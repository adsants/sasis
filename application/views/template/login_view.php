
                

<div class="page-content">
	<div class="container">	
		<div class="row">											
			<div class="col-md-6 col-md-offset-3">
			
				<div class="portlet light box-login">
					<div class="portlet-title text-center">
						<h3>Form Login Admin</h3>
					</div>
					<div class="portlet-body form">
						<br>
						<form class="form-horizontal" method="post" action="<?=base_url();?>admin/authentication" role="form">
								
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Username</label>
								<div class="col-md-9">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<input type="input" name="user_name" required  oninvalid="this.setCustomValidity('Inputkan Username')" autocomplete="false" oninput="setCustomValidity('')" value="<?=$this->session->flashdata('user_name')?>" class="form-control" placeholder="Username"> </div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-lock"></i>
										</span>
										<input type="password" name="pass_word" required oninvalid="this.setCustomValidity('Inputkan Password')"  autocomplete="false"  oninput="setCustomValidity('')" class="form-control" placeholder="Password"> </div>
								</div>
							</div>
							
								<div class="form-group">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn btn-success">Login</button>
									</div>
								</div>
						</form>
					</div>
				</div>
			</div>											
		</div>
	</div>
</div>
						
			
			