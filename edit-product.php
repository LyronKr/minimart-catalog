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
function getAllSections(){
    $conn = connection();
    $sql = "SELECT * FROM sections";

    if($result = $conn->query($sql)){
        return $result;
    } else {
        die("Error retrieving all sections: ". $conn->error);
    }
}
function updateProduct($id, $name, $description, $price, $section_id){
    $conn = connection();
    $sql = "UPDATE products SET `name` = '$name', `description` = '$description', `price` = '$price', `section_id` = '$section_id' WHERE id = $id";

    if($conn->query($sql)){
        header("location: products.php");
    } else {
        die("Error updating the product: ". $conn->error);
    }
}

if(isset($_POST['btn_update'])){
    $id = $_GET['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $section_id = $_POST['section_id'];

    updateProduct($id, $name, $description, $price, $section_id);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product</title>
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
                <h2 class="fw-light mb3">Edit Product</h2>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" id="name" class="form-label small fw-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $product['name']?>" max="50" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="description" id="description" class="form-label small fw-bold">Description</label>
                        <textarea name="description" id="description" rows="5" class="form-control" required><?= $product['description'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Price</label>
                        <div class="input-group">
                            <div class="input-group-text">$</div>
                            <input type="number" name="price" id="" class="form-control" value="<?= $product['price'] ?>" step="any" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="section-id" class="form-label small fw-bold">Section</label>
                        <select name="section_id" id="section-id" class="form-select" required>
                            <option value="">Select Section</option>
                            <?php
                                $all_sections = getAllSections();
                                while($section = $all_sections->fetch_assoc()){
                                    if($section['id'] == $product['section_id']){
                                        echo "<option value='".$section['id']."' selected>".$section['name']."</option>";
                                    } else {
                                        echo "<option value='".$section['id']."'>".$section['name']."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" name="btn_update" class="btn btn-secondary fw-bold">
                        <i class="fa-solid fa-check"></i> Save changes
                    </button>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>