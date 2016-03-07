<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
	    if(empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["conformation"]))
	    {
		    apologize("enter a username or password");
	    }
	    else if($_POST["password"] != $_POST["conformation"])
	    {
		    apologize("password and conformation does not match");
	    }
	    $rows = query("SELECT * FROM users WHERE username = ?" , $_POST["username"] );
	    
	    if(count($rows)==1)
	    {
		    apologize("username already exists");
	    }
        else
        {
            query("INSERT INTO users (username, hash, cash) VALUES(? , ? , 10000.00)" , $_POST["username"] , crypt($_POST["password"]));
            if($query === false)
            {
                apologize("could not register user");
            }
            else
            {
                $rows = query("SELECT LAST_INSERT_ID() AS id");
                
                if (count($rows) == 1)
                {
                    $id = $rows[0]["id"];
                    
                    $_SESSION["id"] = $id;
                    
                    
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["cash"] = $row["cash"];
                    
                    redirect("/");
                }
            }
            
        }    
    
		
    }

?>
