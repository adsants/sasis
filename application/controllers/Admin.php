<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		$this->load->model('m_user_model');
		
	} 

	public function index(){
		
		
		$oke = $this->db->query('show variables like "max_connections"')->row();
		
		if($oke->Value < 3000){
			$this->db->query('set global max_connections = 3000;');
		}
		
		
		ob_start();
		system("ipconfig /all"); //Execute external program to display output
		$mycom = ob_get_contents(); // Capture the output into a variable
		ob_clean();
		
		$findme = "Physical";
		$pmac = strpos($mycom, $findme); // Find the position of Physical text
		
		$mac = substr($mycom, ($pmac + 36), 17);
		//echo $mac;
		
		
		//$this->load->library('encrypt_decrypt');			
		$this->template_view->load_login_admin_view('template/login_admin_view');
		
			//echo	$this->encrypt_decrypt->getText('decrypt', 'cTVvZGFjc3ExeDRXdUZoSVN1OUlzUT09');	
			//echo "...";
			//echo	$this->encrypt_decrypt->getText('encrypt', '123');	
	}
	
	public function authentication(){
		$this->load->library('encrypt_decrypt');			
			
		$this->form_validation->set_rules('user_name', 'Username', 'required');
		$this->form_validation->set_rules('pass_word', 'Password', 'required');
			
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			redirect('admin');
		}
		else{					
		
			
		
			$user		=	$this->input->post('user_name');
			
			$pass		=	str_replace("'","",$this->input->post('pass_word'));
			$pass		=	str_replace("+","",$this->input->post('pass_word'));
			
			$pass 		= 	$this->encrypt_decrypt->getText('encrypt', $pass);				
			
			$whereArray 		= array('user_name' => $user, 'pass_word' => $pass, 'aktif_user' => 'A');
			$dataUser	=	$this->m_user_model->getData($whereArray);
			//echo $this->db->last_query();
		//	var_dump($dataUser);exit();
			if($dataUser){					
				$this->session->set_userdata('id_kategori_user', $dataUser->id_kategori_user);
				$this->session->set_userdata('id_user', $dataUser->id_user);
				$this->session->set_userdata('nama', $dataUser->nama_user);
				$this->session->set_userdata('login_akhir', $dataUser->login_akhir_indo);
				//$this->session->set_userdata('nip', $dataUser->nip_pegawai);
				
				//var_dump($this->session->userdata());
				//exit();
				
				$updateLoginAkhir['login_akhir'] = date('Y-m-d H:i:s');
				$this->m_user_model->update($dataUser->id_user, $updateLoginAkhir);
				
				redirect('backoffice/dashboard');
			}
			else{
				
				
				
				$this->session->set_flashdata($this->input->post());
				
				$this->session->unset_userdata('id_user');
				 
				$this->notice->warning("Maaf, anda gagal Login, silahkan inputkan Username dan Password dengan Benar !");	
				
			//var_dump( $this->db->last_query());
				redirect('admin');
			}
		}	
	}

	
}
