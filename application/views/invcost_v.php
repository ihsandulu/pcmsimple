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
				<li class="active">Cost Payment</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Cost Payment No. <?= $this->input->get("invpayment_no"); ?></h1>
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
						<input type="hidden" name="invcost_id" value="0" />
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
									<div class="form-group">
										<label class="control-label col-sm-2" for="invcost_remarks">Remarks:</label>
										<div class="col-sm-10">
											<input autofocus type="text" class="form-control" name="invcost_remarks" value="<?= $invcost_remarks; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="invcost_amount">Amount:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="invcost_amount" name="invcost_amount" value="<?= $invcost_amount; ?>">
										</div>
									</div>
									<input type="hidden" name="invcost_id" value="<?= $invcost_id; ?>" />
									<input type="hidden" name="invpayment_no" value="<?= $this->input->get("invpayment_no"); ?>" />
									<input type="hidden" name="inv_no" value="<?= $this->input->get("inv_no"); ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("invcost"); ?>">Back</button>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadinvcost_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>Remarks</th>
												<th>Total</th>
												<th class="col-md-1">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $usr = $this->db
												->where("invpayment_no", $this->input->get("invpayment_no"))
												->order_by("invcost_id", "desc")
												->get("invcost");
											//echo $this->db->last_query();
											$no = 1;
											foreach ($usr->result() as $invcost) {
											?>
												<tr>
													<td><?= $no++; ?></td>
													<td><?= $invcost->invcost_remarks; ?></td>
													<td><?= number_format($invcost->invcost_amount, 0, ",", "."); ?></td>
													<td style="padding-left:0px; padding-right:0px;">
														<form method="post" class="col-md-6" style="padding:0px;">
															<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
															<input type="hidden" name="invcost_id" value="<?= $invcost->invcost_id; ?>" />
														</form>

														<form method="post" class="col-md-6" style="padding:0px;">
															<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
															<input type="hidden" name="invcost_id" value="<?= $invcost->invcost_id; ?>" />
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