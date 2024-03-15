<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if (empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= "Customer name cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= "Email address cannot be empty" . "<br>";
    } 
    // else {
    //     if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
    //         $valid = 0;
    //         $error_message .= "Email doesnt Match" . "<br>";
    //     } else {
    //         $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=?");
    //         $statement->execute(array($_POST['cust_email']));
    //         $total = $statement->rowCount();
    //         if ($total) {
    //             $valid = 0;
    //             $error_message .= "This email is already registered. Please use another one." . "<br>";
    //         }
    //     }
    // }

    if (empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= "Phone number cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= "Address cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= "Country cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= "City cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= "State cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= "Zip code cannot be empty" . "<br>";
    }

    if (empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $error_message .= "Both password fields are required" . "<br>";
    }

    if (!empty($_POST['cust_password']) && !empty($_POST['cust_re_password'])) {
        if ($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= "Password do not match . Please re-enter your password." . "<br>";
        }
    }

    if($valid == 1) {    	
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_customer SET cust_name=?,cust_cname=?,cust_email=?,cust_phone=?,cust_country=?,cust_address=?,cust_city=?,cust_state=?,cust_zip=?,cust_password=? WHERE cust_id=?");
		$statement->execute(array(
            strip_tags($_POST['cust_name']),
            strip_tags($_POST['cust_cname']),
            strip_tags($_POST['cust_email']),
            strip_tags($_POST['cust_phone']),
            strip_tags($_POST['cust_country']),
            strip_tags($_POST['cust_address']),
            strip_tags($_POST['cust_city']),
            strip_tags($_POST['cust_state']),
            strip_tags($_POST['cust_zip']),
            md5($_POST['cust_password']),
            $_REQUEST['id']
        ));

    	$success_message = 'Customer data is updated successfully.';
    }
}
?>

<?php
		if (!isset($_REQUEST['id'])) {
			header('location: logout.php');
			exit;
		} else {
			// Check the id is valid or not
			$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
			$statement->execute(array($_REQUEST['id']));
			$total = $statement->rowCount();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if ($total == 0) {
				header('location: logout.php');
				exit;
			}
		}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Customer</h1>
	</div>
	<div class="content-header-right">
		<a href="customer.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$cust_name = $row['cust_name'];
	$cust_cname = $row['cust_cname'];
    $cust_email = $row['cust_email'];
    $cust_phone = $row['cust_phone'];
    $cust_country = $row['cust_country'];
    $cust_address = $row['cust_address'];
    $cust_state = $row['cust_state'];
    $cust_city = $row['cust_city'];
    $cust_zip = $row['cust_zip'];
    $cust_phone = $row['cust_phone'];
}

$statement = $pdo->prepare("SELECT * 
                        FROM tbl_country
                        WHERE country_id=?");
		$statement->execute(array($cust_country));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$country_name = $row['country_name'];
		}
?>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <form class="" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="user-content">
                            <form action="" method="post">
                                <?php $csrf->echoInputField(); ?>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">

                                        <?php
                                        if ($error_message != '') {
                                            echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $error_message . "</div>";
                                        }
                                        if ($success_message != '') {
                                            echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $success_message . "</div>";
                                        }
                                        ?>

                                        <div class="col-md-6 form-group">
                                            <label for="">Customer Name *</label>
                                            <input type="text" class="form-control" name="cust_name" value="<?php echo $cust_name; ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Company Name *</label>
                                            <input type="text" class="form-control" name="cust_cname" value="<?php echo $cust_cname; ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Email *</label>
                                            <input type="email" class="form-control" name="cust_email" value="<?php echo $cust_email; ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Phone *</label>
                                            <input type="number" minlength="10" maxlength="12" class="form-control" name="cust_phone" value="<?php echo $cust_phone; ?>">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="">Address *</label>
                                            <textarea name="cust_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $cust_address; ?></textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Country *</label>
                                            <select name="cust_country" class="form-control select2">
                                                <option value="">Select country</option>
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                ?>
                                                    <option value="<?php echo $row['country_id']; ?>" <?php if($row['country_id'] == $cust_country){echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="">City *</label>
                                            <input type="text" class="form-control" name="cust_city" value="<?php echo $cust_city; ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">State *</label>
                                            <input type="text" class="form-control" name="cust_state" value="<?php echo $cust_state; ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Zipcode *</label>
                                            <input type="number" class="form-control" name="cust_zip" value="<?php echo $cust_zip; ?>">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="">Password *</label>
                                            <input type="password" class="form-control" name="cust_password">
                                        </div>
                                        <div class="col-md-6 form-group">

                                            <label for="">Confirm Password *</label>
                                            <input type="password" class="form-control" name="cust_re_password">
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for=""></label>
                                                <input type="submit" class="btn btn-success" value="Update" name="form1">
                                            </div>
                                            <div class="col-sm-5 text-right ">
                                                <a href="customer.php" class="btn btn-danger pull-right" name="cancel">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </form>


        </div>
    </div>

</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>