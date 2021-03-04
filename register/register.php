<?php
include "index.php";
$myServer = "127.0.0.1,1433";
$myUser = "DragonNest";
$myPass = "uZBfDg7e6LZxZfM";
$DBaccount = "dnmembership";

$name = $_POST['username'];
$pass = $_POST['password'];
$mail = $_POST['mail'];

$str_len1 = strlen($name);
$str_len2 = strlen($pass);

$s=null;
$d=null;
$s = @mssql_connect( $myServer, $myUser, $myPass ) or die();
$d = @mssql_select_db($DBaccount, $s) or die();

$checkuser = mssql_query("SELECT AccountName FROM Accounts WHERE AccountName='$name'");
$name_exist = mssql_num_rows($checkuser);

$checkmail = mssql_query("SELECT AccountName FROM Accounts WHERE Email='$mail'");
$mail_exist = mssql_num_rows($checkmail);

if($mail_exist > 0){	
    echo "<script>
        Swal.fire({
		    icon: 'error',
            title: 'Registration Error',
            text: 'Email $mail is already Taken!',
			showConfirmButton: false,
			timer: 2000
        }).then((result) => {
		 window.history.back();
		});</script>";
exit();}

if($name_exist > 0){	
    echo "<script>
        Swal.fire({
		    icon: 'error',
            title: 'Registration Error',
            text: 'Username $name is already Taken!',
			showConfirmButton: false,
			timer: 2000
        }).then((result) => {
		 window.history.back();
		});</script>";
exit();}

if (!preg_match("#[_a-z0-9]{1,20}@[_a-z0-9]{1,20}\.[_a-z0-9]{1,4}#i", $mail)){
    echo "<script>
        Swal.fire({
            title: 'Warning',
            text: 'Please match the requested Format!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
exit();}

if (!preg_match("#^[a-z0-9]+$#i", $name)){
    echo "<script>
        Swal.fire({
            title: 'Warning',
            text: 'Please match the requested Format!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
exit();}

if (preg_match("#[='\"]|true|false+#i", $pass)){
    echo "<script>
        Swal.fire({
            title: 'Warning',
            text: 'Please match the requested Format!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
exit();}

if ($str_len1 < 6){
    echo "<script>
        Swal.fire({
            title: 'Warning',
            text: 'Username is too short!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
exit();}

if ($str_len2 < 6){
    echo "<script>
        Swal.fire({
            title: 'Warning',
            text: 'Password is too short!',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
		 window.history.back();
		});</script>";
exit();}

mssql_query("SET ANSI_NULLS ON");
mssql_query("SET QUOTED_IDENTIFIER ON");
mssql_query("SET CONCAT_NULL_YIELDS_NULL ON");
mssql_query("SET ANSI_WARNINGS ON");
mssql_query("SET ANSI_PADDING ON");


$sql = "exec DNMembership.dbo.__CreateAccount '$name','$pass', '0', '$mail'";
mssql_query($sql);

$result = mssql_query("SELECT cash FROM Accounts WHERE AccountName='$name'");

if(! $result) {
 die('Could not connect: ' . mssql_error());
}

while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
 $cash = $row['cash'];
}

mssql_close();
echo "<script>
        Swal.fire({
		    icon: 'success',
            title: 'Registration Success!',
            text: 'User $name receives $cash cash!',
			showCancelButton: false,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'close'
            }).then((result) => {
			if (result.isConfirmed) {
		Swal.fire({
	        showConfirmButton: false,
			timer: 1
        })
  }
        }).then((result) => {
		 window.history.back();
	});</script>";
?>