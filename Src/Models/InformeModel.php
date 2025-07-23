<?php
// --- Configuración de CORS ---
// Permite peticiones desde cualquier origen (para desarrollo).
// En producción, deberías restringir esto a tus dominios específicos.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Manejar peticiones OPTIONS (preflight requests) para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// --- Simulación de Base de Datos en Memoria ---
// En una aplicación real, estos datos vendrían de una base de datos (SQL o NoSQL)

// Datos simulados de usuarios (para autenticación y roles)
$users_db = [
    "admin_user" => ["password" => "admin_password", "role" => "admin"],
    "guide_user" => ["password" => "guide_password", "role" => "guide"],
    "regular_user" => ["password" => "user_password", "role" => "user"],
];

// Datos simulados de tours disponibles
$tours_db = [
    ["id" => 1, "name" => "Arte Precolombino", "price" => 25.00, "duration_minutes" => 90],
    ["id" => 2, "name" => "Maestros del Renacimiento", "price" => 30.00, "duration_minutes" => 120],
    ["id" => 3, "name" => "Exposición de Arte Moderno", "price" => 20.00, "duration_minutes" => 60],
    ["id" => 4, "name" => "Historia del Museo", "price" => 15.00, "duration_minutes" => 45],
];

// Datos simulados de boletos vendidos (registros de ventas)
// Cada boleto tiene un tour_id asociado y una fecha de compra
$bookings_db = [
    ["id" => 1, "tour_id" => 1, "user_id" => "regular_user", "purchase_date" => "2025-07-10", "quantity" => 1],
    ["id" => 2, "tour_id" => 2, "user_id" => "regular_user", "purchase_date" => "2025-07-10", "quantity" => 2],
    ["id" => 3, "tour_id" => 1, "user_id" => "regular_user", "purchase_date" => "2025-07-11", "quantity" => 1],
    ["id" => 4, "tour_id" => 3, "user_id" => "regular_user", "purchase_date" => "2025-07-11", "quantity" => 3],
    ["id" => 5, "tour_id" => 2, "user_id" => "regular_user", "purchase_date" => "2025-07-12", "quantity" => 1],
    ["id" => 6, "tour_id" => 1, "user_id" => "regular_user", "purchase_date" => "2025-07-12", "quantity" => 2],
    ["id" => 7, "tour_id" => 4, "user_id" => "regular_user", "purchase_date" => "2025-07-13", "quantity" => 1],
    ["id" => 8, "tour_id" => 3, "user_id" => "regular_user", "purchase_date" => "2025-07-13", "quantity" => 2],
    ["id" => 9, "tour_id" => 1, "user_id" => "regular_user", "purchase_date" => "2025-07-14", "quantity" => 1],
    ["id" => 10, "tour_id" => 2, "user_id" => "regular_user", "purchase_date" => "2025-07-14", "quantity" => 1],
    ["id" => 11, "tour_id" => 1, "user_id" => "regular_user", "purchase_date" => "2025-07-15", "quantity" => 3],
    ["id" => 12, "tour_id" => 4, "user_id" => "regular_user", "purchase_date" => "2025-07-15", "quantity" => 1],
    ["id" => 13, "tour_id" => 1, "user_id" => "regular_user", "purchase_date" => "2025-07-16", "quantity" => 1],
    ["id" => 14, "tour_id" => 2, "user_id" => "regular_user", "purchase_date" => "2025-07-16", "quantity" => 2],
    ["id" => 15, "tour_id" => 3, "user_id" => "regular_user", "purchase_date" => "2025-07-17", "quantity" => 1],
];

// --- Funciones de Autenticación y Autorización (Básica) ---
function authenticate_admin($users_db) {
    // Obtener todos los encabezados de la petición
    $headers = getallheaders();
    $auth_header = $headers['Authorization'] ?? '';

    if (empty($auth_header)) {
        return [null, ["message" => "Authorization header missing"], 401]; // No autorizado
    }

    // Esperamos un formato "Bearer username:password" para esta simulación
    if (strpos($auth_header, 'Bearer ') !== 0) {
        return [null, ["message" => "Unsupported authentication type"], 401];
    }

    $credentials = substr($auth_header, 7); // Eliminar "Bearer "
    $parts = explode(':', $credentials, 2);

    if (count($parts) !== 2) {
        return [null, ["message" => "Invalid Authorization header format"], 401];
    }

    list($username, $password) = $parts;
    $user_data = $users_db[$username] ?? null;

    if ($user_data && $user_data["password"] === $password && $user_data["role"] === "admin") {
        return [$username, null, null]; // Autenticación exitosa
    } else {
        return [null, ["message" => "Invalid credentials or not an admin"], 403]; // Prohibido
    }
}

// --- Endpoints de la API para el Dashboard ---

function get_kpis($users_db, $tours_db, $bookings_db) {
    list($user, $error_response, $status_code) = authenticate_admin($users_db);
    if ($user === null) {
        http_response_code($status_code);
        echo json_encode($error_response);
        exit();
    }

    // Obtener el rango de fechas de los parámetros de la URL
    $start_date_str = $_GET['start_date'] ?? null;
    $end_date_str = $_GET['end_date'] ?? null;

    if ($start_date_str && $end_date_str) {
        try {
            $start_date = DateTime::createFromFormat('Y-m-d', $start_date_str);
            $end_date = DateTime::createFromFormat('Y-m-d', $end_date_str);
            if (!$start_date || !$end_date) {
                throw new Exception("Invalid date format");
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid date format. Use YYYY-MM-DD"]);
            exit();
        }
    } else {
        // Por defecto, el último mes
        $end_date = new DateTime();
        $start_date = (new DateTime())->sub(new DateInterval('P30D')); // Resta 30 días
    }

    $total_revenue = 0.0;
    $total_tickets_sold = 0;
    $active_tours = count($tours_db); // Simplemente contamos los tours disponibles como activos

    // Calcular ingresos y boletos vendidos dentro del rango de fechas
    foreach ($bookings_db as $booking) {
        $booking_date = DateTime::createFromFormat('Y-m-d', $booking["purchase_date"]);
        if ($booking_date && $booking_date >= $start_date && $booking_date <= $end_date) {
            $tour = null;
            foreach ($tours_db as $t) {
                if ($t["id"] === $booking["tour_id"]) {
                    $tour = $t;
                    break;
                }
            }
            if ($tour) {
                $total_revenue += $tour["price"] * $booking["quantity"];
                $total_tickets_sold += $booking["quantity"];
            }
        }
    }

    $kpis = [
        "total_revenue" => round($total_revenue, 2), // Redondear a 2 decimales
        "total_tickets_sold" => $total_tickets_sold,
        "active_tours_count" => $active_tours,
        "start_date" => $start_date->format('Y-m-d'),
        "end_date" => $end_date->format('Y-m-d')
    ];
    http_response_code(200);
    echo json_encode($kpis);
    exit();
}

function get_sales_by_date($users_db, $tours_db, $bookings_db) {
    list($user, $error_response, $status_code) = authenticate_admin($users_db);
    if ($user === null) {
        http_response_code($status_code);
        echo json_encode($error_response);
        exit();
    }

    // Obtener el rango de fechas
    $start_date_str = $_GET['start_date'] ?? null;
    $end_date_str = $_GET['end_date'] ?? null;

    if ($start_date_str && $end_date_str) {
        try {
            $start_date = DateTime::createFromFormat('Y-m-d', $start_date_str);
            $end_date = DateTime::createFromFormat('Y-m-d', $end_date_str);
            if (!$start_date || !$end_date) {
                throw new Exception("Invalid date format");
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid date format. Use YYYY-MM-DD"]);
            exit();
        }
    } else {
        // Por defecto, el último mes
        $end_date = new DateTime();
        $start_date = (new DateTime())->sub(new DateInterval('P30D'));
    }

    $sales_data = [];
    // Inicializar todas las fechas en el rango con 0 ventas
    $current_date = clone $start_date; // Clonar para no modificar el original
    while ($current_date <= $end_date) {
        $sales_data[$current_date->format('Y-m-d')] = 0;
        $current_date->add(new DateInterval('P1D')); // Suma 1 día
    }

    // Sumar las ventas por fecha
    foreach ($bookings_db as $booking) {
        $booking_date = DateTime::createFromFormat('Y-m-d', $booking["purchase_date"]);
        if ($booking_date && $booking_date >= $start_date && $booking_date <= $end_date) {
            $date_str = $booking_date->format('Y-m-d');
            if (isset($sales_data[$date_str])) {
                $sales_data[$date_str] += $booking["quantity"];
            }
        }
    }

    // Convertir el diccionario a una lista de objetos para el frontend
    $result = [];
    ksort($sales_data); // Ordenar por fecha (clave)
    foreach ($sales_data as $date => $tickets) {
        $result[] = ["date" => $date, "tickets_sold" => $tickets];
    }
    http_response_code(200);
    echo json_encode($result);
    exit();
}

function get_popular_tours($users_db, $tours_db, $bookings_db) {
    list($user, $error_response, $status_code) = authenticate_admin($users_db);
    if ($user === null) {
        http_response_code($status_code);
        echo json_encode($error_response);
        exit();
    }

    // Obtener el límite de resultados (por defecto 5)
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;

    $tour_ticket_counts = [];
    foreach ($bookings_db as $booking) {
        $tour_id = $booking["tour_id"];
        $quantity = $booking["quantity"];
        $tour_ticket_counts[$tour_id] = ($tour_ticket_counts[$tour_id] ?? 0) + $quantity;
    }

    // Ordenar los tours por la cantidad de boletos vendidos (descendente)
    arsort($tour_ticket_counts); // Ordena el array por valor en orden descendente

    $result = [];
    $count = 0;
    foreach ($tour_ticket_counts as $tour_id => $tickets_sold) {
        if ($count >= $limit) {
            break;
        }
        $tour = null;
        foreach ($tours_db as $t) {
            if ($t["id"] === $tour_id) {
                $tour = $t;
                break;
            }
        }
        if ($tour) {
            $result[] = [
                "tour_id" => $tour_id,
                "tour_name" => $tour["name"],
                "tickets_sold" => $tickets_sold
            ];
            $count++;
        }
    }
    http_response_code(200);
    echo json_encode($result);
    exit();
}

// --- Endpoint de Autenticación (Simulado) ---
function login($users_db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'] ?? null;
    $password = $data['password'] ?? null;

    $user_data = $users_db[$username] ?? null;

    if ($user_data && $user_data["password"] === $password) {
        // En un sistema real, aquí se generaría un JWT
        http_response_code(200);
        echo json_encode([
            "message" => "Login successful",
            "username" => $username,
            "role" => $user_data["role"],
            "token" => "{$username}:{$password}" // Token simulado para el encabezado Authorization
        ]);
        exit();
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Invalid username or password"]);
        exit();
    }
}

// --- Enrutador Básico ---
// Obtener la URI de la petición y el método
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

// Eliminar el nombre del script si está presente (ej. /api.php/api/dashboard/kpis -> /api/dashboard/kpis)
$script_name = $_SERVER['SCRIPT_NAME'];
if (strpos($request_uri, $script_name) === 0) {
    $request_uri = substr($request_uri, strlen($script_name));
}

// Eliminar cualquier parámetro de consulta para obtener solo la ruta base
$request_uri = strtok($request_uri, '?');

// Definir las rutas y sus funciones correspondientes
switch ($request_uri) {
    case '/api/dashboard/kpis':
        if ($request_method === 'GET') {
            get_kpis($users_db, $tours_db, $bookings_db);
        }
        break;
    case '/api/dashboard/sales-by-date':
        if ($request_method === 'GET') {
            get_sales_by_date($users_db, $tours_db, $bookings_db);
        }
        break;
    case '/api/dashboard/popular-tours':
        if ($request_method === 'GET') {
            get_popular_tours($users_db, $tours_db, $bookings_db);
        }
        break;
    case '/api/auth/login':
        if ($request_method === 'POST') {
            login($users_db);
        }
        break;
}

// Si ninguna ruta coincide, devolver 404 Not Found
http_response_code(404);
echo json_encode(["message" => "Endpoint not found"]);
exit();

?>