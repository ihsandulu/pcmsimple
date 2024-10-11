<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
	<style>
	input{padding:0px !important;}
	</style>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Laporan Penjualan</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Laporan Penjualan</h1>
			</div>			
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
							<div class="well">
							<?php 
							if(isset($_GET['dari'])){$dari=$_GET['dari'];}else{$dari="";}
							if(isset($_GET['ke'])){$ke=$_GET['ke'];}else{$ke="";}
							if(isset($_GET['user_id'])){$user_id=$_GET['user_id'];}else{$user_id="";}
							if(isset($_GET['branch_id'])){$branch_id=$_GET['branch_id'];}else{$branch_id="";}
							?>
							<form method="get" class="form-inline">
							<div class="form-group">
								<label>From : </label>
								<input id="dari" name="dari" type="date" class="form-control" value="<?=$dari;?>"/>
							</div>
							<div class="form-group">
								<label>To : </label>
								<input id="ke" name="ke" type="date" class="form-control" value="<?=$ke;?>"/>
							</div>
							<div class="form-group">
								<label>Marketing : </label>
								<select id="user_id" name="user_id" class="form-control">
								<option value="" <?=($user_id=="")?"selected":"";?>>Semua Marketing</option>
								<?php $user=$this->db
								->where("position_id","3")
								->get("user");
								foreach($user->result() as $user){?>
									<option value="<?=$user->user_id;?>" <?=($user_id==$user->user_id)?"selected":"";?>><?=$user->user_name;?></option>
								<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label>branch : </label>
								<select id="branch_id" name="branch_id" class="form-control">
								<option value="" <?=($branch_id=="")?"selected":"";?>>Semua branch</option>
								<?php $branch=$this->db
								->get("branch");
								foreach($branch->result() as $branch){?>
									<option value="<?=$branch->branch_id;?>" <?=($branch_id==$branch->branch_id)?"selected":"";?>><?=$branch->branch_name;?></option>
								<?php }?>
								</select>
							</div>
							<button type="submit" class="btn btn-warning fa fa-search"></button>
							<button type="button" onClick="cari()" class="btn btn-success fa fa-print"></button>
							<script>
							function cari(){
								window.open('<?=site_url("lappenjualanprint?dari=");?>'+$("#dari").val()+'&ke='+$("#ke").val()+'&user_id='+$("#user_id").val()+'&branch_id='+$("#branch_id").val(),'_blank');
							}
							</script>
							</form>
							</div>
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadbranch_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div style="margin-bottom:30px !important; border:black solid 1px; border-radius:5px; padding:5px;" align="center">
									<span style=" font-size:16px; font-weight:bold;">Laporan Penjualan Marketing: <span id="lappenjualan"></span></span>
									<div>
									<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){echo "From : ".date("d M Y",strtotime($_GET['dari']));}
										
										if(isset($_GET['ke'])&&$_GET['ke']!=""){echo "&nbsp;&nbsp;To : ".date("d M Y",strtotime($_GET['ke']));}
									?>
									</div>									
								</div>
								<div style="margin-bottom:10px !important;">
									<span style=" border-bottom:black solid 1px; font-size:16px; font-weight:bold;">Saldo : </span>	<span id="saldo"></span>							</div>
								<div id="collapse4" class="body table-responsive">				
									<table id="dataTable" class="table table-condensed table-hover table-bordered">
										<thead>
											<tr>
												<th>Date</th>
												<th>Inv No.</th>
												<th>Branch</th>
												<th>Customer</th>
												<th>Marketing</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody> 
											<?php 
											if(isset($_GET['dari'])&&$_GET['dari']!=""){
												$this->db->where("inv_date >=",$_GET['dari']);
											}
										
											if(isset($_GET['ke'])&&$_GET['ke']!=""){
												$this->db->where("inv_date <=",$_GET['ke']);
											}
										
											
											$totalpenjmarketing=0;
											$inv=$this->db
											->group_by("inv_no")
											->get("inv");
											$branch_name="";
											$user_name="";
											foreach($inv->result() as $inv){
												$total=0;
												$invproduct=$this->db
												->where("inv_no",$inv->inv_no)
												->get("invproduct");
												foreach($invproduct->result() as $invproduct){
													$total+=$invproduct->invproduct_qty*$invproduct->invproduct_price;
												}
												
												//echo $this->db->last_query(); 
												$customer_name="";
												$in=$this->db
												->join("user","user.user_id=inv.user_id","left")
												->where("inv_no",$inv->inv_no)
												->get("inv");
												foreach($in->result() as $in){
													$user_id=$in->user_id;
													$user_name=$in->user_name;
													if($identity->identity_project==1){
														$project=$this->db
														->join("customer","customer.customer_id=project.customer_id","left")
														->join("branch","branch.branch_id=customer.branch_id","left")
														->where("project_id",$in->project_id)
														->get("project");
														foreach($project->result() as $project){
															$branch_id=$project->branch_id;
															$branch_name=$project->branch_name;
															$customer_name=$project->customer_name;
														}														
													}else{
														if($in->inv_title=="customer_id"){
															$branch=$this->db
															->join("branch","branch.branch_id=customer.branch_id","left")														
															->where("customer_id",$in->inv_content)
															->get("customer");
															//echo $this->db->last_query();
															foreach($branch->result() as $branch){
																$branch_id=$branch->branch_id;
																$branch_name=$branch->branch_name;
																$customer_name=$branch->customer_name;
															}														
														}
													}	
												}
												
												
											$tampil=0;
											if(
												(isset($_GET["user_id"])&&$_GET["user_id"]==$user_id&&$_GET["user_id"]!="")
												&&
												(isset($_GET["branch_id"])&&$_GET["branch_id"]==$branch_id&&$_GET["branch_id"]!="")
											){
												$tampil=1;
											}			
											
											
											if(
												(isset($_GET["user_id"])&&$_GET["user_id"]==$user_id&&$_GET["user_id"]!="")
												&&
												(isset($_GET["branch_id"])&&$_GET["branch_id"]=="")
											){
												$tampil=1;
											}	
											
											
											if(
												(isset($_GET["user_id"])&&$_GET["user_id"]=="")
												&&
												(isset($_GET["branch_id"])&&$_GET["branch_id"]==$branch_id&&$_GET["branch_id"]!="")
											){
												$tampil=1;
											}													
											
											if(isset($_GET["user_id"])&&$_GET["user_id"]==""&&isset($_GET["branch_id"])&&$_GET["branch_id"]==""){
												$tampil=1;
											}
											
											if(!isset($_GET["user_id"])){
												$tampil=1;
											}
											
											if($tampil==1)
											{
											?>
											<tr>											
												<td><?=$inv->inv_date;?></td>											
												<td><?=$inv->inv_no;?></td>	
												<td style="text-align:left;"><?=$branch_name;?></td>
												<td style="text-align:left;"><?=$customer_name;?></td>
												<td style="text-align:left;"><?=$user_name;?></td>
												<td style="text-align:right;"><?=number_format($total,0,",",".");$totalpenjmarketing+=$total;?></td>											
											</tr>
											<?php }}?>
										</tbody>
									</table>
									<script>
									$("#saldo").html('Rp <?=number_format($totalpenjmarketing,0,",",".");?>');
									</script>
								</div>
								
							</div>
						
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
