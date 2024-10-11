<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class printpdf extends CI_Controller {


	public function index()
	{
		?>
		<div class="col-md-12">	
			<div id="example1"></div>
			<script src="<?=base_url("assets/js/pdfobject.js");?>"></script>
			<?php if($this->input->get("type")=="pdf"){?>
			<script>PDFObject.embed("<?=$this->input->get("url");?>", "#example1");</script>
			<?php }elseif($this->input->get("type")=="image"){?>
			<img src="<?=$this->input->get("url");?>"/>
			<script>
			window.print();
			setTimeout(function(){ this.close(); }, 500);
			</script>
			<?php }?>
			<br/>
		</div>
		
		<?php
	}
}
