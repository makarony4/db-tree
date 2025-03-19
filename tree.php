<?php

$servername = "db";
$username = "root";
$password = "root";
$db = "test";

$start = microtime(true);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$parentCategoriesQuery = "SELECT categories_id WHERE parent_id = 0";


$query = "SELECT categories_id, parent_id FROM categories";
$stmt = $conn->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

function buildCategoryTree($categories) {
    $tree = [];
    $references = [];

    foreach ($categories as $category) {
        $references[$category['categories_id']] = ['id' => $category['categories_id'], 'children' => []];
    }


    foreach ($categories as $category) {
        if ($category['parent_id'] == 0) {
            $tree[$category['categories_id']] = &$references[$category['categories_id']]['children'];
        } else {
            $references[$category['parent_id']]['children'][$category['categories_id']] = &$references[$category['categories_id']]['children'];
        }
    }


    foreach ($references as &$ref) {
        if (empty($ref['children'])) {
            $ref['children'] = $ref['id'];
        }
    }

    return $tree;
}

$categoryTree = buildCategoryTree($categories);
echo "<pre>";
print_r($categoryTree);
echo "</pre>";

$end = microtime(true);
echo "<br>";
echo "Script finished in " . number_format(($end - $start), 2) . " seconds";