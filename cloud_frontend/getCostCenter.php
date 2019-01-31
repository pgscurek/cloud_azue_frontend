<?php
   if (is_resource($db_connection)) {
   // connected
   } else {
   include 'db_connector.php';
   }

   if (!empty($_POST["pid"])) 
   {
     $choice = $_POST["pid"];
     $query = "SELECT cost_center_code, cost_center_description from cost_centers WHERE cost_center_owner_code = $choice";
     $results = mysqli_query($db_connection, $query);

     foreach ($results as $row)
     { 
     //while ($row = $sql->fetch_assoc())
?>
     <option value="<?php echo $row["cost_center_code"];?>"><?php echo $row["cost_center_description"];?></option>
     <?php
     }
   }
   mysqli_close($db_connection);
     ?>      
 