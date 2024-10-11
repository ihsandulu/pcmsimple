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
				$this->db->where("petty_date <",$this->input->get("dari"));
			}elseif(isset($_GET['ke'])){
				$this->db->where("petty_date <",$this->input->get("ke"));
			}else{
				$this->db->where("petty_date <",date("Y-m-d"));
			}
			
			$mas=$this->db
			->select("petty_inout, SUM(petty_amount)As masuk")
			->where("petty_inout","in")
			->group_by("petty_inout")
			->get("petty");
			
			if($mas->num_rows()>0){
				$smas=$mas->row()->masuk;
			}else{
				$smas=0;
			}
			// $this->db->last_query();
			
			if(isset($_GET['dari'])){
				$this->db->where("petty_date <",$this->input->get("dari"));
			}if(isset($_GET['ke'])){
				$this->db->where("petty_date <",$this->input->get("ke"));
			}else{
				$this->db->where("petty_date <",date("Y-m-d"));
			}
			
			$ker=$this->db
			->select("petty_inout, SUM(petty_amount)As keluar")
			->where("petty_inout","out")
			->group_by("petty_inout")
			->get("petty");
			
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
				$this->db->where("petty_date >=",$this->input->get("dari"));
			}else{
				$this->db->where("petty_date >=",date("Y-m-d"));
			}
			
			if(isset($_GET['ke'])){
				$this->db->where("petty_date <=",$this->input->get("ke"));
			}else{
				$this->db->where("petty_date <=",date("Y-m-d"));
			}
			
			$mas=$this->db
			->select("petty_inout, SUM(petty_amount)As masuk")
			->where("petty_inout","in")
			->group_by("petty_inout")
			->get("petty");
			
			if($mas->num_rows()>0){
				$mas=$mas->row()->masuk;
			}else{
				$mas=0;
			}
			// $this->db->last_query();
			
			if(isset($_GET['dari'])){
				$this->db->where("petty_date >=",$this->input->get("dari"));
			}else{
				$this->db->where("petty_date >=",date("Y-m-d"));
			}
			
			if(isset($_GET['ke'])){
				$this->db->where("petty_date <=",$this->input->get("ke"));
			}else{
				$this->db->where("petty_date <=",date("Y-m-d"));
			}
			
			$ker=$this->db
			->select("petty_inout, SUM(petty_amount)As keluar")
			->where("petty_inout","out")
			->group_by("petty_inout")
			->get("petty");
			
			if($ker->num_rows()>0){
				$ker=$ker->row()->keluar;
			}else{
				$ker=0;
			}
			
			$cash=$mas-$ker;
		  ?>
			<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:18px; font-weight:bold; text-align:center; margin:20px;">Petty Cash</div>				
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
												$this->db->where("petty.project_id >","0");
												break;
												case "Non Project":
												$this->db->where("petty.project_id","0");
												break;
											}
										}
										if(isset($_GET['biaya'])){
											switch($_GET['biaya']){
												case "Tetap":
												$this->db->where("petty.biaya_id >","0");
												break;
												case "Tidak Tetap":
												$this->db->where("petty.biaya_id","0");
												break;
											}
										}
										if(isset($_GET['dari'])){
											$this->db->where("petty_date >=",$this->input->get("dari"));
										}else{
											$this->db->where("petty_date >=",date("Y-m-d"));
										}
										
										if(isset($_GET['ke'])){
											$this->db->where("petty_date <=",$this->input->get("ke"));
										}else{
											$this->db->where("petty_date <=",date("Y-m-d"));
										}
										$usr=$this->db
										->join("project","project.project_id=petty.project_id","left")
										->join("biaya","biaya.biaya_id=petty.biaya_id","left")
										->order_by("petty_id","desc")
										->get("petty");
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
										foreach($usr->result() as $petty){	
										if($petty->petty_inout=="in"){$cash+=$petty->petty_amount;$debet+=$petty->petty_amount;}else{$cash-=$petty->petty_amount;$credit+=$petty->petty_amount;}								
										if($petty->biaya_id>0){
											$petty_remarks=$petty->biaya_name;
											if($petty->petty_inout=="in"){
												$biaya="";
											}
											if($petty->petty_inout=="out"){
												$biaya="Tetap";
												$ctetap=+$petty->petty_amount;
											}
										}else{
											$petty_remarks=$petty->petty_remarks;
											if($petty->petty_inout=="in"){
												$biaya="";
											}
											if($petty->petty_inout=="out"){
												$biaya="Tidak Tetap";
												$cttetap=+$petty->petty_amount;
											}
										}
										
										if($petty->project_id>0){
											if($petty->petty_inout=="in"){												
												$cprojectd=+$petty->petty_amount;
											}
											if($petty->petty_inout=="out"){
												$cprojectk=+$petty->petty_amount;
											}
										}else{
											if($petty->petty_inout=="in"){
												$cnprojectd=+$petty->petty_amount;
											}
											if($petty->petty_inout=="out"){
												$cnprojectk=+$petty->petty_amount;
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
											
											if('<?=$no;?>'==2){$("#dateawal").html("<?=$petty->petty_date;?>");}									
										</script>
										<tr>											
											<td><?=$no++;?></td>			
											<td><?=$petty->petty_date;?></td>
											<td style="text-align:left;"><?=$petty_remarks;?></td>
											<td style="text-align:right;"><?=($petty->petty_inout=="in")?number_format($petty->petty_amount,0,",","."):"";?></td>
											<td style="text-align:right;"><?=($petty->petty_inout=="out")?number_format($petty->petty_amount,0,",","."):"";?></td>
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
