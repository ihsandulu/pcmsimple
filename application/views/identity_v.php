<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php"); ?>
	<style>
		.keterangan {
			font-size: 10px;
			color: #FF0000;
			margin-bottom: 25px;
		}
	</style>
</head>

<body class="  ">
	<?php require_once("header.php"); ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home">
							<use xlink:href="#stroked-home"></use>
						</svg></a></li>
				<li class="active">Identity</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Identity</h1>
			</div>
			<!--<?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="identity_id"/>
				</h1>
			</form>
			<?php } ?>-->
		</div>


		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
							<div class="">
								<?php if (isset($_POST['edit'])) {
									$namabutton = 'name="change"';
									$judul = "Update Identity";
								} else {
									$namabutton = 'name="create"';
									$judul = "New Identity";
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_name">Application Name:</label>
										<div class="col-sm-10">
											<input type="text" autofocus class="form-control" id="identity_name" name="identity_name" placeholder="Enter Name of Application" value="<?= $identity_name; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_company">Company:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_company" name="identity_company" placeholder="Enter Company" value="<?= $identity_company; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_slogan">Motto:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_slogan" name="identity_slogan" placeholder="Enter Motto" value="<?= $identity_slogan; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_services">Services:</label>
										<div class="col-sm-10">
											<textarea name="identity_services" id="identity_services"></textarea>
											<script>
												ClassicEditor
													.create(document.querySelector('#identity_services'))
													.then(editor => {
														editor.setData('<?= $identity_services; ?>');
														editor.ui.view.editable.element.style.height = '120px';
													})
													.catch(error => {
														console.error(error);
													});
											</script>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_payment">Payment:</label>
										<div class="col-sm-10">
											<textarea name="identity_payment" id="identity_payment"></textarea>
											<script>
												ClassicEditor
													.create(document.querySelector('#identity_payment'))
													.then(editor => {
														editor.setData('<?= $identity_payment; ?>');
														editor.ui.view.editable.element.style.height = '120px';
													})
													.catch(error => {
														console.error(error);
													});
											</script>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_note">Note:</label>
										<div class="col-sm-10">
											<textarea name="identity_note" id="identity_note"></textarea>
											<script>
												ClassicEditor
													.create(document.querySelector('#identity_note'))
													.then(editor => {
														editor.setData('<?= $identity_note; ?>');
														editor.ui.view.editable.element.style.height = '120px';
													})
													.catch(error => {
														console.error(error);
													});
											</script>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_email">Email:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_email" name="identity_email" placeholder="Enter Email" value="<?= $identity_email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_kirimemail">Send Email:</label>
										<div class="col-sm-10">
											<select name="identity_kirimemail" id="identity_kirimemail" class="form-control">
												<option value="0" <?= ($identity_kirimemail == 0) ? "selected" : ""; ?>>Not Sent</option>
												<option value="1" <?= ($identity_kirimemail == 1) ? "selected" : ""; ?>>Sending Email</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_city">City:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_city" name="identity_city" placeholder="Enter City" value="<?= $identity_city; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_address">Address:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_address" name="identity_address" placeholder="Enter Address" value="<?= $identity_address; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_phone">Phone:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_phone" name="identity_phone" placeholder="Enter Phone" value="<?= $identity_phone; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_fax">Fax:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_fax" name="identity_fax" placeholder="Enter Fax" value="<?= $identity_fax; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_cp">Contact Person:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_cp" name="identity_cp" placeholder="Enter CP" value="<?= $identity_cp; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_npwp">NPWP:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_npwp" name="identity_npwp" placeholder="Enter NPWP" value="<?= $identity_npwp; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_web">Web:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="identity_web" name="identity_web" placeholder="Enter Site" value="<?= $identity_web; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_stempel">Stempel:</label>
										<div class="col-sm-10">
											<select name="identity_stempel" id="identity_stempel" class="form-control">
												<option value="0" <?= ($identity_stempel == 0) ? "selected" : ""; ?>>No</option>
												<option value="1" <?= ($identity_stempel == 1) ? "selected" : ""; ?>>Yes</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Stempel dan tandatangan otomatis)</label>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_kop">Kop Surat:</label>
										<div class="col-sm-10">
											<select name="identity_kop" id="identity_kop" class="form-control">
												<option value="0" <?= ($identity_kop == 0) ? "selected" : ""; ?>>No</option>
												<option value="1" <?= ($identity_kop == 1) ? "selected" : ""; ?>>Yes</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Dengan Kop Surat)</label>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_dimension">Dimension Product:</label>
										<div class="col-sm-10">
											<select name="identity_dimension" id="identity_dimension" class="form-control">
												<option value="0" <?= ($identity_dimension == 0) ? "selected" : ""; ?>>No</option>
												<option value="1" <?= ($identity_dimension == 1) ? "selected" : ""; ?>>Yes</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Apakah product dalam invoice mempunyai dimensi (Panjang x Lebar x Tinggi)?)</label>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_stok">Stok:</label>
										<div class="col-sm-10">
											<select name="identity_stok" id="identity_stok" class="form-control">
												<option value="0" <?= ($identity_stok == 0) ? "selected" : ""; ?>>Stok dr SJ dan Manual Stok</option>
												<option value="1" <?= ($identity_stok == 1) ? "selected" : ""; ?>>Stok dr Invoice dan Manual Stok</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Pertambahan dan pengurangan stok pada gudang dipengaruhi oleh Surat Jalan Barang / Invoice)</label>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_project">Orientation:</label>
										<div class="col-sm-10">
											<select name="identity_project" id="identity_project" class="form-control">
												<option value="0" <?= ($identity_project == 0) ? "selected" : ""; ?>>Without Project</option>
												<option value="1" <?= ($identity_project == 1) ? "selected" : ""; ?>>With Project</option>
												<option value="2" <?= ($identity_project == 2) ? "selected" : ""; ?>>Product Orientation</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Oriantasi aplikasi berdasarkan Project / Tanpa Project / Penjualan Produk)</label>
									</div>


									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_showproduct">Show product from :</label>
										<div class="col-sm-10">
											<select class="form-control" name="identity_showproduct" id="identity_showproduct">
												<option value="0" <?= ($identity_showproduct == 0) ? "selected" : ""; ?>>Pilih product yg akan ditampilkan</option>
												<option value="1" <?= ($identity_showproduct == 1) ? "selected" : ""; ?>>From Master Product</option>
												<option value="2" <?= ($identity_showproduct == 2) ? "selected" : ""; ?>>From Project</option>
											</select>
										</div>
									</div>


									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_number">Numbering:</label>
										<div class="col-sm-10">
											<select name="identity_number" id="identity_number" class="form-control">
												<option value="Monthly" <?= ($identity_number == "Monthly") ? "selected" : ""; ?>>Monthly</option>
												<option value="Yearly" <?= ($identity_number == "Yearly") ? "selected" : ""; ?>>Yearly</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Penomoran akan berganti berdasarkan bulanan / tahunan)</label>
									</div>
									<div class="form-group setting">
										<label class="control-label col-sm-2" for="identity_projectwith">Project With:</label>
										<div class="col-sm-10">
											<select name="identity_projectwith" id="identity_projectwith" class="form-control">
												<option value="0" <?= ($identity_projectwith == 0) ? "selected" : ""; ?>>Customer</option>
												<option value="1" <?= ($identity_projectwith == 1) ? "selected" : ""; ?>>Vendor</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Dengan siapa kerjasama project dilakukan)</label>
									</div>
									<div class="form-group setting">
										<label class="control-label col-sm-2" for="identity_productsupplier">Invoice Product Supplier Category:</label>
										<div class="col-sm-10">
											<select name="identity_productsupplier" id="identity_productsupplier" class="form-control">
												<option value="0" <?= ($identity_productsupplier == 0) ? "selected" : ""; ?>>Global</option>
												<option value="1" <?= ($identity_productsupplier == 1) ? "selected" : ""; ?>>Per Supplier</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Kategori product pada supplier)</label>
									</div>
									<div class="form-group setting">
										<label class="control-label col-sm-2" for="identity_productcustomer">Invoice Product Customer Category:</label>
										<div class="col-sm-10">
											<select name="identity_productcustomer" id="identity_productcustomer" class="form-control">
												<option value="0" <?= ($identity_productcustomer == 0) ? "selected" : ""; ?>>Global</option>
												<option value="1" <?= ($identity_productcustomer == 1) ? "selected" : ""; ?>>Per Customer</option>
												<option value="2" <?= ($identity_productcustomer == 2) ? "selected" : ""; ?>>Per Vendor</option>
												<option value="3" <?= ($identity_productcustomer == 3) ? "selected" : ""; ?>>Per Project</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Kategori product pada customer)</label>
									</div>
									<div class="form-group setting">
										<label class="control-label col-sm-2" for="identity_saldocustomer">Customer Saldo:</label>
										<div class="col-sm-10">
											<select name="identity_saldocustomer" id="identity_saldocustomer" class="form-control">
												<option value="0" <?= ($identity_saldocustomer == 0) ? "selected" : ""; ?>>No</option>
												<option value="1" <?= ($identity_saldocustomer == 1) ? "selected" : ""; ?>>Yes</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Apakah Customer mempunyai product tertentu?)</label>
									</div>
									<div class="form-group setting">
										<label class="control-label col-sm-2" for="identity_lockproduct">Lock Product:</label>
										<div class="col-sm-10">
											<select name="identity_lockproduct" id="identity_lockproduct" class="form-control">
												<option value="0" <?= ($identity_lockproduct == 0) ? "selected" : ""; ?>>No</option>
												<option value="1" <?= ($identity_lockproduct == 1) ? "selected" : ""; ?>>Yes</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Apakah produk akan dikunci percustomer persales?)</label>
									</div>
									<div class="form-group setting">
										<label class="control-label col-sm-2" for="identity_simple">Payment Simple:</label>
										<div class="col-sm-10">
											<select name="identity_simple" id="identity_simple" class="form-control">
												<option value="0" <?= ($identity_simple == 0) ? "selected" : ""; ?>>No</option>
												<option value="1" <?= ($identity_simple == 1) ? "selected" : ""; ?>>Yes</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Payment tergabung dalam Invoice dan otomatis create surat jalan keluar)</label>
									</div>
									<div class="form-group setting">
										<label class="control-label col-sm-2" for="identity_duedate">Alert Due Date Invoice:</label>
										<div class="col-sm-10">
											<select name="identity_duedate" id="identity_duedate" class="form-control">
												<option value="0" <?= ($identity_duedate == 0) ? "selected" : ""; ?>>No</option>
												<option value="1" <?= ($identity_duedate == 1) ? "selected" : ""; ?>>Yes</option>
											</select>
										</div>
										<label class="control-label col-sm-12 keterangan">(Batas akhir invoice ditampilkan?)</label>
									</div>
									<!--<div class="form-group setting">
								<label class="control-label col-sm-2" for="identity_pelunasan">Pelunasan:</label>
								<div class="col-sm-10">
								  <select name="identity_pelunasan" id="identity_pelunasan" class="form-control">
								  	<option value="0" <?= ($identity_saldocustomer == 0) ? "selected" : ""; ?>>Payment</option>
								  	<option value="1" <?= ($identity_saldocustomer == 1) ? "selected" : ""; ?>>Invoice</option>
								  </select>
								</div>
								<label class="control-label col-sm-12 keterangan">(Pelunasan dengan Payment/Invoice)</label>
							  </div>-->

									<div class="form-group">
										<label class="control-label col-sm-2" for="identity_picture">Picture:</label>
										<div class="col-sm-10" align="left">
											<input type="file" id="identity_picture" name="identity_picture"><br />
											<?php if ($identity_picture != "") {
												$user_image = "assets/images/identity_picture/" . $identity_picture;
											} else {
												$user_image = "assets/images/identity_picture/image.gif";
											} ?>
											<img id="identity_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
											<script>
												function readURL(input) {
													if (input.files && input.files[0]) {
														var reader = new FileReader();

														reader.onload = function(e) {
															$('#identity_picture_image').attr('src', e.target.result);
														}

														reader.readAsDataURL(input.files[0]);
													}
												}

												$("#identity_picture").change(function() {
													readURL(this);
												});
											</script>
										</div>
									</div>

									<input type="hidden" name="identity_id" value="<?= $identity_id; ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("identity"); ?>">Back</button>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadidentity_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>identity</th>
												<th>Email</th>
												<th>Address</th>
												<th>Phone</th>
												<th>CP</th>
												<th class="col-md-1">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $usr = $this->db
												->order_by("identity_id", "desc")
												->get("identity");
											$no = 1;
											foreach ($usr->result() as $identity) { ?>
												<tr>
													<td><?= $no++; ?></td>
													<td><?= $identity->identity_name; ?></td>
													<td><?= $identity->identity_email; ?></td>
													<td><?= $identity->identity_address; ?></td>
													<td><?= $identity->identity_phone; ?></td>
													<td><?= $identity->identity_cp; ?></td>
													<td style="padding-left:0px; padding-right:0px;">

														<!--<form method="post" class="" style="padding:0px; margin:2px; float:right;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="identity_id" value="<?= $identity->identity_id; ?>"/>
												</form>	-->

														<form method="post" class="" style="padding:0px; margin:2px; float:right;">
															<button class="btn btn-sm btn-warning" name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
															<input type="hidden" name="identity_id" value="<?= $identity->identity_id; ?>" />
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