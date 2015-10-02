<?php

        include_once "config.php";
	$dbi = 1;
	

        $dbhandle = mssql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi])
                or die("Couldn't connect to SQL Server on $dbhost[$dbi]");
        $selected = mssql_select_db($dbname[$dbi], $dbhandle)
                or die("Couldn't open database $dbname[$dbi]");

	$name_to_search = $_SERVER["QUERY_STRING"];
	$name_to_search = str_replace(array ("\"", "%22", ";"), "", $name_to_search);


//        $query = "SELECT * FROM [dbo].[Resources] WHERE Type = 8 AND ResourceType = 10";
        $query = "SELECT [Description]
  		  FROM [Resources]
                  WHERE [Kind] = 'Computer' AND [Resources].[Name] LIKE '%$name_to_search' OR [Resources].[Name] LIKE '%$name_to_search.%';";

	$result = mssql_query($query);

	//$numRows = mssql_num_rows($result);
        while($row = mssql_fetch_array($result)) {
		$output[] = $row["Description"];
        }

        mssql_close($dbhandle);

	echo json_encode($output);
?>
