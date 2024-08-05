document.getElementById('recipeForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting the traditional way

    var formData = new FormData(this);
    console.log([...formData]); // Log form data to ensure it is being collected correctly

    fetch('update_recipe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            refreshTable(); // Refresh the table to reflect changes
            closeModal('addEditRecipeModal');
        } else {
            console.error('Error:', data.error);
            alert(data.error); // Display the error to the user
        }
    })
    .catch(error => console.error('Fetch error:', error));
});

function deleteRecipe(recipeId) {
    if (confirm('Are you sure you want to delete this recipe?')) {
        fetch(`update_recipe.php?delete=${recipeId}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                refreshTable(); // Refresh the table to reflect changes
            } else {
                console.error('Error:', data.error);
                alert(data.error); // Display the error to the user
            }
        })
        .catch(error => console.error('Fetch error:', error));
    }
}


function refreshTable() {
    fetch('foodlist.php')
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newTableBody = doc.querySelector('tbody').innerHTML;
        document.querySelector('tbody').innerHTML = newTableBody;
    })
    .catch(error => console.error('Error refreshing table:', error));
}

function clearForm() {
    document.getElementById('recipeForm').reset();
    document.getElementById('recipeId').value = '';
    document.getElementById('existingImagePath').value = '';
    document.getElementById('currentRecipeImage').style.display = 'none';
}

function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function viewRecipe(recipe) {
    document.getElementById('viewRecipeName').value = recipe.recipe_name;
    document.getElementById('viewRecipeImage').src = recipe.recipe_image_path;
    document.getElementById('viewRecipeIngredients').value = recipe.recipe_ingredients;
    document.getElementById('viewRecipeProcedure').value = recipe.recipe_procedure;
    openModal('viewRecipeModal');
}

function addRecipe() {
    clearForm();
    document.getElementById('modalTitle').innerText = 'Add Recipe';
    openModal('addEditRecipeModal');
}

function editRecipe(recipe) {
    clearForm();
    document.getElementById('recipeId').value = recipe.recipe_id;
    document.getElementById('recipeName').value = recipe.recipe_name;
    document.getElementById('recipeIngredients').value = recipe.recipe_ingredients;
    document.getElementById('recipeProcedure').value = recipe.recipe_procedure;
    document.getElementById('existingImagePath').value = recipe.recipe_image_path;
    if (recipe.recipe_image_path) {
        document.getElementById('currentRecipeImage').src = recipe.recipe_image_path;
        document.getElementById('currentRecipeImage').style.display = 'block';
    }

    document.getElementById('modalTitle').innerText = 'Edit Recipe';
    openModal('addEditRecipeModal');
}

function toggleFavorite(recipeId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "favorite.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            location.reload();
        }
    };
    xhr.send("recipe_id=" + recipeId);
}

// Close modals when clicking outside of them
window.onclick = function(event) {
    var addEditModal = document.getElementById('addEditRecipeModal');
    var viewModal = document.getElementById('viewRecipeModal');
    if (event.target == addEditModal) {
        closeModal('addEditRecipeModal');
    }
    if (event.target == viewModal) {
        closeModal('viewRecipeModal');
    }
}
