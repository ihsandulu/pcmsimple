<!DOCTYPE html>
<html>
	<head>
		<title>Print Payroll</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
        <style>
		th,td{text-align:center;}
		</style>
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
            
                <div class="col-md-12"><h1 style="text-decoration:underline;">Payroll</h1></div>
                <div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;">
                    <div class="col-md-2 col-sm-2 col-xs-3">Payroll No.</div>
                    <div class="col-md-1 col-sm-1 col-xs-1">:</div>
                    <div class="col-md-9 col-sm-9 col-xs-8"><?=$gaji_no;?>&nbsp;</div>
                    <div class="col-md-2 col-sm-2 col-xs-3">Name</div>
                    <div class="col-md-1 col-sm-1 col-xs-1">:</div>
                    <div class="col-md-9 col-sm-9 col-xs-8"><?=$gaji_name;?>&nbsp;</div>
                    <div class="col-md-2 col-sm-2 col-xs-3">Month</div>
                    <div class="col-md-1 col-sm-1 col-xs-1">:</div>
                    <div class="col-md-9 col-sm-9 col-xs-8"><?=date("M Y",strtotime($gaji_year."-".$gaji_month."-1"));?>&nbsp;</div>
                </div>
               
                <div style="">&nbsp;<br/><br/><br/><br/></div>		
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; ">		
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  <h2>Detail</h2>
                  <table class="table table-bordered col-md-12 col-sm-12 col-xs-12">
                  	<thead>                    	
                    	<tr>
                    	  <th>Description</th>
                  	      <th>Basic (IDR)</th>
                   	      <th>Rate (IDR)</th>
                   	      <th>Day of Work</th>
                   	      <th>Total</th>
                   	  </tr>
                    </thead>
                    <tbody>
                    	<tr>
                        	<td><?=$gaji_description;?></td>
                        	<td><?=number_format($gaji_basic,0,",",".")?></td>
                        	<td><?=number_format($gaji_rate,0,",",".");?></td>
                        	<td><?=$gaji_numday;?></td>
                            <td><?=number_format($gaji_rate*$gaji_numday,0,",",".");?></td>
                        </tr>                    	
                    </tbody>                  
                  </table>
                  <hr/>
                  <h2>Deduction & Bank</h2>
				  <table class="table table-bordered col-md-5 col-sm-12 col-xs-12">
                  	<thead>
                    	<tr>                    	  
                   	      <th>Deduction For</th>
                   	      <th>Amount</th>
                   	  </tr>
                    </thead>
                    <tbody>
                    	<tr>                        	
                        	<td><?=$gaji_deduction_name;?></td>
                        	<td><?=number_format($gaji_deduction_amount,0,",",".");?></td>
                        </tr>                    	
                    </tbody>                  
                  </table>
                  <table class="table table-bordered col-md-offset-1 col-md-5 col-sm-12 col-xs-12">
                  	<thead>
                    	<tr>                    	  
                   	      <th>Bank</th>
                   	      <th>Account Bank</th>
                   	      <th>Remarks</th>
                   	  </tr>
                    </thead>
                    <tbody>
                    	<tr>                        	
                        	<td><?=$gaji_bank;?></td>
                        	<td><?=$gaji_rek;?></td>
                        	<td><?=$gaji_remarks_bank;?></td>
                        </tr>                    	
                    </tbody>                  
                  </table>
                  <hr/>
                  <h2>Payment</h2>
                  <table class="table table-bordered col-md-12 col-sm-12 col-xs-12">
                  	<thead>                    	
                    	<tr>
                    	  <th>Period</th>
                  	      <th>Total Payment</th>
                   	      <th>Remarks</th>
                   	  </tr>
                    </thead>
                    <tbody>
                    	<tr>
                        	<td><?=$gaji_period;?></td>
                        	<td><?=number_format(($gaji_rate*$gaji_numday)-$gaji_deduction_amount,0,",",".");?></td>
                        	<td><?=$gaji_remarks_payment;?></td>
                        </tr>
                    </tbody>                  
                  </table>
                  <br/>
                  <table class="table table-bordered col-md-12 col-sm-12 col-xs-12">
                  	<thead>                    	
                    	<tr>
                    	  <th>Prepared By</th>
                  	      <th>Approved By</th>
                   	      <th>Received By</th>
                   	      <th>Date</th>
                   	  </tr>
                    </thead>
                    <tbody>
                    	<tr>
                        	<td style="height:150px;"><?=$gaji_prepare;?></td>
                        	<td><?=$gaji_approve;?></td>
                        	<td><?=$gaji_receive;?></td>
                        	<td></td>
                        </tr>
                    </tbody>                  
                  </table>
                  </div>
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