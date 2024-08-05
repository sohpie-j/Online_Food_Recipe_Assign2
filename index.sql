CREATE TABLE `tbl_recipe` (
    `recipe_id` INT AUTO_INCREMENT PRIMARY KEY,
    `recipe_name` VARCHAR(255) NOT NULL,
    `recipe_image` VARCHAR(255) NOT NULL,
    `recipe_ingredients` TEXT NOT NULL,
    `recipe_procedure` TEXT NOT NULL
);
