Import-Module -Name AzureRM

$AzureUserName='jscurep@jci.com'
$AzurePassword='HwEd1ttywsL@@F'| ConvertTo-SecureString -Force -AsPlainText
$Azure_Credential=New-Object PSCredential($AzureUserName,$AzurePassword)

## Azure Account info
$ResourceGroupName = "rg-bh-corp-msdn-001"
$storageAccountName = "rgbhcorpmsdn001disks371"

Connect-AzureRmAccount -Credential $Azure_Credential

Get-AzureRmVMImageSku

# Get-AzureRmVMImageOffer

