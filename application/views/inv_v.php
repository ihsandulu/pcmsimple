<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php");


	if (isset($_REQUEST["awal"])) {
		$dari = "";
		$ke = "";
	} elseif (isset($_REQUEST["dari"])) {
		$dari = $_REQUEST["dari"];
		$ke = $_REQUEST["ke"];
	} else {
		$dari = date("Y-m-d");
		$ke = date("Y-m-d");
	}
	if (isset($_REQUEST["project"])) {
		$project = $_REQUEST["project"];
	} else {
		$project = "";
	}
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
				<li class="active">Invoice</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Invoice</h1>
			</div>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['report'])) { ?>
				<form method="POST" class="col-md-2">
					<h1 class="page-header col-md-12">
						<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
						<input type="hidden" name="inv_id" />
					</h1>
				</form>
			<?php } ?>
		</div><!--/.row-->


		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if ($identity->identity_duedate == 1) { ?>
							<div class="alert alert-danger">
								Due date in this week :
								<?php $due = $this->db
									->where("inv_duedate >=", date("Y-m-d", strtotime("-3 days")))
									->where("inv_duedate <=", date("Y-m-d", strtotime("+7 days")))
									->group_by("inv_no")
									->get("inv");
								//echo $this->db->last_query();
								foreach ($due->result() as $due) { ?>
									<strong><?= $due->inv_no; ?></strong>,
								<?php } ?>

							</div>
						<?php } ?>
						<?php
						if (isset($_POST['new']) || isset($_POST['edit'])) {
						?>
							<div class="">
								<?php if (isset($_POST['edit'])) {
									$namabutton = 'name="change"';
									$judul = "Update Invoice";
								} else {
									$namabutton = 'name="create"';
									$judul = "Create Invoice";
								} ?>
								<div class="lead">
									<h3><?= $judul; ?></h3>
								</div>
								<form id="formupdate" class="form-horizontal" method="POST" enctype="multipart/form-data">
									<?php if ($inv_no != "") { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="inv_no">Invoice No.:</label>
											<div class="col-sm-10" align="left">
												<input type="text" id="inv_no" name="inv_no" class="form-control" value="<?= $inv_no; ?>">
											</div>
										</div>
									<?php } ?>
									<?php if ($identity->identity_project == 1) { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="inv_showproduct">Show product from :</label>
											<div class="col-sm-10">
												<select class="form-control" name="inv_showproduct" id="inv_showproduct">
													<option value="0" <?= ($inv_showproduct == "0") ? "selected" : ""; ?>>Pilih product yg akan ditampilkan</option>
													<option value="1" <?= ($inv_showproduct == "1") ? "selected" : (($inv_showproduct == "0" && $identity->identity_showproduct == "1") ? "selected" : ""); ?>>From Master Product</option>
													<option value="2" <?= ($inv_showproduct == "2") ? "selected" : (($inv_showproduct == "0" && $identity->identity_showproduct == "2") ? "selected" : ""); ?>>From Project</option>
												</select>
											</div>
										</div>
									<?php } ?>
									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_date">Date:</label>
										<div class="col-sm-10" align="left">
											<input type="text" name="inv_date" class="date form-control" value="<?= ($inv_date != "" && $inv_date != "0000-00-00") ? $inv_date : date("Y-m-d"); ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_duedate">Due Date:</label>
										<div class="col-sm-10" align="left">
											<input type="text" name="inv_duedate" class="date form-control" value="<?= ($inv_duedate != "" && $inv_duedate != "0000-00-00") ? $inv_duedate : date("Y-m-d"); ?>">
										</div>
									</div>

									<?php
									$identity_project = $this->db->get("identity")->row()->identity_project;
									if ($identity_project != 1) { ?>
										<div class="form-group">
											<label class="control-label col-sm-2" for="customer_id">Customer:</label>
											<div class="col-sm-10">
												<datalist id="customer">
													<?php $uni = $this->db
														->get("customer");
													foreach ($uni->result() as $customer) { ?>
														<option id="<?= $customer->customer_id; ?>" value="<?= $customer->customer_name; ?>">
														<?php } ?>
												</datalist>
												<input id="customerid" onClick="a(this)" onChange="a(this)" class="form-control" list="customer" value="<?= $customer_name; ?>" autocomplete="off">
												<input type="hidden" list="customer" id="customer_id1" name="customer_id" value="<?= $customer_id; ?>">

												<script>
													function a(a) {
														var opt = $('option[value="' + $(a).val() + '"]');
														$("#customer_id1").val(opt.attr('id'));
													}
												</script>

											</div>
										</div>
									<?php } ?>

									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_discount">Discount:</label>
										<div class="col-sm-10" align="left">
											<input type="number" name="inv_discount" class="form-control" value="<?= $inv_discount; ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_ppn">PPN:</label>
										<div class="col-sm-10" align="left">
											<?php if ($inv_ppn == 1) {
												$c = 'checked="checked"';
											} else {
												$c = '';
											} ?>
											<input type="checkbox" style="width:25px; height:25px;" name="inv_ppn" value="1" <?= $c; ?>>
										</div>
									</div>



									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_payment">Payment:</label>
										<div class="col-sm-10" align="left">
											<textarea name="inv_payment" id="inv_payment"></textarea>
											<script>
												ClassicEditor
													.create(document.querySelector('#inv_payment'))
													.then(editor => {
														editor.setData('<?= $inv_payment; ?>');
														editor.ui.view.editable.element.style.height = '120px';
													})
													.catch(error => {
														console.error(error);
													});
											</script>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_storekeeper">Storekeeper:</label>
										<div class="col-sm-10" align="left">
											<input type="text" name="inv_storekeeper" class="form-control" value="<?= $inv_storekeeper; ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_approved">Approved By:</label>
										<div class="col-sm-10" align="left">
											<input type="text" name="inv_approved" class="form-control" value="<?= $inv_approved; ?>">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_receiver">Receiver:</label>
										<div class="col-sm-10" align="left">
											<input type="text" name="inv_receiver" class="form-control" value="<?= $inv_receiver; ?>">
										</div>
									</div>


									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_note">Note:</label>
										<div class="col-sm-10" align="left">
											<textarea name="inv_note" id="inv_note"></textarea>
											<script>
												ClassicEditor
													.create(document.querySelector('#inv_note'))
													.then(editor => {
														editor.setData('<?= $inv_note; ?>');
														editor.ui.view.editable.element.style.height = '120px';
													})
													.catch(error => {
														console.error(error);
													});
											</script>
										</div>
									</div>



									<?php
									if ($identity->identity_simple == 1) {
									?>

										<hr />

										<div class="form-group">
											<label class="control-label col-sm-2" for="unit_id">Payment:</label>
											<div class="col-sm-10">

												<select name="methodpayment_id" class="form-control">
													<?php $met = $this->db->get("methodpayment");
													foreach ($met->result() as $meth) { ?>
														<option value="<?= $meth->methodpayment_id; ?>" <?= ($meth->methodpayment_id == $methodpayment_id) ? "selected" : ""; ?>>
															<?= $meth->methodpayment_name; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>

										<hr />

										<div class="form-group">
											<label class="control-label col-sm-2" for="sjkeluar_pengirim">Pengirim:</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="sjkeluar_pengirim" id="sjkeluar_pengirim" value="<?= $sjkeluar_pengirim; ?>" />
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-sm-2" for="sjkeluar_penerima">Penerima:</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="sjkeluar_penerima" id="sjkeluar_penerima" value="<?= $sjkeluar_penerima; ?>" />
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-sm-2" for="sjkeluar_ekspedisi">Ekspedisi/Kendaraan:</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="sjkeluar_ekspedisi" id="sjkeluar_ekspedisi" value="<?= $sjkeluar_ekspedisi; ?>" />
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-sm-2" for="sjkeluar_nopol">No. Pol:</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="sjkeluar_nopol" id="sjkeluar_nopol" value="<?= $sjkeluar_nopol; ?>" />
											</div>
										</div>

									<?php } ?>

									<div class="form-group">
										<label class="control-label col-sm-2" for="inv_picture">Faktur:</label>
										<div class="col-sm-10" align="left">
											<input type="file" class="form-control" id="inv_picture" name="inv_picture"><br />
											<?php if ($inv_picture != "") {
												$user_image = "assets/images/inv_picture/" . $inv_picture;
											} else {
												$user_image = "assets/img/user.gif";
											} ?>
											<img id="inv_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
											<script>
												function readURL(input) {
													if (input.files && input.files[0]) {
														var reader = new FileReader();

														reader.onload = function(e) {
															$('#inv_picture_image').attr('src', e.target.result);
														}

														reader.readAsDataURL(input.files[0]);
													}
												}

												$("#inv_picture").change(function() {
													readURL(this);
												});
											</script>
										</div>
									</div>

									<input type="hidden" name="inv_no" value="<?= $this->input->post("inv_no"); ?>" />
									<input type="hidden" name="project_id" value="<?= ($project_id > 0) ? $project_id : "0"; ?>" />
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button <?php if ($identity->identity_simple == 1) { ?>type="button" onClick="updatesimpleinv()" <?php } else { ?> type="submit" <?php } ?> id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
											<a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= site_url("inv"); ?>">Back</a>
										</div>
									</div>
								</form>
								<script>
									function updatesimpleinv() {
										$.get("<?= site_url("api/updatesimpleinv"); ?>", $('#formupdate').serialize())
											.done(function(data) {
												var customer_id = 0,
													vendor_id = 0,
													project_id = 0,
													inv_no = '';
												$.each(data, function(a, b) { //alert(a+"="+b);
													if (a == 'customer_id') {
														customer_id = b;
													}
													if (a == 'vendor_id') {
														vendor_id = b;
													}
													if (a == 'project_id') {
														project_id = b;
													}
													if (a == 'inv_no') {
														inv_no = b;
													}
												});
												$('#formupdate').hide();
												//alert(customer_id+"/"+vendor_id+"/"+project_id+"/"+inv_no);
												$.get("<?= site_url("api/productsimpleinv"); ?>", {
														customer_id: customer_id,
														vendor_id: vendor_id,
														project_id: project_id,
														inv_no: inv_no
													})
													.done(function(data) {
														$('#formproduct').html(data);
														$('#formproduct').show();
														tampilproduct(inv_no);
														$('#listproduct').show();
													});
											});
									}
								</script>

							</div>

							<div id="formproduct" style="display:none;">

							</div>
							<div id="listproduct">

							</div>
							<div id="formpayment" style="display:none;">

							</div>
							<div id="listpayment">

							</div>
							<script>
								function tampilproduct(inv_no) {
									$.get("<?= site_url("api/tampilproduct"); ?>", {
											inv_no: inv_no
										})
										.done(function(data) {
											$("#productid").val("");
											$("#invproduct_price").val("");
											$("#listproduct").html(data);
										});
								}
							</script>
						<?php } else { ?>
							<?php if ($message != "") {
								$display = "display:block;";
							} else {
								$display = "display:none;";
							} ?>
							<div id="message" class="alert alert-info alert-dismissable" style="<?= $display; ?>">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong id="messageisi"><?= $message; ?></strong>
							</div>
							<div class="box">
								<div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
									<form class="form-inline">
										<div class="form-group">
											<label for="email">From:</label>
											<input onChange="listinv()" autocomplete="off" type="text" class="form-control date" id="dari" name="dari" value="<?= $dari; ?>">
										</div>
										<div class="form-group">
											<label for="pwd">To:</label>
											<input onChange="listinv()" autocomplete="off" type="text" class="form-control date" id="ke" name="ke" value="<?= $ke; ?>">
										</div>
										<div class="form-group">
											<select class="form-control" name="project">
												<option value="" <?= ($project == "") ? "selected" : ""; ?>>All</option>
												<option value="OK" <?= ($project == "OK") ? "selected" : ""; ?>>Project</option>
												<option value="Non" <?= ($project == "Non") ? "selected" : ""; ?>>Non Project</option>
											</select>
										</div>
										<?php if (isset($_GET['report'])) { ?>
											<input type="hidden" name="report" value="ok">
										<?php } ?>
										<button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
										<a id="listinv" target="_blank" href="<?= site_url("listinvoiceprint?dari=" . $dari . "&ke=" . $ke); ?>" type="submit" class="btn btn-info fa fa-print"> List Invoice</a>

										<script>
											function listinv() {
												$("#listinv").attr("href", "<?= site_url("listinvoiceprint?from="); ?>" + $("#dari").val() + "&to=" + $("#ke").val());
											}
										</script>
									</form>

									<div class="row" style="margin-top:20px; border-top:white 1px solid; padding-top:20px;">
										<div class="col-md-4"><label>Amount : &nbsp;</label><span id="tinvoice"></span></div>
										<div class="col-md-4"><label>Payment : &nbsp;</label><span id="tpembayaran"></span></div>
										<div class="col-md-4"><label>Receivables : &nbsp;</label><span id="tpiutang"></span></div>
									</div>
								</div>
								<div id="collapse4" class="body table-responsive">
									<table id="dataTableinv" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>Date</th>
												<th>Branch</th>
												<th>Invoice No. </th>
												<th>Customer</th>
												<?php if ($identity->identity_project == "1") { ?>
													<th>Project</th>
												<?php } ?>
												<th>PO No.</th>
												<th>Amount</th>
												<th>Payment</th>
												<th>Receivables (Piutang) </th>
												<?php if (!isset($_GET['report'])) {
													$col = "col-md-3";
												} else {
													$col = "col-md-1";
												} ?>
												<th class="<?= $col; ?>">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$tinvoice = 0;
											$tpembayaran = 0;
											$tpiutang = 0;

											$lock = $this->db->get("identity")->row()->identity_lockproduct;

											if (isset($_GET['dari'])) {
												$this->db->where("inv_date >=", $this->input->get("dari"));
											} elseif (isset($_GET['awal'])) {
											} else {
												$this->db->where("inv_date >=", date("Y-m-d"));
											}

											if (isset($_GET['ke'])) {
												$this->db->where("inv_date <=", $this->input->get("ke"));
											} elseif (isset($_GET['awal'])) {
											} else {
												$this->db->where("inv_date <=", date("Y-m-d"));
											}
											if (isset($_GET['project'])) {
												switch ($_GET['project']) {
													case "OK":
														$this->db->where("project_id >", "0");
														break;
													case "Non":
														$this->db->where("project_id", "0");
														break;
													default:
														break;
												}
											}

											//satu customer satu project
											if ($this->session->userdata("user_project") != "" && $lock == 1) {
												$this->db->where("inv.project_id", $this->session->userdata("user_project"));
											}

											//simple payment
											if ($identity->identity_simple == 1) {
												$this->db->join("sjkeluar", "sjkeluar.inv_no=inv.inv_no", "left");
											}

											//project
											if ($identity->identity_project == 1) {
												$this->db->join("project", "project.project_id=inv.project_id", "left");
											}

											$usr = $this->db
												->join("branch", "branch.branch_id=inv.branch_id", "left")
												->join("customer", "customer.customer_id=inv.customer_id", "left")
												->group_by("inv.inv_no")
												->order_by("inv_id", "desc")
												->get("inv");
											//echo $this->db->last_query();
											$no = 1;
											foreach ($usr->result() as $inv) {
												if ($inv->inv_ppn == 1) {
													$inv->inv_ppn = 10 / 100;
												} else {
													$inv->inv_ppn = 0;
												}


												if ($inv->inv_pph == 1) {
													$inv->inv_pph = 2 / 100;
												} else {
													$inv->inv_pph = 0;
												}
											?>
												<tr>
													<td><?= $no++; ?></td>
													<td><?= $inv->inv_date; ?></td>
													<td><?= $inv->branch_name; ?></td>
													<td><?= $inv->inv_no; ?></td>
													<td>
														<?= ucwords($inv->customer_name); ?>
													</td>
													<?php if ($identity->identity_project == "1") {
														if ($this->session->userdata("position_id") == 1 || $this->session->userdata("position_id") == 2 || $this->session->userdata("position_id") == 5 || $this->session->userdata("position_id") == 7) {
															$disproject = '';
														} else {
															$disproject = 'disabled="disabled"';
														}
													?>
														<td>
															<select <?= $disproject; ?> class="form-control" id="project" onChange="inputprojectinvoice(this.value,'<?= $inv->inv_no; ?>')">
																<option value="0">Select Project</option>
																<?php $pr = $this->db->get("project");
																foreach ($pr->result() as $project) { ?>
																	<option value="<?= $project->project_id; ?>" <?= ($inv->project_id == $project->project_id) ? "selected" : ""; ?>><?= $project->project_name; ?></option>
																<?php } ?>
															</select>
															<script>
																function inputprojectinvoice(a, b) {
																	$.get("<?= site_url("api/inputproject_invoice"); ?>", {
																			project_id: a,
																			inv_no: b
																		})
																		.done(function(data) {
																			//inputpoc_invoice('0',b);
																			window.location.href = '<?= current_url(); ?>?message=' + data;
																			$("#messageisi").html(data);
																			$("#message").show();
																			setTimeout(function() {
																				$("#message").hide();
																			}, 2000);
																		});
																}
															</script>
														</td>
													<?php } ?>
													<td>
														<select class="form-control" id="po" onChange="inputpoc_invoice(this.value,'<?= $inv->inv_no; ?>')">
															<option value="0">Select PO</option>
															<?php $po = $this->db
																->where("project_id", $inv->project_id)
																->get("poc");
															foreach ($po->result() as $poc) { ?>
																<option value="<?= $poc->poc_id; ?>" <?= ($inv->poc_id == $poc->poc_id) ? "selected" : ""; ?>><?= $poc->poc_no; ?></option>
															<?php } ?>
														</select>
														<script>
															function inputpoc_invoice(a, b) {
																$.get("<?= site_url("api/inputpoc_invoice"); ?>", {
																		poc_id: a,
																		inv_no: b
																	})
																	.done(function(data) {
																		window.location.href = '<?= current_url(); ?>?message=' + data;
																		$("#messageisi").html(data);
																		$("#message").show();
																		setTimeout(function() {
																			$("#message").hide();
																		}, 2000);
																	});
															}
														</script>
													</td>
													<td><?php
														$i = $this->db
															->where("inv_no", $inv->inv_no)
															->get("invproduct");
														$invoice = 0;
														$discount = 0;
														$to = 0;
														if ($inv->inv_showproduct <= 1) {
															foreach ($i->result() as $i) {
																$to += ($i->invproduct_qty * $i->invproduct_price);
															}
														} else {
															$to = $inv->project_budget;
														}
														$discount = $inv->inv_discount;
														$to -= $discount;
														$inv_ppn = $to * $inv->inv_ppn;
														$invoice = $to + $inv_ppn;
														$p = $this->db
															->join("invpayment", "invpaymentproduct.invpayment_no=invpayment.invpayment_no", "left")
															->where("inv_no", $inv->inv_no)
															->get("invpaymentproduct");
														//echo $this->db->last_query();
														$pembayaran = 0;
														foreach ($p->result() as $p) {
															$pembayaran += ($p->invpaymentproduct_qty * $p->invpaymentproduct_amount);
														}
														echo number_format($invoice, 2, ".", ",");
														$tinvoice += $invoice;
														$tpembayaran += $pembayaran;
														$piutang = $invoice - $pembayaran;
														$tpiutang += $piutang;
														?></td>
													<td><?= number_format($pembayaran, 2, ".", ","); ?></td>
													<td>
														<?= number_format($piutang, 2, ".", ","); ?></td>
													<td style="text-align:center; ">
														<?php
														$identity_project = $this->db->get("identity")->row()->identity_project;
														if ($identity_project != 1 || ($identity_project == 1 && $inv->project_id > 0)) {
															$boleh = 1;
														} else {
															$boleh = 0;
														}
														if ($boleh == 1) {
															if (!isset($_GET['report'])) {
																$float = "float:right;"; ?>
																<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
																	<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																	<input type="hidden" name="inv_no" value="<?= $inv->inv_no; ?>" />
																</form>
																<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
																	<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																	<input type="hidden" name="inv_no" value="<?= $inv->inv_no; ?>" />
																</form>
															<?php } else {
																$float = "";
															} ?>
															<form method="GET" class="" style="padding:0px; margin:2px; <?= $float; ?>">
																<?php $url = base_url("task?customer_id=" . $inv->customer_id . "&inv_no=" . $inv->inv_no); ?>
																<button type="button" data-toggle="tooltip" title="Assignment" href="#" onclick="bukaproduk('<?= $url; ?>');" class="btn btn-sm btn-info " name="task">
																	<span class="fa fa-hand-lizard-o" style="color:white;"></span> </button>
															</form>
															<!-- <form method="POST" class="" style="padding:0px; margin:2px; <?= $float; ?>">
																<a data-toggle="tooltip" title="Print SPK" target="_blank" href="<?= site_url("invprint?printer=spk&inv_no=" . $inv->inv_no) . "&customer_id=" . $inv->customer_id; ?>" class="btn btn-sm btn-success " name="edit" value="OK">
																	<span class="fa fa-user" style="color:white;"></span> </a>
															</form> -->
															<form method="POST" class="" style="padding:0px; margin:2px; <?= $float; ?>">
																<a data-toggle="tooltip" title="Print" target="_blank" href="<?= site_url("invprint?printer=inkjet&inv_no=" . $inv->inv_no) . "&customer_id=" . $inv->customer_id; ?>" class="btn btn-sm btn-warning " name="edit" value="OK">
																	<span class="fa fa-print" style="color:white;"></span> </a>
															</form>
															<?php if (!isset($_GET['report']) && $identity->identity_simple != 1) { ?>
																<?php $urlpayment = site_url("invpayment?inv_no=" . $inv->inv_no) . "&customer_id=" . $inv->customer_id . "&project_id=" . $inv->project_id . "&tagihan=" . $invoice; ?>
																<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
																	<a onclick="bukaproduk('<?= $urlpayment; ?>')" data-toggle="tooltip" title="Payment" href="#" class="btn btn-sm btn-primary " name="payment" value="OK">
																		<span class="fa fa-money" style="color:white;"></span> </a>
																</form>

																<?php $urlproduk = site_url("invproduct?inv_no=" . $inv->inv_no) . "&customer_id=" . $inv->customer_id . "&project_id=" . $inv->project_id; ?>
																<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
																	<a onclick="bukaproduk('<?= $urlproduk; ?>')" data-toggle="tooltip" title="List Product" href="#" class="btn btn-sm btn-info " name="edit" value="OK">
																		<span class="fa fa-shopping-bag" style="color:white;"></span> </a>
																</form>
															<?php } ?>
															<?php if ($identity->identity_simple == 1) { ?>
																<form method="POST" class="" style="padding:0px; margin:2px; <?= $float; ?>">
																	<a data-toggle="tooltip" title="Print Surat Jalan" target="_blank" href="<?= site_url("sjkeluarprint?sjkeluar_no=" . $inv->sjkeluar_no) . "&customer_id=" . $inv->customer_id; ?>" class="btn btn-sm btn-success " name="edit" value="OK">
																		<span class="fa fa-print" style="color:white;"></span>
																	</a>
																</form>
														<?php }
														} ?>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
									<script>
										$("#tinvoice").html("Rp <?= number_format($tinvoice, 2, ".", ","); ?>");
										$("#tpembayaran").html("Rp <?= number_format($tpembayaran, 2, ".", ","); ?>");
										$("#tpiutang").html("Rp <?= number_format($tpiutang, 2, ".", ","); ?>");
									</script>


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