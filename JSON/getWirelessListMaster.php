<?php

        include_once "config.php";

        $dbhandle = mssql_connect($dbhost[1], $dbuser[1], $dbpass[1])
                or die("Couldn't connect to SQL Server on $dbhost[1]");
        $selected = mssql_select_db($dbname[1], $dbhandle)
                or die("Couldn't open database $dbname[1]");


//        $query = "SELECT * FROM [dbo].[Resources] WHERE Type = 8 AND ResourceType = 10";
        $query = "SELECT [FirstIpAddress]
  		  FROM [Resources]
                  WHERE [Resources].[Type] = 8 and [Resources].[Status] = 3 and [Resources].[ResourceType] = 7;";

	$result = mssql_query($query);

	//$numRows = mssql_num_rows($result);
        while($row = mssql_fetch_array($result)) {
		$output[] = $row["FirstIpAddress"];
        }

        mssql_close($dbhandle);

	echo json_encode($output);
?>
