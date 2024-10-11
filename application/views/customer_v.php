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
				<li class="active">Customer</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-10" id="col10">
				<h1 class="page-header"> Customer</h1>
			</div>
			<form method="post" class="col-md-2" id="closeBtn" style="display: none;">
				<h1 class="page-header col-md-12">
					<button onclick="tutup();" class="btn btn-danger btn-block btn-lg" value="OK" style="">Close</button>
				</h1>
			</form>
			<script>
        $(document).ready(function() {
            if (sessionStorage.getItem('openedFromLink')) {
                $('#closeBtn').show(); 
                $('#col10').removeClass('col-md-10').addClass('col-md-8'); 
                // sessionStorage.removeItem('openedFromLink');
            }
        });

        function tutup() {
			window.opener.location.reload();
			sessionStorage.removeItem('openedFromLink');
            window.close(); // Menutup jendela
        }
    </script>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
				<form method="post" class="col-md-2">
					<h1 class="page-header col-md-12">
						<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
						<input type="hidden" name="customer_id" />
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
									$judul = "Update Customer";
								} else {
									$namabutton = 'name="create"';
									$judul = "New Customer";
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<?php if ($identity->identity_saldocustomer == 1) { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="customer_saldo">Saldo:</label>
											<div class="col-sm-10">
												<?php if ($this->session->userdata("position_id") == 1 || $this->session->userdata("position_id") == 2 || $this->session->userdata("position_id") == 7) {
													$disabled = "";
												} else {
													$disabled = 'disabled="disabled"';
												} ?>
												<input type="text" <?= $disabled; ?> autofocus class="form-control" id="customer_saldo" name="customer_saldo" placeholder="Saldo Customer" value="<?= $customer_saldo; ?>">
											</div>
											<div class="col-sm-offset-2 col-sm-10" style="font-size:10px; color:#FF0000;">
												Penambahan saldo dapat dilakukan di petty atau big cash.
											</div>
										</div>
									<?php } ?>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_name">Customer Name:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_name" name="customer_name" placeholder="Enter Name" value="<?= $customer_name; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="branch_id">Branch:</label>
										<div class="col-sm-10">
											<select class="form-control" id="branch_id" name="branch_id">
												<option value="" <?= ($branch_id == "") ? "selected" : ""; ?>>Pilih Branch</option>
												<?php $branch = $this->db->get("branch");
												foreach ($branch->result() as $branch) {
												?>
													<option value="<?= $branch->branch_id; ?>" <?= ($branch_id == $branch->branch_id) ? "selected" : ""; ?>><?= $branch->branch_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_email">Customer Email:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_email" name="customer_email" placeholder="Enter Email" value="<?= $customer_email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_country">Country:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_country" name="customer_country" placeholder="Enter Country" value="<?= $customer_country; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_address">Customer Address:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_address" name="customer_address" placeholder="Enter Address" value="<?= $customer_address; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_phone">Phone:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Phone" value="<?= $customer_phone; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_fax">Fax:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_fax" name="customer_fax" placeholder="Enter Fax" value="<?= $customer_fax; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_cp">Contact Person:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_cp" name="customer_cp" placeholder="Enter CP" value="<?= $customer_cp; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_wa">Whatsapp:<br /><span style="font-size:10px; color:red;">(wajib berawalan 62 di depan tanpa +)</span></label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_wa" name="customer_wa" placeholder="Enter Whatsapp Number" value="<?= ($customer_wa == "") ? "62" : $customer_wa; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_ktp">Identity Number (KTP):</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_ktp" name="customer_ktp" placeholder="Enter Identity Number (KTP)" value="<?= $customer_ktp; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_npwp">NPWP:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="customer_npwp" name="customer_npwp" placeholder="Enter NPWP" value="<?= $customer_npwp; ?>">
										</div>
									</div>

									<input type="hidden" name="customer_id" value="<?= $customer_id; ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("customer"); ?>">Back</button>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadcustomer_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>Customer</th>
												<?php if ($identity->identity_saldocustomer == 1) { ?>
													<th>Saldo</th>
												<?php } ?>
												<th>Branch</th>
												<th>Email</th>
												<th>Address</th>
												<th>Phone</th>
												<th>CP</th>
												<th class="col-md-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $usr = $this->db
												->join("branch", "branch.branch_id=customer.branch_id", "left")
												->order_by("customer_id", "desc")
												->get("customer");
											$no = 1;
											foreach ($usr->result() as $customer) { ?>
												<tr>
													<td><?= $no++; ?></td>
													<td><?= $customer->customer_name; ?></td>
													<?php if ($identity->identity_saldocustomer == 1) { ?>
														<td><?= number_format($customer->customer_saldo, 0, ",", "."); ?></td>
													<?php } ?>
													<td><?= $customer->branch_name; ?></td>
													<td><?= $customer->customer_email; ?></td>
													<td><?= $customer->customer_address; ?></td>
													<td><?= $customer->customer_phone; ?></td>
													<td><?= $customer->customer_cp; ?></td>
													<td style="padding-left:0px; padding-right:0px;">
														<?php if ($identity->identity_productcustomer == 1) { ?>
															<form target="_blank" action="customerproduct" method="get" class="col-md-4" style="padding:0px; float:left;">
																<button class="btn  btn-primary " data-toggle="tooltip" title="Product Customer" name="customer_id" value="<?= $customer->customer_id; ?>"><span class="fa fa-shopping-bag" style="color:white;"></span> </button>
																<input type="hidden" name="customer_name" value="<?= $customer->customer_name; ?>" />
															</form>
														<?php } ?>
														<form method="post" class="col-md-4" style="padding:0px;float:left;">
															<button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
															<input type="hidden" name="customer_id" value="<?= $customer->customer_id; ?>" />
														</form>

														<form method="post" class="col-md-4" style="padding:0px;float:left;">
															<button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
															<input type="hidden" name="customer_id" value="<?= $customer->customer_id; ?>" />
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
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php"); ?>
</body>

</html>