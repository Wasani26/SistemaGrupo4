
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="/sistemaGrupo4/Public/assets/img/LOGO.png" rel="icon">
    <link href="/sistemaGrupo4/Public/assets/img/LOGO.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="/sistemaGrupo4/Public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sistemaGrupo4/Public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/sistemaGrupo4/Public/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/sistemaGrupo4/Public/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/sistemaGrupo4/Public/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/sistemaGrupo4/Public/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/sistemaGrupo4/Public/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="/sistemaGrupo4/Public/assets/css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

  <main>
    <div class="container">

      <main>
        <div class="container">
            <section>
                <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                        <img src="/sistemaGrupo4/Public/assets/img/LOGO.png" alt=""> <span class="d-none d-lg-block">BookMuse</span>
                    </a>
                </div>
                </section>
        </div>
    </main> <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Crear una cuenta</h5>
                    <p class="text-center small">Introduce tus datos personales para crear una cuenta</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate id="form_register">
                    <div class="col-12">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input type="text" name="nombre" class="form-control" id="nombre" required>
                      <div class="invalid-feedback">Por favor, introduzca su nombre!</div>
                    </div>

                        <div class="col-12">
                      <label for="dni" class="form-label">DNI</label>
                      <input type="text" name="dni" class="form-control" id="dni" required pattern="^\d{8}$" title="El DNI debe contener exactamente 8 dígitos numéricos">
                      <div class="invalid-feedback">Por favor, introduzca un DNI válido (8 dígitos numéricos)!</div>
                    </div>

                        <div class="col-12">
                      <label for="correo" class="form-label">Correo electrónico</label>
                      <input type="email" name="correo" class="form-control" id="correo" required>
                      <div class="invalid-feedback">Por favor, introduzca una dirección de correo electrónico válida!</div>
                    </div>

                        <div class="col-12">
                      <label for="telefono" class="form-label">Teléfono</label>
                      <input type="text" name="telefono" class="form-control" id="telefono" required>
                      <div class="invalid-feedback">Por favor, introduzca un número de teléfono válido!</div>
                    </div>

                        <div class="col-12">
                      <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                      <input type="date" name="fecha_nacimiento" class="form-control" id="fecha_nacimiento" required>
                      <div class="invalid-feedback">Por favor, introduzca su fecha de nacimiento!</div>
                    </div>

                        <div class="col-12">
                      <label for="nacionalidad" class="form-label">Nacionalidad</label>
                      <input type="text" name="nacionalidad" class="form-control" id="nacionalidad" required>
                      <div class="invalid-feedback">Por favor, introduzca su nacionalidad!</div>
                    </div>

                    <div class="col-12">
                      <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="nombre_usuario" class="form-control" id="nombre_usuario" required>
                        <div class="invalid-feedback">Por favor elige un nombre de usuario.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="contrasena" class="form-label">Contraseña</label>
                      <input type="password" name="contrasena" class="form-control" id="contrasena" required>
                      <div class="invalid-feedback">Por favor ingrese su contraseña!</div>
                    </div>

                        <div class="col-12">
                      <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                      <input type="password" name="confirmar_contrasena" class="form-control" id="confirmar_contrasena" required>
                      <div class="invalid-feedback">Por favor confirme su contraseña!</div>
                    </div>

                        <div class="col-12">
                            <label for="url_foto" class="form-label">Foto de Perfil (Opcional)</label>
                            <input type="file" name="url_foto" class="form-control" id="url_foto" accept="image/png, image/jpeg, image/gif">
                            <div class="invalid-feedback">Por favor, suba una imagen (PNG, JPG, GIF).</div>
                        </div>


                    <div class="col-12">
                      <div class="form-check">

 <script src="/sistemaGrupo4/Public/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/sistemaGrupo4/Public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/sistemaGrupo4/Public/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="/sistemaGrupo4/Public/assets/vendor/echarts/echarts.min.js"></script>
    <script src="/sistemaGrupo4/Public/assets/vendor/quill/quill.min.js"></script>
    <script src="/sistemaGrupo4/Public/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/sistemaGrupo4/Public/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/sistemaGrupo4/Public/assets/vendor/php-email-form/validate.js"></script>

    <script src="/sistemaGrupo4/Public/assets/js/main.js"></script>
    <script src="/sistemaGrupo4/Public/assets/js/registro.js"></script>

</body>
</html>