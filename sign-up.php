<?php
require "connection.php";

function createUser($first_name, $last_name, $username, $password){
    $conn = connection();

    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (`first_name`, `last_name`, `username`, `password`) VALUES ('$first_name', '$last_name', '$username', '$password')";

    if($conn->query($sql)){
        header("location: login.php");
        exit;
    } else {
        die("Error signing up: " . $conn->error);
    }
}

if(isset($_POST['btn_sign_up'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if Password and Confrim Passworod are the same.
    if($password == $confirm_password){
        // Call the function that will insert data into the database.
        createUser($first_name, $last_name, $username, $password);
    } else {
        echo "<p class='alert alert-danger'>Password and Confirm Passwird do not match</p>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
  <body class="bg-light">
    <div style="height: 100vh;">
        <div class="row h-100 m-0">
            <div class="card w-25 mx-auto my-auto p-0">
                <div class="card-header text-success">
                    <h1 class="card-title h3 mb-0">Create your account</h1>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="first-name" class="form-label small-fw-bold">First Name</label>
                            <input type="text" name="first_name" id="first-name" class="form-control" maxlength="50" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="last-name" class="form-label small fw-bold">Last Name</label>
                            <input type="text" name="last_name" id="last-name" class="form-control" maxlength="50" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" id="username" class="form-control fw-bold" maxlength="15" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control mb-2" required>
                        </div>

                        <div class="mb-5">
                            <label for="confirm-password" class="form-label small fw-bold">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm-password" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100" name="btn_sign_up">Sign Up</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="small">Already have an account? <a href="login.php">Log in.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>