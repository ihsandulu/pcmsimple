<!DOCTYPE html>
<html>
	<head>
		<title>Print Payroll List</title>
		<meta charset="utf-8">
		<meta name="viewgajirt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
         <?php 	
		require_once("meta.php");
		$month=date("n");
		if(isset($_REQUEST["month"])){
			$month=$_REQUEST["month"];
		}
		
		//bulan		
		$bulan_array = array(0=>"Bulan","Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
		?>
	</head>
	<body style="margin:0px;">
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
        <p style="font-size:24px; font-weight:bold;">Report Payroll List</p>
        <p>Month : <?=date("M Y",strtotime(date("Y-".$_GET['month']."-d")));?></p>
        <table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Month</th>
											<th>Branch</th>
											<th>User</th>
											<th>Payment</th>
											<th>Deduction</th>
											<th>Total Payment</th>
                                            <?php if(!isset($_GET['report'])){?>
											<th class="col-md-2">Action</th>
                                            <?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php 	
										$usr=$this->db
										->join("branch","branch.branch_id=gaji.branch_id","left")
										->where("gaji_month",$month)
										->where("gaji_year",date("Y"))
										->order_by("gaji_id","desc")
										->get("gaji");
										$total=0;
										$no=1;
										foreach($usr->result() as $gaji){
											$bulan = $bulan_array[$gaji->gaji_month];
										?>
										<tr>		
											<td><?=$no++;?></td>									
											<td><?=$bulan;?></td>
											<td><?=$gaji->branch_name;?></td>
											<td><?=$gaji->gaji_name;?></td>
											<td><?=number_format($pay=$gaji->gaji_rate*$gaji->gaji_numday,0,",",".");?></td>
											<td><?=number_format($deduction=$gaji->gaji_deduction_amount,0,",",".");?></td>
											<td><?=number_format($pay-$deduction,0,",",".");$total+=$pay-$deduction;?></td>
                                             <?php if(!isset($_GET['report'])){?>
											<td style="padding-left:0px; padding-right:0px;">
												
												<form method="post" class="col-md-4" style="padding:0px;">
													<a target="_blank" href="<?=site_url("gaji_print?gaji_no=".$gaji->gaji_no);?>" class="btn  btn-success"><span class="fa fa-print" style="color:white;"></span> </a>													
												</form>
                                                
                                                <form method="post" class="col-md-4" style="padding:0px;">
													<button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="gaji_id" value="<?=$gaji->gaji_id;?>"/>
												</form>
											
												<form method="post" class="col-md-4" style="padding:0px;">
													<button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="gaji_id" value="<?=$gaji->gaji_id;?>"/>
													<input type="hidden" name="gaji_source" value="<?=$gaji->gaji_source;?>"/>
													<input type="hidden" name="kas_id" value="<?=$gaji->kas_id;?>"/>
													<input type="hidden" name="petty_id" value="<?=$gaji->petty_id;?>"/>
												</form>                                             
												</td>
                                             <?php }?>
										</tr>
										<?php }?>
										<tr>
										  <td colspan="6"><h4>Total</h4></td>
										  <td>Rp <?=number_format($total,0,",",".");?></td>
										  
                                            <?php if(!isset($_GET['report'])){?><td style="padding-left:0px; padding-right:0px;">&nbsp;</td><?php }?>
									  </tr>
									</tbody>
								</table>
</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>