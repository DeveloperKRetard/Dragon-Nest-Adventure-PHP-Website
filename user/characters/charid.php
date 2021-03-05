<?php
$myServer = "127.0.0.1,1433";
$myUser = "DragonNest";
$myPass = "uZBfDg7e6LZxZfM";
$DBaccount = "dnworld";

$name = $_SESSION['AccountID'];

$s = @mssql_connect( $myServer, $myUser, $myPass ) or die ();
$d = @mssql_select_db($DBaccount, $s) or die ();
if (!$s)
  {
  die(mssql_error());
}

mssql_query("SET ANSI_NULLS ON");
mssql_query("SET QUOTED_IDENTIFIER ON");
mssql_query("SET CONCAT_NULL_YIELDS_NULL ON");
mssql_query("SET ANSI_WARNINGS ON");
mssql_query("SET ANSI_PADDING ON");

$result = mssql_query("SELECT CharacterID FROM Characters WHERE AccountID='$name'");

if(! $result) {
 die('Could not connect: ' . mssql_error());
}

while($row = mssql_fetch_array($result, MSSQL_ASSOC)){
 $CharacterID = $row['CharacterID'];
}

mssql_close();

$_SESSION['CharacterID']=$CharacterID;

?>