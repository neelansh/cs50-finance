<?php
    require("../includes/config.php");

    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_POST["symbol"]))
        {
            apologize("enter valid symbol");
        }
        
        $stock = lookup($_POST["symbol"]);
        if($stock === false)
        {
            apologize("invalid symbol entered");
        }
        else
        {
            $rows = query("SELECT shares FROM stocks WHERE id = ? and symbol = ?", $_SESSION["id"], strtoupper($_POST["symbol"]));
            if (count($rows) == 1)
            {
                $stocks = $rows[0]["shares"];
            }
            else
            {
                apologize("Shares for specified symbol not found.");
            }
        
            $value = $stock["price"] * $stocks;
            
            // Delete the user stocks
            $query = query("DELETE FROM stocks where id = ? and symbol = ?", $_SESSION["id"], strtoupper($_POST["symbol"]));
            if ($query === false)
            {
                apologize("Error while selling shares.");
            }
            
            // Update users cash
            $query = query("UPDATE users SET cash = cash + ? where id = ?", $value, $_SESSION["id"]);
            if ($query === false)
            {
               apologize("Error while selling shares.");
            }
            
            //$row = query("SELECT cash FROM users WHERE id = ?" , $_SESSION["id"]);
            
            //$_SESSION["cash"] += $value;
           
            // Log the history
            $query = query("INSERT INTO history(id, type, symbol, shares, price, date) VALUES (?, ?, ?, ?, ?, Now())"
                ,$_SESSION["id"], 0, strtoupper($_POST["symbol"]), $stocks, $stock["price"]);
                //if($query == false)
                //{
                 //   apologize("history not logged in ");
                //}
            
            // Redirect to home
            redirect("/");
        
        }
    }
    else
    {
    
        $rows = query("SELECT symbol FROM stocks WHERE id = ?" , $_SESSION["id"]);
        render("sell_form.php" , ["title" => "sell" , "symbols"=>$rows]);
    }





?>
