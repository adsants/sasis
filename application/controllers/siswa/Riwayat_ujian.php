<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_ujian extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->session_lib->siswa();
		
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->library('text_html');
		
		
		$this->abjadAbc = array("A","B","C","D","E","F");
    
	} 

	public function index(){
		
		$this->showData = $this->detail_siswa_paket_ujian_model->showDataForRiwayat(array('detail_siswa_paket_ujian.id_m_siswa_paket_ujian' => $this->session->userdata('id_m_siswa_paket_ujian'),'detail_siswa_paket_ujian.tgl_akhir_pengerjaan is not null' => null));
		
		//echo $this->db->last_query();
		
		
		$this->template_view->load_siswa_view('siswa/riwayat_ujian_view');
	}
	
	public function detail(){		
		
		
		
		$this->load->helper('pdf_helper');
		
		if(!$this->input->get('id_m_ujian_mapel')){
			redirect($this->template_view->base_url()."/".$this->uri->segment('2'));
		}
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('soal_siswa_model');
		$this->load->model('m_jawaban_model');
		
		$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
		
		if(!$this->dataMapelUjian){
			redirect($this->template_view->base_url()."/".$this->uri->segment('2'));
		}
			
			
		$this->dataSiswa = $this->detail_siswa_paket_ujian_model->getData(array('detail_siswa_paket_ujian.id_detail_siswa_paket_ujian' => $this->input->get('id_detail_siswa_paket_ujian')));
		
		
		//var_dump($this->dataSiswa);
	
		
		$this->tableHtml = '
		<style>
		.borderless td, .borderless th {
			border: none;
		}
		</style>
		';
		
		if($this->dataMapelUjian->tampilkan_nilai == 'Y'){
			if($this->dataMapelUjian->tgl_akhir_pengerjaan == ''){
				$nilai = '<br>Belum selesai Mengerjakan';
			}
			////
			else{			
				$nilai = "<h1>".$this->template_view->nilai_decimal($this->dataSiswa->nilai)."</h1>";
			}
		}
		else{
			$nilai = "<br><br><br><b>Tidak ditampilkan</b>";
		}
		
		
		
		
		$this->load->model('profil_aplikasi_model');	
		$this->dataProfil = $this->profil_aplikasi_model->getData();
		
		$this->tableHtml .= '
	
		
		<table width="100%"  class="table table-bordered">
			<tr valign="top">
				<td width="70%">
					<table width="100%" border="0">
						
						<tr valign="bottom">
							<td width="25%">
								&nbsp;NIS
							</td>
							<td width="5%" align=center>
								:
							</td>
							<td>
								&nbsp;'.$this->dataSiswa->nipd.'
							</td>
						</tr>
						<tr valign="bottom">
							<td>
								&nbsp;Nama
							</td>
							<td align=center>
								:
							</td>
							<td>
								&nbsp;'.$this->dataSiswa->nama.'
							</td>
						</tr>
						<tr valign="bottom">
							<td>
								&nbsp;Kelas
							</td>
							<td align=center>
								:
							</td>
							<td>
								&nbsp;'.$this->dataSiswa->kelas.'
							</td>
						</tr>
						<tr valign="bottom">
							<td>
								&nbsp;Ujian
							</td>
							<td align=center>
								:
							</td>
							<td>
								&nbsp;'.$this->dataMapelUjian->nm_ujian.'
							</td>
						</tr>
						<tr valign="bottom">
							<td>
								&nbsp;Mata Pelajaran
							</td>
							<td align=center>
								:
							</td>
							<td>
								&nbsp;'.$this->dataMapelUjian->nm_mata_pelajaran.'
							</td>
						</tr>
						
						
					</table>
				</td>
				
				<td width="30%" align="center">
					
					Nilai 
					'.$nilai.'
					
				</td>
			</tr>
		</table>
		<br>
		';
		
		if($this->dataMapelUjian->tampilkan_hasil_jawaban == 'Y'){
		
		
		$this->dataUjian = $this->soal_siswa_model->showDataForLaporan(array('id_detail_siswa_paket_ujian' => $this->input->get('id_detail_siswa_paket_ujian')),"","id_soal_siswa");
		//echo $this->db->last_query();
		
		$i=1;
		foreach($this->dataUjian as $data){
			
			if($data->jenis_soal == 'G'){
				
				$jawabanBenar = $this->m_jawaban_model->getDataArray(array('m_jawaban.id_m_soal' =>  $data->id_m_soal, 'm_jawaban.status' => 'B'));
				
				
				if($data->id_m_jawaban){
					$dataJawabanSiswa = $this->m_jawaban_model->getDataArray(array('m_jawaban.id_m_jawaban' =>  $data->id_m_jawaban));
					$jawabanSiswa = $dataJawabanSiswa->jawaban;
				}
				else{
					$jawabanSiswa = "Tidak Dijawab";
				}
				
				
				$this->tableHtml .= '
					
					<table border="1" style="border-collapse:collapse" width="100%" class="table table-bordered">
						<tr>
							<td>	
								Soal Nomor <b>'.
								$i.
								'</b> ( '
								.$this->text_html->status_jawaban_huruf_warna($data->status_jawaban).
								' )'.
						'		<br> Nilai : '.$this->template_view->nilai_decimal($data->nilai_jawaban).'
							</td>
						</tr>
						<tr>
							<td>
								<br>
								'.$data->soal.'
								<br>
							</td>
						</tr>
						<tr>
							<td>
								Kunci Jawaban :
								'.$jawabanBenar->jawaban.'	
								
							</td>
						</tr>
						<tr>
							<td>
								Jawaban Siswa :
								'.$jawabanSiswa.'	
								
							</td>
						</tr>
					</table>
					
					
				';
			}
			else{
				$this->tableHtml .= '
					
					<table border="1" style="border-collapse:collapse" width="100%" class="table table-bordered">
						<tr>
							<td>	
								Soal Nomor <b>'.
								$i.
								'</b> ( '
								.$this->text_html->status_jawaban_huruf_warna($data->status_jawaban,'E').
								' )'.
						'		<br> Nilai : '.$this->template_view->nilai_decimal($data->nilai_jawaban).'
							</td>
						</tr>
						<tr>
							<td>
								<br>
								'.$data->soal.'
								<br>
							</td>
						</tr>
						<tr>
							<td>
								Jawaban Siswa : <br>
								'.$data->jawaban_esay.'	
								
							</td>
						</tr>
					</table>
					
					
				';
			}
			
			
		$i++;
		}
		
		}
		
		else{
			
		$this->tableHtml .= '		
			<table width="100%" border="1" class="table table-striped table-bordered ">
				<tr valign="top">
					<td align=center>
						Detail Soal tidak dapat ditampilkan
					</td>
				</tr>
			</table>
		';
		}
		
		
		$this->tableHtml .= '<br><br><a href="'.$this->template_view->base_url_siswa().'/riwayat_ujian"><span class="btn btn-primary"><i class="fa fa-backward"></i> Kembali ke Daftar Riwayat Ujian</button></a>';
		
		$this->template_view->load_siswa_view('siswa/detail_ujian_view');
	}
	
	
	

	
}
