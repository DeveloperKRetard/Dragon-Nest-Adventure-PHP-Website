<?php
include "index.php";
$myServer = "127.0.0.1,1433";
$myUser = "DragonNest";
$myPass = "uZBfDg7e6LZxZfM";
$DBaccount = "dnmembership";

$name = $_POST['username'];
$pass = $_POST['password'];

$s=null;
$d=null;
$s = @mssql_connect( $myServer, $myUser, $myPass ) or die();
$d = @mssql_select_db($DBaccount, $s) or die();

$checkuser = mssql_query("SELECT AccountName FROM Accounts WHERE AccountName='$name'");
$name_exist = mssql_num_rows($checkuser);

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

mssql_query("SET ANSI_NULLS ON");
mssql_query("SET QUOTED_IDENTIFIER ON");
mssql_query("SET CONCAT_NULL_YIELDS_NULL ON");
mssql_query("SET ANSI_WARNINGS ON");
mssql_query("SET ANSI_PADDING ON");

$cash = 500000;
$sql = "exec DNMembership.dbo.__CreateAccount '$name','$pass'";
mssql_query($sql);
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