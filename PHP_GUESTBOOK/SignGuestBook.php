<?php

	echo " <h2>Sign Guest Book</h2><br><br> ";
	
	// function to check if there are blank space in the field
	
	 if (empty($_POST['fname']) || empty($_POST['last_name']))
	 {	 
		 echo "You must enter your first and last name! Click your browser's Back button to return to the Guest Book form.";
		 
	 } else {
		 
		//create connection to database with ( servername , username, and password)
        $DBConnect = mysql_connect("localhost", "root","");
		
        if ($DBConnect === FALSE)
		{
			// if error
			echo "Unable to connect to the database server." . "Error code " . mysql_errno() . ": " . mysql_error() . "";
		} else
		{
			// Name of Database
            $DBName = "guestbook";
			
			// this function is to check wheater guestbook db is exist or no create
			if ( !mysql_select_db($DBName, $DBConnect)) 
			{
				$SQLstring = "CREATE DATABASE $DBName";
				$QueryResult = mysql_query($SQLstring);
			
				if ($QueryResult === FALSE)
				{
                    echo "Unable to execute the query." . "Error code " . mysql_errno($DBConnect) . ": " . mysql_error($DBConnect) . "";
				} else
				{
                    echo "You are the ﬁrst visitor!";
                }
			}
			
			mysql_select_db("$DBName");
			
			
			// Select Table or create it
			$TableName = "visitors";
			$SQLstring = "SHOW TABLES LIKE '$TableName'";
			$QueryResult = mysql_query($SQLstring);
			if (mysql_num_rows($QueryResult) == 0) 
			{
				$SQLstring = "CREATE TABLE $TableName (countID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, last_name VARCHAR(40), first_name VARCHAR(40))";
				$QueryResult = mysql_query($SQLstring);
				if ($QueryResult === FALSE)
				{
                     echo "Unable to create the table." . "Error code " . mysql_errno($DBConnect) . ": " . mysql_error($DBConnect) . "";
				}
			}
			
			
			$LastName = stripslashes($_POST['last_name']);
            $FirstName = stripslashes($_POST['fname']);
            $SQLstring = "INSERT INTO $TableName VALUES(NULL, '$LastName','$FirstName')";
            $QueryResult = mysql_query($SQLstring);
            
			if ($QueryResult === FALSE)
			{
                echo "Unable to execute the query." . "Error code " . mysql_errno($DBConnect) . ": " . mysql_error($DBConnect) . "";
			} else
			{
				echo "Thank you for signing our guest book!";
			}
			
			mysql_close($DBConnect);
		}
	}
	
	
?>