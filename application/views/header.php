

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal" type="button">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
			
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myImage" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">			
			<div class="modal-body">
				<img id="imgumum" src="" style="max-height:100%; height:auto; width:100%;"/>
			</div>
		</div>
	</div>
</div>
<?php 
//cek user
	if(current_url()!=site_url("register")){
		$userd["user_id"]=$this->session->userdata("user_id");
		$us=$this->db		
		->join("position","position.position_id=user.position_id","left")
		->get_where('user',$userd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $user){		
				foreach($this->db->list_fields('user') as $field)
				{
					$data[$field]=$user->$field;
				}	
				foreach($this->db->list_fields('position') as $field)
				{
					$data[$field]=$user->$field;
				}
			}		
		}else{
			foreach($us->result() as $user){		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]="";
			}
			foreach($this->db->list_fields('position') as $field)
			{
				$data[$field]="";
			}		
		}
		$this->session->sess_destroy();
		redirect(site_url("login"));
		}
	}
?>

<nav class="navbar navbar-inverse navbar-fixed-top backungu" role="navigation">
		<div style="background-image:url(<?=base_url("assets/images/global/iPsyl.png");?>); width:100%; height:100%; position:absolute; top:0px; z-index:-1; opacity:0.4;">&nbsp;</div>
		<div class="container-fluid">
		  <div class="navbar-header ">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#" id="judulatas">
					<img class="img-thumbnail" src="<?=base_url("assets/images/identity_picture/".$identity->identity_picture);?>" alt="" style="width:auto; height:30px; margin-top:-4px;">
					<span style="margin-left:10px; color:#F2F2F2; text-shadow:black 0px 0px 1px;" class="judulhide"><?=$identity->identity_name;?></span> 
					
				</a>
				<ul class="user-menu judulhide">
					<li class="dropdown pull-right">						
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php if($data["user_picture"]!=""){$user_image="assets/images/user_picture/".$data["user_picture"];}else{$user_image="assets/img/user.gif";}?>
                       <img class="" alt="User Picture" width="30" height="30" src="<?=base_url($user_image);?>">
						<?=$data["user_name"];?>, <?=$data["position_name"];?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<!--<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
						<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>-->
						<li><a href="<?=site_url("resetpassword");?>"><i class="fa fa-lock"> Reset Password</i></a></li>
						<li><a href="<?=site_url("logout");?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
					</ul>
					</li>
				</ul>
		  </div>
							
		</div><!-- /.container-fluid -->
</nav>
		
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar" style="background-color:#F4F5FF;">
		<!--<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>-->
		<ul class="nav menu" >
			<li id="dashboard" class="active"><a href="<?=base_url();?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>	
			
			<?php $men=$this->db->get("menu");
			//echo $this->db->last_query();
			if($men->num_rows() > 0){
				foreach($men->result() as $menu){
						
					//cek menu
					$m=$this->db
					->where("position_id",$this->session->userdata("position_id"))
					->where("menu_id",$menu->menu_id)
					->where("menu_sub_id","0")
					->where("menu_sub_sub_id","0")
					->get("position_menu");					
					
					if($m->num_rows()>0){	
					
					$menusu=$this->db
					->where("menu_id",$menu->menu_id)
					->get("menu_sub");
					
					if($menusu->num_rows()>0){
					?>
					<li class="parent backwhite">
						<a href="<?php eval('?>'.$menu->menu_url);?>">
							<span data-toggle="collapse" href="#sub-item-<?=$menu->menu_href;?>" class="fa fa-<?=$menu->menu_fa;?>">&nbsp;&nbsp; <?=$menu->menu_title;?></span> 
						</a>
						<ul class="children collapse" id="sub-item-<?=$menu->menu_href;?>">
						
							<?php 
							foreach($menusu->result() as $menusub){
							if($menusub->menu_sub_title=="Project"&&$identity->identity_project!="1"){$sembunyi="display:none";}else
							if($menusub->menu_sub_title=="Estimasi"&&$identity->identity_project!="1"){$sembunyi="display:none";}else
							if($menusub->menu_sub_title=="Products"&&$identity->identity_project!="2"){$sembunyi="display:none";}else{$sembunyi="";}
							
							//cek menu sub
							$msu=$this->db
							->where("position_id",$this->session->userdata("position_id"))
							->where("menu_id",$menu->menu_id)
							->where("menu_sub_id",$menusub->menu_sub_id)
							->where("menu_sub_sub_id","0")
							->get("position_menu");					
							
							if($msu->num_rows()>0){				
							
							$menusubsu=$this->db
							->where("menu_sub_id",$menusub->menu_sub_id)
							->get("menu_sub_sub");
							
							if($menusubsu->num_rows()>0){
							?>
							
							<li class="parent backwhite">
								<a href="<?php eval('?>'.$menusub->menu_sub_url);?>">
									<span class="fa fa-<?=$menusub->menu_sub_fa;?>" data-toggle="collapse" href="#sub-item-<?=$menusub->menu_sub_href;?>">
									&nbsp; <?=$menusub->menu_sub_title;?>
									</span> 
								</a>
								<ul class="children collapse" id="sub-item-<?=$menusub->menu_sub_href;?>" style="list-style-type: none;">
									
									<?php 
									foreach($menusubsu->result() as $menusubsub){
														
									//cek menu sub sub
									$msubsu=$this->db
									->where("position_id",$this->session->userdata("position_id"))
									->where("menu_id",$menu->menu_id)
									->where("menu_sub_id",$menusub->menu_sub_id)
									->where("menu_sub_sub_id",$menusubsub->menu_sub_sub_id)
									->get("position_menu");
									
									if($msubsu->num_rows()>0){?>
										<li>
											<a href="<?php eval('?>'.$menusubsub->menu_sub_sub_url);?>">
											&nbsp;&nbsp;&nbsp;&nbsp;
											<i class="fa fa-<?=$menusubsub->menu_sub_sub_fa;?>">&nbsp; <?=$menusubsub->menu_sub_sub_title;?></i>
											</a>
										</li>
									<?php }?>
									
									<?php }?>
															
								</ul>
							</li>	
							
							<?php }else{?>
							
								<li class="backwhite"  style="<?=$sembunyi;?>">
								<a href="<?php eval('?>'.$menusub->menu_sub_url);?>">
									<i class="fa fa-<?=$menusub->menu_sub_fa;?> sub1">&nbsp; <?=$menusub->menu_sub_title;?></i>
								</a>
								</li>
							
							<?php }?>
							
							<?php }?>
							<?php }?>
						</ul>				
					</li>
					<?php 
					}else{?>
						<li class="parent backwhite">
						<a href="<?php eval('?>'.$menu->menu_url);?>">
							<span  href="#sub-item-<?=$menu->menu_href;?>" class="fa fa-<?=$menu->menu_fa;?>">&nbsp;&nbsp; <?=$menu->menu_title;?></span> 
						</a>
						</li>
						<?php
						}
					}
				}
			}
			?>
			
			
			<!--<li class=""><a href="<?=site_url("report");?>"><span class="fa fa-wpforms" style="margin-right:17px;"></span> Report</a></li>
			<li class="hponly" style="display:none;"><a href="<?=site_url("resetpassword");?>"><i class="fa fa-lock"  style="margin-right:17px;"></i> Reset Password</a></li>-->
			<li class="hponly" style="display:inline;"><a href="<?=site_url("logout");?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
			
			
		</ul>
		<!--<ul class="nav menu">
			<li class="active"><a href="<?=base_url();?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>	
			<?php if($this->session->userdata("position_id")==1){?>		
			<li class="parent backwhite">
				<a href="#">
					<span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Master</span> 
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li class="parent backwhite">
						<a href="#">
							<span data-toggle="collapse" href="#sub-item-1-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Setting User</span> 
						</a>
						<ul class="children collapse" id="sub-item-1-1">
							
							
							<li>
							<a href="<?=site_url("position");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Position </a>
							</li>
							
							
						
							<li class="">
							<a href="<?=site_url("user");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; User </a>
							</li>
													
						</ul>
					</li>	
					<li class="backwhite">
					<a href="<?=site_url("identity");?>"><i class="fa fa-user sub1"></i>&nbsp; Identity </a>
					</li>
                    <li class="backwhite">
					<a href="<?=site_url("branch");?>"><i class="fa fa-building-o sub1"></i>&nbsp; Branch </a>
					</li>
					<li class="backwhite">
					<a href="<?=site_url("unit");?>"><i class="fa fa-asterisk sub1"></i>&nbsp; Unit </a>
					</li>	
					<li class="backwhite">
					<a href="<?=site_url("nomor");?>"><i class="fa fa-asterisk sub1"></i>&nbsp; Numbering Initials  </a>
					</li>	
					<li class="backwhite">
					<a href="<?=site_url("product");?>"><i class="fa fa-shopping-bag sub1"></i>&nbsp; Product</a>
					</li>		
					<li class="backwhite">
					<a href="<?=site_url("methodpayment");?>"><i class="fa fa-shopping-bag sub1"></i>&nbsp; Payment</a>
					</li>
					<li class="parent backwhite">
						<a href="#">
							<span data-toggle="collapse" href="#sub-item-1-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Supplier</span> 
						</a>
						<ul class="children collapse" id="sub-item-1-2">
							
							
							<li>
							<a href="<?=site_url("supplier");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Supplier </a>
							</li>
								
							<li>
							<a href="<?=site_url("pofield");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; PO Fields</a>
							</li>
																				
						</ul>
					</li>
					<li class="parent backwhite">
						<a href="#">
							<span data-toggle="collapse" href="#sub-item-1-3"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Customer</span> 
						</a>
						<ul class="children collapse" id="sub-item-1-3">
							
							
							<li>
							<a href="<?=site_url("customer");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Customer </a>
							</li>
							
							<li>
							<a href="<?=site_url("qfield");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Quotation Fields </a>
							</li>
							
							<li>
							<a href="<?=site_url("invfield");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Invoice Fields </a>
							</li>							
																				
						</ul>
					</li>
					
				</ul>				
			</li>
			<?php }?>
			<li class="parent backwhite">
				<a href="#">
					<span data-toggle="collapse" href="#sub-item-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Transaction</span> 
				</a>
				<ul class="children collapse" id="sub-item-2">
					<?php if($this->session->userdata("position_id")==2){?>
					<li class="backwhite">
						<a href="<?=site_url("taskt");?>">
							<span class="fa fa-tags" style="margin-right:17px;"></span> Task
						</a>
					</li>
					<?php }else{?>
                    <li class="backwhite">
						<a href="<?=site_url("suratkeluar");?>">
							<span class="fa fa-envelope-open-o" style="margin-right:17px;"></span> Out Mail
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("project");?>">
							<span class="fa fa-tags" style="margin-right:17px;"></span> Project
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("kas");?>">
							<span class="fa fa-money" style="margin-right:17px;"></span> Big Cash 
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("petty");?>">
							<span class="fa fa-money" style="margin-right:17px;"></span> Petty Cash 
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("gaji?month=".date("n"));?>">
							<span class="fa fa-money" style="margin-right:17px;"></span> Payroll 
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("gudang");?>">
							<span class="fa fa-cube" style="margin-right:17px;"></span> Stock 
						</a>
					</li>
					<li class="parent backwhite">
						<a href="#">
							<span data-toggle="collapse" href="#sub-item-2-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Supplier</span> 
						</a>
						<ul class="children collapse" id="sub-item-2-1">							
							
							<li>
							<a href="<?=site_url("po");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; PO</a>
							</li>
							
							<li>
							<a href="<?=site_url("sjmasuk");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; SJ Masuk</a>
							</li>
							
							<li>
							<a href="<?=site_url("invs");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Invoice</a>
							</li>
													
						</ul>
					</li>
					<li class="parent backwhite">
						<a href="#">
							<span data-toggle="collapse" href="#sub-item-2-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Customer</span> 
						</a>
						<ul class="children collapse" id="sub-item-2-2">							
							
							<li class="">
							<a href="<?=site_url("quotation");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Quotation & PO</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("poc");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; PO No Quotation</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("sjkeluar");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; SJ Keluar</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("task");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Assignment</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("inv");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Invoice</a>
							</li>
							
							<li>
							<a href="<?=site_url("invpayment");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Payment Non Invoice</a>
							</li>		
													
						</ul>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("invpayment");?>">
							<span class="fa fa-money" style="margin-right:17px;"></span>  Pemasukan
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("invspayment");?>">
							<span class="fa fa-money" style="margin-right:17px;"></span>  Pengeluaran
						</a>
					</li>
					
					
					
					
					<?php }?>
				</ul>				
			</li>
			<li class="parent backwhite">
				<a href="#">
					<span data-toggle="collapse" href="#sub-item-3"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Report</span> 
				</a>
				<ul class="children collapse" id="sub-item-3">
					<?php if($this->session->userdata("position_id")==2){?>
					<li class="backwhite">
						<a href="<?=site_url("taskt?report=ok");?>">
							<span class="fa fa-tags" style="margin-right:17px;"></span> Task
						</a>
					</li>
					<?php }else{?>
                    <li class="backwhite">
						<a href="<?=site_url("suratkeluar?report=ok&dari=".date("Y-m-d")."&ke=".date("Y-m-d"));?>">
							<span class="fa fa-envelope-open-o" style="margin-right:17px;"></span> Out Mail 
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("kas?report=ok&dari=".date("Y-m-d")."&ke=".date("Y-m-d"));?>">
							<span class="fa fa-money" style="margin-right:17px;"></span> Big Cash 
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("petty?report=ok&dari=".date("Y-m-d")."&ke=".date("Y-m-d"));?>">
							<span class="fa fa-money" style="margin-right:17px;"></span> Petty Cash 
						</a>
					</li>
                    <li class="backwhite">
						<a href="<?=site_url("gaji?report=ok&month=".date("n"));?>">
							<span class="fa fa-money" style="margin-right:17px;"></span> Payroll 
						</a>
					</li>
					<li class="backwhite">
						<a href="<?=site_url("warehouse?report=ok");?>">
							<span class="fa fa-cube" style="margin-right:17px;"></span> Stock 
						</a>
					</li>
                    <li class="backwhite">
						<a href="<?=site_url("projectreport");?>">
							<span class="fa fa-superpowers" style="margin-right:17px;"></span> Project 
						</a>
					</li>
					<li class="parent backwhite">
						<a href="#">
							<span data-toggle="collapse" href="#sub-item-3-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Supplier</span> 
						</a>
						<ul class="children collapse" id="sub-item-3-1">
							
							
							<li>
							<a href="<?=site_url("po?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; PO</a>
							</li>
							
							<li>
							<a href="<?=site_url("sjmasuk?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; SJ Masuk</a>
							</li>
							
							<li>
							<a href="<?=site_url("spayment?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Payment Invoice</a>
							</li>
							
							
													
						</ul>
					</li>
					<li class="parent backwhite">
						<a href="#">
							<span data-toggle="collapse" href="#sub-item-3-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg> Customer</span> 
						</a>
						<ul class="children collapse" id="sub-item-3-2">						
							
							<li class="">
							<a href="<?=site_url("quotation?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Quotation</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("sumquotation?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Summary Quotation</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("sjkeluar?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; SJ Keluar</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("task?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Assignment</a>
							</li>
							
							<li class="">
							<a href="<?=site_url("inv?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Invoice</a>
							</li>
							
							<li>
							<a href="<?=site_url("cpayment?report=ok");?>">
							  &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i>&nbsp; Payment Invoice</a>
							</li>
													
						</ul>
					</li>					
					
					
					<?php }?>
				</ul>				
			</li>
			
			<li class="hponly" style="display:none;"><a href="<?=site_url("logout");?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
			
			
		</ul>-->
		<div class="judulhide col-md-12" style="position:absolute; bottom:0px; padding:10px; border-top:#F0F0F0 solid 1px; z-index:-2;" align="center"><img src="<?=base_url("assets/images/icon/gets.png");?>" alt="" style="width:35px; height:auto;"><br/></div>
		<div id="notification">			
		</div>
	</div>