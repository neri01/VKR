<?php
include "sql_bd.php";

function history_search($buying,$price){
    sql_request("    INSERT 
                         INTO   `history` (`date`, `buying`, `price`, `id`) 
                         VALUES (.date('Y-f-d')., .$buying., .$price., NULL)");
}