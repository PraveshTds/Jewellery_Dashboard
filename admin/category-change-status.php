<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		exit;
	} else {
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$cat_status = $row['cat_status'];
		}
	}
}
?>

<?php
if($cat_status == 0) {$final = 1;} else {$final = 0;}
$statement = $pdo->prepare("UPDATE tbl_category SET cat_status=? WHERE cat_id=?");
$statement->execute(array($final,$_REQUEST['id']));

header('location: category.php');
?>