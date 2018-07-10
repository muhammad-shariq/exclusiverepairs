<?php 
$module_name = 'employee'; 
$module_title = 'Employee'; 
?>
<!--Content [Start]-->
<div id="content">
    <?php $this->load->view('errors/message'); ?>
    <!-- Filter Bar [Start] -->
    <div class="filterBar">
        <div class="container">     
            <h3><?php echo $module_title ?> Management</h3>
            <br />
            <?php if($this->session->is_admin):  ?> 
            <button class="btn btn-success" onclick="add()"><i class="fa fa-plus"></i> Add <?php echo $module_title ?></button>
            <?php endif ?>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</button>
            <br />
            <br />
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Updated</th>

                        <?php if($this->session->is_admin):  ?> 
                        <th style="width:125px;">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                </tbody>     
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Updated</th>

                        <?php if($this->session->is_admin):  ?> 
                        <th>Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div><!--/container-->
    </div><!--/container-->
</div><!--Content [END]-->
<?php if($this->session->is_admin):  ?> 
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
                            <label class="control-label col-md-2">Name</label>
                            <div class="col-md-4">
                                <input name="name" placeholder="Name" class="form-control" type="text" required="">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">Phone</label>
                            <div class="col-md-4">
                                <input name="phone" placeholder="Phone" class="form-control" type="text" required="">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Email</label>
                            <div class="col-md-4">
                                <input name="email" placeholder="Email" class="form-control" type="email" required="">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-2">Location</label>
                            <div class="col-md-4">
                                <select name="office_id" class="form-control">
                              <?php foreach ($offices as $v) : ?>
                                    <option value="<?php echo $v['id']; ?>"><?php echo $v['title']; ?></option>
                              <?php endforeach;  ?>
                                </select>
                                <span class="help-block"></span>
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Username</label>
                            <div class="col-md-4">
                                <input name="username" placeholder="Username" class="form-control" type="text" required="">
                                <span class="help-block"></span>
                            </div>

                            <label class="control-label col-md-2">Is Admin</label>
                            <div class="col-md-4">
                                <select name="is_admin" class="form-control">
                                    <option value="0">No</option>                                    
                                    <option value="1">Yes</option>
                                </select>
                                <span class="help-block"></span>
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Password</label>
                            <div class="col-md-4">
                                <input name="password" placeholder="Password" class="form-control" type="password" required="">
                                <span class="help-block"></span>
                            </div>

                            <label class="control-label col-md-2">Status</label>
                            <div class="col-md-4">
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Suspend</option>
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
<?php endif ?>

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
    /*$('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });*/
 
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
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
} 
 

<?php if($this->session->is_admin):  ?> 
// Only Admin Can perform theses operations
function add()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add <?php echo $module_title ?>'); // Set Title to Bootstrap modal title
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
            $('[name="name"]').val(data.name);
            $('[name="phone"]').val(data.phone);
            $('[name="email"]').val(data.email);
            $('[name="username"]').val(data.username);
            $('[name="password"]').val(data.password);
            $('[name="status"]').val(data.status);
            $('[name="is_admin"]').val(data.is_admin);
            $('[name="office_id"]').val(data.office_id);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit <?php echo $module_title ?>'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function del(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url($module_name.'/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}
<?php endif ?>  
</script>