		
<?php

Class Session_lib {
	public function __construct(){
		$this->msg = new stdClass();
		$this->CI =& get_instance();
	}
	
		
	public function admin(){		
		if($this->CI->uri->segment('1') != 'admin'){
			if($this->CI->session->userdata('id_user') == ''){
				redirect(base_url("admin"));
			}
		}
	}
	public function siswa(){		
		if($this->CI->uri->segment('1') != 'login'){
			if($this->CI->session->userdata('id_m_siswa_paket_ujian') == ''){
				redirect(base_url("login"));
			}
		}
	}

	
}
		