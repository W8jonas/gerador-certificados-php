<?php

function OpenCon()
{
	//$dbhost = "localhost";
	//$dbuser = "agenciami_certificados";
	//$dbpass = "lm5#z4?^i?=b";
	//$dbname = "agenciami_certificados";

	$dbhost = "localhost";
	$dbuser = "simposi1_certificados";
	$dbpass = "6GcGKC@r6kBD";
	$dbname = "simposi1_certificados";

	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("Erro de conexão com banco de dados: %s\n" . $conn->error);

	return $conn;
}

function CloseCon($conn)
{
	$conn->close();
}