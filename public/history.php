<?php
    require("../includes/config.php");
    
    $rows = query("SELECT CASE WHEN type = 0 THEN 'SELL' ELSE 'BUY' END action , symbol,shares, price , date FROM history WHERE id = ? order by date desc", $_SESSION["id"]);    

    if(count($rows) == 0)
    {
        apologize("no history to display");
    }
    
    render("history.php" , ["title"=>"history" , "history"=>$rows]);
?>
