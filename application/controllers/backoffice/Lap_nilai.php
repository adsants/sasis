<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_nilai extends CI_Controller {	

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
		
		$this->template_view->load_admin_view('laporan/lap_ujian_view');
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
			
			$this->dataNilai = "";
			$no=1;
			foreach($this->dataSiswa as $dataSiswa){
				
					
				
				$this->dataNilai .= "
					<tr>
						<td align='center'>".$no.".</td>
						<td>".$dataSiswa->nipd." </td>
						<td>".$dataSiswa->nama."</td>
						<td>".$dataSiswa->kelas." </td>
						<td>".$this->template_view->nilai_decimal($dataSiswa->nilai)."</td>
						<td>".$this->template_view->waktu_pengerjaan_ujian($dataSiswa->id_detail_siswa_paket_ujian)."</td>
					</tr>
					";
			
			$no++;
			}
			
		}
		
		$this->template_view->load_admin_view('laporan/detail_lap_ujian_view');
	}
	
	public function excel(){
		
		
		if($this->input->get('mapel') == 'all'){
			
			$this->load->model('m_ujian_mapel_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			$this->load->model('m_siswa_paket_ujian_model');
			
			$this->dataUjian 	= $this->m_ujian_model->getData($this->input->get('id_m_ujian') );
			
			//var_dump($this->db->last_query());exit();
			
			if(!$this->dataUjian){
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			
				$orderBy = "m_siswa_paket_ujian.kelas";
			
			
			$filename = "Laporan Nilai - ".$this->dataUjian->nm_ujian.".xls"; // File Name
			// Download file
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
			
			$this->dataSiswa = $this->m_siswa_paket_ujian_model->showData(array('id_m_ujian' => $this->input->get('id_m_ujian')),"",$orderBy);
			
			//exit();
			
			$this->tableHtml = "";
			$this->tableHtml .= '
				<table class="table table-striped table-bordered table-hover" style="border:border-collapse" border="1">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">NIPD</th>
							<th scope="col">Nama Siswa</th>
							<th scope="col">Kelas</th>
				';
				
				
				$this->dataMapel 	= $this->m_ujian_mapel_model->showData(array("m_ujian_mapel.id_m_ujian" => $this->dataUjian->id_m_ujian),'','m_mata_pelajaran.nm_mata_pelajaran');
				
				foreach($this->dataMapel as $dataMapel){
					$this->tableHtml .= '
								<th scope="col">'.$dataMapel->nm_mata_pelajaran.'</th>
					';
				}
				

				
			$this->tableHtml .= '
							<th scope="col">Total Nilai</th>
						</tr>
					</thead>
					<tbody>
			';
			
									
									$no=1;
									foreach($this->dataSiswa as $dataSiswa){
									//var_dump($dataSiswa);exit();
									$this->tableHtml .= '		
											<tr>
												<td align="center">'.$no.'</td>
												<td>'.$dataSiswa->nipd.'</td>
												<td>'.$dataSiswa->nama.'</td>
												<td>'.$dataSiswa->kelas.'</td>
											';
											
											
											$this->dataMapel 	= $this->m_ujian_mapel_model->showData(array("m_ujian_mapel.id_m_ujian" => $this->dataUjian->id_m_ujian),'','m_mata_pelajaran.nm_mata_pelajaran');
				
											foreach($this->dataMapel as $dataMapel){
												$this->dataNilaiSiswa 	= $this->detail_siswa_paket_ujian_model->getData(array("detail_siswa_paket_ujian.id_m_siswa_paket_ujian" => $dataSiswa->id_m_siswa_paket_ujian , 'detail_siswa_paket_ujian.id_m_ujian_mapel' => $dataMapel->id_m_ujian_mapel));
												
												$this->tableHtml .= '
													<td>'.$this->template_view->nilai_decimal($this->dataNilaiSiswa->nilai).'</td>
												';
												
												
											}
											
											$this->dataNilaiSiswaKeseluruhan 	= $this->detail_siswa_paket_ujian_model->nilaiAllMapel(array("detail_siswa_paket_ujian.id_m_siswa_paket_ujian" => $dataSiswa->id_m_siswa_paket_ujian ));
												
											$this->tableHtml .= '
												<td>'.$this->template_view->nilai_decimal($this->dataNilaiSiswaKeseluruhan->nilai).'</td>
											';	
												
												
									$this->tableHtml .= '					
												
											</tr>
									';
									
									$no++;
									}
									
			$this->tableHtml .= '	</tbody>
								</table>';
								
			
			echo $this->tableHtml;
		}
		else{
		
		
			if(!$this->input->get('id_m_ujian_mapel')){
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			
			$this->load->model('m_ujian_mapel_model');
			$this->load->model('detail_siswa_paket_ujian_model');
			
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
			
			$filename = "Laporan Nilai - ".$this->dataMapelUjian->nm_ujian." - ".$this->dataMapelUjian->nm_mata_pelajaran.".xls"; // File Name
			// Download file
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
			
			$this->dataSiswa = $this->detail_siswa_paket_ujian_model->showDataForLaporan(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel')),"",$orderBy);
			$this->tableHtml = "";
			$this->tableHtml .= '
				<table class="table table-striped table-bordered table-hover" style="border:border-collapse" border="1">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">NIPD</th>
							<th scope="col">Nama Siswa</th>
							<th scope="col">Kelas</th>
							<th scope="col">Nilai</th>
							<th scope="col">Waktu Pengerjaan</th>
						</tr>
					</thead>
					<tbody>
			';
			
									
									$no=1;
									foreach($this->dataSiswa as $dataSiswa){
									
									$this->tableHtml .= '		
											<tr>
												<td align="center">'.$no.'</td>
												<td>'.$dataSiswa->nipd.'</td>
												<td>'.$dataSiswa->nama.'</td>
												<td>'.$dataSiswa->kelas.'</td>
												<td>'.$this->template_view->cek_nilai($dataSiswa->id_detail_siswa_paket_ujian).'</td>
												<td>'.$this->template_view->waktu_pengerjaan_ujian($dataSiswa->id_detail_siswa_paket_ujian).'</td>
												
											</tr>
									';
									
									$no++;
									}
									
			$this->tableHtml .= '	</tbody>
								</table>';
								
			
			echo $this->tableHtml;
		}
	}
	
}
	
	
	
