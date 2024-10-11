<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* sebelum update script mohon synch code dulu
*/
class api extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->djson(array("connect"=>"ok"));
    }
	
	public function tampilproduct(){
		$identity=$this->db->get("identity")->row();
	?>
	<table id="dataTable" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th>No.</th>
				<th>Product</th>
				<th>Qty</th>
				<?php if($identity->identity_dimension==1){?>
				<th>Length</th>
				<th>Width</th>
				<th>Height</th>
				<?php }?>
				<th>Price</th>
				<th class="col-md-2">Action</th>
			</tr>
		</thead>
		<tbody> 
			<?php $usr=$this->db
			->join("product","product.product_id=invproduct.product_id","left")
			->where("inv_no",$this->input->get("inv_no"))
			->order_by("invproduct_id","desc")
			->get("invproduct");
			$no=1;
			foreach($usr->result() as $invproduct){?>
			<tr>		
				<td><?=$no++;?></td>									
				<td><?=$invproduct->product_name;?></td>
				<td><?=$invproduct->invproduct_qty;?></td>
				<?php if($identity->identity_dimension==1){?>
				<td><?=$invproduct->invproduct_panjang;?> <?=$invproduct->invproduct_unit;?></td>
				<td><?=$invproduct->invproduct_lebar;?> <?=$invproduct->invproduct_unit;?></td>
				<td><?=$invproduct->invproduct_tinggi;?> <?=$invproduct->invproduct_unit;?></td>
				<?php }?>
				<td><?=number_format($invproduct->invproduct_price,2,",",".");?></td>
				<td style="padding-left:0px; padding-right:0px;">
					<form method="post" class="col-md-3" style="padding:0px;">
						<button type="button" onclick="deleteproductinv(<?=$invproduct->invproduct_id;?>,<?=$invproduct->gudang_id;?>)" class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
						<input type="hidden" name="invproduct_id" value="<?=$invproduct->invproduct_id;?>"/>
						<input type="hidden" name="gudang_id" value="<?=$invproduct->gudang_id;?>"/>
					</form>											
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<script>
	function deleteproductinv(invproduct_id,gudang_id,sjkeluarproduct_id){
		$.get("<?=site_url("api/deleteproductinv");?>",{invproduct_id:invproduct_id,gudang_id:gudang_id,inv_no:'<?=$this->input->get("inv_no");?>'})
		.done(function(data){
			tampilproduct('<?=$this->input->get("inv_no");?>');
			$("#tag").val(data);
		});
	}
	</script>
	<?php
	}
	
	public function deleteproductinv(){
		$identity=$this->db->get("identity")->row();
		$this->db->delete("invproduct",array("invproduct_id"=>$this->input->get("invproduct_id")));
		if($identity->identity_stok==1){
			$this->db->delete("gudang",array("gudang_id"=>$this->input->get("gudang_id")));
		}
		
		$this->db->delete("sjkeluarproduct",array("invproduct_id"=>$this->input->get("invproduct_id")));			
		if($identity->identity_stok==0){
			$this->db->delete("gudang",array("invproduct_id"=>$this->input->get("invproduct_id")));
		}	
		
		$tagihan=0;
		$tagihan1=$this->db
		->select("SUM(invproduct_qty*invproduct_price)AS tagihan")
		->where("inv_no",$this->input->get("inv_no"))
		->group_by("inv_no")
		->get("invproduct");
		foreach($tagihan1->result() as $tagihan1){
			$tagihan=$tagihan1->tagihan;			
		}	
		echo $tagihan;
	}
	
	public function insertpaymentinv(){
		$identity=$this->db->get("identity")->row();
		
		//delete dulu yg sebelumnya
		$cek=$this->db
		->where("invpayment_no",$this->input->get("invpayment_no"))
		->get("invpaymentproduct");
		foreach($cek->result() as $cek){
			if($cek->invpaymentproduct_source=="kas_id"){
				$this->db->delete("kas",array("kas_id"=>$cek->kas_id));
			}else{
				$this->db->delete("petty",array("petty_id"=>$cek->petty_id));
			}
			if($identity->identity_saldocustomer==1){
				$customer_saldo=$this->db
				->where("customer_id",$this->input->get("customer_id"))
				->get("customer")
				->row()
				->customer_saldo;
				$pembayaran=$this->db
				->select("SUM(invpaymentproduct_amount*invpaymentproduct_qty)AS pembayaran")
				->where("invpaymentproduct_id",$cek->invpaymentproduct_id)
				->get("invpaymentproduct")
				->row()
				->pembayaran;
				$icustomer["customer_saldo"]=$customer_saldo+$pembayaran;
				$wcustomer["customer_id"]=$this->input->get("customer_id");
				$this->db->update("customer",$icustomer,$wcustomer);
				//echo $this->db->last_query();die;
			}		
			//echo $this->db->last_query();die;
			$this->db->delete("invpaymentproduct",array("invpaymentproduct_id"=>$cek->invpaymentproduct_id));
		}
			
		
		//isi yg baru			
		foreach($this->input->get() as $e=>$f){if($e!='create'&&$e!='methodpayment_id'&&$e!='customer_id'){$input[$e]=$this->input->get($e);}}
		$dp=$this->db
		->where("invpayment_no",$this->input->get("invpayment_no"))
		->get("invpayment")
		->row()
		->invpayment_date;
		;			
		$projectid=$this->db
		->join("inv","inv.inv_no=invpayment.inv_no","left")
		->where("invpayment_no",$this->input->get("invpayment_no"))
		->limit(1)
		->get("invpayment");
		if($projectid->num_rows()>0){$project_id=$projectid->row()->project_id;}else{$project_id=0;}
		
		if(isset($_GET['invpaymentproduct_source'])&&$input["invpaymentproduct_source"]=="kas_id"){
						
			$inputkas["kas_count"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
			$inputkas["kas_inout"]="in";
			$inputkas["kas_remarks"]=$input["invpaymentproduct_description"];
			$inputkas["kas_date"]=$dp;
			$inputkas["project_id"]=$project_id;
			if($identity->identity_saldocustomer==1){
				$inputkas["customer_id"]=$this->input->get("customer_id");
			}
			$this->db->insert("kas",$inputkas);	
			//echo $this->db->last_query();die;
			$input["kas_id"]=$this->db->insert_id();
		}
		
		if(isset($_GET['invpaymentproduct_source'])&&$input["invpaymentproduct_source"]=="petty_id"){
			$inputpetty["petty_amount"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
			$inputpetty["petty_inout"]="in";
			$inputpetty["petty_remarks"]=$input["invpaymentproduct_description"];
			$inputpetty["petty_date"]=$dp;
			$inputpetty["project_id"]=$project_id;
			if($identity->identity_saldocustomer==1){
				$inputpetty["kas_id"]=-2;
				$inputpetty["customer_id"]=$this->input->get("customer_id");
			}
			$this->db->insert("petty",$inputpetty);	
			$input["petty_id"]=$this->db->insert_id();
		}
		
		
		if($identity->identity_saldocustomer==1&&$_GET['methodpayment_id']==-1){
			$customer_saldo=$this->db
			->where("customer_id",$this->input->get("customer_id"))
			->get("customer")
			->row()
			->customer_saldo;
			$icustomer["customer_saldo"]=$customer_saldo-($input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"]);
			$wcustomer["customer_id"]=$this->input->get("customer_id");
			$this->db->update("customer",$icustomer,$wcustomer);
			//echo $this->db->last_query();die;
		}		
		
		
		$this->db->insert("invpaymentproduct",$input);	
		//echo $this->db->last_query();die;
		$data["message"]="Insert Data Success";
		//redirect(current_url(),'location');
	}
	
	public function insertproductinv(){
		$identity=$this->db->get("identity")->row();
		foreach($this->input->get() as $e=>$f){if($e!='create'){$input[$e]=$this->input->get($e);}}
		
		if($identity->identity_stok==1){
			$gudang["gudang_qty"]=$input["invproduct_qty"];
			$gudang["gudang_inout"]="out";
			$gudang["gudang_keterangan"]="Invoice".$input["inv_no"];
			$gudang["product_id"]=$input["product_id"];
			$gudang["inv_no"]=$input["inv_no"];
			$this->db->insert("gudang",$gudang);
			$input["gudang_id"]=$this->db->insert_id();
		}
		if($input["invproduct_qty"]<0.01){$input["invproduct_qty"]=0.01;}
		
		$this->db->insert("invproduct",$input);
		//echo $this->db->last_query();die;
		$invproduct_id=$this->db->insert_id();
		
		$inputsjk["product_id"]=$input["product_id"];
		$inputsjk["sjkeluarproduct_qty"]=$input["invproduct_qty"];
		if($identity->identity_dimension==1){
			$inputsjk["sjkeluarproduct_panjang"]=$input["invproduct_panjang"];
			$inputsjk["sjkeluarproduct_lebar"]=$input["invproduct_lebar"];
			$inputsjk["sjkeluarproduct_tinggi"]=$input["invproduct_tinggi"];
			$inputsjk["sjkeluarproduct_unit"]=$input["invproduct_unit"];
		}
		$inputsjk["invproduct_id"]=$invproduct_id;
		$sjkeluar_no=$this->db->where("inv_no",$input["inv_no"])->get("sjkeluar")->row()->sjkeluar_no;
		$inputsjk["sjkeluar_no"]=$sjkeluar_no;
		$this->db->insert("sjkeluarproduct",$inputsjk);
		//echo $this->db->last_query();			
		if($identity->identity_stok==0){
			$gudangs["product_id"]=$input["product_id"];
			$gudangs["gudang_qty"]=$input["invproduct_qty"];
			$gudangs["gudang_inout"]="out";
			$gudangs["invproduct_id"]=$invproduct_id;
			$gudangs["inv_no"]=$input["inv_no"];
			if(isset($_SESSION['branch_id'])){$branch_id=$this->session->userdata("branch_id");}else{$branch_id=0;}
			$gudangs["branch_id"]=$branch_id;
			$gudangs["sjkeluarproduct_id"]=$this->db->insert_id();
			$gudangs["sjkeluar_no"]=$sjkeluar_no;
			$this->db->insert("gudang",$gudangs);
		}
		$tagihan=0;
		$tagihan1=$this->db
		->select("SUM(invproduct_qty*invproduct_price)AS tagihan")
		->where("inv_no",$this->input->get("inv_no"))
		->group_by("inv_no")
		->get("invproduct");
		foreach($tagihan1->result() as $tagihan1){
			$tagihan=$tagihan1->tagihan;			
		}	
		echo $tagihan;
	
	}
	
	public function paymentsimpleinv(){
	$identity=$this->db->get("identity")->row();
	?>
		<form id="formipayment" class="form-horizontal" method="get" enctype="multipart/form-data">
		<div class="form-group">
			<label class="control-label col-sm-2" for="unit_id">Store to:</label>
			<div class="col-sm-10">
				<label><input required type="radio" name="invpaymentproduct_source" id="kas_id" value="kas_id">Big Cash</label>
				<label><input required type="radio" name="invpaymentproduct_source" id="petty_id" value="petty_id" checked="checked">Petty Cash</label>
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invpaymentproduct_description">Description:</label>
			<div class="col-sm-10">									 
				<input type="text" class="form-control" name="invpaymentproduct_description" value="Pembayaran inv : <?=$_GET['inv_no'];?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="">Total Bill:</label>
			<div class="col-sm-10">
			  <input type="text" disabled="disabled" class="form-control" value="Rp <?=number_format($_GET['tagihan'],2,",",".");?>">
			  <input type="hidden" class="form-control" id="tagihan" value="<?=$_GET['tagihan'];?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invpaymentproduct_amount">Amount:</label>
			<div class="col-sm-10">
				<?php if(isset($_GET['methodpayment_id'])&&$_GET['methodpayment_id']=="-1"){
					$amount=$_GET['tagihan'];
				}else{
					$amount=0;
				}?>
			  <input onKeyUp="kembalian1()" type="number" min="1" autofocus class="form-control dibayar" id="jumlah"  value="<?=$amount;?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="">Change:</label>
			<div class="col-sm-10">
			  <input type="text" id="kembalian" disabled="disabled" class="form-control" value="Rp ">
			  <input type="hidden" id="invpaymentproduct_amount" name="invpaymentproduct_amount" value="<?=$amount;?>">
			  <input type="hidden" id="invpaymentproduct_bayar" name="invpaymentproduct_bayar" value="">
			  <input type="hidden" id="invpaymentproduct_kembalian" name="invpaymentproduct_kembalian" value="">
			</div>			
			
			<script>
			function kembalian1(){
				var bayar = $("#jumlah").val();
				var kembalian = bayar-<?=$_GET['tagihan'];?>;
				if($("#jumlah").val()><?=$_GET['tagihan'];?>)
				{
					$("#invpaymentproduct_amount").val('<?=$_GET['tagihan'];?>');
					$("#invpaymentproduct_bayar").val(bayar);
					$("#invpaymentproduct_kembalian").val(kembalian);
					$("#kembalian").val(formatter.format(kembalian));
				}else{
					$("#invpaymentproduct_amount").val(bayar);
					$("#invpaymentproduct_bayar").val(0);
					$("#invpaymentproduct_kembalian").val(0);
					$("#kembalian").val(formatter.format(0));
				}
			}
			</script>
		  </div>
		  
		  <input type="hidden" name="invpaymentproduct_qty" value="1">
		  <input type="hidden" name="invpayment_no" value="<?=$this->input->get("invpayment_no");?>"/>
		  <input type="hidden" id="methodpayment_id" name="methodpayment_id" value="<?=$_GET['methodpayment_id'];?>">
		  <input type="hidden" id="customer_id" name="customer_id" value="<?=$_GET['customer_id'];?>">	  
		  <div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10">
				<button onclick="insertpaymentinv()" type="button" id="submit" class="btn btn-primary" name="create" value="OK">Submit</button>				
				<!--<button onclick="location.href = location.href;" type="button" id="submit" class="btn btn-warning" name="create" value="OK">Finish</button>-->
			</div>
		  </div>
		</form>
		<script>
		function insertpaymentinv(){
			$.get("<?=site_url("api/insertpaymentinv");?>",$('#formipayment').serialize())
			.done(function(data){
				location.href=location.href;			
				//tampilpayment('<?=$this->input->get("inv_no");?>');
				$('#listpayment').show();
			});
		}
		</script>
	<?php
	}
	
	public function productsimpleinv(){
	$identity=$this->db->get("identity")->row();
	?>
		<form id="formiproduct" class="form-horizontal" method="get" enctype="multipart/form-data">
		  <div class="form-group">
			<label class="control-label col-sm-2" for="unit_id">Product:</label>
			<div class="col-sm-10">
				<datalist id="product">
					<?php if($identity->identity_productcustomer==1){
						$uni=$this->db
					  ->join("product","product.product_id=customerproduct.product_id","left")
					  ->where("customer_id",$this->input->get("customer_id"))
					  ->get("customerproduct");
						  $price="customerproduct_price";
					}elseif($identity->identity_productcustomer==2){
						$uni=$this->db
					  ->join("product","product.product_id=vendorproduct.product_id","left")
					  ->where("vendor_id",$this->input->get("vendor_id"))
					  ->get("vendorproduct");
						  $price="vendorproduct_price";
					}elseif($identity->identity_productcustomer==3){
						$uni=$this->db
					  ->join("product","product.product_id=projectproduct.product_id","left")
					  ->where("project_id",$this->input->get("project_id"))
					  ->get("projectproduct");
						  $price="projectproduct_price";
					}else{
						$uni=$this->db->get("product");
						  $price="product_sell";
					}
					echo $this->db->last_query();
					  foreach($uni->result() as $cusprod){?>											
					  <option id="<?=$cusprod->product_id;?>" value="<?=$cusprod->product_name;?> (Rp.<?=number_format($cusprod->$price,2,",",".");?>)">
					<?php }?>
				</datalist>	 
				
				<input id="productid" onChange="rubah(this)" autofocus class="form-control" list="product" value="" autocomplete="off">	
				<input type="hidden" list="product" id="product_id" name="product_id" value="0">
				<script>
					function productid(a){
						var opt = $('option[value="'+$(a).val()+'"]');
						$("#product_id").val(opt.attr('id'));
						hargacustomer(opt.attr('id'));
						
					}
					function hargacustomer(a){
						$.get("<?=site_url("api/hargacustomer");?>",{product_id:a,customer_id:'<?=$this->input->get("customer_id");?>',vendor_id:'<?=$this->input->get("vendor_id");?>',project_id:'<?=$this->input->get("project_id");?>'})
						.done(function(data){
							$("#invproduct_price").val(data);
						});
					}
					
					function rubah(a){
						productid(a);
						stoptime();
					}
					
					var timeout;
					function doStuff() {
						timeout = setInterval(function(){productid('#productid');},100);
					}
					
					function stoptime(){
						clearTimeout(timeout);
					}
				</script>	
			  
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invproduct_price">Price:</label>
			<div class="col-sm-10">
			  <input onFocus="stoptime()" type="text"  class="form-control" id="invproduct_price" name="invproduct_price" placeholder="Enter Price" value="">
			</div>
		  </div>
		<?php if($identity->identity_dimension==1){?>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invproduct_panjang">Length:</label>
			<div class="col-sm-10">
			  <input onFocus="stoptime()" type="text"  class="form-control" id="invproduct_panjang" name="invproduct_panjang" placeholder="Enter Length" value="">
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invproduct_lebar">Width:</label>
			<div class="col-sm-10">
			  <input onFocus="stoptime()" type="text"  class="form-control" id="invproduct_lebar" name="invproduct_lebar" placeholder="Enter Width" value="">
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invproduct_tinggi">Height:</label>
			<div class="col-sm-10">
			  <input onFocus="stoptime()" type="text"  class="form-control" id="invproduct_tinggi" name="invproduct_tinggi" placeholder="Enter Height" value="">
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invproduct_unit">Unit:<br/>(Mis.cm,m)</label>
			<div class="col-sm-10">

			  <input onFocus="stoptime()" type="text"  class="form-control" id="invproduct_unit" name="invproduct_unit" placeholder="Enter Unit" value="">
			</div>
		  </div>
		  <?php }?>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="invproduct_qty">Qty:</label>
			<div class="col-sm-10">
			  <input type="text" autofocus class="form-control" id="invproduct_qty" name="invproduct_qty" placeholder="Enter Qty" value="1">
			</div>
		  </div>
		  <?php if(isset($_GET['bap'])){?>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="bap_remarks">Remarks:</label>
			<div class="col-sm-10">
			  <input type="text"  class="form-control" id="bap_remarks" name="bap_remarks" placeholder="Enter Remarks" value="<?=$this->input->get("bap_remarks");?>">
			</div>
		  </div>
		  <?php }?>
		  <input type="hidden" name="inv_no" value="<?=$this->input->get("inv_no");?>"/>				  					  
		  <div class="form-group"> 
			<div class="col-sm-offset-2 col-sm-10">
				<button onclick="insertproductinv()" type="button" id="submit" class="btn btn-primary col-md-5  col-sm-5  col-xs-5" name="create" value="OK">Submit</button>
				<?php 
				$tagihan=0;
				$tagihan1=$this->db
				->select("SUM(invproduct_qty*invproduct_price)AS tagihan")
				->where("inv_no",$this->input->get("inv_no"))
				->group_by("inv_no")
				->get("invproduct");
				foreach($tagihan1->result() as $tagihan1){
					$tagihan=$tagihan1->tagihan;			
				}	
				$methodpayment_id=0;$invpayment_no="";$invpayment_no=
				$invpayment=$this->db->where("inv_no",$this->input->get("inv_no"))->get("invpayment");
				foreach($invpayment->result() as $invpayment){
					$methodpayment_id=$invpayment->methodpayment_id;
					$invpayment_no=$invpayment->invpayment_no;
				}
				?>
				<?=$methodpayment_id;?>,<?=$invpayment_no;?>
				<input type="hidden" value="<?=$tagihan;?>" id="tag"/>
				<button onclick="tampilpayment('<?=$this->input->get("inv_no");?>',$('#tag').val(),<?=$methodpayment_id;?>,'<?=$invpayment_no;?>',<?=$this->input->get("customer_id");?>)" type="button" id="submitpayment" class="btn btn-warning col-md-offset-2 col-md-5 col-sm-offset-2 col-sm-5 col-xs-offset-2 col-xs-5" name="create" value="OK">Payment</button>
			</div>
		  </div>
		</form>
				
		<script>
		function insertproductinv(){
			$.get("<?=site_url("api/insertproductinv");?>",$('#formiproduct').serialize())
			.done(function(data){				
				tampilproduct('<?=$this->input->get("inv_no");?>');
				$('#listproduct').show();
				$("#tag").val(data);
			});
		}
		function tampilpayment(inv_no,tagihan,methodpayment_id,invpayment_no,customer_id){
			$('#formproduct').hide();
			$('#listproduct').hide();
			$.get("<?=site_url("api/paymentsimpleinv");?>",{inv_no:inv_no,tagihan:tagihan,methodpayment_id:methodpayment_id,invpayment_no:invpayment_no,customer_id:customer_id})
			.done(function(data){										
				$('#formpayment').html(data);
				$('#formpayment').show();
				//tampilpayment(inv_no);
				$('#listpayment').show();
			});
		}
		</script>
	<?php
	}
	
	public function updatesimpleinv(){
		$identity=$this->db->get("identity")->row();
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];  
			
			if(isset($_GET['project_id'])){
				$input_update["project_id"]=$this->input->get("project_id");
			}else{
				$input_update["project_id"]=$this->session->userdata("user_project");
			}
			$input_update["inv_discount"]=$this->input->get("inv_discount");
			$input_update["inv_date"]=$this->input->get("inv_date");
			$input_update["inv_duedate"]=$this->input->get("inv_duedate");	
			$input_update["inv_no"]=$this->input->get("inv_no1");	
			$input_update["customer_id"]=0;
			if(isset($_GET['customer_id'])){
			$input_update["customer_id"]=$this->input->get("customer_id");
			}
			$input_update["vendor_id"]=0;
			if(isset($_GET['vendor_id'])){
			$input_update["vendor_id"]=$this->input->get("vendor_id");	
			}
			$where["inv_no"]=$this->input->get("inv_no");	
			$this->db->update("inv",$input_update,$where);
			
			/*if($identity->identity_pelunasan==1){
				$inputp["methodpayment_id"]=$this->input->get("methodpayment_id");
				$inputp["invpayment_date"]=$this->input->get("inv_date");	
				
				$inputp["inv_no"]=$this->input->get("inv_no");
				$this->db->update("invpayment",$inputp,array("inv_no"=>$this->input->get("inv_no")));		
			}*/
			
			
			
			
			//******masukin payment********	
			$inputpayment["invpayment_date"]=$input_update["inv_date"];
			$inputpayment["methodpayment_id"]=$this->input->get("methodpayment_id");
			$this->db->update("invpayment",$inputpayment,$where);
			//echo $this->db->last_query();die();
			
			//SJ Keluar
			$inputsjkeluar["sjkeluar_pengirim"]=$this->input->get("sjkeluar_pengirim");
			$inputsjkeluar["sjkeluar_penerima"]=$this->input->get("sjkeluar_penerima");
			$inputsjkeluar["sjkeluar_date"]=$input_update["inv_date"];
			$inputsjkeluar["sjkeluar_ekspedisi"]=$this->input->get("sjkeluar_ekspedisi");
			$inputsjkeluar["sjkeluar_nopol"]=$this->input->get("sjkeluar_nopol");
			if(isset($_GET['customer_id'])){
			$inputsjkeluar["customer_id"]=$input_update["customer_id"];
			}
			$this->db->update("sjkeluar",$inputsjkeluar,$where);
			//echo $this->db->last_query();die();
			$data["message"]="Insert Data Success";
			
			$data["customer_id"]=$input_update["customer_id"];
			$data["vendor_id"]=$input_update["vendor_id"];
			$data["project_id"]=$input_update["project_id"];
			$data["inv_no"]=$input_update["inv_no"];
			$this->djson($data);
		
	}
	
	public function insertsimpleinv(){	
		$identity=$this->db->get("identity")->row();
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];    	
		
		$nosura=$this->db
		->where("nomor_name","Invoice")
		->get("nomor");
		if($nosura->num_rows()>0){
			$nosurat=$nosura->row()->nomor_no."-";
		}else{
			$nosurat="QTH-INV-";
		}
		
		$quno=$this->db
		->order_by("inv_id","desc")
		->limit("1")
		->get("inv");
		if($quno->num_rows()>0){
			//caribulan
			$invterakhir=$quno->row()->inv_no;
			$blinv=explode("-",$invterakhir);
			$blninv=$blinv[1];
			$noterakhir=end($blinv);
			$identity_number=$this->db->get("identity")->row()->identity_number;
			if($identity_number=="Monthly"){
				if($blninv!=$bulan){
					$inv_no=1;
				}else{
					$inv_no=$noterakhir+1;
					//$inv_no=1;
				}
			}
			if($identity_number=="Yearly"){
				if($blinv[2]!=date("Y")){
				$inv_no=1;
			}else{
				$inv_no=$noterakhir+1;
				//$inv_no=1;
				}
			}
		}else{
			$inv_no=1;
		}
		$inv_no=$nosurat.$bulan.date("-Y-").str_pad($inv_no,5,"0",STR_PAD_LEFT);
		if($identity->identity_simple==0){
			foreach($this->input->get() as $e=>$f){
			$input["inv_no"]=$inv_no;
			$os = array("create", "methodpayment_id", "inv_discount", "inv_date", "inv_duedate", "customer_id", "vendor_id");
			if(!in_array($e, $os)){
				$isi[$e]=$this->input->get($e);
				if (stripos($e,"/") !== false) {
					$qutit=explode("/",$e);
					$input["inv_title"]=$qutit[0];
					$input["inv_customize"]=$qutit[1];
					$input["element_id"]=$qutit[2];
				}else{
					$input["inv_title"]=$e;
					$input["element_id"]="0";
				}
				$input["inv_content"]=$f;
				$this->db->insert("inv",$input);
				//echo $this->db->last_query()."<br/>";die;
			}
		}
		}
		if($_SESSION['branch_id']==null){$branch_id=0;}else{$branch_id=$_SESSION['branch_id'];}
		$input_update["project_id"]=$this->session->userdata("user_project");
		$input_update["branch_id"]=$branch_id;
		$input_update["inv_discount"]=$this->input->get("inv_discount");
		$input_update["user_id"]=$_SESSION['user_id'];
		$input_update["inv_date"]=$this->input->get("inv_date");
		$input_update["inv_duedate"]=$this->input->get("inv_duedate");	
		if(isset($_GET['customer_id'])){
		$input_update["customer_id"]=$this->input->get("customer_id");
		}
		if(isset($_GET['vendor_id'])){
		$input_update["vendor_id"]=$this->input->get("vendor_id");	
		}
		
		if($identity->identity_simple==0){
			$where["inv_no"]=$inv_no;	
			$this->db->update("inv",$input_update,$where);
		}else{
			$input_update["inv_no"]=$inv_no;
			$this->db->insert("inv",$input_update);
			//echo $this->db->last_query();
			
			
			//******masukin payment********		
			$nosura=$this->db
			->where("nomor_name","Payment Invoice Customer")
			->get("nomor");
			if($nosura->num_rows()>0){
				$nosurat=$nosura->row()->nomor_no."-";
			}else{
				$nosurat="PIC-";
			}
			
			$quno=$this->db
			->order_by("invpayment_id","desc")
			->limit("1")
			->get("invpayment");
			if($quno->num_rows()>0){
				//caribulan
				$terakhir=$quno->row()->invpayment_no;
				$blno=explode("-",$terakhir);
				$blnno=$blno[1];
				$noterakhir=end($blno);
				$identity_number=$this->db->get("identity")->row()->identity_number;
				if($identity_number=="Monthly"){
					if($blnno!=$bulan){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
				if($identity_number=="Yearly"){
					if($blno[2]!=date("Y")){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
			}else{
				$inno=1;
			}
			$sno=$nosurat.$bulan.date("-Y-").str_pad($inno,5,"0",STR_PAD_LEFT);
			$inputpayment["invpayment_no"]=$sno;
			$inputpayment["invpayment_date"]=$input_update["inv_date"];
			$inputpayment["methodpayment_id"]=$this->input->get("methodpayment_id");
			$inputpayment["inv_no"]=$input_update["inv_no"];
			$this->db->insert("invpayment",$inputpayment);
			 $this->db->last_query();
			
			//SJ Keluar
			$nosura=$this->db
			->where("nomor_name","SJ Keluar")
			->get("nomor");
			if($nosura->num_rows()>0){
				$nosurat=$nosura->row()->nomor_no."-";
			}else{
				$nosurat="SJK-";
			}			
				
			$sjno=$this->db
			->order_by("sjkeluar_id","desc")
			->limit("1")
			->get("sjkeluar");
			if($sjno->num_rows()>0){
				//caribulan
				$terakhir=$sjno->row()->sjkeluar_no;
				$blno=explode("-",$terakhir);
				$blnno=$blno[1];
				$noterakhir=end($blno);
				$identity_number=$this->db->get("identity")->row()->identity_number;
				if($identity_number=="Monthly"){
					if($blnno!=$bulan){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
				if($identity_number=="Yearly"){
					if($blno[2]!=date("Y")){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
			}else{
				$inno=1;
			}
			$sno=$nosurat.$bulan.date("-Y-").str_pad($inno,5,"0",STR_PAD_LEFT);
			$inputsjkeluar["sjkeluar_no"]=$sno;
			$inputsjkeluar["sjkeluar_pengirim"]=$this->input->get("sjkeluar_pengirim");
			$inputsjkeluar["sjkeluar_penerima"]=$this->input->get("sjkeluar_penerima");
			$inputsjkeluar["sjkeluar_date"]=$input_update["inv_date"];
			$inputsjkeluar["sjkeluar_ekspedisi"]=$this->input->get("sjkeluar_ekspedisi");
			$inputsjkeluar["sjkeluar_nopol"]=$this->input->get("sjkeluar_nopol");
			$inputsjkeluar["inv_no"]=$input_update["inv_no"];
			$inputsjkeluar["branch_id"]=$branch_id;	
			$inputsjkeluar["project_id"]=$input_update["project_id"];
			if(isset($_GET['customer_id'])){
			$inputsjkeluar["customer_id"]=$input_update["customer_id"];
			}
			$this->db->insert("sjkeluar",$inputsjkeluar);
			
			$data["message"]="Insert Data Success";
			
			
		
		}
		//echo $this->db->last_query();		
			
			$data["message"]="Insert Data Success";
			//$data["message"]=$this->db->last_query();
			
			$data["customer_id"]=$input_update["customer_id"];
			$data["vendor_id"]=$this->input->get("customer_id");
			$data["project_id"]=$input_update["project_id"];
			$data["inv_no"]=$input_update["inv_no"];
			$this->djson($data);
	}
	
	public function tableshow(){
		$type=$this->input->get("type");
		$project_id=$this->input->get("project_id");
		?>
		<?php 										
		$usr=$this->db
		->join("project","project.project_id=estimasi.project_id","left")
		->join("customer","customer.customer_id=project.customer_id","left")
		->where("estimasi.project_id",$project_id)
		->where("estimasi_type",$type)
		->order_by("estimasi_id","desc")
		->get("estimasi");
		$no=1;
		foreach($usr->result() as $estimasi){?>
		<tr>	
			<td><?=$no++;?></td>						
			<td><?=$estimasi->project_name;?></td>
			<td><?=$estimasi->estimasi_name;?></td>
			<td><?=number_format($estimasi->estimasi_mount,2,",",".");?></td>											
			<td style="text-align:center; ">  
			<?php if(!isset($_GET['report'])){$float="float:right;";?>  								
				<form method="POST" class="col-md-6" style="">
					<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
					<input type="hidden" name="estimasi_id" value="<?=$estimasi->estimasi_id;?>"/>
				</form> 									
				<form method="POST" class="col-md-6" style="">
					<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
					<input type="hidden" name="estimasi_id" value="<?=$estimasi->estimasi_id;?>"/>
				</form>	                                      				
			<?php }else{$float="";}?>	</td>
		</tr>
		<?php }?>
		<?php
	}
	
	
	
	public function pilihcustomer(){
		$identity_project=$this->db->get("identity")->row()->identity_project;
		if($this->input->get("pilih")=="satu"){
		?>
		<datalist id="customer">
			<?php $uni=$this->db
			  ->get("customer");
			  foreach($uni->result() as $customer){?>	
			  <?php if($identity_project=="2"){$ktp=$customer->customer_ktp;}else{$ktp="";}?>										
			  <option id="<?=$customer->customer_id;?>" value="<?=$customer->customer_name;?>">
			<?php }?>
		</datalist>	  
		<input id="customerid" onChange="rubah1(this)" autofocus class="form-control" list="customer"  autocomplete="off">	
		<input type="hidden" list="customer" id="customer_id" name="customer_id" value="">
		<script>
			function rubah1(a){
				var opt = $('option[value="'+$(a).val()+'"]');
				$("#customer_id").val(opt.attr('id'));																					
			}
			
														
		</script>	
		<?php
		}
		if($this->input->get("pilih")=="banyak"){
		?>
		<select id="customer_id" name="customer_id[]" multiple class="form-control" style="height:350px;">
		<?php $sis=$this->db										
		->get("customer");
		$nn=1;
		//$a = $this->db->last_query();
		foreach($sis->result() as $customer){									
		?>
		  <option value="<?=$customer->customer_id;?>"><?=$nn++;?>). <?=$customer->customer_name;?>, <?=$customer->customer_address;?></option>
		 <?php }?>
		</select>
		<?php
		}
		if($this->input->get("pilih")=="grup"){
		?>
		<select id="grup_id" class="form-control" onchange="grupd()">
		<option value="">Select Group</option>
		<?php $grup=$this->db										
		->get("grup");
		//$a = $this->db->last_query();
		foreach($grup->result() as $grup){									
		?>
		  <option value="<?=$grup->grup_id;?>"><?=$grup->grup_name;?></option>
		 <?php }?>
		</select>
		
		<select id="customer_id" name="customer_id[]" multiple class="form-control" style="height:350px;">
		</select>
		
		<script>
		function grupd(){
			$.get("<?=site_url("api/grupd");?>",{grup_id:$("#grup_id").val()})
			.done(function(data){
				$("#customer_id").html(data);
			});
		}
		</script>
		<?php
		}
	}
	
	public function grupd(){?>
		<?php $sis=$this->db	
		->join("customer","customer.customer_id=grupd.customer_id","left")	
		->where("grup_id",$this->input->get("grup_id"))								
		->get("grupd");
		$nn=1;
		//echo $this->db->last_query();
		foreach($sis->result() as $customer){									
		?>
		  <option selected="selected" value="<?=$customer->customer_id;?>"><?=$nn++;?>). <?=$customer->customer_name;?>, <?=$customer->customer_address;?></option>
		 <?php }?>
	<?php }
	
	public function uploadgambar(){
		$dir=$this->input->post("dir");
		$table=$this->input->post("table");
		$datetime=$this->input->post("datetime");
		$id=$this->input->post("id");
		
		$data['uploadgambar']="";
		
		$gambar=str_replace(' ', '_',$_FILES['gambar']['name']);
		$gambar = date("H_i_s_").$gambar;
		if(file_exists ('assets/images/'.$dir.'/'.$gambar)){
		unlink('assets/images/'.$dir.'/'.$gambar);
		}
		$config['file_name'] = $gambar;
		$config['upload_path'] = 'assets/images/'.$dir.'/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('gambar'))
		{
			echo $data['uploadgambar']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$input["picture"]=$gambar;
			$input["datetime"]=$datetime;
			//$ketika[$where]=$id;
			$this->db->insert($table,$input);
			echo $this->db->last_query();
			echo $data['uploadgambar']="Upload Success !";
		}
	
	
	}
	
	public function allpicture(){
			$table=$this->input->get("table");
			$datetime=$this->input->get("datetime");
			$dir=$this->input->get("dir");
		  $gambar=$this->db
		  ->where("datetime",$datetime)
		  ->get($table);
		  foreach($gambar->result() as $gambar){?>
		  <div class="col-md-3" style="padding:5px; margin-bottom:2px; width:25%; float:left;">
		  <div class="col-md-12 border" style="height:340px; border-radius:0px; padding:20px; box-shadow:grey 0px 0px 2px 1px;">
		  <img src="<?=base_url("assets/images/".$dir."/".$gambar->picture);?>" class="img img-rounded" style="object-fit:contain; width:100%; height:300px;"/>
		  </div>
		  </div>
		  <?php
		  }
	}
	
	
	
	public function hargadasar(){
		$input["product_id"]=$this->input->get("product_id");
		$field = $this->input->get("field");
		$product = $this->db->get_where("product",$input);
		if($product->num_rows()>0){
			echo $product->row()->$field;
		}else{
			echo "0";
		}
		
	}
	
	public function hargasupplier(){
		$input["supplier_id"]=$this->input->get("supplier_id");
		$input["product_id"]=$this->input->get("product_id");
		$product = $this->db->get_where("supplierproduct",$input);
		if($product->num_rows()>0){
			echo $product->row()->supplierproduct_price;
		}else{
			echo "0";
		}
		
	}
	
	public function hargacustomer(){
		$input["product_id"]=$this->input->get("product_id");
		$identity=$this->db->get("identity")->row();
		$price=0;
		if($identity->identity_productcustomer==3 && $identity->identity_project==1){
			$input["project_id"]=$this->input->get("project_id");
			$product = $this->db->get_where("projectproduct",$input);
			if($product->num_rows()>0){
				$price = $product->row()->projectproduct_price;
			}
		}elseif($identity->identity_productcustomer==1){
			$input["customer_id"]=$this->input->get("customer_id");
			$product = $this->db->get_where("customerproduct",$input);
			if($product->num_rows()>0){
				$price = $product->row()->customerproduct_price;
			}
		}elseif($identity->identity_productcustomer==2){
			$input["vendor_id"]=$this->input->get("vendor_id");
			$product = $this->db->get_where("vendorproduct",$input);
			if($product->num_rows()>0){
				$price = $product->row()->vendorproduct_price;
			}
		}else{
			$product = $this->db->get_where("product",$input);
			if($product->num_rows()>0){
				$price = $product->row()->product_sell;
			}
		}
		//echo $this->db->last_query();
		echo $price;
	}
	   
  	public function cekproject(){
		$isi=$this->input->get("isi");
		$cek=$this->db
		->where("project_code",$isi)
		->get("project");
		if($cek->num_rows()>0){
			echo "ada";
		}else{
			echo "kosong";
		}
	}
   
   
	public function inputproject(){
	$input['project_id']=$this->input->get("project_id");
	$quotation_no['quotation_no']=$this->input->get("quotation_no");
	$this->db->update("quotation",$input,$quotation_no);
	if($this->db->affected_rows()>0){echo "Update Success";}else{echo "Update Failed";}
	}
	
	public function inputproject_invoice(){
	$input['project_id']=$this->input->get("project_id");
	$project=$this->db
	->where("project_id",$input['project_id'])
	->get("project");
	foreach($project->result() as $project){
		if($this->db->get("identity")->row()->identity_projectwith==0){
			$input['customer_id']=$project->customer_id;
		}		
	}
	
	$inv_no['inv_no']=$this->input->get("inv_no");
	$this->db->update("inv",$input,$inv_no);
	$this->db->update("sjkeluar",$input,$inv_no);
	if($this->db->affected_rows()>0){echo "Update Success";}else{echo "Update Failed";}
	//echo $this->db->last_query();
	}
	
	public function inputproject_paymentsupplier(){
	$input['project_id']=$this->input->get("project_id");
	$invspayment_no['invspayment_no']=$this->input->get("invspayment_no");
	$this->db->update("invspayment",$input,$invspayment_no);
	if($this->db->affected_rows()>0){echo "Update Success";}else{echo "Update Failed";}
	}
	
	function inputsjmasuk_invoice(){
		$input['sjmasuk_id']=$this->input->get("sjmasuk_id");
		$i['sjmasuk_no']=$this->db->where("sjmasuk_id",$input['sjmasuk_id'])->get("sjmasuk")->row()->sjmasuk_no;
		$invs_no['invs_no']=$this->input->get("invs_no");
		$invs_no['invs_id']=$this->input->get("invs_id");
		$this->db->update("invs",$input,$invs_no);
		//echo $this->db->last_query();
		$this->db->update("sjmasuk",$invs_no,$input);
		//if($this->db->affected_rows()>0){
			$where["invs_no"]=$invs_no['invs_no'];
			$this->db->delete("invsproduct",$where);
			//echo $this->db->last_query();
			$sjmasukproduct1=$this->db
			->join("sjmasuk","sjmasuk.sjmasuk_no=sjmasukproduct.sjmasuk_no","left")
			->where("sjmasukproduct.sjmasuk_no",$i['sjmasuk_no'])
			->get("sjmasukproduct");
			//echo $this->db->last_query();
			foreach($sjmasukproduct1->result() as $sjmasukproduct){
				$inputi["product_id"]=$sjmasukproduct->product_id;
				$inputi["invsproduct_qty"]=$sjmasukproduct->sjmasukproduct_qty;
				$inputi["invs_no"]=$this->input->get("invs_no");
				//$inputi["gudang_id"]=$sjmasukproduct->gudang_id;
				
				
				//$inputi["gudang_barcode"]=$sjmasukproduct->gudang_barcode;	
				//$inputi["sjmasukproduct_id"]=$sjmasukproduct->sjmasukproduct_id;
				$inputi["sjmasuk_id"]=$sjmasukproduct->sjmasuk_id;
				$this->db->insert("invsproduct",$inputi);
				//echo $this->db->last_query();
			}
			if($this->db->insert_id()>0){
				echo "Update Success";
			}else{
				echo "Product belum terupdate";
			}
		//}else{
			//echo "Update Failed";
		//}
	}
	
	public function inputpoc_invoice(){
	$input['poc_id']=$this->input->get("poc_id");
	$inv_no['inv_no']=$this->input->get("inv_no");
	$this->db->update("inv",$input,$inv_no);
	if($this->db->affected_rows()>0){echo "Update Success";}else{echo "Update Failed";}
	}
	
	public function inputstatus(){
	$input['quotation_status']=$this->input->get("quotation_status");
	$quotation_no['quotation_no']=$this->input->get("quotation_no");
	$this->db->update("quotation",$input,$quotation_no);
	if($this->db->affected_rows()>0){echo "Update Success";}else{echo "Update Failed";}
	}
	
	public function inputquotation(){
		$input['quotation_no']=$this->input->get("quotation_no");
		$po_no['po_no']=$this->input->get("po_no");
		$this->db->update("po",$input,$po_no);
		if($this->db->affected_rows()>0){echo "Update Success";}else{echo "Update Failed";}
	}
	
	public function input_position_menu(){
		$input['menu_id']=$this->input->get("a");
		$input['menu_sub_id']=$this->input->get("b");
		$input['menu_sub_sub_id']=$this->input->get("c");
		$input['position_id']=$this->input->get("d");
		$this->db->insert("position_menu",$input);
		if($this->db->insert_id()>0){echo "Insert Success";}else{echo "Insert Failed";}
	}
	
	public function remove_position_menu(){
		$where['menu_id']=$this->input->get("a");
		$where['menu_sub_id']=$this->input->get("b");
		$where['menu_sub_sub_id']=$this->input->get("c");
		$where['position_id']=$this->input->get("d");
		$this->db->delete("position_menu",$where);
		if($this->db->affected_rows()>0){echo "Delete Success";}else{echo "Delete Failed";}
	}
	
	
	private function djson($value=array()) {
		$json = json_encode($value);
		$this->output->set_header("Access-Control-Allow-Origin: *");
		$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
		$this->output->set_status_header(200);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
	
	/*
	function send_gcm_notify($reg_id, $title, $message, $img_url, $tag) {
		define("GOOGLE_API_KEY", "AIzaSyDbabv_NlcyoxwaOedLjlimcZS9drjA5uE");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => $title, "body" => $message, "tag" => $tag ),
			'data'						=> array("message" =>$message, "image"=> $img_url),
        );
		
        $headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
		
        curl_close($ch);
        echo $result;
    }	
	
	public function sendMessage($data,$target){
		//FCM api URL
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = 'AIzaSyANqvKPEr9XQ5-bXTS9m93DYMLwBCY5_Yc';
					
		$fields = array();
		$fields['data'] = $data;
		if(is_array($target)){
			$fields['registration_ids'] = $target;
		}else{
			$fields['to'] = $target;
		}
		//header with content_type api key
		$headers = array(
			'Content-Type:application/json',
		  'Authorization:key='.$server_key
		);
					
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}
	
	function send_android_notification($registration_ids, $message) {
		$fields = array(
		'registration_ids' => array($registration_ids),
		'data'=> $message,
		);
		$headers = array(
		'Authorization: key=AIzaSyANqvKPEr9XQ5-bXTS9m93DYMLwBCY5_Yc', // FIREBASE_API_KEY_FOR_ANDROID_NOTIFICATION
		'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();
		 
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		 
		// Disabling SSL Certificate support temporarly
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		 
		// Execute post
		$result = curl_exec($ch );
		if($result === false){
		die('Curl failed:' .curl_errno($ch));
		}
		 
		// Close connection
		curl_close( $ch );
		return $result;
		}
	*/	
		
	

	
	
}