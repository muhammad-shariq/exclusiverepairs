<!doctype html>
<html>
<head>
<title><?php echo $page_title; ?> | GSM Workshop Plus</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url(); ?>assets/favicon.ico" type="image/x-icon">
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url(); ?>assets/styles/styles.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/customstyles.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/parsley.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/magnific-popup.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/dataTables.bootstrap.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/styles/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/styles/chosen.css" rel="stylesheet">

<!--Scripts--> 
<script type="text/javascript" src="//code.jquery.com/jquery-1.12.0.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.3.0.min.js"></script> 
</head>
<body>
<!--SuperDiv [Start]-->
<div id="superdiv"> 
  <!--Header [Start]-->
  <header id="header">
    <div class="container">
      <div class="row"> 
        <!--Logo-->
        <aside class="logo pull-left"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="GSM Workshop Plus" height="85" ></aside>
        <div class="usrOpt no-pad col-md-6 pull-right">
        <?php if( $this->session->userdata('is_logged_in') ===  TRUE ): ?>
          <!-- Status Bar [Start] -->
          <div class="statusBar"> <span class="pull-left">Welcome <?php echo $this->session->name; ?></span>
            <div class="dropdown pull-left"> <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="pad-5 btn-useropt cursor"> <i class="fa fa-angle-down"></i> </a> |
              <ul class="dropdown-menu useroptMenu" aria-labelledby="dLabel">
                <li><a data-toggle="modal" data-target="#password-popup" href="#password-popup" class="open-popup-link">Change Password</a></li>
              </ul>
            </div>
            <a href="<?php echo site_url("logout"); ?>" class="pad-5 f12"><i class="fa fa-sign-out"></i> Logout</a> </div>
          <!-- Status Bar [END] 
          <a href="<?php echo site_url("dashboard"); ?>" class="btn btn-default active pull-right">Dashboard</a>-->  
          <?php if($this->session->is_admin): ?>
          <!-- office Drop Down-->
          <div class="dropdown pull-right"> <a id="office" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default btn-dropDown"> All Location <i class="fa fa-angle-down"></i> </a>
            <?php if(count($offices)>0): ?>
            <ul class="dropdown-menu useroptMenu" aria-labelledby="dLabel">
              <li><a href="<?php echo site_url("employee/office/"); ?>?office_id=0&return_url=<?php echo str_replace($this->config->item('url_suffix'), "", current_url()) ?>">All Location</a></li>
              <?php foreach ($offices as $v) : ?>
              <li><a href="<?php echo site_url("employee/office/"); ?>?office_id=<?php echo $v['id']; ?>&return_url=<?php echo str_replace($this->config->item('url_suffix'), "", current_url()) ?>"><?php echo $v['title']; ?></a></li>
              <?php if($this->session->office_id == $v['id']): ?>
              <script>$('#office').html('<?php echo $v['title']; ?>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>');</script>
              <?php endif;  ?>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        <?php endif; ?>
        </div>
      </div>
      <!--/row--> 
    </div>
    <!--/container--> 
    <!-- Main Menu [Start] -->
    <nav id="mainMenu">
      <div class="container">
        <div class="row">
          <ul class="topMenu">
            <li <?php echo($this->uri->segment(1) == 'dashboard'?'class="active"':''); ?>> <a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i><br>
              Dashboard</a> </li>
            
            <li <?php echo($this->uri->segment(1) == 'job'?'class="active"':''); ?>> <a href="<?php echo site_url('job'); ?>"><i class="fa fa-book"></i><br>
              Bookings</a> </li>
            
            <li <?php echo($this->uri->segment(1) == 'customer'?'class="active"':''); ?>> <a href="<?php echo site_url('customer'); ?>"><i class="fa fa-users"></i><br>
              Customers</a> </li>
            
            <li <?php echo($this->uri->segment(1) == 'employee'?'class="active"':''); ?>> <a href="<?php echo site_url('employee'); ?>"><i class="fa fa-user-secret"></i><br>
              Employees</a> </li>
            
            <li <?php echo($this->uri->segment(1) == 'brand'?'class="active"':''); ?>> <a href="<?php echo site_url('brand'); ?>"><i class="fa fa-cog"></i><br>
              Brands</a> </li>

            <li <?php echo($this->uri->segment(1) == 'model'?'class="active"':''); ?>> <a href="<?php echo site_url('model'); ?>"><i class="fa fa-cogs"></i><br>
              Brand Models</a> </li>

            <li <?php echo($this->uri->segment(1) == 'email'?'class="active"':''); ?>> <a href="<?php echo site_url('email'); ?>"><i class="fa fa-envelope"></i><br>
              Email Templates</a> </li>
          </ul>
        </div>
        <!--/row--> 
      </div>
      <!--/container--> 
    </nav>
    <!-- Main Menu [END] --> 
  </header>
  <!--Header [END]--> 
  <!--Content [Start]-->
  <?php $this->load->view('errors/message'); ?>
  <?php $this->load->view($template); ?>
  <!--Content [END]--> 
</div>
<!--SuperDiv [END]-->
<?php if( $this->session->userdata('is_logged_in') ===  TRUE ): ?>
<!-- Modal -->
<div class="modal fade" id="password-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<?php echo form_open('employee/change_password', array('class' => "col-md-10 fn mauto", 'data-parsley-validate' => "" )); ?>
		<input type="hidden" name="return_url" value="<?php echo str_replace($this->config->item('url_suffix'), "", current_url()); ?>" style="display:none;" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
		<div class="popGrid">
			<div class="form-group">
				<input name="password" type="password" placeholder="New Passsword" class="form-control" id="password" value="" required minlength="3" maxlength="32">
			</div>
			<div class="form-group">
				<input name="re-password" type="password" placeholder="Confirm Password" class="form-control" required minlength="3" maxlength="32" data-parsley-equalto="#password">
			</div>			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Change Password</button>
      </div>
	  <?php echo form_close(); ?> 
    </div>
  </div>
</div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/parsley.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.knob.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.magnific-popup.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/chosen.jquery.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/settings.js"></script>
</body>
</html>