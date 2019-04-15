<div class="page-header-menu">
	<div class="container">
				
	
		<div class="hor-menu  ">
			<ul class="nav navbar-nav">
				<li class="menu-dropdown classic-menu-dropdown">
					<a href="<?=base_url();?>siswa/dashboard"> 
						<i class="fa fa-home"></i> Beranda
					</a>			
				</li>
				<li class="menu-dropdown classic-menu-dropdown">
					<a href="<?=base_url();?>siswa/riwayat_ujian"> 
						<i class="fa fa-history"></i> Riwayat Ujian
					</a>			
				</li>
				
				<!--<li class="menu-dropdown classic-menu-dropdown">
					<a href="<?=base_url();?>siswa/profil"> 
						<i class="fa fa-user"></i> Profil Saya
					</a>			
				</li>
				-->
				<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
					<a onclick="show_confirmation_modal('<p>Apakah anda yakin akan keluar ..?</p>','<?=base_url();?>logout_siswa')"> 
						<i class="fa fa-lock"></i> Logout
					</a>			
				</li>
				
				 
			</ul>
			
		</div>
		<!-- END MEGA MENU -->

	</div>
</div>