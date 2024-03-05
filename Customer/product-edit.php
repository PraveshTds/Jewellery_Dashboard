<?php require_once('header.php'); ?>

 <?php
		if (isset($_POST['form1'])) {
			$valid = 1;

			if (empty($_POST['cat_id'])) {
				$valid = 0;
				$error_message .= "You must have to select an end level category<br>";
			}

			if (empty($_POST['p_name'])) {
				$valid = 0;
				$error_message .= "Product name can not be empty<br>";
			}

			if (empty($_POST['sku'])) {
				$valid = 0;
				$error_message .= "Current Price can not be empty<br>";
			}

			if (empty($_POST['Quantity'])) {
				$valid = 0;
				$error_message .= "Quantity can not be empty<br>";
			}

			if (empty($_POST['product_code'])) {
				$valid = 0;
				$error_message .= "Quantity can not be empty<br>";
			}

			$path = $_FILES['p_featured_photo']['name'];
			$path_tmp = $_FILES['p_featured_photo']['tmp_name'];

			if ($path != '') {
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$file_name = basename($path, '.' . $ext);
				if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
					$valid = 0;
					$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
				}
			}


			if ($valid == 1) {

				if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {

					$photo = array();
					$photo = $_FILES['photo']["name"];
					$photo = array_values(array_filter($photo));

					$photo_temp = array();
					$photo_temp = $_FILES['photo']["tmp_name"];
					$photo_temp = array_values(array_filter($photo_temp));

					$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
					$statement->execute();
					$result = $statement->fetchAll();
					foreach ($result as $row) {
						$next_id1 = $row[10];
					}
					$z = $next_id1;

					$m = 0;
					for ($i = 0; $i < count($photo); $i++) {
						$my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);
						if ($my_ext1 == 'jpg' || $my_ext1 == 'png' || $my_ext1 == 'jpeg' || $my_ext1 == 'gif') {
							$final_name1[$m] = $z . '.' . $my_ext1;
							move_uploaded_file($photo_temp[$i], "../assets/uploads/product_photos/" . $final_name1[$m]);
							$m++;
							$z++;
						}
					}

					if (isset($final_name1)) {
						for ($i = 0; $i < count($final_name1); $i++) {
							$statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
							$statement->execute(array($final_name1[$i], $_REQUEST['id']));
						}
					}
				}

				if ($path == '') {
					$statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?,
										collection=?,
										site_link=?,
										sku=?,
										p_featured_photo=?,
										p_code=?,
										gender_id=?,
										price=?,
										quantity=?,
										details=?,
										cat_id=?,
										cust_id=?

        							WHERE p_id=?");
					$statement->execute(array(
						$_POST['p_name'],
						$_POST['collection'],
						$_POST['site_link'],
						$_POST['sku'],
						$final_name,
						$_POST['product_code'],
						$_POST['gender'],
						$_POST['price'],
						$_POST['Quantity'],
						$_POST['details'],
						$_POST['cat_id'],
						$_SESSION['user']['id'],
						$_REQUEST['id']
					));
				} else {

					unlink('../assets/uploads/' . $_POST['current_photo']);

					$final_name = 'product-featured-' . $_REQUEST['id'] . '.' . $ext;
					move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);


					$statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?,
										collection=?,
										site_link=?,
										sku=?,
										p_featured_photo=?,
										p_code=?,
										gender_id=?,
										price=?,
										quantity=?,
										details=?,
										cat_id=?,
										cust_id=?

        							WHERE p_id=?");
					$statement->execute(array(
						$_POST['p_name'],
						$_POST['collection'],
						$_POST['site_link'],
						$_POST['sku'],
						$final_name,
						$_POST['product_code'],
						$_POST['gender'],
						$_POST['price'],
						$_POST['Quantity'],
						$_POST['details'],
						$_POST['cat_id'],
						$_SESSION['user']['id'],
						$_REQUEST['id']
					));
				}


				// if(isset($_POST['size'])) {

				// 	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
				// 	$statement->execute(array($_REQUEST['id']));

				// 	foreach($_POST['size'] as $value) {
				// 		$statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
				// 		$statement->execute(array($value,$_REQUEST['id']));
				// 	}
				// } else {
				// 	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
				// 	$statement->execute(array($_REQUEST['id']));
				// }

				$success_message = 'Product is updated successfully.';
			}
		}
		?> 

<?php
		if (!isset($_REQUEST['id'])) {
			header('location: logout.php');
			exit;
		} else {
			// Check the id is valid or not
			$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
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
		<h1>Edit Product</h1>
	</div>
	<div class="content-header-right">
		<a href="product.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

 <?php
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$p_name = $row['p_name'];
			$price = $row['price'];
			$collection = $row['collection'];
			$site_link = $row['site_link'];
			$p_featured_photo = $row['p_featured_photo'];
			$sku = $row['sku'];
			$p_code = $row['p_code'];
			$quantity = $row['quantity'];
			$details = $row['details'];
			$cat_id = $row['cat_id'];
		}

		$statement = $pdo->prepare("SELECT * 
                        FROM tbl_category t1
                        JOIN tbl_category_type t2
                        ON t1.ctype_id = t2.ctype_id
                        JOIN tbl_gender t3
                        ON t2.gender_id = t3.gender_id
                        WHERE t1.cat_id=?");
		$statement->execute(array($cat_id));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$cat_name = $row['cat_name'];
			$ctype_id = $row['ctype_id'];
			$gender_id = $row['gender_id'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$size_id[] = $row['size_id'];
		}

		?> 


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

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Category Name <span style="color:red">*</span></label>
							<div class="col-sm-4">
								<select name="cat_id" class="form-control category">
									<option value="">Select Category Name</option>
									<?php
									$cust_id = $_SESSION['user']['id'];
									$statement = $pdo->prepare("SELECT * FROM tbl_category where customer=? AND cat_status=1 ORDER BY cat_name ASC");
									$statement->execute(array($cust_id));
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['cat_id']; ?>" <?php if($row['cat_id'] == $cat_id){echo 'selected';} ?>><?php echo $row['cat_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Product Name <span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Collection</label>
							<div class="col-sm-4">
								<input type="text" name="collection" class="form-control" value="<?php echo $collection; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Site Link</label>
							<div class="col-sm-4">
								<input type="text" name="site_link" class="form-control" value="<?php echo $site_link; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">SKU no<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="sku" class="form-control" value="<?php echo $sku; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Product code<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="product_code" class="form-control" value="<?php echo $p_code; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Gender<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<select name="gender" class="form-control select2 cat-type">
									<option>Select Gender</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_gender ORDER BY gender_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['gender_id']; ?>" <?php if($row['gender_id'] == $gender_id){echo 'selected';} ?>><?php echo $row['gender_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Price</label>
							<div class="col-sm-4">
								<input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Quantity<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="Quantity" class="form-control" value="<?php echo $quantity; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Existing Photo</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<img src="../assets/uploads/<?php echo $p_featured_photo; ?>" alt="" style="width:150px;">
								<input type="hidden" name="current_photo" value="<?php echo $p_featured_photo; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Image<span style="color:red">*</span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<input type="file" name="p_featured_photo">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Thumb_image</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<table id="ProductTable" style="width:100%;">
									<tbody>
										<tr>
											<td>
												<div class="upload-btn">
													<input type="file" name="photo[]" style="margin-bottom:5px;">
												</div>
											</td>
											<td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-2">
								<input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Details</label>
							<div class="col-sm-8">
								<textarea name="details" class="form-control" cols="10" rows="5"><?php echo $details; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-3 text-right ">
								<button type="submit" class="btn btn-success pull-left" name="form1">Save</button>
							</div>
							<div class="col-sm-5 text-right ">
								<button type="submit" class="btn btn-danger pull-right" name="form1">Cancel</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>