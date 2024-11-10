<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["username"])) {
    header("location:index.php");
    exit;
}

$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="container">
    <h1 class="text-center my-4">Welcome to my app, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <a href="logout.php" class="btn btn-danger mb-4">Logout</a>

    <div class="row">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col-md-4 my-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row["username"]) . '</h5>
                        <h6 class="card-subtitle mb-2 text-muted">ID: ' . htmlspecialchars($row["id"]) . '</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>
</body>
</html>