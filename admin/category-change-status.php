<?php require_once('header.php');
require_once('category_functions.php');
?>

<?php
if (!isset($_POST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$catid = $_POST['id'];
	$statement = $pdo->prepare("SELECT * FROM tbl_cust_category WHERE cat_id=?");
	$statement->execute(array($catid));
	$total = $statement->rowCount();
	if ($total == 0) {
		exit;
	} else {
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$active_product_count = $row['active_product_count'];
		}
	}

	$categoryName = $result[0]['cat_name'];

	$customer = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
	$customer->execute(array($result[0]['customer']));
	$total_cust = $customer->fetchAll();
	$customer = strtolower($total_cust[0]['full_name']);
}
?>

<?php
if ($active_product_count == 0) {
	$final = 1;
} else {
	$final = 0;
}
$statement = $pdo->prepare("UPDATE tbl_cust_category SET active_product_count=? WHERE cat_id=?");
$statement->execute(array($final, $catid));

updateCategoryActiveProductCount($pdo, $ftpConnection, $categoryName, $final, $customer);

header('location: cust-category.php');
?>