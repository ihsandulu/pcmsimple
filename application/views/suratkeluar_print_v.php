<!DOCTYPE html>
<html>
	<head>
		<title>Print Surat Keluar</title>
		<meta charset="utf-8">
		<meta name="viewsuratkeluarrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
	</head>
	<body>
        <div class="container">
            <div class="row">
                      
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
            
                <div class="col-md-12"><h1 style="text-decoration:underline;">Surat Keluar</h1></div>
                <div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;">
                    <div class="col-md-2 col-sm-2 col-xs-2">Ref. No.</div>
                    <div class="col-md-1 col-sm-1 col-xs-1">:</div>
                    <div class="col-md-9 col-sm-9 col-xs-9"><?=$suratkeluar_no;?>&nbsp;</div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;" align="right">
                    <div class="col-md-3 col-sm-3 col-xs-12" align="right"><?=ucfirst($branch_name).", ".date("M d, Y");?></div>
                </div>
                <div style="">&nbsp;<br/><br/></div>		
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; ">		
                  <div class="col-md-12 col-sm-12 col-xs-12"><?=$suratkeluar_content;?></div>
                </div>
                <div class="col-md-12">&nbsp;</div>		
        	</div>
        </div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>