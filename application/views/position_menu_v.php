<!doctype html>
<html>

<head>
    <?php require_once("meta.php");?>
	<style>
	.displaynone{
	position:fixed;
	left:50%;
	top:20%;
	transform:translate(-50%,-50%);
	z-index:1000;
		visibility: hidden;
		opacity: 0;
		transition: visibility 0.5s, opacity 0.5s linear;
	}
	.displayinline{
	position:fixed;
	left:50%;
	top:20%;
	transform:translate(-50%,-50%);
	z-index:1000;
		visibility:visible;
		opacity: 1;
		transition: visibility 0s, opacity 0.5s linear;

	}
	ul{margin-left:20px;}
	</style>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Position Menu</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Position Menu : <?=$position_name;?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2" action="<?=site_url("position");?>">							
				<h1 class="page-header col-md-12"> 
				<button class="btn btn-warning btn-block btn-lg" value="OK" style="">Back</button>
				<input type="hidden" name="position_menu_id"/>
				</h1>
			</form>
			<!--
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="position_menu_id"/>
				</h1>
			</form>
			-->
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					
							<div class="alert alert-warning alert-dismissable displaynone">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong id="alertisi"><?=$message;?></strong>
							</div>
						
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								
								<ul class="nav menu">
																
								<?php $men=$this->db->get("menu");
								foreach($men->result() as $menu){
								
								//cek menu
								$m=$this->db
								->where("position_id",$position_id)
								->where("menu_id",$menu->menu_id)
								->where("menu_sub_id","0")
								->where("menu_sub_sub_id","0")
								->get("position_menu");		
								
								$menusu=$this->db
								->where("menu_id",$menu->menu_id)
								->get("menu_sub");
								
								if($menusu->num_rows()>0){
								?>
								<li class="parent backwhite">
									<a href="<?php eval('?>'.$menu->menu_url);?>">
										<?php if($m->num_rows()>0){$cmenu="checked";}else{$cmenu="";}?>
										<input type="checkbox" <?=$cmenu;?> onClick="input_position_menu('<?=$menu->menu_id;?>','0','0',this)" style=""/>
										<span data-toggle="collapse" href="#item-<?=$menu->menu_href;?>" class="fa fa-<?=$menu->menu_fa;?>">&nbsp;&nbsp; <?=$menu->menu_title;?></span> 
									</a>
									<ul class="children collapse" id="item-<?=$menu->menu_href;?>">
									
										<?php 
										foreach($menusu->result() as $menusub){
												
										//cek menu sub
										$msu=$this->db
										->where("position_id",$position_id)
										->where("menu_id",$menu->menu_id)
										->where("menu_sub_id",$menusub->menu_sub_id)
										->where("menu_sub_sub_id","0")
										->get("position_menu");
										
										if($msu->num_rows()>0){$cmenusub="checked";}else{$cmenusub="";}
										
										$menusubsu=$this->db
										->where("menu_sub_id",$menusub->menu_sub_id)
										->get("menu_sub_sub");
										
										if($menusubsu->num_rows()>0){
										?>
										
										<li class="parent backwhite">
											<input type="checkbox" <?=$cmenusub;?> onClick="input_position_menu('<?=$menu->menu_id;?>','<?=$menusub->menu_sub_id;?>','0',this)"/>
											<a href="<?php eval('?>'.$menusub->menu_sub_url);?>">
												<span class="fa fa-<?=$menusub->menu_sub_fa;?>" data-toggle="collapse" href="#item-<?=$menusub->menu_sub_href;?>">
												&nbsp; <?=$menusub->menu_sub_title;?>
												</span> 
											</a>
											<ul class="children collapse" id="item-<?=$menusub->menu_sub_href;?>" style="list-style-type: none;">
												
												<?php 
												foreach($menusubsu->result() as $menusubsub){
												
												//cek menu sub sub
												$msubsu=$this->db
												->where("position_id",$position_id)
												->where("menu_id",$menu->menu_id)
												->where("menu_sub_id",$menusub->menu_sub_id)
												->where("menu_sub_sub_id",$menusubsub->menu_sub_sub_id)
												->get("position_menu");
												?>
												
												<li>
													<?php if($msubsu->num_rows()>0){$cmenusubsub="checked";}else{$cmenusubsub="";}?>
													<input type="checkbox" <?=$cmenusubsub;?> onClick="input_position_menu('<?=$menu->menu_id;?>','<?=$menusub->menu_sub_id;?>','<?=$menusubsub->menu_sub_sub_id;?>',this)"/>
													<a href="<?php eval('?>'.$menusubsub->menu_sub_sub_url);?>">
													&nbsp;&nbsp;&nbsp;&nbsp;
													<i class="fa fa-<?=$menusubsub->menu_sub_sub_fa;?>">&nbsp; <?=$menusubsub->menu_sub_sub_title;?></i>
													</a>
												</li>
												
												<?php }?>
																		
											</ul>
										</li>	
										
										<?php }else{?>
										
										
										<li class="backwhite">
										<input type="checkbox" <?=$cmenusub;?> onClick="input_position_menu('<?=$menu->menu_id;?>','<?=$menusub->menu_sub_id;?>','0',this)"/>
										<a href="<?php eval('?>'.$menusub->menu_sub_url);?>">
											<i class="fa fa-<?=$menusub->menu_sub_fa;?> sub1">&nbsp; <?=$menusub->menu_sub_title;?></i>
										</a>
										</li>
										
										<?php }?>
										<?php }?>
									</ul>				
								</li>
								<?php 
								}else{?>
									<li class="parent backwhite">
									<a href="<?php eval('?>'.$menu->menu_url);?>">
										<?php if($m->num_rows()>0){$cmenu="checked";}else{$cmenu="";}?>
										<input type="checkbox" <?=$cmenu;?> onClick="input_position_menu('<?=$menu->menu_id;?>','0','0',this)" style=""/>
										<span data-toggle="collapse" href="#item-<?=$menu->menu_href;?>" class="fa fa-<?=$menu->menu_fa;?>">&nbsp;&nbsp; <?=$menu->menu_title;?></span> 
									</a>
									</li>
									<?php
									}
								}?>
								
								
								<!--<li class=""><a href="<?=site_url("report");?>"><span class="fa fa-wpforms" style="margin-right:17px;"></span> Report</a></li>
								<li class="hponly" style="display:none;"><a href="<?=site_url("resetpassword");?>"><i class="fa fa-lock"  style="margin-right:17px;"></i> Reset Password</a></li>-->
								<li class="hponly" style="display:none;"><a href="<?=site_url("logout");?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
								
								
							</ul>
								
								</div>
							</div>
						
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
	<script>
	var url;
	function input_position_menu(a,b,c,d){
		if($(d).is(':checked')) {
			url="<?=site_url("api/input_position_menu");?>";
		} else {
			url="<?=site_url("api/remove_position_menu");?>";
		}

		$.get(url,{a:a,b:b,c:c,d:'<?=$position_id;?>'})
		.done(function(data){
			$("#alertisi").html(data);
			$(".alert").removeClass("displaynone").addClass("displayinline");
			setTimeout(function(){
				
			$(".alert").fadeIn().removeClass("displayinline").addClass("displaynone");
			},1000);
		});
	}
	</script>
</body>

</html>
