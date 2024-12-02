<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php"); ?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<style>
		#map {
			height: 400px;
			width: 100%;
		}

		input,
		button {
			margin: 5px 0;
			width: 100%;
			padding: 8px;
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
												<input type="text" <?= $disabled; ?> class="form-control" id="customer_saldo" name="customer_saldo" placeholder="Saldo Customer" value="<?= $customer_saldo; ?>">
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
										<label class="control-label col-sm-2" for="hunian_id">Hunian:</label>
										<div class="col-sm-10">
											<select class="form-control" id="hunian_id" name="hunian_id">
												<option value="" <?= ($hunian_id == "") ? "selected" : ""; ?>>Pilih Hunian</option>
												<?php $hunian = $this->db->get("hunian");
												foreach ($hunian->result() as $hunian) {
												?>
													<option value="<?= $hunian->hunian_id; ?>" <?= ($hunian_id == $hunian->hunian_id) ? "selected" : ""; ?>><?= $hunian->hunian_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_email">Customer Email:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Enter Email" value="<?= $customer_email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_country">Country:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_country" name="customer_country" placeholder="Enter Country" value="<?= ($customer_country!="")?$customer_country:"Indonesia"; ?>">
										</div>
									</div>


									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_phone">Phone:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Phone" value="<?= $customer_phone; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_fax">Fax:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_fax" name="customer_fax" placeholder="Enter Fax" value="<?= $customer_fax; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_cp">Contact Person:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_cp" name="customer_cp" placeholder="Enter CP" value="<?= $customer_cp; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_wa">Whatsapp:<br /><span style="font-size:10px; color:red;">(wajib berawalan 62 di depan tanpa +)</span></label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_wa" name="customer_wa" placeholder="62xxxxx" value="<?= $customer_wa; ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="provinsi_id">Provinsi:</label>
										<div class="col-sm-10">
											<select onchange="pilihinkota()" class="form-control select2" id="provinsi_id" name="provinsi_id">
												<option  data-name="" value="" <?= ($provinsi_id == "") ? "selected" : ""; ?>>Pilih Provinsi</option>
												<?php $provinsi = $this->db->order_by("provinsi_name", "ASC")->get("provinsi");
												foreach ($provinsi->result() as $provinsi) { ?>
													<option  data-name="<?= $provinsi->provinsi_name; ?>" value="<?= $provinsi->provinsi_id; ?>" <?= ($provinsi_id == $provinsi->provinsi_id) ? "selected" : ""; ?>><?= $provinsi->provinsi_name; ?></option>
												<?php } ?>
											</select>			
											<input type="hidden" id="provinsi_name" />
											<script>
												function pilihinkota() {
													let provinsi_id = $("#provinsi_id").val();
													// alert("<?= base_url("api/pilihinkota"); ?>?provinsi_id="+provinsi_id+"&kota_id=0");
													$.get("<?= base_url("api/pilihinkota"); ?>", {
															provinsi_id: provinsi_id,
															kota_id: '0'
														})
														.done(function(data) {
															$("#kota_id").html(data);
															
															const provinsiDropdown = $("#provinsi_id");
															let provinsiname = provinsiDropdown.find("option:selected").data("name");
															$("#provinsi_name").val(provinsiname);
															isimaps();
															// alert(data);
														});
												}
											</script>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="kota_id">Kota:</label>
										<div class="col-sm-10">
											<select onchange="pilihinkecamatan()" class="form-control select2" id="kota_id" name="kota_id">
												<option  data-name="" value="" <?= ($kota_id == "") ? "selected" : ""; ?>>Pilih Kota</option>
												<?php
												$kota = $this->db->order_by("kota_name", "ASC")->get("kota");
												foreach ($kota->result() as $kota) { ?>
													<option data-name="<?= $kota->kota_name; ?>"  value="<?= $kota->kota_id; ?>" <?= ($kota_id == $kota->kota_id) ? "selected" : ""; ?>><?= $kota->kota_name; ?></option>
												<?php } ?>
											</select>											
											<input type="hidden" id="kota_name" />
											<script>
												function pilihinkecamatan() {
													let kota_id = $("#kota_id").val();
													// alert("<?= base_url("api/pilihinkecamatan"); ?>?kota_id="+kota_id+"&kecamatan_id=0");
													$.get("<?= base_url("api/pilihinkecamatan"); ?>", {
															kota_id: kota_id,
															kecamatan_id: '0'
														})
														.done(function(data) {
															$("#kecamatan_id").html(data);

															
															const kotaDropdown = $("#kota_id");
															let kotaname = kotaDropdown.find("option:selected").data("name");
															$("#kota_name").val(kotaname);
															isimaps();
															// alert(data);
														});
												}
											</script>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="kecamatan_id">Kecamatan:</label>
										<div class="col-sm-10">
											<select onchange="pilihinkelurahan();" class="form-control select2" id="kecamatan_id" name="kecamatan_id">
												<option data-name="" data-code="" value="" <?= ($kecamatan_id == "") ? "selected" : ""; ?>>Pilih Kecamatan</option>
												<?php
												$kecamatan = $this->db->order_by("kecamatan_name", "ASC")
													->where("kota_id", $kota_id)
													->get("kecamatan");
												foreach ($kecamatan->result() as $kecamatan) { ?>
													<option data-name="<?= $kecamatan->kecamatan_name; ?>" data-code="<?= $kecamatan->kecamatan_code; ?>" value="<?= $kecamatan->kecamatan_id; ?>" <?= ($kecamatan_id == $kecamatan->kecamatan_id) ? "selected" : ""; ?>><?= $kecamatan->kecamatan_name; ?></option>
												<?php } ?>
											</select>
											<input type="hidden" id="kecamatan_code" />
											<input type="hidden" id="kecamatan_name" />
											<script>
												function pilihinkelurahan() {
													let kecamatan_id = $("#kecamatan_id").val();
													// alert("<?= base_url("api/pilihinkelurahan"); ?>?kecamatan_id="+kecamatan_id+"&kelurahan_id=0");
													$.get("<?= base_url("api/pilihinkelurahan"); ?>", {
															kecamatan_id: kecamatan_id,
															kelurahan_id: '0'
														})
														.done(function(data) {
															$("#kelurahan_id").html(data);

															const kecamatanDropdown = $("#kecamatan_id");
															let kecamatancode = kecamatanDropdown.find("option:selected").data("code");
															$("#kecamatan_code").val(kecamatancode);

															let kecamatanname = kecamatanDropdown.find("option:selected").data("name");
															$("#kecamatan_name").val(kecamatanname);
															isicustomercode();
															isimaps();
															// alert(data);
														});
												}
											</script>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="kelurahan_id">Kelurahan:</label>
										<div class="col-sm-10">
											<select onchange="isikelurahancode();isicustomercode();" class="form-control select2" id="kelurahan_id" name="kelurahan_id">
												<option data-name="" data-code="" value="" <?= ($kelurahan_id == "") ? "selected" : ""; ?>>Pilih Kelurahan</option>
												<?php
												$kelurahan = $this->db->order_by("kelurahan_name", "ASC")
													->where("kecamatan_id", $kecamatan_id)
													->get("kelurahan");
												foreach ($kelurahan->result() as $kelurahan) { ?>
													<option data-name="<?= $kelurahan->kelurahan_name; ?>" data-code="<?= $kelurahan->kelurahan_code; ?>" value="<?= $kelurahan->kelurahan_id; ?>" <?= ($kelurahan_id == $kelurahan->kelurahan_id) ? "selected" : ""; ?>><?= $kelurahan->kelurahan_name; ?></option>
												<?php } ?>
											</select>
											<input filetype="hidden" id="kelurahan_code" />
											<input filetype="hidden" id="kelurahan_name" />
											<script>
												function isikelurahancode() {
													const kelurahanDropdown = $("#kelurahan_id");
													let kelurahancode = kelurahanDropdown.find("option:selected").data("code");
													$("#kelurahan_code").val(kelurahancode);

													let kelurahanname = kelurahanDropdown.find("option:selected").data("name");
													$("#kelurahan_name").val(kelurahanname);
													isicustomercode();
													isimaps();
												}
											</script>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_code">Customer Code:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_code" name="customer_code" placeholder="Enter code" value="<?= $customer_code; ?>">
										</div>
										<script>
											function isicustomercode() {
												let customer_name = $("#customer_name").val();
												let firstSevenChars = customer_name.slice(0, 7);
												let kecamatancode = $("#kecamatan_code").val();
												let kelurahancode = $("#kelurahan_code").val();
												let customerwa = $("#customer_wa").val();
												let tigacustomerwa = customerwa.slice(-3);
												let hasil = firstSevenChars + '-' + kecamatancode + kelurahancode + tigacustomerwa;
												$("#customer_code").val(hasil);												
											}

											function isimaps(){
												let provinsi_name = $("#provinsi_name").val();
												let kotaname = $("#kota_name").val();
												let kecamatanname = $("#kecamatan_name").val();
												let kelurahanname = $("#kelurahan_name").val();
												let hasilmaps = kelurahanname + ',' + kecamatanname + ',' + kotaname + ',' + provinsi_name;
												$("#customer_maps").val(hasilmaps);
											}
										</script>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_address">Customer Address:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="Enter Address" value="<?= $customer_address; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_maps">Maps:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_maps" name="customer_maps" placeholder="Enter Address" value="<?= $customer_maps; ?>">
										</div>
										<button type="button" id="searchAddress">Cari Alamat</button>
										<div id="map"></div>
										<input type="text" name="customer_location" id="customer_location" readonly placeholder="Koordinat (latitude, longitude)" value="<?= $customer_location; ?>" />

										<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
										<script>
											$(document).ready(function() {
												$('input[name="customer_maps"]').on('keydown', function(e) {
													if (e.key === "Enter") {
														e.preventDefault(); // Mencegah aksi default (submit)
														$("#searchAddress").click();
													}
												});

												function reverseGeocode(lat, lon) {
													const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
													$.getJSON(url, function(data) {
														if (data && data.address) {
															const address = [
																data.address.road || '',
																data.address.city || '',
																data.address.state || '',
																data.address.postcode || '',
																data.address.country || ''
															].filter(Boolean).join(', ');
															$('#customer_maps').val(address); // Isi input alamat
														} else {
															$('#customer_maps').val('Alamat tidak ditemukan');
														}
													}).fail(function() {
														$('#customer_maps').val('Gagal mendapatkan alamat');
													});
												}

												// Inisialisasi peta
												<?php
												if ($customer_location == "") {
													$location = "-6.200000, 106.816666";
												} else {
													$location = $customer_location;
												} ?>
												const map = L.map('map').setView([<?= $location; ?>], 10); // Jakarta

												// Tambahkan tile dari OpenStreetMap
												L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
													maxZoom: 19,
													attribution: '© OpenStreetMap contributors'
												}).addTo(map);

												// Marker
												const marker = L.marker([<?= $location; ?>], {
													draggable: true
												}).addTo(map);

												// Fungsi untuk memperbarui input koordinat
												function updateLocationInput(lat, lng) {
													$('#customer_location').val(`${lat}, ${lng}`);
												}

												// Listener untuk drag marker
												marker.on('dragend', function(event) {
													const position = event.target.getLatLng();
													updateLocationInput(position.lat, position.lng);
													reverseGeocode(position.lat, position.lng); // Dapatkan alamat dari koordinat
												});

												// Listener untuk klik di peta
												map.on('click', function(event) {
													const {
														lat,
														lng
													} = event.latlng;
													marker.setLatLng([lat, lng]);
													updateLocationInput(lat, lng);
													reverseGeocode(lat, lng); // Dapatkan alamat dari koordinat
												});

												// Geocoding menggunakan Nominatim API
												$('#searchAddress').on('click', function() {
													const address = $('#customer_maps').val();
													const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;

													$.getJSON(url, function(data) {
														if (data && data.length > 0) {
															const {
																lat,
																lon
															} = data[0];
															map.setView([lat, lon], 15); // Pusatkan peta ke lokasi
															marker.setLatLng([lat, lon]); // Pindahkan marker
															updateLocationInput(lat, lon);
															reverseGeocode(lat, lon); // Perbarui alamat
														} else {
															alert('Alamat tidak ditemukan!');
														}
													}).fail(function() {
														alert('Terjadi kesalahan saat menghubungi server.');
													});
												});
											});
										</script>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_ktp">Identity Number (KTP):</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_ktp" name="customer_ktp" placeholder="Enter Identity Number (KTP)" value="<?= $customer_ktp; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_npwp">NPWP:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="customer_npwp" name="customer_npwp" placeholder="Enter NPWP" value="<?= $customer_npwp; ?>">
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
								<form id="importn" method="post" class="col-md-12 form well" enctype="multipart/form-data">
									<div class="form-group">
										<label>Import Excel : </label>
										<input class="form-control" name="filecustomer" type="file" />
									</div>
									<div class="form-group">
										<button class="btn btn-primary" type="submit" name="import">Import</button>
										<button class="btn btn-danger" type="button" onclick="tutupimport()">Close</button>
									</div>
								</form>
								<button id="btnimport" class="btn btn-primary" type="button" onclick="bukaimport()">Import Excel</button>
								<button id="btntemplate" class="btn btn-success" type="button" onclick="downloadtemplate()"><i class="fa fa-print"></i> Download Excel Template</button>
								<script>
									function tutupimport() {
										$("#importn").hide();
										$("#btnimport").show();
									}

									function bukaimport() {
										$("#importn").show();
										$("#btnimport").hide();
									}
									tutupimport();

									function downloadtemplate() {
										window.open("<?= base_url("customer1.xlsx"); ?>", '_self');
									}
								</script>
								<br />
								<br />
								<div id="collapse4" class="body table-responsive">
									<table id="table" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th class="col-md-2 noExport">Action</th>
												<!-- <th>No.</th> -->
												<th>Date</th>
												<th>Branch</th>
												<th>Hunian</th>
												<th>Customer</th>
												<th>Code</th>
												<?php if ($identity->identity_saldocustomer == 1) { ?>
													<th>Saldo</th>
												<?php } ?>
												<th>Email</th>
												<th>Address</th>
												<th>Phone</th>
												<th>Whatsapp</th>
												<th>CP</th>
												<th>KTP</th>
												<th>NPWP</th>
												<th>Fax</th>
											</tr>
										</thead>
										<tbody>
											<?php $usr = $this->db
												->join("branch", "branch.branch_id=customer.branch_id", "left")
												->join("hunian", "hunian.hunian_id=customer.hunian_id", "left")
												->order_by("customer_id", "desc")
												->get("customer");
											$no = 1;
											foreach ($usr->result() as $customer) { ?>
												<tr>
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
													<!-- <td><?= $no++; ?></td> -->
													<td><?= $customer->customer_date; ?></td>
													<td><?= $customer->branch_name; ?></td>
													<td><?= $customer->hunian_name; ?></td>
													<td><?= $customer->customer_name; ?></td>
													<td><?= $customer->customer_code; ?></td>
													<?php if ($identity->identity_saldocustomer == 1) { ?>
														<td><?= number_format($customer->customer_saldo, 0, ",", "."); ?></td>
													<?php } ?>
													<td><?= $customer->customer_email; ?></td>
													<td><?= $customer->customer_address; ?></td>
													<td><?= $customer->customer_phone; ?></td>
													<td><?= $customer->customer_wa; ?></td>
													<td><?= $customer->customer_cp; ?></td>
													<td><?= $customer->customer_ktp; ?></td>
													<td><?= $customer->customer_npwp; ?></td>
													<td><?= $customer->customer_fax; ?></td>
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
	<script>
		$(document).ready(function() {
			$('#table').DataTable({
				dom: 'Bfrtip',
				buttons: [{
						extend: 'print',
						text: 'Print',
						title: 'Customer Data',
						exportOptions: {
							columns: ':not(.noExport)' // Mengabaikan kolom dengan class 'noExport'
						}
					},
					{
						extend: 'excelHtml5',
						text: 'Export to Excel',
						filename: 'Customer Data', // Nama file Excel yang dihasilkan
						title: 'Customer Data',
						exportOptions: {
							columns: ':not(.noExport)' // Mengabaikan kolom dengan class 'noExport'
						}
					}
				]
			});
		});
	</script>
</body>

</html>