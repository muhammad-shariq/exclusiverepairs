<div id="content">
	<div class="container">
		<div class="row">
			<?php $this->load->view('errors/message'); ?>
			<!-- Dashboard [Start] -->
			<div id="dashboard">
				<!-- Start -->
				<div class="box col-md-3">
					<div class="cnt">
						<input class="knob" 
						data-width="110"
						data-height="110"
						data-thickness=".1"
						data-fgColor="#1E3C49"
						data-bgColor="#706d64"
						data-displayInput="false"
						value="100"
						autocomplete="off">
						<div class="status"><?php echo $total_customers ?></div>
						<h4>Customers</h4>
						<a href="<?php echo site_url('customer') ?>">View All</a>
					</div>
				</div>
				<!-- END -->			
				<!-- Start -->
				<div class="box col-md-3">
					<div class="cnt">
						<input class="knob" 
						data-width="110"
						data-height="110"
						data-thickness=".1"
						data-fgColor="#1E3C49"
						data-bgColor="#706d64"
						data-displayInput="false"
						value="<?php echo(empty($total_jobs)?'0':$pending_jobs/$total_jobs * 100); ?>"
						autocomplete="off">
						<div class="status"><?php echo $pending_jobs; ?></div>
						<h4>Pending Jobs</h4>
						<a href="<?php echo site_url('job'); ?>">View All</a>
					</div>
				</div>
				<!-- END -->
			
				<!-- Start -->
				<div class="box col-md-3">
					<div class="cnt">
						<input class="knob" 
						data-width="110"
						data-height="110"
						data-thickness=".1"
						data-fgColor="#1E3C49"
						data-bgColor="#706d64"
						data-displayInput="false"
						value="<?php echo(empty($total_jobs)?'0':$ready_jobs/$total_jobs * 100); ?>"
						autocomplete="off">
						<div class="status"><?php echo $ready_jobs; ?></div>
						<h4>Completed Jobs</h4>
						<a href="<?php echo site_url('job'); ?>">View All</a>
					</div>
				</div>
				<!-- END -->

				<!-- Start -->
				<div class="box col-md-3">
					<div class="cnt">
						<input class="knob" 
						data-width="110"
						data-height="110"
						data-thickness=".1"
						data-fgColor="#1E3C49"
						data-bgColor="#706d64"
						data-displayInput="false"
						value="<?php echo(empty($weekly_stats->income)?'0':$weekly_stats->profit/$weekly_stats->income * 100); ?>"
						autocomplete="off">
						<div class="status"><?php echo $weekly_stats->profit; ?></div>
						<h4>Weekly Profit</h4>
						<a href="<?php echo site_url('job'); ?>">View All</a>
					</div>
				</div>
				<!-- END -->				
			
				<div class="clearfix"></div><br>
			
			</div><!-- Dashboard [END] -->
		</div><!--/row-->
	</div><!--/container-->
</div>
<script>
    $(function($){
    	//Graph
        $(".knob").knob({
            draw 	: function (){},
            readOnly: true
        });
    });
</script>
