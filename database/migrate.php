<?php
require 'connection.php';

function runMigration($pdo, $filePath) {
    $sql = file_get_contents($filePath);
    if (!$sql) {
        die("Failed to read $filePath\n");
    }

    try {
        $pdo->exec($sql);
        echo "Migration from $filePath executed successfully.\n";
    } catch (PDOException $e) {
        die("Error executing migration from $filePath: " . $e->getMessage() . "\n");
    }
}

$migrationFiles = [
    __DIR__ . '/migrations/categories_table.sql',
    __DIR__ . '/migrations/courses_table.sql'
];

foreach ($migrationFiles as $file) {
    runMigration($pdo, $file);
}
