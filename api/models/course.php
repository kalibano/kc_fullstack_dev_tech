<?php
class Course {
    public static function getAll($db, $categoryId = null) {
        if ($categoryId) {
            $stmt = $db->prepare("
            SELECT 
                course_id AS course_id, 
                courses.title AS title, 
                courses.description AS description, 
                courses.image_preview AS image_preview, 
                categories.id AS category_id, 
                categories.name AS category_name 
            FROM 
                courses 
            JOIN 
                categories ON courses.category_id = categories.id 
            WHERE 
                courses.category_id = ?
        ");
            $stmt->execute([$categoryId]);
        } else {
            $stmt = $db->query("
            SELECT 
                course_id AS course_id, 
                courses.title AS title, 
                courses.description AS description, 
                courses.image_preview AS image_preview, 
                categories.id AS category_id, 
                categories.name AS category_name 
            FROM 
                courses 
            JOIN 
                categories ON courses.category_id = categories.id
        ");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($db, $id) {
        $stmt = $db->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
