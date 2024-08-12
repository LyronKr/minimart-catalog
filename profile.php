<?php
session_start();

require "connection.php";

$user = getUser();

function getUser(){
    $conn   = connection();

    $id     = $_SESSION['id'];
    $sql    = "SELECT * FROM users WHERE id = $id";

    if($result = $conn->query($sql)){
        return $result->fetch_assoc();
    } else {
        die("Error retrieving your data: " . $conn->error);
    }
}

function updatePhoto($id, $photo_name, $photo_tmp){
    $conn = connection();
    $sql = "UPDATE users SET photo = '$photo_name' WHERE id = $id";

    if($conn->query($sql)){
        $destination = "assets/images/$photo_name";
        move_uploaded_file($photo_tmp, $destination);
        header("refresh: 0");
    } else {
        die("Error uploading photo: " . $conn->error);
    }
}

if(isset($_POST['btn_upload_photo'])){
    $id = $_SESSION['id'];
    $photo_name = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];

    updatePhoto($id, $photo_name, $photo_tmp);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    </head>
  <body>
    <?php
    include 'main-nav.php';
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">

                <?php
                if($user['photo']){
                ?>
                    <img src="./assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto img-thumbnail profile-photo">
                <?php
                } else {
                ?>
                    <i class="fa-regular fa-user d-block text-center profile-icon"></i>
                <?php
                }
                ?>

                <div class="mt-2 mb-3 text-center">
                    <p class="h4 mb-0"><?= $user['username'] ?></p>
                    <p><?= $user['first_name'] . " " . $user['last_name'] ?></p>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-2">
                        <input type="file" name="photo" id="photo" class="form-control">
                        <button type="submit" class="btn btn-outline-secondary" name="btn_upload_photo">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>