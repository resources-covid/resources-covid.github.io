<?php
	if ($_SERVER["REQUEST_METHOD"]=="GET"  ) {
		function test_input($data) 
		{
			$data = trim($data);
			$data = stripslashes($data);
			//$data = htmlspecialchars($data);
			$data = rawurldecode($data);
			return $data;
		}
		$store=array();
		$c=0;
		$state=test_input($_GET["st"]);;
		$file=fopen("District_Name.tsv","r");
		while (!feof($file)) {
			$check=fgetcsv($file,0,"\t");
			if($state==$check[0]) {
				$store[$c]=$check[1];
			}
			$c++;
		}
		if (!empty($store)) {
			$store=json_encode($store);
			echo $store;
		}
		fclose($file);
	}
?>