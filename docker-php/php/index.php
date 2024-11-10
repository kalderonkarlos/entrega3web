<?php
require_once "config.php";
session_start();

if (isset($_SESSION["username"])) {
    header("location:home.php");
    exit;
}

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];

    if ($password === $repeat_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if (mysqli_query($connection, $query)) {
            echo '<script>
                    alert("Registro exitoso. Ahora puedes iniciar sesión.");
                    window.location.href = "index.php";
                  </script>';
            exit;
        } else {
            echo '<script>alert("Error al registrar el usuario.");</script>';
        }
    } else {
        echo '<script>alert("Las contraseñas no coinciden.");</script>';
    }
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user["password"])) {
            $_SESSION["username"] = $username;
            header("location:home.php");
            exit;
        } else {
            echo '<script>alert("Credenciales incorrectas");</script>';
        }
    } else {
        echo '<script>alert("Credenciales incorrectas");</script>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Introduction to PHP</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="container align-middle">
    <?php if (isset($_GET["action"]) && $_GET["action"] == "register"): ?>
        <form method="post">
            <h3 class="text-center">Register</h3>
            <div class="form-outline mb-4">
                <input type="text" id="username" name="username" class="form-control" required />
                <label class="form-label" for="username">Username</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control" required />
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="repeat_password" name="repeat_password" class="form-control" required />
                <label class="form-label" for="repeat_password">Repeat Password</label>
            </div>
            <input type="submit" class="btn btn-primary btn-block mb-4" value="Register" name="register" />
            <div class="text-center">
                <p>Already a member? <a href="index.php?action=login">Login</a></p>
            </div>
        </form>
    <?php else: ?>
        <form method="post">
            <h3 class="text-center">Login</h3>
            <div class="form-outline mb-4">
                <input type="text" id="username" name="username" class="form-control" required />
                <label class="form-label" for="username">Username</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="password" name="password" class="form-control" required />
                <label class="form-label" for="password">Password</label>
            </div>
            <input type="submit" class="btn btn-primary btn-block mb-4" value="Login" name="login" />
            <div class="text-center">
                <p>Not a member? <a href="index.php?action=register">Register</a></p>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
