<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_database"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipeId = $_POST['recipe_id'];
    $recipeName = $_POST['recipe_name'];
    $recipeIngredients = $_POST['recipe_ingredients'];
    $recipeProcedure = $_POST['recipe_procedure'];
    $existingImagePath = $_POST['existing_image_path'];

    $target_dir = "tbl_upload/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Check if an image file is uploaded
    if ($_FILES["recipe_image"]["size"] != 0) {
        $target_file = $target_dir . basename($_FILES["recipe_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["recipe_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $target_file = $target_dir . time() . '_' . basename($_FILES["recipe_image"]["name"]);
        }

        // Check file size
        if ($_FILES["recipe_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Upload file if all checks pass
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["recipe_image"]["tmp_name"], $target_file)) {
                // Image uploaded successfully
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            $target_file = $existingImagePath; // Use the existing image path if upload fails
        }
    } else {
        $target_file = $existingImagePath; // Use the existing image path if no new file is uploaded
    }

    if (empty($recipeId)) {
        $sql = "INSERT INTO tbl_recipe (recipe_name, recipe_image_path, recipe_ingredients, recipe_procedure)
                VALUES ('$recipeName', '$target_file', '$recipeIngredients', '$recipeProcedure')";
    } else {
        $sql = "UPDATE tbl_recipe SET recipe_name='$recipeName', recipe_image_path='$target_file', recipe_ingredients='$recipeIngredients', recipe_procedure='$recipeProcedure' WHERE recipe_id='$recipeId'";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

if (isset($_GET['delete'])) {
    $recipeId = $_GET['delete'];
    $sql = "DELETE FROM tbl_recipe WHERE recipe_id='$recipeId'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

$conn->close();
?>
