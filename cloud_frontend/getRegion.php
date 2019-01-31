<?php
   if (is_resource($db_connection)) {
   // connected
   } else {
   include 'db_connector.php';
   }

   if (!empty($_POST["pid"])) 
   {
     $choice = $_POST["pid"];
     $query = "SELECT region_code, region_name from regions WHERE provider_id = $choice AND region_availability = 'y'";
     //$query = "SELECT * from regions" ;
     $results = mysqli_query($db_connection, $query);

     foreach ($results as $row)
     { 
     //while ($row = $sql->fetch_assoc())
?>
     <option value="<?php echo $row["region_code"];?>"><?php echo $row["region_name"];?></option>
     <?php
     }
   }
   mysqli_close($db_conneciton);
     ?>      
 