<!-- Modal for Add/Edit Recipe -->
<div id="addEditRecipeModal" class="modal">
    <div class="modal-content" style="max-width: 800px; width: 100%;">
        <span class="close" onclick="closeModal('addEditRecipeModal')">&times;</span>
        <h2 id="modalTitle">Add/Edit Recipe</h2>
        <form id="recipeForm" method="POST" action="update_recipe.php" enctype="multipart/form-data">
            <input type="hidden" id="recipeId" name="recipe_id">
            <input type="hidden" id="existingImagePath" name="existing_image_path">
            <div class="form-group">
                <label for="recipeName">Recipe Name</label>
                <input type="text" class="form-control" id="recipeName" name="recipe_name" required>
            </div>
            <div class="form-group" style="display: flex; align-items: flex-start;">
                <div style="flex: 0 0 150px;">
                    <label for="recipeImage">Recipe Image</label>
                    <input type="file" class="form-control" id="recipeImage" name="recipe_image">
                    <img id="currentRecipeImage" src="" alt="Current Recipe Image" style="display: none; margin-top: 10px; width: 100px; height: auto;">
                </div>
                <div style="flex: 1; margin-left: 20px;">
                    <label for="recipeIngredients">Ingredients</label>
                    <textarea class="form-control" id="recipeIngredients" name="recipe_ingredients" rows="10" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="recipeProcedure">Procedure</label>
                <textarea class="form-control" id="recipeProcedure" name="recipe_procedure" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<!-- Modal for View Recipe -->
<div id="viewRecipeModal" class="modal">
    <div class="modal-content" style="max-width: 800px; width: 100%;">
        <span class="close" onclick="closeModal('viewRecipeModal')">&times;</span>
        <h2>View Recipe</h2>
        <div class="form-group">
            <label for="viewRecipeName">Recipe Name</label>
            <input type="text" class="form-control" id="viewRecipeName" readonly>
        </div>
        <div class="form-group" style="display: flex; align-items: flex-start;">
            <div style="flex: 0 0 150px;">
                <label for="viewRecipeImage">Recipe Image</label>
                <img id="viewRecipeImage" src="" alt="Food Image" class="img-fluid" style="width: 100%; height: auto; margin:auto;">
            </div>
            <div style="flex: 1; margin-left: 20px;">
                <label for="viewRecipeIngredients">Ingredients</label>
                <textarea class="form-control" id="viewRecipeIngredients" rows="10" readonly></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="viewRecipeProcedure">Procedure</label>
            <textarea class="form-control" id="viewRecipeProcedure" rows="10" readonly></textarea>
        </div>
    </div>
</div>
