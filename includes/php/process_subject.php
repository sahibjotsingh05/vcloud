<?php
include_once 'connection.php';
if(isset($_SESSION['department'])){
    $sqlquery = 'SELECT name FROM department WHERE name !="'.$_SESSION['department'].'" ORDER BY id';
} else {
    $sqlquery = "SELECT name, id FROM department ORDER BY id";
}
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sqlquery)){
    echo "NOT PREPARED. :-".$stmt->error;
}else{
    if(!mysqli_stmt_execute($stmt)){
        echo "NOT EXECUTED. :-".$stmt->error;
    }else{
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result)>0){
            while($data = mysqli_fetch_assoc($result)){
                if(isset($_SESSION['department'])){
                    echo "<button class='subject aside_item margin' id='default' value=".$data['name'].">".ucwords(str_replace('_',' ',$data['name']))."</button>";
                } else {
                    echo "<option value=".$data['id'].">".ucwords(str_replace('_',' ',$data['name']))."</option>";
                }
            }
        }
    }
}
?>
