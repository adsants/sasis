<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ujian extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->load->library('encrypt_decrypt');
		$this->session_lib->admin();
		
		$this->load->model('m_ujian_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('m_ujian_mapel_model');
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
		
		$this->template_view->load_admin_view('master/ujian/ujian_view');
	}
	public function add(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
	
		$this->template_view->load_admin_view('master/ujian/ujian_add_view');
	}
	
	
	public function insert(){		
	
		
		$this->load->model('m_siswa_paket_ujian_model');
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		$this->form_validation->set_rules('nm_ujian', 'Ujian', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
		}
		else{							
		//var_dump($_FILES['data_siswa']['name']);exit();
		
			$data['nm_ujian'] 			= $this->input->post('nm_ujian');
		
			$newid = $this->m_ujian_model->insert($data);
		
			if($_FILES['data_siswa']['name']){
				$config['upload_path']          = './upload/siswa/';
				
				$config['allowed_types'] 	= 'xls';
				$config['max_size'] 		= 2000;

				$this->load->library('upload', $config);

				if ( !$this->upload->do_upload('data_siswa')){		
					$this->session->set_flashdata($this->input->post());	
					
					$this->notice->warning($this->upload->display_errors());								
					redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
				}
				else{
					$fileUpload = $this->upload->data();					
				
					$final_file_name = time()."_".$fileUpload['raw_name'].''.$fileUpload['file_ext'];
					rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
					
					if($newid){
						
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
															 
									
							$cekSiswa	=	$this->m_siswa_paket_ujian_model->getData(array('nipd' => $rowData[0][1], 'id_m_ujian' => $newid));
						
							if($cekSiswa){
								$siswaSudahAda .= "<br> <b>Nama Siswa : ". $rowData[0][2]." , NIPD : " .$rowData[0][1]." Sudah Terdaftar.</b>";
							}
							else{
								
								if($rowData[0][1]){
									$dataSiswa['nama'] 			= $rowData[0][2];
									$dataSiswa['nipd'] 			= $rowData[0][1];
									$dataSiswa['kelas'] 		= $rowData[0][3];
									
									$dataSiswa['password'] 		= $this->encrypt_decrypt->generateRandomString('4');
									$dataSiswa['status'] 		= "A";
									$dataSiswa['id_m_ujian'] 	= $newid;
									
									$insertSiswa = $this->m_siswa_paket_ujian_model->insert($dataSiswa);							
									
									if($insertSiswa){						
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
						
						redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
					}
					else{				
						$this->session->set_flashdata($this->input->post());
						$this->notice->warning("Proses Tambah Data Ujian Gagal, silahkan cek inputan Anda.");				
						redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
					}		
				}
			}
			else{
				$this->notice->success("
					Proses Tambah data Ujian berhasil.");				
				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			
			}
			
				
		}
	}
	
	
	public function edit($primaryKey = null){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		$this->dataForUpdate	=	$this->m_ujian_model->getData($primaryKey);
		
		if(!$this->dataForUpdate){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->template_view->load_admin_view('master/ujian/ujian_edit_view');
	}
	public function update($primaryKey = null){	
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
		
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
			
			
		$this->form_validation->set_rules('nm_ujian', 'Ujian', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
		}
		else{							
		
			$data['nm_ujian'] 			= $this->input->post('nm_ujian');
		
			$returnUpdate = $this->m_ujian_model->update($primaryKey,$data);
			
			if($returnUpdate){
				$this->notice->success("Proses Ubah Data Ujian berhasil.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Ubah Data Ujian Gagal, silahkan cek inputan Anda.");				
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
		$returnUpdate 				= $this->m_ujian_model->update($primaryKey,$data);
		
		if($returnUpdate){
			$this->notice->success("Proses Penghapusan Data Ujian berhasil.");			
		}
		else{
			$this->notice->warning("Proses Penghapusan Data Ujian Gagal, silahkan ulangi lagi.");	
		}				
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
	}
	
	public function siswa($idUjian){		
		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);
		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		$this->load->model('m_siswa_paket_ujian_model');
		
		$this->showData 	= $this->m_siswa_paket_ujian_model->showData(array('m_siswa_paket_ujian.id_m_ujian' => $idUjian),'','kelas,nipd,nama');
		
		$this->template_view->load_admin_view('master/ujian/siswa_view');
	}
	
	public function insert_siswa($idUjian){		
		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);
		
		if(!$this->dataUjian){
			$status = array('status' => false, 'pesan' => 'Proses penambahan Data Siswa Gagal, silahkan reload Halaman ini (Tekan f5)');
		}	
		
		$this->hak_akses->cek_add($this->uri->segment(2));		

		$this->load->model('m_siswa_paket_ujian_model');
		
		$cekSiswa = $this->m_siswa_paket_ujian_model->getData(array('m_siswa_paket_ujian.nipd' => $this->input->post('nipd') ));
		if($cekSiswa){
			$status = array('status' => false, 'pesan' => 'Proses penambahan Data Siswa Gagal, dikarenakan Data Siswa dengan NIPD : '.$this->input->post('nipd').' telah terdaftar dengan Nama : '.$cekSiswa->nama);
		}
		else{
			$data['nama'] 			= $this->input->post('nama');
			$data['kelas'] 			= $this->input->post('kelas');
			$data['nisn'] 			= $this->input->post('nisn');
			$data['nipd'] 			= $this->input->post('nipd');
			$data['id_m_ujian'] 	= $idUjian;
			$data['password'] 		= $this->encrypt_decrypt->generateRandomString('4');
			
			$newid = $this->m_siswa_paket_ujian_model->insert($data);
			
			if($newid){
				$status = array('status' => true);
			}
			else{				
				$status = array('status' => false, 'pesan' => 'Proses penambahan Data Siswa Gagal, silahkan reload Halaman ini (Tekan f5)');
			}		
			
		}
		
		
		echo(json_encode($status));
	}
	
	
	public function mapel($idUjian){		
		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}						
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('m_mata_pelajaran_model');
		
		$this->showData 	= $this->m_ujian_mapel_model->showData(array('m_ujian_mapel.id_m_ujian' => $idUjian));
		
		
		$this->dataMapel 	= $this->m_mata_pelajaran_model->showData(array("m_mata_pelajaran.id_m_mata_pelajaran not in (select id_m_mata_pelajaran from  m_ujian_mapel where id_m_ujian = '". $idUjian."' and m_ujian_mapel.id_user_delete is null) " => null));
		
		$this->template_view->load_admin_view('master/ujian/mapel_view');
	}
	
	public function insert_mapel($idUjian){		
		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);
		
		if(!$this->dataUjian){
			$status = array('status' => false, 'pesan' => 'Proses penambahan Data Mata Pelajaran Gagal, silahkan reload Halaman ini (Tekan f5)');
		}	
		
		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_add($this->uri->segment(2));
		
		$this->form_validation->set_rules('id_m_mata_pelajaran', 'Mata Pelajaran', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
		}
		else{
			$this->session->set_flashdata($this->input->post());
		
		
			if($this->input->post('jenis_soal_ujian_ganda')== '' && $this->input->post('jenis_soal_ujian_uraian')==''){					
				
				$status = array('status' => false, 'pesan' => 'Proses Ubah Data Ujian Gagal, silahkan pilih Jenis Soal Ujian');
				
				exit();
			}
			
				
				$this->load->model('m_ujian_mapel_model');
			
				$data['id_m_mata_pelajaran'] 	= $this->input->post('id_m_mata_pelajaran');
				$data['id_m_ujian'] 			= $idUjian;
				$data['status_ujian'] 			= $this->input->post('status_ujian');
				$data['id_user'] 				= $this->session->userdata('id_user');
				
				if($this->input->post('jenis_soal_ujian_uraian')!= ''){					
					$data['jml_soal_esay'] 		= $this->input->post('jml_soal_uraian');
				}
				else{					
					$data['jml_soal_esay'] 		= "0";
				}
				
				if($this->input->post('jenis_soal_ujian_ganda')!= ''){					
					$data['jml_soal_ganda'] 		= $this->input->post('jml_soal_ganda');
				}
				else{					
					$data['jml_soal_ganda'] 		= "0";
				}
				
				if($this->input->post('jenis_soal_ujian_ganda')!= '' && $this->input->post('jenis_soal_ujian_uraian')!=''){				
					$data['jenis_soal_ujian'] 		= 'C';					
					$data['tampilkan_nilai'] 		= 'N';					
				}
				elseif($this->input->post('jenis_soal_ujian_ganda') != '' && $this->input->post('jenis_soal_ujian_uraian')==''){			
					$data['jenis_soal_ujian'] 		= 'G';
					$data['tampilkan_nilai'] 		= $this->input->post('tampilkan_nilai');					
				}
				elseif($this->input->post('jenis_soal_ujian_ganda') == '' && $this->input->post('jenis_soal_ujian_uraian')!=''){			
					$data['tampilkan_nilai'] 		= 'N';
				}
				
				
				//$data['jml_soal_ganda'] 		= $this->input->post('jml_soal_ganda');
				//$data['jml_soal_esay'] 			= $this->input->post('jml_soal_esay');
				
				
				
				$data['tampilkan_hasil_jawaban'] 		= $this->input->post('tampilkan_hasil_jawaban');
				//$data['keterangan_ujian'] 		= $this->input->post('keterangan_ujian');	
				
				$data['token_ujian'] 			= $this->encrypt_decrypt->generateRandomString(4);				
				
				//$data['jml_soal_ganda'] 		= $this->input->post('jml_soal_ganda');
				//$data['jml_soal_esay'] 			= $this->input->post('jml_soal_esay');
				
				$data['nilai_maksimal_ujian'] 	= $this->input->post('nilai_maksimal_ujian');
				$data['menit_pengerjaan'] 		= $this->input->post('menit_pengerjaan');			
				
				$date = DateTime::createFromFormat('d-m-Y', $this->input->post('tgl_pengerjaan'));
				$tglPengerjaan = $date->format('Y-m-d');
				
				$data['tgl_pengerjaan'] 		= $tglPengerjaan." ".$this->input->post('jam').":".$this->input->post('menit');
				
				$dateAkhir = DateTime::createFromFormat('d-m-Y', $this->input->post('tgl_akhir_pengerjaan'));
				$tglAkhirPengerjaan = $dateAkhir->format('Y-m-d');
				$data['tgl_akhir_pengerjaan'] 		= $tglAkhirPengerjaan." ".$this->input->post('jam_akhir').":".$this->input->post('menit_akhir');
				
				$newid = $this->m_ujian_mapel_model->insert($data);
				
				if($newid){
					$status = array('status' => true,'redirect_link' => $this->template_view->base_url_admin()."/".$this->uri->segment('2')."/detail_mapel/".$idUjian."/".$newid);
				}
				else{				
					$status = array('status' => false, 'pesan' => 'Proses penambahan Data Mata Pelajaran Gagal, silahkan reload Halaman ini (Tekan f5)');
				}	
		}
		
		echo(json_encode($status));
	}
	public function edit_mapel($id_m_ujian, $id_m_ujian_mapel){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$id_m_ujian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		$this->dataUjian	=	$this->m_ujian_model->getData($id_m_ujian);
		
		if(!$this->dataUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		if(!$id_m_ujian_mapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		$this->load->model('m_ujian_mapel_model');
		
		$this->dataUjianMapel	=	$this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' => $id_m_ujian_mapel));
		
		$this->load->model('m_mata_pelajaran_model');
		
		$this->dataMapel 	= $this->m_mata_pelajaran_model->showData('','','nm_mata_pelajaran');
		
		if(!$this->dataUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->template_view->load_admin_view('master/ujian/mapel_edit_view');
	}
	
	public function update_mapel($idUjian,$idUjianMapel){		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		
		if(!$idUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}				
		$this->load->model('m_ujian_mapel_model');
		
		$this->dataUjianMapel	=	$this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' => $idUjianMapel));
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);
		
		if(!$this->dataUjian){
			$status = array('status' => false, 'pesan' => 'Proses penambahan Data Mata Pelajaran Gagal, silahkan reload Halaman ini (Tekan f5)');
		}	
		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
		
		$this->form_validation->set_rules('id_m_mata_pelajaran', 'Mata Pelajaran', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
		}
		else{
			$this->session->set_flashdata($this->input->post());
		
		
			/**if($this->input->post('jenis_soal_ujian_ganda') == '' && $this->input->post('jenis_soal_ujian_uraian')==''){					
				
				$status = array('status' => false, 'pesan' => 'Proses Ubah Data Ujian Gagal, silahkan pilih Jenis Soal Ujian');
				
				exit();
			}**/
			
				
				$this->load->model('m_ujian_mapel_model');
			
				$data['id_m_mata_pelajaran'] 	= $this->input->post('id_m_mata_pelajaran');
				//$data['id_m_ujian'] 			= $idUjian;
				$data['status_ujian'] 			= $this->input->post('status_ujian');
				$data['id_user'] 				= $this->session->userdata('id_user');
				/**
				if($this->input->post('jenis_soal_ujian_uraian')!= ''){					
					$data['jml_soal_esay'] 		= $this->input->post('jml_soal_uraian');
				}
				else{					
					$data['jml_soal_esay'] 		= "0";
				}
				
				if($this->input->post('jenis_soal_ujian_ganda')!= ''){					
					$data['jml_soal_ganda'] 		= $this->input->post('jml_soal_ganda');
				}
				else{					
					$data['jml_soal_ganda'] 		= "0";
				}
				
				if($this->input->post('jenis_soal_ujian_ganda')!= '' && $this->input->post('jenis_soal_ujian_uraian')!=''){				
					$data['jenis_soal_ujian'] 		= 'C';					
					$data['tampilkan_nilai'] 		= 'N';					
				}
				elseif($this->input->post('jenis_soal_ujian_ganda') != '' && $this->input->post('jenis_soal_ujian_uraian')==''){			
					$data['jenis_soal_ujian'] 		= 'G';
					$data['tampilkan_nilai'] 		= $this->input->post('tampilkan_nilai');					
				}
				elseif($this->input->post('jenis_soal_ujian_ganda') == '' && $this->input->post('jenis_soal_ujian_uraian')!=''){			
					$data['tampilkan_nilai'] 		= 'N';
				}
				
				
				//$data['jml_soal_ganda'] 		= $this->input->post('jml_soal_ganda');
				//$data['jml_soal_esay'] 			= $this->input->post('jml_soal_esay');
				
				**/
				$data['tampilkan_nilai'] 			= $this->input->post('tampilkan_nilai');
				$data['tampilkan_hasil_jawaban'] 	= $this->input->post('tampilkan_hasil_jawaban');
				//$data['keterangan_ujian'] 		= $this->input->post('keterangan_ujian');	
				
				//$data['token_ujian'] 			= $this->encrypt_decrypt->generateRandomString(4);				
				
				//$data['jml_soal_ganda'] 		= $this->input->post('jml_soal_ganda');
				//$data['jml_soal_esay'] 			= $this->input->post('jml_soal_esay');
				
				//$data['nilai_maksimal_ujian'] 	= $this->input->post('nilai_maksimal_ujian');
				$data['menit_pengerjaan'] 		= $this->input->post('menit_pengerjaan');	

				
				
				
				$date 							= DateTime::createFromFormat('d-m-Y', $this->input->post('tgl_pengerjaan'));
				$tglPengerjaan 					= $date->format('Y-m-d');				
				$data['tgl_pengerjaan'] 		= $tglPengerjaan." ".$this->input->post('jam').":".$this->input->post('menit');
				
				$dateAkhir 						= DateTime::createFromFormat('d-m-Y', $this->input->post('tgl_akhir_pengerjaan'));
				$tglAkhirPengerjaan 			= $dateAkhir->format('Y-m-d');
				$data['tgl_akhir_pengerjaan'] 	= $tglAkhirPengerjaan." ".$this->input->post('jam_akhir').":".$this->input->post('menit_akhir');
				
				$newid = $this->m_ujian_mapel_model->update($idUjianMapel, $data);
				
				//echo $this->db->last_query();
				
				
				if($newid){
					
					$dataSiswaUjians	=	$this->detail_siswa_paket_ujian_model->showData(array( 'detail_siswa_paket_ujian.id_m_ujian_mapel' => $idUjianMapel, 'tgl_mulai_pengerjaan is null' => null));
					
					foreach($dataSiswaUjians as $dataSiswaUjian){
						$dataUbahMenit['menit_pengerjaan'] 	= $this->input->post('menit_pengerjaan');
						$this->detail_siswa_paket_ujian_model->update(array( 'id_detail_siswa_paket_ujian' => $dataSiswaUjian->id_detail_siswa_paket_ujian),$dataUbahMenit );
					}
						
					$this->notice->success("Proses Ubah Data Ujian Mata Pelajaran berhasil. <br> Catatan : Proses ini tidak mengubah Data Format Soal Ujian");	
					
					$status = array('status' => true,'redirect_link' => $this->template_view->base_url_admin()."/".$this->uri->segment('2')."/mapel/".$idUjian);
				}
				else{				
					$status = array('status' => false, 'pesan' => 'Proses perubahan Data Mata Pelajaran Gagal, silahkan reload Halaman ini (Tekan f5)');
				}	
		}
		
		echo(json_encode($status));
	}
	
	public function detail_mapel($idUjian,$idUjianMapel){		
		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		if(!$idUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('m_mata_pelajaran_model');
		$this->load->model('m_paket_soal_model');
		$this->load->model('t_paket_soal_ujian_model');
		$this->load->model('m_soal_model');
		
		$this->dataMapel 	= $this->m_ujian_mapel_model->getData(array( 'm_ujian_mapel.id_m_ujian_mapel'  => $idUjianMapel ));		
		if(!$this->dataMapel){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}			
		
		$this->dataPaketSoal 	= $this->m_paket_soal_model->showData(array('m_paket_soal.id_m_mata_pelajaran' => $this->dataMapel->id_m_mata_pelajaran));
		
		$this->htmlPaket = "";
		$no =1;
		foreach($this->dataPaketSoal  as $dataPaketSoal){
			
			$cekAda = $this->t_paket_soal_ujian_model->getData(array('t_paket_soal_ujian.id_m_paket_soal' => $dataPaketSoal->id_m_paket_soal , 't_paket_soal_ujian.id_m_ujian_mapel' => $idUjianMapel));
			//echo $this->db->last_query();
			$cekJumlahSoalGanda = $this->m_soal_model->showData(array('m_soal.id_m_paket_soal' => $dataPaketSoal->id_m_paket_soal , 'm_soal.jenis_soal' => 'G', 'm_soal.status_soal' => 'A', 'm_soal.kategori_soal' => 'MD'));
			
			$cekJumlahSoalGandaSedang = $this->m_soal_model->showData(array('m_soal.id_m_paket_soal' => $dataPaketSoal->id_m_paket_soal , 'm_soal.jenis_soal' => 'G', 'm_soal.status_soal' => 'A', 'm_soal.kategori_soal' => 'SD'));
			
			$cekJumlahSoalGandaSulit = $this->m_soal_model->showData(array('m_soal.id_m_paket_soal' => $dataPaketSoal->id_m_paket_soal , 'm_soal.jenis_soal' => 'G', 'm_soal.status_soal' => 'A', 'm_soal.kategori_soal' => 'SL'));
			
			$cekJumlahSoalEsay 	= $this->m_soal_model->showData(array('m_soal.id_m_paket_soal' => $dataPaketSoal->id_m_paket_soal , 'm_soal.jenis_soal' => 'E', 'm_soal.status_soal' => 'A', 'm_soal.kategori_soal' => 'MD'));
			
			$cekJumlahSoalEsaySedang 	= $this->m_soal_model->showData(array('m_soal.id_m_paket_soal' => $dataPaketSoal->id_m_paket_soal , 'm_soal.jenis_soal' => 'E', 'm_soal.status_soal' => 'A', 'm_soal.kategori_soal' => 'SD'));
			
			$cekJumlahSoalEsaySulit 	= $this->m_soal_model->showData(array('m_soal.id_m_paket_soal' => $dataPaketSoal->id_m_paket_soal , 'm_soal.jenis_soal' => 'E', 'm_soal.status_soal' => 'A', 'm_soal.kategori_soal' => 'SL'));
			
			///var_dump(count($cekJumlahSoalEsay));
			
		//	var_dump($cekAda);
			
			if($cekAda){
				
				if($cekAda->jumlah_soal_ganda > 0){
					$checkedGanda = 'checked';
					
					if($cekAda->acak_soal_ganda  == 'Y'){
						$acakSoalGanda = 'checked';
					}
					else{
						$acakSoalGanda = '';
					}
					
					if($cekAda->acak_jawaban_ganda == 'Y'){
						$acakJawabanGanda = 'checked';
					}
					else{
						$acakJawabanGanda = '';
					}
					
					$showJumlahGanda 		= '';
					$showNilaiBenarGanda 	= '';
					$showNilaiSalahGanda 	= '';
					$showAcakGanda 			= '';
					$showAcakJawabanGanda 	= '';
				}
				else{
					$checkedGanda = '';
					$acakSoalGanda = '';
					$acakJawabanGanda = '';
					
					
					$showJumlahGanda 		= 'none';
					$showNilaiBenarGanda 	= 'none';
					$showNilaiSalahGanda 	= 'none';
					$showAcakGanda 			= 'none';
					$showAcakJawabanGanda 	= 'none';
				}
				
				if($cekAda->jumlah_soal_esay > 0){
					$checkedEsay = 'checked';
					
					if($cekAda->acak_soal_esay  == 'Y'){
						$acakSoalEsay = 'checked';
					}
					else{
						$acakSoalEsay = '';
					}
					
					$showJumlahEsay = '';
					$showNilaiBenarEsay = '';
					$showNilaiSalahEsay = '';
					$showAcakEsay = '';
					
				}
				else{
					$checkedEsay = '';
					$acakSoalEsay = '';
					
					$showJumlahEsay = 'none';
					$showNilaiBenarEsay = 'none';
					$showNilaiSalahEsay = 'none';
					$showAcakEsay = 'none';
				}
				
				/////////////
				
				if($cekAda->jumlah_soal_ganda_sedang > 0){
					$checkedGandaSedang = 'checked';
					
					if($cekAda->acak_soal_ganda_sedang  == 'Y'){
						$acakSoalGandaSedang = 'checked';
					}
					else{
						$acakSoalGandaSedang = '';
					}
					
					if($cekAda->acak_jawaban_ganda_sedang == 'Y'){
						$acakJawabanGandaSedang = 'checked';
					}
					else{
						$acakJawabanGandaSedang = '';
					}
					
					$showJumlahGandaSedang 		= '';
					$showNilaiBenarGandaSedang 	= 'showNilaiBenarGandaSedang';
					$showNilaiSalahGandaSedang 	= '';
					$showAcakGandaSedang 			= '';
					$showAcakJawabanGandaSedang 	= '';
				}
				else{
					$checkedGandaSedang = '';
					$acakSoalGandaSedang = '';
					$acakJawabanGandaSedang = '';
					
					
					$showJumlahGandaSedang 		= 'none';
					$showNilaiBenarGandaSedang 	= 'none';
					$showNilaiSalahGandaSedang 	= 'none';
					$showAcakGandaSedang 			= 'none';
					$showAcakJawabanGandaSedang 	= 'none';
				}
				
				if($cekAda->jumlah_soal_esay_sedang > 0){
					$checkedEsaySedang = 'checked';
					
					if($cekAda->acak_soal_esay_sedang  == 'Y'){
						$acakSoalEsaySedang = 'checked';
					}
					else{
						$acakSoalEsaySedang = '';
					}
					
					$showJumlahEsaySedang 		= '';
					$showNilaiBenarEsaySedang 	= '';
					$showNilaiSalahEsaySedang 	= '';
					$showAcakEsaySedang 		= '';
					
				}
				else{
					$checkedEsaySedang 		= '';
					$acakSoalEsaySedang 	= '';
					
					$showJumlahEsaySedang 		= 'none';
					$showNilaiBenarEsaySedang 	= 'none';
					$showNilaiSalahEsaySedang 	= 'none';
					$showAcakEsaySedang 		= 'none';
				}
				
				/////////////
				
				if($cekAda->jumlah_soal_ganda_sulit > 0){
					$checkedGandaSulit = 'checked';
					
					if($cekAda->acak_soal_ganda_sulit  == 'Y'){
						$acakSoalGandaSulit = 'checked';
					}
					else{
						$acakSoalGandaSulit = '';
					}
					
					if($cekAda->acak_jawaban_ganda_sulit == 'Y'){
						$acakJawabanGandaSulit = 'checked';
					}
					else{
						$acakJawabanGandaSulit = '';
					}
					
					$showJumlahGandaSulit 		= '';
					$showNilaiBenarGandaSulit 	= '';
					$showNilaiSalahGandaSulit 	= '';
					$showAcakGandaSulit 			= '';
					$showAcakJawabanGandaSulit 	= '';
				}
				else{
					$checkedGandaSulit = '';
					$acakSoalGandaSulit = '';
					$acakJawabanGandaSulit = '';
					
					
					$showJumlahGandaSulit 		= 'none';
					$showNilaiBenarGandaSulit 	= 'none';
					$showNilaiSalahGandaSulit 	= 'none';
					$showAcakGandaSulit 			= 'none';
					$showAcakJawabanGandaSulit 	= 'none';
				}
				
				if($cekAda->jumlah_soal_esay_sulit > 0){
					$checkedEsaySulit = 'checked';
					
					if($cekAda->acak_soal_esay_sulit  == 'Y'){
						$acakSoalEsaySulit = 'checked';
					}
					else{
						$acakSoalEsaySulit = '';
					}
					
					$showJumlahEsaySulit 		= '';
					$showNilaiBenarEsaySulit 	= '';
					$showNilaiSalahEsaySulit 	= '';
					$showAcakEsaySulit 		= '';
					
				}
				else{
					$checkedEsaySulit 		= '';
					$acakSoalEsaySulit 	= '';
					
					$showJumlahEsaySulit 		= 'none';
					$showNilaiBenarEsaySulit 	= 'none';
					$showNilaiSalahEsaySulit 	= 'none';
					$showAcakEsaySulit 		= 'none';
				}
				
				/////////////////
				
				$this->htmlPaket .= '
				<tr>
					<td align="enter" width="5%">'.$no.'.</td>
					<td>
						<b>'.$dataPaketSoal->nm_paket_soal.'</b> <br><br>
						
						
					<input type="hidden" name="paket_soal[]" value="'.$cekAda->id_m_paket_soal.'" id="paket_soal_'.$dataPaketSoal->id_m_paket_soal.'" >
				';		
						
				if(count($cekJumlahSoalGanda) > 0 || count($cekJumlahSoalEsay) > 0 ){
					$this->htmlPaket .= '	
						<table class="table table-striped table-bordered table-hover table-checkable order-column">
							<thead>
								<tr>
									<th scope="col" colspan="6">
										Kategori Mudah
									</th>
								</tr>
								<tr>
									<td scope="col">Jenis Soal</td>
									<td width="20%" scope="col">Jumlah Diujikan</td>
									<td width="15%" scope="col">Nilai benar</td>
									<td width="15%" scope="col">Nilai Salah</td>
									<td width="12%" scope="col">Acak Soal</td>
									<td width="15%" scope="col">Acak Jawaban</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" '.$checkedGanda.'  onclick="click_jenis_soal_ujian_ganda(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_ganda_'.$dataPaketSoal->id_m_paket_soal.'"> Pilihan Ganda
												<span></span>
											</label>
									</td>
									<td>
										<input data-toggle="tooltip" title="Jumlah Semua Soal = '.count($cekJumlahSoalGanda).'" type="text"  max="'.count($cekJumlahSoalGanda).'" placeholder="Jumlah Soal Ganda" style="display:'.$showJumlahGanda.'" name="jml_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="jml_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  value="'.$cekAda->jumlah_soal_ganda.'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:'.$showNilaiBenarGanda.'" name="nilai_benar_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_ganda_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number"  value="'.$cekAda->nilai_benar_soal_ganda.'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:'.$showNilaiSalahGanda.'"  name="nilai_salah_ganda_'.$dataPaketSoal->id_m_paket_soal.'"  id="nilai_salah_ganda_'.$dataPaketSoal->id_m_paket_soal.'"  value="'.$cekAda->nilai_salah_soal_ganda.'"  class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakGanda.'" id="div_acak_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakSoalGanda.' id="acak_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakJawabanGanda.'" id="div_acak_jawaban_ganda_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_jawaban_ganda_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakJawabanGanda.' id="acak_jawaban_ganda_'.$dataPaketSoal->id_m_paket_soal.'"> Acak jawaban
												<span></span>
											</label>
									</td>
								</tr>
								
								
								<tr>
									<td>
										<label class="mt-checkbox mt-checkbox-outline">
											<input type="checkbox" '.$checkedEsay.'  onclick="click_jenis_soal_ujian_uraian(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_uraian_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_uraian_'.$dataPaketSoal->id_m_paket_soal.'"> Soal Uraian
											<span></span>
										</label>
									</td>
									<td>
										<input type="text" placeholder="Jumlah Soal Uraian" style="display:'.$showJumlahEsay.'" name="jml_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->jumlah_soal_esay.'" max="'.count($cekJumlahSoalEsay).'" id="jml_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  title="Jumlah Semua Soal = '.count($cekJumlahSoalEsay).'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:'.$showNilaiBenarEsay.'" name="nilai_benar_uraian_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->nilai_benar_soal_esay.'" id="nilai_benar_uraian_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:'.$showNilaiSalahEsay.'" name="nilai_salah_uraian_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->nilai_salah_soal_esay.'" id="nilai_salah_uraian_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakEsay.'" id="div_acak_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox"  value="Y" name="acak_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakSoalEsay.' id="acak_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
									</td>
								</tr>
							</tbody>
						</table>
					';
					
				}	
				
				
				////
				
				if(count($cekJumlahSoalGandaSedang) > 0 || count($cekJumlahSoalEsaySedang) > 0 ){
					$this->htmlPaket .= '	
						<table class="table table-striped table-bordered table-hover table-checkable order-column">
							<thead>
								<tr>
									<th scope="col" colspan="6">
										Kategori Sedang
									</th>
								</tr>
								<tr>
									<td scope="col">Jenis Soal</td>
									<td width="20%" scope="col">Jumlah Diujikan</td>
									<td width="15%" scope="col">Nilai benar</td>
									<td width="15%" scope="col">Nilai Salah</td>
									<td width="12%" scope="col">Acak Soal</td>
									<td width="15%" scope="col">Acak Jawaban</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" '.$checkedGandaSedang.' onclick="click_jenis_soal_ujian_ganda_sedang(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Pilihan Ganda
												<span></span>
											</label>
									</td>
									<td>
										<input data-toggle="tooltip" title="Jumlah Semua Soal = '.count($cekJumlahSoalGandaSedang).'" type="text"  max="'.count($cekJumlahSoalGandaSedang).'" placeholder="Jumlah Soal Ganda" style="display:'.$showJumlahGandaSedang.'" name="jml_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="jml_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  value="'.$cekAda->jumlah_soal_ganda_sedang.'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:'.$showNilaiBenarGandaSedang.'" name="nilai_benar_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number"  value="'.$cekAda->nilai_benar_soal_ganda_sedang.'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:'.$showNilaiSalahGandaSedang.'"  name="nilai_salah_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"  id="nilai_salah_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"  value="'.$cekAda->nilai_salah_soal_ganda_sedang.'"  class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakGandaSedang.'" id="div_acak_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakSoalGandaSedang.' id="acak_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakJawabanGandaSedang.'" id="div_acak_jawaban_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_jawaban_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakJawabanGandaSedang.' id="acak_jawaban_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Acak jawaban
												<span></span>
											</label>
									</td>
								</tr>
								
								
								<tr>
									<td>
										<label class="mt-checkbox mt-checkbox-outline">
											<input type="checkbox" '.$checkedEsaySedang.'  onclick="click_jenis_soal_ujian_uraian(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Soal Uraian
											<span></span>
										</label>
									</td>
									<td>
										<input type="text" placeholder="Jumlah Soal Uraian" style="display:'.$showJumlahEsaySedang.'" name="jml_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->jumlah_soal_esay.'" max="'.count($cekJumlahSoalEsaySedang).'" id="jml_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  title="Jumlah Semua Soal = '.count($cekJumlahSoalEsaySedang).'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:'.$showNilaiBenarEsaySedang.'" name="nilai_benar_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->nilai_benar_soal_esay_sedang.'" id="nilai_benar_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:'.$showNilaiSalahEsaySedang.'" name="nilai_salah_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->nilai_salah_soal_esay.'" id="nilai_salah_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakEsaySedang.'" id="div_acak_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox"  value="Y" name="acak_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakSoalEsaySedang.' id="acak_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
									</td>
								</tr>
							</tbody>
						</table>
					';
					
				}	
				
				/////
				
				if(count($cekJumlahSoalGandaSulit) > 0 || count($cekJumlahSoalEsaySulit) > 0 ){
					$this->htmlPaket .= '	
						<table class="table table-striped table-bordered table-hover table-checkable order-column">
							<thead>
								<tr>
									<th scope="col" colspan="6">
										Kategori Sulit
									</th>
								</tr>
								<tr>
									<td scope="col">Jenis Soal</td>
									<td width="20%" scope="col">Jumlah Diujikan</td>
									<td width="15%" scope="col">Nilai benar</td>
									<td width="15%" scope="col">Nilai Salah</td>
									<td width="12%" scope="col">Acak Soal</td>
									<td width="15%" scope="col">Acak Jawaban</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline">
												<input <input type="checkbox" '.$checkedGandaSulit.'  onclick="click_jenis_soal_ujian_ganda(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Pilihan Ganda
												<span></span>
											</label>
									</td>
									<td>
										<input data-toggle="tooltip" title="Jumlah Semua Soal = '.count($cekJumlahSoalGandaSulit).'" type="text"  max="'.count($cekJumlahSoalGandaSulit).'" placeholder="Jumlah Soal Ganda" style="display:'.$showJumlahGandaSulit.'" name="jml_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="jml_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  value="'.$cekAda->jumlah_soal_ganda_sulit.'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:'.$showNilaiBenarGandaSulit.'" name="nilai_benar_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number"  value="'.$cekAda->nilai_benar_soal_ganda_sulit.'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:'.$showNilaiSalahGandaSulit.'"  name="nilai_salah_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"  id="nilai_salah_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"  value="'.$cekAda->nilai_salah_soal_ganda_sulit.'"  class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakGandaSulit.'" id="div_acak_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakSoalGandaSulit.' id="acak_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakJawabanGanda.'" id="div_acak_jawaban_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_jawaban_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakJawabanGandaSulit.' id="acak_jawaban_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Acak jawaban
												<span></span>
											</label>
									</td>
								</tr>
								
								
								<tr>
									<td>
										<label class="mt-checkbox mt-checkbox-outline">
											<input type="checkbox" '.$checkedEsaySulit.'  onclick="click_jenis_soal_ujian_uraian(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Soal Uraian
											<span></span>
										</label>
									</td>
									<td>
										<input type="text" placeholder="Jumlah Soal Uraian" style="display:'.$showJumlahEsaySulit.'" name="jml_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->jumlah_soal_esay_sulit.'" max="'.count($cekJumlahSoalEsaySulit).'" id="jml_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  title="Jumlah Semua Soal = '.count($cekJumlahSoalEsaySulit).'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:'.$showNilaiBenarEsaySulit.'" name="nilai_benar_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->nilai_benar_soal_esay_sulit.'" id="nilai_benar_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:'.$showNilaiSalahEsaySulit.'" name="nilai_salah_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" value="'.$cekAda->nilai_salah_soal_esay_sulit.'" id="nilai_salah_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:'.$showAcakEsaySulit.'" id="div_acak_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox"  value="Y" name="acak_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" '.$acakSoalEsaySulit.' id="acak_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
									</td>
								</tr>
							</tbody>
						</table>
					';
					
				}	
				
				
				////
				
				
			}
			else{
			
				$this->htmlPaket .= '
				<tr>
					<td align="enter" width="5%">'.$no.'.</td>
					<td>
						<b>'.$dataPaketSoal->nm_paket_soal.'</b> <br><br>
						
						<input type="hidden" name="paket_soal[]" value="" id="paket_soal_'.$dataPaketSoal->id_m_paket_soal.'">
						
				';
				
				if(count($cekJumlahSoalGanda) > 0 || count($cekJumlahSoalEsay) > 0 ){
					$this->htmlPaket .= '	
						<table class="table table-striped table-bordered table-hover table-checkable order-column">
							<thead>
								<tr>
									<th scope="col" colspan="6">
										Kategori Mudah
									</th>
								</tr>
								<tr>
									<td scope="col">Jenis Soal</td>
									<td width="20%" scope="col">Jumlah Diujikan</td>
									<td width="15%" scope="col">Nilai benar</td>
									<td width="15%" scope="col">Nilai Salah</td>
									<td width="12%" scope="col">Acak Soal</td>
									<td width="15%" scope="col">Acak Jawaban</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline">
												<input  type="checkbox" onclick="click_jenis_soal_ujian_ganda(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_ganda_'.$dataPaketSoal->id_m_paket_soal.'"> Pilihan Ganda
												<span></span>
											</label>
									</td>
									<td>
										<input data-toggle="tooltip" title="Jumlah Semua Soal = '.count($cekJumlahSoalGanda).'" type="text"  max="'.count($cekJumlahSoalGanda).'" placeholder="Jumlah Soal Ganda" style="display:none" name="jml_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="jml_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips">
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:none" name="nilai_benar_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_ganda_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:none"  name="nilai_salah_ganda_'.$dataPaketSoal->id_m_paket_soal.'"  id="nilai_salah_ganda_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_soal_ganda_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_jawaban_ganda_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_jawaban_ganda_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_jawaban_ganda_'.$dataPaketSoal->id_m_paket_soal.'"> Acak jawaban
												<span></span>
											</label>
									</td>
								</tr>
								
								
								<tr>
									<td>
										<label class="mt-checkbox mt-checkbox-outline">
											<input type="checkbox" onclick="click_jenis_soal_ujian_uraian(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_uraian_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_uraian_'.$dataPaketSoal->id_m_paket_soal.'"> Soal Uraian
											<span></span>
										</label>
									</td>
									<td>
										<input type="text" placeholder="Jumlah Soal Uraian" style="display:none" name="jml_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'" max="'.count($cekJumlahSoalEsay).'" id="jml_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  title="Jumlah Semua Soal = '.count($cekJumlahSoalEsay).'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:none" name="nilai_benar_uraian_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_uraian_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:none" name="nilai_salah_uraian_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_salah_uraian_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox"  value="Y" name="acak_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
									</td>
								</tr>
							</tbody>
						</table>
					';
					
				}
						
				if(count($cekJumlahSoalGandaSedang) > 0 || count($cekJumlahSoalEsaySedang) > 0 ){
					$this->htmlPaket .= '
						<table class="table table-striped table-bordered table-hover table-checkable order-column">
							<thead>
								<tr>
									<th scope="col" colspan="6">
										Kategori Sedang
									</th>
								</tr>
								<tr>
									<td scope="col">Jenis Soal</td>
									<td width="20%" scope="col">Jumlah Diujikan</td>
									<td width="15%" scope="col">Nilai benar</td>
									<td width="15%" scope="col">Nilai Salah</td>
									<td width="12%" scope="col">Acak Soal</td>
									<td width="15%" scope="col">Acak Jawaban</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline">
												<input  type="checkbox" onclick="click_jenis_soal_ujian_ganda_sedang(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Pilihan Ganda
												<span></span>
											</label>
									</td>
									<td>
										<input data-toggle="tooltip" title="Jumlah Semua Soal = '.count($cekJumlahSoalGandaSedang).'" type="text"  max="'.count($cekJumlahSoalGandaSedang).'" placeholder="Jumlah Soal Ganda" style="display:none" name="jml_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="jml_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips">
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:none" name="nilai_benar_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:none"  name="nilai_salah_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"  id="nilai_salah_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_soal_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_jawaban_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_jawaban_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_jawaban_ganda_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Acak jawaban
												<span></span>
											</label>
									</td>
								</tr>
								
								
								<tr>
									<td>
										<label class="mt-checkbox mt-checkbox-outline">
											<input type="checkbox" onclick="click_jenis_soal_ujian_uraian_sedang(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Soal Uraian
											<span></span>
										</label>
									</td>
									<td>
										<input type="text" placeholder="Jumlah Soal Uraian" style="display:none" name="jml_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" max="'.count($cekJumlahSoalEsaySedang).'" id="jml_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  title="Jumlah Semua Soal = '.count($cekJumlahSoalEsaySedang).'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:none" name="nilai_benar_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:none" name="nilai_salah_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_salah_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox"  value="Y" name="acak_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_soal_uraian_sedang_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
									</td>
								</tr>
							</tbody>
						</table>
						';
					}	
					if(count($cekJumlahSoalGandaSulit) > 0 || count($cekJumlahSoalEsaySulit) > 0 ){
					$this->htmlPaket .= '
						<table class="table table-striped table-bordered table-hover table-checkable order-column">
							<thead>
								<tr>
									<th scope="col" colspan="6">
										Kategori Sulit
									</th>
								</tr>
								<tr>
									<td scope="col">Jenis Soal</td>
									<td width="20%" scope="col">Jumlah Diujikan</td>
									<td width="15%" scope="col">Nilai benar</td>
									<td width="15%" scope="col">Nilai Salah</td>
									<td width="12%" scope="col">Acak Soal</td>
									<td width="15%" scope="col">Acak Jawaban</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline">
												<input  type="checkbox" onclick="click_jenis_soal_ujian_ganda_sulit(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Pilihan Ganda
												<span></span>
											</label>
									</td>
									<td>
										<input data-toggle="tooltip" title="Jumlah Semua Soal = '.count($cekJumlahSoalGandaSulit).'" type="text"  max="'.count($cekJumlahSoalGandaSulit).'" placeholder="Jumlah Soal Ganda" style="display:none" name="jml_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="jml_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips">
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:none" name="nilai_benar_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:none"  name="nilai_salah_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"  id="nilai_salah_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_soal_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_jawaban_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox" value="Y" name="acak_jawaban_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_jawaban_ganda_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Acak jawaban
												<span></span>
											</label>
									</td>
								</tr>
								
								
								<tr>
									<td>
										<label class="mt-checkbox mt-checkbox-outline">
											<input type="checkbox" onclick="click_jenis_soal_ujian_uraian_sulit(\''.$dataPaketSoal->id_m_paket_soal.'\')" value="'.$dataPaketSoal->id_m_paket_soal.'" name="jenis_soal_ujian_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="jenis_soal_ujian_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Soal Uraian
											<span></span>
										</label>
									</td>
									<td>
										<input type="text" placeholder="Jumlah Soal Uraian" style="display:none" name="jml_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" max="'.count($cekJumlahSoalEsaySulit).'" id="jml_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number tooltips"  title="Jumlah Semua Soal = '.count($cekJumlahSoalEsaySulit).'" >
									</td>
									<td>
										<input type="text" placeholder="Nilai Benar" style="display:none" name="nilai_benar_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_benar_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td>
										<input type="text" placeholder="Nilai Salah" style="display:none" name="nilai_salah_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="nilai_salah_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" class="form-control number">
									</td>
									<td align=left>
											<label class="mt-checkbox mt-checkbox-outline"  style="display:none" id="div_acak_soal_uraian_'.$dataPaketSoal->id_m_paket_soal.'">
												<input type="checkbox"  value="Y" name="acak_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'" id="acak_soal_uraian_sulit_'.$dataPaketSoal->id_m_paket_soal.'"> Acak Soal
												<span></span>
											</label>
									</td>
									
									<td align=left>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
						
					
				</tr>
				';
				}
			}
			$no++;
		}
		
		
		$this->template_view->load_admin_view('master/ujian/detail_mapel_view');
	}
	
	public function insert_detail_mapel($idUjian, $idUjianMapel){
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		if(!$idUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		
		
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('m_paket_soal_model');
		$this->load->model('soal_siswa_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		
		$dataUjianMapel = $this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' =>  $idUjianMapel));
		
		$cekSudahDikerjakan = $this->detail_siswa_paket_ujian_model->getData(array('detail_siswa_paket_ujian.tgl_mulai_pengerjaan is not null' =>  null, 'detail_siswa_paket_ujian.id_m_ujian_mapel' => $idUjianMapel));
		
		if($cekSudahDikerjakan){
			$status = array('status' => false, 'pesan' => 'Proses Ubah Detail Soal Ujian Gagal, dikarenakan Ujian dengan Mata Pelajaran '.$dataUjianMapel->nm_mata_pelajaran.' sudah terdapat siswa yang mengerjakan.');
		}
		else{
		
			if(is_array($this->input->post('paket_soal'))){
				
				$jumlahNilaiBenarGanda = 0;
				$jumlahNilaiBenarUraian = 0;
				$jumlahSoalGanda = 0;
				$jumlahSoalUraian = 0;
				
				foreach($this->input->post('paket_soal') as $id_paket_soal){
					if($this->input->post('jml_soal_ganda_'.$id_paket_soal) != ''){
						$jumlahNilaiBenarGanda += $this->input->post('nilai_benar_ganda_'.$id_paket_soal) * $this->input->post('jml_soal_ganda_'.$id_paket_soal);					
						
						$jumlahSoalGanda += $this->input->post('jml_soal_ganda_'.$id_paket_soal);
					}
					
					if($this->input->post('jml_soal_uraian_'.$id_paket_soal) != ''){
						$jumlahNilaiBenarUraian += $this->input->post('nilai_benar_uraian_'.$id_paket_soal) * $this->input->post('jml_soal_uraian_'.$id_paket_soal);
						
						$jumlahSoalUraian += $this->input->post('jml_soal_uraian_'.$id_paket_soal);
					}
					
					if($this->input->post('jml_soal_ganda_sedang_'.$id_paket_soal) != ''){
						$jumlahNilaiBenarGanda += $this->input->post('nilai_benar_ganda_sedang_'.$id_paket_soal) * $this->input->post('jml_soal_ganda_sedang_'.$id_paket_soal);					
						
						$jumlahSoalGanda += $this->input->post('jml_soal_ganda_sedang_'.$id_paket_soal);
					}
					
					if($this->input->post('jml_soal_uraian_sedang_'.$id_paket_soal) != ''){
						$jumlahNilaiBenarUraian += $this->input->post('nilai_benar_uraian_sedang_'.$id_paket_soal) * $this->input->post('jml_soal_uraian_sedang_'.$id_paket_soal);
						
						$jumlahSoalUraian += $this->input->post('jml_soal_uraian_sedang_'.$id_paket_soal);
					}
					
					if($this->input->post('jml_soal_ganda_sulit_'.$id_paket_soal) != ''){
						$jumlahNilaiBenarGanda += $this->input->post('nilai_benar_ganda_sulit_'.$id_paket_soal) * $this->input->post('jml_soal_ganda_sulit_'.$id_paket_soal);					
						
						$jumlahSoalGanda += $this->input->post('jml_soal_ganda_sulit_'.$id_paket_soal);
					}
					
					if($this->input->post('jml_soal_uraian_sulit_'.$id_paket_soal) != ''){
						$jumlahNilaiBenarUraian += $this->input->post('nilai_benar_uraian_sulit_'.$id_paket_soal) * $this->input->post('jml_soal_uraian_sulit_'.$id_paket_soal);
						
						$jumlahSoalUraian += $this->input->post('jml_soal_uraian_sulit_'.$id_paket_soal);
					}
					
					
				}
				
				$jumlahNilaiSemua 	= $jumlahNilaiBenarUraian + $jumlahNilaiBenarGanda;
				
				if($jumlahSoalGanda != $dataUjianMapel->jml_soal_ganda){
					$status = array('status' => false, 'pesan' => 'Proses Simpan Data Gagal, dikarenakan Jumlah Soal Ganda yang anda inputkan adalah '.$jumlahSoalGanda.'. Jumlah Soal Ganda yang diharuskan adalah '.$dataUjianMapel->jml_soal_ganda);
				}
				elseif($jumlahSoalUraian != $dataUjianMapel->jml_soal_esay){
					$status = array('status' => false, 'pesan' => 'Proses Simpan Data Gagal, dikarenakan Jumlah Soal Uraian yang anda inputkan adalah '.$jumlahSoalGanda.'. Jumlah Soal Uraian yang diharuskan adalah '.$dataUjianMapel->jml_soal_esay);
				}
				elseif($jumlahNilaiSemua != $dataUjianMapel->nilai_maksimal_ujian){
					$status = array('status' => false, 'pesan' => 'Proses Simpan Data Gagal, dikarenakan Total Nilai Keseluruhan yang anda inputkan adalah '.$jumlahNilaiSemua.'. Nilai yang diharuskan adalah dengan Total '.$dataUjianMapel->nilai_maksimal_ujian);
				}
				else{
					//var_dump($_POST);exit();				
					
					$this->load->model('t_paket_soal_ujian_model');
					
					$this->db->trans_start();
					
					
					$detail_siswa_paket_ujian = $this->detail_siswa_paket_ujian_model->showData(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $idUjianMapel));
					
					if($detail_siswa_paket_ujian){
						
						$delete_soal_siswa = $this->soal_siswa_model->delete(array("soal_siswa.id_detail_siswa_paket_ujian in (select id_detail_siswa_paket_ujian from detail_siswa_paket_ujian where detail_siswa_paket_ujian.id_m_ujian_mapel='".$idUjianMapel."' ) " => null));
						
						$delete_detail_siswa_paket_ujian = $this->detail_siswa_paket_ujian_model->delete(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $idUjianMapel));
						
						
						$delete_t_paket_soal_ujian = $this->t_paket_soal_ujian_model->delete(array('t_paket_soal_ujian.id_m_ujian_mapel' => $idUjianMapel));
					}
					
					
					foreach($this->input->post('paket_soal') as $id_paket_soal){
		
						
						
						if($id_paket_soal!=''){
							
							$data['jumlah_soal_ganda'] 			= $this->input->post('jml_soal_ganda_'.$id_paket_soal);
							$data['nilai_benar_soal_ganda'] 	= $this->input->post('nilai_benar_ganda_'.$id_paket_soal);
							$data['nilai_salah_soal_ganda'] 	= $this->input->post('nilai_salah_ganda_'.$id_paket_soal);
							
							if($this->input->post('acak_soal_ganda_'.$id_paket_soal)){
								$acalSoalGanda = 'Y';
							}
							else{
								$acalSoalGanda = 'N';
							}
							$data['acak_soal_ganda'] 		= $acalSoalGanda;
							
							if($this->input->post('acak_jawaban_ganda_'.$id_paket_soal)){
								$acalJawabGanda = 'Y';
							}
							else{
								$acalJawabGanda = 'N';
							}
							$data['acak_jawaban_ganda'] 		= $acalJawabGanda;
							
							$data['jumlah_soal_esay'] 			= $this->input->post('jml_soal_uraian_'.$id_paket_soal);;
							$data['nilai_benar_soal_esay'] 		= $this->input->post('nilai_benar_uraian_'.$id_paket_soal);
							$data['nilai_salah_soal_esay'] 		= $this->input->post('nilai_salah_uraian_'.$id_paket_soal);
							
							if($this->input->post('acak_soal_uraian_'.$id_paket_soal)){
								$acalJawabEsay = 'Y';
							}
							else{
								$acalJawabEsay = 'N';
							}
							$data['acak_soal_esay'] 			= $this->input->post('acak_soal_uraian_'.$id_paket_soal);
							
							
							$data['jumlah_soal_ganda_sedang'] 		= $this->input->post('jml_soal_ganda_sedang_'.$id_paket_soal);
							$data['nilai_benar_soal_ganda_sedang'] 	= $this->input->post('nilai_benar_ganda_sedang_'.$id_paket_soal);
							$data['nilai_salah_soal_ganda_sedang'] 	= $this->input->post('nilai_salah_ganda_sedang_'.$id_paket_soal);
							
							if($this->input->post('acak_soal_ganda_sedang_'.$id_paket_soal)){
								$acalSoalGandaSedang = 'Y';
							}
							else{
								$acalSoalGandaSedang = 'N';
							}
							$data['acak_soal_ganda_sedang'] 		= $acalSoalGandaSedang;
							
							if($this->input->post('acak_jawaban_ganda_sedang_'.$id_paket_soal)){
								$acalJawabGandaSedang = 'Y';
							}
							else{
								$acalJawabGandaSedang = 'N';
							}
							$data['acak_jawaban_ganda_sedang'] 		= $acalJawabGandaSedang;
							
							$data['jumlah_soal_esay_sedang'] 		= $this->input->post('jml_soal_uraian_sedang_'.$id_paket_soal);;
							$data['nilai_benar_soal_esay_sedang'] 	= $this->input->post('nilai_benar_uraian_sedang_'.$id_paket_soal);
							$data['nilai_salah_soal_esay_sedang'] 	= $this->input->post('nilai_salah_uraian_sedang_'.$id_paket_soal);
							
							if($this->input->post('acak_soal_uraian_sedang_'.$id_paket_soal)){
								$acalJawabEsaySedang = 'Y';
							}
							else{
								$acalJawabEsaySedang = 'N';
							}
							$data['acak_soal_esay_sedang'] 			= $acalJawabEsaySedang;
							
							
							$data['jumlah_soal_ganda_sulit'] 		= $this->input->post('jml_soal_ganda_sulit_'.$id_paket_soal);
							$data['nilai_benar_soal_ganda_sulit'] 	= $this->input->post('nilai_benar_ganda_sulit_'.$id_paket_soal);
							$data['nilai_salah_soal_ganda_sulit'] 	= $this->input->post('nilai_salah_ganda_sulit_'.$id_paket_soal);
							
							if($this->input->post('acak_soal_ganda_sulit_'.$id_paket_soal)){
								$acalSoalGandaSulit = 'Y';
							}
							else{
								$acalSoalGandaSulit = 'N';
							}
							$data['acak_soal_ganda_sulit'] 			= $acalSoalGandaSulit;
							
							if($this->input->post('acak_jawaban_ganda_sulit_'.$id_paket_soal)){
								$acalSoalGandaSulit = 'Y';
							}
							else{
								$acalSoalGandaSulit = 'N';
							}
							$data['acak_jawaban_ganda_sulit'] 		= $acalSoalGandaSulit;
							
							$data['jumlah_soal_esay_sulit'] 		= $this->input->post('jml_soal_uraian_sulit_'.$id_paket_soal);;
							$data['nilai_benar_soal_esay_sulit'] 	= $this->input->post('nilai_benar_uraian_sulit_'.$id_paket_soal);
							$data['nilai_salah_soal_esay_sulit'] 	= $this->input->post('nilai_salah_uraian_sulit_'.$id_paket_soal);
							
							if($this->input->post('acak_soal_uraian_sulit_'.$id_paket_soal)){
								$acalSoalEsaySulit = 'Y';
							}
							else{
								$acalSoalEsaySulit = 'N';
							}
							$data['acak_soal_esay_sulit'] 			= $acalSoalEsaySulit;
							
							$data['id_m_ujian_mapel'] 			= $idUjianMapel;
							$data['id_m_paket_soal'] 			= $id_paket_soal;
							
							$newid = $this->t_paket_soal_ujian_model->insert($data);
						}
					}
					
					
					
					$this->load->model('m_siswa_paket_ujian_model');
					$this->load->model('detail_siswa_paket_ujian_model');
					$this->load->model('soal_siswa_model');
					$this->load->model('m_soal_model');
					
					$this->dataSiswaUjian = $this->m_siswa_paket_ujian_model->showData(array('m_siswa_paket_ujian.id_m_ujian' => $idUjian));
					
					foreach($this->dataSiswaUjian as $dataSiswa){
						
						$dataDetailSiswa['nilai'] 					= null;
						$dataDetailSiswa['menit_pengerjaan'] 		= $dataUjianMapel->menit_pengerjaan;
						$dataDetailSiswa['id_m_siswa_paket_ujian'] 	= $dataSiswa->id_m_siswa_paket_ujian;
						$dataDetailSiswa['id_m_ujian_mapel'] 		= $idUjianMapel;
						
						$newIdDetailSiswa = $this->detail_siswa_paket_ujian_model->insert($dataDetailSiswa);
						
						if($newIdDetailSiswa){
							
							$dataPaketSoalForSiswa = $this->t_paket_soal_ujian_model->showData(array('id_m_ujian_mapel' => $idUjianMapel),'','id_t_paket_soal_ujian asc');
							
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
										
										$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sulit , 'Y','G');
									}
									else{
										$dataSoalForSoalSiswa = $this->m_soal_model->soalRandomDanTidak(array('m_soal.id_m_paket_soal' => $insertDataPaketSoalForSiswa->id_m_paket_soal, 'm_soal.kategori_soal' => 'SL'), $insertDataPaketSoalForSiswa->jumlah_soal_ganda_sulit ,null,'G');
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
						
					}
					
					
					$this->db->trans_complete();
					if($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						$status = array('status' => FALSE, 'pesan' => 'Failed to save data, check your input ..');
					}
					else {
						$this->db->trans_commit();
						$this->notice->success("Proses Pembuatan Soal Berhasil.");	
						$status = array('status' => true );
					}
				}
			}
			else{
				$status = array('status' => false, 'pesan' => 'Silahkan Pilih Data Paket Soal yang Diujikan');
			}
		}
		echo(json_encode($status));
	}
	
	
	public function delete_mapel($idUjian,$idUjianMapel){
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		if(!$idUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		
		
		$data['id_user_delete'] 	= $this->session->userdata('id_user');
		$data['tgl_delete'] 		= date('Y-m-d H:i:s');	
		$returnUpdate 				= $this->m_ujian_mapel_model->update($idUjianMapel,$data);
		
		if($returnUpdate){
			$this->notice->success("Proses Penghapusan Data Ujian berhasil.");			
		}
		else{
			$this->notice->warning("Proses Penghapusan Data Ujian Gagal, silahkan ulangi lagi.");	
		}				
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/mapel/".$idUjian);
		
	}
	
	public function daftar_hadir($idUjian,$idUjianMapel){
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		if(!$idUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
				
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('m_siswa_paket_ujian_model');
		
		$this->dataUjianMapel = $this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' =>  $idUjianMapel));	

		
		if(!$this->dataUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->showData = $this->m_siswa_paket_ujian_model->showDataKelas(array('id_m_ujian' => $idUjian),'', 'kelas');
		
		$this->template_view->load_admin_view('master/ujian/daftar_hadir_view');
	}
	
	
	public function ubah_token($idUjian,$idUjianMapel){
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
		if(!$idUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
				
		$this->load->model('m_ujian_mapel_model');
		
		$this->dataUjianMapel = $this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' =>  $idUjianMapel));	
		if(!$this->dataUjianMapel){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
				
		$dataToken['token_ujian'] = $this->encrypt_decrypt->generateRandomString(4);		
		$this->m_ujian_mapel_model->update( $idUjianMapel, $dataToken );
		
		redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/mapel/".$idUjian);
	}
	
}
	
	
	
