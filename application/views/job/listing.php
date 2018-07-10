<?php 
$module_name = 'job'; 
$module_title = 'Bookings'; 
?>
<!--Content [Start]-->
<div id="content">
    <!-- Filter Bar [Start] -->
    <div class="filterBar">
        <div class="container">     
            <h3><?php echo $module_title ?> Management</h3>
            <br />
            <button class="btn btn-success" onclick="window.location='<?php echo site_url($module_name.'/add')?>'"><i class="fa fa-plus"></i> Add <?php echo $module_title ?></button>
            <button class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</button>
            <br />
            <br />
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Received</th>
                        <th>Delivery</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>     
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Received</th>
                        <th>Delivery</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div><!--/container-->
    </div><!--/container-->
</div><!--Content [END]-->
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
}); 
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

function status_change(id, status)
{
    if(confirm('Are you sure to change its status?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url($module_name.'/ajax_status_change')?>/"+id+"/"+status,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Unable to change its status');
            }
        });
 
    }
}

<?php if($this->session->is_admin):  ?> 
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