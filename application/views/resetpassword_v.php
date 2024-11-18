<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php"); ?>
	<style>
		#customer {
			display: none;
		}
	</style>
</head>

<body class="  " onLoad="tampilcustomer()">
	<?php require_once("header.php"); ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home">
							<use xlink:href="#stroked-home"></use>
						</svg></a></li>
				<li class="active">User</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> User</h1>
			</div>
			<?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
				<form method="post" class="col-md-2">
					<h1 class="page-header col-md-12">
						<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
						<input type="hidden" name="user_id" />
					</h1>
				</form>
			<?php } ?>
		</div><!--/.row-->


		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if ($message != "") { ?>
							<div class="alert alert-info alert-dismissable">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong><?= $message; ?></strong><br /><?= $uploaduser_picture; ?>
							</div>
						<?php } ?>
						<div class="">
							<?php
							$namabutton = 'name="change"';
							$judul = "Update User";
							?>
							<div class="lead">
								<h3><?= $judul; ?></h3>
							</div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label col-sm-2" for="user_name">Name:</label>
									<div class="col-sm-10">
										<input type="text" autofocus class="form-control" id="user_name" name="user_name" placeholder="Enter Name" value="<?= $user_name; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="user_email">Email:</label>
									<div class="col-sm-10">
										<input type="user_email" class="form-control" id="user_email" name="user_email" placeholder="Enter email" value="<?= $user_email; ?>">
									</div>
								</div>
								<div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekemail" style="display:none;">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Perhatian!</strong> Email telah digunakan.
								</div>

								<script>
									$("#user_email").keyup(function() {
										if ($("#user_email").val() != "<?= $this->session->userdata("user_email"); ?>")
											$.get("<?= site_url("cekuser"); ?>", {
												id: $("#user_email").val()
											})
											.done(function(data) {
												if (data > 0) {
													$("#cekemail").fadeIn();
													$("#submit").prop("disabled", "disabled");
												} else {
													$("#cekemail").fadeOut();
													$("#submit").prop("disabled", "");
												}
											});
									});
								</script>
								<div class="form-group">
									<label class="control-label col-sm-2" for="user_password">Password:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter password" value="<?= $user_password; ?>">
									</div>
								</div>


								<div class="form-group">
									<label class="control-label col-sm-2" for="user_picture">Picture:</label>
									<div class="col-sm-10" align="left">
										<input type="file" class="form-control" id="user_picture" name="user_picture"><br />
										<?php if ($user_picture != "") {
											$user_image = "assets/images/user_picture/" . $user_picture;
										} else {
											$user_image = "assets/img/user.gif";
										} ?>
										<img id="user_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
										<script>
											function readURL(input) {
												if (input.files && input.files[0]) {
													var reader = new FileReader();

													reader.onload = function(e) {
														$('#user_picture_image').attr('src', e.target.result);
													}

													reader.readAsDataURL(input.files[0]);
												}
											}

											$("#user_picture").change(function() {
												readURL(this);
											});
										</script>
									</div>
								</div>

								<input type="hidden" name="user_id" value="<?= $user_id; ?>" />
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
										<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("user"); ?>">Back</button>
									</div>
								</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php"); ?>
</body>

</html>