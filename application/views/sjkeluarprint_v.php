<!DOCTYPE html>
<html>

<head>
	<title>Print SJ Keluar</title>
	<meta charset="utf-8">
	<meta name="viewsjkeluarrt" content="width=device-width, initial-scale=1">
	<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<script src="<?= base_url("assets/js/jquery-1.11.1.min.js"); ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
	<style>
		.border {
			border: black solid 1px;
		}

		.besar {
			font-size: 12px;
			font-weight: bold;
		}

		.kecil {
			font-size: 10px;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row">
			<div style="margin-bottom:0px;">

				<?php
				$identity = $this->db->get("identity")->row();
				if ($identity->identity_kop == 1) {
					require_once("kop.php");
				}
				?>
				<div style="font-weigh:bold; font-size:15px; text-decoration: underline;">SURAT JALAN</div>
				<div class="col-md-8 col-sm-8 col-xs-8" style="padding:0px;">
					<div class="col-md-6 col-sm-6 col-xs-6 text-left kecil" style="padding:0px;">
						<div class="col-md-12 col-sm-12 col-xs-12 text-left kecil" style="padding:0px;">Jenis Kendaraan : <?= $sjkeluar_ekspedisi; ?></div>
						<div class="col-md-12 col-sm-12 col-xs-12 text-left kecil" style="padding:0px;">No. Pol. : <?= $sjkeluar_nopol; ?></div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-left kecil" style="border-left:black solid 1 px;">Payment : <?= $methodpayment_name; ?></div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-left besar" style="border-left:black solid 1 px;">No. SJ : <?= $sjkeluar_no; ?></div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4" style="padding-left:10px;">
					<div class="col-md-12 col-sm-12 col-xs-12 besar"><?= $identity_city; ?>, <?= date("d, M Y", strtotime($sjkeluar_date)); ?></div>
					<div class="col-md-12 col-sm-12 col-xs-12 besar">Kepada Yth</div>
					<div class="col-md-12 col-sm-12 col-xs-12 kecil"><?= $customer_name; ?></div>
					<div class="col-md-12 col-sm-12 col-xs-12 kecil"><?= $customer_address; ?></div>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; margin-top:20px;">
				<table class="col-md-12 col-sm-12 col-xs-12" border="1">
					<tr>
						<th style="text-align:center;">No</th>
						<th style="text-align:center;">Description</th>
						<th style="text-align:center;">Qty</th>
					</tr>
					<?php
					$no = 1;
					$to = 0;
					$prod = $this->db
						->join("product", "product.product_id=sjkeluarproduct.product_id", "left")
						->where("sjkeluar_no", $this->input->get("sjkeluar_no"))
						->get("sjkeluarproduct");
					foreach ($prod->result() as $product) { ?>
						<tr>
							<td style="text-align:center;"><?= $no++; ?>&nbsp;</td>
							<td style="text-align:center;"><?= $product->product_name; ?>&nbsp;</td>
							<td style="text-align:center;"><?= $product->sjkeluarproduct_qty; ?>&nbsp;</td>
						</tr>
					<?php } ?>

				</table>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:10px;">
				<div align="center">Tanda Terima :</div>
				<div align="center" class="besar"><?= $customer_name; ?></div>
				<div style="height:50px;">&nbsp;</div>
				<div align="center" class="kecil"><?= $sjkeluar_penerima; ?>&nbsp;</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:10px;">
				<div align="center">Hormat Kami :</div>
				<div align="center" class="besar"><?= $identity_company; ?></div>
				<div style="height:50px;">&nbsp;</div>
				<div align="center" class="kecil"><?= $sjkeluar_pengirim; ?>&nbsp;</div>
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