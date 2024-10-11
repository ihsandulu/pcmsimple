<?php 
$identity=$this->db->get("identity")->row();
if(isset($_GET["listtable"])){?>
	<table id="dataTable1" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th>No.</th>
				<th>Date</th>
				<th>Creator</th>
				<th>Status</th>
				<th>Payment No. </th>
				<th>Payment</th>
				<th>Amount</th>
				<?php if($identity->identity_project=="1"){?>
				<th>Project</th>
				<?php }?>
				<th class="col-md-2">Action</th>
			</tr>
		</thead>
		<tbody> 
			<?php 
			if(!isset($_GET["tagihan"])){
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
			}
			if(isset($_GET['invs_no'])){											
				$this->db->where("invs_no",$this->input->get("invs_no"));
			}else{
				$this->db->where("invs_no","");
			}
			if($this->session->userdata("position_id")!=1&&$this->session->userdata("position_id")!=5&&$this->session->userdata("position_id")!=7){
				$this->db->where("invspayment.user_id",$this->session->userdata("user_id"));
			}	
			$usr=$this->db
			->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
			->join("user","user.user_id=invspayment.user_id","left")	
			->order_by("invspayment_id","desc")									
			->get("invspayment");
			$no=1;
			//echo $this->db->last_query();
			foreach($usr->result() as $invspayment){
				$invsppro_amount=0;
				$pr=$this->db
				->select("*,SUM(invspaymentproduct_amount*invspaymentproduct_qty)As invsppro_amount")
				->where("invspayment_no",$invspayment->invspayment_no)
				->group_by("invspayment_no")
				->get("invspaymentproduct");
				if($pr->num_rows()>0){$invsppro_amount=$pr->row()->invsppro_amount;}
				if($invspayment->invspayment_status=="CA Request"){
				$bmerah="bmerah";?>
				<script>
				setTimeout(function(){$(".bmerah").css({"background-color":"#FFCCCC"});},200);
				</script>
				<?php }else{
				$bmerah="";
				}
			?>
			<tr class="<?=$bmerah;?>">
				<td><?=$no++;?></td>
				<td><?=$invspayment->invspayment_date;?></td>											
				<td><?=$invspayment->user_name;?></td>										
				<td><?=$invspayment->invspayment_status;?></td>
				<td><?=$invspayment->invspayment_no;?></td>
				<td><?=$invspayment->methodpayment_name;?></td>
				<td id="tam<?=$invspayment->invspayment_id;?>"><?=number_format($invsppro_amount,0,",",".");?></td>
				<?php if($identity->identity_project=="1"){?>
				<td>
				<select  
				onChange="inputproject(this,'<?=htmlspecialchars($invspayment->invspayment_no, ENT_QUOTES);?>')" 
				id="project_id" name="project_id" class="form-control" required>
				
					<option value="0" <?=($invspayment->project_id=="0")?'selected="selected"':'';?>>
					Select Project                                                </option>
					
					<?php if($invspayment->project_id!="0"){?>
					<option value="<?=$invspayment->project_id;?>" <?=($invspayment->project_id!="0")?'selected="selected"':'';?>>
					  <?=$invspayment->project_name;?>
					</option>
					<?php }?>
					
					<?php $proj=$this->db->get("project");
						foreach($proj->result() as $project){?>
					<option value="<?=$project->project_id;?>" <?=($invspayment->project_id==$project->project_id)?'selected="selected"':'';?>> (
					  <?=$project->project_code;?>
					  )
					  <?=$project->project_name;?>
					</option>
					<?php }?>
				  </select>
				  
				  <script>
				  function inputproject(a,b){
				  $.get("<?=site_url("api/inputproject_paymentsupplier");?>",{project_id:a.value,invspayment_no:b})
				  .done(function(data){
				  window.location.href='<?=current_url();?>?message='+data;
				   $("#messageisi").html(data);
				   $("#message").show();
				   setTimeout(function(){$("#message").hide();},2000);
				  });
				  }
				  </script>                                            </td>
				<?php }?>
				<td style="padding-left:0px; padding-right:0px;">	 
					<form method="POST" class="col-md-2" style="padding:0px;">
						<?php if(isset($_GET['invs_no'])){$invs_no=$_GET['invs_no'];}else{$invs_no="";}?>
						<?php if(isset($_GET['supplier_id'])){$supplier_id=$_GET['supplier_id'];}else{$supplier_id="";}?>
					  <button onClick="awal('<?=$invspayment->invspayment_no;?>')" type="button" data-toggle="tooltip" title="Charge Item" target="_blank" href="<?=site_url("invspaymentproduct?invspayment_no=".$invspayment->invspayment_no."&invs_no=".$invs_no."&supplier_id=".$supplier_id);?>" class="btn btn-xs btn-info" style="margin:0px;">
					  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </button>
					</form> 
					<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5||$this->session->userdata("position_id")==7)&&isset($_GET['invs_no'])&&$_GET['invs_no']!=""){?>		 
					<form method="POST" class="col-md-2" style="padding:0px;">
					  <a data-toggle="tooltip" title="Print Payment" target="_blank" href="<?=site_url("invspaymentprint?invspayment_no=".$invspayment->invspayment_no);?>" class="btn btn-xs btn-success" style="margin:0px;">
					  <span class="fa fa-print" style="color:white;"></span>											  </a>
					</form> 
					<?php }?>
					<?php //if($this->session->userdata("position_id")!=5&&$invspayment->invspayment_status=="CA Request"){?>		<?php if(($invspayment->user_id==$this->session->userdata("user_id"))||$this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5){?>
					<form method="post" class="col-md-2" style="padding:0px;">
						<button class="btn btn-xs btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;margin:0px;"></span> </button>
						<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
					</form>
					<?php }?>
					<form method="post" class="col-md-2" style="padding:0px;">
						<button class="btn btn-xs btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;margin:0px;"></span> </button>
						<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
						<input type="hidden" name="invspayment_no" value="<?=$invspayment->invspayment_no;?>"/>
					</form>		
				
					<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==7)&&$invspayment->invspayment_status=="CA Request"){?>	
					<form method="post" class="col-md-2" style="padding:0px;">
						<button type="button" title="Approve" data-toggle="tooltip" class="btn btn-xs btn-success" onClick="setujui('<?=$invspayment->invspayment_id;?>')"><span class="fa fa-check-square" style="color:white;margin:0px;"></span> </button>
					</form>	
					<?php }?>		
					<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5)&&$invspayment->invspayment_status=="CA Request Approved"){?>	
					<form method="post" class="col-md-2" style="padding:0px;">
						<button type="button" title="Pay CA Request" data-toggle="tooltip" class="btn btn-xs btn-success" onClick="payca('<?=$invspayment->invspayment_id;?>')"><span class="fa fa-money" style="color:white;margin:0px;"></span> </button>
					</form>	
					<?php }?>	
					<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5)&&$invspayment->invspayment_status=="CA Out"){?>		
					<form method="post" class="col-md-2" style="padding:0px;">
						<button title="CA Settlement" data-toggle="tooltip" class="btn btn-xs btn-success " name="settlement" value="OK"><span class="fa fa-edit" style="color:white;margin:0px;"></span> </button>
						<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
						<input type="hidden" name="invspayment_no" value="<?=$invspayment->invspayment_no;?>"/>
					</form>
					<?php }?>
					<?php if(!isset($_POST['invs_no'])){?>	
					<a target="_blank" href="<?=site_url("expense?invspayment_no=".$invspayment->invspayment_no);?>" class="btn btn-xs btn-success col-md-2" data-toggle="tooltip" title="Expense" ><span class="fa fa-print" style="color:white;margin:0px;"></span> </a>	
					<?php }?>						
					</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<script>
	 $('#dataTable1').DataTable( {
			"order": [[ 0, "asc" ]],
			 "iDisplayLength": 25
		} );
	</script>
<?php }else{?>

<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
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
	if(!isset($_GET["invs_no"])){		
		$listjudul="Cash Advance";
		$judul="Cash Advance";
	}else{
		$listjudul="Account Payable";
		$judul="Account Payable No. ".$this->input->get("invs_no");
	}
	?>
	<style>
	.btn-xs{margin-bottom:10px;}
	.bmerah{background-color:#FFCCCC;}
	.ciformi{padding:20px !important;}
	.judul{font-size:18px; font-weight:bold; margin-top:0px; margin-bottom:20px; padding:10px; background:#F2F2F2; text-align:center;}
	.kanan{float:right;}
	</style>
	<script>
	<?php
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
	$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	if(isset($_GET['invs_no'])){$invsno=$_GET['invs_no'];}else{$invsno="";}
	?>
	function listtable(){
		$.ajax({
		  url: "<?=$currentUrl;?>",
		  method: "GET",
		  data: { listtable:'OK',tagihan:'<?=(isset($_GET['tagihan']))?$this->input->get("tagihan"):"";?>'},
		  dataType: "html"
		})
		.done(function( msg ) {//alert(msg);
		  $( "#listutama" ).html( msg );
		  $( "#chargeitem" ).modal( "hide" );
		}).fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}
	</script>
	<script>
	function awal(invspayment_no){
		$.ajax({
		  url: "<?=site_url("invspaymentproduct?invs_no=".$invsno);?>",
		  method: "GET",
		  data: { invspayment_no : invspayment_no },
		  dataType: "html"
		})
		.done(function( msg ) {
		  $( "#ciform" ).html( msg );
		  $("#chargeitem").modal("show");
		}).fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}
	</script>
	<script>
	function baru(invspaymentproduct_id,invspayment_no){
		$.ajax({
		  url: "<?=site_url("invspaymentproduct?invs_no=".$invsno."&invspayment_no=");?>"+invspayment_no,
		  method: "POST",
		  data: { invspaymentproduct_id : invspaymentproduct_id, new:'OK', invspayment_no:invspayment_no },
		  dataType: "html"
		})
		.done(function( msg ) {
		  $( "#ciform" ).html( msg );
		}).fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}
	</script>
	<script>
	
	function edita(invspaymentproduct_id,invspayment_no){
		$.ajax({
		  url: "<?=site_url("invspaymentproduct?invs_no=".$invsno."&invspayment_no=");?>"+invspayment_no,
		  method: "POST",
		  data: { invspaymentproduct_id : invspaymentproduct_id, edit:'OK', invspayment_no:invspayment_no },
		  dataType: "html"
		})
		.done(function( msg ) {
		  $( "#ciform" ).html( msg );
		}).fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}
	
	</script>
	<script>
	function deleta(invspayment_no,invspaymentproduct_id,invspaymentproduct_source,kas_id,petty_id){		
		$.ajax({
		  url: "<?=site_url("invspaymentproduct?invs_no=".$invsno."&invspayment_no=");?>"+invspayment_no,
		  method: "POST",
		  data: { delete:'OK', invspaymentproduct_id:invspaymentproduct_id, invspaymentproduct_source:invspaymentproduct_source, kas_id:kas_id, petty_id:petty_id  },
		  dataType: "html"
		})
		.done(function( msg ) {
		  $( "#ciform" ).html( msg );
		}).fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}
	
	</script>
	<script>
	function cu(cu,invspaymentproduct_source,biaya_id,invspaymentproduct_description,invspaymentproduct_amount,invspaymentproduct_qty,invspaymentproduct_id,petty_id,kas_id,invspayment_no){
	//alert(invspaymentproduct_source+"/"+biaya_id+"/"+invspaymentproduct_description+"/"+invspaymentproduct_amount+"/"+invspaymentproduct_qty+"/"+invspaymentproduct_id+"/"+petty_id+"/"+kas_id+"/"+invspayment_no);
		$.ajax({
		  url: "<?=site_url("invspaymentproduct?invs_no=".$invsno."&invspayment_no=");?>"+invspayment_no,
		  method: "POST",
		  data: { cu:cu,invspaymentproduct_source:invspaymentproduct_source,biaya_id:biaya_id,invspaymentproduct_description:invspaymentproduct_description,invspaymentproduct_amount:invspaymentproduct_amount,invspaymentproduct_qty:invspaymentproduct_qty,invspaymentproduct_id:invspaymentproduct_id,petty_id:petty_id,kas_id:kas_id,invspayment_no:invspayment_no },
		  dataType: "html"
		})
		.done(function( msg ) {
		  $( "#ciform" ).html( msg );
		}).fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	}
	</script>
	<script>
	
	const formatter = new Intl.NumberFormat('id-ID', {
	  style: 'currency',
	  currency: 'IDR',
	  minimumFractionDigits: 0
	})
	
	</script>
	<script>

	function cashback(invspayment_id,invspayment_back){
		$.ajax({
		url:"<?=current_url();?>",
		method:"POST",
		data:{caback:"OK",invspayment_id:invspayment_id,invspayment_back:invspayment_back},
		dataType:"html"
		})
		.done(function(data){//alert(data);		
			$("#isicaback"+invspayment_id).html(formatter.format(invspayment_back));
			$("#hasilcaback"+invspayment_id).show();
			$("#editcaback"+invspayment_id).hide();
		});
	}
	
	</script>
	<script>
	function editcaback(invspayment_id){
		$("#hasilcaback"+invspayment_id).hide();
		$("#editcaback"+invspayment_id).show();
	}
	</script>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	
	<div id="caback" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"  onClick="listtable()">&times;</button>
			<h4 class="modal-title">Charge Item</h4>
		  </div>
		  <div class="modal-body" id="cibackform">
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"  onClick="listtable()">Close</button>
		  </div>
		</div>
	
	  </div>
	</div>
	
	<div id="chargeitem" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"  onClick="listtable()">&times;</button>
			<h4 class="modal-title">Charge Item</h4>
		  </div>
		  <div class="modal-body" id="ciform">
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"  onClick="listtable()">Close</button>
		  </div>
		</div>
	
	  </div>
	</div>
	
	<div id="approvemodal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Approve CA Request</h4>
		  </div>
		  <div class="modal-body">
			<form method="post">
				<div class="col-md-12 text-center" style="margin-bottom:20px;">
					Are you sure to approve this CA Request?
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
				</div>
				<div class="col-md-6">
					<button name="approve" value="OK" type="submit" class="btn btn-success btn-block">Approve</button>
				</div>
				<input type="hidden" name="invspayment_id" class="invspaymentid"/>
			</form>
			<div style="clear:both;"></div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	
	  </div>
	</div>
	
	<div id="caoutmodal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">CA Out</h4>
		  </div>
		  <div class="modal-body">
			<form method="post">
				<div class="col-md-12 text-center" style="margin-bottom:20px;">
					Are you sure to pay this CA Request?
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
				</div>
				<div class="col-md-6">
					<button name="caout" value="OK" type="submit" class="btn btn-success btn-block">Pay</button>
				</div>
				<input type="hidden" name="invspayment_id" class="invspaymentid"/>
			</form>
			<div style="clear:both;"></div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	
	  </div>
	</div>
	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active"><?=$listjudul;?></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header" style="float:left;"><?=$judul;?></h1>
				<h4 class="page-header" style="color:red; position:relative; top:5px;"><?=(isset($_GET['tagihan']))?"Tagihan Rp ".number_format($this->input->get("tagihan"),0,",","."):"";?></h4>
			</div>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 		
				<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_POST['settlement'])&&!isset($_POST['bukti'])){?>		
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<?php if(isset($_GET["invs_no"])){?>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<?php }?>
				<input type="hidden" name="invspayment_id" value="0"/>
				<?php }else{?>
				<a type="button"  href="<?=current_url("invspayment")."?".$_SERVER['QUERY_STRING'];?>" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</a>
				<?php }?>
				</h1>
			</form>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<?php
						if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5||$this->session->userdata("position_id")==7)&&$invspayment_status==""){
							$show="display:block;";
							$invspayment_status="CA Out";
						}elseif(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5||$this->session->userdata("position_id")==7)&&$invspayment_status!="CA Request"){
							$show="display:block;";
						}elseif($this->session->userdata("position_id")!=5&&$invspayment_status==""){
							$show="display:none;";
							$invspayment_status="CA Request";
						}else{
							$show="display:none;";
						}?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update ".$invspayment_status;}else{$namabutton='name="create"';$judul="New ".$invspayment_status;}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<?php if(isset($_POST['settlement'])){$readonly='readonly=""';}else{$readonly='';}?>
							
							  <div class="form-group" style="<?=$show;?>">
								<label class="control-label col-sm-2" for="unit_id">Payment:</label>
								<div class="col-sm-10">
									<select name="methodpayment_id" class="form-control">
										<option value="" <?=($methodpayment_id=="")?"selected":"";?>>
											Choose Payment
										</option>
									<?php $met=$this->db->get("methodpayment");
									foreach($met->result() as $meth){?>
										<option value="<?=$meth->methodpayment_id;?>" <?=($meth->methodpayment_id==$methodpayment_id)?"selected":"";?>>
											<?=$meth->methodpayment_name;?>
										</option>
									<?php }?>
								  	</select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_payto"><?=(isset($_REQUEST['invs_no']))?"Pay to":"Requestor";?> :</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_payto" name="invspayment_payto"  value="<?=$invspayment_payto;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_department"><?=(isset($_REQUEST['invs_no']))?"Received":"Requestor";?> Department :</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_department" name="invspayment_department"  value="<?=$invspayment_department;?>">
								</div>
							  </div>
							  <?php if(!isset($_REQUEST['invs_no'])){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_purpose">Requestor Purpose :</label>
								<div class="col-sm-10">
								  <select <?=$readonly;?> autofocus class="form-control" id="invspayment_purpose" name="invspayment_purpose">
								  <option value="" <?=($invspayment_purpose=="")?"selected":"";?>>Choose Purpose</option>
								  <option value="Meal Allowance" <?=($invspayment_purpose=="Meal Allowance")?"selected":"";?>>Meal Allowance</option>
								  <option value="Operational Project" <?=($invspayment_purpose=="Operational Project")?"selected":"";?>>Operational Project</option>
								  <option value="Operational Marketing" <?=($invspayment_purpose=="Operational Marketing")?"selected":"";?>>Operational Marketing</option>
								  <option value="Office" <?=($invspayment_purpose=="Office")?"selected":"";?>>Office</option>
								  <option value="QHSE" <?=($invspayment_purpose=="QHSE")?"selected":"";?>>QHSE</option>
								  <option value="Other" <?=($invspayment_purpose=="Other")?"selected":"";?>>Other</option>
								  </select>
								</div>
							  </div>
							  <?php }?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_prepareby">Prepared By *:</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_prepareby" name="invspayment_prepareby"  value="<?=$invspayment_prepareby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_receivedby">Received By (<?=(isset($_REQUEST['invs_no']))?"Supplier":"Client";?>)*:</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_receivedby" name="invspayment_receivedby"  value="<?=$invspayment_receivedby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_approvedby">Approve By :</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_approvedby" name="invspayment_approvedby"  value="<?=$invspayment_approvedby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_date">Date:</label>
								<div class="col-sm-10">
								  <input required type="text" <?=$readonly;?> autocomplete="off" autofocus class="form-control date" id="invspayment_date" name="invspayment_date" placeholder="Enter Date" value="<?=$invspayment_date;?>">
								</div>
							  </div>
							  <?php if($user_id==""||$user_id=="0"){?>
							  <input type="hidden" name="user_id" value="<?=$this->session->userdata("user_id");?>"/>
							  <?php }?>
							  <input type="hidden" name="invspayment_status" value="<?=$invspayment_status;?>"/>	
							  <input type="hidden" name="invspayment_id" value="<?=$invspayment_id;?>"/>	
							  <input type="hidden" name="invs_no" value="<?=$this->input->get("invs_no");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("invspayment");?>">Back</button>
								</div>
							  </div>
							</form>
							
						</div>
						<?php }elseif(isset($_POST['settlement'])){?>		
					<?php if($uploadinvspaymentpicture_name!=""){$display="display:block;";}else{$display="display:none;";}?>
						<div id="message" class="alert alert-info alert-dismissable" style="<?=$display;?>">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong id="messageisi"><?=$uploadinvspaymentpicture_name;?></strong>
						</div>				
						<div class="">							
							<div class="lead"><h3>Settlement</h3></div>
							<div id="collapse4" class="body table-responsive">				
								<table id="" class="table table-condensed table-hover">
									<thead>
										<tr>
										  	<th>Date</th>
										  	<th>Creator</th>
											<th>Status</th>
											<th>Payment No. </th>
											<th>Payment</th>
											<th>Amount</th>
											<?php if($identity->identity_project=="1"){?>
											<th>Project</th>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['invs_no'])){											
											$this->db->where("invs_no",$this->input->get("invs_no"));
										}else{
											$this->db->where("invs_no","");
										}
										if($this->session->userdata("position_id")!=1&&$this->session->userdata("position_id")!=5&&$this->session->userdata("position_id")!=7){
											$this->db->where("invspayment.user_id",$this->session->userdata("user_id"));
										}	
										$usr=$this->db
										->join("project","project.project_id=invspayment.project_id","left")
										->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
										->join("user","user.user_id=invspayment.user_id","left")	
										->where("invspayment_id",$this->input->post("invspayment_id"))									
										->get("invspayment");
										$no=1;
										//echo $this->db->last_query();
										foreach($usr->result() as $invspayment){
											$invsppro_amount=0;
											$pr=$this->db
											->select("*,SUM(invspaymentproduct_amount*invspaymentproduct_qty)As invsppro_amount")
											->where("invspayment_no",$invspayment->invspayment_no)
											->group_by("invspayment_no")
											->get("invspaymentproduct");
											if($pr->num_rows()>0){$invsppro_amount=$pr->row()->invsppro_amount;}
											if($invspayment->invspayment_status=="CA Request"){
											$bmerah="bmerah";?>
											<script>
											setTimeout(function(){$(".bmerah").css({"background-color":"#FFCCCC"});},200);
											</script>
											<?php }else{
											$bmerah="";
											}
										?>
										<tr class="<?=$bmerah;?>">
										  	<td><?=$invspayment->invspayment_date;?></td>											
											<td><?=$invspayment->user_name;?></td>										
											<td><?=$invspayment->invspayment_status;?></td>
											<td><?=$invspayment->invspayment_no;?></td>
											<td><?=$invspayment->methodpayment_name;?></td>
											<td><?=number_format($invsppro_amount,0,",",".");?></td>
											<?php if($identity->identity_project=="1"){?>
											<td><?=$invspayment->project_name;?></td>
											<?php }?>
										</tr>
										<?php }?>
									</tbody>
								</table>
						  </div>
						  	<div class="lead">
							<h5>Charge Item</h5>
							<!--<div>
								<a data-toggle="tooltip" title="Charge Item" target="_blank" href="<?=site_url("invspaymentproduct?invspayment_no=".$invspayment->invspayment_no."&invs_no=".$invs_no."&supplier_id=");?>" class="btn btn-sm btn-info" style="margin:20px;">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>	Change Charge Item										  </a>
								<div style="clear:both;"></div>
							</div>-->
							</div>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  	<th>CA No.</th>
										  	<th>Cash Back</th>
										  	<th>Source</th>
											<th>Description</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("invspayment","invspayment.invspayment_no=invspaymentproduct.invspayment_no","left")
										->where("invspaymentproduct.invspayment_no",$this->input->post("invspayment_no"))
										->order_by("invspaymentproduct_id","desc")
										->get("invspaymentproduct");
										//echo $this->db->last_query();
										$no=1;
										$nos=1;
										foreach($usr->result() as $invspaymentproduct){
										//cek rows ca
										$rowsca=$this->db
										->where("invspayment_no",$invspaymentproduct->invspayment_no)
										->get("invspaymentproduct")
										->num_rows();
										
										if($invspaymentproduct->invspaymentproduct_source=="petty_id"){$source="Petty Cash";}else{$source="Big Cash";}
										?>
										<tr>
											<?php if($nos==1){$nos++;?>
											<td rowspan="<?=$rowsca;?>"><?=$no++;?></td>
											<td rowspan="<?=$rowsca;?>"><?=$invspaymentproduct->invspayment_no;?></td>
											<td rowspan="<?=$rowsca;?>">
											<form class="form-inline" id="editcaback<?=$invspaymentproduct->invspayment_id;?>" style="display:none;">
											<div class="form-group">
											<input id="invspayment_back<?=$invspaymentproduct->invspayment_id;?>" class="form-control" value="<?=$invspaymentproduct->invspayment_back;?>"/>
											<button type="button" onClick="cashback('<?=$invspaymentproduct->invspayment_id;?>',$('#invspayment_back<?=$invspaymentproduct->invspayment_id;?>').val())" class="btn btn-lg btn-success fa fa-check"></button>
											</div>
											</form>
											<div id="hasilcaback<?=$invspaymentproduct->invspayment_id;?>">
											<span id="isicaback<?=$invspaymentproduct->invspayment_id;?>">Rp<?=number_format($invspaymentproduct->invspayment_back,0,",",".");?></span>&nbsp;
											<button onClick="editcaback('<?=$invspaymentproduct->invspayment_id;?>')" title="CA Back" data-toggle="tooltip" class="btn btn-xs btn-success fa fa-edit"></button>
											</div>
											
											</td>
											<?php }?>
											<td><?=$source;?></td>											
											<td><?=$invspaymentproduct->invspaymentproduct_description;?></td>
											<td><?=$invspaymentproduct->invspaymentproduct_qty;?></td>
											<td><?=number_format($invspaymentproduct->invspaymentproduct_amount,0,",",".");?></td>
											<td><?=number_format($invspaymentproduct->invspaymentproduct_amount*$invspaymentproduct->invspaymentproduct_qty,0,",",".");?></td>
											
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
						  
						  	<div class="lead"><h3>File for Evidence</h3></div>
							<form class="form-horizontal col-md-6" method="post" enctype="multipart/form-data">	
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspaymentpicture_name">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="invspaymentpicture_name" name="invspaymentpicture_name"><br/>							
								  <img id="invspaymentpicture_name_image" src="<?=base_url("assets/images/invspaymentpicture/noimage.png");?>" style="width:100%; height:auto;"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invspaymentpicture_name_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invspaymentpicture_name").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <input type="hidden" name="invspayment_id" value="<?=$this->input->post("invspayment_id");?>"/> 
							  <input type="hidden" name="settlement" value="OK"/>  
							  <div class="form-group"> 
								<div class="col-sm-12">
									<button type="submit" id="submit" class="btn btn-primary col-md-12" nama="settle" value="OK">Submit</button>
								</div>
							  </div>
							</form>
							<div class="col-md-6" style="padding:5px;">
								<?php 
								$pic=$this->db
								->where("invspayment_id",$this->input->post("invspayment_id"))
								->get("invspaymentpicture");
								foreach($pic->result() as $pic){?>
								<div class="col-md-4">
									<img onClick="tampil(this)" src="<?=base_url("assets/images/invspaymentpicture/".$pic->invspaymentpicture_name);?>" style="width: 100%; height: 150px; object-fit: cover; box-shadow:grey 1px 1px 1px; cursor:pointer;"/>
									<div>
										<a target="_blank" href="<?=base_url("assets/images/invspaymentpicture/".$pic->invspaymentpicture_name);?>" class="btn btn-xs btn-warning" style="position:absolute; bottom:0px; right:15px;"><i class="fa fa-print"></i></a>
										<form method="post">
										<button name="deletegambar" value="<?=$pic->invspaymentpicture_id;?>" class="btn btn-xs btn-danger" style="position:absolute; bottom:0px; left:15px;"><i class="fa fa-close"></i></button>
							  			<input type="hidden" name="settlement" value="OK"/>   
										<input type="hidden" name="invspayment_id" value="<?=$this->input->post("invspayment_id");?>"/>
										<input type="hidden" name="invspayment_no" value="<?=$this->input->post("invspayment_no");?>"/>
										</form>
									</div>
								</div>
								<?php }?>
								<script>
								function tampil(a){
									var gambar=$(a).attr("src");
									$("#imgumum").attr("src",gambar);
									$("#myImage").modal("show");
								}
								</script>
							</div>
						</div>
						<?php }elseif(isset($_POST['bukti'])){?>
						<div class="lead"><h3>File for Evidence</h3></div>
							<form class="form-horizontal col-md-6" method="post" enctype="multipart/form-data">	
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspaymentpicture_name">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="invspaymentpicture_name" name="invspaymentpicture_name"><br/>							
								  <img id="invspaymentpicture_name_image" src="<?=base_url("assets/images/invspaymentpicture/noimage.png");?>" style="width:100%; height:auto;"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invspaymentpicture_name_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invspaymentpicture_name").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <input type="hidden" name="invspayment_id" value="<?=$this->input->post("invspayment_id");?>"/> 
							  <div class="form-group"> 
								<div class="col-sm-12">
									<button type="submit" id="submit" class="btn btn-primary col-md-12" name="bukti" value="OK">Submit</button>
								</div>
							  </div>
							</form>
							<div class="col-md-6" style="padding:5px;">
								<?php 
								$pic=$this->db
								->where("invspayment_id",$this->input->post("invspayment_id"))
								->get("invspaymentpicture");
								foreach($pic->result() as $pic){?>
								<div class="col-md-4">
									<img onClick="tampil(this)" src="<?=base_url("assets/images/invspaymentpicture/".$pic->invspaymentpicture_name);?>" style="width: 100%; height: 150px; object-fit: cover; box-shadow:grey 1px 1px 1px; cursor:pointer;"/>
									<div>
										<a target="_blank" href="<?=base_url("assets/images/invspaymentpicture/".$pic->invspaymentpicture_name);?>" class="btn btn-xs btn-warning" style="position:absolute; bottom:0px; right:15px;"><i class="fa fa-print"></i></a>
										<form method="post">
										<button name="deletegambar" value="<?=$pic->invspaymentpicture_id;?>" class="btn btn-xs btn-danger" style="position:absolute; bottom:0px; left:15px;"><i class="fa fa-close"></i></button>
							  			<input type="hidden" name="bukti" value="OK"/>   
										<input type="hidden" name="invspayment_id" value="<?=$this->input->post("invspayment_id");?>"/>
										<input type="hidden" name="invspayment_no" value="<?=$this->input->post("invspayment_no");?>"/>
										</form>
									</div>
								</div>
								<?php }?>
								<script>
								function tampil(a){
									var gambar=$(a).attr("src");
									$("#imgumum").attr("src",gambar);
									$("#myImage").modal("show");
								}
								</script>
							</div>
						<?php }else{?>		
							<?php if($message!=""){$display="display:block;";}else{$display="display:none;";}?>
							
							<div id="message" class="alert alert-info alert-dismissable" style="<?=$display;?>">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong id="messageisi"><?=$message;?></strong>
							</div>
							<div class="box">
							<?php if(!isset($_GET['tagihan'])){?>
								<div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
								<form class="form-inline">
								  <div class="form-group">
									<label for="email">From:</label>
									<input onChange="hrefurl('#expenseprint','expense')" autocomplete="off" type="text" class="form-control date" id="dari" name="dari" value="<?=$dari;?>">
								  </div>
								  <div class="form-group">
									<label for="pwd">To:</label>
									<input onChange="hrefurl('#expenseprint','expense')" autocomplete="off" type="text" class="form-control date" id="ke" name="ke" value="<?=$ke;?>">
								  </div>
								  <div class="form-group">
									<select onChange="hrefurl('#expenseprint','expense')" autocomplete="off" class="form-control" id="cap" name="cap" value="<?=$cap;?>">
										<option value="" <?=($cap=="")?"selected":"";?>>All</option>
										<option value="Project" <?=($cap=="Project")?"selected":"";?>>Project</option>
										<option value="Office" <?=($cap=="Office")?"selected":"";?>>Office</option>
									</select>
								  </div>
								  <?php if(isset($_GET['report'])){?>
									<input type="hidden" name="report" value="ok">
								 <?php }?>
								  <?php if(isset($_GET['invs_no'])){?>
									<input type="hidden" name="invs_no" value="<?=$_GET['invs_no'];?>">
								 <?php }?>
								  <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
								<?php if(!isset($_POST['invs_no'])){?>	
								<a id="expenseprint" target="_blank" href="<?=site_url("expense?dari=".$dari."&ke=".$ke."&cap=".$cap);?>" class="btn btn-md btn-success kanan" data-toggle="tooltip" title="Expense" ><span class="fa fa-print" style="color:white;margin:0px;"></span> </a>	
								<?php }?>
								  
								</form>
								<script>
								function hrefurl(a,b){
									var dari,ke,cap;
									dari=$("#dari").val();
									ke=$("#ke").val();
									cap=$("#cap").val();
									$(a).attr("href",b+"?dari="+dari+"&ke="+ke+"&cap=");
								}
								</script>
							
								</div>
							<?php }?>	
								<div id="listutama" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  	<th>Date</th>
										  	<th>Creator</th>
											<th>Status</th>
											<th>Payment No. </th>
											<th>Payment</th>
											<th>Amount</th>
											<?php if($identity->identity_project=="1"){?>
											<th>Project</th>
											<?php }?>
											<th>Bukti</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(!isset($_GET['tagihan'])){
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
										}
										
										if(isset($_GET['cap'])){											
											switch($this->input->get("cap")){
												case "Project":
												$this->db->where("project_id >",0);
												break;
												case "Office":
												$this->db->where("project_id",0);
												break;
												default:
												break;
											}
										}
										
										if(isset($_GET['invs_no'])){											
											$this->db->where("invs_no",$this->input->get("invs_no"));
										}else{
											$this->db->where("invs_no","");
										}
										
										if($this->session->userdata("position_id")!=1&&$this->session->userdata("position_id")!=5&&$this->session->userdata("position_id")!=7){
											$this->db->where("invspayment.user_id",$this->session->userdata("user_id"));
										}	
										
										$usr=$this->db
										->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
										->join("user","user.user_id=invspayment.user_id","left")	
										->order_by("invspayment_id","desc")									
										->get("invspayment");
										$no=1;
										//echo $this->db->last_query();
										foreach($usr->result() as $invspayment){
											$invsppro_amount=0;
											$pr=$this->db
											->select("*,SUM(invspaymentproduct_amount*invspaymentproduct_qty)As invsppro_amount")
											->where("invspayment_no",$invspayment->invspayment_no)
											->group_by("invspayment_no")
											->get("invspaymentproduct");
											if($pr->num_rows()>0){$invsppro_amount=$pr->row()->invsppro_amount;}
											if($invspayment->invspayment_status=="CA Request"){
											$bmerah="bmerah";?>
											<script>
											setTimeout(function(){$(".bmerah").css({"background-color":"#FFCCCC"});},200);
											</script>
											<?php }else{
											$bmerah="";
											}
										?>
										<tr class="<?=$bmerah;?>">
											<td><?=$no++;?></td>
										  	<td><?=$invspayment->invspayment_date;?></td>											
											<td><?=$invspayment->user_name;?></td>										
											<td><?=$invspayment->invspayment_status;?></td>
											<td><?=$invspayment->invspayment_no;?></td>
											<td><?=$invspayment->methodpayment_name;?></td>
											<td id="tam<?=$invspayment->invspayment_id;?>"><?=number_format($invsppro_amount,0,",",".");?></td>
											<?php if($identity->identity_project=="1"){?>
											<td>
                                            <select  
                                            onChange="inputproject(this,'<?=htmlspecialchars($invspayment->invspayment_no, ENT_QUOTES);?>')" 
                                            id="project_id" name="project_id" class="form-control" required>
                                            
                                                <option value="0" <?=($invspayment->project_id=="0")?'selected="selected"':'';?>>
                                                Select Project                                                </option>
                                                
                                                <?php if($invspayment->project_id!="0"){?>
                                                <option value="<?=$invspayment->project_id;?>" <?=($invspayment->project_id!="0")?'selected="selected"':'';?>>
                                                  <?=$invspayment->project_name;?>
                                              	</option>
                                                <?php }?>
                                                
                                                <?php $proj=$this->db->get("project");
												  	foreach($proj->result() as $project){?>
                                                <option value="<?=$project->project_id;?>" <?=($invspayment->project_id==$project->project_id)?'selected="selected"':'';?>> (
                                                  <?=$project->project_code;?>
                                                  )
                                                  <?=$project->project_name;?>
                                                </option>
                                                <?php }?>
                                              </select>
                                              
                                              <script>
											  function inputproject(a,b){
											  $.get("<?=site_url("api/inputproject_paymentsupplier");?>",{project_id:a.value,invspayment_no:b})
											  .done(function(data){
											  window.location.href='<?=current_url();?>?message='+data;
											   $("#messageisi").html(data);
											   $("#message").show();
											   setTimeout(function(){$("#message").hide();},2000);
											  });
											  }
											  </script>                                            </td>
											<?php }?>
											<td>
											<form method="post">
												<button name="bukti" class="btn btn-primary">Bukti</button>											
							  					<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/> 
											</form>
											</td>
											<td style="padding-left:0px; padding-right:0px;">	 
												<form method="POST" class="col-md-2" style="padding:0px;">
													<?php if(isset($_GET['invs_no'])){$invs_no=$_GET['invs_no'];}else{$invs_no="";}?>
													<?php if(isset($_GET['supplier_id'])){$supplier_id=$_GET['supplier_id'];}else{$supplier_id="";}?>
												  <button onClick="awal('<?=$invspayment->invspayment_no;?>')" type="button" data-toggle="tooltip" title="Charge Item" target="_blank" href="<?=site_url("invspaymentproduct?invspayment_no=".$invspayment->invspayment_no."&invs_no=".$invs_no."&supplier_id=".$supplier_id);?>" class="btn btn-xs btn-info" style="margin:0px;">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </button>
												</form> 
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5||$this->session->userdata("position_id")==7)&&isset($_GET['invs_no'])&&$_GET['invs_no']!=""){?>		 
												<form method="POST" class="col-md-2" style="padding:0px;">
												  <a data-toggle="tooltip" title="Print Payment" target="_blank" href="<?=site_url("invspaymentprint?invspayment_no=".$invspayment->invspayment_no);?>" class="btn btn-xs btn-success" style="margin:0px;">
												  <span class="fa fa-print" style="color:white;"></span>											  </a>
												</form> 
												<?php }?>
											
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==7)&&$invspayment->invspayment_status=="CA Request"){?>	
												<form method="post" class="col-md-2" style="padding:0px;">
													<button type="button" title="Approve" data-toggle="tooltip" class="btn btn-xs btn-success" onClick="setujui('<?=$invspayment->invspayment_id;?>')"><span class="fa fa-check-square" style="color:white;margin:0px;"></span> </button>
												</form>	
												<?php }?>		
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5)&&$invspayment->invspayment_status=="CA Request Approved"){?>	
												<form method="post" class="col-md-2" style="padding:0px;">
													<button type="button" title="Pay CA Request" data-toggle="tooltip" class="btn btn-xs btn-success" onClick="payca('<?=$invspayment->invspayment_id;?>')"><span class="fa fa-money" style="color:white;margin:0px;"></span> </button>
												</form>	
												<?php }?>	
												<?php if(!isset($_REQUEST['invs_no'])){?>	
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5)&&$invspayment->invspayment_status=="CA Out"){?>		
												<form method="post" class="col-md-2" style="padding:0px;">
													<button title="CA Settlement" data-toggle="tooltip" class="btn btn-xs btn-success " name="settlement" value="OK"><span class="fa fa-check" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
													<input type="hidden" name="invspayment_no" value="<?=$invspayment->invspayment_no;?>"/>
												</form>
												<?php }?>
												<?php }?>
												<?php if(!isset($_REQUEST['invs_no'])){?>	
												<a target="_blank" href="<?=site_url("caprint?invspayment_no=".$invspayment->invspayment_no);?>" class="btn btn-xs btn-success col-md-2" data-toggle="tooltip" title="CA Print" ><span class="fa fa-print" style="color:white;margin:0px;"></span> </a>	
												<?php }?>
												<?php //if($this->session->userdata("position_id")!=5&&$invspayment->invspayment_status=="CA Request"){?>		
												<?php if(($invspayment->user_id==$this->session->userdata("user_id"))||$this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5){?>
												<form method="post" class="col-md-2" style="padding:0px;">
													<button class="btn btn-xs btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
												</form>
												<?php }?>
												<form method="post" class="col-md-2" style="padding:0px;">
													<button class="btn btn-xs btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
													<input type="hidden" name="invspayment_no" value="<?=$invspayment->invspayment_no;?>"/>
												</form>							
												</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							  </div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
	
	<script>
		function setujui(a){
			$("#approvemodal").modal();
			$(".invspaymentid").val(a);
		}
		function payca(a){
			$("#caoutmodal").modal();
			$(".invspaymentid").val(a);
		}
	</script>
</body>

</html>

<?php }?>