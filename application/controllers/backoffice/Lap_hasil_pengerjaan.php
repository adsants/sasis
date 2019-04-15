<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_hasil_pengerjaan extends CI_Controller {	

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
		
		$this->template_view->load_admin_view('laporan/lap_hasil_pengerjaan_view');
	}
	
	public function detail($idUjian){		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}						
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		
		$this->ShowDataMapelUjian 	= $this->m_ujian_mapel_model->showData(array("m_ujian_mapel.id_m_ujian" => $idUjian));
		
		
		if($this->input->get('id_m_ujian_mapel')){
			
			$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
			
			if($this->input->get('order_by')){
				if($this->input->get('order_by') == 'detail_siswa_paket_ujian.nilai'){
					
					$orderBy = $this->input->get('order_by')." desc";
				}
				else{
					
					$orderBy = $this->input->get('order_by')." asc";
				}
			}
			else{
				$orderBy = "m_siswa_paket_ujian.nama";
			}
			
			$this->dataSiswa = $this->detail_siswa_paket_ujian_model->showDataForLaporan(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel')),"",$orderBy);
			
			
			
		}
		
		$this->template_view->load_admin_view('laporan/detail_lap_hasil_pengerjaan_view');
	}
	
	public function excel(){
		
		if(!$this->input->get('id_m_ujian_mapel')){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('soal_siswa_model');
		
		$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
		
		if(!$this->dataMapelUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
			
		if($this->input->get('order_by')){
			if($this->input->get('order_by') == 'detail_siswa_paket_ujian.nilai'){
				
				$orderBy = $this->input->get('order_by')." desc";
			}
			else{
				
				$orderBy = $this->input->get('order_by')." asc";
			}
		}
		else{
			$orderBy = "m_siswa_paket_ujian.nipd";
		}
		
		$filename = "Laporan Hasil Pengerjaan Ujian - ".$this->dataMapelUjian->nm_ujian." - ".$this->dataMapelUjian->nm_mata_pelajaran.".xls"; // File Name
		// Download file
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");
		
		
		
		
			$this->tableHtml = '
			<table >
					<tr  >
						<td colspan="57"><b>Laporan Hasil Pengerjaan Ujian</b></td>
					</tr>
					
					<tr  >
						<td>Ujian : </td>
						<td colspan="55">'.$this->dataMapelUjian->nm_ujian.' </td>
					</tr>
					<tr  >
						<td>Mata Pelajaran : </td>
						<td colspan="55">'.$this->dataMapelUjian->nm_mata_pelajaran.' </td>
					</tr>
					<tr  >
						<td>&nbsp; </td>
						<td colspan="55"></td>
					</tr>
					
					<tr  >
						<td>Keterangan : </td>
					</tr>	
					<tr  >
						<td style="background: rgb(255, 234, 167);">Salah </td>
					</tr>
					<tr  >
						<td style="background: rgb(85, 239, 196);">Benar </td>
					</tr>
					<tr  >	
						<td style="background: rgb(223, 230, 233);">Tidak Dijawab </td>
						
					</tr>
					<tr  >
						<td>&nbsp; </td>
						<td colspan="55"></td>
					</tr>
			</table>
			';
		
		$jml_total_soal = $this->dataMapelUjian->jml_soal_ganda + $this->dataMapelUjian->jml_soal_esay;
		
		
		
		
		//$this->pagination->initialize($config);
			$this->tableHtml .= '
			<table border="1" style="border-collapse:collapse">
				<thead>
					<tr  >
						
						<td align="center" valign="middle" width="150" rowspan="2">Nomor Induk Siswa</td>
						<td align="center" valign="middle" width="150" rowspan="2">Nama</td>
						<td align="center" valign="middle" width="150" rowspan="2">Kelas</td>
						<td align="center" width="300" colspan="'.$jml_total_soal.'">Nomor Soal</td>
						<td align="center" valign="middle" width="150" rowspan="2">Nilai</td
					</tr>
					
					<tr >
			';
			
		
			for($i=1; $i <= $jml_total_soal; $i++){	
				$this->tableHtml .= '
						<td align="center">'.$i.'</td>
				';
			}
			
			$this->tableHtml .= 
				'
					</tr>
					</thead>		
				<tbody>
				';		
				
			
				
				
			$this->dataSiswa = $this->detail_siswa_paket_ujian_model->showDataForLaporan(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel')),"",$orderBy);	
				
			foreach($this->dataSiswa as $data){		
			
			$this->tableHtml .= '
			
						
					<tr height="50">
						<td align="center" width="150">'.$data->nipd.'</td>
						<td align="center" width="150">'.$data->nama.'</td>
						<td align="center" width="150">'.$data->kelas.'</td>
			';			
						
				$this->showDataJawaban 		= $this->soal_siswa_model->showDataLapDetail(array('detail_siswa_paket_ujian.id_m_ujian_mapel' =>$this->input->get('id_m_ujian_mapel') , 'detail_siswa_paket_ujian.id_detail_siswa_paket_ujian' =>  $data->id_detail_siswa_paket_ujian),'','id_soal_siswa');
				
				//$this->db->last_query();exit();
				
				
				foreach($this->showDataJawaban as $dataJawaban){		
						
					if($dataJawaban->status_jawaban == 'S'){
						$style= 'style="background: rgb(255, 234, 167);" ';
					}
					elseif($dataJawaban->status_jawaban == 'B'){
						$style= 'style="background: rgb(85, 239, 196);" ';
					}
					else{
						
						$style= 'style="background: rgb(223, 230, 233);" ';
					}
					$this->tableHtml .= '	
						<td align="center" '.$style.' width="150">'.$this->template_view->nilai_decimal($dataJawaban->nilai_jawaban).'</td>
					';
				
				}
					
					
			$this->tableHtml .= '	
				<td align="center" width="150">'.$this->template_view->nilai_decimal($data->nilai).'</td>
			</tr>
			';
			}
			
			
			
			$this->tableHtml .= '
				</tbody>
			</table>
			';
			
		
		echo $this->tableHtml;
		
	}
	
	
	public function cetak_detail(){		
		
		
		
		//$this->load->helper('pdf_helper');
		
		if(!$this->input->get('id_m_ujian_mapel')){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('soal_siswa_model');
		$this->load->model('m_jawaban_model');
		
		$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
		
		if(!$this->dataMapelUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
			
			
		$this->dataSiswa = $this->detail_siswa_paket_ujian_model->getData(array('detail_siswa_paket_ujian.id_detail_siswa_paket_ujian' => $this->input->get('id_detail_siswa_paket_ujian')));
		
		
		//var_dump($this->dataSiswa);
		
		echo "<title>Laporan hasil Pengerjaan</title>";
		
		$this->tableHtml = '<link href="'.base_url().'assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		';
		$this->tableHtml .= '
		<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>		
		<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css" type="text/css">
		';
		
		$this->tableHtml .= '
		<style>
		.borderless td, .borderless th {
			border: none;
		}
		</style>
		';
		if($this->dataSiswa->tgl_akhir_pengerjaan == ''){
			$nilai = '<br>Belum selesai Mengerjakan';
		}
		////
		else{			
			$nilai = "<h1>".$this->template_view->nilai_decimal($this->dataSiswa->nilai)."</h1>";
		}
		
		$this->load->model('profil_aplikasi_model');	
		$this->dataProfil = $this->profil_aplikasi_model->getData();
		
		$this->tableHtml .= '
		
		<table width="100%" border="0" class="table table-bordered">
			<tr valign="center">
				<td width="30%" align="center">
					<img src="'.base_url().'upload/logo/'.$this->dataProfil->icon.'" width="300px">
				</td>
				<td width="70%">
					<table width="100%" border="0" classs="borderless">
						<tr valign="bottom">
							<td align="center">
								<br>
								<center>
								<h3>'.$this->dataProfil->nm_aplikasi.'</h3>
								<h4>'.$this->dataProfil->alamat.'</h4>
								<h4>'.$this->dataProfil->telp.'</h4>
								</center>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="100%" border="0" class="table">
			<tr valign="top">
				<td align="center">
					<h4>Laporan Hasil Pengerjaan Ujian</h4>
				</td>
			</tr>
		</table>
		
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
								Jawaban Siswa : <br>
								'.$data->jawaban_esay.'	
								
							</td>
						</tr>
					</table>
					
					
				';
			}
			
			
		$i++;
		}
		
		
		$this->tableHtml .= '<br><br>Powered By www.sahabat-siswa.com';
		
		
		echo $this->tableHtml;
		echo "
		
		<script>
		window.print();
		</script>
		
		";
	//	$mpdf = new \Mpdf\Mpdf();
		
	//	$mpdf->SetTitle('Hasil Ujian');
	//	$mpdf->WriteHTML($this->tableHtml );
	//	$mpdf->Output('Hasil Ujian '.$this->dataSiswa->nm_ujian.' - '.$this->dataSiswa->nis.'.pdf', 'I');     
		//$payStub->Output('yourFileName.pdf', 'I');
	
		
	}
	
}
	
	
	
