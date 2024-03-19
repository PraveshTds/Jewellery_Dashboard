<?php require_once('header.php'); ?>

<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
$customer = $_SESSION['user']['id'];
$statement = $pdo->prepare("SELECT * FROM tbl_cust_category where customer=? AND active_product_count=1");
$statement->execute(array($customer));
$total_end_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product where cust_id=?");
$statement->execute(array($customer));
$total_product = $statement->rowCount();

?>

<section class="content">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-primary">
				<div class="inner">
					<h3><?php echo $total_product; ?></h3>
					<p>Products</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-android-cart"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-maroon">
				<div class="inner">
					<h3><?php echo $total_end_category; ?></h3>
					<p>Categories</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-arrow-down-b"></i>
				</div>
			</div>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>