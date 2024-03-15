<?php
require_once('header.php');
require_once('server.php');
?>

<?php
if (isset($_POST['form1'])) {
	$valid = 1;

	$existing_cat = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
	$existing_cat->execute(array($_POST['category_name']));
	$total = $existing_cat->fetchAll();
	$cat_name = $total[0]['category_name'];

	if (empty($_POST['gender_id'])) {
		$valid = 0;
		$error_message .= "You must have to select Gender<br>";
	}

	if (empty($_POST['ctype_id'])) {
		$valid = 0;
		$error_message .= "You must have to select category type<br>";
	}

	if ($_POST['category_name']) {
		if (empty($_POST['category_name'])) {
			$valid = 0;
			$error_message .= "Category name can not be empty<br>";
		} else {
			if (!preg_match("/^[a-zA-Z]+(_[a-zA-Z]+)*$/", $cat_name)) {
				$valid = 0;
				$error_message .= "Category name should only contain alphabets and underscores, and no spaces are allowed<br>";
			} else {
				// Check if the category already exists
				$existing_cat = $pdo->prepare("SELECT * FROM tbl_cust_category WHERE customer = ? AND cat_name=?");
				$existing_cat->execute(array($_POST['customer'], $cat_name));
				$total = $existing_cat->rowCount();
				if ($total) {
					$error_message .= "Category for this customer already exists, cannot create a new category<br>";
					$valid = 0;
				}
			}
		}
	}

	if ($valid == 1) {
		$statement = $pdo->prepare("INSERT INTO tbl_cust_category (cat_name,ctype_id,sequence,active_product_count,customer,cat_status) VALUES (?,?,?,?,?,0)");
		$statement->execute(array($cat_name, $_POST['ctype_id'], $_POST['sequence'], $_POST['active_product_count'], $_POST['customer']));

		$json_data = getting_files($ftpConnection, $pdo);
		$categories = json_decode($json_data, true);

		// Construct new category data
		$new_category = array(
			"category" => $cat_name,
			"label" => $cat_name, // Assuming label is same as category name
			"type" => $_POST['ctype_id'], // Assuming ctype_id corresponds to type
			"sequence" => $_POST['sequence'],
			"sets_info" => array(),
			"active_product_count" => $_POST['active_product_count']
		);

		// Append new category to existing categories array
		$categories['data'][] = $new_category;

		// Convert array back to JSON
		$updated_json = json_encode($categories, JSON_PRETTY_PRINT);

		$remote_json_file = '/domains/textronic.info/public_html/api_jewellery/api/Brand/pravesh/cat_data.json';

		// Write updated JSON to a temporary local file
		$temp_file = tempnam(sys_get_temp_dir(), 'updated_json_');
		if ($temp_file === false) {
			$error_message .= 'Unable to create temporary file.';
		} else {
			if (file_put_contents($temp_file, $updated_json)) {
				$upload_result = ftp_put($ftpConnection, $remote_json_file, $temp_file, FTP_BINARY);
				if ($upload_result === false) {
					$error_message .= 'Unable to upload JSON data to the server.';
				} else {
					$success_message .= ' JSON data updated successfully.';
				}
				unlink($temp_file);
			} else {
				$error_message .= 'Unable to write JSON data to temporary file.';
			}
		}

		ftp_close($ftpConnection);

		$success_message = 'Category is added successfully.';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Category</h1>
	</div>
	<div class="content-header-right">
		<a href="cust-category.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if ($error_message) : ?>
				<div class="callout callout-danger">

					<p>
						<?php echo $error_message; ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ($success_message) : ?>
				<div class="callout callout-success">

					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Customer<span>*</span></label>
							<div class="col-sm-4">
								<select name="customer" class="form-control">
									<option value="">Customer</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE role = 'customer'");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Gender<span>*</span></label>
							<div class="col-sm-4">
								<select name="gender_id" class="form-control select2 gender">
									<option value="">Gender</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_gender ORDER BY gender_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['gender_id']; ?>"><?php echo $row['gender_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Type<span>*</span></label>
							<div class="col-sm-4">
								<select name="ctype_id" class="form-control select2 cat-type">
									<option value="">Select Type</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Category<span>*</span></label>
							<div class="col-sm-4">
								<select name="category_name" class="form-control category_name">
									<option value="">Category</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">sequence<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="sequence">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">active_product_count<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="active_product_count">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-3 text-right ">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
							<div class="col-sm-5 text-right ">
								<a href="cust-category.php" class="btn btn-danger pull-left" name="cancel">Cancel</a>
							</div>
						</div>

					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>