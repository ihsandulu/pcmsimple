<div style=" border-bottom:black solid 1px; padding-top:5px; ">
							
                    <div class="col-md-2 col-sm-2 col-xs-2 " style="padding:0px; padding-bottom:10px;">
						<?php if(isset($identity_picture)){?>
						<img src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:100%; height:auto; max-width:100%; "/>
						<?php }?>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 " style="padding:0px; padding-top:10px;" align="center">
						<?php if(isset($identity_company)){?>
						<div style="font-weight:bold; padding:0px; font-size:16px;"><?=$identity_company;?></div>
						<?php }?>
						<?php if(isset($identity_address)){?>
						<?=$identity_address;?><br/>
						<?php }?>
						<?php if(isset($identity_phone)){?>
						Phone : <?=$identity_phone;?>
						<?php }?>
						<?php if(isset($identity_fax)){?>
						&nbsp; Fax : <?=$identity_fax;?>
						<?php }?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2" style="text-align:right; padding:0px;">
						
						<?php if(isset($identity_services)){?>
						<span><?=$identity_services;?></span>
						<?php }?>
					</div>		
                    <div style="clear:both;"></div>
	</div>