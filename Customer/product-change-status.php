<?php require_once('header.php'); ?>

<?php
if(!isset($_POST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_POST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$p_status = $row['p_status'];
		}
	}
}
?>

<?php
if($p_status == 0) {$final = 1;} else {$final = 0;}
$statement = $pdo->prepare("UPDATE tbl_product SET p_status=? WHERE p_id=?");
$statement->execute(array($final,$_REQUEST['id']));

header('location: product.php');
?>