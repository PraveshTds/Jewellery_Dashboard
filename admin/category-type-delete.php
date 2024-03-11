<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_category_type WHERE ctype_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Getting all ecat ids
	$statement = $pdo->prepare("SELECT * FROM tbl_cust_category WHERE ctype_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$cat_ids[] = $row['cat_id'];
	}

	if(isset($cat_ids)) {

		for($i=0;$i<count($cat_ids);$i++) {
			$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE cat_id=?");
			$statement->execute(array($cat_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$p_ids[] = $row['p_id'];
			}
		}

		for($i=0;$i<count($p_ids);$i++) {

			// Getting photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$p_featured_photo = $row['p_featured_photo'];
				unlink('../assets/uploads/'.$p_featured_photo);
			}

			// Getting other photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$photo = $row['photo'];
				unlink('../assets/uploads/product_photos/'.$photo);
			}

			// Delete from tbl_photo
			$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_photo
			$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_size
			// $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
			// $statement->execute(array($p_ids[$i]));

		}

		// Delete from tbl_cust_category
		for($i=0;$i<count($cat_ids);$i++) {
			$statement = $pdo->prepare("DELETE FROM tbl_cust_category WHERE cat_id=?");
			$statement->execute(array($cat_ids[$i]));
		}

	}

	// Delete from tbl_category_type
	$statement = $pdo->prepare("DELETE FROM tbl_category_type WHERE ctype_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: cust-category.php');
?>