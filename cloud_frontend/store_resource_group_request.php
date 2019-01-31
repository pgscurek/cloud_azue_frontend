<!DOCTYPE html>
<html>
 <body>


 <?php

   $provider_code=$_POST['Provider'];
   $region_id=$_POST['Region'];
   $costcenterowner=$_POST['CostCenterOwner'];
   $costcenter=$_POST['costCenter'];
   $servicelevel=$_POST['serviceLevel'];
   $textmessage=$_POST['message'];
   $businessunit=$_POST['BusinessUnit'];
   $environment=$_POST['Environment'];

   $requestor="UNKNOWN";
   $approval_status="u";
   $approval_type="r";
   $subject="New Service Group Request";

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

   $query = "SELECT business_unit_name FROM business_unit WHERE business_unit_code = " . "'" . $businessunit . "'"; 
   $result = mysqli_query($db_connection, $query);
   while ($row = $result->fetch_assoc())
   {
     $business_unitname = $row['business_unit_name'];
   }

   $query = "SELECT environment_name FROM environments WHERE environment_code = " . "'" . $environment . "'"; 
   $result = mysqli_query($db_connection, $query);
   while ($row = $result->fetch_assoc())
   {
     $environmentname = $row['environment_name'];
   }

   $sql = "insert into cloud_requests (requestor_id, provider, region, owner_id, cost_center_code, service_level, text_field, approval_status, request_type, business_unit, environment)
 values ('" . $requestor . "','" . $provider . "','" . $region_id . "','" . $costcenterowner . "','" . $costcenter . "','" . $servicelevel . "','" . $textmessage . "','" . $approval_status . "','" . $approval_type . "','" . $business_unitname . "','" . $environmentname . "')";
   
  if (mysqli_query($db_connection, $sql)) {
   include "notify_requestor.php";
   } 

   $db_connection->close();

 ?>
 <script>
   window.location.replace("menu.html");
 </script>
 </body>
</html> 
