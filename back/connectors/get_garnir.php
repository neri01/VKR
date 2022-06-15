<?php
    include 'sql_bd.php';
    $data = sql_request("SELECT * FROM `first`");
    $i = -1;
    foreach($data as $row){
        $i = $i+1;
        $obj[$i]["name"] = $row["name"];
        $obj[$i]["price"] = $row["price"];
        $obj[$i]["ingridient"] = $row["ingridient"];
        $obj[$i]["mass"] = $row["mass"];
        $obj[$i]["img"] = $row["img"];
    }
    echo json_encode($obj);

    ?>

