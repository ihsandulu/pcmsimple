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
			
		<div style="margin-bottom:30px; border-bottom:black solid 3px; padding-bottom:30px;">
					<div class="col-md-8">
						<div class="col-md-6" style="height:90px;">
							<img src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:auto; height:100%; max-width:100%; position:relative; left:50%; top:50%; transform:translate(-50%,-50%); "/>
						</div>
						<div class="col-md-6" style="padding-left:10px;">
							<h3><?=$identity_company;?></h3>
							<span><?=$identity_slogan;?></span>
						</div>
					</div>
                    <div class="col-md-4" style="line-height: 100%; padding-top:7px;" align="right"><?=$identity_services;?></div>
                    <div style="clear:both;"></div>
		</div>
		
		<div class="row">
			<div class="col-md-10" style="border-bottom:black solid 1px; margin-top:-11px;  margin-bottom:25px; padding-top:15px; padding-bottom:15px;">
			<?php
			$in=$this->db
			->select("kas_inout, SUM(kas_count)As masuk")
			->where("kas_inout","in")
			->group_by("kas_inout")
			->get("kas")
			->row()
			->masuk;
			// $this->db->last_query();
			$ou=$this->db
			->select("kas_inout, SUM(kas_count)As keluar")
			->where("kas_inout","out")
			->group_by("kas_inout")
			->get("kas");
			if($ou->num_rows()>0){$out=$ou->row()->keluar;}else{$out=0;}
			$tcash=$in-$out;
			?>
				<h4 style=""> 
				<span style="font-weight:bold; float:left;">Cash Total (Rp. <?=number_format($tcash,0,",",".");?>)</span> | <span style="font-size:14px; float:right;">
			
							
							 
							  
							  <?php
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
								}else{$mas=0;}
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
								}else{$ker=0;}
								$cash=$mas-$ker;
							  ?>
							  Cash : <?=number_format($cash,0,",",".");?> On <?=date("d M Y",strtotime($this->input->get("dari")));?> To <?=date("d M Y",strtotime($this->input->get("ke")));?>
							  </span>
							  </h4>
							
						
			</div>
							
			<div class="col-md-10">				
			<table id="dataTable" class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Date</th>
						<th>Amount </th>
						<th>In/Out</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody> 
					<?php 
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
					->order_by("kas_id","desc")
					->get("kas");
					foreach($usr->result() as $kas){									
					?>
					<tr>											
						<td><?=$kas->kas_date;?></td>
						<td><?=number_format($kas->kas_count,0,",",".");?></td>
						<td><?=$kas->kas_inout;?></td>
						<td><?=$kas->kas_remarks;?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			</div>
		</div>
					
	

<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>
</body>

</html>
