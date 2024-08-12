<?php
session_start();

require "connection.php";

if(isset($_POST['btn_add'])){
    $name = $_POST['name'];
    createSection($name);
}
if(isset($_POST['btn_delete'])){
    $section_id = $_POST['btn_delete'];
    deleteSection($section_id);
}
function createSection($name){
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    $sql = "INSERT INTO sections (`name`) VALUE ('$name')";

    /* EXECUTION */
    if($conn->query($sql)){
        // Success
        header("refresh: 0 ");
        // refresh the current page after 0 seconds
    } else {
        // Fail
        die("Error adding new product section: ".$conn->error);
        // error is a generic error string holder
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

function deleteSection($section_id){
    $conn = connection();
    $sql = "DELETE FROM sections WHERE id = $section_id";

    if($conn->query($sql)){
        header("refresh: 0 ");
    } else {
        die('Error deleting the product sectionL '.$conn->error);
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sections</title>
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
                <h2 class="fw-light mb-3">Sections</h2>

                <!-- Form -->
                 <div class="mb-3">
                    <form action="" method="post">
                        <div class="row gx-2">
                            <div class="col">
                                <input type="text" name="name" id="name" placeholder="Add a new section here..." max="50" class="form-control" required autofocus>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="btn_add" class="btn btn-info w-100 fw-bold"><i class="fa-solid fa-plus"></i>Add</button>
                            </div>
                        </div>
                    </form>
                 </div>

                 <!-- Table -->
                <table class="table table-sm align-middle text-center">
                    <thead class="table-info">
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $all_sections = getAllSections();
                            while($section = $all_sections->fetch_assoc()){
                                // fetch_assoc() ---> transform the result into an associative array
                                // $section is an array
                                // print_r($section);
                            ?>
                            <tr>
                                <td><?= $section['id']?></td>
                                <td><?= $section['name']?></td>
                                <td>
                                    <form action="" method="post">
                                        <button type="submit" name="btn_delete" value="<?= $section['id'] ?>" title="Delete" class="btn btn-outline-danger border-0">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>