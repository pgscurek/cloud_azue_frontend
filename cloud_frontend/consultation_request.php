<!DOCTYPE html>
<html>
 <body>


 <?php

   $FirstName=$_POST['firstname'];
   $LastName=$_POST['lastname'];
   $EmailAddress=$_POST['contact_email'];
   $provider_code=$_POST['Provider'];
   $textmessage=$_POST['message'];

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
 
   // Assemble information into message. 
   $msg = "Requestor: " . $LastName . " " .$FirstName . "\nEmail Address: " . $EmailAddress . "\nProvider: " . $provider . "\n\nCustomer Entered Information:\n" . $textmessage . "\n";

   // use wordwrap() if lines are longer than 70 characters
   $msg = wordwrap($msg,70);

   // send email
   mail("peter.scurek-ext@jci.com","Consultation Request",$msg);

   mysqli_close($db_connection);
 ?>
 <script>
   window.location.replace("menu.html");
 </script>
 </body>
</html> 
