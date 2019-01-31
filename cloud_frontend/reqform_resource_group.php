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

     <form id="ResourceForm" action="store_resource_group_request.php" method="post">
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

    COST CENTER OWNER:
<!--     <select id="CostCenterOwner" name="CostCenterOwner" onchange="getCostCenter(this.value,'#costCenter','getCostCenter.php');">
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


     SERVICE LEVEL:
     <select id="serviceLevel" name="serviceLevel">
       <?php 
       $query = "SELECT service_level_code, service_level_description FROM service_levels";
       $sql = mysqli_query($db_connection, $query);
       while ($row = $sql->fetch_assoc())
       {
         echo "<option value=" . $row['service_level_description'] . ">" . $row['service_level_description'] . "</option>";
       }
       ?>
     </select>
     <br>
     <br>


     Enter additional information:
     <br>
     <textarea name="message" rows="10" cols="80"></textarea>
     <br>
     <br>
     <input type="submit" value="Submit Request">
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