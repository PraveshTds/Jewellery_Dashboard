<?php
// update-category-status.php

// Assuming you have a database connection established
include '../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cat_id']) && isset($_GET['action'])) {
    $catId = $_GET['cat_id'];
    $action = $_GET['action'];

    // Validate $action to prevent SQL injection
    if ($action !== 'enable' && $action !== 'disable') {
        exit('Invalid action');
    }

    // Update the database based on the action
    $newStatus = $action === 'enable' ? 1 : 0;

    $statement = $pdo->prepare("UPDATE tbl_category SET active = :newStatus WHERE cat_id = :catId");
    $statement->bindParam(':newStatus', $newStatus, PDO::PARAM_INT);
    $statement->bindParam(':catId', $catId, PDO::PARAM_INT);

    if ($statement->execute()) {
        // Return the new status (1 for active, 0 for inactive)
        echo $newStatus;
    } else {
        echo 'Error updating category status';
    }
} else {
    echo 'Invalid request';
}
?>
