<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->session_lib->admin();
		
		$this->load->library('encrypt_decrypt');		
		$this->load->model('profil_aplikasi_model');
	} 

	public function index(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		if($this->input->post('nm_aplikasi')){
			$this->form_validation->set_rules('nm_aplikasi', 'Nama Aplikasi', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('telp', 'Telp', 'required');
			
			if ($this->form_validation->run() == FALSE)	{
				$this->notice->warning(validation_errors());	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			else{							
			
				if($_FILES['icon_logo']['name']){
				
								
					$config['upload_path']          = './upload/logo/';
					$config['allowed_types']        = 'jpg|png|jpeg';
					$config['max_size'] 			= '1000';


					$this->load->library('upload', $config);

					if ( !$this->upload->do_upload('icon_logo')){		
						$this->session->set_flashdata($this->input->post());	
						
						$this->notice->warning($this->upload->display_errors());					
						redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
					}
					else{
						$fileUpload = $this->upload->data();
						
					
						$final_file_name = time()."_".$fileUpload['raw_name'].''.$fileUpload['file_ext'];
						rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
										
						$data['icon'] = $final_file_name;
					}
				}
			
				$data['nm_aplikasi'] 			= $this->input->post('nm_aplikasi');
				$data['alamat'] 				= $this->input->post('alamat');
				$data['telp'] 					= $this->input->post('telp');
			
				$returnUpdate = $this->profil_aplikasi_model->update($data);
				//echo $this->db->last_query();exit();
				//var_dump($returnUpdate);exit();
				if($returnUpdate){
					$this->notice->success("Proses Ubah Data Profil Aplikasi berhasil.");				
					redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
				}
				else{				
					$this->session->set_flashdata($this->input->post());
					$this->notice->warning("Proses Ubah Data Profil Aplikasi Gagal, silahkan cek inputan Anda.");				
					redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
				}
			}
		}
		
		$this->dataForUpdate = $this->profil_aplikasi_model->getData();
		
		$this->template_view->load_admin_view('master/profil_aplikasi/profil_aplikasi_view');
	}

	
}
	
	
	
