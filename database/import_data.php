<?php
require 'connection.php';

function importData($pdo, $filePath, $tableName) {
    $data = json_decode(file_get_contents($filePath), true);

    if (!$data) {
        die("Failed to parse JSON from $filePath\n");
    }

    foreach ($data as $record) {
        $columns = implode(", ", array_keys($record));
        $placeholders = implode(", ", array_fill(0, count($record), '?'));

        $query = $pdo->prepare("INSERT INTO $tableName ($columns) VALUES ($placeholders)");
        try {
            $query->execute(array_values($record));
        } catch (PDOException $e) {
            echo "Error inserting record: " . $e->getMessage() . "\n";
        }
    }
    echo "Data imported into $tableName successfully.\n";
}

try {
    importData($pdo, __DIR__ . '/../data/categories.json', 'categories');
    importData($pdo, __DIR__ . '/../data/course_list.json', 'courses');
} catch (Exception $e) {
    die("Data import failed: " . $e->getMessage());
}
