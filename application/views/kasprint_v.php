<!doctype html>
<html>

<head>
   <title>Print Cash</title>
	<meta charset="utf-8">
	<meta name="viewsjkeluarrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
  
</head>

<body class="  " >
			
		      
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
		
		<?php
			//cash sebelumnya
			if(isset($_GET['dari'])){
				$this->db->where("kas_date <",$this->input->get("dari"));
			}elseif(isset($_GET['ke'])){
				$this->db->where("kas_date <",$this->input->get("ke"));
			}else{
				$this->db->where("kas_date <",date("Y-m-d"));
			}
			
			$mas=$this->db
			->select("kas_inout, SUM(kas_count)As masuk")
			->where("kas_inout","in")
			->group_by("kas_inout")
			->get("kas");
			
			if($mas->num_rows()>0){
				$smas=$mas->row()->masuk;
			}else{
				$smas=0;
			}
			// $this->db->last_query();
			
			if(isset($_GET['dari'])){
				$this->db->where("kas_date <",$this->input->get("dari"));
			}if(isset($_GET['ke'])){
				$this->db->where("kas_date <",$this->input->get("ke"));
			}else{
				$this->db->where("kas_date <",date("Y-m-d"));
			}
			
			$ker=$this->db
			->select("kas_inout, SUM(kas_count)As keluar")
			->where("kas_inout","out")
			->group_by("kas_inout")
			->get("kas");
			
			if($ker->num_rows()>0){
				$sker=$ker->row()->keluar;
			}else{
				$sker=0;
			}
			
			$scash=$smas-$sker;
		  ?>							  
		  <?php
			//cash periode ini
			if(isset($_GET['dari'])){
				$this->db->where("kas_date >=",$this->input->get("dari"));
			}else{
				$this->db->where("kas_date >=",date("Y-m-d"));
			}
			
			if(isset($_GET['ke'])){
				$this->db->where("kas_date <=",$this->input->get("ke"));
			}else{
				$this->db->where("kas_date <=",date("Y-m-d"));
			}
			
			$mas=$this->db
			->select("kas_inout, SUM(kas_count)As masuk")
			->where("kas_inout","in")
			->group_by("kas_inout")
			->get("kas");
			
			if($mas->num_rows()>0){
				$mas=$mas->row()->masuk;
			}else{
				$mas=0;
			}
			// $this->db->last_query();
			
			if(isset($_GET['dari'])){
				$this->db->where("kas_date >=",$this->input->get("dari"));
			}else{
				$this->db->where("kas_date >=",date("Y-m-d"));
			}
			
			if(isset($_GET['ke'])){
				$this->db->where("kas_date <=",$this->input->get("ke"));
			}else{
				$this->db->where("kas_date <=",date("Y-m-d"));
			}
			
			$ker=$this->db
			->select("kas_inout, SUM(kas_count)As keluar")
			->where("kas_inout","out")
			->group_by("kas_inout")
			->get("kas");
			
			if($ker->num_rows()>0){
				$ker=$ker->row()->keluar;
			}else{
				$ker=0;
			}
			
			$cash=$mas-$ker;
		  ?>
			<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:18px; font-weight:bold; text-align:center; margin:20px;">Big Cash</div>				
			<div class="col-md-12 col-sm-12 col-xs-12">				
			<table id="dataTable" class="table table-condensed table-hover table-bordered">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Description</th>
											<th>Debet  </th>
											<th>Credit</th>
											<th>Balance</th>
											<?php if(!isset($_GET['report'])){?>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<tr>											
											<td>1</td>			
											<td id="dateawal"></td>
											<td style="text-align:left;">Dari Kantor</td>
											<td style="text-align:right;"><?=number_format($scash,0,",",".");?></td>
											<td style="text-align:right;"></td>
											<td style="text-align:right;"><?=number_format($scash,0,",",".");?></td>
											<?php if(!isset($_GET['report'])){?>
											<?php }?>
										</tr>
										<?php 
										if(isset($_GET['project'])){
											switch($_GET['project']){
												case "Project":
												$this->db->where("kas.project_id >","0");
												break;
												case "Non Project":
												$this->db->where("kas.project_id","0");
												break;
											}
										}
										if(isset($_GET['biaya'])){
											switch($_GET['biaya']){
												case "Tetap":
												$this->db->where("kas.biaya_id >","0");
												break;
												case "Tidak Tetap":
												$this->db->where("kas.biaya_id","0");
												break;
											}
										}
										if(isset($_GET['dari'])){
											$this->db->where("kas_date >=",$this->input->get("dari"));
										}else{
											$this->db->where("kas_date >=",date("Y-m-d"));
										}
										
										if(isset($_GET['ke'])){
											$this->db->where("kas_date <=",$this->input->get("ke"));
										}else{
											$this->db->where("kas_date <=",date("Y-m-d"));
										}
										$usr=$this->db
										->join("project","project.project_id=kas.project_id","left")
										->join("biaya","biaya.biaya_id=kas.biaya_id","left")
										->order_by("kas_id","desc")
										->get("kas");
										$no=2;
										$ctetap=0;
										$cttetap=0;
										$cprojectd=0;
										$cprojectk=0;
										$cnprojectd=0;
										$cnprojectk=0;
										$cash=$scash;
										$debet=$scash;
										$credit=0;
										//echo $this->db->last_query();
										foreach($usr->result() as $kas){	
										if($kas->kas_inout=="in"){$cash+=$kas->kas_count;$debet+=$kas->kas_count;}else{$cash-=$kas->kas_count;$credit+=$kas->kas_count;}								
										if($kas->biaya_id>0){
											$kas_remarks=$kas->biaya_name;
											if($kas->kas_inout=="in"){
												$biaya="";
											}
											if($kas->kas_inout=="out"){
												$biaya="Tetap";
												$ctetap=+$kas->kas_count;
											}
										}else{
											$kas_remarks=$kas->kas_remarks;
											if($kas->kas_inout=="in"){
												$biaya="";
											}
											if($kas->kas_inout=="out"){
												$biaya="Tidak Tetap";
												$cttetap=+$kas->kas_count;
											}
										}
										
										if($kas->project_id>0){
											if($kas->kas_inout=="in"){												
												$cprojectd=+$kas->kas_count;
											}
											if($kas->kas_inout=="out"){
												$cprojectk=+$kas->kas_count;
											}
										}else{
											if($kas->kas_inout=="in"){
												$cnprojectd=+$kas->kas_count;
											}
											if($kas->kas_inout=="out"){
												$cnprojectk=+$kas->kas_count;
											}
										}								
										?>
										<script>
											$("#ctetap").html("Rp <?=number_format($ctetap,0,",",".");?>");
											$("#cttetap").html("Rp <?=number_format($cttetap,0,",",".");?>");
											$("#cprojectd").html("Rp <?=number_format($cprojectd,0,",",".");?>");
											$("#cprojectk").html("Rp <?=number_format($cprojectk,0,",",".");?>");
											$("#cnprojectd").html("Rp <?=number_format($cnprojectd,0,",",".");?>");
											$("#cnprojectk").html("Rp <?=number_format($cnprojectk,0,",",".");?>");	
											$("#debet").html("Rp <?=number_format($debet,0,",",".");?>");
											$("#credit").html("Rp <?=number_format($credit,0,",",".");?>");	
											
											if('<?=$no;?>'==2){$("#dateawal").html("<?=$kas->kas_date;?>");}									
										</script>
										<tr>											
											<td><?=$no++;?></td>			
											<td><?=$kas->kas_date;?></td>
											<td style="text-align:left;"><?=$kas_remarks;?></td>
											<td style="text-align:right;"><?=($kas->kas_inout=="in")?number_format($kas->kas_count,0,",","."):"";?></td>
											<td style="text-align:right;"><?=($kas->kas_inout=="out")?number_format($kas->kas_count,0,",","."):"";?></td>
											<td style="text-align:right;"><?=number_format($cash,0,",",".");?></td>
											<?php if(!isset($_GET['report'])){?>
											<?php }?>
										</tr>
										<?php }?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="3" style="text-align:right; padding:9px;">&nbsp;Total :</th>
											<th style="text-align:right; padding:9px;"><?=number_format($debet,0,",",".");?>  </th>
											<th style="text-align:right; padding:9px;"><?=number_format($credit,0,",",".");?></th>
											<th style="text-align:right; padding:9px;"><?=number_format($cash,0,",",".");?></th>
											<?php if(!isset($_GET['report'])){?>
											<?php }?>
										</tr>
									</tfoot>
								</table>
			</div>
		</div>
					
	

<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>
</body>

</html>
