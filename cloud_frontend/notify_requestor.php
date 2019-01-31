<!DOCTYPE html>
<html>
 <body>


 <?php

//   $provider_code=$_POST['Provider'];
//   $region_id=$_POST['Region'];
//   $costcenterowner=$_POST['CostCenterOwner'];
//   $costcenter=$_POST['costCenter'];
//   $servicelevel=$_POST['serviceLevel'];
//   $textmessage=$_POST['message'];

   if (is_resource($db_connection)) {
   // connected
   } else {
   include 'db_connector.php';
   }

   $query = "SELECT provider_name FROM providers WHERE provider_id = ". $provider_code; 
   $result = mysqli_query($db_connection, $query);
   while ($row = $result->fetch_assoc())
   {
     $provider = $row['provider_name'];
   }

   $query = "SELECT region_name FROM regions WHERE provider_id = " . $provider_code . " AND region_code = " . "'" . $region_id . "'"; 
   $result = mysqli_query($db_connection, $query);
   while ($row = $result->fetch_assoc())
   {
     $region = $row['region_name'];
   }

   $query = "SELECT cost_center_description FROM cost_centers WHERE cost_center_code = " . "'" . $costcenter . "'"; 
   $result = mysqli_query($db_connection, $query);
   while ($row = $result->fetch_assoc())
   {
     $costcenter = $row['cost_center_description'];
   }

   $query = "SELECT lastname, firstname, middle_initial, owner_email FROM cost_center_owners WHERE cost_center_owner_code = " . "'" . $costcenterowner . "'"; 
   $result = mysqli_query($db_connection, $query);
   while ($row = $result->fetch_assoc())
   {
     $costcenterowner = $row['lastname'] . "," . $row['firstname'] . " " . $row['middle_initial'];
     $emailaddress = $row['owner_email'];
   }
 

   // Assemble information into message. 
   $msg = "Provider: " . $provider . "\nRegion: " . $region . "\nCost Center Owner: " . $costcenterowner . "\nCost Center: " . $costcenter . "\nService Level: " . $servicelevel . "\n\nCustomer Entered Information:\n" . $textmessage . "\n";

   // use wordwrap() if lines are longer than 70 characters
   $msg = wordwrap($msg,70);

   // send email
   mail($emailaddress,$subject,$msg);

   mysqli_close($db_connection);
 ?>
 <script>
   window.location.replace("menu.html");
 </script>
 </body>
</html> 
