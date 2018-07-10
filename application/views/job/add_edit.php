<div class="container bookings-form">
<?php echo form_open('' , array('data-parsley-validate' => "")); ?>
    <div class="row">
        <div class="col-sm-6">
        <?php if(isset($job)): ?>
            <h2>Update a Booking</h2>
        <?php else: ?>    
            <h2>Add a Booking</h2>
        <?php endif ?>    
        </div>
        <?php /*<div class="col-sm-6">
            <h3 class="alert alert-success pull-right text-uppercase">Unlocknetwork Repare</h3>
       </div>*/?>
    </div>
    <div class="form-box">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Job Information</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Cutomer Name </label>
                            <select name="customer_id" data-placeholder="Select customer" class="chosen-select" required="">
                            <option></option>
                            <?php foreach ($customers as $customer): ?>
                              <option value="<?php echo $customer['id'] ?>" <?php echo set_select('customer_id', $customer['id'], (isset($job) && $job[0]['customer_id'] == $customer['id']?TRUE:FALSE) ); ?>><?php echo $customer['name'] ?></option>
                            <?php endforeach ?>
                           </select>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_form">
                          <i class="fa fa-plus"> Add New Customer</i>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Receive Date</label>
                            <input name="receive_date" type="text" class="form-control" id="datepick" required="" value="<?php echo set_value('receive_date', isset($job)?date('m/d/Y', strtotime($job[0]['receive_date'])):''); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Delivery Date</label>
                            <input type="text" class="form-control" id="datepick1" name="delivery_date" required="" value="<?php echo set_value('delivery_date', isset($job)?date('m/d/Y', strtotime($job[0]['delivery_date'])):''); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Job Pending with</label>
                            <input type="text" class="form-control" name="technician" required="" value="<?php echo set_value('technician', isset($job)?$job[0]['technician']:''); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Device Information</h3>
            </div>
            <div class="panel-body">
        <?php if(isset($job[0]['items']) && count($job[0]['items']) > 0): ?>
            <?php foreach ($job[0]['items'] as $device): ?>
            <div class="device-info">            
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Brand</label>
                            <select data-placeholder="Select From List" class="form-control brand" name="brand_id[]" required="">
                            <option></option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?php echo $brand['id'] ?>" <?php echo set_select('brand_id[]', $brand['id'], $device['brand_id'] == $brand['id']?TRUE:FALSE ); ?>><?php echo $brand['title'] ?></option>
                            <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Model</label>
                            <select data-placeholder="Select From List" class="form-control model" name="brand_model_id[]" required="">
                            <option></option>
                            </select>
                            <input type="hidden" value="<?php echo set_value('brand_model_id[]', isset($job)?$device['brand_model_id']:''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">IMEI/ ESN/ SN</label>
                            <input type="text" class="form-control" name="device_number[]" required="" value="<?php echo set_value('device_number[]', isset($job)?$device['device_number']:''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Color</label>
                            <input type="text" class="form-control" name="color[]" required="" value="<?php echo set_value('color[]', isset($job)?$device['color']:''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Provider Info</label>
                            <input type="text" class="form-control" name="provider[]" required="" value="<?php echo set_value('provider[]', isset($job)?$device['provider']:''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Password</label>
                            <input type="text" class="form-control" name="device_password[]" required="" value="<?php echo set_value('device_password[]', isset($job)?$device['device_password']:''); ?>">
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Fault Discription</label>
                            <input type="text" class="form-control" name="fault_discription[]" required="" value="<?php echo set_value('fault_discription[]', isset($job)?$device['fault_discription']:''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Cost</label>
                            <input type="text" class="form-control" name="cost[]" required="" value="<?php echo set_value('cost[]', isset($job)?$device['cost']:''); ?>">
                        </div>
                    </div>                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" class="form-control" name="amount[]" required="" value="<?php echo set_value('amount[]', isset($job)?$device['amount']:''); ?>">
                        </div>
                    </div>
                </div>
                <h4>Initial Check</h4>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Power On</label>
                            <select data-placeholder="Select From List" class="form-control" name="power_on[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('power_on[]', 1, $device['power_on'] == 1 ?TRUE:FALSE ); ?>>Working</option>
                                <option value="0" <?php echo set_select('power_on[]', 0, $device['power_on'] == 0 ?TRUE:FALSE ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Charging</label>
                            <select data-placeholder="Select From List" class="form-control" name="charging[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('charging[]', 1, $device['charging'] == 1 ?TRUE:FALSE ); ?>>Working</option>
                                <option value="0" <?php echo set_select('charging[]', 0, $device['charging'] == 0 ?TRUE:FALSE ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Network</label>
                            <select data-placeholder="Select From List" class="form-control" name="network[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('network[]', 1, $device['network'] == 1 ?TRUE:FALSE ); ?>>Working</option>
                                <option value="0" <?php echo set_select('network[]', 0, $device['network'] == 0 ?TRUE:FALSE ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Display</label>
                            <select data-placeholder="Select From List" class="form-control" name="display[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('display[]', 1, $device['display'] == 1 ?TRUE:FALSE ); ?>>Working</option>
                                <option value="0" <?php echo set_select('display[]', 0, $device['display'] == 0 ?TRUE:FALSE ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Camera</label>
                            <select data-placeholder="Select From List" class="form-control" name="camera[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('camera[]', 1, $device['camera'] == 1 ?TRUE:FALSE ); ?>>Working</option>
                                <option value="0" <?php echo set_select('camera[]', 0, $device['camera'] == 0 ?TRUE:FALSE ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Battery</label>
                            <select data-placeholder="Select From List" class="form-control" name="battery[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('battery[]', 1, $device['battery'] == 1 ?TRUE:FALSE ); ?>>Working</option>
                                <option value="0" <?php echo set_select('battery[]', 0, $device['battery'] == 0 ?TRUE:FALSE ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                </div> 
                <hr>                               
            </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="device-info">            
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Model</label>
                            <select data-placeholder="Select From List" class="form-control brand" name="brand_id[]" required="">
                            <option></option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?php echo $brand['id'] ?>" <?php echo set_select('brand_id[]', $brand['id'] ); ?>><?php echo $brand['title'] ?></option>
                            <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Model</label>
                            <select data-placeholder="Select From List" class="form-control model" name="brand_model_id[]" required="">
                            <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">IMEI/ ESN/ SN</label>
                            <input type="text" class="form-control" name="device_number[]" required="" value="<?php echo set_value('device_number[]'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Color</label>
                            <input type="text" class="form-control" name="color[]" required="" value="<?php echo set_value('color[]'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Provider Info</label>
                            <input type="text" class="form-control" name="provider[]" required="" value="<?php echo set_value('provider[]'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Device Password</label>
                            <input type="text" class="form-control" name="device_password[]" required="" value="<?php echo set_value('device_password[]'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">Fault Discription</label>
                            <input type="text" class="form-control" name="fault_discription[]" required="" value="<?php echo set_value('fault_discription[]'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Cost</label>
                            <input type="text" class="form-control" name="cost[]" required="" value="<?php echo set_value('cost[]'); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" class="form-control" name="amount[]" required="" value="<?php echo set_value('amount[]'); ?>">
                        </div>
                    </div>
                </div>
                <h4>Initial Check</h4>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Power On</label>
                            <select data-placeholder="Select From List" class="form-control" name="power_on[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('power_on[]', 1 ); ?>>Working</option>
                                <option value="0" <?php echo set_select('power_on[]', 0 ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Charging</label>
                            <select data-placeholder="Select From List" class="form-control" name="charging[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('charging[]', 1 ); ?>>Working</option>
                                <option value="0" <?php echo set_select('charging[]', 0 ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Network</label>
                            <select data-placeholder="Select From List" class="form-control" name="network[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('network[]', 1 ); ?>>Working</option>
                                <option value="0" <?php echo set_select('network[]', 0 ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Display</label>
                            <select data-placeholder="Select From List" class="form-control" name="display[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('display[]', 1 ); ?>>Working</option>
                                <option value="0" <?php echo set_select('display[]', 0 ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Camera</label>
                            <select data-placeholder="Select From List" class="form-control" name="camera[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('camera[]', 1 ); ?>>Working</option>
                                <option value="0" <?php echo set_select('camera[]', 0 ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="dpBlock" for="">Battery</label>
                            <select data-placeholder="Select From List" class="form-control" name="battery[]" required="">
                                <option></option>
                                <option value="1" <?php echo set_select('battery[]', 1 ); ?>>Working</option>
                                <option value="0" <?php echo set_select('battery[]', 0 ); ?>>Not Working</option>
                            </select>
                        </div>
                    </div>
                </div> 
                <hr>                               
            </div>                            
        <?php endif ?>                
            <a class="btn btn-info btn-sm" id="copydevice" href="#" rel=".device-info"><i class="fa fa-plus"></i> &nbsp; Add More Devices</a>            
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Description & Remarks</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Other Notes</label>
                            <textarea class="form-control" name="notes"><?php echo set_value('notes', isset($job)?$job[0]['notes']:''); ?></textarea>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-offset-1 col-md-5">
        <?php if($this->uri->segment(3) !== NULL): ?>
            <a href="#" onclick="document.getElementById('thermal_print').contentDocument.location.reload(true)" class="btn btn-primary btn-lg btn-block"><i class="fa fa-print"></i> &nbsp; Print</a>
        <?php else: ?>
            <a href="javascript:alert('Please save this first.');" class="btn btn-primary btn-lg btn-block"><i class="fa fa-print"></i> &nbsp; Print</a>                    
        <?php endif ?>    
        </div>
        <div class="col-md-5">
            <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-save"></i> &nbsp; Save</button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<!-- Add Customer Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Customer</h4>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/>
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-3">Name</label>
                    <div class="col-md-9">
                        <input name="name" placeholder="Name" class="form-control" type="text" required="">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Phone</label>
                    <div class="col-md-9">
                        <input name="phone" placeholder="Phone" class="form-control" type="text" required="">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Email</label>
                    <div class="col-md-9">
                        <input name="email" placeholder="Email" class="form-control" type="email" required="">
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
  </div>
</div>
<?php /* Thermal Invoice which will be open print */ ?>
<?php if(isset($job)): ?>
<iframe src="<?php echo site_url('job/recept/'.$this->uri->segment(3)); ?>" id="thermal_print" style="width:0;height:0;border:0; border:none;"></iframe>
<?php endif; ?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
    $('.brand').on('change', function (){
        var brand = $(this);
        $.getJSON('<?php echo site_url('job/ajax_get_model') ?>', {brand_id: brand.val()}, function(data){
            var options = '';
            for (var x = 0; x < data.length; x++) {
                options += '<option value="' + data[x]['id'] + '">' + data[x]['title'] + '</option>';
            }
            brand.closest('.row').find('.model').html(options);
        });
    });
    <?php if(isset($job[0]['items']) && count($job[0]['items']) > 0): ?>
    $('.brand').trigger("change");
    $('.model').each(function () {
        var model = $(this).siblings('input').val();
        var obj = $(this);
        setTimeout(function(){
            obj.val(model);
        }, 2000); //2 seconds        
    });    
    <?php endif ?>
});

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url = "<?php echo site_url('customer/ajax_add')?>";
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                location.reload();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
}
</script>