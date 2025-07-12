<?php
//Importa CSV para MySql - Descontos

	//connect to the database 
	$connect = mysqli_connect("localhost","simposi1_certificados","6GcGKC@r6kBD","simposi1_certificados"); 
	//mysqli_select_db("asbairsc_certificados",$connect); //select the table 

	mysqli_query($connect, "DELETE FROM certificado_2024");
	// 

	    //get the csv file 
	    $file = 'certificados.csv'; 
	    $handle = fopen($file,"r"); 
	     
	    //loop through the csv file and insert into database 
	    do { 
	        if ($data[0]) { 
				
	            if($data[0] > 0):
	        		$codeCurso == addslashes($data[0]).'<br>';
	        	endif;
	
				echo addslashes($data[0]).'<br>';
	            echo addslashes($data[1]).'<br>';
	            echo addslashes($data[2]).'<br>';
	            echo addslashes($data[3]).'<br>';
	            echo addslashes($data[4]).'<br>';	 
			
	            mysqli_query($connect, "INSERT INTO certificado (nome, email, cpf, status) VALUES 
	                ( 
	                    '".addslashes(preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($data[0]))))."',
	                    '".addslashes($data[1])."',
	                    '".addslashes(preg_replace( '#[^0-9]#', '', $data[2] ))."',
	                    '1'
	                ) 
	            "); 

	        } 
	    } while ($data = fgetcsv($handle,1000,',','"')); 

?>

