<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php");
	if (isset($_GET['tagihan'])) {
		$urltagihan = "&tagihan=" . $this->input->get("tagihan");
	} else {
		$urltagihan = "";
	}
	?>
</head>

<body class="  ">
	<?php require_once("header.php"); ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home">
							<use xlink:href="#stroked-home"></use>
						</svg></a></li>
				<li class="active">Product Invoice Payment</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Product Invoice Payment No. <?= $this->input->get("invpayment_no"); ?></h1>
			</div>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
				<form method="post" class="col-md-4">
					<h1 class="page-header col-md-12">
						<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
						<?php if (isset($_GET['inv_no'])) {
							$inv_no = $_GET['inv_no'];
						} else {
							$inv_no = "";
						} ?>
						<?php if (isset($_GET['customer_id'])) {
							$customer_id = $_GET['customer_id'];
						} else {
							$customer_id = "";
						} ?>
						<?php if (isset($_GET['project_id'])) {
							$project_id = $_GET['project_id'];
						} else {
							$project_id = "";
						} ?>
						<button type="button" onclick="tutup();" class="btn btn-warning btn-lg" style="float:right; margin:2px;">
							Back
						</button>


						<input type="hidden" name="invpaymentproduct_id" value="0" />
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
									$judul = "Update Product";
								} else {
									$namabutton = 'name="create"';
									$judul = "New Product";
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<?php if (!isset($_GET['methodpayment_id']) || (isset($_GET['methodpayment_id']) && $_GET['methodpayment_id'] != -1) || $cukup == 0) { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="unit_id">Store to:</label>
											<div class="col-sm-10">
												<?php if (isset($_POST['edit'])) {
													$disabled = "disabled"; ?>
													<input type="hidden" name="invpaymentproduct_source" value="<?= $invpaymentproduct_source; ?>" />
												<?php } else {
													$disabled = "";
												} ?>
												<label><input <?= $disabled; ?> required type="radio" name="invpaymentproduct_source" id="kas_id" value="kas_id" <?= ($invpaymentproduct_source == "kas_id") ? 'checked="checked"' : ""; ?>>Big Cash</label>
												<label><input <?= $disabled; ?> required type="radio" name="invpaymentproduct_source" id="petty_id" value="petty_id" <?= ($invpaymentproduct_source == "petty_id" || $invpaymentproduct_source == "") ? 'checked="checked"' : ""; ?>>Petty Cash</label>
											</div>
										</div>
									<?php } ?>
									<div class="form-group">
										<label class="control-label col-sm-2" for="invpaymentproduct_description">Description:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="invpaymentproduct_description" value="<?= ($invpaymentproduct_description != "") ? $invpaymentproduct_description : "Pembayaran inv : " . $_GET['inv_no']; ?>">
										</div>
									</div>
									<!--<div class="form-group">
								<label class="control-label col-sm-2" for="invpaymentproduct_code">Code:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invpaymentproduct_code" name="invpaymentproduct_code"  value="<?= $invpaymentproduct_code; ?>">
								</div>
							  </div>-->
									<div class="form-group">
										<label class="control-label col-sm-2" for="">Total Bill:</label>
										<div class="col-sm-10">
											<input type="text" disabled="disabled" class="form-control" value="Rp <?= number_format($tagihan, 2, ",", "."); ?>">
											<input type="hidden" class="form-control" id="tagihan" value="<?= $tagihan; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="invpaymentproduct_amount">Amount:</label>
										<div class="col-sm-10">
											<?php if (isset($_GET['methodpayment_id']) && $_GET['methodpayment_id'] == "-1") {
												$amount = $tagihan;
											} else {
												$amount = $invpaymentproduct_amount;
											} ?>
											<input onKeyUp="kembalian1()" type="number" min="1" step="0.01" autofocus class="form-control dibayar" id="jumlah" value="<?= $amount; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="">Change:</label>
										<div class="col-sm-10">
											<input type="text" id="kembalian" disabled="disabled" class="form-control" value="Rp ">
											<input type="hidden" id="invpaymentproduct_amount" name="invpaymentproduct_amount" value="<?= $amount; ?>">
											<input type="hidden" id="invpaymentproduct_bayar" name="invpaymentproduct_bayar" value="">
											<input type="hidden" id="invpaymentproduct_kembalian" name="invpaymentproduct_kembalian" value="">
										</div>
										<script>
											function kembalian1() {
												var bayar = $("#jumlah").val();
												var kembalian = bayar - <?= $tagihan; ?>;
												if ($("#jumlah").val() > <?= $tagihan; ?>) {
													$("#invpaymentproduct_amount").val('<?= $tagihan; ?>');
													$("#invpaymentproduct_bayar").val(bayar);
													$("#invpaymentproduct_kembalian").val(kembalian);
													$("#kembalian").val(formatter.format(kembalian));
												} else {
													$("#invpaymentproduct_amount").val(bayar);
													$("#invpaymentproduct_bayar").val(0);
													$("#invpaymentproduct_kembalian").val(0);
													$("#kembalian").val(formatter.format(0));
												}
											}
										</script>
									</div>

									<input type="hidden" name="invpaymentproduct_qty" value="<?= ($invpaymentproduct_qty > 0) ? $invpaymentproduct_qty : 1; ?>">
									<input type="hidden" name="invpaymentproduct_id" value="<?= $invpaymentproduct_id; ?>" />
									<input type="hidden" name="invpayment_no" value="<?= $this->input->get("invpayment_no"); ?>" />
									<input type="hidden" name="petty_id" value="<?= $petty_id; ?>" />
									<input type="hidden" name="kas_id" value="<?= $kas_id; ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>

											<a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= $currentUrl; ?>">Back</a>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadinvpaymentproduct_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>Source</th>
												<th>Description</th>
												<!--<th>Code</th>-->
												<th>Qty</th>
												<th>Price</th>
												<th>Total</th>
												<th class="col-md-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $usr = $this->db
												->where("invpayment_no", $this->input->get("invpayment_no"))
												->order_by("invpaymentproduct_id", "desc")
												->get("invpaymentproduct");
											//echo $this->db->last_query();
											$no = 1;
											foreach ($usr->result() as $invpaymentproduct) {
												if ($invpaymentproduct->invpaymentproduct_source == "petty_id") {
													$source = "Petty Cash";
												} else {
													$source = "Big Cash";
												}
											?>
												<tr>
													<td><?= $no; ?></td>
													<td><?= $source; ?></td>
													<td><?= $invpaymentproduct->invpaymentproduct_description; ?></td>
													<!--<td><?= $invpaymentproduct->invpaymentproduct_code; ?></td>-->
													<td><?= $invpaymentproduct->invpaymentproduct_qty; ?></td>
													<td><?= number_format($invpaymentproduct->invpaymentproduct_amount, 0, ",", "."); ?></td>
													<td><?= number_format($invpaymentproduct->invpaymentproduct_amount * $invpaymentproduct->invpaymentproduct_qty, 0, ",", "."); ?></td>
													<td style="padding-left:0px; padding-right:0px;">
														<form method="post" class="col-md-4" style="padding:0px;">
															<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
															<input type="hidden" name="invpaymentproduct_id" value="<?= $invpaymentproduct->invpaymentproduct_id; ?>" />
														</form>

														<form method="post" class="col-md-4" style="padding:0px;">
															<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
															<input type="hidden" name="invpaymentproduct_id" value="<?= $invpaymentproduct->invpaymentproduct_id; ?>" />
															<input type="hidden" name="invpaymentproduct_source" value="<?= $invpaymentproduct->invpaymentproduct_source; ?>" />
															<input type="hidden" name="kas_id" value="<?= $invpaymentproduct->kas_id; ?>" />
															<input type="hidden" name="petty_id" value="<?= $invpaymentproduct->petty_id; ?>" />
														</form>

														<form method="POST" class="col-md-4" style="padding:0px;">
															<a data-toggle="tooltip" title="Print Kwitansi" target="_blank" href="<?= site_url("invpaymentprint?nom=" . $no++ . "&invpayment_no=" . $invpaymentproduct->invpayment_no . "&invpaymentproduct_id=" . $invpaymentproduct->invpaymentproduct_id); ?>" class="btn btn-sm btn-success" style="margin:0px;">
																<span class="fa fa-print" style="color:white;"></span> </a>
														</form>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
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