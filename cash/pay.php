<?PHP
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

$id = $_POST['BUYER-ID'];
echo MakeResponse("S000",$id,123);



?>