<?php
    
    require("../includes/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_POST["symbol"]))
        {
            apologize("enter a symbol");
        }
        if(empty($_POST["shares"]) || !is_numeric($_POST["shares"]) || !preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("enter number of shares you want to buy");
        }
        
        $stock = lookup($_POST["symbol"]);
        
        
        if($stock === false)
        {
            apologize("enter a valid stock symbol");
        }
        else
        {
              $value = $stock["price"] * $_POST["shares"];
            
            $rows = query("SELECT cash FROM users WHERE id = ?" , $_SESSION["id"]);
            
            // Check the amount of cash
            if ($rows[0]["cash"] < $value)
            {
                apologize("You don't have sufficient amount of deposited money.");
            }
            else
            {
                // Insert the bought stock into database
                $query = query("INSERT INTO stocks(id, symbol, shares) VALUES (?, ?, ?)
                    ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)"
                    ,$_SESSION["id"], strtoupper($stock["symbol"]), $_POST["shares"]);
                if ($query === false)
                {
                    apologize("Error while buying shares.");
                }
                
                // Update the user's cash
                $query = query("UPDATE users SET cash = cash - ? where id = ?", $value, $_SESSION["id"]);
                if ($query === false)
                {
                    apologize("Error while buying shares.");
                }
              
                //$_SESSION["cash"] -= $value;
                
                // Log the history
                $query = query("INSERT INTO history(id, type, symbol, shares, price, date) VALUES (?, ?, ?, ?, ?, Now())"
                    ,$_SESSION["id"], 1, strtoupper($_POST["symbol"]), $_POST["shares"], $stock["price"]);
                
                // Redirect to home
                redirect("/");
            }
        }
        
    }
    else
    {
        render("buy_form.php" , ["title"=>"buy"]);
    }

?>
