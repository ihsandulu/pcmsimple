<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php");
	$month = date("n");
	if (isset($_REQUEST["month"])) {
		$month = $_REQUEST["month"];
	}

	//bulan		
	$bulan_array = array(0 => "Bulan", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
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
				<li class="active">Payroll</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header">Payroll</h1>
			</div>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
				<form method="post" class="col-md-2">
					<h1 class="page-header col-md-12">
						<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
						<input type="hidden" name="gaji_id" />
					</h1>
				</form>
			<?php } ?>
		</div><!--/.row-->


		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if (isset($_POST['new']) || isset($_POST['edit']) && !isset($_GET['report'])) { ?>
							<div class="">
								<?php if (isset($_POST['edit'])) {
									$namabutton = 'name="change"';
									$judul = "Update Payroll";
								} else {
									$namabutton = 'name="create"';
									$judul = "New Payroll";
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form class="form-horizontal" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="control-label col-sm-2" for="user_id">User:</label>
										<div class="col-sm-10">
											<select onchange="isinama()" type="text" autofocus class="form-control select2" id="user_id" name="user_id">
												<option value="0" <?= ($user_id == "0") ? "selected" : ""; ?>>Choose User</option>
												<?php $user = $this->db->order_by("user_name", "ASC")->get("user");
												foreach ($user->result() as $user) { ?>
													<option value="<?= $user->user_id; ?>"
														data-gaji="<?= $user->user_name; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_name; ?></option>
												<?php } ?>
											</select>
											<input type="hidden" name="gaji_name" id="gaji_name" value="<?= $gaji_name; ?>" />
											<script>
												function isinama() {
													let gaji_name = $("#user_id option:selected").data("gaji");
													$("#gaji_name").val(gaji_name);
												}
											</script>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="gajitype_id ">Period:</label>
										<div class="col-sm-10">
											<select onchange="pilihtype();" class="form-control" id="gajitype_id" name="gajitype_id">
												<option value="0" <?= ($gajitype_id == "0") ? "selected" : ""; ?>>Select Type</option>
												<option value="-1" <?= ($gajitype_id == "-1") ? "selected" : ""; ?>>Current Periode</option>
												<?php $gajitype = $this->db->order_by("gajitype_name", "ASC")->get("gajitype");
												foreach ($gajitype->result() as $gajitype) { ?>
													<option value="<?= $gajitype->gajitype_id; ?>" <?= ($gajitype_id == $gajitype->gajitype_id) ? "selected" : ""; ?>><?= $gajitype->gajitype_name; ?></option>
												<?php } ?>
											</select>
											<script>
												function pilihtype() {
													let gajitype = $("#gajitype_id").val();
													if (gajitype == -1) {
														$(".periode").show();
													} else {
														$(".periode").hide();
													}
												}
												$(document).ready(function() {
													pilihtype();
												});
											</script>
										</div>
									</div>
									<div class="form-group periode">
										<label class="control-label col-sm-2" for="gaji_from">From:</label>
										<div class="col-sm-10">
											<input type="date" class="form-control date" name="gaji_from" value="<?= $gaji_from; ?>" />
										</div>
									</div>
									<div class="form-group periode">
										<label class="control-label col-sm-2" for="gaji_to">To:</label>
										<div class="col-sm-10">
											<input type="date" class="form-control date" name="gaji_to" value="<?= $gaji_to; ?>" />
										</div>
									</div>
									<hr />
									<div class="form-group">
										<label class="control-label col-sm-2" for="gaji_source">Pay from:</label>
										<div class="col-sm-10">
											<?php if (isset($_POST['edit'])) {
												$disabled = "disabled"; ?>
												<input type="hidden" name="gaji_source" value="<?= $gaji_source; ?>" />
											<?php } else {
												$disabled = "";
											} ?>
											<select name="gaji_source" class="form-control" <?= $disabled; ?>>
												<option value="kas_id" <?= ($gaji_source == "kas_id") ? 'selected' : ""; ?>>Big Cash</option>
												<option value="petty_id" <?= ($gaji_source == "petty_id") ? 'selected' : ""; ?>>Petty Cash</option>
											</select>
										</div>
									</div>
									<?php if ($identity->identity_project == 1) { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="project_id">Project:</label>
											<div class="col-sm-10">
												<select name="project_id" class="form-control">
													<option value="0" <?= ($project_id == "0") ? 'selected' : ""; ?>>Choose Project</option>
													<?php $project = $this->db
														->where("project_selesai !=", "Selesai")
														->get("project");
													foreach ($project->result() as $project) { ?>
														<option value="<?= $project->project_id; ?>" <?= ($project_id == $project->project_id) ? 'selected' : ""; ?>><?= $project->project_name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php } ?>
									<!-- <hr />
									<div class="form-group">
										<label class="control-label col-sm-2" for="gaji_biayades">Nama Biaya:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="gaji_biayades" value="<?= $gaji_biayades; ?>" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="gaji_biaya">Nominal Biaya:</label>
										<div class="col-sm-10">
											<input type="number" min="1" class="form-control" name="gaji_biaya" value="<?= $gaji_biaya; ?>" />
										</div>
									</div> -->

									<input type="hidden" name="gaji_id" value="<?= $gaji_id; ?>" />
									<input type="hidden" name="petty_id" value="<?= $petty_id; ?>" />
									<input type="hidden" name="kas_id" value="<?= $kas_id; ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("gaji"); ?>">Back</button>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadgaji_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
								<div class="col-md-6" style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
									<form class="form-inline">
									<?php 
										if(isset($_GET['fromtglgajian'])){ 
											$fromtglgajian = $_GET['fromtglgajian'];
										}else{
											$fromtglgajian = date("Y-m-d");
										}
										if(isset($_GET['totglgajian'])){ 
											$totglgajian = $_GET['totglgajian'];
										}else{
											$totglgajian = date("Y-m-d");
										}
										?>
										<!-- <div class="form-group">
											<label for="email">Month:</label>
											<select name="month" class="form-control">
												<?php for ($x = 1; $x <= 12; $x++) { ?>
													<option value="<?= $x; ?>" <?= ($month == $x) ? "selected" : ""; ?>><?= $bulan_array[$x]; ?></option>
												<?php } ?>
											</select>
										</div> -->

										<label>Payday:</label>
										<div class="form-group">
											<label for="fromtglgajian">From:</label>
											<input type="date" class="form-control" name="fromtglgajian" value="<?= $fromtglgajian; ?>" />
										</div>
										<div class="form-group">
											<label for="totglgajian">To:</label>
											<input type="date" class="form-control" name="totglgajian" value="<?= $totglgajian; ?>" />
										</div>


										<?php if (isset($_GET['report'])) { ?>
											<input type="hidden" name="report" value="ok">
										<?php } ?>
										<button name="btnpdate" style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
										<?php if (isset($_GET['report'])) { ?>
											<a target="_blank" href="<?= site_url("gaji_list_print?report=ok&month=" . $month); ?>" class="btn btn-success fa fa-print"></a> <?php } ?>
									</form>

								</div>
								<div class="col-md-6" style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
									<form class="form-inline">
										<?php 
										if(isset($_GET['fromtgltransaksi'])){ 
											$fromtgltransaksi = $_GET['fromtgltransaksi'];
										}else{
											$fromtgltransaksi = date("Y-m-d");
										}
										if(isset($_GET['totgltransaksi'])){ 
											$totgltransaksi = $_GET['totgltransaksi'];
										}else{
											$totgltransaksi = date("Y-m-d");
										}
										?>
										<!-- <div class="form-group">
											<label for="email">Month:</label>
											<select name="month" class="form-control">
												<?php for ($x = 1; $x <= 12; $x++) { ?>
													<option value="<?= $x; ?>" <?= ($month == $x) ? "selected" : ""; ?>><?= $bulan_array[$x]; ?></option>
												<?php } ?>
											</select>
										</div> -->

										<label>Transaction Date:</label>
										<div class="form-group">
											<label for="fromtgltransaksi">From:</label>
											<input type="date" class="form-control" name="fromtgltransaksi" value="<?= $fromtgltransaksi; ?>" />
										</div>
										<div class="form-group">
											<label for="totgltransaksi">To:</label>
											<input type="date" class="form-control" name="totgltransaksi" value="<?= $totgltransaksi; ?>" />
										</div>


										<?php if (isset($_GET['report'])) { ?>
											<input type="hidden" name="report" value="ok">
										<?php } ?>
										<button name="btntdate" style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
										<?php if (isset($_GET['report'])) { ?>
											<a target="_blank" href="<?= site_url("gaji_list_print?report=ok&month=" . $month); ?>" class="btn btn-success fa fa-print"></a> <?php } ?>
									</form>

								</div>
								<div id="collapse4" class="body table-responsive">
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<?php if (!isset($_GET['report'])) { ?>
													<th class="col-md-2">Action</th>
												<?php } ?>
												<th>No.</th>
												<th>Month</th>
												<th>Branch</th>
												<th>User</th>
												<th>Payment</th>
												<th>Deduction</th>
												<th>Total Payment</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$bmonth = str_pad($month, 2, "0", STR_PAD_LEFT);
											if(isset($_GET['btntdate'])){
												$this->db->where("SUBSTR(gaji_datetime,1,10) >=", $fromtgltransaksi);
												$this->db->where("SUBSTR(gaji_datetime,1,10) <=", $totgltransaksi);
											}
											if(isset($_GET['btnpdate'])){
												$this->db->where("gaji_from >=", $fromtglgajian);
												$this->db->where("gaji_from <=", $totglgajian);
											}
											$gajid = $this->db
												->join("gaji", "gaji.gaji_id=gajid.gaji_id", "left")
												// ->where("SUBSTR(gaji_datetime,1,7)", date("Y-$bmonth"))
												->get("gajid");
											// echo $this->db->last_query();
											$arr = array();
											foreach ($gajid->result() as $gajid) {
												if ($gajid->gajid_type == "0") {
													$arr[$gajid->gaji_id]["upah"][] = $gajid->gajid_nominal;
												}
												if ($gajid->gajid_type == "1") {
													$arr[$gajid->gaji_id]["biaya"][] = $gajid->gajid_nominal;
												}
											}
											// print_r($arr);

											if(isset($_GET['btntdate'])){
												$this->db->where("SUBSTR(gaji_datetime,1,10) >=", $fromtgltransaksi);
												$this->db->where("SUBSTR(gaji_datetime,1,10) <=", $totgltransaksi);
											}
											if(isset($_GET['btnpdate'])){
												$this->db->where("gaji_from >=", $fromtglgajian);
												$this->db->where("gaji_from <=", $totglgajian);
											}
											$usr = $this->db
												->join("branch", "branch.branch_id=gaji.branch_id", "left")
												// ->where("SUBSTR(gaji_datetime,1,7)", date("Y-$bmonth"))
												->order_by("gaji_id", "desc")
												->get("gaji");
											// echo $this->db->last_query();
											$no = 1;
											foreach ($usr->result() as $gaji) {
												$upah = 0;
												$biaya = 0;
												$bulan = $bulan_array[(int)substr($gaji->gaji_datetime, 5, 2)];
												if (isset($arr[$gaji->gaji_id]["upah"])) {
													$upah = array_sum($arr[$gaji->gaji_id]["upah"]);
												}
												if (isset($arr[$gaji->gaji_id]["biaya"])) {
													$biaya = array_sum($arr[$gaji->gaji_id]["biaya"]);
												}
											?>
												<tr>
													<?php if (!isset($_GET['report'])) { ?>
														<td style="padding-left:0px; padding-right:0px;">

															<form method="post" class="col-md-3" style="padding:0px;">
																<?php $url = base_url("gajid?gaji_id=" . $gaji->gaji_id . "&gaji_source=" . $gaji->gaji_source . "&kas_id=" . $gaji->kas_id . "&petty_id=" . $gaji->petty_id); ?>
																<button type="button" onclick="bukaproduk('<?= $url; ?>')" data-toggle="tooltip" title="Detail" href="#" class="btn btn-primary " name="payment" value="OK">
																	<span class="fa fa-money" style="color:white;"></span> </button>
															</form>
															<form method="post" class="col-md-3" style="padding:0px;">
																<a target="_blank" href="<?= site_url("gaji_print?gaji_no=" . $gaji->gaji_no . "&gaji_id=" . $gaji->gaji_id); ?>" class="btn  btn-success"><span class="fa fa-print" style="color:white;"></span> </a>
															</form>

															<form method="post" class="col-md-3" style="padding:0px;">
																<button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																<input type="hidden" name="gaji_id" value="<?= $gaji->gaji_id; ?>" />
															</form>

															<form method="post" class="col-md-3" style="padding:0px;" onsubmit="return confirmDelete()">
																<button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																<input type="hidden" name="gaji_id" value="<?= $gaji->gaji_id; ?>" />
																<input type="hidden" name="gaji_source" value="<?= $gaji->gaji_source; ?>" />
																<input type="hidden" name="kas_id" value="<?= $gaji->kas_id; ?>" />
																<input type="hidden" name="petty_id" value="<?= $gaji->petty_id; ?>" />
															</form>

															<script>
																function confirmDelete() {
																	return confirm("Apakah Anda yakin ingin menghapus data ini?");
																}
															</script>
														</td>
													<?php } ?>
													<td><?= $no++; ?></td>
													<td><?= $bulan; ?></td>
													<td><?= $gaji->branch_name; ?></td>
													<td><?= $gaji->gaji_name; ?></td>
													<td><?= number_format($upah, 0, ",", "."); ?></td>
													<td><?= number_format($biaya, 0, ",", "."); ?></td>
													<td><?= number_format($upah - $biaya, 0, ",", "."); ?></td>
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