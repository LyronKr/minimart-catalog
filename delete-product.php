<?php
session_start();

require "connection.php";

$id = $_GET['id'];
$product = getProduct($id);

function getProduct($id){
    $conn = connection();
    $sql = "SELECT * FROM products WHERE id = $id";

    if($result = $conn->query($sql)){
        return $result->fetch_assoc();
        // return an associative array
        // Since we are epxecting 1 row only.
    } else {
        die('Error retrieving the product: ' . $conn->error);
    }
}
function deleteProduct($id){
    $conn = connection();
    $sql = "DELETE FROM products WHERE id = $id";

    if($conn->query($sql)){
        header("location: products.php");
        exit;
    } else {
        die("Error deleting the product: " . $conn->error);
    }
}

if(isset($_POST['btn_delete'])){
    $id = $_GET['id'];
    deleteProduct($id);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Product</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
  <body>
    <?php
    include 'main-nav.php';
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">

                <div class="text-center mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-warning display-4"></i>
                    <h2 class="fw-light mb-3 text-danger">Delete Product</h2>
                    <p class="fw-bold mb-0">Are you sure you want to delete "<?= $product['name'] ?>"?</p>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="products.php" class="btn btn-secondary w-100">Cancel</a>
                    </div>
                    <div class="col">
                        <form method="post">
                            <button type="submit" class="btn btn-outline-secondary w-100" name="btn_delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>