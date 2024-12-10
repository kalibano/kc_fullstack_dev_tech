<?php
class Category {
    public static function getAll($db) {
        $stmt = $db->query("SELECT 
            c.id AS id,
            c.name AS name,
            c.parent AS parent,
            COUNT(co.course_id) AS course_count
            FROM 
                categories c
            LEFT JOIN 
                courses co ON c.id = co.category_id
            GROUP BY 
                c.id, c.name, c.parent
            ORDER BY 
                c.parent, c.name;
        ");
        
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categoryList = [];
        
        // Create a structure where categories with parent id are nested
        foreach ($categories as $category) {
            if ($category['parent'] === null) {
                // If no parent, this is a root category
                $categoryList[$category['id']] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'course_count' => $category['course_count'],
                    'subcategories' => []
                ];
            } else {
                // This is a subcategory
                if (isset($categoryList[$category['parent']])) {
                    $categoryList[$category['parent']]['subcategories'][] = [
                        'id' => $category['id'],
                        'name' => $category['name'],
                        'course_count' => $category['course_count']
                    ];
                }
            }
        }
    
        // Now calculate the course count for parent categories based on their subcategories
        foreach ($categoryList as $parentId => &$parentCategory) {
            $totalCourseCount = $parentCategory['course_count']; // Start with the parent category's own count
            foreach ($parentCategory['subcategories'] as $subcategory) {
                $totalCourseCount += $subcategory['course_count']; // Add the subcategory's course count
            }
            $parentCategory['course_count'] = $totalCourseCount; // Update the parent's course count
        }
    
        return $categoryList;
    }

    public static function getById($db, $id) {
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
