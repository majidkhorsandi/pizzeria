<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>M & M Pizzas</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js" ></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/main.js" ></script>
	<script type="text/javascript" src="css/dragToShare.css" ></script>

	<link rel="stylesheet" href="css/style.css" />

</head>
<body>
<script type="text/javascript" src="wz_tooltip.js"></script>
<div id='main'>
		<div id="info">
			<h1>Instructions</h1>
				<span>Step 1: </span><p>Hover an item for more information</p>
				<span>Step 2: </span><p>Drag desired pizza to the shopping wagon</p>
				<span>Step 3: </span><p>Click on checkout to process your order</p>
		</div>
	<div class='container'>
		<ul class="toBeSorted">
			<?php	
				$file = 'pizzeria.xml';
				$xml = simplexml_load_file($file);
					if (count($xml->menu->pizza) > 0) {
					   foreach ($xml->menu->pizza as $node) {
			        // This prints out each of the models	
				$pn = $node['id'] ;		
				$href = 'href=order.php?pn=' . $pn;
				$retriIng = '<ul>';
				foreach ($node->ingredient as $ing) {
					foreach ($xml->storage->ingredient as $showIng) {
		  				if ($showIng['id'] == $ing['id'] && $ing['units'] != "0")
							$retriIng .= '<li>' .  $showIng['name'] . '</li>';  				
					}	
				}
				$retriIng .= '</ul>';
				echo '<li id="' . $node['id'] . '"><img id=" ' . $node->name . '" src="images/pizza2.gif" onmouseover="Tip(\'Ingredients: ' . $retriIng . '\')" /><a ' . $href . ' onmouseover="Tip(\'Ingredients: ' . $retriIng . '\')"> ' . '<span class="pizzaName">' . $node->name . '</span>' . ' </a></li> ';
 			  			}
					}
			?>
		</ul>
	</div>
		<div id="menuBar">
		<div id="top10" >
			<h1>Top 10 Pizzas</h1>
			<ul>
			<?php 	
				$count = 1;
				$pizzas = array();
					foreach ($xml->menu->pizza as $snode) {
						$pizzas[(string)$snode->name] = $snode->popularity;
					}
					
				arsort($pizzas);			
				
				foreach ($pizzas as $key => $val) {
					foreach ($xml->menu->children() as $fnode){
						if ($key == $fnode->name){
							$href = 	'href=order.php?pn=' . $fnode['id'] ;
  		  					echo '<li><a ' . $href . '> ' . $count . '. ' . $fnode->name . '</a></li>';
  		  					$count++;
  		  				}	
  		  			}
  		  				if ($count == 11){break;}
  		 		}		
			?>	
			</ul>
	</div>
			<div id="cart">
				<h1>Shopping Cart</h1>
				
				<ul></ul>
				<img src="images/Shoppingcart.png" id="shoppingcart" title="Drag items to this basket!">
				<img src="images/checkout.png" class="button" id="checkout" title="Click to process the order">
			</div>
	</div>
</div>
</body>
</html>