<?php
session_start();

require "connection.php";

function getAllProducts(){
    $conn = connection();
    $sql = "SELECT products.id AS id,
                products.name AS name,
                products.description AS description,
                products.price AS price,
                sections.name AS section
            FROM products
            INNER JOIN sections
            ON products.section_id = sections.id
            ORDER BY products.id";
    if($result = $conn->query($sql)){
        return $result;
    } else {
        die('Error retrieving all products: ' . $conn->error);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
    include 'main-nav.php';
    ?>
    <main class="container">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-light">Products</h2>
            </div>
            <div class="col text-end">
                <a href="add-product.php" class="btn btn-success"><i class="fa-solid fa-plus-circle"></i> New Product</a>
            </div>
        </div>

        <table class="table table-hover align-middle border">
            <thead class="small table-success">
                <tr>
                    <th>ID</th>
                    <th style="width: 250px">NAME</th>
                    <th>DESCRIPTION</th>
                    <th>PRICE</th>
                    <th>SECTION</th>
                    <th style="width: 105px"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $all_products = getAllProducts();
                while($product = $all_products->fetch_assoc()){
                    // print_r($product);
                ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['description'] ?></td>
                    <td>$<?= $product['price'] ?></td>
                    <td><?= $product['section'] ?></td>
                    <td>
                        <a href="edit-product.php?id=<?= $product['id'] ?>" class="btn small btn-outline-secondary">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="delete-product.php?id=<?= $product['id'] ?>" class="btn small btn-outline-danger">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>