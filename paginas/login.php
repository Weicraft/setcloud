<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';

$db = conectarDB();
$plan = '3';

//Cerrar sesión
session_start();
$_SESSION = [];

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $user = mysqli_real_escape_string($db, $_POST['user']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$user) {
        $errores[] = 'El usuario es obligatorio';
    }
    if (!$password) {
        $errores[] = 'El password es obligatorio o no es válido';
    }

    if (empty($errores)) {

        $queryUser = "SELECT * FROM user WHERE usuario='$user' AND estado = 'A'";
        $resultUser = mysqli_query($db, $queryUser);

        if ($resultUser->num_rows) {

            //Obtener los datos del usuario
            $usuario = mysqli_fetch_assoc($resultUser);
            //verificación del password
            $auth = password_verify($password, $usuario['pass']);

            if ($auth) {
                //El usuario está autenticado
                session_start();

                //llenar el arreglo de la sesión
                $_SESSION['login'] = true;
                $_SESSION['user'] = $usuario['id_user'];
                $_SESSION['plan'] = $plan;

                header('Location: panelprincipal');
            } else {
                $errores[] = 'El Password no es correcto';
            }
        } else {
            $errores[] = 'El Usuario No Existe';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producción Audiovisual</title>
    <link rel="icon" href="paginas/build/img/favicon_NiBel.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <?php include __DIR__ . '/templates/cssindex.php'; ?>
</head>

<body>
    <header>
        </div>
        <div class="contenedor fecha">
            <p><?php mostrarFecha() ?></p>
        </div>
        <div class="header">
            <img src="paginas/build/img/banner_login.png" alt="Imagen Banner">
        </div>
    </header>

    <main>
        <div class="principal">
            <div class="contenedor formulario">
                <?php foreach ($errores as $error): ?>
                    <div class="alerta error">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach; ?>
                <form method="POST">
                    <fieldset>
                        <legend>Ingresar al Panel Principal</legend>
                        <div class="flex-simple-center">
                            <div>
                                <div class="form-field">
                                    <div class="label">
                                        <label for="">Usuario:</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" class="field" id="user" name="user">
                                    </div>
                                </div>
                                <div class="form-field">
                                    <div class="label">
                                        <label for="">Contraseña:</label>
                                    </div>
                                    <div class="input">
                                        <input type="password" class="field" id="password" name="password">
                                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                                            🔓
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-contenedor">
                            <input class="boton" type="submit" value="Ingresar">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>
    <?php
    include __DIR__ . '/templates/footer.php';
    ?>
</body>

<script src="paginas/build/js/bundle.min.js"></script>
<script src="jquery.js"></script>
<script src="scriptsjquery.js"></script>

</html>