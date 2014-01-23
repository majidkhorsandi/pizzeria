<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

	<title>Pizzeria</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js" ></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/manager.js" ></script>
	<script type="text/javascript" src="js/jquery.boxy.js" ></script>
	<script type="text/javascript" src="js/jquery.mousewheel.min.js" ></script>
	<script type="text/javascript" src="js/mwheelIntent.js" ></script>
	<link rel="stylesheet" href="css/manager.css" />

	

</head>
<body>


<div id="body">
	
	<?php
	
			$file = 'pizzeria.xml';
			
		   $xml = simplexml_load_file($file);
	?>	
	
	<div id="sidebar">
		<ul>
			<li>
				 <span>Show list of recepies</span>
				 <img  id="mnuShowPizzaList" src="images/cheff.png" /> 
			</li>
			<li>
				  <span>Show top 10 recepies</span>
				  <img  id="mnuShowTop10" src="images/top10.png" />	
			</li>
			<li>
					<span>Add New Recepie</span>
				  <img  id="mnuShowNewPizza" src="images/pizza_slice.png" />	
			</li>
			<li>
					<span>Manage Ingredients</span>
				  <img  id="mnuShowIngredients" src="images/cheese.png" />	
			</li>
		</ul>
	</div>
	
	<div id="contents">
	
	<div id="pizzaList"   >
	<ul>
<?php
			
			
			if (count($xml->menu->pizza) > 0) {
			
			//$max = 0;
		   foreach ($xml->menu->pizza as $node) {

        // This prints out each of the models
			
			//$max = ($max < (int)$node['id']) ? (int)$node['id'] : $max ;			
			 
			
			
			echo '<li id="' . $node['id'] . '">
			<span>' . $node->name . '</span><br>			
			<span style="color:orange">popularity: ' . $node->popularity . '</span><br>			
			<img class="delete" title="remove this recepie from menu" src="images/delete.png" />			
			<img class="edit"  title="edit this recepie" src="images/button_edit.png" />
			<div  id="pizzaEditor" class="hidden">
			<input type="text" class="txtPname" value="' . ($node->name == "" ? "name" : $node->name) . '" /><br> 	
			<input type="text" class="txtDescription" value="' . ($node->description == "" ? "description" : $node->description ). '" /><br><br> 
				
			<span>popularity: ' . $node->popularity . '</span><table>';
			
			foreach ($node->ingredient as $ingr) {	
					
					foreach($xml->storage->ingredient as $storingr){
						if($storingr['id'] == $ingr['id']  ){
							if ($ingr['units'] == "0"){	
								echo 	'<tr class="hidden"><td><span class="editorIngredients">' . $storingr['name'] . '</span></td>
										<td><input type="text" class="amounts" value="' . $ingr['units'] . '" /></td>
										<td class="deleteCell"><img class="button" src="images/edit_delete.png" /></td></tr>';
										break;
							}	
							else{
								echo 	'<tr ><td><span class="editorIngredients">' . $storingr['name'] . '</span></td>
									<td><input type="text" class="amounts" value="' . $ingr['units'] . '" /></td>
									<td class="deleteCell"><img class="button" src="images/edit_delete.png" /></td></tr>';
									break;
							}	
						}
					}
			//	}
				//else{
				//	break;				
				
			}		
			echo '</table><img id="btnUpdate" class="button" src="images/save.png" />
					<img class="close" src="images/close.png" /></div></li>' ;

 		  }
 		  
 		 
}
?>

	</ul>
</div>

<div id="newpizza" class="hidden">

<h2>Pizza Information</h2><br>
 	 <label for="name">Pizza Name: </label>
    <input id="txtName" name="name"  type="text" size="15" /><br>
    <label for="discription">Description: </label>
    <input id="txtDiscription" name="discription"  type="text" size="15" /><br><br>
    <h2>Ingredients</h2>
	<ul>	
	<?php
	foreach ($xml->storage->ingredient as $ingr){
			echo '<li id="' . $ingr['id'] . '">
			<span class="name" >' . $ingr['name'] . '</span> 			
			<span class="count" >0</span> 
			<img  class="buttonDecrese" src="images/remove.png" />			
			<img  class="buttonIncrease" src="images/add.png"/>
			</li>';
		}
	?>
	</ul>
	<br>
	<br>
	 <img id="btnSave" class="button" title="save" src="images/save.png" />



</div>



	<div id="topten" class="hidden">
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
						$href = 	'#' ;
  		  				echo '<li><a ' . $href . ' > ' . $count . '. ' . $fnode->name . ' </a></li>';
  		  				$count++;
  		  			}
  		  			
  		  			
  		  		}
  		  		if ($count == 11){break;}
  		 }

				
	?>	
		</ul>
	</div>

<div id="ingredientManager" class="hidden" >


	<?php 
			echo '<table><tr ><th>Name</th><th>In Storage</th><th>Manage</th></tr>
					<tr><td><input type="text" /></td><td><input type="text" />
					</td><td><img id="btnAddIngredient" src="images/save.png" /></td></tr>' ;
			foreach ($xml->storage->ingredient as $node) {
				
				echo '<tr><td class="hidden"> ' . $node['id'] . '</td>
				<td class="data"><span>' . $node['name'] . '</span><input class="hidden" type="text" value="" /></td>
				<td class="data"><span>' . $node['in_storage'] . '</span><input class="hidden" type="text" value="" /></td>
				<td class="manage">
				<img class="hidden" id="btnUpdateIngredient" src="images/save.png" title="update" />
				<img class="hidden" id="btnCancelIngredient" src="images/cancel_red.png" title="Cancel" />				
				<img id="btnDeleteIngredient"  src="images/delete.png" title="delete" />			
				<img id="btnEditIngredient"   src="images/button_edit.png" title="edit" />
				</td></tr>' ;				
			
			}
			
			echo '</table>'
	?>
</div>


	</div>
	

</div>



</body>
</html>