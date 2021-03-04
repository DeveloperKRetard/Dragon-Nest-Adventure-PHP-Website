<?PHP
error_reporting(0);
ini_set('display_errors',0);
$DB_HOST="127.0.0.1,1433";
$DB_USER = "DragonNest";
$DB_PASSWORD="uZBfDg7e6LZxZfM";

$id = $_POST['id'];
$password= $_POST['password'];

if(isset($id))
{

mssql_connect($DB_HOST,$DB_USER,$DB_PASSWORD);
mssql_select_db("DNMembership");
$exists = mssql_query("select AccountID from dbo.Accounts where AccountName = '$id'"); 
if(mssql_num_rows($exists) > 0 )
{
	$exists = mssql_query("select AccountID from dbo.Accounts where AccountName = '$id' and RLKTPassword = '$password'"); 
	if(mssql_num_rows($exists) > 0 )
{
	echo 'S000	OK	0';
}
else
{
	
	echo 'E203	OK	0';
}
	
	
}
else
{
	echo 'E202	OK	0';
	
}

}
else
{
	echo 'E205  OK 0';
}
?>

