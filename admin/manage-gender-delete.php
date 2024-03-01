<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_gender WHERE gender_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php	
	$statement = $pdo->prepare("SELECT * 
							FROM tbl_gender t1
							JOIN tbl_category_type t2
							ON t1.gender_id = t2.gender_id
							JOIN tbl_category t3
							ON t2.ctype_id = t3.ctype_id
							WHERE t1.gender_id=?");
	$statement->execute(array($_REQUEST['id']));
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

			// Delete from tbl_rating
			$statement = $pdo->prepare("DELETE FROM tbl_rating WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

		}

		// Delete from tbl_category
		for($i=0;$i<count($cat_ids);$i++) {
			$statement = $pdo->prepare("DELETE FROM tbl_category WHERE cat_id=?");
			$statement->execute(array($cat_ids[$i]));
		}

	}

	// Delete from tbl_category_type
	$statement = $pdo->prepare("DELETE FROM tbl_category_type WHERE gender_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_gender
	$statement = $pdo->prepare("DELETE FROM tbl_gender WHERE gender_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: manage-gender.php');
?>