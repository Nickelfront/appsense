<?php

if (!$_SESSION['loggedIn']) {
	header("location: forbidden.php");	
}
// session_start();
