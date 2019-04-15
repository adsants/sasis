<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori_user extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->session_lib->admin();
		
		$this->load->model('kategori_user_model');
		$this->load->model('t_hak_akses_model');
	} 

	public function index(){
		
		$like 		= null;
		$urlSearch 	= null;
		$order_by	=	"nm_kategori_user";

		if($this->input->get('search')){
			$urlSearch 	= 	"?search=".$_GET['search'];
			$like		=	$this->input->get('search');			
		}

		$config['base_url'] 	= base_url().'backoffice/'.$this->uri->segment(2).'/index'.$urlSearch;
		
		$this->jumlahData 		= $this->kategori_user_model->showData("",$like);
		$config['total_rows'] 	= count($this->jumlahData);
		$config['per_page'] 	= 10;
		
		$this->showData 		= $this->kategori_user_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);		
		
		$this->template_view->load_admin_view('master/kategori_user/kategori_user_view');
	}
	
	public function add(){
		$this->template_view->load_admin_view('master/kategori_user/kategori_user_add_view');
	}
	
	public function insert(){
		$this->form_validation->set_rules('nm_kategori_user', 'Nama Kategori User', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
		}
		else{							
		
			$data['nm_kategori_user'] 			= $this->input->post('nm_kategori_user');		
		
			$newid = $this->kategori_user_model->insert($data);
			
			if($newid){
				$this->notice->success("Proses Tambah Data Kategori User berhasil, silahkan pilih Hak Akses menu untuk Kategori User : ".$this->input->post('nm_kategori_user'));						
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$newid);
			}
			else{				
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Tambah Data Kategori User Gagal, silahkan cek inputan Anda.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add");
			}			
		}
		
		
	}
	public function edit($IdPrimaryKey){
		$where =array('id_kategori_user' => $IdPrimaryKey);
		$orderBy = 'urutan_menu';
		$this->dataForUpdate = $this->kategori_user_model->getData($where);		
		if(!$this->dataForUpdate){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		$this->load->model('menu_model');
		$this->load->model('t_hak_akses_model');
		$this->checkboxMenu = "<div class='col-sm-9 col-sm-offset-3'><table class='table table-bordered' width='100%'><thead><tr><td align='center'><div class='checkbox'><label><input type='checkbox' id='checkAllDelete' onclick='checkAllDeleteButton()'> &nbsp;Nama Menu</label></div> </td><td>Tambah</td><td>Ubah</td><td>Hapus</td></tr></thead><tbody>";
		$whereMenuSatu = array('id_parent_menu' => '0');
		foreach( $this->menu_model->showData($whereMenuSatu,'',$orderBy) as $menuSatu){
			$whereDataSatu =array('t_hak_akses.id_kategori_user' => $IdPrimaryKey, 't_hak_akses.id_menu' => $menuSatu->id_menu);
			$dataSatu = $this->t_hak_akses_model->getData($whereDataSatu);
			
			if($dataSatu){
				$aktifMenuSatu = "checked";
				if($dataSatu->insert_akses == 'Y'){
					$addAktifSatu = "checked";
				}
				else{
					$addAktifSatu = "";
				}
				if($dataSatu->edit_akses == 'Y'){
					$editAktifSatu = "checked";
				}
				else{
					$editAktifSatu = "";
				}
				if($dataSatu->delete_akses == 'Y'){
					$deleteAktifSatu = "checked";
				}
				else{
					$deleteAktifSatu = "";
				}
			}
			else{
				$aktifMenuSatu = "";
				$addAktifSatu = "";
				$editAktifSatu = "";
				$deleteAktifSatu = "";
			}
			
			
			$this->checkboxMenu.= "<tr><td><div class='checkbox'><label><input ".$aktifMenuSatu." type='checkbox' value='".$menuSatu->id_menu."' name='id_menu[]'>".$menuSatu->nm_menu."</label></div></td>";
			if($menuSatu->link_menu!=""){
				if($menuSatu->insert_akses == "Y"){
					$this->checkboxMenu.= "<td align='center'><input ".$addAktifSatu." type='checkbox' name='add_".$menuSatu->id_menu."' value='Y'></td>";
				}
				else{
					$this->checkboxMenu.= "<td></td>";
				}
				if($menuSatu->edit_akses == "Y"){
					$this->checkboxMenu.= "<td align='center'><input ".$editAktifSatu." type='checkbox' name='edit_".$menuSatu->id_menu."' value='Y'></td>";
				}
				else{
					$this->checkboxMenu.= "<td></td>";
				}
				if($menuSatu->delete_akses == "Y"){
					$this->checkboxMenu.= "<td align='center'><input ".$deleteAktifSatu." type='checkbox' name='delete_".$menuSatu->id_menu."' value='Y'></td>";
				}
				else{
					$this->checkboxMenu.= "<td></td>";
				}
				
			}
			else{
				$this->checkboxMenu.="<td colspan='3'></td>";
			}
			
			$this->checkboxMenu.= "</tr>";
			
			////////////////////// ---> Menu Dua <---------- ////////////////
			$whereMenuDua = array('id_parent_menu' => $menuSatu->id_menu , 'aktif_menu' => 'Y');
			foreach( $this->menu_model->showData($whereMenuDua,'',$orderBy) as $menuDua){
				$whereDataDua =array('t_hak_akses.id_kategori_user' => $IdPrimaryKey, 't_hak_akses.id_menu' => $menuDua->id_menu);
				$dataDua = $this->t_hak_akses_model->getData($whereDataDua);
				
				if($dataDua){
					$aktifMenuDua = "checked";
					if($dataDua->insert_akses == 'Y'){
						$addAktifDua = "checked";
					}
					else{
						$addAktifDua = "";
					}
					if($dataDua->edit_akses == 'Y'){
						$editAktifDua = "checked";
					}
					else{
						$editAktifDua = "";
					}
					if($dataDua->delete_akses == 'Y'){
						$deleteAktifDua = "checked";
					}
					else{
						$deleteAktifDua = "";
					}
				}
				else{
					$aktifMenuDua = "";
					$addAktifDua = "";
					$editAktifDua = "";
					$deleteAktifDua = "";
				}
				
				$this->checkboxMenu.= "<tr><td><div class='col-sm-6 col-sm-offset-1'><div class='checkbox'><label><input type='checkbox' ".$aktifMenuDua." value='".$menuDua->id_menu."' name='id_menu[]'>".$menuDua->nm_menu."</label></div></div></td>";
				if($menuDua->link_menu!=""){
					if($menuDua->insert_akses == "Y"){
						$this->checkboxMenu.= "<td align='center'><input ".$addAktifDua." type='checkbox' name='add_".$menuDua->id_menu."' value='Y'></td>";
					}
					else{
						$this->checkboxMenu.= "<td></td>";
					}
					if($menuDua->edit_akses == "Y"){
						$this->checkboxMenu.= "<td align='center'><input ".$editAktifDua." type='checkbox' name='edit_".$menuDua->id_menu."' value='Y'></td>";
					}
					else{
						$this->checkboxMenu.= "<td></td>";
					}
					if($menuDua->delete_akses == "Y"){
						$this->checkboxMenu.= "<td align='center'><input type='checkbox' ".$deleteAktifDua." name='delete_".$menuDua->id_menu."' value='Y'></td>";
					}
					else{
						$this->checkboxMenu.= "<td></td>";
					}
					
				}
				else{
					$this->checkboxMenu.="<td colspan='3'></td>";
				}
				
				$this->checkboxMenu.= "</tr>";
				
				//////////////////--> Menu Tiga <--- ///////////////////
				$whereMenuTiga = array('id_parent_menu' => $menuDua->id_menu);
				foreach( $this->menu_model->showData($whereMenuTiga) as $menuTiga){
					
					$whereDataTiga =array('t_hak_akses.id_kategori_user' => $IdPrimaryKey, 't_hak_akses.id_menu' => $menuTiga->id_menu);
					$dataTiga = $this->t_hak_akses_model->getData($whereDataTiga);
					
					
					
					if($dataTiga){
						$aktifMenuTiga = "checked";
						if($dataTiga->insert_akses == 'Y'){
							$addAktifTiga = "checked";
						}
						else{
							$addAktifTiga = "";
						}
						if($dataTiga->edit_akses == 'Y'){
							$editAktifTiga = "checked";
						}
						else{
							$editAktifTiga = "";
						}
						if($dataTiga->delete_akses == 'Y'){
							$deleteAktifTiga = "checked";
						}
						else{
							$deleteAktifTiga = "";
						}
					}
					else{
						$aktifMenuTiga = "";
						$addAktifTiga = "";
						$editAktifTiga = "";
						$deleteAktifTiga = "";
					}
					
					$this->checkboxMenu.= "<tr><td><div class='col-sm-6 col-sm-offset-2'><div class='checkbox'><label><input type='checkbox' ".$aktifMenuTiga." value='".$menuTiga->id_menu."' name='id_menu[]'>".$menuTiga->nm_menu."</label></div></div></td>";
					if($menuTiga->link_menu!=""){
						if($menuTiga->insert_akses == "Y"){
							$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='add_".$menuTiga->id_menu."' ".$addAktifTiga." value='Y'></td>";
						}
						else{
							$this->checkboxMenu.= "<td></td>";
						}
						if($menuTiga->edit_akses == "Y"){
							$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='edit_".$menuTiga->id_menu."' ".$editAktifTiga." value='Y'></td>";
						}
						else{
							$this->checkboxMenu.= "<td></td>";
						}
						if($menuTiga->delete_akses == "Y"){
							$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='delete_".$menuTiga->id_menu."' ".$deleteAktifTiga." value='Y'></td>";
						}
						else{
							$this->checkboxMenu.= "<td></td>";
						}
						
					}
					else{
						$this->checkboxMenu.="<td colspan='3'></td>";
					}
					
					$this->checkboxMenu.= "</tr>";
					
				
				}
			}
		}
		$this->checkboxMenu .= "</tbody></table></div>";
		
		$this->template_view->load_admin_view('master/kategori_user/kategori_user_edit_view');
	}
	
	
	
	public function update($primaryKey = null){
		if(!$primaryKey){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}	
			
		$this->form_validation->set_rules('nm_kategori_user', 'Nama Kategori User', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			$this->session->set_flashdata($this->input->post());
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
		}
		else{				
			
			$this->db->trans_start();
		
			$data['nm_kategori_user'] 	= $this->input->post('nm_kategori_user');		
			$queryUpdate				= $this->kategori_user_model->update($primaryKey,$data);
						
			$queryDelete				= $this->t_hak_akses_model->delete($primaryKey);
			
			foreach($this->input->post('id_menu') as $id_menu){
				
				if($this->input->post('add_'.$id_menu)){
					$add	=	'Y';
				}
				else{
					$add	=	'N';
				}
				
				if($this->input->post('edit_'.$id_menu)){
					$edit	=	'Y';
				}
				else{
					$edit	=	'N';
				}
				
				if($this->input->post('delete_'.$id_menu)){
					$delete	=	'Y';
				}
				else{
					$delete	=	'N';
				}
				
				$dataHakAkses['ID_KATEGORI_USER'] 	= $primaryKey;	
				$dataHakAkses['id_menu'] 			= $id_menu;	
				$dataHakAkses['insert_akses'] 		= $add;	
				$dataHakAkses['edit_akses'] 		= $edit;	
				$dataHakAkses['delete_akses'] 		= $delete;	
				
				$this->t_hak_akses_model->insert($dataHakAkses);
				
			}
						
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata($this->input->post());
				$this->notice->warning("Proses Ubah Data Kategori User Gagal, silahkan cek inputan Anda.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$primaryKey);
				
			}
			else{				
				$this->notice->success("Proses Ubah Data  Kategori User berhasil.");				
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
		}
	}
	
	
	public function delete($IdPrimaryKey){
		$this->db->trans_start();
		
		$this->kategori_user_model->delete($IdPrimaryKey);		
		$this->t_hak_akses_model->delete($IdPrimaryKey);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE){
			$this->session->set_flashdata($this->input->post());
			$this->notice->warning("Proses Hapus Data Kategori User Gagal, silahkan cek inputan Anda.");				
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			
		}
		else{				
			$this->notice->success("Proses Hapus Data  Kategori User berhasil.");				
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}		
	}

}
