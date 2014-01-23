<?php
		
		$xmlDoc = new DOMDocument();
		$xmlDoc->formatOutput = true;
		$xmlDoc->load("pizzeria.xml");
		
		if($_POST) {
		
			if($_POST['item'] == 'pizza'){
		
				$allpizzas = 	$xmlDoc->getElementsByTagName("pizza");
			 	$maxID = 0;		
			 	foreach($allpizzas as $piz){
					$curID = (int)$piz->getAttribute('id');
					if($curID > $maxID) $maxID = $curID ; 
				}		
				$pizzaName = $_POST['pname'];
				$desc = $_POST['desc'];
				$ids = array();
				$names = array();
				$units = array();
				$ids = $_POST['ids'];
				$names = $_POST['names'];
				$units = $_POST['units'];
				
				//echo $pizzaName . ' ' . $desc . ' ' . $names ;
				
				$pizza = $xmlDoc->createElement("pizza");
				$name = $xmlDoc->createElement("name",$pizzaName);
				$pizza->appendChild($name);
				$pizza->appendChild($xmlDoc->createElement("description",$desc));
				$pizza->appendChild($xmlDoc->createElement("popularity",'0'));
				$newid = $xmlDoc->createAttribute('id');
				$newidText = $xmlDoc->createTextNode($maxID+1);
				$newid->appendChild($newidText);
				$pizza->appendChild($newid);
	
				//$pizzaName = $xmlDoc->createElement('name' , $pizzaName );
				//$pizzaName = $xmlDoc->createElement('description' , $desc );
				//$menu->appendChild($pizza);
				
				//$pizza->appendChild($pizzaName);
				//$pizza->appendChild($desc);
				
				$count = 0;
				
				foreach($ids as $id) {
					$ing = $xmlDoc->createElement("ingredient");	
					
					$ingid = $xmlDoc->createAttribute('id');
					$ingidText = $xmlDoc->createTextNode($ids[$count]);
					$ingid->appendChild($ingidText);
					
					$ingunit = $xmlDoc->createAttribute('units');
					$ingunitText = $xmlDoc->createTextNode($units[$count]);
					$ingunit->appendChild($ingunitText);
					
					$ing->appendChild($ingid);
					$ing->appendChild($ingunit);
							
					$pizza->appendChild($ing);
					$count = $count + 1;
				
				}
				
					
				$menu = $xmlDoc->getElementsByTagName("menu")->item(0); 
				$menu->appendChild($pizza);
						
				$cat = $xmlDoc->documentElement;
				$cat->appendChild($menu);
				$xmlDoc->appendChild($cat);
				
	         echo $xmlDoc->save("pizzeria.xml"); 
			
			}
			else if($_POST['item'] == 'ingredient'){
			
			
				$storage = 	$xmlDoc->getElementsByTagName('storage')->item(0);
				$items = $storage->getElementsByTagName('ingredient');
				
			 	$maxID = 0;		
			 	foreach($items as $item){
					$curID = (int)$item->getAttribute('id');
					if($curID > $maxID) $maxID = $curID ; 
				}	
				
				$name = $_POST['name'];
				$instorage = $_POST['instorage'];
				
				$ingredient = $xmlDoc->createElement("ingredient");
				
				//id attribute
				$newid = $xmlDoc->createAttribute('id');
				$newidText = $xmlDoc->createTextNode($maxID+1);
				$newid->appendChild($newidText);
				$ingredient->appendChild($newid);
				
				//name attribute
				$newName = $xmlDoc->createAttribute('name');
				$newNameText = $xmlDoc->createTextNode($name);
				$newName->appendChild($newNameText);
				$ingredient->appendChild($newName);
 
				//in_storage attribute 				
 				$newCount = $xmlDoc->createAttribute('in_storage');
				$newCountText = $xmlDoc->createTextNode($instorage);
				$newCount->appendChild($newCountText);
				$ingredient->appendChild($newCount);
				
				$storage->appendChild($ingredient);
				
				$cat = $xmlDoc->documentElement;
				$cat->appendChild($storage);
				$xmlDoc->appendChild($cat);
				
	         echo $xmlDoc->save("pizzeria.xml");
 				
			}
				
					
			}
				
	 
		
	
?>