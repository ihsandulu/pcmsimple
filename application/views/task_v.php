<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php"); ?>

	<style>
		.d1 {
			position: relatif;
			top: 0px;
			left: 0px;
			/* box-shadow: black 1px 1px 1px 1px; */
		}

		.bold {
			font-weight: bold;
		}

		.wels {
			background-color: #FEEFC2;
			padding: 10px;
			border-radius: 5px;
			margin: 0px 0px 20px 0px;
			font-weight: bold;
			text-align: center;
		}

		.detail {
			border-bottom: rgba(255, 255, 255, 0.8) solid 1px;
			padding: 3px 0px 3px 0px;
		}

		#pemisah {
			border-top: gray double 3px;
			margin-top: 20px;
			padding: 20px;
			overflow-x: auto;
		}

		#datatransaksi {
			margin-top: 20px;
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
				<li class="active">Assignment</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<?php if (isset($_GET["inv_no"])) {
				$col1 = "8";
			} else {
				$col1 = "10";
			} ?>
			<div class="col-md-<?= $col1; ?>">
				<h1 class="page-header"> Assignment</h1>
			</div>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
				<?php if ($this->session->userdata("position_id") != 2 && $this->session->userdata("position_id") != 6 && !isset($_GET['report'])) { ?>
					<?php if (isset($_GET["inv_no"])) { ?>
						<form id="back" method="POST" class="col-md-2">
							<h1 class="page-header col-md-12">
								<button type="button" onclick="tutup();" class="btn btn-warning btn-block btn-lg" style="float:right; margin:2px;">
									Back
								</button>
							</h1>
						</form>
					<?php
					} ?>
					<form id="new" method="POST" class="col-md-2">
						<h1 class="page-header col-md-12">
							<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
							<input type="hidden" name="task_id" />
						</h1>
					</form>
				<?php } ?>
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
									$judul = "Update Assignment";
								} else {
									$namabutton = 'name="create"';
									$judul = "Create Assignment";
								} ?>
								<?php if ($this->session->userdata("position_id") != 2) {
									$disabled = "";
									$readonly = "";
								} else {
									$disabled = 'disabled="disabled"';
									$readonly = 'readonly="readonly"';
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form class="form-horizontal" method="POST" enctype="multipart/form-data">
									<?php if (isset($_GET['inv_no'])) {
										if (isset($_GET['inv_no'])) {
											$inv_no = $this->input->get("inv_no");
										}
									?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="inv_no">Invoice No.:</label>
											<div class="col-sm-10">
												<input <?= $disabled; ?> name="inv_no" id="inv_no" value="<?= $inv_no; ?>" class="form-control" readonly="" />
											</div>
										</div>
									<?php } ?>

									<div class="form-group">
										<label class="control-label col-sm-2" for="customer_id">Customer:<br />
											<a href="#" class="btn btn-warning" id="newCustomerBtn">New Customer</a>
											<script>
												document.getElementById('newCustomerBtn').addEventListener('click', function() {
													sessionStorage.setItem('openedFromLink', 'true');
													window.open('<?= base_url("customer"); ?>', '_blank');
												});
											</script>
										</label>
										<div class="col-sm-10">
											<?php if (isset($_GET['customer_id'])) {
												$customer_id = $this->input->get("customer_id");
											} ?>
											<select <?= $disabled; ?> name="customer_id" class="form-control" required>
												<option value="">Select Customer</option>
												<?php $prod = $this->db->get("customer");
												foreach ($prod->result() as $customer) { ?>
													<option value="<?= $customer->customer_id; ?>" <?php if ($customer_id == $customer->customer_id) { ?>selected="selected" <?php } ?>>
														<?= $customer->customer_name; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>



									<div class="form-group">
										<label class="control-label col-sm-2" for="task_pengirim">Ditugaskan pada:</label>
										<div class="col-sm-10">
											<select <?= $disabled; ?> name="user_id" class="form-control" required>
												<option value="">Select User</option>
												<?php $tek = $this->db
													->where("position_id", "2")
													->get("user");
												foreach ($tek->result() as $teknisi) { ?>
													<option value="<?= $teknisi->user_id; ?>" <?php if ($user_id == $teknisi->user_id) { ?>selected="selected" <?php } ?>>
														<?= $teknisi->user_name; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="task_date">Tgl. Penugasan:</label>
										<div class="col-sm-10">
											<input <?= $disabled; ?> class="form-control date" type="text" name="task_date" id="task_date" value="<?= $task_date; ?>" />
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="task_time">Jam:</label>
										<div class="col-sm-10">
											<input <?= $disabled; ?> class="form-control" type="time" name="task_time" id="task_time" value="<?= $task_time; ?>" />
										</div>
									</div>

									<!-- <div class="form-group">
										<label class="control-label col-sm-2" for="task_due">Batas Waktu Pekerjaan:</label>
										<div class="col-sm-10">
											<input <?= $disabled; ?> class="form-control date" type="text" name="task_due" id="task_due" value="<?= $task_due; ?>" />
										</div>
									</div> -->

									<div class="form-group">
										<label class="control-label col-sm-2" for="task_tips">Tips:</label>
										<div class="col-sm-10">
											<select onchange="tips();" id="task_tips" name="task_tips" class="form-control">
												<option value="0" <?= ($task_tips == "0") ? "selected" : "" ?>>Tidak Ada</option>
												<option value="1" <?= ($task_tips == "1") ? "selected" : "" ?>>Tanpa Keterangan</option>
												<option value="2" <?= ($task_tips == "2") ? "selected" : "" ?>>Untuk Petugas</option>
											</select>
										</div>
									</div>
									<div id="tasktipsnominal" class="form-group" style="display:none;">
										<label class="control-label col-sm-2" for="task_tipsnominal">Tips Nominal:</label>
										<div class="col-sm-10">
											<input <?= $disabled ?> class="form-control" type="number" name="task_tipsnominal" id="task_tipsnominal" value="<?= $task_tipsnominal ?>" />
										</div>
									</div>

									<script>
										function tips() {
											let tipsnya = $("#task_tips").val();
											if (tipsnya == "1" || tipsnya == "2") {
												$("#tasktipsnominal").show();
											} else {
												$("#tasktipsnominal").hide();
												$("#task_tipsnominal").val(0);
											}
										}
										tips();
									</script>


									<div class="form-group">
										<label class="control-label col-sm-2" for="task_content">Keterangan:</label>
										<div class="col-sm-10">
											<textarea <?= $readonly; ?> class="form-control" type="text" name="task_content" id="task_content"><?= $task_content; ?></textarea>
											<script>
												var roxyFileman = '<?= site_url("fileman/index.html"); ?>';
												CKEDITOR.replace(
													'task_content', {
														filebrowserBrowseUrl: roxyFileman,
														filebrowserImageBrowseUrl: roxyFileman + '?type=image',
														removeDialogTabs: 'link:upload;image:upload',
														height: '200px',
														stylesSet: 'my_custom_style'
													}
												);
											</script>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="task_finished">Selesai Pekerjaan:<br /><small>(Diisi setelah selesai)</small></label>
										<div class="col-sm-10">
											<input class="form-control date" type="text" name="task_finished" id="task_finished" value="<?= $task_finished; ?>" />
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="task_picture">Bukti Pekerjaan:<br /><small>(Diisi setelah selesai)</small></label>
										<div class="col-sm-10" align="left">
											<input type="file" id="task_picture" name="task_picture"><br />
											<?php if ($task_picture != "") {
												$user_image = "assets/images/task_picture/" . $task_picture;
											} else {
												$user_image = "assets/images/task_picture/noimage.png";
											} ?>
											<img id="task_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
											<script>
												function readURL(input) {
													if (input.files && input.files[0]) {
														var reader = new FileReader();

														reader.onload = function(e) {
															$('#task_picture_image').attr('src', e.target.result);
														}

														reader.readAsDataURL(input.files[0]);
													}
												}

												$("#task_picture").change(function() {
													readURL(this);
												});
											</script>
										</div>
									</div>

									<input class="form-control" type="hidden" name="task_id" id="task_id" value="<?= $task_id; ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<a onclick="kembali(); " href="#" type="button" class="btn btn-warning col-md-offset-1 col-md-5">Back</a>
											<script>

											</script>
										</div>
									</div>
								</form>
							</div>
						<?php } else { ?>
							<?php if ($message != "") { ?>
								<div class="alert alert-info alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong><?= $message; ?></strong><br /><?= $uploadtask_picture; ?>
								</div>
							<?php } ?>
							<div class="box">
								<?php
								if ($this->session->userdata("position_id") != 2 && $this->session->userdata("position_id") != 6) { ?>
									<div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
										<form class="form-inline">
											<?php
											if ($this->session->userdata("position_id") != 2 && $this->session->userdata("position_id") != 6) {
											?>
												<div class="form-group">
													<label for="email">Petugas:</label>
													<select class="form-control" name="user_id">
														<option value="" <?= ($this->input->get("user_id") == "") ? "selected" : ""; ?>>All</option>
														<?php $user = $this->db->where("position_id", "2")->get("user");
														foreach ($user->result() as $user) { ?>
															<option value="<?= $user->user_id; ?>" <?= ($this->input->get("user_id") == $user->user_id) ? "selected" : ""; ?>><?= $user->user_name; ?></option>
														<?php } ?>
													</select>
												</div>
												<button class="btn btn-warning btn-md fa fa-search"></button>
											<?php } ?>
											<a target="_blank" href="<?= site_url("taskprintall"); ?>" class="btn btn-success btn-md fa fa-print"></a>
										</form>
									</div>
								<?php } ?>
								<?php

								if ($this->session->userdata("position_id") != 6) { ?>
									<?php if ($this->session->userdata("position_id") == 2) { ?>
										<button onclick="bukadata();" class="btn btn-warning fa fa-bars" style="margin-left:20px;"> Buka Data</button>
										<script>
											function bukadata() {
												$("#datatransaksi").toggle();
											}
											$(document).ready(function() {
												$("#datatransaksi").hide();
												<?php if (isset($_GET["from"])) { ?>
													$("#datatransaksi").show();
												<?php } ?>
											});
										</script>
									<?php } ?>
									<div id="datatransaksi" class="col-xs-12">
										<div class="carikonten well">
											<form class="form-inline cari">
												<div class="form-group">
													<label for="from">From</label>
													<input name="from" type="date" class="form-control date" value="<?= (isset($_GET['from'])) ? $_GET['from'] : date("Y-m-d"); ?>" />
												</div>
												<div class="form-group cari">
													<label for="to">To</label>
													<input name="to" type="date" class="form-control date" value="<?= (isset($_GET['to'])) ? $_GET['to'] : date("Y-m-d"); ?>" />
												</div>
												<?php if (isset($_GET['report'])) { ?>
													<input type="hidden" name="report" value="ok" />
												<?php } ?>
												<button name="search" class="btn btn-primary">
													<i class="fa fa-search"></i>
												</button>
												<?php
												if (isset($_GET['from'])) {
													$from = $_GET['from'];
												} else {
													$from = date("Y-m-d");
												}
												if (isset($_GET['to'])) {
													$to = $_GET['to'];
												} else {
													$to = date("Y-m-d");
												}
												?>
											</form>
										</div>
										<div id="pemisah" class="tarik">
											<table id="dataTable2" class="table table-condensed table-hover">
												<thead>
													<tr>
														<?php if (!isset($_GET['report'])) {
															$col = "col-md-2";
														} else {
															$col = "col-md-1";
														} ?>
														<th class="<?= $col; ?>">Action</th>
														<th>No.</th>
														<?php if ($this->session->userdata("position_id") != 6) { ?>
															<th>Date</th>
															<th>Time</th>
															<!-- <th>Due Date </th> -->
														<?php } ?>
														<th>Finished Date </th>
														<?php if ($this->session->userdata("position_id") != 6) { ?>
															<th>INV No.</th>
														<?php } ?>
														<th>Task No. </th>
														<th>Customer</th>
														<?php if ($this->session->userdata("position_id") != 6) { ?>
															<th>Teknisi</th>
														<?php } ?>
														<th>Task</th>
														<th>Status</th>
														<th>Tips</th>
														<th class="col-md-1">Proof </th>
													</tr>
												</thead>
												<tbody>
													<?php

													$this->db->where("task.task_date >=", $from);
													$this->db->where("task.task_date <=", $to);
													if (isset($_GET['inv_no'])) {
														$this->db->where("inv_no", $_GET['inv_no']);
													}

													if ($this->session->userdata("position_id") == 2) {
														$this->db->where("task.user_id", $this->session->userdata("user_id"));
													}
													if ($this->session->userdata("position_id") == 6) {
														$this->db->where("task.customer_id", $this->session->userdata("customer_id"));
													}
													if (isset($_GET['user_id']) && $_GET['user_id'] != "") {
														$this->db->where("task.user_id", $this->input->get("user_id"));
													}
													$usr = $this->db
														->join("user", "user.user_id=task.user_id", "left")
														->join("customer", "customer.customer_id=task.customer_id", "left")
														->order_by("task_id", "desc")
														->get("task");
													// echo $this->db->last_query();
													$no = 1;
													$numrows = $usr->num_rows();
													foreach ($usr->result() as $task) {
														$warna = "background-color:#BAFFC9;";
														$status = "Done";
														if ($task->task_finished == "0000-00-00") {
															$warna = "background-color:#ECD2C0;";
															$status = "";
														}
														if ($task->user_id == 0) {
															$warna = "background-color:#000000!important; color:white!important;";
															$status = "";
														}
													?>
														<tr style="<?= $warna; ?>">
															<td style="text-align:center; ">
																<?php if (!isset($_GET['report'])) {
																	$float = "float:right;"; ?>
																	<?php if ($this->session->userdata("position_id") != 2) { ?>
																		<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
																			<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																			<input type="hidden" name="task_id" value="<?= $task->task_id; ?>" />
																		</form>

																		<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
																			<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																			<input type="hidden" name="task_id" value="<?= $task->task_id; ?>" />
																		</form>
																	<?php } ?>

																<?php } else {
																	$float = "";
																} ?>
																<?php if ($this->session->userdata("position_id") != 2) { ?>
																	<form method="POST" class="" style="padding:0px; margin:2px; <?= $float; ?>">
																		<a data-toggle="tooltip" title="Print Surat Perintah Kerja" target="_blank" href="<?= site_url("taskprint?inv_no=" . $task->inv_no) . "&task_no=" . $task->task_no . "&customer_id=" . $task->customer_id; ?>" class="btn btn-sm btn-success " name="edit" value="OK">
																			<span class="fa fa-print" style="color:white;"></span> </a>
																	</form>
																<?php } ?>
																<form method="POST" class="" style="padding:0px; margin:2px; <?= $float; ?>">
																	<?php $url = site_url("taskproduct?inv_no=" . $task->inv_no) . "&customer_id=" . $task->customer_id . "&task_id=" . $task->task_id; ?>
																	<a onclick="bukaproduk('<?= $url; ?>');return false;" data-toggle="tooltip" title="Material / Product" target="_blank" href="#" class="btn btn-sm btn-primary ">
																		<span class="fa fa-shopping-bag" style="color:white;"></span> </a>
																</form>
															</td>
															<td><?= $no++; ?></td>
															<?php if ($this->session->userdata("position_id") != 6) { ?>
																<td><?= $task->task_date; ?></td>
																<td><?= $task->task_time; ?></td>
																<!-- <td><?= ($task->task_due == "0000-00-00") ? "" : $task->task_due; ?></td> -->
															<?php } ?>
															<td>
																<?= ($task->task_finished == "0000-00-00") ? "" : $task->task_done; ?>&nbsp;
																<?php if ($task->task_geolocation != "") { ?>
																	<a target="_blank" href="https://www.google.com/maps/?q=<?= $task->task_geolocation; ?>">
																		<span class="fa fa-map-marker"></span>
																	</a>
																<?php } ?>
															</td>
															<?php if ($this->session->userdata("position_id") != 6) { ?>
																<td><?= $task->inv_no; ?></td>
															<?php } ?>
															<td><?= $task->task_no; ?></td>
															<td><?= $task->customer_name; ?></td>
															<?php if ($this->session->userdata("position_id") != 6) { ?>
																<td><?= $task->user_name; ?></td>
															<?php } ?>
															<td><?= $task->task_content; ?></td>
															<td><?= $status; ?></td>
															<td>
																<?= ($task->task_tips == "1") ? "Tanpa Keterangan" : "" ?>
																<?= ($task->task_tips == "2") ? "Untuk Petugas" : "" ?>
																<br />
																(<?php
																	if ($task->task_tips > 0) {
																		if ($task->task_tips == 1 && $this->session->userdata("position_id") == 2) {
																			echo "";
																		} else {
																			echo number_format($task->task_tipsnominal, 0, ",", ".");
																		}
																	} ?>)
															</td>
															<td><?php if ($task->task_picture != "") {
																	$gambar = $task->task_picture;
																} else {
																	$gambar = "noimage.png";
																} ?>
																<img src="<?= base_url("assets/images/task_picture/" . $gambar); ?>" alt="approve" style="width:20px; height:20px; margin-right:10px;" onClick="tampil(this)">
																<script>
																	function tampil(a) {
																		var gambar = $(a).attr("src");
																		$("#imgumum").attr("src", gambar);
																		$("#myImage").modal("show");
																	}
																</script>
																<a href="<?= base_url("assets/images/task_picture/" . $gambar); ?>" target="_blank" class="fa fa-download"></a>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								<?php } ?>
								<?php
								if ($this->session->userdata("position_id") == 2 || $this->session->userdata("position_id") == 6) {
									if (isset($_GET['inv_no'])) {
										$this->db->where("inv_no", $_GET['inv_no']);
									}

									if ($this->session->userdata("position_id") == 2) {
										$this->db->where("task.user_id", $this->session->userdata("user_id"));
									}
									if ($this->session->userdata("position_id") == 6) {
										$this->db->where("task.customer_id", $this->session->userdata("customer_id"));
									}
									if (isset($_GET['user_id']) && $_GET['user_id'] != "") {
										$this->db->where("task.user_id", $this->input->get("user_id"));
									}
									$usr = $this->db
										->join("user", "user.user_id=task.user_id", "left")
										->join("customer", "customer.customer_id=task.customer_id", "left")
										->where("task_date", date("Y-m-d"))
										->order_by("task_id", "desc")
										->get("task");
									//echo $this->db->last_query();
									$no = 1;
									$bantuan = array("", "Ya (Potongan 50%)");
									foreach ($usr->result() as $task) {
										$warna = "background-color:#9ADED4;";
										$status = "Done";
										if ($task->task_finished == "0000-00-00") {
											$warna = "background-color:#ECD2C0;";
											$status = "";
										}
										if ($task->task_arrive != null) {
											$warna = "background-color:#E8E8AD;";
											$status = "Accepted";
										}
										if ($task->task_finished > "0000-00-00") {
											if ($task->task_komplain != "") {
												$warna = "background-color:#F7C2D6;";
												$status = "Komplain";
											} else {
												$warna = "background-color:#9ADED4;";
												$status = "Done";
											}
										}
								?>
										<div class="col-md-4 col-xs-12" style="">
											<div class="row" style="<?= $warna; ?>; margin:5px; padding:15px 5px 15px 5px; border-radius:5px; box-shadow:rgba(0,0,0,0.1) 0px 0px 5px 1px;">
												<div class="col-md-12">

													<div class="col-md-12" style="">
														<form style=" float:left;">
															<span class="btn btn-sm btn-default ">
																<?= $no++; ?> </span>
														</form>
														<?php if (!isset($_GET['report'])) {
															$float = "float:left;"; ?>
															<?php if ($this->session->userdata("position_id") != 2) { ?>
																<form method="POST" class="" style="margin-left:2px; float:left;">
																	<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																	<input type="hidden" name="task_id" value="<?= $task->task_id; ?>" />
																</form>

																<form method="POST" class="" style="margin-left:2px; float:left;">
																	<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																	<input type="hidden" name="task_id" value="<?= $task->task_id; ?>" />
																</form>
															<?php } ?>

														<?php } else {
															$float = "";
														} ?>
														<?php if ($this->session->userdata("position_id") != 2) { ?>
															<form method="POST" class="" style="padding:0px; margin-left:2px; <?= $float; ?>">
																<a data-toggle="tooltip" title="Print Invoice" target="_blank" href="<?= site_url("taskprint?inv_no=" . $task->inv_no) . "&customer_id=" . $task->customer_id; ?>" class="btn btn-sm btn-success " name="edit" value="OK">
																	<span class="fa fa-print" style="color:white;"></span> </a>
															</form>
														<?php } ?>
														<form method="POST" class="" style="padding:0px; margin-left:2px; <?= $float; ?>">
															<a data-toggle="tooltip" title="Material / Product" onclick="bukaproduk('<?= site_url("taskproduct?inv_no=" . $task->inv_no) . "&customer_id=" . $task->customer_id . "&task_id=" . $task->task_id; ?>');" href="#" class="btn btn-sm btn-primary ">
																<span class="fa fa-shopping-bag" style="color:white;"></span> </a>
														</form>
														<?php if ($task->task_finished == "0000-00-00") { ?>
															<form id="reject<?= $task->task_id; ?>" method="POST" class="" style="padding:0px; margin-left:2px; <?= $float; ?>" onsubmit="return confirmSubmit()">
																<input type="hidden" value="<?= $task->task_id; ?>" name="task_id" />
																<input type="hidden" value="0" name="user_id" />
																<input type="hidden" value="<?= $task->user_name; ?>" name="user_name" />
																<input type="hidden" value="<?= $task->customer_name; ?>" name="customer_name" />
																<button name="change" value="OK" data-toggle="tooltip" title="Reject Task" class="btn btn-sm btn-danger">
																	<span class="fa fa-close" style="color:white;"></span>
																</button>
															</form>
														<?php } ?>
														<?php if ($task->task_arrive == null) { ?>
															<form id="acc<?= $task->task_id; ?>" method="POST" class="" style="padding:0px; margin-left:2px; <?= $float; ?>" onsubmit="return confirmSubmit()">
																<input type="hidden" value="<?= $task->task_id; ?>" name="task_id" />
																<input type="hidden" value="<?= $this->session->userdata("user_id"); ?>" name="user_id" />
																<input type="hidden" value="<?= $this->session->userdata("user_name"); ?>" name="user_name" />
																<input type="hidden" value="<?= $task->customer_name; ?>" name="customer_name" />
																<input type="hidden" value="<?= date("Y-m-d H:i:s"); ?>" name="task_arrive" />
																<input type="hidden" value="" class="task_geolocation" name="task_geolocation" />
																<button name="change" value="OK" data-toggle="tooltip" title="Accept Task" class="btn btn-sm btn-success">
																	<span class="fa fa-check" style="color:white;"></span>
																</button>
															</form>
														<?php } ?>
														<form id="acc<?= $task->task_id; ?>" method="POST" class="" style="padding:0px; margin-left:2px; <?= $float; ?>" onsubmit="return confirmSubmit()">
															<a data-toggle="tooltip" title="Print Surat Perintah Kerja" target="_blank" href="<?= site_url("taskprint?inv_no=" . $task->inv_no) . "&task_no=" . $task->task_no . "&customer_id=" . $task->customer_id; ?>" class="btn btn-sm btn-success " name="edit" value="OK">
																<span class="fa fa-print" style="color:white;"></span> </a>
														</form>

														<script type="text/javascript">
															function geolocation() {
																if (navigator.geolocation) {
																	navigator.geolocation.getCurrentPosition(function(position) {
																		var latitude = position.coords.latitude;
																		var longitude = position.coords.longitude;
																		var latlon = latitude + ',' + longitude;
																		// alert();
																		$(".task_geolocation").val(latlon);
																	}, function(error) {
																		// alert("Geolocation gagal: " + error.message);
																	});
																} else {
																	alert("Geolocation tidak didukung oleh browser ini.");
																}
															}
															geolocation();
															setInterval(function() {
																geolocation();
															}, 5000);

															function confirmSubmit() {
																// event.preventDefault();
																confirm("Apakah kamu yakin ingin melanjutkan?");
															}
														</script>
													</div>
													<div class="col-xs-12" style="margin-top:15px;">
														<div class="wels">
															<?= $task->inv_no; ?> | <?= $task->task_no; ?>
														</div>
													</div>

													<div class="col-xs-12 detail" style="">
														<div class="col-xs-4 bold">Date Time</div>
														<div class="col-xs-8">: <?= $task->task_date; ?> <?= $task->task_time; ?></div>
													</div>
													<?php if ($task->task_finished > "0000-00-00") { ?>
														<div class="col-xs-12 detail" style="">
															<div class="col-xs-4 bold">Finished</div>
															<div class="col-xs-8">: <?= ($task->task_done == "0000-00-00") ? "&nbsp;" : $task->task_done; ?> </div>
														</div>
													<?php } ?>

													<div class="col-xs-12 detail" style="">
														<div class="col-xs-4 bold">Customer</div>
														<div class="col-xs-8">: <?= $task->customer_name; ?></div>
													</div>
													<div class="col-xs-12 detail" style="">
														<div class="col-xs-4 bold">Petugas</div>
														<div class="col-xs-8">: <?= $task->user_name; ?></div>
													</div>
													<div class="col-xs-12 detail" style="">
														<div class="col-xs-4 bold">Catatan</div>
														<div class="col-xs-8">: <?= $task->task_content; ?>&nbsp;</div>
													</div>

													<?php if ($task->task_finished > "0000-00-00" || $task->task_arrive > "0000-00-00") { ?>
														<div class="col-xs-12 detail" style="">
															<div class="col-xs-4 bold">Status</div>
															<div class="col-xs-8">: <?= $status; ?>&nbsp;</div>
														</div>
														<div class="col-xs-12 detail" style="">
															<div class="col-xs-4 bold">Bantuan Pusat</div>
															<div class="col-xs-8">: <?= $bantuan[$task->task_bantuan]; ?>&nbsp;</div>
														</div>
													<?php } ?>
													<?php if ($task->task_finished > "0000-00-00") { ?>
														<div class="col-xs-12 detail" style="">
															<div class="col-xs-4 bold">Bukti Photo</div>
															<div class="col-xs-8">: <?php if ($task->task_picture != "") {
																						$gambar = $task->task_picture;
																					} else {
																						$gambar = "noimage.png";
																					} ?>
																<img src="<?= base_url("assets/images/task_picture/" . $gambar); ?>" alt="approve" style="width:20px; height:20px;" onClick="tampil(this)">&nbsp;
															</div>
														</div>
													<?php } ?>
													<?php if ($task->task_arrive > "0000-00-00") { ?>
														<div class="col-xs-12 detail" style="">
															<div class="col-xs-4 bold">Tips</div>
															<div class="col-xs-8">:
																<?php
																if ($task->task_tips > 0) {
																	if ($task->task_tips == 1 && $this->session->userdata("position_id") == 2) {
																		echo "";
																	} else {
																		echo number_format($task->task_tipsnominal, 0, ",", ".");
																	}
																} ?>
																&nbsp;
															</div>
														</div>
														<?php if ($status == "Done") { ?>
															<div class="col-xs-12" style="">
																<form action="" method="POST" enctype="multipart/form-data">
																	<div class="form-group">
																		<label for="email">Komplain:</label>
																		<input type="text" class="form-control" name="task_komplain" value="<?= $task->task_komplain; ?>">
																	</div>
																	<input type="hidden" name="task_id" value="<?= $task->task_id; ?>" />
																	<button name="change" value="OK" type="submit" class="btn btn-success">Komplain</button>
																</form>
															</div>
														<?php } ?>
														<div class="col-xs-12" style="">
															<form action="" method="POST" enctype="multipart/form-data">
																<div class="form-group">
																	<label for="email">Bukti Selesai:</label>
																	<input type="file" class="form-control" name="task_picture">
																</div>
																<input type="hidden" name="task_id" value="<?= $task->task_id; ?>" />
																<button name="change" value="OK" type="submit" class="btn btn-success">DONE</button>
																<?php if ($task->task_bantuan == 0) { ?>
																	<button onclick="klik('bantuan');" type="button" class="btn btn-warning">Butuh Bantuan</button>
																<?php } ?>
															</form>
														</div>
														<div class="col-xs-12" style="display:none;">
															<form action="" method="POST" enctype="multipart/form-data">
																<input type="hidden" name="task_id" value="<?= $task->task_id; ?>" />
																<input type="hidden" name="task_bantuan" value="1" />
																<button id="bantuan" name="change" value="OK" type="submit" class="btn btn-success">Bantuan</button>
															</form>
														</div>
														<script>
															function klik(a) {
																if (confirm("Anda Yakin Meminta Bantuan?")) {
																	$("#" + a).click();
																}
															}
														</script>
													<?php } ?>
												</div>
											</div>
										</div>
								<?php }
								}
								?>
							</div>
					</div>
				<?php } ?>

				<script>
					function tampil(a) {
						var gambar = $(a).attr("src");
						$("#imgumum").attr("src", gambar);
						$("#myImage").modal("show");
					}
					<?php if ($numrows > 0) { ?>
						$("#new").hide();
						$("#back").removeClass("col-md-2").addClass("offset-md-2 col-md-2");
					<?php } ?>
				</script>
				</div>
			</div>
		</div>
	</div>

	<!-- /#wrap -->
	<?php require_once("footer.php"); ?>


</body>

</html>