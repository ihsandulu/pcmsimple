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
			font-size: 10px;
			padding:1px !important;
		}

		.tengah {
			position: relative;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			font-weight: bold;
			font-size: 17px;
			text-align: center;
		}
		.pl-1{padding-left: 5px!important;}
	</style>
</head>

<body>
	<div class="container">
		<div class="row">

			<?php
			$identity = $this->db->get("identity")->row();
			/* if ($identity->identity_kop == 1) {
				require_once("kop.php");
			} */
			?>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:10px;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="font-weight:bold; font-size:13px;"><?= $identity_company; ?></div>
				<div class="col-md-12 col-sm-12 col-xs-12"><?= $identity_address; ?></div>
				<div class="col-md-12 col-sm-12 col-xs-12"><?= $identity_phone; ?></div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-2" style="padding-top: 15px !important;  text-align: center; font-weight:bold; font-size:15px;">Payroll
			</div>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:10px;">
				<div class="col-md-3 col-sm-3 col-xs-3">No.</div>
				<div class="col-md-9 col-sm-9 col-xs-9">: <?= $gaji_no; ?></div>
				<div class="col-md-3 col-sm-3 col-xs-3">Name</div>
				<div class="col-md-9 col-sm-9 col-xs-9">: <?= $gaji_name; ?></div>
				<div class="col-md-3 col-sm-3 col-xs-3">Month</div>
				<div class="col-md-9 col-sm-9 col-xs-9">: <?= date("M Y", strtotime($gaji_datetime)); ?></div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; font-weight:bold; font-size:1px;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:1px; border-top: black solid 1px !important;">&nbsp;</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6" style="font-size:10px;">
				<div class="col-md-2 col-sm-2 col-xs-2">Name</div>
				<div class="col-md-10 col-sm-10 col-xs-10">: <?= $gaji_name; ?></div>
				<div class="col-md-2 col-sm-2 col-xs-2">Position</div>
				<div class="col-md-10 col-sm-10 col-xs-10">: <?= $position_name; ?></div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6" style="font-size:10px;">
				<div class="col-md-2 col-sm-2 col-xs-2">Phone</div>
				<div class="col-md-10 col-sm-10 col-xs-10">: <?= $user_wa; ?></div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; font-weight:bold; font-size:1px;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:1px; border-top: black solid 1px !important;">&nbsp;</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; margin:0px;">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<table class="col-md-12 col-sm-12 col-xs-12" border="1">
						<thead>
							<tr>
								<th>No.</th>
								<th>Description</th>
								<th>Nominal</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$gajid = $this->db
								->join("gaji", "gaji.gaji_id=gajid.gaji_id", "left")
								->where("gajid.gaji_id", $this->input->get("gaji_id"))
								->get("gajid");
							$upah = 0;
							$biaya = 0;
							$tnominalinv = 0;
							$nett = 0;
							foreach ($gajid->result() as $gajid) {
								$tnominalinv = $gajid->gaji_tnominalinv;
								if ($gajid->gajid_type == 0) {
									$upah += $gajid->gajid_nominal;
									$nett = $gajid->gajid_nett;
								} else {
									$biaya += $gajid->gajid_nominal;
								}
							} ?>
							<tr>
								<td>1</td>
								<td class="text-left pl-1"> Gross Income</td>
								<td><?= number_format($tnominalinv, 0, ",", ".") ?></td>
							</tr>
							<tr>
								<td>2</td>
								<td class="text-left pl-1"> Nett Income</td>
								<td><?= number_format($nett, 0, ",", ".") ?></td>
							</tr>
							<tr>
								<td>3</td>
								<td class="text-left pl-1"> Nett Income + Modal + Tips</td>
								<td><?= number_format($upah, 0, ",", ".") ?></td>
							</tr>
							<tr>
								<td>4</td>
								<td class="text-left pl-1"> Loan</td>
								<td><?= number_format($biaya, 0, ",", ".") ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center; font-weight:bold; font-size:1px;">
					<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:1px; border-top: black solid 1px !important;">&nbsp;</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<table class="table col-md-12 col-sm-12 col-xs-12">
						<thead>
							<tr>
								<th colspan="2" class="text-left pl-1"> Take Home Pay</th>
								<th><?= number_format($upah - $biaya, 0, ",", ".") ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6" style="font-size:10px;">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">Recipient</div>
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">&nbsp;<br/><br/><br/></div>
				<div class="col-md-12 col-sm-12 col-xs-12 text-center"><?= $gaji_name; ?></div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6" style="font-size:10px;">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center"><?=date("Y-m-d");?></div>
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">&nbsp;<br/><br/><br/></div>
				<div class="col-md-12 col-sm-12 col-xs-12 text-center"><?= $identity_company; ?></div>
			</div>
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