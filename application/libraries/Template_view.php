<?php
class Template_view extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();

    }
    
    function base_url_admin(){		
		return base_url()."backoffice";       
	}
	function base_url_siswa(){		
		return base_url()."siswa";       
	}
	function load_null($content_view = null){		
		$this->_ci->load->model('profil_aplikasi_model');
		$this->_ci->dataProfilAplikasi = $this->_ci->profil_aplikasi_model->getData();	
		$this->_ci->load->view($content_view);       
	}
	////
	function nilai_decimal($nilai = null){
		if(!$nilai){
			return "0";
		}
		else{
			$pecah = explode('.', $nilai);
			
			if( $pecah[1] != "00" ){
				return $nilai;
			}
			else{
				return $pecah[0];
			}
		}
	}
	
	function cek_nilai($id_detail_siswa_paket_ujian){
		$this->_ci->load->model('detail_siswa_paket_ujian_model');
		$this->_ci->load->model('soal_siswa_model');
		
		$dataNilai = $this->_ci->detail_siswa_paket_ujian_model->getData(array('id_detail_siswa_paket_ujian' => $id_detail_siswa_paket_ujian));	
		
		
				
		
		if($dataNilai->nilai == ""){
			$jumlahNilai	=	$this->_ci->soal_siswa_model->sumNilai(array('id_detail_siswa_paket_ujian' => $id_detail_siswa_paket_ujian));
			return $this->nilai_decimal($jumlahNilai->nilai);			
		}
		else{
			return $this->nilai_decimal($dataNilai->nilai);
		}
	}
	
	function waktu_pengerjaan_ujian($id_detail_siswa_paket_ujian){
		$this->_ci->load->model('detail_siswa_paket_ujian_model');
		$dataWaktu = $this->_ci->detail_siswa_paket_ujian_model->getData(array('id_detail_siswa_paket_ujian' => $id_detail_siswa_paket_ujian));	
		
		if($dataWaktu){
			if($dataWaktu->tgl_mulai_pengerjaan == ''){
				return "Belum Mengerjakan";
			}
			elseif($dataWaktu->tgl_mulai_pengerjaan != '' && $dataWaktu->tgl_akhir_pengerjaan == ''){
				return $dataWaktu->tgl_mulai_pengerjaan_indo."<br>Belum Selesai Mengerjakan";
			}
			else{
				return $dataWaktu->tgl_mulai_pengerjaan_indo ." s/d ".$dataWaktu->tgl_akhir_pengerjaan_indo;
			}
			
		}
		else{
			return "Belum Mengerjakan";
		}
	}
	function mac(){
		$ipAddress	=	$_SERVER['REMOTE_ADDR'];
		$macAddr	=	false;

		#run the external command, break output into lines
		$arp		=	`arp -a $ipAddress`;
		$lines		=	explode("\n", $arp);
		
		#look for the output line describing our IP address
		foreach($lines as $line)
		{
			$cols	=	preg_split('/\s+/', trim($line));
			if ($cols[0]==$ipAddress){
			   $macAddr=$cols[1];
			}
			//var_dump($line);
		}
		
		
		return $macAddr;
	}
	function load_login_admin_view($content_view = null){		
		$this->_ci->load->model('profil_aplikasi_model');
		$this->_ci->load->library('encrypt_decrypt');
		$this->_ci->dataProfilAplikasi = $this->_ci->profil_aplikasi_model->getData();
		
		/**
		$date_now = date("Y-m-d");

		if ($date_now > $this->_ci->dataProfilAplikasi->tanggal) {
			$ready = $this->_ci->encrypt_decrypt->getText('decrypt', $this->_ci->dataProfilAplikasi->token);
			
			if($ready != 's4s1s'){
				redirect(base_url()."expired");
			}
		}
		**/
		
		$this->_ci->load->view($content_view);       
	}
	function load_view($content_view = null){		
		$this->_ci->load->model('profil_aplikasi_model');	
		$this->_ci->load->model('m_user_model');	
		$this->_ci->dataProfilAplikasi = $this->_ci->profil_aplikasi_model->getData();
		$this->_ci->dataPegawaiSession = $this->_ci->m_user_model->getData(array( 'm_user.id_user' => $this->_ci->session->userdata('id_user')));
		
		$this->_ci->menu 		= false;
		$this->_ci->siswa		= true;
		$this->_ci->menu_siswa	= false;
		$this->_ci->load->view('template/header_view');
		$this->_ci->load->view($content_view);
		$this->_ci->load->view('template/footer_view');        
	}
	
	function load_siswa_view($content_view = null){		
		$this->_ci->load->model('profil_aplikasi_model');	
		$this->_ci->load->model('m_user_model');	
		$this->_ci->dataProfilAplikasi = $this->_ci->profil_aplikasi_model->getData();
		$this->_ci->dataPegawaiSession = $this->_ci->m_user_model->getData(array( 'm_user.id_user' => $this->_ci->session->userdata('id_user')));
		
		$this->_ci->menu 		= false;
		$this->_ci->siswa		= true;
		$this->_ci->menu_siswa	= true;
		$this->_ci->load->view('template/header_view');
		$this->_ci->load->view($content_view);
		$this->_ci->load->view('template/footer_view');        
	}
	
	
	function load_admin_view($content_view = null){
		
		$this->_ci->load->model('profil_aplikasi_model');	
		$this->_ci->load->model('m_user_model');	
		$this->_ci->dataProfilAplikasi = $this->_ci->profil_aplikasi_model->getData();
		$this->_ci->dataPegawaiSession = $this->_ci->m_user_model->getData(array( 'm_user.id_user' => $this->_ci->session->userdata('id_user')));
		
		$this->_ci->menu 	= true;
		$this->_ci->siswa	= false;
		$this->_ci->menu_siswa	= false;
		$this->_ci->load->view('template/header_slide_kiri_view');
		$this->_ci->load->view($content_view);
		$this->_ci->load->view('template/footer_slide_kiri_view');       
	}
	
	function cek_downline_menu($id_menu){		
		$this->_ci->load->model('m_menu_model');
		
		$whereDownlineMenu 	= array('id_parent_menu' => $id_menu);
		$dataTopMenu  		= $this->_ci->m_menu_model->showData($whereDownlineMenu);
		
		return count($dataTopMenu);		
	}
	
	function load_menu($id_kategori_user){
		if(!$id_kategori_user){
			redirect('admin');
		}
		
		$this->_ci->load->model('t_hak_akses_model');
		$this->_ci->load->model('m_menu_model');
		
		$whereTopMenu 	= array('t_hak_akses.id_kategori_user' => $id_kategori_user, 'm_menu.id_parent_menu' => '0');
		$dataTopMenu  		= $this->_ci->t_hak_akses_model->showData($whereTopMenu );
		
		$dataAktifMenu  	= $this->_ci->m_menu_model->getDataAkses($this->_ci->uri->segment('2'));
		//echo $this->_ci->db->last_query();
		//var_dump($dataAktifMenu);exit();
		if($dataAktifMenu->tingkat_menu == '3'){
			$idAktifMenuDua  	= $dataAktifMenu->id_parent_menu;
			
			$dataAktifMenuSatu 	=	 $this->_ci->m_menu_model->getData(array('id_menu' => $dataAktifMenu->id_parent_menu));
			$idAktifMenuSatu  	= 	$dataAktifMenuSatu->id_parent_menu;
			$idAktifMenuTiga	=	"";
		}
		else{
			if($dataAktifMenu->tingkat_menu == '2'){
				$idAktifMenuDua		=	"";
				$idAktifMenuSatu  	= 	$dataAktifMenu->id_parent_menu;				
				$idAktifMenuTiga	=	"";
			}
			else{
				$idAktifMenuDua		=	"";
				$idAktifMenuSatu	=	$dataAktifMenu->id_menu;
				$idAktifMenuTiga	=	$dataAktifMenu->id_menu;
			}
		}
		
		//var_dump( $idAktifMenuSatu);exit();
		$menuHtml		=	"";
			foreach($dataTopMenu as $data){
				$cekDownlineMenu = $this->cek_downline_menu( $data->id_menu );
				//var_dump($cekDownlineMenu); 
				
				if($cekDownlineMenu == '0'){
					$urlTopMenu	=	base_url()."".$data->link_menu;
					$classTopMenuHref	=	"";
					if($idAktifMenuSatu == $data->id_menu ){
						$classTopMenuLi		=	"nav-item active open";
					}
					else{
						
					$classTopMenuLi		=	"";
					}
					$arrow				=	"";
					
				}
				else{
					$urlTopMenu			=	"javascript:;";
					if($idAktifMenuSatu == $data->id_menu ){
						$classTopMenuLi		=	"nav-item active open";
					}
					else{
						$classTopMenuLi		=	"nav-item";
					}
					$classTopMenuHref	=	"nav-link nav-toggle";
					$arrow				=	"<span class='arrow'></span>";
				}
				
				$menuHtml .= "
				<li  class='".$classTopMenuLi."'>
					<a href='".$urlTopMenu."' class='".$classTopMenuHref."'>
						<i class='".$data->icon_menu."'></i><span class='title'> ".$data->nm_menu."</span>
                        <span class='selected'></span>".$arrow."
					</a>
				";
					
					if($cekDownlineMenu > 0){
						$whereSecondMenu 	= array('t_hak_akses.id_kategori_user' => $id_kategori_user, 'm_menu.id_parent_menu' => $data->id_menu);
						$secondMenu  	= $this->_ci->t_hak_akses_model->showData($whereSecondMenu );
						
						//echo $this->_ci->db->last_query();
						
						$menuHtml		.=	'<ul class="sub-menu">';
							foreach($secondMenu as $dataSecondMenu){
								$cekDownlineSecondMenu = $this->cek_downline_menu( $dataSecondMenu->id_menu );
								
								if($cekDownlineSecondMenu == '0'){
									$urlSecondMenu	=	base_url()."".$dataSecondMenu->link_menu;
									$classSecondMenuHref	=	"nav-link";
									$classSecondMenuLi		=	"";
									$arrowSecond		=	"";
									
								}
								else{
									$urlSecondMenu			=	"javascript:;";
									if($idAktifMenuDua == $dataSecondMenu->id_menu ){
										$classSecondMenuLi		=	"nav-item active open";
									}
									else{
										$classSecondMenuLi		=	"nav-item";
									}
									$classSecondMenuHref	=	"nav-link nav-toggle";
									$arrowSecond		=	"<span class='arrow'></span>";
								}
				
								$menuHtml .= "
								<li  class='".$classSecondMenuLi."'>
									<a href='".$urlSecondMenu."' class='".$classSecondMenuHref."'>
										<i class='".$dataSecondMenu->icon_menu."'></i><span class='title'> ".$dataSecondMenu->nm_menu."</span>
										<span class='selected'></span>".$arrowSecond."
									</a>
								";
									
									
									
									if($cekDownlineSecondMenu > 0){
										$whereThirdMenu 	= array('t_hak_akses.id_kategori_user' => $id_kategori_user, 'm_menu.id_parent_menu' => $dataSecondMenu->id_menu);
										$thirdMenu  	= $this->_ci->t_hak_akses_model->showData($whereThirdMenu );
										
										//echo $this->_ci->db->last_query();
										
										$menuHtml		.=	'<ul class="sub-menu">';
											foreach($thirdMenu as $dataThirdMenu){
												$cekDownlineThirdMenu = $this->cek_downline_menu( $dataThirdMenu->id_menu );
												
												if($cekDownlineThirdMenu == '0'){
													$urlThirdMenu	=	base_url()."".$dataThirdMenu->link_menu;
													
													if($idAktifMenuTiga == $dataThirdMenu->id_menu){
														$classThirdMenuHref	=	"nav-link  active open";
													}
													else{
														$classThirdMenuHref	=	"nav-link";
													}
													
													$classThirdMenuLi		=	"";
													
												}
												else{
													
													
													$urlThirdMenu			=	"javascript:;";
													$classThirdMenuLi		=	"nav-item";
													$classThirdMenuHref		=	"nav-link nav-toggle";
												}
								
												$menuHtml .= "
												<li aria-haspopup='true' class='".$classThirdMenuLi."'>
													<a href='".$urlThirdMenu."' class='".$classThirdMenuHref."'>
														<i class='fa fa-arrows-h'></i> ".$dataThirdMenu->nm_menu."
													</a>
												";					
												
												$menuHtml .= "
												</li>
												";
											}
										$menuHtml .= "
										</ul>
										";
									}
								$menuHtml .= "
								</li>
								";
							}
						$menuHtml .= "
						</ul>
						";
					}
				$menuHtml .= "
				</li>
				";
			}
			
			
		echo $menuHtml;
	
	}

}
