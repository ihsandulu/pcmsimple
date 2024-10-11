<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once("meta.php");?>	
	<style>
	html, body{
		background: url(<?=base_url("assets/images/global/back.jpg");?>) no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	.backutama{margin-top:10px; position:fixed; left:50%; top:50%; transform:translate(-50%,-50%); width:100%;}
	@media screen and (min-width: 991px){
		.formin{ padding-left:5%;}
		.formd{ margin-top:30px !important; }
		.logologo{ padding:10px; }
		.logobottom{
			padding:10px; 
			height:90px;
			}
		.powerby{position:relative; top:60px;}
		.cudologo{float:right; width:350px;  text-align:right; position:relative; top:20px; right:100px;}
	}
	@media screen and (min-width: 767px){
		.formin{ padding-left:5%;}
		.logologo{ padding:10px; }
		.powerby{position:relative; top:60px;}
		.logobottom{
			padding:0px; 
			height:90px;
			}
		.cudologo{float:right; width:350px;  text-align:right;}
	}
	@media screen and (max-width: 766px){		
		.logologo{ padding:10px; }
		.cudologo{text-align:center; position:relative; top:20px; right:0px;}
		.scmlogo{position:relative; top:-15px;}
	}
	</style>
</head>
<body>	
	<div class="container-fluid backutama">
		<div class="row part">
			<!----><div class="col-md-12 part" align="center">
				<img class="img-responsive" src="<?=base_url("assets/images/icon/pcm.png");?>" style="height:50px; width:auto; margin-top:30px;"/>
			</div>
			<div class="col-md-12 part" align="center">
				<h1 style="text-shadow:#C1BDBA 2px 2px 3px; color:#F2F7FA;"><b>Project Cost Management</b></h1>
			</div>
		</div>
		<br/>
		
		<div class="row">
			<div id="bck" class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 col-xs-12" style="background-color:#DAD0CE; opacity:0.5; height:210px; padding:20px; border-radius:5px;">
				
			</div>
			<div class="formin" style="position:relative; top:0px;" >
				<div class="col-md-offset-4 col-md-3 col-sm-offset-3 col-sm-5  col-xs-12" style="position:absolute; top:0px; margin-top:20px;">
					<?php if($hasil!=""){?>
					<div id="alert" class="alert alert-warning alert-dismissable">
					  <a id="close" href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  <strong>Warning!</strong> {hasil}
					</div>
					<script>
						$("#bck").css("height","270px");
						$("#close").click(function(){
							$("#alert").hide();
							$("#bck").css("height","210px");
						});
					</script>
					<?php }echo$hasil;?>
					<div class="text-center col-md-12" style="font-size:13px;"><b>Please type your Username and Password</b></div>
					<form class="formd form-horizontal" style="margin:20px;" method="post">
					  <div class="input-group form-group">
						<span class="input-group-addon" style=" background-color:#000000; color:white; border:black solid 1px;"><i class="glyphicon glyphicon-user"></i></span>
						<input id="user_email" type="email" class="form-control" name="user_email" placeholder="Email">
					  </div>
					  <div class="input-group form-group">
						<span class="input-group-addon" style=" background-color:#000000; color:white; border:black solid 1px;"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="user_password" type="password" class="form-control" name="user_password" placeholder="Password">
					  </div>					  
					  <div class="form-group">						
						<button type="submit" class="btn btn-primary btn-block  col-sm-12">Submit</button>						
					  </div>
					</form>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:30px;">
			<div class="col-md-12 scmlogo" style="padding-top:0px;">
				<div class="col-md-3 col-sm-3 col-xs-12 text-center logobottom" style="" align="center">
					<div class="col-md-12 col-sm-12 text-center" style="color:white; padding:5px; text-shadow:#C1BDBA 2px 2px 3px;">exclusively built for</div>
					<div class="col-md-12 col-sm-12">
					<img class="" src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:auto; height:70px;"/>
					</div>
				</div>
				<div class="logobottom cudologo" style=" ">	
					<div class="col-md-12 col-sm-12 col-xs-12 " style="color:white; text-shadow:#C1BDBA 2px 2px 3px;">powered by GETS</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<img class="" src="<?=base_url("assets/images/icon/gets.png");?>" style="width:100px; height:auto;"/>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>