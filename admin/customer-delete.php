<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$data = $statement->fetchAll();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Delete from tbl_customer
	$statement = $pdo->prepare("DELETE FROM tbl_customer WHERE cust_id=?");
	$statement->execute(array($_REQUEST['id']));


	// Delete from tbl_user
	$statement = $pdo->prepare("DELETE FROM tbl_user WHERE email=?");
	$statement->execute(array($data[0]['cust_email']));

	header('location: customer.php');
?>