<?php
require_once('../../util/main.php');
require_once('../../util/tags.php');
require_once('../../model/database.php');
require_once('../../model/product_db.php');
require_once('../../model/category_db.php');
require_once('../../model/category.php');
require_once('../../model/product.php');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_categories';
    }
}

switch ($action) {
    case 'list_categories':
        $categories = CategoryDB::getCategories();
        include('category_list.php');
        break;

    case 'delete_category':
        $category_id = filter_input(
            INPUT_POST,
            'category_id',
            FILTER_VALIDATE_INT
        );
        $num_products = CategoryDB::getNumProducts($category_id);

        if ($num_products > 0) {
            $error = "This category has products, 
            do not delete this category
             without first deleting all the products. 
             There are {$num_products} products listed
             in this category.";
            Database::displayError($error);
        } else {
            CategoryDB::deleteCategory($category_id);
            // display product list for the current category
            header("Location: .?action=list_categories");
            break;
        }
    case 'add_category':
        $category_name = filter_input(INPUT_POST, 'categoryName');
        if ($category_name == FALSE || $category_name == null) {
            $error = 'Invalid category name.
                      Check all fields and try again.';
            include('../../errors/error.php');
        } else {
            echo $category_name;
            CategoryDB::addCategory($category_name);
            // display added product
            header("Location: .?action=list_categories");
        }
        break;
}
