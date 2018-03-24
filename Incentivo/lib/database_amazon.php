<?

//$db_host        = "10.0.28.80";
$db_host        = "kch-1ano-sql-de.czvz6jrh66tt.us-west-2.rds.amazonaws.com";
$db_name        = "DB_Informe_Gestion";
$db_username    = "master_user";
$db_password    = "komatsu2016";

	//$am=mssql_connect($db_host,$db_username,$db_password);
	//mssql_select_db($db_name) or die (error_conexion);

	$pdoAws = new PDO('sqlsrv:Server=' . $db_host . ';Database='. $db_name,$db_username,$db_password);

	if($pdoAws == null)
		die (error_conexion);

?>
