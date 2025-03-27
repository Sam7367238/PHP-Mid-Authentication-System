<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Best Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

                    <div class="card rounded-0 mt-5">
                        <div class="card-header bg-white">
                            <h1 class="text-center">Registration Form</h1>
                        </div>

                        <?php
                        require_once "../Database.php";
                        $config = require("../Configuration.php");

                        if (isset($_POST["submit"])) {
                            $db = new Database($config["Database"], "", "");

                            // Declare Params
                            $fullname = $_POST["fullname"];
                            $email = $_POST["email"];
                            $password = $_POST["password"];
                            $repeatPassword = $_POST["repeatpassword"];

                            // Hashed Password

                            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

                            // Validate Inputs

                            $errors = array();

                            if (empty($fullname) || empty($email) || empty($password) || empty($repeatPassword)) {
                                array_push($errors, "All fields are required.");
                            }

                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                array_push($errors, "Enter a valid email.");
                            }

                            if (strlen($password) < 8) {
                                array_push($errors, "Password must be at least 8 characters.");
                            }

                            if ($password !== $repeatPassword) {
                                array_push($errors, "Passwords do not match.");
                            }

                            $rows = $db -> query("SELECT * FROM Users WHERE Email = ?", [$email]) -> fetchAll(PDO::FETCH_ASSOC);

                            if (count($rows) > 0) {
                                array_push($errors, "An account with the same Email has already been registered.");
                            }

                            if (count($errors) > 0) {
                                // Output error message

                                foreach ($errors as $error) {
                                    echo '<div class="alert alert-danger">' . $error . '</div>';
                                }
                            } else {
                                
                                $db -> query("INSERT INTO Users (Full_Name, Email, Password) VALUES (?, ?, ?);", [$fullname, $email, $passwordHashed]);
                                $row = $db -> query("SELECT * FROM Users WHERE Email = ?", [$email]) -> fetch();
                                
                                $_SESSION["User_ID"] = $row["ID"];
                                $_SESSION["Username"] = $row["Full_Name"];

                                header("Location: ../index.php");
                            }
                        }
                        ?>

                        <div class="card-body">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" placeholder="Enter Full Name" value="<?= isset($_POST["fullname"]) ? $_POST["fullname"] : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?= isset($_POST["email"]) ? $_POST["email"] : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="mb-3">
                                <label for="repeatpassword" class="form-label">Repeat Password</label>
                                <input type="password" name="repeatpassword" class="form-control" placeholder="Enter Repeat Password">
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                            <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Register">
                            <a href="Login.php" class="btn btn-secondary" role="button">Login Instead</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>