<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		
		///// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->session_lib->admin();
		
		$this->load->model('m_user_model');
		$this->load->model('kategori_user_model');
		$this->load->model('t_hak_akses_model');
		$this->load->library('encrypt_decrypt');
		$this->load->library('text_html');
	} 

	public function index(){
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		
		$like 		= null;
		$urlSearch 	= null;
		$order_by	=	"user_name";

		if($this->input->get('search')){
			$urlSearch 	= 	"?search=".$_GET['search'];
			$like		=	$this->input->get('search');			
		}

		$config['base_url'] 	= base_url().'backoffice/'.$this->uri->segment(2).'/index'.$urlSearch;
		
		$this->jumlahData 		= $this->m_user_model->showData("id_user !='1'",$like);
		$config['total_rows'] 	= count($this->jumlahData);
		$config['per_page'] 	= 10;
		
		$this->showData 		= $this->m_user_model->showData("id_user !='1'",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);		
		
		$this->template_view->load_admin_view('master/user/user_view');
	}
	
	public function add(){
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		$this->dataKategoriUser = $this->kategori_user_model->showDataNotdeveloper();
		$this->template_view->load_admin_view('master/user/user_add_view');
	}
	
	public function insert(){
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		$this->form_validation->set_rules('id_kategori_user_form', 'Kategori User', 'required');
		$this->form_validation->set_rules('nama_user_form', 'Nama', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
		}
		else{							
			$checkUsernameSama	=	$this->m_user_model->getData(array('m_user.user_name' => $this->input->post('user_name_form')));
			
			
			if($checkUsernameSama){
				$this->session->set_flashdata($this->input->post());
				
				$this->notice->warning('Proses Tambah Data User Gagal, dikarenakan Username <b>'.$this->input->post('user_name_form').'</b> telah digunakan. Silahkan gunakan username lainnya.');				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
			}
			
			
		//	exit();
			
			if ( preg_match('/\s/',$this->input->post('pass_word')) ) {
				$this->notice->warning('Proses Tambah Data User Gagal, dikarenakan Password tidak boleh ada spasi');	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
			}
			
			if ( preg_match('/\s/',$this->input->post('user_name')) ) {
				$this->notice->warning('Proses Tambah Data User Gagal, dikarenakan Username tidak boleh ada spasi');	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
			}
			
			$data['id_kategori_user'] 			= $this->input->post('id_kategori_user_form');
			$data['nama_user'] 			= $this->input->post('nama_user_form');
			
			$data['user_name'] 					= $this->input->post('user_name_form');		
			
			
			$this->load->library('encrypt_decrypt');
			$pass							=	$this->encrypt_decrypt->getText('encrypt', $this->input->post('pass_word_form'));	
			$data['pass_word'] 				= $pass;		
			$data['aktif_user'] 			=  "A";		
		
			$newid = $this->m_user_model->insert($data);
			
			if($newid){
				//$this->notice->success("Proses Tambah Data User berhasil.");						
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Tambah Data Kategori User Gagal, silahkan cek inputan Anda.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
			}			
		}		
	}

	public function edit($primaryKey = null){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		
		$this->dataForUpdate = $this->m_user_model->getData(array('m_user.id_user' => $primaryKey));
		
		if(!$this->dataForUpdate){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		//var_dump($this->dataForUpdate);
	//	$this->load->library('encrypt_decrypt');
		$this->dataKategoriUser = $this->kategori_user_model->showData();
	
		
		$this->load->library('encrypt_decrypt');
		//	$pass							=	$this->encrypt_decrypt->getText('encrypt', $this->input->post('pass_word'));	
		
		$this->template_view->load_admin_view('master/user/user_edit_view');
	}
	public function update($primaryKey = null){	
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
		
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
			
		$this->form_validation->set_rules('nama_user_form', 'Nama Pegawai', 'required');
		$this->form_validation->set_rules('user_name_form', 'Username', 'required');
		$this->form_validation->set_rules('pass_word_form', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
		}
		else{							
		
			$checkUsernameSama	=	$this->m_user_model->getData(array('m_user.user_name' => $this->input->post('user_name') , "m_user.id_user != '".$primaryKey."'" => null));
			
			if($checkUsernameSama){
				$this->notice->warning('Proses Ubah Data User Gagal, dikarenakan username <b>'.$this->input->post('user_name_form').'</b> telah digunakan. Silahkan ganti Username !');	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
			}
			
			if ( preg_match('/\s/',$this->input->post('pass_word')) ) {
				$this->notice->warning('Proses Ubah Data User Gagal, dikarenakan Password tidak boleh ada spasi');	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
			}
			
			if ( preg_match('/\s/',$this->input->post('user_name')) ) {
				$this->notice->warning('Proses Ubah Data User Gagal, dikarenakan Username tidak boleh ada spasi');	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
			}
		
			$data['nama_user'] 			= $this->input->post('nama_user_form');
			$data['id_kategori_user'] 		= $this->input->post('id_kategori_user_form');
			$data['user_name'] 				= $this->input->post('user_name_form');	
			$data['aktif_user'] 				= $this->input->post('aktif_user');	
			
			
			$this->load->library('encrypt_decrypt');
			$pass							=	$this->encrypt_decrypt->getText('encrypt', $this->input->post('pass_word_form'));
			$data['pass_word'] 				= 	$pass;	
		
			$returnUpdate = $this->m_user_model->update($primaryKey,$data);
			
			if($returnUpdate){
				$this->notice->success("Proses Ubah Data Pegawai berhasil.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Ubah Data Pegawai Gagal, silahkan cek inputan Anda.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
			}
		}	
		
	}
	

}
