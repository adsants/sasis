<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siswa extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->load->library('encrypt_decrypt');
		$this->session_lib->admin();
		
		$this->load->model('m_ujian_model');
	} 

	public function index(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		$like 		= null;
		$urlSearch 	= null;
		$order_by	=	"nm_ujian";

		if($this->input->get('search')){
			$urlSearch 	= 	"?search=".$_GET['search'];
			$like		=	$this->input->get('search');			
		}

		$config['base_url'] 	= base_url().'backoffice/'.$this->uri->segment(2).'/index'.$urlSearch;
		
		$this->jumlahData 		= $this->m_ujian_model->showData("",$like);
		$config['total_rows'] 	= count($this->jumlahData);
		$config['per_page'] 	= 10;
		
		$this->showData 		= $this->m_ujian_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);		
		
		$this->template_view->load_admin_view('master/siswa/siswa_view');
	}

	
	public function detail($idUjian){		
		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);
		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		$this->load->model('m_siswa_paket_ujian_model');
		
		$this->showData 	= $this->m_siswa_paket_ujian_model->showData(array('m_siswa_paket_ujian.id_m_ujian' => $idUjian),'','kelas,nipd,nama');
		
		$this->template_view->load_admin_view('master/siswa/siswa_detail_view');
	}
	
	public function insert_siswa($idUjian){		
		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);
		
		if(!$this->dataUjian){
			$status = array('status' => false, 'pesan' => 'Proses penambahan Data Siswa Gagal, silahkan reload Halaman ini (Tekan f5)');
		}	
			

		$this->load->model('m_siswa_paket_ujian_model');
		
		$cekSiswa = $this->m_siswa_paket_ujian_model->getData(array('m_siswa_paket_ujian.nipd' => $this->input->post('nipd') , 'm_siswa_paket_ujian.id_m_ujian' => $idUjian));
		
		if($cekSiswa){
			$status = array('status' => false, 'pesan' => 'Proses penambahan Data Siswa Gagal, dikarenakan Data Siswa dengan NIPD : '.$this->input->post('nipd').' telah terdaftar dengan Nama : '.$cekSiswa->nama);
		}
		else{
			
			$this->load->model('m_ujian_mapel_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			$this->load->model('t_paket_soal_ujian_model');
			$this->load->model('soal_siswa_model');
			$this->load->model('m_soal_model');
			
			$this->db->trans_start();
					
			
			$data['nama'] 			= $this->input->post('nama');
			$data['kelas'] 			= $this->input->post('kelas');
			$data['nipd'] 			= $this->input->post('nipd');
			$data['id_m_ujian'] 	= $idUjian;
			$data['password'] 		= $this->encrypt_decrypt->generateRandomString('4');
			
			$newid = $this->m_siswa_paket_ujian_model->insert($data);
			
			$this->dataUjianMapel = $this->m_ujian_mapel_model->showData(array('m_ujian_mapel.id_m_ujian' => $idUjian));
			
			foreach($this->dataUjianMapel as $dataUjianMapel){
				$dataSiswaPaketUjian['menit_pengerjaan'] 			= $dataUjianMapel->menit_pengerjaan;
				$dataSiswaPaketUjian['id_m_siswa_paket_ujian'] 		= $newid;
				$dataSiswaPaketUjian['id_m_ujian_mapel'] 			= $dataUjianMapel->id_m_ujian_mapel;
				
				$newIdSiswaPaketUjian = $this->detail_siswa_paket_ujian_model->insert($dataSiswaPaketUjian);
				
				$dataPaketSoalForSiswa = $this->t_paket_soal_ujian_model->showData(array('id_m_ujian_mapel' => $dataUjianMapel->id_m_ujian_mapel),'','id_t_paket_soal_ujian asc');
							
				foreach($dataPaketSoalForSiswa as $insertDataPaketSoalForSiswa){
					if($insertDataPaketSoalForSiswa->jumlah_soal_ganda > 0){
						if($insertDataPaketSoalForSiswa->acak_soal_ganda == 'Y'){
							
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda , 'Y','G');
						}
						else{
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda ,'','G');
						}
						
						foreach($dataSoalForSoalSiswa as $soalInsert){
							$dataSoalGanda['id_m_soal'] 					= $soalInsert->id_m_soal;
							$dataSoalGanda['status_jawaban'] 				= '';
							$dataSoalGanda['id_detail_siswa_paket_ujian'] 	= $newIdSiswaPaketUjian;
						
							$this->soal_siswa_model->insert($dataSoalGanda);
						}
					}
					
					if($insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang > 0){
						if($insertDataPaketSoalForSiswa->acak_soal_ganda_sedang == 'Y'){
							
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang , 'Y','G');
						}
						else{
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang ,'','G');
						}
						
						foreach($dataSoalForSoalSiswa as $soalInsert){
							$dataSoalGanda['id_m_soal'] 					= $soalInsert->id_m_soal;
							$dataSoalGanda['status_jawaban'] 				= '';
							$dataSoalGanda['id_detail_siswa_paket_ujian'] 	= $newIdSiswaPaketUjian;
						
							$this->soal_siswa_model->insert($dataSoalGanda);
						}
					}
					
					if($insertDataPaketSoalForSiswa->jumlah_soal_ganda_sulit > 0){
						if($insertDataPaketSoalForSiswa->jumlah_soal_ganda_sulit == 'Y'){
							
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang , 'Y','G');
						}
						else{
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang ,'','G');
						}
						
						foreach($dataSoalForSoalSiswa as $soalInsert){
							$dataSoalGanda['id_m_soal'] 					= $soalInsert->id_m_soal;
							$dataSoalGanda['status_jawaban'] 				= '';
							$dataSoalGanda['id_detail_siswa_paket_ujian'] 	= $newIdSiswaPaketUjian;
						
							$this->soal_siswa_model->insert($dataSoalGanda);
						}
					}
					
					
				}
				
				foreach($dataPaketSoalForSiswa as $insertDataPaketSoalForSiswa){
					if($insertDataPaketSoalForSiswa->jumlah_soal_esay > 0){
						if($insertDataPaketSoalForSiswa->acak_soal_esay == 'Y'){							
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay , 'Y' ,'E');
						}
						else{
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay ,'','E');
						}
						foreach($dataSoalForSoalSiswa as $soalInsert){
							$dataSoalEsay['id_m_soal'] 						= $soalInsert->id_m_soal;
							$dataSoalEsay['status_jawaban'] 				= '';
							$dataSoalEsay['id_detail_siswa_paket_ujian'] 	= $newIdSiswaPaketUjian;
						
							$this->soal_siswa_model->insert($dataSoalEsay);
						}
					}
					
					if($insertDataPaketSoalForSiswa->jumlah_soal_esay_sedang > 0){
						if($insertDataPaketSoalForSiswa->acak_soal_esay_sedang == 'Y'){							
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sedang , 'Y' ,'E');
						}
						else{
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sedang ,'','E');
						}
						foreach($dataSoalForSoalSiswa as $soalInsert){
							$dataSoalEsay['id_m_soal'] 						= $soalInsert->id_m_soal;
							$dataSoalEsay['status_jawaban'] 				= '';
							$dataSoalEsay['id_detail_siswa_paket_ujian'] 	= $newIdSiswaPaketUjian;
						
							$this->soal_siswa_model->insert($dataSoalEsay);
						}
					}
					
					if($insertDataPaketSoalForSiswa->jumlah_soal_esay_sulit > 0){
						if($insertDataPaketSoalForSiswa->acak_soal_esay_sulit == 'Y'){							
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sulit , 'Y' ,'E');
						}
						else{
							$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sulit ,'','E');
						}
						foreach($dataSoalForSoalSiswa as $soalInsert){
							$dataSoalEsay['id_m_soal'] 						= $soalInsert->id_m_soal;
							$dataSoalEsay['status_jawaban'] 				= '';
							$dataSoalEsay['id_detail_siswa_paket_ujian'] 	= $newIdSiswaPaketUjian;
						
							$this->soal_siswa_model->insert($dataSoalEsay);
						}
					}
				}
				
			}
			
			
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$status = array('status' => FALSE, 'pesan' => 'Failed to save data, check your input ..');
			}
			else {
				$this->db->trans_commit();

				$status = array('status' => true );
			}	
			
		}
		
		
		echo(json_encode($status));
	}
	
	
	public function reset($id_m_siswa_paket_ujian){
		if(!$id_m_siswa_paket_ujian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
			$this->load->model('m_siswa_paket_ujian_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			$this->load->model('soal_siswa_model');
			$this->load->model('m_ujian_mapel_model');
		
		$this->dataSiswa	= $this->m_siswa_paket_ujian_model->getData(array('id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian));
		
		if(!$this->dataSiswa){
			$this->notice->warning("Proses Gagal, silahkan reload Halaman ini.");				
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add/?id_m_mata_pelajaran=".$this->input->post('id_m_mata_pelajaran'));
		}	
		
		
		$this->db->trans_start();
			
		$this->dataLoopSiswa	= $this->detail_siswa_paket_ujian_model->showData(array('id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian));
		foreach($this->dataLoopSiswa as $dataSiswa){
			
			$this->dataMapel	= $this->m_ujian_mapel_model->getData(array('id_m_ujian_mapel' => $dataSiswa->id_m_ujian_mapel));
			
			
			$dataNilai['tgl_mulai_pengerjaan'] = null;
			$dataNilai['tgl_akhir_pengerjaan'] = null;
			$dataNilai['tgl_koreksi'] = null;
			$dataNilai['id_user_koreksi'] = null;
			$dataNilai['nilai'] = null;
			$dataNilai['menit_pengerjaan'] = $this->dataMapel->menit_pengerjaan;
			
			$this->detail_siswa_paket_ujian_model->update(array('id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian),$dataNilai);
			
			//echo $this->db->last_query();exit();
			$dataJawaban['status_jawaban'] = null;
			$dataJawaban['ragu_ragu'] = 'N'; 
			$dataJawaban['nilai_jawaban'] = null; 
			$dataJawaban['time_stamp'] = null; 
			$dataJawaban['jawaban_esay'] = null; 
			$dataJawaban['id_m_jawaban'] = null; 
			
			$this->soal_siswa_model->update(array('id_detail_siswa_paket_ujian' => $dataSiswa->id_detail_siswa_paket_ujian),$dataJawaban);
			
		}
		
		
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->notice->warning("Proses Gagal, Silahkan Reload Halaman ini");		
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/detail/".$this->dataSiswa->id_m_ujian);
		}
		else{				
			$this->notice->success("Proses Reset Jawaban Siswa berhasil.");						
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/detail/".$this->dataSiswa->id_m_ujian);
		}	
	}
	
	
	public function add($id_ujian){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		if(!$id_ujian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		$this->load->model('m_ujian_model');
		$this->load->model('m_siswa_paket_ujian_model');
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('t_paket_soal_ujian_model');
		$this->load->model('m_soal_model');
		$this->load->model('soal_siswa_model');
		
		$this->dataUjian	= $this->m_ujian_model->getData($id_ujian);
		//var_dump($this->input->post());
		//
		if(isset($_FILES['data_siswa']['name'])){
			$config['upload_path']          = './upload/siswa/';
			
			$config['allowed_types'] 	= 'xls';
			$config['max_size'] 		= 2000;

			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('data_siswa')){		
				$this->session->set_flashdata($this->input->post());	
				
				$this->notice->warning($this->upload->display_errors());								
			}
			else{
				$fileUpload = $this->upload->data();					
			
				$final_file_name = time()."_".$fileUpload['raw_name'].''.$fileUpload['file_ext'];
				rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
				
				
				$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
				
				$inputFileName 	= $config['upload_path'].''.$final_file_name;				
			 
				try {
					$inputFileType = IOFactory::identify($inputFileName);
					$objReader = IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
				} 
				catch(Exception $e) {
					die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
				}

				$sheet = $objPHPExcel->getSheet(0);
				$highestRow = $sheet->getHighestRow();
				$highestColumn = $sheet->getHighestColumn();
				 
				$gagal 			= 0; 
				$hasil 			= 0; 
				$siswaSudahAda 	= ""; 
				
				for ($row = 2; $row <= $highestRow; $row++){                           
					$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
													NULL,
													TRUE,
													FALSE);
													 
							
					$cekSiswa	=	$this->m_siswa_paket_ujian_model->getData(array('nipd' => $rowData[0][1], 'id_m_ujian' => $id_ujian));
				
					if($cekSiswa){
						$siswaSudahAda .= "<br> <b>Nama Siswa : ". $rowData[0][2]." , NIPD : " .$rowData[0][1]." Sudah Terdaftar.</b>";
					}
					else{
						
						if($rowData[0][1]!=''){		
						$dataSiswa['nama'] 			= $rowData[0][2];
						$dataSiswa['nipd'] 			= $rowData[0][1];
						$dataSiswa['kelas'] 		= $rowData[0][3];
						
						$dataSiswa['password'] 		= $this->encrypt_decrypt->generateRandomString('4');
						$dataSiswa['status'] 		= "A";
						$dataSiswa['id_m_ujian'] 	= $id_ujian;
						
						$insertSiswa = $this->m_siswa_paket_ujian_model->insert($dataSiswa);							
						
						if($insertSiswa){
							
							
							$dataUjian = $this->m_ujian_mapel_model->showData(array('m_ujian_mapel.id_m_ujian' => $id_ujian)); 
							
							foreach($dataUjian as $dataUjians){
								
								$dataDetailSiswa['nilai'] 					= null;
								$dataDetailSiswa['menit_pengerjaan'] 		= $dataUjians->menit_pengerjaan;
								$dataDetailSiswa['id_m_siswa_paket_ujian'] 	= $insertSiswa;
								$dataDetailSiswa['id_m_ujian_mapel'] 		= $dataUjians->id_m_ujian_mapel;
							
								$newIdDetailSiswa = $this->detail_siswa_paket_ujian_model->insert($dataDetailSiswa);
							
								$dataPaketSoalForSiswa = $this->t_paket_soal_ujian_model->showData(array('id_m_ujian_mapel' => $dataUjians->id_m_ujian_mapel),'','id_t_paket_soal_ujian asc');
								
								foreach($dataPaketSoalForSiswa as $insertDataPaketSoalForSiswa){
									if($insertDataPaketSoalForSiswa->jumlah_soal_ganda > 0){
										if($insertDataPaketSoalForSiswa->acak_soal_ganda == 'Y'){
											
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda , 'Y','G');
										}
										else{
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda ,null,'G');
										}
										
										//echo $this->db->last_query();exit();
										
										foreach($dataSoalForSoalSiswa as $soalInsert){
											$dataSoalGanda['id_m_soal'] 					= $soalInsert->id_m_soal;
											$dataSoalGanda['status_jawaban'] 				= '';
											$dataSoalGanda['id_detail_siswa_paket_ujian'] 	= $newIdDetailSiswa;
										
											$this->soal_siswa_model->insert($dataSoalGanda);
										}
									}
									
									if($insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang > 0){
										if($insertDataPaketSoalForSiswa->acak_soal_ganda_sedang == 'Y'){
											
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang , 'Y','G');
										}
										else{
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang ,null,'G');
										}
										
										foreach($dataSoalForSoalSiswa as $soalInsert){
											$dataSoalGanda['id_m_soal'] 					= $soalInsert->id_m_soal;
											$dataSoalGanda['status_jawaban'] 				= '';
											$dataSoalGanda['id_detail_siswa_paket_ujian'] 	= $newIdDetailSiswa;
										
											$this->soal_siswa_model->insert($dataSoalGanda);
										}
									}
									
									if($insertDataPaketSoalForSiswa->jumlah_soal_ganda_sulit > 0){
										if($insertDataPaketSoalForSiswa->jumlah_soal_ganda_sulit == 'Y'){
											
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang , 'Y','G');
										}
										else{
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sedang ,null,'G');
										}
										
										foreach($dataSoalForSoalSiswa as $soalInsert){
											$dataSoalGanda['id_m_soal'] 					= $soalInsert->id_m_soal;
											$dataSoalGanda['status_jawaban'] 				= '';
											$dataSoalGanda['id_detail_siswa_paket_ujian'] 	= $newIdDetailSiswa;
										
											$this->soal_siswa_model->insert($dataSoalGanda);
										}
									}
									
									
								}
								
								foreach($dataPaketSoalForSiswa as $insertDataPaketSoalForSiswa){
									if($insertDataPaketSoalForSiswa->jumlah_soal_esay > 0){
										if($insertDataPaketSoalForSiswa->acak_soal_esay == 'Y'){							
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay , 'Y' ,'E');
										}
										else{
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'MD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay ,'','E');
										}
										foreach($dataSoalForSoalSiswa as $soalInsert){
											$dataSoalEsay['id_m_soal'] 						= $soalInsert->id_m_soal;
											$dataSoalEsay['status_jawaban'] 				= '';
											$dataSoalEsay['id_detail_siswa_paket_ujian'] 	= $newIdDetailSiswa;
										
											$this->soal_siswa_model->insert($dataSoalEsay);
										}
									}
									
									if($insertDataPaketSoalForSiswa->jumlah_soal_esay_sedang > 0){
										if($insertDataPaketSoalForSiswa->acak_soal_esay_sedang == 'Y'){							
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sedang , 'Y' ,'E');
										}
										else{
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SD'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sedang ,'','E');
										}
										foreach($dataSoalForSoalSiswa as $soalInsert){
											$dataSoalEsay['id_m_soal'] 						= $soalInsert->id_m_soal;
											$dataSoalEsay['status_jawaban'] 				= '';
											$dataSoalEsay['id_detail_siswa_paket_ujian'] 	= $newIdDetailSiswa;
										
											$this->soal_siswa_model->insert($dataSoalEsay);
										}
									}
									
									if($insertDataPaketSoalForSiswa->jumlah_soal_esay_sulit > 0){
										if($insertDataPaketSoalForSiswa->acak_soal_esay_sulit == 'Y'){							
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sulit , 'Y' ,'E');
										}
										else{
											$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_esay_sulit ,'','E');
										}
										foreach($dataSoalForSoalSiswa as $soalInsert){
											$dataSoalEsay['id_m_soal'] 						= $soalInsert->id_m_soal;
											$dataSoalEsay['status_jawaban'] 				= '';
											$dataSoalEsay['id_detail_siswa_paket_ujian'] 	= $newIdDetailSiswa;
										
											$this->soal_siswa_model->insert($dataSoalEsay);
										}
									}
								}
							
							}
						
							$hasil += 1;
						}
						else{
							$gagal += 1;
						}
						}
					}
				
				}
				
				$this->notice->success("
					Proses Import Data Siswa berhasil. Hasil Import adalah sebagai berikut : <br>
					Jumlah Siswa Berhasil diimport : ".$hasil."<br>
					Jumlah Siswa Gagal diimport : ".$gagal."<br>
					Siswa yang tidak diimport karena NIPD sudah Ada : ".$siswaSudahAda."
				");	
			}
			
			
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add/".$id_ujian);
		}
		
		
		$this->template_view->load_admin_view('master/siswa/siswa_add_view');
	}
	
	
	public function get_reset_device($id_m_ujian,$id_m_siswa_paket_ujian){
		if(!$id_m_ujian){			
			echo "silahkan Reload Halaman ini";
		}				
		
			$this->load->model('m_siswa_paket_ujian_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			$this->load->model('soal_siswa_model');
			$this->load->model('m_ujian_mapel_model');
		
		$this->dataSiswa	= $this->m_siswa_paket_ujian_model->getData(array('id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian));
		
		if(!$this->dataSiswa){				
			echo "silahkan Reload Halaman ini";
		}	
		
		$this->dataHtml	= $this->detail_siswa_paket_ujian_model->showDataForResetDevice(array('id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian, 'mac_address is not null' => null,  ));
		
		if(!$this->dataHtml){
			echo "<center>Tidak ada Data yang dapat di reset Device.</center>";
		}
		else{
			echo "<table width='100%' border='0' class='table table-striped table-bordered table-hover'>";
			foreach($this->dataHtml as $html){
				
				echo "<tr><td width='70%'>".$html->nm_mata_pelajaran."</td><td align='right'>
				<a href='".$this->template_view->base_url_admin()."/siswa/reset_device/".$id_m_ujian."/".$html->id_detail_siswa_paket_ujian."'><span class='btn btn-warning'>Reset</span></a></td></tr>";
			}
			echo "</table>";
		}
	}
	
	public function get_reset_jawaban($id_m_ujian,$id_m_siswa_paket_ujian){
		if(!$id_m_ujian){			
			echo "silahkan Reload Halaman ini";
		}				
		
			$this->load->model('m_siswa_paket_ujian_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			$this->load->model('soal_siswa_model');
			$this->load->model('m_ujian_mapel_model');
		
		$this->dataSiswa	= $this->m_siswa_paket_ujian_model->getData(array('id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian));
		
		if(!$this->dataSiswa){				
			echo "silahkan Reload Halaman ini";
		}	
		
		$this->dataHtml	= $this->detail_siswa_paket_ujian_model->showDataForResetDevice(array('id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian, 'tgl_mulai_pengerjaan is not null' => null,  ));
		
		if(!$this->dataHtml){
			echo "<center>Tidak ada Data yang dapat di reset Jawaban.</center>";
		}
		else{
			echo "<table width='100%' border='0' class='table table-striped table-bordered table-hover'>";
			foreach($this->dataHtml as $html){
				
				echo "<tr><td width='70%'>".$html->nm_mata_pelajaran."</td><td align='right'>
				<a href='".$this->template_view->base_url_admin()."/siswa/reset_jawaban/".$id_m_ujian."/".$html->id_detail_siswa_paket_ujian."'><span class='btn btn-warning'>Reset</span></a></td></tr>";
			}
			echo "</table>";
		}
	}
	
	public function reset_device($id_m_ujian,$id_detail_siswa_paket_ujian){
		if(!$id_m_ujian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
			$this->load->model('m_siswa_paket_ujian_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			$this->load->model('soal_siswa_model');
			$this->load->model('m_ujian_mapel_model');
		
		$this->dataSiswa	= $this->detail_siswa_paket_ujian_model->getData(array('id_detail_siswa_paket_ujian' => $id_detail_siswa_paket_ujian));
		
		if(!$this->dataSiswa){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->db->query("update detail_siswa_paket_ujian set mac_address = null where id_detail_siswa_paket_ujian = '".$id_detail_siswa_paket_ujian."'");
		
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/detail/".$id_m_ujian);
		
	}
	
	
	public function reset_jawaban($id_m_ujian,$id_detail_siswa_paket_ujian){
		if(!$id_m_ujian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
			$this->load->model('m_siswa_paket_ujian_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			$this->load->model('soal_siswa_model');
			$this->load->model('m_ujian_mapel_model');
		
		$this->dataSiswa	= $this->detail_siswa_paket_ujian_model->getData(array('id_detail_siswa_paket_ujian' => $id_detail_siswa_paket_ujian));
		
		if(!$this->dataSiswa){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->dataUjianMapel	= $this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' => $this->dataSiswa->id_m_ujian_mapel));
		
		$this->db->query("update detail_siswa_paket_ujian set mac_address = null,tgl_akhir_pengerjaan = null, tgl_mulai_pengerjaan = null, nilai = null, tgl_koreksi = null, id_user_koreksi = null, menit_pengerjaan = '".$this->dataUjianMapel->menit_pengerjaan."' where id_detail_siswa_paket_ujian = '".$id_detail_siswa_paket_ujian."'");
		
		
		$this->db->query("update soal_siswa set status_jawaban='', nilai_jawaban = null, ragu_ragu = 'N', time_stamp=null, jawaban_esay = null, id_m_jawaban = null where id_detail_siswa_paket_ujian = '".$id_detail_siswa_paket_ujian."'");
		
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/detail/".$id_m_ujian);
		
	}
	
	public function hapus_siswa(){
		
		$this->load->model('detail_siswa_paket_ujian_model');
		
		
		foreach($this->input->post('id_m_siswa_paket_ujian') as $hapus){
			
			$this->dataSiswa	= $this->detail_siswa_paket_ujian_model->showData(array('detail_siswa_paket_ujian.id_m_siswa_paket_ujian' => $hapus));
			
			foreach($this->dataSiswa as $dataSiswa){
				
				//var_dump($dataSiswa);
				
				$this->db->query("delete from detail_siswa_paket_ujian where id_detail_siswa_paket_ujian = '".$dataSiswa->id_detail_siswa_paket_ujian."'");
		
				$this->db->query("delete from soal_siswa where id_detail_siswa_paket_ujian = '".$dataSiswa->id_detail_siswa_paket_ujian."'");				
				
			}
			$this->db->query("delete from m_siswa_paket_ujian where id_m_siswa_paket_ujian = '".$hapus."'");
			
			$this->notice->success("Proses Hapus data Siswa berhasil.");
			
			
		
			
		}
		
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/detail/".$this->input->post('id_m_ujian'));
		
	}
}
	
	
	
