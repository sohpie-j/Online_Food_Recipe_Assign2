<?php
include 'conn/conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="css/flist_style.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header" id="link_header">
        <ul class="nav">
            <li><a href="home.php">Home</a></li>
            <li><a href="foodlist.php">Food List</a></li>
            <li><a href="login/login.php">Login/Sign Up</a></li>
        </ul>
    </div>

    <div class="container">
        <h1 class="mt-4">Recipe List</h1>
        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-primary" onclick="addRecipe()">Add Recipe</button>
            <form class="form-inline" method="GET" action="foodlist.php">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="col-food-number">Number</th>
                    <th class="col-food-picture">Food Picture</th>
                    <th class="col-food-name">Food Name</th>
                    <th class="col-food-ingredient">Food Ingredient</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

                $sql = "SELECT * FROM tbl_recipe WHERE recipe_name LIKE :search OR recipe_ingredients LIKE :search";
                $stmt = $conn->prepare($sql);
                $searchParam = "%$searchQuery%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $counter = 1;

                if (count($results) > 0) {
                    foreach ($results as $row) {
                        echo "<tr id='recipeRow-" . $row['recipe_id'] . "'>";
                        echo "<td class='counter_text'>" . $counter++ . "</td>";
                        echo "<td class='image_align'><img class='recipe-image' src='" . htmlspecialchars($row['recipe_image_path']) . "' alt='Food Image' width='100'></td>";
                        echo "<td class='recipe-name'>" . htmlspecialchars($row['recipe_name']) . "</td>";
                        echo "<td class='recipe-ingredients'>" . htmlspecialchars($row['recipe_ingredients']) . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-info' onclick='viewRecipe(" . htmlspecialchars(json_encode($row)) . ")'>View</button> ";
                        echo "<button class='btn btn-warning' onclick='editRecipe(" . htmlspecialchars(json_encode($row)) . ")'>Edit</button> ";
                        echo "<button class='btn btn-danger' onclick='deleteRecipe(" . htmlspecialchars($row['recipe_id']) . ")'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No recipes found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'assets/fl_modal.php'; ?>
    <script src="assets/fl_script.js"></script>
</body>
</html>
