<?php

        include_once "config.php";
	$dbi = 1;
	

        $dbhandle = mssql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi])
                or die("Couldn't connect to SQL Server on $dbhost[$dbi]");
        $selected = mssql_select_db($dbname[$dbi], $dbhandle)
                or die("Couldn't open database $dbname[$dbi]");

	$name_to_search = $_SERVER["QUERY_STRING"];
	$name_to_search = str_replace(array ("\"", "%22", ";"), "", $name_to_search);

	$name_to_search = rawurldecode($name_to_search);
	
//        $query = "SELECT * FROM [dbo].[Resources] WHERE Type = 8 AND ResourceType = 10";
        $query = "SELECT [LOG-SYSTEM].[dbo].[Resources].[Name], [Description], [LOG-SYSTEM].[dbo].[ResourceTypes].[Name] AS Typ, [Notice]
                  FROM [Resources]
                  INNER JOIN [LOG-SYSTEM].[dbo].ResourceTypes
                  ON [LOG-SYSTEM].[dbo].[Resources].[ResourceType] = [LOG-SYSTEM].[dbo].[ResourceTypes].[Id]
                  WHERE [Kind] = 'Computer' AND [HasAgent] = 1 AND [Resources].[Description] LIKE '%$name_to_search%';";

	$result = mssql_query($query);

	//$numRows = mssql_num_rows($result);
        while($row = mssql_fetch_array($result)) {
		$output[] = $row["Name"]." - ".$row["Description"]." (".$row["Typ"]." / ".$row["Notice"].")";
        }

        mssql_close($dbhandle);

	echo json_encode($output);
?>
