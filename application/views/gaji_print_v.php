<!DOCTYPE html>
<html>

<head>
	<title>Print Payroll</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<script src="<?= base_url("assets/js/jquery-1.11.1.min.js"); ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
	<style>
		th,
		td {
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row">

			<?php
			$identity = $this->db->get("identity")->row();
			if ($identity->identity_kop == 1) {
				require_once("kop.php");
			}
			?>

			<div class="col-md-12">
				<h1 style="text-decoration:underline;">Payroll</h1>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
				<div class="col-md-2 col-sm-2 col-xs-3">Payroll No.</div>
				<div class="col-md-1 col-sm-1 col-xs-1">:</div>
				<div class="col-md-9 col-sm-9 col-xs-8"><?= $gaji_no; ?>&nbsp;</div>
				<div class="col-md-2 col-sm-2 col-xs-3">Name</div>
				<div class="col-md-1 col-sm-1 col-xs-1">:</div>
				<div class="col-md-9 col-sm-9 col-xs-8"><?= $gaji_name; ?>&nbsp;</div>
				<div class="col-md-2 col-sm-2 col-xs-3">Month</div>
				<div class="col-md-1 col-sm-1 col-xs-1">:</div>
				<div class="col-md-9 col-sm-9 col-xs-8"><?= date("M Y", strtotime($gaji_datetime)); ?>&nbsp;</div>
			</div>

			<div style="">&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; ">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2>Payment</h2>
					<table class="table table-bordered col-md-12 col-sm-12 col-xs-12">
						<thead>
							<tr>
								<th>Description</th>
								<th>Nominal</th>
							</tr>
						</thead>
						<tbody>
							<?php $gajid = $this->db
								->where("gaji_id", $this->input->get("gaji_id"))
								->where("gajid_type", "0")
								->get("gajid");
							foreach ($gajid->result() as $gajid) { ?>
								<tr>
									<td>
										<?= $gajid->gajid_name; ?>
										<?php if ($gajid->gajid_hari > 0) { ?>
											<br />Days: <?= $gajid->gajid_hari; ?>
											<br />Basic Salary Daily : Rp. <?= number_format($gajid->gajid_basic, 0, ",", "."); ?>
										<?php } ?>
									</td>
									<td><?= number_format($gajid->gajid_nominal, 0, ",", ".") ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<hr />
					<h2>Deduction</h2>
					<table class="table table-bordered col-md-5 col-sm-12 col-xs-12">
						<?php $gajid = $this->db
							->where("gaji_id", $this->input->get("gaji_id"))
							->where("gajid_type", "1")
							->get("gajid");
						foreach ($gajid->result() as $gajid) { ?>
							<thead>
								<tr>
									<th>Deduction For</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<?= $gajid->gajid_name; ?>
									</td>
									<td><?= number_format($gajid->gajid_nominal, 0, ",", ".") ?></td>
								</tr>
							<?php } ?>
							</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-12">&nbsp;</div>
		</div>
	</div>
</body>

</html>
<script>
	window.print();
	setTimeout(function() {
		this.close();
	}, 500);
</script>