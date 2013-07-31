<?

$connectionString	= 'mysql:dbname=mydb;host=localhost';
$dbuser 		= 'root';
$dbpassword		= 'root';

$db = new PDO($connectionString, $dbuser, $dbpassword, array(
	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
));

?>
