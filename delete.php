
<?php
		
			
		$xmlDoc = new DOMDocument();
		$xmlDoc->load("pizzeria.xml");

		 
			
		//$xml = simplexml_load_file($file);

		if($_POST) {
			
			$item = $_POST['item'];
			
			if($item == 'pizza') {
				$id = $_POST['id'];
				$items = $xmlDoc->getElementsByTagName('pizza');
				foreach($items as $item) { 
				 	if ($id == $item->getAttribute('id'))  $rm =  $item;//$menu->removeChild($item);
			 	}
			 	
			 	if ($rm){
			 		 $rm->parentNode->removeChild($rm);
			 		 echo $xmlDoc->save("pizzeria.xml"); 
			 	}
		 	}
		 	
		 	else if ($item == 'ingredient'){
		 		
				$id = $_POST['iid'];	 		
		 		$storage = $xmlDoc->getElementsByTagName('storage')->item(0);
		 		$items = $storage->getElementsByTagName('ingredient');
		 		
			 	foreach($items as $item) { 
					 	if ($id == $item->getAttribute('id'))  $rm =  $item;//$menu->removeChild($item);
				 	}
				 	
				 	if ($rm){
				 		
				 		 $rm->parentNode->removeChild($rm);
				 		 echo $xmlDoc->save("pizzeria.xml"); 
				 	}
			 	
		 	}
		}
		
	
?>