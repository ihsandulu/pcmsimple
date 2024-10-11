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
				<li class="active">Product Invoice</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Product Invoice No. <?= $this->input->get("inv_no"); ?></h1>
			</div>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
				<form method="post" class="col-md-4">
					<h1 class="page-header col-md-12">
						<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
						<button type="button" onclick="tutup();" class="btn btn-warning btn-lg" style="float:right; margin:2px;">
							Back
						</button>
						<input type="hidden" name="invproduct_id" value="0" />
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
								<?php
								if (isset($_GET['bap'])) {
									$namabutton = 'name="bap"';
									$judul = "Berita Acara Pemusnahan";
								} else {
									if (isset($_POST['edit'])) {
										$namabutton = 'name="change"';
										$judul = "Update Product";
									} else {
										$namabutton = 'name="create"';
										$judul = "New Product";
									}
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="control-label col-sm-2" for="unit_id">Product:</label>
										<div class="col-sm-10">
											<datalist id="product">
												<?php
												if ($identity->identity_productcustomer == 3 && $identity->identity_project == 1) {
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
												foreach ($product->result() as $cusprod) { ?>
													<option id="<?= $cusprod->product_id; ?>" value="<?= $cusprod->product_name; ?> (Rp.<?= number_format($cusprod->$price, 0, ",", "."); ?>)">
													<?php } ?>
											</datalist>

											<input id="productid" onChange="rubah(this)" autofocus class="form-control" list="product" value="<?= $product_name; ?>" autocomplete="off">
											<input type="hidden" list="product" id="product_id" name="product_id" value="<?= $product_id; ?>">
											<script>
												function productid(a) {
													var opt = $('option[value="' + $(a).val() + '"]');
													$("#product_id").val(opt.attr('id'));
													hargacustomer(opt.attr('id'));

												}

												function hargacustomer(a) {
													$.get("<?= site_url("api/hargacustomer"); ?>", {
															product_id: a,
															customer_id: '<?= $this->input->get("customer_id"); ?>',
															vendor_id: '<?= $this->input->get("vendor_id"); ?>',
															project_id: '<?= $this->input->get("project_id"); ?>'
														})
														.done(function(data) {
															$("#invproduct_price").val(data);
														});
												}

												function rubah(a) {
													productid(a);
													stoptime();
												}

												var timeout;

												function doStuff() {
													timeout = setInterval(function() {
														productid('#productid');
													}, 100);
												}

												function stoptime() {
													clearTimeout(timeout);
												}
											</script>

										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="invproduct_price">Price:</label>
										<div class="col-sm-10">
											<input onFocus="stoptime()" type="text" class="form-control" id="invproduct_price" name="invproduct_price" placeholder="Enter Price" value="<?= $invproduct_price; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="invproduct_remarks">Remarks:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="invproduct_remarks" name="invproduct_remarks" placeholder="Enter Remarks" value="<?= $invproduct_remarks; ?>">
										</div>
									</div>
									<?php if ($identity->identity_dimension == 1) { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="invproduct_panjang">Length:</label>
											<div class="col-sm-10">
												<input onFocus="stoptime()" type="text" class="form-control" id="invproduct_panjang" name="invproduct_panjang" placeholder="Enter Length" value="<?= $invproduct_panjang; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="invproduct_lebar">Width:</label>
											<div class="col-sm-10">
												<input onFocus="stoptime()" type="text" class="form-control" id="invproduct_lebar" name="invproduct_lebar" placeholder="Enter Width" value="<?= $invproduct_lebar; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="invproduct_tinggi">Height:</label>
											<div class="col-sm-10">
												<input onFocus="stoptime()" type="text" class="form-control" id="invproduct_tinggi" name="invproduct_tinggi" placeholder="Enter Height" value="<?= $invproduct_tinggi; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-2" for="invproduct_unit">Unit:<br />(Mis.cm,m)</label>
											<div class="col-sm-10">
												<input onFocus="stoptime()" type="text" class="form-control" id="invproduct_unit" name="invproduct_unit" placeholder="Enter Unit" value="<?= $invproduct_unit; ?>">
											</div>
										</div>
									<?php } ?>
									<div class="form-group">
										<label class="control-label col-sm-2" for="invproduct_qty">Qty:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="invproduct_qty" name="invproduct_qty" placeholder="Enter Qty" value="<?= ($invproduct_qty <= 0) ? 1 : $invproduct_qty; ?>">
										</div>
									</div>
									<?php if (isset($_GET['bap'])) { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="bap_remarks">Remarks:</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="bap_remarks" name="bap_remarks" placeholder="Enter Remarks" value="<?= $this->input->get("bap_remarks"); ?>">
											</div>
										</div>
									<?php } ?>
									<input type="hidden" name="invproduct_id" value="<?= $invproduct_id; ?>" />
									<input type="hidden" name="inv_no" value="<?= $this->input->get("inv_no"); ?>" />
									<input type="hidden" name="gudang_id" value="<?= $gudang_id; ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("invproduct"); ?>">Back</button>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadinvproduct_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
							<div id="collapse4" class=" tarik">
								<table id="" class="table table-condensed table-hover">
										<thead>
											<tr>
											<th class="col-md-2">Action</th>
												<th>No.</th>
												<th>Product</th>
												<th>Qty</th>
												<?php if ($identity->identity_dimension == 1) { ?>
													<th>Length</th>
													<th>Width</th>
													<th>Height</th>
												<?php } ?>
												<th>Price</th>
												<th>Remarks</th>
											</tr>
										</thead>
										<tbody>
											<?php $usr = $this->db
												->join("product", "product.product_id=invproduct.product_id", "left")
												->where("inv_no", $this->input->get("inv_no"))
												->order_by("invproduct_id", "desc")
												->get("invproduct");
											$no = 1;
											foreach ($usr->result() as $invproduct) { ?>
												<tr>
													<td style="padding-left:0px; padding-right:0px;">
														<?php if ($identity->identity_stok == 1) { ?>
															<form method="post" action="<?= site_url("invproduct?inv_no=" . $invproduct->inv_no . "&customer_id=" . $this->input->get("customer_id") . "&bap=OK&bap_remarks=Reject Product Invoice " . $invproduct->inv_no); ?>" method="post" method="post" class="col-md-3" style="padding:0px;">
																<button name="edit" class="btn btn-danger" title="Berita Acara Pemusnahan" data-toggle="tooltip" value="OK"><span class="fa fa-trash" style="color:white;"></span> </button>
																<input type="hidden" name="invproduct_id" value="<?= $invproduct->invproduct_id; ?>" />
															</form>
															<form method="post" target="_blank" action="<?= site_url("gudang?daurulang=OK&gudang_qty=" . $invproduct->invproduct_qty . "&gudang_inout=in&gudang_keterangan=Pengembalian Invoice " . $invproduct->inv_no . "&table=invproduct&id=" . $invproduct->invproduct_id); ?>" method="post" method="post" class="col-md-3" style="padding:0px;">
																<button name="new" class="btn btn-info" title="Daur Ulang (New Product)/ Return Product" data-toggle="tooltip" value="OK"><span class="fa fa-cogs" style="color:white;"></span> </button>
																<input type="hidden" name="gudang_id" />
															</form>
														<?php } ?>
														<form method="post" class="col-md-3" style="padding:0px;">
															<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
															<input type="hidden" name="invproduct_id" value="<?= $invproduct->invproduct_id; ?>" />
														</form>

														<form method="post" class="col-md-3" style="padding:0px;">
															<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
															<input type="hidden" name="invproduct_id" value="<?= $invproduct->invproduct_id; ?>" />
															<input type="hidden" name="gudang_id" value="<?= $invproduct->gudang_id; ?>" />
														</form>
													</td>
													<td><?= $no++; ?></td>
													<td><?= $invproduct->product_name; ?></td>
													<td><?= $invproduct->invproduct_qty; ?></td>
													<?php if ($identity->identity_dimension == 1) { ?>
														<td><?= $invproduct->invproduct_panjang; ?> <?= $invproduct->invproduct_unit; ?></td>
														<td><?= $invproduct->invproduct_lebar; ?> <?= $invproduct->invproduct_unit; ?></td>
														<td><?= $invproduct->invproduct_tinggi; ?> <?= $invproduct->invproduct_unit; ?></td>
													<?php } ?>
													<td><?= number_format($invproduct->invproduct_price, 2, ",", "."); ?></td>
													<td><?= $invproduct->invproduct_remarks; ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<script>
									// tarik
									const tableContainer = document.querySelector('.tarik');

									let isDown = false;
									let startX;
									let scrollLeft;

									tableContainer.addEventListener('mousedown', (e) => {
										isDown = true;
										tableContainer.classList.add('active');
										startX = e.pageX - tableContainer.offsetLeft;
										scrollLeft = tableContainer.scrollLeft;
									});

									tableContainer.addEventListener('mouseleave', () => {
										isDown = false;
										tableContainer.classList.remove('active');
									});

									tableContainer.addEventListener('mouseup', () => {
										isDown = false;
										tableContainer.classList.remove('active');
									});

									tableContainer.addEventListener('mousemove', (e) => {
										if (!isDown) return;
										e.preventDefault();
										const x = e.pageX - tableContainer.offsetLeft;
										const walk = (x - startX) * 2; // Nilai 2 bisa diatur untuk kecepatan scroll
										tableContainer.scrollLeft = scrollLeft - walk;
									});
								</script>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- /#wrap -->
		<?php require_once("footer.php"); ?>
</body>

</html>