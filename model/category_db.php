<?php
class CategoryDB {

    public static function getNumProducts($category_id){
        $db = Database::getDB();
        $query = 'SELECT count(*) as num_products FROM products p 
                  join categories c on p.categoryID = c.categoryID
                  where c.categoryID = :categoryID';
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':categoryID', $category_id);
            $statement->execute();
            $answer = $statement->fetch();
            $statement->closeCursor();
            return $answer['num_products'];
        } catch (PDOException $e){
            Database::displayError($e->getMessage());
        }

    }
    public static function getCategories() {
        $db = Database::getDB();
        $query = 'SELECT categoryID, categoryName 
                  FROM categories
                  ORDER BY categoryID';
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
            
            $categories = [];
            foreach ($rows as $row) {
                $categories[] = new Category($row['categoryID'],
                                             $row['categoryName']);
            }
            return $categories;
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }

    public static function getCategory($category_id) {
        $db = Database::getDB();
        $query = 'SELECT categoryID, categoryName 
                  FROM categories
                  WHERE categoryID = :category_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            
            return new Category($row['categoryID'],
                                $row['categoryName']);
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }
    public static function addCategory($category_name) {
        $db = Database::getDB();
        $query = 'INSERT INTO categories(categoryName)VALUES (:categoryName)';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':categoryName', $category_name);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            
            return $db->lastInsertId();
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
    }
    public static function deleteCategory($category_id) {
        $db = Database::getDB();

        $query = 'DELETE FROM categories
                  WHERE categoryID = :category_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            
            include('category_list.php');
        } catch (PDOException $e) {
            Database::displayError($e->getMessage());
        }
        
    }

}
