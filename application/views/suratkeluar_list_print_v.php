<!DOCTYPE html>
<html>
	<head>
		<title>Print Surat Keluar</title>
		<meta charset="utf-8">
		<meta name="viewsuratkeluarrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
         <?php 	
		require_once("meta.php");
		$dari=date("Y-m-d");
		$ke=date("Y-m-d");
		if(isset($_REQUEST["dari"])){
			$dari=$_REQUEST["dari"];
			$ke=$_REQUEST["ke"];
		}
		?>
	</head>
	<body style="margin:0px;">
        <p style="font-size:24px; font-weight:bold;">Report Out Mail List</p>
        <p>Period <?=date("d-m-Y",strtotime($dari));?> to <?=date("d-m-Y",strtotime($ke));?></p>
        <table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Branch</th>
											<th>Title</th>
											<th>User</th>
											<th>Remarks</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("branch","branch.branch_id=suratkeluar.branch_id","left")
										->where("suratkeluar_date >=",$dari)
										->where("suratkeluar_date <=",$ke)
										->order_by("suratkeluar_id","desc")
										->get("suratkeluar");
										$no=1;
										foreach($usr->result() as $suratkeluar){?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$suratkeluar->suratkeluar_date;?></td>
											<td><?=$suratkeluar->branch_name;?></td>
											<td><?=$suratkeluar->suratkeluar_title;?></td>
											<td><?=$suratkeluar->suratkeluar_user;?></td>
											<td><?=$suratkeluar->suratkeluar_remarks;?></td>
										</tr>
										<?php }?>
									</tbody>
								</table>
</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>