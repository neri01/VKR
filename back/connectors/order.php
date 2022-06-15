<?php
require_once("sql_bd.php");
require_once("bitrix.php");

if (!check_user($_POST["phone"],$_POST["hash"]))
{exit;}

$price=0;
$prods_ID = json_decode($_POST['products']);
$prods_QUA = json_decode($_POST['products_quantity']);
$products = array();

$add_log='';

for($i=0;$i<count($prods_ID);$i++) {
     $cur = b24("crm.product.get",array("id"=>$prods_ID[$i]));
    $products[] = Array(
        "PRODUCT_ID"=>(int)$prods_ID[$i],
        "sql_name"=>$cur["result"]["NAME"],
        "PRICE"=> $cur["result"]["PRICE"],
        "QUANTITY"=> (int)$prods_QUA[$i],
    );
    $price+=$cur["result"]["PRICE"]*(int)$prods_QUA[$i];
}



$query_contact = array(
    "fields" => array(
            "NAME"=> $_POST["name"],
            "SECOND_NAME"=> $_POST["second_name"],
            "LAST_NAME"=> $_POST["last_name"],
            "OPENED"=> "Y",
            "ASSIGNED_BY_ID"=> 1,
            "TYPE_ID"=> "CLIENT",
            "PHONE"=> array("n0" => array("VALUE"=> string_to_phone($_POST["phone"]), "VALUE_TYPE"=> "MOBILE"),),
    ),
);

$contact = b24("crm.contact.add",$query_contact);

/*
$query_contact_add = array(
    "id" => json_encode($deal["result"]),
    "fields" => array(
        "CONTACT_ID"=>json_encode($contact["result"]),
    ),
);
*/
$query = array(
    "fields" => array(
        "COMMENT"=> $_POST["comment"],
        "CONTACT_ID"=> json_encode($contact["result"]),
        "OPENED"=> "Y",
        "TITLE" => "заказ",
    ),
    'params' => array("REGISTER_SONET_EVENT" => "Y"),
);

$deal = b24("crm.deal.add",$query);

$file = fopen("logger.txt", "a");
fwrite($file,"\n".json_encode($contact)."\n".json_encode($deal)."\n".$_POST["phone"]."\n".json_encode($products));
fclose($file);

$query = array(
    "id"=>json_encode($deal["result"]),
    "rows"=>$products,
);

$ret = b24("crm.deal.productrows.set",$query);

//-------------------------save in history---------------------------------------------------------------

$data = sql_request("SELECT * FROM `users` where phone = '" . $_POST['phone'] . "'");

foreach ($data as $row) {
    $user_id=$row["user_id"];
}

sql_request("INSERT INTO `history` (`date`, `ID_user`, `price`, `id`) 
                        VALUES (NOW(), '".$user_id."', '".$price."', NULL)");

$data = sql_request("SELECT * FROM `history` ORDER BY id DESC LIMIT 1");
foreach ($data as $row) {
    $buy_id=$row["id"];
}

//----


$file = fopen("logger.txt", "a");
fwrite($file,"\n".$buy_id."\n".$user_id."\n".json_encode($prods_ID)."\n");
fclose($file);

for($i=0;$i<count($prods_ID);$i++) {

    sql_request("INSERT INTO `purchases` (`buy_id`, `id`, `product_name`, `quantity`) 
                    VALUES ('".$buy_id."', NULL, '".$products[$i]["sql_name"]."', '".(int)$prods_QUA[$i]."')");
}


