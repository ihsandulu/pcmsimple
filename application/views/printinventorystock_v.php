<!doctype html>
<html>

<head>
    <title>Print Inventory Stock</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
</head>

<body>
	<h3>Stock inventory On <?=date("M d,Y");?></h3>
	<br/>
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinventorylog_picture;?>
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
										->order_by("inventory_id","desc")									
										->order_by("inventory_name","asc")
										->get("inventory");
										$no=1;
										foreach($usr->result() as $inventory){
										$jml=0;
										$inventorylog=$this->db								
										->where("inventory_id",$inventory->inventory_id)
										->get("inventorylog");
										foreach($inventorylog->result() as $inventorylog){
											if($inventorylog->inventorylog_inout=="in"){$jml+=$inventorylog->inventorylog_qty;}else{$jml-=$inventorylog->inventorylog_qty;}
										}
										?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$inventory->inventory_name;?></td>
											<td><?=$jml;?></td>
											<?php 
												if($jml<$inventory->inventory_minimal){
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
