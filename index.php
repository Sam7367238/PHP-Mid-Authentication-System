<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <?php
        session_start();

        if (isset($_SESSION["User_ID"])) {
            echo '<a href="Profile.php" class="btn btn-primary me-2">Profile</a>';
            echo '<a href="Authentication/Logout.php" class="btn btn-danger">Log Out</a>';
        } else {
            echo '<a href="Authentication/Register.php" class="btn btn-success me-2">Sign Up</a>';
            echo '<a href="Authentication/Login.php" class="btn btn-primary">Sign In</a>';
        }
        ?>
        <br><br>
        <h1 class="display-4">Welcome to this website!</h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>