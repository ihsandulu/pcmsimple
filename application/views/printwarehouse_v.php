<!doctype html>
<html>

<head>
    <title>Print Warehouse</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
</head>

<body>
	<h3>Stock Product On <?=date("M d,Y");?></h3>
	<br/>
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadgudang_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Product</th>
											<th>Qty</th>
											<th class="col-md-2">Info</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										$no=0;
										$usr=$this->db	
										->order_by("product_id","desc")									
										->order_by("product_name","asc")
										->get("product");
										$no=1;
										foreach($usr->result() as $product){
										$jml=0;
										$gudang=$this->db								
										->where("product_id",$product->product_id)
										->get("gudang");
										foreach($gudang->result() as $gudang){
											if($gudang->gudang_inout=="in"){$jml+=$gudang->gudang_qty;}else{$jml-=$gudang->gudang_qty;}
										}
										?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$product->product_name;?></td>
											<td><?=$jml;?></td>
											<?php 
												if($jml<$product->product_minimal){
													$pesan="Need to re-order"; 
													$css="background-color:red; color:white";
												}else{$pesan="";$css="";}
											?>
											<td style="<?=$css;?>">
												<?=$pesan;?>											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
						 
					

</body>

</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>
