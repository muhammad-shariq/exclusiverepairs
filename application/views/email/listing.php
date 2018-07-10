<?php 
$module_name = 'email'; 
$module_title = 'Email Template'; 
?>
<!--Content [Start]-->
<div id="content">
    <?php $this->load->view('errors/message'); ?>
    <!-- Filter Bar [Start] -->
    <div class="filterBar">
        <div class="container">     
            <h3><?php echo $module_title ?> Management</h3>
            <br />
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</button>
            <br />
            <br />
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>From Name</th>
                        <th>From Email</th>
                        <th>To Email</th>
                        <th>Subject</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>     
                <tfoot>
                <tr>
                    <th>Title</th>
                    <th>From Name</th>
                    <th>From Email</th>
                    <th>To Email</th>
                    <th>Subject</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div><!--/container-->
    </div><!--/container-->
</div><!--Content [END]-->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"><?php echo $module_title ?> Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-2">Title</label>
                            <div class="col-md-4">
                                <input name="title" placeholder="Title" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">From Name</label>
                            <div class="col-md-4">
                                <input name="from_name" placeholder="From Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">To Email</label>
                            <div class="col-md-4">
                                <input name="to_email" placeholder="To Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">From Email</label>
                            <div class="col-md-4">
                                <input name="from_email" placeholder="From Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Subject</label>
                            <div class="col-md-10">
                                <input name="subject" placeholder="Subject" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Message</label>
                            <div class="col-md-10">
                                <textarea name="message" placeholder="Message" class="form-control" rows="7"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Status</label>
                            <div class="col-md-4">
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url($module_name.'/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
 
    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
});
 
function edit(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url($module_name.'/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="title"]').val(data.title);
            $('[name="from_name"]').val(data.from_name);
            $('[name="from_email"]').val(data.from_email);
            $('[name="to_email"]').val(data.to_email);
            $('[name="subject"]').val(data.subject);
            $('[name="message"]').val(data.message);
            $('[name="status"]').val(data.status);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit <?php echo $module_title; ?>'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url($module_name.'/ajax_add')?>";
    } else {
        url = "<?php echo site_url($module_name.'/ajax_update')?>";
    }
 
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
                reload_table();
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