<?php require_once('header.php');
require_once('category_functions.php');
 ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_cust_category WHERE cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll();
	$cat_name = $result[0]['cat_name'];
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
$cust_id = $result[0]['customer'];

    $customer = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
    $customer->execute(array($cust_id));
    $total_cust = $customer->fetchAll();
    $customer = strtolower($total_cust[0]['full_name']);
?>

<?php
	

	// Getting all ecat ids
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$p_ids[] = $row['p_id'];
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
	deleteCategory($pdo, $ftpConnection, $cat_name, $customer);
	$statement = $pdo->prepare("DELETE FROM tbl_cust_category WHERE cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	header('location: cust-category.php');
?>