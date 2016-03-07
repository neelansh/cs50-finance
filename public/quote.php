<?php
    
  require("../includes/config.php");
  
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(empty($_POST["symbol"]))
    {
        apologize("enter a symbol");
    }
    else
    {
        $stock = lookup($_POST["symbol"]);
        
        if($stock === false)
        {
            apologize("entered symbol not found");
        }
        else
        {
            render("quote.php" , ["name" => $stock["name"] , "symbol" => $stock["symbol"] , "price" => $stock["price"]]);
        }
    }
    
  }  
  else
  {
    render("quote_form.php");
  }   
    

?>
