<?php
include_once 'connection.php';

function errorAnalysis($stmt, $sqlquery){
    if(!mysqli_stmt_prepare($stmt, $sqlquery)){
        return "NOT PREPARED ".$stmt->error;
    }else{
        if(!mysqli_stmt_execute($stmt)){
            return "NOT EXECUTED ".$stmt->error;
        }
    }
}