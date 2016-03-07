<?php

    // configuration
    require("../includes/config.php"); 

    // render portfolio
    //render("portfolio.php", ["title" => "Portfolio"]);
    
    $rows = query("SELECT * FROM stocks WHERE id = ?" , $_SESSION["id"]);
    $rows2 = query("SELECT cash FROM users WHERE id = ?" , $_SESSION["id"]);
    //echo($rows2);
    $stocks = [];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $stocks[] = [
            "name" => $stock["name"],
            "price" => $stock["price"],
            "shares" => $row["shares"],
            "symbol" => $row["symbol"]
            ];
        }
    }
    
    render("portfolio.php" , ["title" => "portfolio" ,"cash" => $rows2[0]["cash"],"stocks" => $stocks]);

?>
