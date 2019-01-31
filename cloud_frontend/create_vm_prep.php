<html>
<body>

<?php 
   if(isset($_POST['DataCenter'])) 
      $Location=$_POST['DataCenter'];
      $business_code=$_POST['BusinessUnit'];
      $region=$_POST['Region'];
      $servernumber=$_POST['ServerNumber'];
      $VMSize=$_POST['VMSize'];
      $VMName=$_POST['VMName'];
      $DataDiskSize=$_POST['DataDisk2Size'];
      $output="";
      $status=1;
      $servername=$business_code . $region . "s" . $servernumber;

      echo "Data Center = " . $Location . "<br>";
      echo "Region = " . $region . "<br>";
      echo "Business Unit = " . $business_code . "<br>";
      echo "VM Template = " . $VMSize . "<br>";
      echo "Server Number = " . $servernumber . "<br>";
      echo "DataDisk2Size = " . $DataDiskSize . "<br>";
   "<br>";
   "<br>";

   $command1 = "C:\Windows\System32\WindowsPowerShell\\v1.0\powershell.exe -NonInteractive -ExecutionPolicy Unrestricted -File c:\inetpub\cloud\azure_create_vm.ps1 -LocationName $region -business_unit_code $business_code -ServerNumber $servernumber -VMSize $VMSize -DataDiskSize $DataDiskSize";
   "<br>";
   echo "COMMAND: " . $command1 . "<br><br>";
   echo "A server named " . $servername . " is being deployed to " . $region . " in " . $Location . "<br><br>";
   exec($command1,$output,$status);

   if (0 === $status) {
     print "<br><br>" . "The VM " . $servername . " has been successfully deployed." . "<br>";
     print "Its ip address is : " . $output . "<br>";
   } else {
     print "<br><br>" . "The VM " . $VMName . "was not able to be successfully deployed." . "<br>";
     print "The last message :" . "<br><br>";
     var_dump($output);
   }
?>

</body>
</html>