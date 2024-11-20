<?php
date_default_timezone_set("Asia/Bangkok");
$identity = $this->db->get("identity")->row();


function currentUrl($server)
{
	//Figure out whether we are using http or https.
	$http = 'http';
	//If HTTPS is present in our $_SERVER array, the URL should
	//start with https:// instead of http://
	if (isset($server['HTTPS'])) {
		$http = 'https';
	}
	//Get the HTTP_HOST.
	$host = $server['HTTP_HOST'];
	//Get the REQUEST_URI. i.e. The Uniform Resource Identifier.
	$requestUri = $server['REQUEST_URI'];
	//Finally, construct the full URL.
	//Use the function htmlentities to prevent XSS attacks.
	return $http . '://' . htmlentities($host) . '' . htmlentities($requestUri);
}

$currentUrl = currentUrl($_SERVER);

//cek user

$userd["user_id"] = $this->session->userdata("user_id");
if (current_url() != site_url("login") && current_url() != site_url("register")) {
	$us = $this->db
		->join("position", "position.position_id=user.position_id", "left")
		->get_where('user', $userd);
	//echo $this->db->last_query();die;	
	if ($us->num_rows() > 0) {
		foreach ($us->result() as $user) {
			foreach ($this->db->list_fields('user') as $field) {
				$data[$field] = $user->$field;
			}
			foreach ($this->db->list_fields('position') as $field) {
				$data[$field] = $user->$field;
			}
		}
	} else {
		$this->session->sess_destroy();
		redirect(site_url("login"));
	}
}
?>
<?php

function penyebut($nilai)
{
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}

function terbilang($nilai)
{
	if ($nilai < 0) {
		$hasil = "minus " . trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}
	return $hasil;
}


$angka = 1530093;
//echo terbilang($angka);
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $identity->identity_name; ?></title>
<link rel="icon" type="image/png" href="<?= base_url("assets/images/icon/" . $identity->identity_picture); ?>">
<script src="<?= base_url("assets/js/jquery-1.11.1.min.js"); ?>"></script>
<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/datepicker3.css'); ?>" rel="stylesheet">

<link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet">


<link href="<?= base_url('assets/css/animate.css'); ?>" rel="stylesheet">

<!--Icons-->
<script src="assets/js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->


<link href="<?= base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet">



<!-- <script type="text/javascript" src="<?= base_url('ckeditor/ckeditor.js'); ?>"></script> -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>




<link rel="stylesheet" href="<?= base_url('assets/css/screen.css'); ?>">
<script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.validate.js'); ?>"></script>


<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>


<link rel="stylesheet" href="<?= base_url('assets/css/jquery-ui.css'); ?>">
<script src="<?= base_url('assets/js/jquery-ui.js'); ?>"></script>

<link href="<?= base_url("assets/css/select2.min.css"); ?>" rel="stylesheet" />
<script src="<?= base_url("assets/js/select2.min.js"); ?>"></script>


<link href="<?= base_url('assets/css/jquery.dataTables.min.css'); ?>" rel="stylesheet">
<script src="<?= base_url("assets/js/jquery.dataTables.min.js"); ?>"></script>

<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/buttons.print.min.js"></script>
<script src="assets/js/jszip.min.js"></script>

<style>
	#dataTable {
		cursor: pointer;
	}

	.ui-datepicker-month,
	.ui-datepicker-year {
		border-radius: 5px !important;
		padding: 3px !important;
		border: none !important;
		margin: 3px !important;
	}

	[data-handler='selectDay'] {
		border-radius: 5px !important;
		border: none !important;
	}

	.border {
		border: black solid 1px;
	}

	body {
		font-family: 'Source Sans Pro', sans-serif;
	}

	.iconutama {
		font-size: 30px;
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}

	@media screen and (min-width: 481px) {
		#judulshow {
			display: none;
		}
	}

	@media screen and (max-width: 480px) {
		#judulatas {
			font-size: 10px !important;
		}

		#judulshow {
			display: inline;
		}

		.judulhide {
			display: none;
			text-shadow: white 0 0 10px;
		}

		#dashboard {
			margin-top: 50px;
		}
	}

	.parsend {
		border-bottom: #C9C9C9 solid 1px;
	}

	button {
		border-radius: 2px !important;
	}

	input[type=file] {
		border: none;
	}

	input[type=text]background-color:none !important;
	border:none !important;
	border-bottom:#AAB9FD solid 1px !important;
	border-radius:0px !important;
	box-shadow:none !important;
	}

	input[type=text]:focus {
		background-color: none !important;
		border: none !important;
		border-bottom: #AAB9FD solid 2px !important;
		border-radius: 0px !important;
		box-shadow: none !important;
	}

	.form-group>.control-label {
		text-align: left;
	}

	.backwhite {
		border-bottom: #F9F9FF solid 1px;
	}

	.delete {
		color: red !important;
	}

	div.dataTables_filter input {
		background-color: none !important;
		border: none !important;
		border-bottom: #F0F0F0 solid 1px !important;
		border-radius: 0px !important;
		box-shadow: none !important;
	}

	div.dataTables_filter input:focus {
		background-color: none !important;
		border: none !important;
		border-bottom: #F0F0F0 solid 2px !important;
		border-radius: 0px !important;
		box-shadow: none !important;
	}

	div.dataTables_length select {
		border: none !important;
		border-bottom: #F0F0F0 solid 1px !important;
		border-radius: 0px !important;
		box-shadow: none !important;
	}

	.dataTable {
		border-bottom: #E9E9E9 solid 1px !important;
	}

	div.callout {
		background: #F5F5F5;
		/* For browsers that do not support gradients */
		background: -webkit-linear-gradient(#F5F5F5, #FAFAFA);
		/* For Safari 5.1 to 6.0 */
		background: -o-linear-gradient(#F5F5F5, #FAFAFA);
		/* For Opera 11.1 to 12.0 */
		background: -moz-linear-gradient(#F5F5F5, #FAFAFA);
		/* For Firefox 3.6 to 15 */
		background: linear-gradient(#F5F5F5, #FAFAFA);
		/* Standard syntax */
		background-image: -moz-linear-gradient(top, #444, #444);
		position: relative;
		color: #048686;
		padding: 10px;
		border-radius: 5px;
		margin: 25px;
		min-height: 50px;
		border: 1px solid tranparent;
		font-family: 'Slabo 27px', serif !important;
		/*text-shadow: 0 0 1px #000;
		
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset;*/
	}

	.callout:hover {
		background: #5CC9DF;
		color: white !important;
	}

	.callout.left {
		box-shadow: -3px 3px 5px #EAEAEA;
	}

	.callout.right {
		box-shadow: 3px 3px 5px #EAEAEA;
	}

	.callout::before {
		content: "";
		width: 0px;
		height: 0px;
		border: white 20px solid;
		position: absolute;
	}

	.callout.left::before {
		right: -40px;
		top: 43%;
		border-left: 20px solid #F5F5F5;
	}

	.callout.right::before {
		left: -40px;
		top: 43%;
		border-right: 20px solid #F5F5F5;
	}

	.timeline-garis {
		position: absolute;
		top: 50%;
		left: 113%;
		//box-shadow: 0px 0px 25px #F5F5F5; 
		//border:#D6FAFE solid 2px; 
		border-radius: 50%;
		padding: 10px;
		font-size: 10px;
		background: #5CC9DF;
		text-align: center;
		cursor: pointer;
		font-size: 13px !important;
		z-index: 100;
	}

	.timeline-garisr {
		position: absolute;
		top: 50%;
		right: 112%;
		//box-shadow: 0px 0px 25px #F5F5F5; 
		//border:#D6FAFE solid 2px; 
		border-radius: 50%;
		padding: 10px;
		font-size: 10px;
		background: #5CC9DF;
		text-align: center;
		cursor: pointer;
		font-size: 13px !important;
		z-index: 100;
	}

	.img-circle {
		width: 70px;
		height: 70px;
	}

	.liticketno {
		background: #A8B9CB;
		/* For browsers that do not support gradients */
		background: -webkit-linear-gradient(#A8B9CB, #F0F0F0);
		/* For Safari 5.1 to 6.0 */
		background: -o-linear-gradient(#A8B9CB, #F0F0F0);
		/* For Opera 11.1 to 12.0 */
		background: -moz-linear-gradient(#A8B9CB, #F0F0F0);
		/* For Firefox 3.6 to 15 */
		background: linear-gradient(#A8B9CB, #F0F0F0);
		/* Standard syntax */
		padding-left: 10px !important;
		color: white;
	}

	#notification {
		display: none;
		text-align: center;
		border-radius: 5px;
		position: fixed;
		right: -10px;
		bottom: -10px;
		color: #000;
		padding: 10px;
		box-shadow: 0px 0px 20px #999;
		margin: 25px;
		min-height: 50px;
		border: #708BA9 3px solid;
		z-index: 1000 !important;
		background-color: #A7B8CA;
		background: -webkit-linear-gradient(#A7B8CA, #D8DFE7);
		background: -o-linear-gradient(#A7B8CA, #D8DFE7);
		background: -moz-linear-gradient(#A7B8CA, #D8DFE7);
		background: linear-gradient(#A7B8CA, #D8DFE7);
		display: none;
	}

	#notification::before {
		content: "";
		width: 0px;
		height: 0px;
		border: 0.8em solid transparent;
		position: absolute;
		right: -23px;
		top: 10%;
		border-left: 10px solid #A7B8CA;
	}

	.notifisi {
		background: white;
		padding: 0px;
		padding-bottom: 5px border-radius:5px;
	}

	.notifisijudul {
		padding: 5px;
		color: white;
		font-weight: bold;
		width: 100%;
	}

	.formnotif1 {
		margin-top: 5px;
	}

	.btnnotif {
		width: 100%;
		margin-top: -5px;
	}

	.backungu {
		background-color: #718CAA;
		background: -webkit-linear-gradient(#718CAA, #8A9FB8);
		background: -o-linear-gradient(#718CAA, #8A9FB8);
		background: -moz-linear-gradient(#718CAA, #8A9FB8);
		background: linear-gradient(#718CAA, #8A9FB8);
	}

	.breadcrumb {
		background-color: #B6BFD3 !important;
		background: -webkit-linear-gradient(#B6BFD3, #E9ECF2) !important;
		background: -o-linear-gradient(#B6BFD3, #E9ECF2) !important;
		background: -moz-linear-gradient(#B6BFD3, #E9ECF2) !important;
		background: linear-gradient(#B6BFD3, #E9ECF2) !important;
	}

	.breadcrumb>li,
	.breadcrumb>li>a {

		text-shadow: white 1px 1px 1px;
	}

	.nav.menu {
		padding: 0px;
		margin: 0px;
	}

	.nav.menu>li>ul {
		list-style: none;
	}

	.nav.menu>li>a {
		color: #6B7C91 !important;
	}

	.nav.menu>li {
		padding: 0px !important;
		margin: 0px;
	}

	.nav.menu>li.active>a {
		background-color: #A5AFC9 !important;
		background: -webkit-linear-gradient(#A5AFC9, #E9ECF2) !important;
		background: -o-linear-gradient(#A5AFC9, #E9ECF2) !important;
		background: -moz-linear-gradient(#A5AFC9, #E9ECF2) !important;
		background: linear-gradient(#A5AFC9, #E9ECF2) !important;
		color: white !important;
	}

	.marginkirikanan {
		margin-left: 10px;
		margin-right: 10px;
	}

	.ellipsis {
		overflow: hidden !important;
		text-overflow: ellipsis !important;
		word-wrap: break-word !important;
	}

	div::-webkit-scrollbar {
		background: transparent;
	}

	#chat-content {
		height: 500px;
	}

	.toggle {
		display: none;
	}

	.menufa {
		margin-right: 15px;
	}

	.border-grey {
		border-radius: 5px;
		padding: 20px;
		margin-bottom: 15px;
		box-shadow: #F2F2F2 0px 0px 5px;
	}

	.formedit {
		margin: 50px !important;
		padding: 50px !important;
		border-radius: 5px;
		border: rgba(220, 220, 220, 0.6) solid 1px;
	}

	.lead {
		padding: 10px !important;
		background-color: rgba(220, 220, 220, 0.3);
		border-radius: 5px;
		border: rgba(220, 220, 220, 0.6) solid 1px;
		text-align: center;
		text-shadow: white 1px 1px 1px;
		box-shadow: rgba(220, 220, 220, 0.3) 0px 1px 1px 1px
	}

	.formlead {
		padding: 70px !important;
		background-color: rgba(240, 240, 240, 0.3);
		border-radius: 5px;
		border: rgba(220, 220, 220, 0.6) solid 1px;
		text-align: center;
		text-shadow: white 1px 1px 1px;
	}

	table>thead>tr>th {
		text-align: center;
	}

	table>tbody>tr>td {
		padding: 3px;
		font-size: 12px;
		text-align: center;
	}

	.sub1 {
		margin-right: 10px;
	}

	.p-1 {
		padding: 5px;
	}

	.p-2 {
		padding: 10px;
	}



	.tarik:active {
		cursor: grabbing;
		/* Gambar tangan saat mengklik */
	}

	.tarik {
		overflow: auto;
		white-space: nowrap;
		cursor: grab;
	}

	.tarik * table {
		border-collapse: collapse;
		width: 100%;
	}


	td {
		transition: background-color 0.3s ease;
		/* Efek transisi halus */
	}

	td:hover {
		background-color: #d3d3d3;
		/* Warna abu-abu lembut */
		color: #333;
		/* Warna teks lebih gelap jika diinginkan */
	}

	tr {
		transition: background-color 0.3s ease;
	}

	/* Warna seluruh baris berubah saat di-hover */
	tr:hover {
		background-color: #d3d3d3 !important;
		/* Warna abu-abu lembut */
		color: #333 !important;
		/* Warna teks lebih gelap jika diinginkan */
	}
</style>

<script>
	const formatter = new Intl.NumberFormat('in-IN', {
		style: 'currency',
		currency: 'IDR',
		minimumFractionDigits: 2
	})

	$(document).ready(function() {
		$('#dataTable').DataTable({
			"order": [
				[0, "asc"]
			],
			"iDisplayLength": 25
		});

		$('#dataTableinv').DataTable({
			"order": [
				[2, "desc"],
				[0, "asc"]
			],
			"iDisplayLength": 25
		});

		$('#parameter').DataTable({
			"order": [
				[3, "asc"],
				[4, "desc"],
				[2, "desc"]
			],
			"iDisplayLength": 25
		});

		$('#dataTable1').DataTable({
			"order": [
				[0, "desc"]
			],
			"iDisplayLength": 25
		});

		$(".date").attr("autocomplete", "off");

	});

	function datatable(a, b, c) {
		//a = id/class table
		//b = colom berapa
		//c = asc/desc
		//datatable('#dataTable',0,'desc')
		$(a).DataTable({
			"order": [
				[b, c]
			],
			"iDisplayLength": 25
		});
	}
</script>
<script>
	$(document).ready(function() {

		$("form").validate();




	});

	function bounceIn(a) {
		$(a).addClass('animated bounceIn').parent().parent().addClass('animated bounceIn');
		setTimeout(function() {
			$(a).removeClass('animated bounceIn').parent().parent().removeClass('animated bounceIn');
		}, 500);
	}



	! function($) {
		$(document).on("click", "ul.nav li.parent > a > span.icon", function() {
			$(this).find('em:first').toggleClass("glyphicon-minus");
		});
		$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
	}(window.jQuery);

	$(window).on('resize', function() {
		if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
	})

	$(window).on('resize', function() {
		if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
	})

	funtion bukasub() {
		$('.sub-item-1').collapse('show');
	}
</script>