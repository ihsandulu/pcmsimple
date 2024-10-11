<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php"); ?>
</head>

<body class="  ">
	<?php require_once("header.php"); ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home">
							<use xlink:href="#stroked-home"></use>
						</svg></a></li>
				<li class="active">Task</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Task No. <?= $this->input->get("task_no"); ?></h1>
			</div>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
				<form method="post" class="col-md-4">
					<h1 class="page-header col-md-12">
						<?php if ($this->session->userdata("position_id") != 2) { ?>
							<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
						<?php } ?>
						<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
						<input type="hidden" name="taskproduct_id" value="0" />
					</h1>
				</form>
			<?php } ?>
		</div><!--/.row-->


		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
							<div class="">
								<?php if (isset($_POST['edit'])) {
									$namabutton = 'name="change"';
									$judul = "Update Task";
								} else {
									$namabutton = 'name="create"';
									$judul = "New Task";
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="control-label col-sm-2" for="unit_id">Task:</label>
										<div class="col-sm-10">
											<datalist id="product">
												<?php if ($identity->identity_productcustomer == 3 && $identity->identity_project == 1) {
													$input["project_id"] = $this->input->get("project_id");
													$product = $this->db
														->join("product", "product.product_id=projectproduct.product_id", "left")
														->get_where("projectproduct", $input);
													$price = "projectproduct_price";
												} elseif ($identity->identity_productcustomer == 1) {
													$input["customer_id"] = $this->input->get("customer_id");
													$product = $this->db
														->join("product", "product.product_id=customerproduct.product_id", "left")
														->get_where("customerproduct", $input);
													$price = "customerproduct_price";
												} elseif ($identity->identity_productcustomer == 2) {
													$input["vendor_id"] = $this->input->get("vendor_id");
													$product = $this->db
														->join("product", "product.product_id=vendorproduct.product_id", "left")
														->get_where("vendorproduct", $input);
													$price = "vendorproduct_price";
												} else {
													$product = $this->db->get_where("product");
													$price = "product_sell";
												}
												//$t= $this->db->last_query();
												foreach ($product->result() as $cusprod) { ?>
													<option price="<?= $cusprod->product_sell; ?>" id="<?= $cusprod->product_id; ?>" value="<?= $cusprod->product_name; ?>">
													<?php } ?>
											</datalist>

											<input onChange="productid(this)" class="form-control" list="product" value="<?= $product_name; ?>">
											<div id="tprice"></div>
											<input type="hidden" list="product" id="product_id" name="product_id" value="<?= $product_id; ?>">
											<script>
												function productid(a) {
													var opt = $('option[value="' + $(a).val() + '"]');
													$("#product_id").val(opt.attr('id'));
													let price = opt.attr('price');
													if (price) {
														price = parseFloat(price).toLocaleString('id-ID', {
															style: 'decimal',
															minimumFractionDigits: 2,
															maximumFractionDigits: 2
														});
														$("#tprice").html("Price: " + price);
													} else {
														$("#tprice").html("");
													}
												}
											</script>

										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="taskproduct_remarks">Remarks:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="taskproduct_remarks" name="taskproduct_remarks" value="<?= $taskproduct_remarks; ?>">
										</div>
									</div>

									<input type="hidden" name="taskproduct_id" value="<?= $taskproduct_id; ?>" />
									<input type="hidden" name="taskproduct_date" value="<?= $taskproduct_date; ?>" />
									<input type="hidden" name="task_no" value="<?= $this->input->get("task_no"); ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("taskproduct"); ?>">Back</button>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadtaskproduct_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">

									<?php if ($this->session->userdata("position_id") == 2) { ?>
										<?php $usr = $this->db
											->join("product", "product.product_id=taskproduct.product_id", "left")
											->where("task_no", $this->input->get("task_no"))
											->order_by("taskproduct_id", "desc")
											->get("taskproduct");
										//echo $this->db->last_query();
										$no = 1;
										foreach ($usr->result() as $taskproduct) {
											if ($taskproduct->taskproduct_qty == 1) {
												$warna = "background-color:#BAFFC9;";
												$status = "Done";
											} else {
												$warna = "background-color:#FFB3BA;";
												$status = "";
											}
										?>
											<div class="col-md-4 col-xs-12" style="text-align:center;">
												<div class="row" style="<?= $warna; ?>;margin:5px;padding:15px 5px 15px 5px; border-radius:5px; box-shadow:rgba(0,0,0,0.1) 0px 0px 5px 1px;">
													<div class="col-md-12">

														<div style="font-weight:bold; font-size:20px;">Status :
															<?php
															if ($taskproduct->taskproduct_qty == 1) {
																echo "Done";
															} else {
																echo "Proses";
															}
															?>
														</div>
														<!-- <div><?= $taskproduct->taskproduct_date; ?></div> -->
														<div><?= $taskproduct->product_name; ?> (<?= number_format($taskproduct->product_sell, 0, ",", "."); ?>)</div>
														<div><?= $taskproduct->taskproduct_remarks; ?></div>

														<!-- <div><?php if ($taskproduct->taskproduct_picture == "") {
																		$taskproduct_picture = "noimage.png";
																	} else {
																		$taskproduct_picture = $taskproduct->taskproduct_picture;
																	} ?>
															<img src="<?= base_url("assets/images/taskproduct_picture/" . $taskproduct_picture); ?>" title="Bukti Penyelesaian" alt="Bukti Penyelesaian" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;" onClick="tampilimg(this)" />
															<?php if ($taskproduct->taskproduct_picture != "") { ?>
																&nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?= base_url("assets/images/taskproduct_picture/" . $taskproduct->taskproduct_picture); ?>" target="_blank"></a>
															<?php } ?>
														</div> -->
														<?php if (!isset($_GET['report'])) { ?>
															<?php if ($this->session->userdata("position_id") == 2) { ?>
																<div class="" style="padding:10px; ">

																	<form enctype="multipart/form-data" method="post" class="col-md-12" style="padding:0px;">
																		<!-- <input type="file" name="taskproduct_picture" class="col-md-4" style="border:none;" /> -->
																		<!-- <input type="text" name="taskproduct_date" class=" col-md-offset-1 col-md-4 date" placeholder="Date" style="height:32px;" value="<?= $taskproduct->taskproduct_date; ?>" /> -->
																		<button class="btn btn-success btn-block" name="change" value="OK"><span class="fa fa-check-square-o" style="color:white;"></span> </button>
																		<input type="hidden" name="taskproduct_qty" value="1" />
																		<input type="hidden" name="taskproduct_id" value="<?= $taskproduct->taskproduct_id; ?>" />
																	</form>
																</div>
															<?php } else { ?>
																<div style="padding-left:0px; padding-right:0px;">

																	<form method="post" class="col-md-6" style="padding:0px;">
																		<button type="button" onclick="confirmDelete('delete<?= $taskproduct->taskproduct_id; ?>')" class="btn btn-danger delete" id="delete<?= $taskproduct->taskproduct_id; ?>" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																		<input type="hidden" name="taskproduct_id" value="<?= $taskproduct->taskproduct_id; ?>" />
																	</form>
																	<?php
																	if ($taskproduct->taskproduct_qty == 1) {
																		echo "Done";
																	} else {
																	?>
																		<form method="post" class="col-md-6" style="padding:0px;">
																			<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																			<input type="hidden" name="taskproduct_id" value="<?= $taskproduct->taskproduct_id; ?>" />
																		</form>
																	<?php } ?>
																</div>
															<?php } ?>
														<?php } ?>
													</div>
												</div>
											</div>
										<?php } ?>

									<?php } else { ?>
										<table id="dataTable" class="table table-condensed table-hover">
											<thead>
												<tr>
													<?php if (!isset($_GET['report'])) { ?>
														<?php if ($this->session->userdata("position_id") == 2) { ?>
															<th class="col-md-5">Action</th>
														<?php } else { ?>
															<th class="col-md-1">Action</th>
														<?php } ?>
													<?php } ?>
													<th>No.</th>
													<th>Date Task Done</th>
													<th>Task</th>
													<th>Remarks</th>
													<th>Picture</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<?php $usr = $this->db
													->join("product", "product.product_id=taskproduct.product_id", "left")
													->where("task_no", $this->input->get("task_no"))
													->order_by("taskproduct_id", "desc")
													->get("taskproduct");
												//echo $this->db->last_query();
												$no = 1;
												foreach ($usr->result() as $taskproduct) {
													if ($taskproduct->taskproduct_qty == 1) {
														$warna = "background-color:#BAFFC9;";
														$status = "Done";
													} else {
														$warna = "background-color:#FFB3BA;";
														$status = "";
													}
												?>
													<tr style="<?= $warna; ?>">
														<?php if (!isset($_GET['report'])) { ?>
															<?php if ($this->session->userdata("position_id") == 2) { ?>
																<td class="" style="padding-left:5px; padding-right:10px; border-left:black solid 1px;">

																	<form enctype="multipart/form-data" method="post" class="col-md-12" style="padding:0px;">
																		<input type="file" name="taskproduct_picture" class="col-md-4" style="border:none;" />
																		<input type="text" name="taskproduct_date" class=" col-md-offset-1 col-md-4 date" placeholder="Date" style="height:32px;" value="<?= $taskproduct->taskproduct_date; ?>" />
																		<button class="btn btn-success col-md-offset-1 col-md-2" name="change" value="OK"><span class="fa fa-check-square-o" style="color:white;"></span> </button>
																		<input type="hidden" name="taskproduct_qty" value="1" />
																		<input type="hidden" name="taskproduct_id" value="<?= $taskproduct->taskproduct_id; ?>" />
																	</form>
																</td>
															<?php } else { ?>
																<td style="padding-left:0px; padding-right:0px;">

																	<form method="post" class="col-md-6" style="padding:0px;">
																		<button type="button" onclick="confirmDelete('delete<?= $taskproduct->taskproduct_id; ?>')" class="btn btn-danger delete" id="delete<?= $taskproduct->taskproduct_id; ?>" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																		<input type="hidden" name="taskproduct_id" value="<?= $taskproduct->taskproduct_id; ?>" />
																	</form>
																	<?php
																	if ($taskproduct->taskproduct_qty == 1) {
																		echo "Done";
																	} else {
																	?>
																		<form method="post" class="col-md-6" style="padding:0px;">
																			<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																			<input type="hidden" name="taskproduct_id" value="<?= $taskproduct->taskproduct_id; ?>" />
																		</form>
																	<?php } ?>
																</td>
															<?php } ?>
														<?php } ?>
														<td><?= $no++; ?></td>
														<td><?= $taskproduct->taskproduct_date; ?></td>
														<td><?= $taskproduct->product_name; ?> (<?= number_format($taskproduct->product_sell, 0, ",", "."); ?>)</td>
														<td><?= $taskproduct->taskproduct_remarks; ?></td>

														<td><?php if ($taskproduct->taskproduct_picture == "") {
																$taskproduct_picture = "noimage.png";
															} else {
																$taskproduct_picture = $taskproduct->taskproduct_picture;
															} ?>
															<img src="<?= base_url("assets/images/taskproduct_picture/" . $taskproduct_picture); ?>" title="Bukti Penyelesaian" alt="Bukti Penyelesaian" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;" onClick="tampilimg(this)" />
															<?php if ($taskproduct->taskproduct_picture != "") { ?>
																&nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?= base_url("assets/images/taskproduct_picture/" . $taskproduct->taskproduct_picture); ?>" target="_blank"></a>
															<?php } ?>
														</td>
														<td>
															<?php
															if ($taskproduct->taskproduct_qty == 1) {
																echo "Done";
															} else {
																echo "Proses";
															}
															?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php"); ?>
</body>

</html>