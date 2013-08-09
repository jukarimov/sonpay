<?php
session_start();

if (isset($_POST['state'])) {
	if($_POST['state'] == 'open')
		$_SESSION['chat'] = 'open';
	else
		$_SESSION['chat'] = 'hidden';
}

if (isset($_GET['state'])) {

	if (isset($_SESSION['chat']))
		echo $_SESSION['chat'];

}

?>
