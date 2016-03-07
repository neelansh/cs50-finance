<?php
    
    
    require("../includes/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {  
        if(empty($_POST["oldpassword"]))
        {
            apologize("enter old password");
        }
        
        $query = query("SELECT * FROM users WHERE id = ?" , $_SESSION["id"]);
        if($query === false)
        {
            apologize("somthing went wrong");
        }
        
        if(crypt($_POST["oldpassword"] , $query[0]["hash"]) != $query[0]["hash"])
        {
            apologize("you entered wrong password");
        }
        
        if(empty($_POST["password"]))
        {
            apologize("enter new password");
        }
        if(empty($_POST["confirmation"]))
        {
            apologize("enter confirmation");
        }
        
        if($_POST["password"] != $_POST["confirmation"])
        {
            apologize("pasword does not match");
        }
        
        if(query("UPDATE users SET hash = ( ? ) WHERE id = ( ? )", crypt($_POST["password"]),$_SESSION["id"]) === false)
            apologize("Sorry, some internal error occurred.");
        else
            redirect("index.php");
        
        
    }
    else
    {
        render("changepass_form.php" , ["title"=>"Change Password"]);
    }
?>
