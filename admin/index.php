<?php require_once('header.php');
?>

<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
// $statement = $pdo->prepare("SELECT * FROM tbl_gender");
// $statement->execute();
// $total_top_category = $statement->rowCount();

// $statement = $pdo->prepare("SELECT * FROM tbl_category_type");
// $statement->execute();
// $total_mid_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT category_name, COUNT(*) as category_count FROM tbl_category GROUP BY category_name");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
$category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_status='1'");
$statement->execute();
$total_customers = $statement->rowCount();

// $statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_active='1'");
// $statement->execute();
// $total_subscriber = $statement->rowCount();

// $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost");
// $statement->execute();
// $available_shipping = $statement->rowCount();

// $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
// $statement->execute(array('Completed'));
// $total_order_completed = $statement->rowCount();

// $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE shipping_status=?");
// $statement->execute(array('Completed'));
// $total_shipping_completed = $statement->rowCount();

// $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
// $statement->execute(array('Pending'));
// $total_order_pending = $statement->rowCount();

// $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=? AND shipping_status=?");
// $statement->execute(array('Completed','Pending'));
// $total_order_complete_shipping_pending = $statement->rowCount();
?>

<section class="content">
	<div class="row">
		<a href="product.php">
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
		</a>
		<a href="customer.php">
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3><?php echo $total_customers; ?></h3>
						<p><a href="customer.php"></a>Active Customers</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-person-stalker"></i>
					</div>
				</div>
			</div>
		</a>
		<a href="cust-category.php">
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $category; ?></h3>
						<p>Categories</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-arrow-down-b"></i>
					</div>
				</div>
			</div>
		</a>
	</div>

</section>

<?php require_once('footer.php'); ?>