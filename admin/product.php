<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Products</h1>
	</div>
	<!-- <div class="content-header-right">
		<a href="product-add.php" class="btn btn-primary btn-sm">Add Product</a>
	</div> -->
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead class="thead-dark">
							<tr>
								<th width="10">Id</th>
								<th width="50">Customer</th>
								<th>Photo</th>
								<th width="50">Product Name</th>
								<th width="60">Category Name</th>
								<th width="60">SKU</th>
								<th width="60">Quantity</th>
								<th width="60">Price</th>
								<th width="60">Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$statement = $pdo->prepare("SELECT
														
														t1.p_id,
														t1.p_name,
														t1.price,
														t1.sku,
														t1.p_featured_photo,
														t1.quantity,
														t1.cust_id,
														t1.p_status,

														t2.cat_id,
														t2.cat_name,
														t2.customer,

														t3.ctype_id,
														t3.ctype_name,

														t4.gender_id,
														t4.gender_name

							                           	FROM tbl_product t1
							                           	JOIN tbl_cust_category t2
							                           	ON t1.cat_id = t2.cat_id
							                           	JOIN tbl_category_type t3
							                           	ON t2.ctype_id = t3.ctype_id
							                           	JOIN tbl_gender t4
							                           	ON t3.gender_id = t4.gender_id
							                           	ORDER BY t1.p_id DESC
							                           	");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td>
										<?php if ($row['customer']) {
											$cust_id = $row['customer'];
											$query = "SELECT * from tbl_user where id='$cust_id'";
											$stmt = $pdo->prepare($query);
											$stmt->execute();
											$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
											foreach ($res as $row1) {
												echo $row1['full_name'];
											}
										} ?>
									</td>
									<td style="width:82px;"><img src="../assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo $row['p_name']; ?>" style="width:50px;"></td>
									<td><?php echo $row['p_name']; ?></td>
									<td><?php echo $row['cat_name']; ?></td>
									<td><?php echo $row['sku']; ?></td>
									<td><?php echo $row['quantity']; ?></td>
									<td><?php echo $row['price']; ?></td>
									<td><?php if ($row['p_status'] == 1) { echo 'Enable'; } else { echo 'Disable'; } ?>

								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
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
				<p>Are you sure want to delete this item?</p>
				<p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>