<?php			
function lempar($parameter){
if(isset($_POST[$parameter])&&$_POST[$parameter]){$parameter=$this->input->post($parameter);}else
if(isset($_GET[$parameter])&&$_GET[$parameter]){$parameter=$this->input->get($parameter);}else
{$parameter=NULL;}
return $parameter;	
}
function lemper($parameter){
if(isset($_POST[$parameter])&&$_POST[$parameter]){$parameter=$this->input->post($parameter);}else
if(isset($_GET[$parameter])&&$_GET[$parameter]){$parameter=$this->input->get($parameter);}else
{$parameter="";}
return $parameter;	
}
function lempor($parameter){
if(isset($_POST[$parameter])&&$_POST[$parameter]){$parameter=$this->input->post($parameter);}else
if(isset($_GET[$parameter])&&$_GET[$parameter]){$parameter=$this->input->get($parameter);}else
{$parameter="0";}
return $parameter;	
}
?>