<?
error_reporting(0);
ini_set('display_errors',0);
$DB_HOST="127.0.0.1,1433";
$DB_USER = "DragonNest";
$DB_PASSWORD="uZBfDg7e6LZxZfM";


function MakeResponse($status,$user,$balance)
{


    $arr["RESULT-CODE"]=$status;
    $arr["RESULT-MESSAGE"]="Success";
    $arr["SID"]="DRNEST";
    $arr["CN"]="44820790";
    $arr["UID"]=$user;
    $arr["CASH-BALANCE"] = $balance;
    return json_encode($arr);
    
}
$id = $_POST['UID'];
if(isset($id)) {
mssql_connect($DB_HOST,$DB_USER,$DB_PASSWORD); 
mssql_select_db("DNMembership"); //ip .. others 
$exists = mssql_query("Select AccountID from dbo.Accounts where AccountName='$id'");
    if(mssql_num_rows($exists) > 0)
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
		
		echo MakeResponse("S000",$id,$balance);

    }
	else{
		echo MakeResponse("E301",$id,$balance);
	}
}

?>