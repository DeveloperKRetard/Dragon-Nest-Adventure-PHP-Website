<?php
ob_start();
session_start();
include "index.php";
$myServer = "127.0.0.1,1433";
$myUser = "DragonNest";
$myPass = "uZBfDg7e6LZxZfM";
$DBaccount = "dnmembership";

$name = $_POST['username'];
$pass = $_POST['password'];

$s = @mssql_connect( $myServer, $myUser, $myPass ) or die ();
$d = @mssql_select_db($DBaccount, $s) or die ();
if (!$s)
  {
  die('Could not connect: ' . mysql_error());
}

mssql_query("SET ANSI_NULLS ON");
mssql_query("SET QUOTED_IDENTIFIER ON");
mssql_query("SET CONCAT_NULL_YIELDS_NULL ON");
mssql_query("SET ANSI_WARNINGS ON");
mssql_query("SET ANSI_PADDING ON");

$result = mssql_query("exec DNMembership.dbo.DN_login_html N'$name',N'$pass'");
$info=mssql_fetch_array($result);
$LoginResult=$info[LoginResult];

if ($LoginResult==1){

	$result = mssql_query("SELECT AccountID FROM Accounts WHERE AccountName='$name'");
	
	$exist = mssql_num_rows($result);
	if($exist <= 0){
    echo "<script>
        Swal.fire({
            title: 'Success',
            text: 'Login Success',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
	exit();}
	
	$info=mssql_fetch_array($result);
	$AccountID=$info[AccountID];
	mssql_close();
	
	$_SESSION['AccountID']=$AccountID;
echo "<script>
       Swal.fire({
            title: 'Success',
            text: 'Login Success!',
            icon: 'success',
            showConfirmButton: true
        }).then((result) => {
		 window.location='/user';
		});</script>";
exit();}

if ($LoginResult==5){
echo "<script>
        Swal.fire({
            title: 'Warning',
            text: 'Wrong Username or Password!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
	exit();}

echo "<script>
       Swal.fire({
            title: 'Warning',
            text: 'Unknown Error!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
?>