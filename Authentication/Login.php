<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

                    <div class="card rounded-0 mt-5">
                        <div class="card-header bg-white">
                            <h1 class="text-center">Login Form</h1>
                        </div>

                        <?php
                        require_once "../Database.php";
                        $config = require("../Configuration.php");

                        if (isset($_POST["submit"])) {
                            // Declare Params
                            $email = $_POST["email"];
                            $password = $_POST["password"];

                            // Validate Inputs

                            $errors = array();

                            if (empty($email) || empty($password)) {
                                array_push($errors, "All fields are required.");
                            }

                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                array_push($errors, "Enter a valid email.");
                            }

                            if (strlen($password) < 8) {
                                array_push($errors, "Password must be at least 8 characters.");
                            }

                            if (count($errors) > 0) {
                                // Output error message

                                foreach ($errors as $error) {
                                    echo '<div class="alert alert-danger">' . $error . '</div>';
                                }
                            } else {
                                $db = new Database($config["Database"], "", "");
                                $row = $db -> query("SELECT * FROM Users WHERE Email = ?", [$email]) -> fetch();

                                if ($row && password_verify($password, $row["Password"])) {
                                    $_SESSION["User_ID"] = $row["ID"];
                                    $_SESSION["Username"] = $row["Full_Name"];

                                    header("Location: ../index.php");
                                    exit;
                                } else {
                                    echo '<div class="alert alert-danger">Invalid Credentials</div>';
                                }
                            }
                        }
                        ?>

                        <div class="card-body">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?= isset($_POST["email"]) ? $_POST["email"] : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                            <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Login">
                            <a href="Register.php" class="btn btn-secondary" role="button">Register Instead</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>