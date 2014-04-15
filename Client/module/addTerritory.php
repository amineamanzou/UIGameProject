<?php
	session_start();
    $db = mysql_connect('localhost', 'root', 'root');
    mysql_select_db('UIGameProject',$db);


	$sql = "INSERT INTO pos_territoires(x,y,larg,longu) 
			VALUES (".$_GET['x'].",".$_GET['y'].",".$_GET['larg'].",".$_GET['longu'].")";
    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>