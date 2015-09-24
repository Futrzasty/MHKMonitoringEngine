<?php

        include_once "config.php";

        $dbhandle = mssql_connect($dbhost[1], $dbuser[1], $dbpass[1])
                or die("Couldn't connect to SQL Server on $dbhost[1]");
        $selected = mssql_select_db($dbname[1], $dbhandle)
                or die("Couldn't open database $dbname[1]");

        $argc = explode(";", $_SERVER["QUERY_STRING"]);
        $argv = count($argc);
        $alias = $argc[0];

//        $query = "SELECT * FROM [dbo].[Resources] WHERE Type = 8 AND ResourceType = 10";
        $query = "SELECT [DetailedRoomDescription], [Resources].[Name], [Locations].[Name] AS Street, [Impact]
  		  FROM [Resources]
		  INNER JOIN [Locations] 
		  ON [Resources].[Location1] = [Locations].[Id]
                  WHERE [FirstIpAddress] = '$alias' AND [ResourceType] IS NOT NULL;";

	$result = mssql_query($query);

	//$numRows = mssql_num_rows($result);
        $row = mssql_fetch_array($result);

	$output = array('Alias'  => $row["Street"]." - ".$row["DetailedRoomDescription"],
			'Name'   => $row["Name"],
			'Impact' => $row["Impact"],
		
	);
				
        mssql_close($dbhandle);

	echo json_encode($output);
?>
