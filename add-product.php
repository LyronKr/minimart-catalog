<?php
session_start();

require "connection.php";

function getAllSections(){
    $conn = connection();
    $sql = "SELECT * FROM sections";

    if($result = $conn->query($sql)){
        return $result;
    } else {
        die("Error retrieving all sections: ". $conn->error);
    }
}

function createProduct($name, $description, $price, $section_id){
    $conn = connection();
    $sql = "INSERT INTO `products` (`name`, `description`, `price`, `section_id`) VALUES ('$name', '$description', '$price', '$section_id')";

    if($conn->query($sql)){
        header("location: products.php");
        // Go to products.php if the query is successful
        exit;
        // same as die()
    } else {
        die('Error adding a new product: ' . $conn->error);
    }
}


if(isset($_POST['btn_add'])){
    $name          = $_POST['name'];
    $description   = $_POST['description'];
    $price         = $_POST['price'];
    $section_id    = $_POST['section_id'];

    createProduct($name, $description, $price, $section_id);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Products</title>
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
                <h2 class="fw-light mb-3">New Product</h2>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-bold">Name</label>
                        <input type="text" name="name" id="name" max="50" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold">Description</label>
                        <input type="text" name="description" id="description" rows="5" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="any" required>
                    </div>

                    <div class="mb-4">
                        <label for="section-id" class="form-label small fw-bold">Section</label>
                        <select name="section_id" id="section-id" class="form-select" required>
                            <option value="" hidden>Select Section</option>
                        </select>
                    </div>

                    <a href="products.php" class="btn btn-outline-success">Cancel</a>
                    <button type="submit" name="btn_add" class="btn btn-success fw-bold px-5">
                        <i class="fa-solid fa-plus"></i>Add
                    </button>

                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
