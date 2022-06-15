<?php
require_once('bitrix.php');
$sections = (b24("crm.productsection.list"));

foreach($sections["result"] as $section) {
    $i = -1;
    $data = b24("crm.product.list",
        array("filter" => array("SECTION_ID" => $section["ID"]),));

    foreach ($data["result"] as $row) {
        $i = $i + 1;
        $obj[$section["NAME"]][$i]["ID"] = $row["ID"];
        $obj[$section["NAME"]][$i]["name"] = $row["NAME"];
        $obj[$section["NAME"]][$i]["price"] = (int)$row["PRICE"];
        $obj[$section["NAME"]][$i]["ingridient"] = $row["DESCRIPTION"];

        $temp = b24("crm.product.get",array("id" => $row["ID"]));
        $obj[$section["NAME"]][$i]["mass"] = (int)$temp["result"]["PROPERTY_109"]["value"];
        $obj[$section["NAME"]][$i]["img"] = $temp["result"]["PROPERTY_107"]["value"];
    }

}

$data = b24("crm.product.list", array(
    "order" =>array("NAME" => "ASK"),
    "filter" => array("SECTION_ID" => $section["ID"]),
    "select" => array('*', 'PROPERTY_*')

    ));
echo decode_bitrix(json_encode($obj));
