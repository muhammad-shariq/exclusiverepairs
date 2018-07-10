<?php	if($this->session->flashdata('warning') != ""){ ?>
                <div class="alertMsg bg-warning"> 
                    <?php echo $this->session->flashdata('warning'); ?>
                </div>            
<?php	}	?>
<?php	if($this->session->flashdata('error') != ""){ ?>
                <div class="alertMsg bg-danger">
                    <?php echo $this->session->flashdata('error'); ?> 
                </div>            
<?php	}	?>
<?php	if($this->session->flashdata('success') != ""){ ?>
                <div class="alertMsg bg-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>            
<?php	}	?>
<?php	if($this->session->flashdata('info') != ""){ ?>
                <div class="alertMsg bg-info"> 
                    <?php echo $this->session->flashdata('info'); ?>
                </div>
<?php	}	?> 
<?php   if(validation_errors()){ ?>
                <div class="alertMsg bg-danger"> 
                    <ul>
                    <?php echo validation_errors('<li>','</li>'); ?>
                    </ul>
                </div>
<?php   } ?> 