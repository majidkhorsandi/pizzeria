<?php
			
			
			$file = 'pizzeria.xml';
			
			$xml = simplexml_load_file($file);


        // This prints out each of the models
			
			$ids = 	$_REQUEST['ids'];	
			$OkOrder = false;
		
			 foreach($ids as $id){			
				foreach ($xml->menu->pizza as $node) {
					
					
					if ($node['id'] ==  $id){		
						foreach ($node->ingredient as $ing) {
							foreach($xml->storage->ingredient as $storeing){
								if ($ing['id'] == $storeing['id']){
									 $diff = (int)$storeing['in_storage'] - (int)$ing['units']; 
									 if ($diff >= 0){
									 	$storeing['in_storage'] = ($diff);
									 	
									 	$OkOrder = true;
									 } else{
									 	$OkOrder = false;
									 }
								}
							}
						}
						if ($OkOrder) $node->popularity = (int) $node->popularity + 1;	 		
					}
					 
				}
				
				
			} 
			
			//echo json_encode($OkOrder);
			include('./JSON.php');
			$json = new Services_JSON();
			echo $json->encode($OkOrder);			
			
			if ($OkOrder) file_put_contents($file, $xml->asXML());
			
			 

?>