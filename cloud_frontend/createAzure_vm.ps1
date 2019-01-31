param([string] $LocationName = 'eastus2',
      [string] $business_unit_code = 'j',
      [string] $ServerNumber = '800',
      [string] $VmSize = 'Standard_A3',
      [string] $DataDiskSize = '0',
      [string] $OS = 'Windows'
     )
#      [string] $DataDiskChoice = 'n',
set-Location Env:
#$Env:PSModulePath
$Env:PSModulePath = "C:\Program Files\WindowsPowerShell\Modules;C:\Windows\system32\WindowsPowerShell\v1.0\Modules\;C:\Program Files\Centrify\PowerShell\;C:\Program Files\Microsoft Monitoring Agent\Agent\PowerShell\;C:\Program Files\Microsoft Monitoring Agent\Agent\AzureAutomation\7.2.13130.0"
#$Env:PSModulePath


##$LocationName = 'eastus2'
##$business_unit_code = 'j'
##$ServerNumber = '800'
##$VmSize = 'Standard_A3'
##$DataDiskChoice = 'y'
##$DataDiskSize = '10'


# Import PowerShell Modules
##echo "Import Module AzureRM"
Import-Module -Name AzureRM
##echo "$?"

# Debug
## $DebugPreference="Continue"

$siteCode='030'
$OS_Type='-' + $OS
echo OS_Type=$OS_Type

if ($OS -eq "Linux") {
   $osCode='s'
}
else
{
   $osCode='m'
}

$VmName = $business_unit_code + $siteCode + $osCode + $ServerNumber

echo VmName=$VmName

# Define a credential object to store the username and password to connect to Azure
$AzureUserName='jscurep@jci.com'
$AzurePassword='HwEd1ttywsL@@F'| ConvertTo-SecureString -Force -AsPlainText
$Azure_Credential=New-Object PSCredential($AzureUserName,$AzurePassword)

## Azure Account info
$ResourceGroupName = "rg-bh-corp-msdn-001"
$storageAccountName = "rgbhcorpmsdn001disks371"

Connect-AzureRmAccount -Credential $Azure_Credential

# Define a credential object to store the username and password for the virtual machine
$UserName='pscurek'
$Password='HwEd1ttywsL@@F'| ConvertTo-SecureString -Force -AsPlainText
$Credential=New-Object PSCredential($UserName,$Password)

# Create the virtual machine configuration object

# Exit script if a virtual machine exists with the same name
### $VM_Exists = Get-AzureRMVM -Name $VMName -ResourceGroupName $ResourceGroupName
### if ($VM_Exists) { 
### Write-Host "A VM named $VMName already exists, Exiting script"
### exit }

### if ($VM_Exists) { 
### Write-Host "A VM named $VMName already exists"
### Remove-AzureRmVM -ResourceGroupName $ResourceGroupName -Name $vmName }

echo New-AzureRmConfig
echo VmName=$VmName
echo VmSize=$VmSize

$VirtualMachine = New-AzureRmVMConfig `
   -VMName $VmName `
   -VMSize $VmSize

if ($OS -eq 'Windows') {
   $VirtualMachine = Set-AzureRmVMOperatingSystem `
     -VM $VirtualMachine `
     -Windows `
     -ComputerName $VmName `
     -Credential $Credential

$offer='RHEL'
$skus='7.2'
$publisher='RedHat'

echo $offer $skus $publisher

   $VirtualMachine = Set-AzureRmVMSourceImage `
     -VM $VirtualMachine `
     -PublisherName "MicrosoftWindowsServer" `
     -Offer "Windows" `
     -Skus "2016-Datacenter" `
     -Version "latest"
}
else
{
   $VirtualMachine = Set-AzureRmVMOperatingSystem `
     -VM $VirtualMachine `
     -Linux `
     -ComputerName $VmName `
     -Credential $Credential

   $VirtualMachine = Set-AzureRmVMSourceImage `
     -VM $VirtualMachine `
     -PublisherName $publisher `
     -Offer $offer `
     -Skus $skus `
     -Version "latest"
}



$osDiskName = $VmName + "_OsDisk"
$StorageAccount = Get-AzureRmStorageAccount -Name $storageAccountName -ResourceGroupName $ResourceGroupName
$osDiskUri = $StorageAccount.PrimaryEndpoints.Blob.ToString() + "vhds/" + $vmName + $osDiskName  + ".vhd"

$NICName = $VmName + "376"
$Nic = New-AzureRmNetworkInterface -Name $NICName -ResourceGroupName $ResourceGroupName -Location $LocationName -SubnetId "/subscriptions/32ed6935-355d-4b62-8e63-1901e62882c9/resourceGroups/rg-network-msdn-002/providers/Microsoft.Network/virtualNetworks/vnet-msdn-003/subnets/snet-msdn-eastus2-002" 

# Sets the operating system disk properties on a virtual machine. 
$VirtualMachine = Set-AzureRmVMOSDisk `
  -VM $VirtualMachine `
  -Name $osDiskName `
  -VhdUri $OsDiskUri `
  -CreateOption FromImage

# Sets the data properties on a virtual machine.
if ( $DataDiskSize -ne 0 )
{
$DataDiskVhdUri01 = $StorageAccount.PrimaryEndpoints.Blob.ToString() + "vhds/" + $vmName + "data1.vhd"
$VirtualMachine = Add-AzureRmVMDataDisk -VM $VirtualMachine -Name 'DataDisk1' -Caching 'ReadOnly' -DiskSizeInGB $DataDiskSize -Lun 0 -VhdUri $DataDiskVhdUri01 -CreateOption Empty 
}
# Sets the NIC properties on a virtual machine.
$VirtualMachine = Add-AzureRmVMNetworkInterface -VM $VirtualMachine -Id $Nic.Id 

# Create the virtual machine.
New-AzureRmVM `
  -ResourceGroupName $ResourceGroupName `
  -Location $LocationName `
  -VM $VirtualMachine


if ( $? -eq "True" )
{

   # Retrieve IP address of primary NIC
   $IP = (Get-AzureRmNetworkInterface -Name $NICName -ResourceGroupName $ResourceGroupName).IpConfigurations.PrivateIpAddress

  # clear
   echo ============================================
   echo "IP address for $VMName is : $IP"
   echo ============================================
}
else
{
  # clear
   echo ============================================
   echo "There was and Error creating $VMName"
   echo ============================================
  # Invoke-MySqlQuery  -Query "UPDATE servername_pool SET status='A' WHERE name = '$ServerNumber'"
}
# Logout of Azure
Disconnect-AzureRmAccount