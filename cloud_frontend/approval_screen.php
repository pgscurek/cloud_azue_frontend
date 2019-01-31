<!DOCTYPE html>
<html>
 <head>
  <title>Cloud Hosting Services POC</title>
  <script src="jquery-3.3.1.js"></script>
  <link rel="stylesheet" type="text/css" href="cloud.css">
 </head>
 
 <body>
 <?php
   if (is_resource($db_connection)) {
   // connected
   } else {
   include 'db_connector.php';
   }

   include 'menu.html';
 ?>
   <div class="bg">

<?php

$query="SELECT * from cloud_requests WHERE owner_id = 'Henkle,Thomas'";
$results=mysqli_query($db_connection,$query);

//echo "<form id='approvalForm' action='process_requests.php' method='post'>";
?>

<form id="ApprovalForm" action="menu.html">
<table border='10'>
<tr>
<th>Approve</th>
<th>Deny</th>
<th>Request Number</th>
<th>Requestor</th>
<th>Owner</th>
<th>Cost Center</th>
<th>Provider</th>
<th>Region</th>
<th>Service Level</th>
<th>Business Unit</th>
<th>Operating System</th>
<th>VM Size</th>
<th>Environment</th>
</tr>

<?php
while ($row = mysqli_fetch_array($results))
{

$request_number=$row['reqnum'];
echo "<tr>";
echo "<td><input type='checkbox' value='$request_number' name='approve[]' />&nbsp;</td>";
echo "<td><input type='checkbox' value='$request_number' name='deny[]' />&nbsp;</td>";
echo "<td>" . $row['reqnum'] . "</td>";
echo "<td>" . $row['requestor_id'] . "</td>";
echo "<td>" . $row['owner_id'] . "</td>";
echo "<td>" . $row['cost_center_code'] . "</td>";
echo "<td>" . $row['provider'] . "</td>";
echo "<td>" . $row['region'] . "</td>";
echo "<td>" . $row['service_level'] . "</td>";
echo "<td>" . $row['business_unit'] . "</td>";
echo "<td>" . $row['os_type'] . "</td>";
echo "<td>" . $row['vm_size'] . "</td>";
echo "<td>" . $row['environment'] . "</td>";
}
?>

</table>
<br>
<br>

<input type="submit" value="Process Requests">
     <input type="button" name="cancel" value="Cancel" onClick="window.location.href='screen_base.php';" />
</form>

<?php
mysqli_close($db_connection);
?>

 </body>
</html>