<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';

if (isset($_POST['form1'])) {

	if (empty($_POST['email']) || empty($_POST['password'])) {
		$error_message = 'Email and/or Password can not be empty<br>';
	} else {

		$email = strip_tags($_POST['email']);
		$password = strip_tags($_POST['password']);

		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND status=?");
		$statement->execute(array($email, 'Active'));
		$total = $statement->rowCount();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if ($total == 0) {
			$error_message .= 'Email Address does not match<br>';
		} else {
			foreach ($result as $row) {
				$row_password = $row['password'];
				$role = $row['role'];
			}

			if ($row_password != md5($password)) {
				$error_message .= 'Password does not match<br>';
			} else {
				if ($role == 'customer' || $role == "Customer") {
					$_SESSION['user'] = $row;
					header('Location: customer/index.php');
				} else {
					$_SESSION['user'] = $row;
					header("location: admin/index.php");
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/J_style.css">
</head>

<body class="hold-transition login-page sidebar-mini">
<div class="container-fulid outer_box">
	<div class="row">
		<div class="col-md-12 col-lg-12 cover_box">
<div class="login-box">
	<div class="login-logo">
		<!-- <b> Login </b> -->
		<img src="img/client.png"/>
	</div>
  	<div class="login-box-body">
    	<p class="login-box-msg">Welcome to jewellery warehouse</p>
    
	    <?php 
	    if( (isset($error_message)) && ($error_message!='') ):
	        echo '<div class="error">'.$error_message.'</div>';
	    endif;
	    ?>

		<form action="" method="post">
			<?php $csrf->echoInputField(); ?>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Email address" name="email" type="email" autocomplete="off" autofocus>
			</div>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="">
			</div>
			<div class="row">
				<div class="col-xs-8"></div>
				<div class="col-xs-4">
					<input type="submit" class="btn btn-success btn-block btn-flat login-button" name="form1" value="Log In">
				</div>
			</div>
		</form>
	</div>
	</div>
	</div>
</div>
<div>


<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.inputmask.date.extensions.js"></script>
<script src="js/jquery.inputmask.extensions.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/icheck.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>

</body>

</html>