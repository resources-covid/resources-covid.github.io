<?php
	if ($_SERVER["REQUEST_METHOD"]=="GET"  ) {
		function test_input($data) 
		{
			$data = trim($data);
			$data = stripslashes($data);
			//$data = htmlspecialchars($data);
			//$data = rawurldecode($data);
			return $data;
		}
		$state=test_input($_GET["s"]);
		$dist=test_input($_GET["d"]);
		$cat=test_input($_GET["c"]);
		$c=0;
		$store=array();
		$file=fopen("https://docs.google.com/spreadsheets/d/e/2PACX-1vRtdxhufm11xTC8jx050FfVT504TKIaR5gqls4TTaF6pldLn-WDCkrmTrr-XXVVQ8xGZXLzg9OK_P5X/pub?gid=2002740475&single=true&output=tsv","r");
		fgetcsv($file,0,"\t");
		while (!feof($file)) {
			$check=fgetcsv($file,0,"\t");
			if($check[0]==$state && $check[1]==$dist)
			{
				if($state=="Pan India") {
					if(trim($check[4])==$cat) {
						$flag=0;
						$check[2]=trim($check[2]);
						$check[3]=trim($check[3]);
						foreach($store as $x=>$val) {
							if($val==$check[3]) {
								$flag=1;
								break;
							}
						}
						if ($flag==0) {
							$c++;
							$store[$check[2]."!".$c]=$check[3];
						}
					}
				}
				else {
					if(count($check)>3)
					{
						$trans1=explode("$,",$check[2]);
						$trans2=explode("$,",$check[3]);
						$trans3=explode("$,",$check[4]);
						for ($i=0;$i<count($trans3);$i++) {
							if(trim($trans3[$i])==$cat) {
								$flag=0;
								$trans1[$i]=trim($trans1[$i]);
								$trans2[$i]=trim($trans2[$i]);
				
								foreach($store as $x=>$val) {
									if($val==$trans2[$i]) {
										$flag=1;
										break;
									}
								}
								if ($flag==0) {
									$c++;
									$store[$trans1[$i]."!".$c]=$trans2[$i];
								}
							}
						}
					}
					break;
				}
			}
		}
		if (!empty($store)) {
			$store=json_encode($store);
			echo $store;
		}
		else {
			return false;
		}
		fclose($file);
	}
?>
		
				
		