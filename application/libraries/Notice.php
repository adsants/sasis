<?php

Class Notice {
	public function __construct(){
		$this->msg = new stdClass();
		$this->CI =& get_instance();
	}
	
		
	public function success($msg){
		$msg = "<div class='alert alert-success'>".$msg."</div>";
		$this->build($msg);
	}

	public function warning($msg){
		$msg = "<div class='alert alert-warning'>".$msg."</div>";
		$this->build($msg);
	}
		
	public function build($msg){
		$notice = $this->CI->session->flashdata("notice");
		if(!$notice) $notice = new stdClass();
		
		$this->CI->session->set_flashdata("notice",$msg);		
	}
}
