<?php $identity=$this->db->get("identity")->row();?>
<!DOCTYPE html>
<html>
	<head>
		<title>Print Payroll</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
        <style>
		th,td{text-align:center;}
		</style>
	</head>
	<body>
        <div class="container">
            <div class="row">      
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
				<div class="box">
								<div style="margin-bottom:30px !important; border:black solid 1px; border-radius:5px; padding:5px;" align="center">
									<span style=" font-size:16px; font-weight:bold;">Laporan Penjualan Marketing : <span id="lappenjualan"></span></span>
									<div>
									<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){echo "From : ".date("d M Y",strtotime($_GET['dari']));}
										
										if(isset($_GET['ke'])&&$_GET['ke']!=""){echo "&nbsp;&nbsp;To : ".date("d M Y",strtotime($_GET['ke']));}
									?>
									</div>									
									
								</div>
								<div style="margin-bottom:10px !important;">
									<span style=" border-bottom:black solid 1px; font-size:16px; font-weight:bold;">Saldo : <span id="totalpembelian"></span><span id="saldo"></span>
									
								</div>
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
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 1500);
</script>