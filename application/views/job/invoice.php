<!DOCTYPE html>
<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
<meta charset="utf-8">
<title>Invoice</title>
<link href="<?php echo base_url(); ?>assets/styles/print.css" rel="stylesheet" type="text/css" />
</head>
<body onload="window.print();">
<header class="clearfix">
  <div id="logo"><img src="<?php echo base_url(); ?>assets/images/logo.png" />
    <div id="center_title">Check-In Receipt</div>
  </div>
  <div id="customer">
    <div id="jbnum">
      <div> Job Number </div>
      <div>
        <h1> <?php echo $job['id'] ?></h1>
      </div>
    </div>
  </div>
  <div id="project">
    <div>Tel: <strong>01618343351</strong></div>
    <div>E-mail: <strong>sales@gsmworkshop.com</strong></div>
    <div>Website: <strong>www.gsmworkshop.com</strong></div>
  </div>
</header>
<main>
  <div id="cinfo_table_rgt">
    <table width="100%" border="0">
      <tr>
        <th id="th_center" colspan="2" scope="col">Job Information </th>
      </tr>
      <tr>
        <td width="45%">Receive Date </td>
        <td width="55%">: <?php echo date('d-M-Y', strtotime($job['receive_date'])) ?></td>
      </tr>
      <tr>
        <td width="45%">Delivery Date </td>
        <td>: <?php echo date('d-M-Y', strtotime($job['delivery_date'])) ?></td>
      </tr>
      <tr>
        <td width="45%">Technician </td>
        <td>: <?php echo $job['technician'] ?></td>
      </tr>
      <tr>
        <td width="42%">Location</td>
        <td>: <?php echo $job['office'] ?></td>
      </tr>
    </table>
  </div>
  <div id="cinfo_table">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th id="th_center" colspan="2" scope="col">Customer Information </th>
      </tr>
      <tr>
        <td width="5%">NAME </td>
        <td width="95%">: <?php echo $job['name'] ?></td>
      </tr>
      <tr>
        <td  width="5%">PHONE </td>
        <td>: <?php echo $job['phone'] ?></td>
      </tr>
      <tr>
        <td width="5%">E-MAIL</td>
        <td>: <?php echo $job['email'] ?></td>
      </tr>
      <tr>
        <td width="42%"></td>
        <td>&nbsp;</td>
      </tr>      
    </table>
  </div>
    <table width="100%" border="0" cellspacing="0" class="data-table">
      <tr>
        <td id="th_center" colspan="5" scope="col"><h3>Invoice</h3></td>
      </tr>      
      <tr>
        <th style="width: 5%">Sr#</th>  
        <th style="width: 17%">IMEI</th>
        <th style="width: 35%">Fault Description</th>
        <th style="width: 30%">Device Info </th>
        <th style="width: 13%">CHARGES</th>
      </tr>
<?php $total = 0.00; ?>      
<?php foreach ($job['items'] as $k => $device): ?>      
      <tr>
        <td><?php echo $k+1 ?></td>
        <td><?php echo $device['device_number'] ?></td>
        <td><?php echo $device['fault_discription'] ?></td>
        <td><?php echo $device['brand'] ?>&nbsp;<?php echo $device['model'] ?>&nbsp;(<?php echo $device['color'] ?>)</td>
        <td><strong>&pound;<?php echo number_format($device['amount'], 2) ?></strong></td>
      </tr>
<?php $total += floatval($device['amount']); ?>    
<?php endforeach ?>
      <tr>
        <td colspan="4" style="text-align: right;font-weight: bold;">Total Charges:</td>
        <td><strong>&pound;<?php echo number_format($total, 2) ?></strong></td>
      </tr>    
    </table>
    
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td style="background-color:#FFF;" bgcolor="#FFFFFF"><div id="signcompny"> For </div></td>
      <td style=" background-color:#FFF;" bgcolor="#FFFFFF"><div id="signcus"> Customer's Sign </div></td>
    </tr>
  </table>
  <div id="notices">
    <table width="100%" cellspacing="0">
      <tr>
        <th>Terms And Condition</th>
      </tr>
      <tr>
        <td style="line-height:inherit; text-align:justify">PLEASE RETAIN THIS RECEIPT FOR YOUR RECORDS, WITHOUT THIS WE WILL NOT SURVE YOU.</td>
      </tr>
    </table>
  </div>
</main>
</body>
</html>