<?php
	$dari=date("Y-m-d");
	$ke=date("Y-m-d");
	$cap="";
	if(isset($_REQUEST["dari"])){
		$dari=$_REQUEST["dari"];
		$ke=$_REQUEST["ke"];
	}
	if(isset($_REQUEST["cap"])){
		$cap=$_REQUEST["cap"];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Print Payment Invoice Supplier</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<style>
		.border{border:#999999 solid 1px;}
		.tebal{border:black solid 2px;}
		.bold{font-weight:bold;}
		.rincian{margin-left:30px;}
		.underline{text-decoration:underline;}
		@media print {
			.break {page-break-after: always;}
		}
		</style>
	</head>
	<body>
	
	<?php
	$nohalaman=1;
	if($identity_project==1){$halaman=3;?>
	<div class="container">
	<div class="row">
		<div style="margin-bottom:0px; padding:0px;">
					<div class="col-md-12 col-sm-12 col-xs-12 " style="padding:0px;">
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:90px; padding:5px;">
							<img src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:auto; height:60px; max-width:100%; position:relative; left:50%; top:50%; transform:translate(-50%,-50%); "/>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-9 border" style="height:90px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:24px; font-weight:bold;">EXPENSE REPORT</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:60px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;"><?=$identity_company;?></div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Rev.</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Issued Date</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Page</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px; ">Document No.</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;">00</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;"><?=date("d-M-Y");?></div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;"><?=$nohalaman++;?>/<?=$halaman;?></div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px; "><?=$invspayment_no;?></div>
						</div>
					</div>
                    <div style="clear:both;"></div>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-8" style=" padding:5px;">
			Employee / Project : <span style="text-decoration:underline;">All Project</span>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4" style=" padding:5px; margin-bottom:0px;">
			Date : <span style="text-decoration:underline;"><?=date("d-M-Y");?></span>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style=" padding:5px;">
			* Receipts MUST accompany all claims.<br/>
			** Claims MUST be approved General Manager
		</div>
		
		
		
		
			<div class="col-md-12" style="padding:0px; ">
				<table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">Date</th>
				  <th style="text-align:center;">CA No.</th>
				  <th style="text-align:center;">Client</th>
				  <th style="text-align:center;">Expense Details</th>
				  <th style="text-align:center;">Amount</th>
				</tr>	
			 
				<?php 
				function is_decimal( $val )
				{
					return is_numeric( $val ) && floor( $val ) != $val;
				}
				$no=1;$to=0;
				
		
				if(isset($_GET['dari'])){
					$this->db->where("invspayment_date >=",$this->input->get("dari"));
				}else{
					$this->db->where("invspayment_date >=",date("Y-m-d"));
				}
				
				if(isset($_GET['ke'])){
					$this->db->where("invspayment_date <=",$this->input->get("ke"));
				}else{
					$this->db->where("invspayment_date <=",date("Y-m-d"));
				}
				/*
				if(isset($_GET['cap'])){											
					switch($this->input->get("cap")){
						case "Project":
						$this->db->where("invspayment.project_id >",0);
						break;
						case "Office":
						$this->db->where("invspayment.project_id",0);
						break;
						default:
						break;
					}
				}	*/
				$cap="Project";
				$this->db->where("invspayment.project_id >",0);
				$prod=$this->db
				->join("biaya","biaya.biaya_id=invspaymentproduct.biaya_id","left")
				->join("invspayment","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
				->order_by("invspaymentproduct_id","desc")
				->get("invspaymentproduct");
				$total=0;
				$rowspan=0;
				foreach($prod->result() as $product){
				
				//cek row per payment
				$rprod=$this->db
				->where("invspayment_no",$product->invspayment_no)
				->get("invspaymentproduct");
				$rowspan=$rprod->num_rows();
				
				if($product->biaya_id>0){
					$invspaymentproduct_description=$product->biaya_name;
				}else{
					$invspaymentproduct_description=$product->invspaymentproduct_description;
				}
				?>
				<tr>
					<?php if($no==1){?>
				  <td style="text-align:center;" rowspan="<?=$rowspan;?>"><?=date("d-M-Y",strtotime($product->invspayment_date));?></td>
				  <td style="text-align:center;" rowspan="<?=$rowspan;?>"><?=$product->invspayment_no;?></td>
				  <td style="text-align:center;" rowspan="<?=$rowspan;?>"><?=$product->invspayment_payto;?></td>
				  <?php }
				  if($no<$rowspan){ $no++;}else{$no=1;}
				  ?>
				  <td style="text-align:left;">&nbsp;<?=$invspaymentproduct_description;?> <?=preg_match('/^\d+\.\d+$/',$product->invspaymentproduct_qty);?> x <?=number_format($product->invspaymentproduct_amount,0,",",".");?></td>
			      <td style="text-align:center;"><?=number_format($product->invspaymentproduct_amount*$product->invspaymentproduct_qty,0,",",".");$total+=$product->invspaymentproduct_amount*$product->invspaymentproduct_qty;?></td>
				</tr>
				<?php }?>
				<tr>
				  <td colspan="4" style="text-align:center;">TOTAL</td>
				  <td style="text-align:center;"><?=number_format($total,0,",",".");?></td>
			    </tr>
			  </table>
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Signature  : <span style="text-decoration:underline;"><?="";//$invspayment_receivedby;?></span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Approved  : <span style="text-decoration:underline;"><?="";//$invspayment_approvedby;?></span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Paid  : <span style="text-decoration:underline;"><?="";//$invspayment_prepareby;?></span>
			</div>
			<div class="col-md-offset-8 col-md-4 col-sm-offset-8 col-sm-4 col-xs-offset-8 col-xs-4" style="margin-bottom:5px;">
				Date  : <span style="text-decoration:underline;">_______________</span>
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Date  : <span style="text-decoration:underline;">_______________</span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Date  : <span style="text-decoration:underline;">_______________</span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Cheque No.  : <span style="text-decoration:underline;">_______________</span>
			</div>
		
	</div>
	</div>
	<div class="break"></div>
	<?php }else{$halaman=2;}
	
	?>
	<div class="container">
	<div class="row">
		<div style="margin-bottom:0px; padding:0px;">
					<div class="col-md-12 col-sm-12 col-xs-12 " style="padding:0px;">
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:90px; padding:5px;">
							<img src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:auto; height:60px; max-width:100%; position:relative; left:50%; top:50%; transform:translate(-50%,-50%); "/>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-9 border" style="height:90px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:24px; font-weight:bold;">EXPENSE REPORT</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:60px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;"><?=$identity_company;?></div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Rev.</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Issued Date</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Page</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px; ">Document No.</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;">00</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;"><?=date("d-M-Y");?></div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;"><?=$nohalaman++;?>/<?=$halaman;?></div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px; "><?=$invspayment_no;?></div>
						</div>
					</div>
                    <div style="clear:both;"></div>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-8" style=" padding:5px;">
			Employee / Project : <span style="text-decoration:underline;">Office</span>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4" style=" padding:5px; margin-bottom:0px;">
			Date : <span style="text-decoration:underline;"><?=date("d-M-Y");?></span>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style=" padding:5px;">
			* Receipts MUST accompany all claims.<br/>
			** Claims MUST be approved General Manager
		</div>
		
		
		
		
			<div class="col-md-12" style="padding:0px; ">
				<table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">Date</th>
				  <th style="text-align:center;">Receipt No.</th>
				  <th style="text-align:center;">Expense Details</th>
				  <th style="text-align:center;">Amount</th>
				</tr>	
			 
				<?php 
				
				$no=1;$to=0;
				
		
				if(isset($_GET['dari'])){
					$this->db->where("invspayment_date >=",$this->input->get("dari"));
				}else{
					$this->db->where("invspayment_date >=",date("Y-m-d"));
				}
				
				if(isset($_GET['ke'])){
					$this->db->where("invspayment_date <=",$this->input->get("ke"));
				}else{
					$this->db->where("invspayment_date <=",date("Y-m-d"));
				}
				
				/*
				if(isset($_GET['cap'])){											
					switch($this->input->get("cap")){
						case "Project":
						$this->db->where("invspayment.project_id >",0);
						break;
						case "Office":
						$this->db->where("invspayment.project_id",0);
						break;
						default:
						break;
					}
				}	*/
				$cap="Office";
				$this->db->where("invspayment.project_id",0);
				$prod=$this->db
				->join("biaya","biaya.biaya_id=invspaymentproduct.biaya_id","left")
				->join("invspayment","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
				->order_by("invspaymentproduct_id","desc")
				->get("invspaymentproduct");
				$total=0;
				$rowspan=0;
				foreach($prod->result() as $product){
				
				//cek row per payment
				$rprod=$this->db
				->where("invspayment_no",$product->invspayment_no)
				->get("invspaymentproduct");
				$rowspan=$rprod->num_rows();
				
				if($product->biaya_id>0){
					$invspaymentproduct_description=$product->biaya_name;
				}else{
					$invspaymentproduct_description=$product->invspaymentproduct_description;
				}
				?>
				<tr>
					<?php if($no==1){?>
				  <td style="text-align:center;" rowspan="<?=$rowspan;?>"><?=date("d-M-Y",strtotime($product->invspayment_date));?></td>
				  <td style="text-align:center;" rowspan="<?=$rowspan;?>"><?=$product->invspayment_no;?></td>
				  <?php }
				  if($no<$rowspan){ $no++;}else{$no=1;}
				  ?>
				  <td style="text-align:left;">&nbsp;<?=$invspaymentproduct_description;?> <?=preg_match('/^\d+\.\d+$/',$product->invspaymentproduct_qty);?> x <?=number_format($product->invspaymentproduct_amount,0,",",".");?></td>
			      <td style="text-align:center;"><?=number_format($product->invspaymentproduct_amount*$product->invspaymentproduct_qty,0,",",".");$total+=$product->invspaymentproduct_amount*$product->invspaymentproduct_qty;?></td>
				</tr>
				<?php }?>
				<tr>
				  <td style="text-align:center;">TOTAL</td>
				  <td style="text-align:center;">&nbsp;</td>
				  <td style="text-align:center;">&nbsp;</td>
				  <td style="text-align:center;"><?=number_format($total,0,",",".");?></td>
			    </tr>
			  </table>
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Signature  : <span style="text-decoration:underline;"><?="";//$invspayment_receivedby;?></span>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-8" style="margin-bottom:5px;">
				Approved  : <span style="text-decoration:underline;"><?="";//$invspayment_approvedby;?></span>
			</div>
			
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Date  : <span style="text-decoration:underline;">_______________</span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Date  : <span style="text-decoration:underline;">_______________</span>
			</div>
		
	</div>
	</div>
	<div class="break"></div>
	<div class="container">
	<div class="row">
		<div style="margin-bottom:0px; padding:0px;">
					<div class="col-md-12 col-sm-12 col-xs-12 " style="padding:0px;">
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:90px; padding:5px;">
							<img src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:auto; height:60px; max-width:100%; position:relative; left:50%; top:50%; transform:translate(-50%,-50%); "/>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-9 border" style="height:90px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:24px; font-weight:bold;">EXPENSE REPORT</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:60px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;"><?=$identity_company;?></div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Rev.</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Issued Date</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px;">Page</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:12px; ">Document No.</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;">00</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;"><?=date("d-M-Y");?></div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px;"><?=$nohalaman++;?>/<?=$halaman;?></div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 border" style="height:30px;">
							<div style="clear:both; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); font-size:9px; "><?=$invspayment_no;?></div>
						</div>
					</div>
                    <div style="clear:both;"></div>
		</div>
		
		<div class="col-md-offset-8 col-sm-offset-8 col-xs-offset-8 col-md-4 col-sm-4 col-xs-4" style=" padding:5px; margin-bottom:0px;">
			<?=$this->session->userdata("branch_name");?>, <?=date("d M Y");?>
		</div>
		
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
	  
	  <?php
		//cash dari dan ke kasbesar periode ini
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
		$this->db->where("kas_id >","0");
		$mas=$this->db
		->select("petty_inout, SUM(petty_amount)As masuk")
		->where("petty_inout","in")
		->group_by("petty_inout")
		->get("petty");
		
		if($mas->num_rows()>0){
			$maskb=$mas->row()->masuk;
		}else{
			$maskb=0;
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
		
		$this->db->where("kas_id >","0");
		$ker=$this->db
		->select("petty_inout, SUM(petty_amount)As keluar")
		->where("petty_inout","out")
		->group_by("petty_inout")
		->get("petty");
		
		if($ker->num_rows()>0){
			$kerkb=$ker->row()->keluar;
		}else{
			$kerkb=0;
		}
		
		$cashkb=$maskb-$kerkb;
	  ?>
					
						
		<table id="dataTable" class="table table-condensed table-hover" style="display:none;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Date</th>
					<th>Description</th>
					<th>Debet  </th>
					<th>Credit</th>
					<th>Saldo</th>
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
				
				$cashback=0;
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
				
				//ca back
				if(isset($_GET['dari'])){
					$this->db->where("invspayment_date >=",$this->input->get("dari"));
				}else{
					$this->db->where("invspayment_date >=",date("Y-m-d"));
				}
				
				if(isset($_GET['ke'])){
					$this->db->where("invspayment_date <=",$this->input->get("ke"));
				}else{
					$this->db->where("invspayment_date <=",date("Y-m-d"));
				}
				$caback=$this->db
				->where("petty_id >","0")
				->get("invspayment");
				//echo $this->db->last_query();
				foreach($caback->result() as $caback){
					$cashback+=$caback->invspayment_back;
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
			
		
		<div class="col-md-12 col-sm-12 col-xs-12" style=" padding:5px;">			
			<div class="col-md-12 col-sm-12 col-xs-12 bold">
				Arus Kas Masuk
			</div>	
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-md-7 col-sm-7 col-xs-7">
				Saldo Terakhir
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4">
				<?=number_format($cash,0,",",".");?>
			</div>	
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-md-7 col-sm-7 col-xs-7">
				Kas Masuk dari Kas Besar
			</div>		
			<div class="col-md-4 col-sm-4 col-xs-4">
				<?=number_format($maskb,0,",",".");?>
			</div>	
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-md-7 col-sm-7 col-xs-7">
				Pengembalian uang operational
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4">
				<?=number_format($cashback,0,",",".");?>
			</div>	
			<div class="col-md-8 col-sm-8 col-xs-8 bold">
				Total Arus Kas Masuk
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4 underline">
				<?=number_format($cash+$maskb+$kerkb,0,",",".");?>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style=" padding:5px;">			
			<div class="col-md-12 col-sm-12 col-xs-12 bold">
				Arus Kas Keluar
			</div>	
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-md-7 col-sm-7 col-xs-7">
				Pengeluaran untuk office
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4">
				<?=number_format($cnprojectk,0,",",".");?>
			</div>	
			<div class="col-md-offset-1 col-sm-offset-1 col-xs-offset-1 col-md-7 col-sm-7 col-xs-7">
				Pengeluaran untuk project
			</div>		
			<div class="col-md-4 col-sm-4 col-xs-4">
				<?=number_format($cprojectk,0,",",".");?>
			</div>	
			<div class="col-md-8 col-sm-8 col-xs-8 bold">
				Total Arus Kas Keluar
			</div>	
			<div class="col-md-4 col-sm-4 col-xs-4 underline">
				<?=number_format($cnprojectk+$cprojectk,0,",",".");?>
			</div>
		</div>
		
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px; height:50px;">
				Prepared By : <span style="text-decoration:underline;"><?="";//$invspayment_receivedby;?></span>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-8" style="margin-bottom:5px; height:50px;">
				Approved By : <span style="text-decoration:underline;"><?="";//$invspayment_approvedby;?></span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				<span style="text-decoration:underline;margin-top:50px;">_______________</span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				<span style="text-decoration:underline;margin-top:50px;">_______________</span>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				.
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Date  : 
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="margin-bottom:5px;">
				Date  : 
			</div>
		
	</div>
	</div>
	<div class="break"></div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>