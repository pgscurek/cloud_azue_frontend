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

     <form name= ConsultationFrom id="ConsultationForm" action="consultation_request.php" method="post">
     <br>
     <br>
     <p>ENTER YOUR CONTACT INFORMATION</p>
     <br>
     FIRST NAME :
     <input type="text" name="firstname" id="firstname">
     <br>
     <br>
     LAST NAME :
     <input type="text" name="lastname" id="lastname">
     <br>
     <br>
     EMAIL:
     <input id=contact_email name="contact_email">
     <br>
     <br>
     PROVIDER:
     <select id="Provider" name="Provider" onchange="getRegion(this.value);">
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
     Enter a brief description of desired cloud services:
     <br>
     <textarea name="message" rows="10" cols="80"></textarea>
     <br>
     <br>
     <input type="submit" value="Submit Request">
     <input type="button" name="cancel" value="Cancel" onClick="window.location.href='screen_base.php';" />
     <br>
     </form>


  <script>
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