<?php
			
			
			$file = 'pizzeria.xml';
			$xml = simplexml_load_file($file);
			
			if($_POST['item'] == 'pizza'){
				$pid = $_POST['pid'];
				$pname = $_POST['pname'];
				$desc = $_POST['desc'];
				$units = array();
	
				$units = $_POST['units'];
				$count = 0;
				
				foreach($xml->menu->pizza as $node){
					if($node['id']  == $pid ) {
						$node->name = $pname;
						$node->description = $desc;
						foreach($node->ingredient as $ing){
							$ing['units'] = $units[$count];
							$count++;
						}
						break;
					}
				}
			}
			else if($_POST['item'] == 'ingredient'){
			
				
				$name = $_POST['name'];
				$instorage = $_POST['instorage'];
				$iid = $_POST['iid'];
								
				foreach($xml->storage->ingredient as $node){
					if($node['id']  == $iid ) {
						$node['name'] = $name;
						$node['in_storage'] = $instorage;
						break;
					}
				}
			
			}
			file_put_contents($file, $xml->asXML());
			
			
?>