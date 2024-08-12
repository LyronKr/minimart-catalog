<?php
require "connection.php";

function login($username, $password){
    $conn = connection();
    $sql = "SELECT * FROM users WHERE username = '$username'";

    if($result = $conn->query($sql)){
        # Check if the username exists
        if($result->num_rows == 1){
            $user = $result->fetch_assoc();

            # Check if the password is correct
            if(password_verify($password, $user['password'])){
                /***** SESSION ******/
                session_start();

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];

                header("location: products.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Incorrect password.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Username not found.</div>";
        }
    } else {
        die("Error retrieving the user: " . $conn->error);
    }
}

if(isset($_POST['btn_log_in'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    login($username, $password);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit This</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="bg-light">
    <div style="height: 100vh;">
        <div class="row h-100 m-0">
            <div class="card w-25 mx-auto my-auto p-0">
                <div class="card-header text-primary">
                    <h1 class="card-title text-center mb-0">Minimart Catalog</h1>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="usernamme" class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" id="username" class="form-control" autofocus required>
                        </div>
                        
                        <div class="mb-5">
                            <label for="usernamme" class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100" name="btn_log_in">Login</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="sign-up.php">Create Account.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>