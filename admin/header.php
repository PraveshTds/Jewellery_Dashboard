<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
ob_start();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
include("../inc/config.php");
include("../inc/functions.php");
include("../inc/CSRF_Protect.php");
require_once('server.php');
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if (!isset($_SESSION['user'])) {
	header('location: ../index.php');
	exit;
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/ionicons.min.css">
	<link rel="stylesheet" href="../css/datepicker3.css">
	<link rel="stylesheet" href="../css/all.css">
	<link rel="stylesheet" href="../css/select2.min.css">
	<link rel="stylesheet" href="../css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../css/jquery.fancybox.css">
	<link rel="stylesheet" href="../css/AdminLTE.min.css">
	<link rel="stylesheet" href="../css/_all-skins.min.css">
	<link rel="stylesheet" href="../css/on-off-switch.css" />
	<link rel="stylesheet" href="../css/summernote.css">
	<link rel="stylesheet" href="../style.css">

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">JewellsAR</span>
			</a>

			<nav class="navbar navbar-static-top">

				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin Panel</span>
				<!-- Top Bar ... User Inforamtion .. Login/Log out Area -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); ?>
		<!-- Side Bar to Manage Shop Activities -->
		<aside class="main-sidebar">
			<section class="sidebar">

				<ul class="sidebar-menu">

					<li class="treeview <?php if ($cur_page == 'index.php') {
											echo 'active';
										} ?>">
						<a href="index.php">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'customer.php') || ($cur_page == 'customer-add.php') || ($cur_page == 'customer-edit.php')) {
											echo 'active';
										} ?>">
						<a href="customer.php">
							<i class="fa fa-user-plus"></i> <span>Customer</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'country.php') || ($cur_page == 'country-add.php') || ($cur_page == 'country-edit.php') || ($cur_page == 'manage-gender.php') || ($cur_page == 'manage-gender-add.php') || ($cur_page == 'manage-gender-edit.php') || ($cur_page == 'category-type.php') || ($cur_page == 'category-type-add.php') || ($cur_page == 'category-type-edit.php') || ($cur_page == 'cust-category.php') || ($cur_page == 'cust-category-add.php') || ($cur_page == 'cust-category-edit.php') || ($cur_page == 'category.php')) {
											echo 'active';
										} ?>">
						<a href="#">
							<i class="fa fa-cogs"></i>
							<span>Category Master</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
<<<<<<< HEAD
							<!-- <li><a href="manage-gender.php"><i class="fa fa-circle-o"></i>Gender</a></li> -->
=======
							<li><a href="manage-gender.php"><i class="fa fa-circle-o"></i>Gender</a></li>
>>>>>>> 47de46c2ba56d2c2293d4a12fa1245cdfa13ebd7
							<li><a href="category-type.php"><i class="fa fa-circle-o"></i>Category Type</a></li>
							<li><a href="category.php"><i class="fa fa-circle-o"></i>Category </a></li>
						</ul>
					</li>
					<li class="treeview <?php if (($cur_page == 'product.php') || ($cur_page == 'product-add.php') || ($cur_page == 'product-edit.php')) {
											echo 'active';
										} ?>">
						<a href="cust-category.php">
							<i class="fa fa-shopping-bag"></i> <span>Customer Category</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'product.php') || ($cur_page == 'product-add.php') || ($cur_page == 'product-edit.php')) {
											echo 'active';
										} ?>">
						<a href="product.php">
							<i class="fa fa-shopping-bag"></i> <span>Product</span>
						</a>
					</li>

				</ul>
			</section>
		</aside>

		<div class="content-wrapper">