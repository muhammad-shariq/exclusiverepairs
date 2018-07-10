<!doctype html>
<html>
<head>
<title>Login | GSM Workshop Plus</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url(); ?>assets/favicon.ico" type="image/x-icon">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url(); ?>assets/styles/styles.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/customstyles.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/parsley.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/dataTables.bootstrap.css" rel="stylesheet"/>
<!--Scripts--> 
<script type="text/javascript" src="http://code.jquery.com/jquery-1.12.0.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.3.0.min.js"></script> 
</head>
<body>
<!--SuperDiv [Start]-->
<div id="superdiv">
	<!--
	<header id="header">
		<div class="container">
			<div class="row">
				<aside class="logo pull-left">
                	<img src="<?/*php echo base_url(); */?>assets/images/logo.png" alt="GSM Workshop Plus" height="85">
                </aside>
            </div>
        </div>
    </header>-->
	
	<!--Content [Start]-->
	<div id="content">
		<div class="container">
			<div class="row">
				<!--Login section [Start]-->
				<div class="sc-register" id="login">
                    <aside class="logo text-center">
                        <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="GSM Workshop Plus" height="85">
                    </aside><br>
					<div class="col-md-5 col-xs-12 fn mauto">
						<div class="rbox">
							<h2 class="txt-center">Administrator</h2>
							<h3 class="txt-center bold">Login</h3>
	                        <?php
	                        if($this->input->get('action') != 'forgot_password') {
	                            ?>
	                            <?php $this->load->view('errors/message'); ?>
	                        <?php
	                        }
	                        ?>
							<?php echo form_open('login', array('class' => "col-md-10 fn mauto", 'data-parsley-validate' => "" )); ?>
							<input type="hidden" name="return_url" value="<?php echo $this->input->get('return_url'); ?>" style="display:none;" />
								<div class="form-group">
									<input name="username" type="text" placeholder="Username" class="form-control" required minlength="4" maxlength="32">
								</div>
								
								<div class="form-group">
									<input name="password" type="password" placeholder="Password" class="form-control" required minlength="4" maxlength="32">
								</div>
								<div class="form-group">
									<input type="submit" value="Login" class="btn btn-primary fn dpTable mauto">
								</div>
								
								<div class="txt-center">
									<a href="javascript:void(0);" onclick="javascript:toggleBlocks('forgotPassword');">Forgot Password</a>
								</div>
							<?php echo form_close(); ?>
						</div>	
					</div>
				</div><!--Login section [Start]-->
				<!--Forgot Password section [Start]-->
				<div class="sc-register" id="forgotPassword" style="display: none">
					<div class="col-md-5 col-xs-12 fn mauto">
						<div class="rbox">
						<h2 class="txt-center">Administrator</h2>
						<h3 class="txt-center bold">Retrieve Password</h3>
                        <?php
                        if($this->input->get('action') == 'forgot_password') {
                           $this->load->view('errors/message'); ?>
                        <?php
                        }
                        ?>
						<?php echo form_open('forgot_password', array('class' => "col-md-10 fn mauto pad-5", 'data-parsley-validate' => "" )); ?>
							<div class="form-group">
								<input name="Email" type="email" placeholder="Email Address" class="form-control" required>
							</div>

							<div class="form-group">
								<input type="submit" value="Retrieve Password" class="btn btn-default fn dpTable mauto">
							</div>

							<div class="txt-center">
								<a href="javascript:void(0);" onclick="javascript:toggleBlocks('login');">Back to login</a>
							</div>
						<?php echo form_close(); ?>
						</div>
					</div>
				</div><!--Forgot Password section [Start]-->

			</div><!--/row-->
		</div><!--/container-->
	</div><!--Content [END]-->
	
</div><!--SuperDiv [END]-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/parsley.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/settings.js"></script>
<script type="application/javascript">
function toggleBlocks(val)
{
    if(val != '')
    {
        if(val == 'forgotPassword')
        {
            $('#login').hide(1000);
            $('#forgotPassword').show(1000);
        }
        else if(val == 'login')
        {
            $('#forgotPassword').hide(1000);
            $('#login').show(1000);
        }


    }
}
<?php if((isset($forgotPassword) && $forgotPassword == true) || $this->input->get('action') == 'forgot_password'): ?>
window.onload = function(e) {
    toggleBlocks('forgotPassword');
};
<?php endif ?>
</script>
</body>
</html>