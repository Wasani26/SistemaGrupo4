<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>BookMuse Registro</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/BookMuse.png" rel="icon">
  <link href="assets/img/BookMuse.png" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="d-flex justify-content-center">
                    <a href="auth.php" class="logo d-flex align-items-center w-auto">
                      <img src="assets/img/BookMuse.png" alt="">
                      <span class="d-none d-lg-block">BookMuse</span>
                    </a>
                  </div><form class="row g-3 needs-validation" novalidate id="form_register">
                    <div class="mt-3 pb-4">
                      <h5 class="card-title text-center pb-0 fs-4">Crear una cuenta</h5>
                      <p class="text-center small">Introduce tus datos personales para crear una cuenta</p>
                    </div>

                    <div class="col-12">
                      <label for="nombre" class="form-label label-izquierda">Nombre</label>
                      <input type="text" name="nombre" class="form-control input-ajustado" id="nombre" required>
                      <div class="invalid-feedback">Por favor, introduzca su nombre!</div>
                    </div>

                    <div class="col-12">
                      <label for="dni" class="form-label label-izquierda">DNI</label>
                      <input type="text" name="dni" class="form-control input-ajustado" id="dni" required pattern="^\d{8}$" title="El DNI debe contener exactamente 8 dígitos numéricos">
                      <div class="invalid-feedback">Por favor, introduzca un DNI válido!</div>
                    </div>

                    <div class="col-12">
                      <label for="correo" class="form-label label-izquierda">Correo electrónico</label>
                      <input type="email" name="correo" class="form-control input-ajustado" id="correo" required>
                      <div class="invalid-feedback">Por favor, introduzca una dirección de correo válida!</div>
                    </div>

                    <div class="col-12">
                      <label for="telefono" class="form-label label-izquierda">Teléfono</label>
                      <input type="text" name="telefono" class="form-control input-ajustado" id="telefono" required>
                      <div class="invalid-feedback">Por favor, introduzca un teléfono válido!</div>
                    </div>

                    <div class="col-12">
                      <label for="fecha_nacimiento" class="form-label label-izquierda">Fecha de Nacimiento</label>
                      <input type="text" name="fecha_nacimiento" class="form-control input-ajustado" id="fecha_nacimiento" required>
                      <div class="invalid-feedback">Por favor, introduzca su fecha de nacimiento!</div>
                    </div>

                    <div class="col-12">
                      <label for="nacionalidad" class="form-label label-izquierda">Nacionalidad</label>
                      <input type="text" name="nacionalidad" class="form-control input-ajustado" id="nacionalidad" required>
                      <div class="invalid-feedback">Por favor, introduzca su nacionalidad!</div>
                    </div>

                    <div class="col-12">
                      <label for="nombre_usuario" class="form-label label-izquierda">Nombre de Usuario</label>
                      <div class="input-group has-validation input-ajustado">
                        <input type="text" name="nombre_usuario" class="form-control" id="nombre_usuario" required>
                        <div class="invalid-feedback">Por favor elige un nombre de usuario.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="contrasena" class="form-label label-izquierda">Contraseña</label>
                      <input type="password" name="contrasena" class="form-control input-ajustado" id="contrasena" required>
                      <div class="invalid-feedback">Por favor ingrese su contraseña!</div>
                    </div>

                    <div class="col-12">
                      <label for="confirmar_contrasena" class="form-label label-izquierda">Confirmar Contraseña</label>
                      <input type="password" name="confirmar_contrasena" class="form-control input-ajustado" id="confirmar_contrasena" required>
                      <div class="invalid-feedback">Por favor confirme su contraseña!</div>
                    </div>

                    <div class="col-12">
                      <label for="url_foto" class="form-label label-izquierda">Foto de Perfil (Opcional)</label>
                      <input type="file" name="url_foto" class="form-control input-ajustado" id="url_foto" accept="image/png, image/jpeg, image/gif">
                      <div class="invalid-feedback">Por favor, suba una imagen (PNG, JPG, GIF).</div>
                    </div>
                    
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="acceptTerms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">Acepto los <a href="#">términos y condiciones</a></label>
                        <div class="invalid-feedback">Debes aceptar los términos y condiciones para continuar.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Crear una Cuenta</button>
                    </div>

                    <div class="col-12">
                      <p class="small mb-0">¿Ya tienes una cuenta? <a href="auth.php">Ingresa</a></p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="js/registro.js"></script>

  
 
</body>
</html>