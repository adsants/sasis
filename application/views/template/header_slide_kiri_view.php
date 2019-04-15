<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Sahabat Siswa (SASIS)</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #3 for " name="description" />
        <meta content="" name="author" />
		
        <style>
		@font-face {
			font-family: 'Open Sans';
			font-style: normal;
			font-weight: 300;
			src: local('Open Sans Regular'), local('OpenSans-Regular'), url(<?=base_url();?>assets/fonts/OpenSans-Regular.ttf) format('truetype');
		}
		</style>
	    <link href="<?=base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?=base_url();?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?=base_url();?>assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?=base_url();?>assets/layouts/layout/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?=base_url();?>assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
		
		
		
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
		
        <link href="<?=base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
		
        <link href="<?=base_url();?>assets/css/tambahan.css" rel="stylesheet" type="text/css" />
		
		
		 <script src="<?=base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		 
        <script src="<?=base_url();?>assets/global/plugins/pulsate.js" type="text/javascript"></script>
		
		<link href="<?=base_url();?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
		
        <link href="<?=base_url();?>assets/css/BootSideMenu.css" rel="stylesheet" type="text/css" />
		<style>
		.page-content-inner{
			margin-top:35px;
		}
		
		body{
		font-size:16px;
			
		}
		</style>
        <link rel="shortcut icon" href="favicon.ico" /> </head>

    <body class="page-container-bg-solid">
            <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
						
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
						<div id="text_logo" style="color:#36c6d3;background: -webkit-linear-gradient(#36c6d3, #fff); -webkit-background-clip: text;  -webkit-text-fill-color: transparent;font-weight:bold;float:left;margin-top:15px;text-align:left;margin-left:15px;"><i class="fa fa-mortar-board"></i> &nbsp;&nbsp; Sahabat Siswa (SASIS)</div>
						<ul class="nav navbar-nav pull-right">
                    
                           
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<i class="fa fa-user"></i>&nbsp;
									
									<span class="username username-hide-on-mobile"> <?=$this->session->userdata('nama');?> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="<?=$this->template_view->base_url_admin();?>/dashboard/profil">
                                            <i class="icon-user"></i> Ganti Password</a>
                                    </li>
                                    <li>
                                        <a onclick="show_confirmation_modal('<p>Apakah anda yakin akan keluar ..?</p>','<?=base_url();?>logout')">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
							</li>
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                          
                           
                           <br>
						   
							<li  class=''>
								<a href='' class=''>
									<span class='title text-success text-bold'> 
										<center>
										<img style="margin-top:10px;" title="Logo" width="120px" src="<?=base_url();?>upload/logo/<?=$this->dataProfilAplikasi->icon;?>">
										<br>
										<strong><?=$this->dataProfilAplikasi->nm_aplikasi;?></strong>
										<br>
										<br>
										</center>
									</span>
								</a>
							
							</li>
							
							
										
							<?php 
							//var_dump($this->dataProfilAplikasi);
							if($this->menu){
								$this->load->view('template/menu_view');
							}
							?>
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">