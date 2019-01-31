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

    <form id="ServerForm" action="store_server_request.php" method="post">
    <br>
    <br>
     PROVIDER:
<!--     <select id="Provider" name="Provider" onchange="getRegion(this.value);">
-->
     <select id="Provider" name="Provider" onchange="getData(this.value,'#Region','getRegion.php');">
       <?php 
       $query = "SELECT provider_id, provider_name FROM providers";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['provider_id'] . ">" . $row['provider_name'] . "</option>";
       }
       ?>
    </select>
    <br>
    <br>

     REGION/DATACENTER:
     <select id="Region" name="Region">
     <option value=>--- Select Provider ---</option>;        
    </select>
    <br>
    <br>

    JCI BUSINESS UNIT:
    <select id="BusinessUnit" name="BusinessUnit">
       <?php 
       $query = "SELECT business_unit_code, business_unit_name FROM business_unit";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['business_unit_code'] . ">" . $row['business_unit_name'] . "</option>";
       }
       ?>
    </select>
    <br>
    <br>


    OS TYPE:
    <select id="OSType" name="OSType">
       <?php 
       $query = "SELECT os_code, os_description FROM operating_system";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['os_code'] . ">" . $row['os_description'] . "</option>";
       }
       ?>
    </select>
    <br>
    <br>

    VM SIZE:
    <select id="VMSize" name="VMSize">
       <?php 
       $query = "SELECT vm_size_code, vm_size_description FROM vm_size";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['vm_size_code'] . ">" . $row['vm_size_description'] . "</option>";
       }
       ?>
    </select>
    <br>
    <br>

    ADDITIONAL DATA DISK SIZE:
   <select id="DataDisk2Size" name="DataDisk2Size">
       <?php 
       $query = "SELECT disk_size_gb, disk_description FROM disk_sizes";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['disk_size_gb'] . ">" . $row['disk_description'] . "</option>";
       }
       ?>
   </select>
   <br>
   <br>

   ENVIRONMENT:
   <select id="Environment" name="Environment">
     <?php 
     $query = "SELECT environment_code, environment_name FROM environments";
     $sql = mysqli_query($db_connection, $query);
     while ($row = $sql->fetch_assoc())
     {
       echo "<option value=" . $row['environment_code'] . ">" . $row['environment_name'] . "</option>";
     }
     ?>
   </select>
   <br>
   <br>
    COST CENTER OWNER:
<!--     <select id="CostCenterOwner" name="CostCenterOwner" onchange="getCostCenter(this.value);">
-->
     <select id="CostCenterOwner" name="CostCenterOwner" onchange="getCostCenter(this.value,'#costCenter','getCostCenter.php');">
       <?php 
       $query = "SELECT cost_center_owner_code, lastname, firstname, middle_initial FROM cost_center_owners";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['cost_center_owner_code'] . ">" . $row['lastname'] . ", " . $row['firstname'] . " " . $row['middle_initial'] . "</option>";
       }
       ?>
     </select>
     <br>
     <br>

     COST CENTER:
     <select id="costCenter" name="costCenter">
       <?php 
       $query = "SELECT cost_center_code, cost_center_description FROM cost_centers";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['cost_center_description'] . ">" . $row['cost_center_description'] . "</option>";
       }
       ?>
     </select>
     <br>
     <br>
     SERVICE LEVEL:
     <select id="serviceLevel" name="serviceLevel">
       <?php 
       $query = "SELECT service_level_code, service_level_description FROM service_levels";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['service_level_code'] . ">" . $row['service_level_description'] . "</option>";
       }
       ?>
     </select>
     <br>
     <br>
     DOMAIN:
     <select id="domain" name="domain">
       <?php 
       $query = "SELECT domain_id, domain_name FROM domains";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['domain_id'] . ">" . $row['domain_name'] . "</option>";
       }
       ?>
     </select>
     <br>
     <br>

<!-- <label for ="additionaldisk">Add an additional data disk:</label>
<input name="additionaldisk" id="additionaldisk" type=checkbox checked="yes">
<input type="checkbox" id="additionaldisk" > 

   Add an additional data disk: 
   <input type="checkbox" id="additionaldisk" name="additionaldisk" value="y"
   <br>
   <br>
   DATA DISK SIZE
   <br>
   <input type="text" id="DataDisk2Size" name="DataDisk2Size">
-->

   </font>
   <br>
   <br>
   <input type="submit" value="Request Server">
   <input type="button" name="cancel" value="Cancel" onClick="window.location.href='screen_base.php';" />
   <br>
  </form>

  <script>

  function getData(val,form_id,script) 
  { 
   $.ajax({
                type: "POST",
                url: script,
                data: "pid="+val,
                success: function(data){
                    $(form_id).html(data);
                }
            });
  }

  function getRegion(val) 
  { 
   $.ajax({
                type: "POST",
                url: "getRegion.php",
                data: "pid="+val,
                success: function(data){
                    $("#Region").html(data);
                }
            });
  }

  function getCostCenter(val)
  { 
   $.ajax({
                type: "POST",
                url: "getCostCenter.php",
                data: "pid="+val,
                success: function(data){
                    $("#costCenter").html(data);
                }
            });
  }
  </script>
  </div>
 </body>
</html>