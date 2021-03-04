<?php 
error_reporting(0);
ini_set('display_errors', 0);
$DB_HOST="127.0.0.1,1433";
$DB_USER = "DragonNest";
$DB_PASSWORD="uZBfDg7e6LZxZfM";

function MakeResponse($status,$user,$balance)
{
//{"RESULT-CODE":"S000","RESULT-MESSAGE":"Success","SID":"DRNEST","CN":"44820790","UID":"kreondn0001","CASH-BALANCE":100000}

	$arr["RESULT-CODE"] =$status;
	$arr["RESULT-MESSAGE"] ="Success";
	$arr["SID"] ="DRNEST";
	$arr["CN"] ="44820790";
	$arr["UID"] = $user;
	$arr["CASH-BALANCE"] = $balance;
	
	return json_encode($arr);
}

function GetBalance($user)
{
		mssql_query('SET ANSI_NULLS ON');
        mssql_query('SET ANSI_PADDING ON');
        mssql_query('SET ANSI_WARNINGS ON');
        mssql_query('SET ARITHABORT ON');
        mssql_query('SET CONCAT_NULL_YIELDS_NULL ON');
        mssql_query('SET QUOTED_IDENTIFIER ON');
		$stmt = mssql_init('P_GetCashBalance');
		$balance=0;
		// Bind values
		mssql_bind($stmt, '@nvcAccountName',    $id,  SQLVARCHAR,     false,  false,   18);
		mssql_bind($stmt, '@intCashBalance',    $balance,  SQLINT4,     true);

		// Execute the statement
		mssql_execute($stmt);

		// And we can free it like so:
		mssql_free_statement($stmt);
		return $balance;
}

function SetBalance($user,$amout)
{
		mssql_query('SET ANSI_NULLS ON');
        mssql_query('SET ANSI_PADDING ON');
        mssql_query('SET ANSI_WARNINGS ON');
        mssql_query('SET ARITHABORT ON');
        mssql_query('SET CONCAT_NULL_YIELDS_NULL ON');
        mssql_query('SET QUOTED_IDENTIFIER ON');
		$stmt = mssql_init('__NX__UpdateCashBalance');
		$balance=0;
		// Bind values
		mssql_bind($stmt, '@nvcAccountName',    $user,  SQLVARCHAR,     false,  false,   50);
		mssql_bind($stmt, '@intUpdateCash',    $amout,  SQLINT4,     false);
		mssql_bind($stmt, '@intRemainCash',    $balance,  SQLINT4,     true);

		// Execute the statement
		mssql_execute($stmt);

		// And we can free it like so:
		mssql_free_statement($stmt);
		return $balance;
}

$id = $_POST['BUYER-ID']; 
$total = $_POST['TOTAL-PRICE'];

if(isset($id) && isset($total)) {
mssql_connect($DB_HOST,$DB_USER,$DB_PASSWORD); 
mssql_select_db("DNMembership"); //ip .. others 
$exists = mssql_query("Select AccountID from dbo.Accounts where AccountName='$id'");
    if(mssql_num_rows($exists) > 0)
    {
		$balance = GetBalance($id);
		if($balance-$total < 0)
		{
			echo MakeResponse("E402",$id,$balance);
		}else{
			$leftbalance = SetBalance($id,-$total);
			echo MakeResponse("S000",$id,$leftbalance);
		}
    }
	else{
		echo MakeResponse("E301",$id,0);
	}
}

?>