<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mata_pelajaran extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->session_lib->admin();
		
		$this->load->model('m_mata_pelajaran_model');
	} 

	public function index(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		$like 		= null;
		$urlSearch 	= null;
		$order_by	=	"nm_mata_pelajaran";

		if($this->input->get('search')){
			$urlSearch 	= 	"?search=".$_GET['search'];
			$like		=	$this->input->get('search');			
		}

		$config['base_url'] 	= base_url().'backoffice/'.$this->uri->segment(2).'/index'.$urlSearch;
		
		$this->jumlahData 		= $this->m_mata_pelajaran_model->showData("",$like);
		$config['total_rows'] 	= count($this->jumlahData);
		$config['per_page'] 	= 10;
		
		$this->showData 		= $this->m_mata_pelajaran_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);		
		
		$this->template_view->load_admin_view('master/mata_pelajaran/mata_pelajaran_view');
	}
	public function add(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
	
		$this->template_view->load_admin_view('master/mata_pelajaran/mata_pelajaran_add_view');
	}
	public function insert(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		$this->form_validation->set_rules('nm_mata_pelajaran', 'Mata Pelajaran', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
		}
		else{							
		
			$data['nm_mata_pelajaran'] 			= $this->input->post('nm_mata_pelajaran');
		
			$newid = $this->m_mata_pelajaran_model->insert($data);
			
			if($newid){
				$this->notice->success("Proses Tambah Data Mata Pelajaran berhasil.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Tambah Data Mata Pelajaran Gagal, silahkan cek inputan Anda.");				
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
		$this->dataForUpdate	=	$this->m_mata_pelajaran_model->getData($primaryKey);
		
		if(!$this->dataForUpdate){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->template_view->load_admin_view('master/mata_pelajaran/mata_pelajaran_edit_view');
	}
	public function update($primaryKey = null){	
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
		
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
			
			
		$this->form_validation->set_rules('nm_mata_pelajaran', 'Mata Pelajaran', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
		}
		else{							
		
			$data['nm_mata_pelajaran'] 			= $this->input->post('nm_mata_pelajaran');
		
			$returnUpdate = $this->m_mata_pelajaran_model->update($primaryKey,$data);
			
			if($returnUpdate){
				$this->notice->success("Proses Ubah Data Mata Pelajaran berhasil.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Ubah Data Mata Pelajaran Gagal, silahkan cek inputan Anda.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
			}
		}
	}
	public function delete($primaryKey = null){
		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_delete($this->uri->segment(2));
		
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		$data['id_user_delete'] 	= $this->session->userdata('id_user');
		$data['tgl_delete'] 		= date('Y-m-d H:i:s');	
		$returnUpdate 				= $this->m_mata_pelajaran_model->update($primaryKey,$data);
		
		if($returnUpdate){
			$this->notice->success("Proses Penghapusan Data Mata Pelajaran berhasil.");			
		}
		else{
			$this->notice->warning("Proses Penghapusan Data Mata Pelajaran Gagal, silahkan ulangi lagi.");	
		}				
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
	}
}
	
	
	
