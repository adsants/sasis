<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_soal extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->session_lib->admin();
		
		$this->load->model('m_paket_soal_model');
		$this->load->model('m_mata_pelajaran_model');
		$this->load->model('m_soal_model');
		$this->load->model('m_jawaban_model');
	} 

	public function index(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		$like 		= null;
		$urlSearch 	= null;
		$order_by	=	"id_m_paket_soal";

		if($this->input->get('search')){
			$urlSearch 	= 	"?search=".$_GET['search'];
			$like		=	$this->input->get('search');			
		}

		$config['base_url'] 	= base_url().'backoffice/'.$this->uri->segment(2).'/index'.$urlSearch;
		
		$this->jumlahData 		= $this->m_paket_soal_model->showData("m_paket_soal.id_m_mata_pelajaran = '".$this->input->get('id_m_mata_pelajaran')."'",$like);
		$config['total_rows'] 	= count($this->jumlahData);
		$config['per_page'] 	= 10;
		
		$this->showData 		= $this->m_paket_soal_model->showData("m_paket_soal.id_m_mata_pelajaran = '".$this->input->get('id_m_mata_pelajaran')."'",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->dataMapel 		= $this->m_mata_pelajaran_model->showData("",'','m_mata_pelajaran.nm_mata_pelajaran');
		$this->pagination->initialize($config);		
		
		$this->template_view->load_admin_view('master/paket_soal/paket_soal_view');
	}
	public function add(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		
		$this->dataMapel 		= $this->m_mata_pelajaran_model->showData("",'','m_mata_pelajaran.nm_mata_pelajaran');
	
		$this->template_view->load_admin_view('master/paket_soal/paket_soal_add_view');
	}
	public function insert(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		$this->form_validation->set_rules('nm_paket_soal', 'Paket Soal', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
		}
		else{							
		
			$data['nm_paket_soal'] 			= $this->input->post('nm_paket_soal');
			$data['id_m_mata_pelajaran'] 	= $this->input->post('id_m_mata_pelajaran');
		
			$newid = $this->m_paket_soal_model->insert($data);
			
			if($newid){
				$this->notice->success("Proses Tambah Data Paket Soal berhasil.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."?id_m_mata_pelajaran=".$this->input->post('id_m_mata_pelajaran'));
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Tambah Data Paket Soal Gagal, silahkan cek inputan Anda.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add/?id_m_mata_pelajaran=".$this->input->post('id_m_mata_pelajaran'));
			}			
		}
	}
	
	
	public function edit($primaryKey = null){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		$this->dataForUpdate	=	$this->m_paket_soal_model->getData($primaryKey);
		
		if(!$this->dataForUpdate){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->dataMapel 		= $this->m_mata_pelajaran_model->showData("",'','m_mata_pelajaran.nm_mata_pelajaran');
		$this->template_view->load_admin_view('master/paket_soal/paket_soal_edit_view');
	}
	public function update($primaryKey = null){	
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
		
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
			
			
		$this->form_validation->set_rules('nm_paket_soal', 'Paket Soal', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
		}
		else{							
		
			$data['nm_paket_soal'] 			= $this->input->post('nm_paket_soal');
		
			$returnUpdate = $this->m_paket_soal_model->update($primaryKey,$data);
			
			if($returnUpdate){
				$this->notice->success("Proses Ubah Data Paket Soal berhasil.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."?id_m_mata_pelajaran=".$this->input->post('id_m_mata_pelajaran'));
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Ubah Data Paket Soal Gagal, silahkan cek inputan Anda.");			

				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey."?id_m_mata_pelajaran=".$this->input->post('id_m_mata_pelajaran'));
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
		$returnUpdate 				= $this->m_paket_soal_model->update($primaryKey,$data);
		
		if($returnUpdate){
			$this->notice->success("Proses Penghapusan Data Paket Soal berhasil.");			
		}
		else{
			$this->notice->warning("Proses Penghapusan Data Paket Soal Gagal, silahkan ulangi lagi.");	
		}				
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
	}
	
	
	public function soal(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		$this->dataPaketSoal	=	$this->m_paket_soal_model->getData($this->input->get('id_m_paket_soal'));
		
		$like 		= null;
		$urlSearch 	= null;
		$order_by	=	"id_m_soal";

		if($this->input->get('search')){
			$urlSearch 	= 	"?search=".$_GET['search'];
			$like		=	$this->input->get('search');			
		}

		$config['base_url'] 	= base_url().'backoffice/'.$this->uri->segment(2).'/index'.$urlSearch;
		
		$where = array('m_soal.id_m_paket_soal' => $this->input->get('id_m_paket_soal'));
		
		$this->jumlahData 		= $this->m_soal_model->showData($where,$like);
		$config['total_rows'] 	= count($this->jumlahData);
		$config['per_page'] 	= 150;
		
		$this->showData 		= $this->m_soal_model->showData($where,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);		
		
		$this->template_view->load_admin_view('master/paket_soal/soal_view');
	}
	
	public function add_soal(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		if(!$this->input->get('id_m_paket_soal')){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		
		$this->dataPaket		= $this->m_paket_soal_model->getData( $this->input->get('id_m_paket_soal'));
	
		$this->template_view->load_admin_view('master/paket_soal/soal_add_view');
	}
	
	
	public function insert_soal(){	
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		
		
		
		$this->form_validation->set_rules('soal', 'Soal', 'required');
		$this->form_validation->set_rules('jenis_soal', 'Jenis Soal', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add_soal?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));	
		}
		
		else{		
		
			if($this->input->post('jenis_soal')=='G'){
				
				
				//echo $this->input->post('status');
				if($this->input->post('status')==''){
					$this->notice->warning("Proses Penambahan Data Soal gagal, dikarenakan anda belum memilih Jawaban Benar.");	
					
					$this->session->set_flashdata($this->input->post());			
					
					redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add_soal?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));		
				}
				
				
			}
				
				
			//	var_dump($_FILES);exit();
			
			
				
				
			
				if($_FILES['file_soal']['name']){
					//var_dump($_FILES['file_soal']['type']);exit();
					
					$errors     = array();
					$maxsize    = 10097152;
					$acceptable = array(
						'audio/mpeg',
						'video/mp4',
						'audio/mp3'
					);

					if(($_FILES['file_soal']['size'] >= $maxsize) || ($_FILES["file_soal"]["size"] == 0)) {
						$errors[] = 'File terlalu Besar, File harus lebih kecil dari 10 megabytes.';
					}

					if(!in_array($_FILES['file_soal']['type'], $acceptable) && (!empty($_FILES["file_soal"]["type"]))) {
						$errors[] = 'Type File yang diperbolehkan adalah mp3 dan mp4.';
					}
					
					if(count($errors) === 0) {
						$audio_content = base64_encode(file_get_contents($_FILES['file_soal']['tmp_name']));									
						$data['file_soal'] 		= $audio_content;
						$typeFile = explode("/", $_FILES['file_soal']['type']);
						$data['type_file_soal'] = $typeFile[1];
					} else {
						$this->session->set_flashdata($this->input->post());
						$warning  = "";
						foreach($errors as $error) {
							$warning .= $error;	
						}
						$this->notice->warning($warning);
						
						redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add_soal?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));			
						
					}
				}
					
			
		
				$data['soal'] 						= $this->input->post('soal');
				$data['jenis_soal'] 				= $this->input->post('jenis_soal');
				$data['status_soal'] 				= 'A';
				$data['kategori_soal'] 				= $this->input->post('kategori_soal');
				$data['id_m_paket_soal'] 			= $this->input->get('id_m_paket_soal');
				if($this->input->post('jenis_soal')=='G'){
					$data['jml_jawaban'] 			= $this->input->post('jml_jawaban');
				}
				//$data['urut_soal'] 				= $this->input->post('urut_soal');
			
				$newid = $this->m_soal_model->insert($data);
				//$newid = '1';
				if($newid){
					if($this->input->post('jenis_soal') == 'G'){
						foreach($this->input->post('jawaban') as $urutJawaban  =>  $jawaban){
							if($jawaban[$urutJawaban]){
								
								if($this->input->post('status') == $urutJawaban ){
									$status	=	'B';				
								}
								else{
									$status	=	'S';
								}
								
								$dataJawaban['id_m_soal'] 	= 	$newid;
								$dataJawaban['jawaban'] 	= 	$jawaban[$urutJawaban];					
								$dataJawaban['status'] 		= 	$status;					
								$idJawab = $this->m_jawaban_model->insert($dataJawaban);
							}
						}
					//exit();
					
					
						
						$this->notice->success("Proses Tambah Data Soal berhasil");				
						
						redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/soal?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));
						
					}
					else{					
						$this->notice->success("Proses Tambah Data Soal berhasil");	
						
						redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/soal?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));
					}
				}
				else{				
					$this->session->set_flashdata($this->input->post());
					$this->notice->warning("Proses Tambah Data Soal Gagal, silahkan cek inputan Anda.");	
					
					redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add_soal?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));
				}
			
		}
	}
	
	public function edit_soal($primaryKey = null){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		$this->dataForUpdate	=	$this->m_soal_model->getData($this->input->get('id_m_soal'));
		
		if(!$this->dataForUpdate){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->dataJawaban	=	$this->m_jawaban_model->showData(array('m_jawaban.id_m_soal' => $this->input->get('id_m_soal')));
		
		$this->tampilkan_urut = 'N';
		
	
		
		$this->template_view->load_admin_view('master/paket_soal/soal_edit_view');
	}
	
	public function update_soal($primaryKey = null){	
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
		
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
			
			
		$this->form_validation->set_rules('soal', 'Soal', 'required');
		$this->form_validation->set_rules('jenis_soal', 'Jenis Soal', 'required');
		
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit_soal/".$primaryKey."?id_m_soal=".$this->input->get('id_m_soal'));
		}
		else{				
			
		
			if($_FILES['file_soal']['name']){
				
				$config['upload_path']          = './upload/soal/';
				$config['allowed_types']        = 'mp3|mp4';
				$config['max_size'] 			= '10000';


				$this->load->library('upload', $config);

				if ( !$this->upload->do_upload('file_soal')){		
					$this->session->set_flashdata($this->input->post());	
					
					$this->notice->warning($this->upload->display_errors());					
					redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit_soal/".$primaryKey."?id_m_soal=".$this->input->get('id_m_soal'));
				}
				else{
					$fileUpload = $this->upload->data();
				
					$final_file_name = time()."_".$fileUpload['raw_name'].''.$fileUpload['file_ext'];
					rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
									
					
					$data['file_soal'] 		= $final_file_name;
					$typeFile = str_replace(".", "", $fileUpload['file_ext']);
					$data['type_file_soal'] = $typeFile;
				}


			}
			
			if($this->input->post('tanpa_file') == 'Y'){
				$data['file_soal'] 		= '';
				$data['type_file_soal'] = '';
			}
		
			$data['soal'] 				= $this->input->post('soal');
			$data['kategori_soal'] 		= $this->input->post('kategori_soal');
		
			$returnUpdate = $this->m_soal_model->update($this->input->get('id_m_soal'),$data);
			
			$returnUpdate = true;
			if($returnUpdate){
				if($this->input->post('jenis_soal') == 'G'){
					foreach($this->input->post('jawaban') as $idJawaban  =>  $jawaban){
						if($jawaban[$idJawaban]){
							
							if($this->input->post('status') == $idJawaban ){
								$status	=	'B';				
							}
							else{
								$status	=	'S';
							}
							
							$dataJawaban['jawaban'] 	= 	$jawaban[$idJawaban];					
							$dataJawaban['status'] 		= 	$status;					
							$idJawab = $this->m_jawaban_model->update(array('id_m_jawaban' => $idJawaban),$dataJawaban);
							
							//echo $this->db->last_query();
						}
					}
				}
					
				$this->notice->success("Proses Ubah Data Soal berhasil");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/soal?id_m_paket_soal=".$primaryKey);
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Ubah Data Soal Gagal, silahkan cek inputan Anda.");				
			
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit_soal/".$primaryKey."?id_m_soal=".$this->input->get('id_m_soal'));
			}
		}
	}
	
	public function aktif_soal($id_paket_soal,$id_m_soal,$status){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		if(!$id_paket_soal || !$id_m_soal || !$status){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		
		$dataUpdateSoal['status_soal'] 	= $status;
		$this->m_soal_model->update($id_m_soal,$dataUpdateSoal);
	
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/soal/?id_m_paket_soal=".$id_paket_soal);
	}
	
	
	public function delete_soal($id_paket_soal, $primaryKey = null){
		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_delete($this->uri->segment(2));
		//extit();
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		if(!$id_paket_soal){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		
		$data['id_user_delete'] 	= $this->session->userdata('id_user');
		$data['tgl_delete'] 		= date('Y-m-d H:i:s');	
		$returnUpdate 				= $this->m_soal_model->update($primaryKey,$data);
	
		if($returnUpdate){
			$this->notice->success("Proses Penghapusan Data Soal berhasil.");			
		}
		else{
			$this->notice->warning("Proses Penghapusan Data Soal Gagal, silahkan ulangi lagi.");	
		}				
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/soal?id_m_paket_soal=".$id_paket_soal);
	}
	public function export(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
	
		if(!$this->input->get('id_m_paket_soal')){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		
		$dataPaket 	= $this->m_paket_soal_model->getData( $this->input->get('id_m_paket_soal'));
		$dataSoal 	= $this->m_soal_model->showData(array('m_soal.id_m_paket_soal' => $this->input->get('id_m_paket_soal')));
		
		if(!$dataPaket){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		else{
			
			$result = array();
			$i = 0;
			foreach($dataSoal as $row){

				$result[] = array(
					'id_m_soal' 		=> $row->id_m_soal ,
					'soal' 				=> $row->soal,
					'jenis_soal' 		=> $row->jenis_soal,
					'jml_jawaban' 		=> $row->jml_jawaban,
					'type_file_soal' 	=> $row->type_file_soal,
					'file_soal' 		=> $row->file_soal,
					'status_soal' 		=> $row->status_soal,
					'kategori_soal' 	=> $row->kategori_soal,
					'data_jawaban' => array()
				);
				
				$dataJawaban = $this->m_jawaban_model->showData(array('m_jawaban.id_m_soal' => $row->id_m_soal));
				
				foreach($dataJawaban as $rowJawaban){
				
					$result[$i]['data_jawaban'][] = array(
						'id_m_jawaban' 		=> $rowJawaban->id_m_jawaban,
						'jawaban' 			=> $rowJawaban->jawaban,
						'id_m_soal' 		=> $rowJawaban->id_m_soal,
						'status' 			=> $rowJawaban->status
					);
					
					$result = array_values($result); 
				}

			$i++;
			}
			$formattedData = json_encode($result);
			

			//echo $formattedData;exit();

			$name = str_replace(' ','_',$dataPaket->nm_paket_soal);
			$nameMapel = str_replace(' ','_',$dataPaket->nm_mata_pelajaran);

			$filename = $nameMapel."-".$name.'.json';

			$this->load->helper('download');
			force_download($filename, $formattedData);
		}
	}
	
	public function import(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$this->input->get('id_m_paket_soal')){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		
		$this->dataPaket 	= $this->m_paket_soal_model->getData( $this->input->get('id_m_paket_soal'));		
		if(!$this->dataPaket){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		if(isset($_FILES['file_json']['name'])){
					
			
			$config['upload_path']          = './upload/import_soal/';
			$config['allowed_types']        = '*';
			$config['max_size'] 			= '10000';


			$this->load->library('upload', $config);

			//var_dump($fileUpload['file_ext']);exit();
			
			if ( !$this->upload->do_upload('file_json')){		
				$this->session->set_flashdata($this->input->post());	
				
				$this->notice->warning($this->upload->display_errors());					
				
				redirect($this->template_view->base_url_admin()."/bank_soal/import?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));
				
				exit();
			}
			else{
				$fileUpload = $this->upload->data();
			
				$final_file_name = time()."_".$fileUpload['raw_name'].''.$fileUpload['file_ext'];
				rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
								
			}
			
			$json_url 		= base_url()."upload/import_soal/".$final_file_name;
			$json 			= file_get_contents($json_url);
			$dataJson 		= json_decode($json, TRUE);		
		
			$insertSukses = 0;
			$insertGagal = 0;			
			
			if (is_array($dataJson) || is_object($dataJson)){
				foreach($dataJson as $dataSoalInsert){
					
					if(isset($dataSoalInsert)){
						$data['id_m_paket_soal'] 				= $this->input->get('id_m_paket_soal');
						$data['soal'] 					= $dataSoalInsert['soal'];
						$data['jenis_soal'] 			= $dataSoalInsert['jenis_soal'];
						$data['jml_jawaban'] 			= $dataSoalInsert['jml_jawaban'];
						$data['kategori_soal'] 			= $dataSoalInsert['kategori_soal'];
						$data['file_soal'] 				= $dataSoalInsert['file_soal'];
						$data['type_file_soal'] 		= $dataSoalInsert['type_file_soal'];
						$data['status_soal'] 			= $dataSoalInsert['status_soal'];
					
						$idSoal = $this->m_soal_model->insert($data);
					
						foreach($dataSoalInsert['data_jawaban'] as $dataJawabanInsert){
							
							$dataJawaban['id_m_soal'] 	= 	$idSoal;
							$dataJawaban['jawaban'] 	= 	$dataJawabanInsert['jawaban'];
							$dataJawaban['status'] 		= 	$dataJawabanInsert['status'];				
							$idjawaban  = $this->m_jawaban_model->insert($dataJawaban);
							
						}
					}
				}				
				$this->notice->success("Proses Import Data Soal Berhasil.");

				redirect($this->template_view->base_url_admin()."/bank_soal/soal?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));				
			}
			else{
				$this->notice->warning("Proses Import Data Soal Gagal. Pastikan File adalah format .json dan Maksimal adalah 10 Mb");
				
				redirect($this->template_view->base_url_admin()."/bank_soal/import?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));
			}
			
		}
		
		$this->template_view->load_admin_view('master/paket_soal/import_view');
	}
	
		
}

	
	
	
