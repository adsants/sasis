<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ujian extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('encrypt_decrypt');
		$this->session_lib->siswa();
		
		
		$this->load->library('text_html');
		
		$this->load->model('m_siswa_paket_ujian_model');
		$this->load->model('m_ujian_model');
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		
		
		$this->abjadAbc = array("A","B","C","D","E","F");
    
	} 

	public function Login($id_ujian , $id_m_ujian_mapel){
		
		if(!$id_ujian){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}			
		$this->dataUjian		=	$this->m_ujian_model->getData( $id_ujian);
		
		if(!$id_m_ujian_mapel){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}			
		$this->dataUjianMapel		=	$this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' => $id_m_ujian_mapel, 'm_ujian_mapel.status_ujian' => 'A'));
		
		$this->dataDetailSiswa		=	$this->detail_siswa_paket_ujian_model->getDataForUjian(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $id_m_ujian_mapel, 'detail_siswa_paket_ujian.id_m_siswa_paket_ujian' => $this->session->userdata('id_m_siswa_paket_ujian')));		
		
		
		$this->template_view->load_siswa_view('siswa/ujian_login_view');
	}
	
	public function authentication($id_ujian , $id_m_ujian_mapel){
		
		if(!$id_ujian){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}			
		$this->dataUjian		=	$this->m_ujian_model->getData( $id_ujian);
		
		if(!$id_m_ujian_mapel){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}			
		$this->dataUjianMapel		=	$this->m_ujian_mapel_model->getData(array('m_ujian_mapel.id_m_ujian_mapel' => $id_m_ujian_mapel, 'm_ujian_mapel.status_ujian' => 'A'));
		
		$sekarang			=	date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
		$contractDateBegin 	= 	date('Y-m-d H:i:s', strtotime($this->dataUjianMapel->tgl_pengerjaan_indo));
		$contractDateEnd 	= 	date('Y-m-d H:i:s', strtotime($this->dataUjianMapel->tgl_akhir_pengerjaan_indo));
		
		if (($sekarang > $contractDateBegin) && ($sekarang < $contractDateEnd)){
		
			$cekSiswa = $this->detail_siswa_paket_ujian_model->loginUjian(array('m_ujian_mapel.token_ujian' => $this->input->post('token')));
			
			if($cekSiswa){
				
				$this->session->set_userdata('ujian_'.$id_m_ujian_mapel, $id_m_ujian_mapel);
			}
			else{
				$this->notice->warning("Maaf. Proses Login Ujian gagal, Silahkan inputkan Token dengan benar.");
			}
			
		}
		else{
			$this->notice->warning("Maaf. Proses Login Ujian gagal, dikarenakan Waktu sekarang tidak sesuai dengan Tanggal Pengerjaan Ujian.");				
		}
		
		redirect($this->template_view->base_url_siswa()."/ujian/login/".$id_ujian."/".$id_m_ujian_mapel);
	}
	public function mulai($id_ujian = null,$id_m_ujian_mapel =  null){
		
		//var_dump( $this->template_view->mac());//exit();
		
		
		if(!$id_ujian){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}			
		$this->dataUjian	=	$this->m_ujian_model->getData( $id_ujian);
		
		if(!$this->dataUjian){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}
		
		if(!$id_m_ujian_mapel){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}			
		$this->dataUjianMapel	=	$this->m_ujian_mapel_model->getDataForUjian(array('m_ujian_mapel.id_m_ujian_mapel' => $id_m_ujian_mapel));
		
		if(!$this->dataUjianMapel){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}
		
		
		$this->jumlahSoal	=	$this->dataUjianMapel->jml_soal_ganda + $this->dataUjianMapel->jml_soal_esay;		
		
		$this->siswaUjian		=	$this->detail_siswa_paket_ujian_model->getDataForUjian(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $id_m_ujian_mapel , 'detail_siswa_paket_ujian.id_m_siswa_paket_ujian' => $this->session->userdata('id_m_siswa_paket_ujian') ));
		
		if(!$this->siswaUjian){			
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}
		
		//var_dump($this->siswaUjian);exit();
		
		if($this->siswaUjian->tgl_akhir_pengerjaan != ''){
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}
		
		if($this->siswaUjian->tgl_akhir_pengerjaan != ''){
			redirect($this->template_view->base_url_siswa()."/dashboard");
		}
		
		
		/// cek dulu apakah sudah ada tgl atau tidak
		if($this->siswaUjian->tgl_mulai_pengerjaan ==''){
			
			$dataUpdateSiswaUjian['tgl_mulai_pengerjaan']	=	date('Y-m-d H:i:s');
			
			$this->detail_siswa_paket_ujian_model->update(array('id_detail_siswa_paket_ujian' => $this->siswaUjian->id_detail_siswa_paket_ujian),$dataUpdateSiswaUjian);
			
			//echo $this->db->last_query();
		}
		if($this->siswaUjian->tgl_mulai_pengerjaan !=''){
			
			if($this->siswaUjian->mac_address !=  ''){
			if($this->siswaUjian->mac_address !=  $this->template_view->mac()){
				
				$this->notice->warning("Maaf Proses Kerjakan Ujian Gagal dikarenakan Device / Komputer / Laptop yang anda gunakan berbeda dengan saat Proses  awal Login.");
				redirect($this->template_view->base_url_siswa()."/ujian/login/".$id_ujian."/".$id_m_ujian_mapel);
			}
			}
		}
		
		
		$dataUpdateMac['mac_address']			=	$this->template_view->mac();		
		$this->detail_siswa_paket_ujian_model->update(array('id_detail_siswa_paket_ujian' => $this->siswaUjian->id_detail_siswa_paket_ujian),$dataUpdateMac);
		
		$this->load->model('soal_siswa_model');
		$this->load->model('m_soal_model');
		$this->load->model('m_jawaban_model');
		$this->load->model('t_paket_soal_ujian_model');
			
		$this->soalUjian	= $this->soal_siswa_model->showData(array('id_detail_siswa_paket_ujian' => $this->siswaUjian->id_detail_siswa_paket_ujian),"","id_soal_siswa");
		
		$this->idSoalSiswaPertama	= $this->soal_siswa_model->getData(array('id_detail_siswa_paket_ujian' => $this->siswaUjian->id_detail_siswa_paket_ujian),"","id_soal_siswa asc");
		
		
		
		$this->soalHtml	 	= "";
		$this->daftarSoal 	= "";
		
		$jumlahSoal = count($this->soalUjian);
		$i=1;
		foreach($this->soalUjian as $data){
						
			
			
			
			if($i == 1){
				$display = "";
				$this->input_id_soal_siswa = $data->id_soal_siswa;
			}
			else{
				$display = "none";
			}
			
			if($data->ragu_ragu == 'Y'){
				$checkedRagu = "checked";
			}
			else{
				$checkedRagu = "";
			}
			
			$idPrev = $data->id_soal_siswa - 1;
			$idNext = $data->id_soal_siswa + 1;
			
			if($i == 1){
				$btnPrev =	"";
				$currentSoal = "current_soal";
			}
			else{
				$nomorSoal 	= $i - 1;
				$btnPrev 	= '
				<span id="div_prev_pesan_pause_'.$data->id_soal_siswa.'" style="display:none" class="btn btn-danger"><i class="fa fa-info-circle"> </i> Pause dahulu Media Player</span> 
				<span class="btn default" id="btn_prev_'.$data->id_soal_siswa.'" onclick="buka_soal(\''.$idPrev.'\',\''.$nomorSoal.'\')"><i class="fa fa-backward"></i> SOAL SEBELUMNYA</span>';
				
				$currentSoal = "";
			}
			
			if($i == $jumlahSoal){
				$btnNext =	'
				<span id="div_next_pesan_pause_'.$data->id_soal_siswa.'" style="display:none" class="btn btn-danger"><i class="fa fa-info-circle"> </i> Pause dahulu Media Player</span>
				<span class="btn btn-primary" id="btn_next_'.$data->id_soal_siswa.'" onclick="btn_selesai_ujian()">SELESAI <i class="fa fa-forward"></i></span>';
			}
			else{
				$nomorSoal 	= $i + 1;
				$btnNext 	= '
				<span id="div_next_pesan_pause_'.$data->id_soal_siswa.'" style="display:none" class="btn btn-danger"><i class="fa fa-info-circle"> </i> Pause dahulu Media Player</span> 
				<span class="btn btn-primary" id="btn_next_'.$data->id_soal_siswa.'" onclick="buka_soal(\''.$idNext.'\',\''.$nomorSoal.'\')">SOAL BERIKUTNYA <i class="fa fa-forward"></i></span>';
			}
			
			$this->m_soal	= $this->m_soal_model->getSoalForUjian(array('id_m_soal' => $data->id_m_soal));
			
			$this->data_t_paket_soal_ujian	= $this->t_paket_soal_ujian_model->getData(array('t_paket_soal_ujian.id_m_paket_soal' => $this->m_soal->id_m_paket_soal ,'t_paket_soal_ujian.id_m_ujian_mapel' => $id_m_ujian_mapel));
			
			if($this->m_soal->kategori_soal == 'MD'){
				$acakJawaban = $this->data_t_paket_soal_ujian->acak_jawaban_ganda;
			}
			elseif($this->m_soal->kategori_soal == 'SD'){
				$acakJawaban = $this->data_t_paket_soal_ujian->acak_jawaban_ganda_sedang;
			}
			else{
				$acakJawaban = $this->data_t_paket_soal_ujian->acak_jawaban_ganda_sulit;
			}
			
			if($this->m_soal->file_soal != ''){
				/**if($this->m_soal->type_file_soal == 'mpeg' || $this->m_soal->type_file_soal == 'mp3'){
					$fileSoal	= '
					<audio controls onclick="cek_pause_audio(\''.$data->id_soal_siswa.'\')" id="audio_'.$data->id_soal_siswa.'">
						<source src="'.base_url().'upload/soal/'.$this->m_soal->file_soal.'" type="audio/mpeg">
						Your browser does not support the audio element.
					</audio>
					';
				}
				else{
					$fileSoal	= '
					<video width="60%" height="250" controls>
						<source src="'.base_url().'upload/soal/'.$this->m_soal->file_soal.'" type="video/mp4">
						Your browser does not support the video tag.
					</video> 
					
					';
				}**/
				
				if($this->m_soal->type_file_soal == 'mpeg' || $this->m_soal->type_file_soal == 'mp3'){
					$fileSoal	= '
					<audio controls  onpause="pause_jon()" onplay="play_jon()"  id="audio_'.$data->id_soal_siswa.'">
						<source  src="data:audio/mpeg;base64,'.$this->m_soal->file_soal.'">
						Your browser does not support the audio element.
					</audio>
					';
				}
				else{
					$fileSoal	= '
					<video width="60%" onpause="pause_jon()" onplay="play_jon()" height="250" controls>
						<source src="data:video/mp4;base64,'.$this->m_soal->file_soal.'">
						Your browser does not support the video tag.
					</video> 
					
					';
				}
			}
			else{
				$fileSoal	= '';
			}
			
			$this->soalHtml .= 	'
				
				<div class="row font_soal" style="display:'.$display.'" id="div_soal_'.$data->id_soal_siswa.'" >
					'.$fileSoal.'
					
					<input id="input_id_m_soal_'.$data->id_soal_siswa.'" type="hidden" value="'.$data->id_m_soal.'">
					<div class="col-md-12" id="kotak_soal">
						'.$this->m_soal->soal.'
						<hr>
						
				';
				
				if($this->m_soal->jenis_soal == 'E'){
					$this->soalHtml .= 	'
						<div  >
							<textarea onkeyup="jawab_esay(\''.$this->m_soal->id_m_soal.'\',\''.$this->siswaUjian->id_detail_siswa_paket_ujian.'\',\''.$abjad.'\',\''.$data->id_soal_siswa.'\',\''.$this->abjadAbc[$abjad].'\')" rows="6" id="textarea_'.$data->id_soal_siswa.'" class="form-control" placeholder="Ketikkan Jawaban disini">'.$data->jawaban_esay.'</textarea>
						</div>
					';
				}
				else{
				
					$this->jawaban	= $this->m_jawaban_model->showDataForUjian(array('m_jawaban.id_m_soal' => $data->id_m_soal), $acakJawaban);
					
					
					
					$abjad		=	0;
					foreach($this->jawaban as $dataJawaban){
						if($dataJawaban->id_m_jawaban == $data->id_m_jawaban){
							$checked = "checked='checked'";
						}
						else{
							$checked = "";			
						}
						
						
						
						$this->soalHtml .= 	'
						<div class="form-group form-md-radios">
								<div class="md-radio-list">
									<label id="label_'.$data->id_soal_siswa.'_'.$abjad.'"><input '.$checked.'  type="radio" name="select_'.$data->id_soal_siswa.'" id="select_'.$data->id_soal_siswa.'_'.$abjad.'" onclick="kirim_jawaban(\''.$dataJawaban->id_m_jawaban.'\',\''.$dataJawaban->id_m_soal.'\',\''.$this->siswaUjian->id_detail_siswa_paket_ujian.'\',\''.$abjad.'\',\''.$data->id_soal_siswa.'\',\''.$this->abjadAbc[$abjad].'\')" value="'.$dataJawaban->id_m_jawaban.'" /><span id="check_ujian" '.$checked.'>'.$this->abjadAbc[$abjad].'</span> <div id="div_jawaban">'.$dataJawaban->jawaban .'</div></label>
								</div>
							</div>
						';
						
						if($data->id_m_jawaban == ''){	
							$jawabanBenarAbcd	=	"?";					
						}
						else{	
							if($data->id_m_jawaban == $dataJawaban->id_m_jawaban){
								$jawabanBenarAbcd	=	$this->abjadAbc[$abjad];
							}
						}
					$abjad++;
					}
				}	
				
				
				if($this->m_soal->jenis_soal == 'E'){
					//var_dump($data);echo "<hr>";
					if($data->jawaban_esay != '' ){
						$jawabanBenar = "&#10003;";
					}
					else{
						$jawabanBenar = "?";
					}
				}
				else{
					$jawabanBenar = $jawabanBenarAbcd;
				}
				
			if($data->ragu_ragu == 'Y'){
				$this->daftarSoal .='
				<div class="col-md-3 col-sm-3 col-xs-3"  onclick="buka_soal(\''.$data->id_soal_siswa.'\',\''.$i.'\')"><div class="circle" id="slide_abcd_'.$data->id_soal_siswa.'">'.$jawabanBenar.'</div>
					<div class="list_soal soal_ragu" id="daftar_soal_'.$data->id_soal_siswa.'">					
						'.$i.'
					</div>
				</div>';
			}
			else{
				
				if($this->m_soal->jenis_soal == 'E'){
					if($data->jawaban_esay != '' ){
						$this->daftarSoal .='
						<div class="col-md-3 col-sm-3 col-xs-3"  onclick="buka_soal(\''.$data->id_soal_siswa.'\',\''.$i.'\')"><div class="circle" id="slide_abcd_'.$data->id_soal_siswa.'">'.$jawabanBenar.'</div>
							<div class="list_soal sudah_dijawab" id="daftar_soal_'.$data->id_soal_siswa.'">					
								'.$i.'
							</div>
						</div>';
						
					}
					else{
						$this->daftarSoal .='
						<div class="col-md-3 col-sm-3 col-xs-3"  onclick="buka_soal(\''.$data->id_soal_siswa.'\',\''.$i.'\')"><div class="circle" id="slide_abcd_'.$data->id_soal_siswa.'">'.$jawabanBenar.'</div>
							<div class="list_soal '.$currentSoal.'" id="daftar_soal_'.$data->id_soal_siswa.'">					
								'.$i.'
							</div>
						</div>';		
						
					}
				}
				else{
					if($data->id_m_jawaban != '' ){
						$this->daftarSoal .='
						<div class="col-md-3 col-sm-3 col-xs-3"  onclick="buka_soal(\''.$data->id_soal_siswa.'\',\''.$i.'\')"><div class="circle" id="slide_abcd_'.$data->id_soal_siswa.'">'.$jawabanBenar.'</div>
							<div class="list_soal sudah_dijawab" id="daftar_soal_'.$data->id_soal_siswa.'">					
								'.$i.'
							</div>
						</div>';
						
					}
					else{
						$this->daftarSoal .='
						<div class="col-md-3 col-sm-3 col-xs-3"  onclick="buka_soal(\''.$data->id_soal_siswa.'\',\''.$i.'\')"><div class="circle" id="slide_abcd_'.$data->id_soal_siswa.'">'.$jawabanBenar.'</div>
							<div class="list_soal '.$currentSoal.'" id="daftar_soal_'.$data->id_soal_siswa.'">					
								'.$i.'
							</div>
						</div>';		
						
					}
				}
				
				
			}
			
			$this->soalHtml .= 
				
				'</div>
				<div class="row" id="btn_soal">
						<form id="form_soal" action="'.$this->template_view->base_url_siswa().'/ujian/kirim_jawaban">
							<div class="col-sm-4" style="margin-bottom:5px">	
								
								'.$btnPrev.'
								
								
							</div>
							<div class="col-sm-4 text-center" style="margin-bottom:5px">
								<label id="ragu_ragu">
									<input type="checkbox" '.$checkedRagu.' id="btn_ragu_ragu_'.$data->id_soal_siswa.'" onclick="ragu_ragu(\''.$data->id_soal_siswa.'\')"> RAGU-RAGU
									<span></span>
								</label>
							</div>
							<div class="col-sm-4 text-right" style="margin-bottom:5px">
								
								'.$btnNext.'
								
							</div>
						</form>
				</div>
				</div>
				
				';
		$i++;
		}

		
			//var_dump($jawabanBenar);exit();
		
		
		
		
		$this->template_view->load_view('siswa/ujian_mulai_view');
	}
	public function kirim_jawaban(){
		
		//$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('m_jawaban_model');
		$this->load->model('m_soal_model');
		$this->load->model('soal_siswa_model');
		$this->load->model('t_paket_soal_ujian_model');
		
		if($this->input->post('type_soal')!=='esay'){
			$this->form_validation->set_rules('id_m_jawaban', 'jawaban', 'required');
		}
		
		$this->form_validation->set_rules('id_m_soal', 'Soal', 'required');
		$this->form_validation->set_rules('id_detail_siswa_paket_ujian', 'Siswa Ujian', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => false , 'pesan' => "Form validation is required");
		}
		else{							
		
			
			$dataStatusJawaban	=	$this->m_jawaban_model->getDataForUjian( $this->input->post('id_m_jawaban') );
			$dataSoal			=	$this->m_soal_model->getDatSatuTable( $this->input->post('id_m_soal') );		
			
		
			$this->dataNilaiSoal 		= $this->t_paket_soal_ujian_model->getData(array('t_paket_soal_ujian.id_m_ujian_mapel' => $this->input->post('id_m_ujian_mapel')));
	
	
			
			$nilaiJawaban = "0";
			if($this->input->post('type_soal')!=='esay'){
				if($dataStatusJawaban->status == 'B'){
					if($dataSoal->jenis_soal == 'G'){
						if($dataSoal->kategori_soal == 'MD'){
							$nilaiJawaban	=	$this->dataNilaiSoal->nilai_benar_soal_ganda;
						}
						if($dataSoal->kategori_soal == 'SD'){
							$nilaiJawaban	=	$this->dataNilaiSoal->nilai_benar_soal_ganda_sedang;
						}
						if($dataSoal->kategori_soal == 'SL'){
							$nilaiJawaban	=	$this->dataNilaiSoal->nilai_benar_soal_ganda_sulit;
						}
						
					}	
				}
				else{
					if($dataSoal->jenis_soal == 'G'){
						
						if($dataSoal->kategori_soal == 'MD'){
							$nilaiJawaban	=	$this->dataNilaiSoal->nilai_salah_soal_ganda;
						}
						if($dataSoal->kategori_soal == 'SD'){
							$nilaiJawaban	=	$this->dataNilaiSoal->nilai_salah_soal_ganda_sedang;
						}
						if($dataSoal->kategori_soal == 'SL'){
							$nilaiJawaban	=	$this->dataNilaiSoal->nilai_salah_soal_ganda_sulit;
						}
					}	
				}
			}
			
			
		//var_dump($nilaiJawaban);
		
			/// update Jawaban
			$whereJawaban					=	array( 'id_m_soal' => $this->input->post('id_m_soal'), 'id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian'));
			
			$data['time_stamp'] 			= date("Y-m-d H:i:s");
			
			if($this->input->post('type_soal')!=='esay'){
				$data['status_jawaban'] 		= $dataStatusJawaban->status;
				$data['id_m_jawaban'] 			= $this->input->post('id_m_jawaban');				
				$data['nilai_jawaban'] 			= $nilaiJawaban;
			}
			else{				
				$data['jawaban_esay'] 			= $this->input->post('jawaban_esay');
			}
			
			$result = $this->soal_siswa_model->update($whereJawaban,$data);
			//echo $this->db->last_query();
			
			// update waktu akhir
			$dataUpdateSiswaUjian['menit_pengerjaan']	=	$this->input->post('menit_akhir');
			$this->detail_siswa_paket_ujian_model->update(array( 'id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')),$dataUpdateSiswaUjian);
			
			
			//echo $this->db->last_query();
			if($result === FALSE){
				$status = array('status' => false , 'pesan' => "Gagal Update Jawaban");
			}
			else{				
				//$this->model_db = $this->load->database('sasis_database_smp2candi', true);
				//$this->model_db->close();   
				//$this->db->close();
				$status = array('status' => true);
			}			
		}
		

		echo(json_encode($status));
	}
	
	public function ragu_submit(){
		$this->form_validation->set_rules('id_soal_siswa', 'ID T Jawaban Siswa', 'required');
		$this->form_validation->set_rules('hasil_ragu', 'RAGU-RAGU', 'required');
		
		$this->load->model('soal_siswa_model');
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => false , 'pesan' => "Form validation is required");
		}
		else{							
		
			
			/// update Jawaban Ragu
			$whereJawaban				=	array('id_soal_siswa' => $this->input->post('id_soal_siswa'));
			
			$data['ragu_ragu'] 			= $this->input->post('hasil_ragu');
		
			$result = $this->soal_siswa_model->update($whereJawaban,$data);
			
			
			if($result === FALSE){
				$status = array('status' => false , 'pesan' => "Gagal Update Jawaban");
			}
			else{				
				$status = array('status' => true);
			}			
		}
		

		echo(json_encode($status));
	}
	
	public function selesai(){
		$this->form_validation->set_rules('id_detail_siswa_paket_ujian', 'ID Trans Jawaban Siswa', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => false , 'pesan' => "Form validation is required");
		}
		else{							
			$this->load->model('detail_siswa_paket_ujian_model');		
			$this->load->model('soal_siswa_model');		
			
			
			$cekStatus	=	$this->detail_siswa_paket_ujian_model->getDataForUjian(array('detail_siswa_paket_ujian.id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')));
			
			if($cekStatus->tgl_akhir_pengerjaan != ''){
				$status = array('status' => false , 'pesan' => "<div class='alert alert-warning'>Proses simpan Gagal, Anda Sudah melakukan Ujian <br><a href='".$this->template_view->base_url_siswa()."/dashboard'>Kembali ke Beranda</a></div>",'sudah_ujian' => true);
			}
			else{	
				$soalBelumJawab	=	$this->soal_siswa_model->getData(array('soal_siswa.time_stamp is null' => null, 'soal_siswa.id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')));					
				
				if($soalBelumJawab){	
					$this->idSoalSiswaPertama	= $this->soal_siswa_model->getData(array('id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian') ),"","id_soal_siswa asc");		
					
					$nomor_soal = ($soalBelumJawab->id_soal_siswa - $this->idSoalSiswaPertama->id_soal_siswa ) + 1;					
					
					$status = array('status' => false , 'pesan' => "<div class='alert alert-warning'>Soal Nomor <b>".$nomor_soal."</b> masih Belum dijawab, Anda masih memiliki waktu untuk mengerjakan Ujian. Silahkan Jawab soal tersebut terlebih dahulu dengan Klik Tombol Tidak.</div>", 'belum_semua' => true);
				}
				else{
					
					$soalRagu	=	$this->soal_siswa_model->getData(array('soal_siswa.ragu_ragu' => 'Y', 'soal_siswa.id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')));				
					
					if($soalRagu){
					
						$this->idSoalSiswaPertama	= $this->soal_siswa_model->getData(array('id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian') ),"","id_soal_siswa asc");		
						
						$nomor_soal = ($soalRagu->id_soal_siswa - $this->idSoalSiswaPertama->id_soal_siswa ) + 1;
						
						$status = array('status' => false , 'pesan' => "<div class='alert alert-warning'>jawaban Soal Nomor <b>".$nomor_soal."</b> masih Ragu-Ragu. Anda masih memiliki waktu untuk mengecek kembali Jawaban anda. Jika tidak, silahkan anda klik Selesai.</div>" ,  'ragu' => true);
					}
					else{
						$status = array('status' => true);
					}					
				}
			}				
		}	

		echo(json_encode($status));
	}
	
	public function tutup_ujian(){
		
		$this->load->model('detail_siswa_paket_ujian_model');		
		$this->load->model('soal_siswa_model');		
		//echo "joss";
		//exit();
		
		//$cekStatus	=	$this->detail_siswa_paket_ujian_model->getData(array('detail_siswa_paket_ujian.id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')));
		
			
		//if($cekStatus->tgl_akhir_pengerjaan != ''){
		//	$status = array('status' => false , 'pesan' => "<div class='alert alert-warning'>Proses simpan Gagal, Anda Sudah melakukan Ujian <br><a href='".$this->template_view->base_url_siswa()."/dashboard'>Kembali ke Beranda</a></div>",'sudah_ujian' => true);
		//}
		//else{	
		
			$jumlahNilai	=	$this->soal_siswa_model->sumNilai(array('id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')));
			
			if($jumlahNilai){
				$dataUpdateSiswaUjian['nilai']	=	$jumlahNilai->nilai;		
			}
			
			$dataUpdateSiswaUjian['tgl_akhir_pengerjaan'] 	= 	date('Y-m-d H:i:s');			
			$result = $this->detail_siswa_paket_ujian_model->update(array( 'id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')),$dataUpdateSiswaUjian);	
			
			//echo $this->db->last-query();
			
			

			if($result === FALSE){			
				$status = array('status' => false);				
			}
			else{			

				$cekUjianMapel	=	$this->m_ujian_mapel_model->getDataForUjian(array('m_ujian_mapel.id_m_ujian_mapel' => $this->input->post('id_m_ujian_mapel')));
			
				if($cekUjianMapel->tampilkan_nilai == 'Y'){
					
					//var_dump($jumlahNilai->nilai);
					
					if(!$jumlahNilai->nilai){					
						$status = array('status' => true,'nilai' => '<center><h4>Belum Ada Nilai</h4><hr></center>');
					}
					else{
						$status = array('status' => true,'nilai' => '<center><h4>Nilai Anda</h4><h2>'.$this->template_view->nilai_decimal($jumlahNilai->nilai).'</h2><hr></center>');
					}
				}
				else{
					$status = array('status' => true,'nilai' => '');
				}
			}	
	//	}sss
		
		echo(json_encode($status));
	}
	
	
}
