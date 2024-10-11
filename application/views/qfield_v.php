<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Quotation Fields</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Quotation Fields</h1>
			</div>			
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="">
							<div class="lead"><h3>Update Quotation Fields</h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_product">Show Product</label>
								<div class="col-sm-10">
								<select class="form-control" id="quotation_product" name="quotation_product">
									<option value="1" <?=($quotation_product==1)?"selected":"";?>>Ya</option>
									<option value="0" <?=($quotation_product==0)?"selected":"";?>>Tidak</option>
								</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_intro">Intro (Pembuka):</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_intro" name="quotation_intro"><?=$quotation_intro;?></textarea>
									<script>
										CKEDITOR.replace('quotation_intro');
									</script>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_workscope">Workscope:</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_workscope" name="quotation_workscope"><?=$quotation_workscope;?></textarea>
									<script>
										CKEDITOR.replace('quotation_workscope');
									</script>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_payment">Payment:</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_payment" name="quotation_payment"><?=$quotation_payment;?></textarea>
									<script>
										CKEDITOR.replace('quotation_payment');
									</script>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_closing">Closing (Penutup):</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_closing" name="quotation_closing"><?=$quotation_closing;?></textarea>
									<script>
										CKEDITOR.replace('quotation_closing');
									</script>	
								</div>
							</div>
							
							
							 			  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary btn-lg col-md-5" name="change" value="OK">Submit</button>
								</div>
							  </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
