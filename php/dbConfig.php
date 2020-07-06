	<?php
	//connect to to server and database
	$ser="fdb12.biz.nf";
	$user="2240214_blog";
	$pass="parglonfo2";
	$db="2240214_blog";
	$port="3306";

	$con = new mysqli($ser, $user, $pass, $db, $port) or die("Connection Failed");