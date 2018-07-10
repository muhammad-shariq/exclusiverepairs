<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice</title>
<link href="<?php echo base_url(); ?>assets/styles/thermal.css" rel="stylesheet" type="text/css" />
</head>
<body onload="window.print();">
<div id="main">
  <div id="logo"> <img src="<?php echo base_url(); ?>assets/images/logo.png" style="width:80%" /></div>
  <div class="contentbox">
  <p>Job Number: <strong style="float:right"><?php echo $job['id'] ?></strong></p>
  <p>Tel: <strong style="float:right">01618343351</strong></p>
  <p>E-mail: <strong style="float:right">sales@gsmworkshop.com</strong></p>
  <p>Website: <strong style="float:right">www.gsmworkshop.com</strong></p>
  <hr>
  <h4 style="margin-bottom:5px; margin-top:10px;">Job Information</h4>
  <p>Receive Date: <strong style="float:right"><?php echo date('d-M-Y', strtotime($job['receive_date'])) ?></strong></p>
  <p>Delivery Date: <strong style="float:right"><?php echo date('d-M-Y', strtotime($job['delivery_date'])) ?></strong></p>
  <p>Technician: <strong style="float:right"><?php echo $job['technician'] ?></strong></p>
  <p>Location: <strong style="float:right"><?php echo $job['office'] ?></strong></p>
  <hr>
  <h4 style="margin-bottom:5px; margin-top:10px;">Customer Information</h4>
  <p>Name: <strong style="float:right"><?php echo $job['name'] ?></strong></p>
  <p>Phone: <strong style="float:right"><?php echo $job['phone'] ?></strong></p>
  <p>Email: <strong style="float:right"><?php echo $job['email'] ?></strong></p>
  <hr>
  <h3 style="margin-bottom:8px; margin-top:10px;">Device Information</h3>
<?php $total = 0.00; ?>      
<?php foreach ($job['items'] as $k => $device): ?>   
  <p><strong><?php echo $device['brand'] ?></strong>&nbsp;-&nbsp;<?php echo $device['model'] ?>&nbsp;<small>(<?php echo $device['color'] ?>)</small></p>
  <p><strong>IMEI/ ESN/ SN:</strong> <?php echo $device['device_number'] ?><strong style="float:right">&pound;<?php echo number_format($device['amount'], 2) ?></strong></p>
  <p><strong>Fault(s):</strong>
  <?php echo $device['battery']?'': 'Battery, ' ?>
  <?php echo $device['charging']?'': 'Charging, ' ?>
  <?php echo $device['network']?'': 'Network, ' ?>
  <?php echo $device['display']?'': 'Display, ' ?>
  <?php echo $device['camera']?'': 'Camera, ' ?>  
  <?php echo $device['power_on']?'': 'Power On ' ?>
    
  </p>
  <hr style="border:0; border-top:1px solid #999">
<?php $total += floatval($device['amount']); ?>    
<?php endforeach ?>
  <p><strong>TOTAL</strong><strong style="float:right">&pound;<?php echo number_format($total, 2) ?></strong></p>
  </div>
  <div id="signcompny"> PLEASE RETAIN THIS RECEIPT FOR YOUR RECORDS, WITHOUT THIS WE WILL NOT SURVE YOU.</div>
  <?php /*<div id="signcus"> Customer's Sign </div>*/?>
</div>
</body>
</html>