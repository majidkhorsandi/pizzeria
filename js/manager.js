$(document).ready(function(){


$('img.edit').click(function(){

	$(this).next('div').show('slow');

});

//////////////////////////////////////////////////////////

$('.amounts').mwheelIntent(function(e, delta) {

	 var $value = $(this).attr('value');
	 $value =  parseInt($value) + delta;   
    if ($value >0) {$(this).attr('value' , $value) };
});

//////////////////////////////////////////////////////////

$('img.save').click(function(){


});

//////////////////////////////////////////////////////////

$('img.close').click(function(){

	$(this).parent().hide('slow');

});

//////////////////////////////////////////////////////////

$('img.delete').click(function(){

	var $confirm = confirm('are you sure you want to delete this recepie?');
	
	if ($confirm){
		$.post("delete.php", { item : 'pizza' , id: $(this).parent().attr('id')});
		$(this).parent().fadeOut("slow");	
	}
	
});

//////////////////////////////////////////////////////////

$('#ingredients ul li').click(function(){
	
	$flag = false;
	$html = $(this).html();
	var $current = 0;
	$('#newingredients ul li').each(function(){
		if ($(this).children('span.name').html() == $html) {
			$flag = true;
			$current = $(this).find('span.count').html();
			$(this).find('span.count').html(parseInt($current) + 1);
		}	
	});
	
		if (!$flag){
			var $html = '<li><span class="hidden">' + $(this).attr("id") + '</span><span class="name">';
				 $html += $(this).html() + '</span><span class="count"> ' + 1 ;
				 $html += '</span> <img id="btnRemIng" class="button" src="images/remove.png" />';
				 $html += '<img id="btnAddIng" class="button" src="images/add.png"/></li>' ;
			var $html = $('#newingredients ul').html() + $html;			
			$('#newingredients ul').html($html);
		};
	
	
});

//////////////////////////////////////////////////////////
$('.buttonIncrease').click(function(){
$current = $(this).parent().find('span.count').html();

if(parseInt($current)==0){
	
	$(this).parent().css('color' , 'black');
	$(this).parent().find('span.count').html(parseInt($current) + 1);	
}
else{
	$(this).parent().find('span.count').html(parseInt($current) + 1);
}
});
//////////////////////////////////////////////////////////
$('.buttonDecrese').click(function(){
$current = $(this).parent().find('span.count').html();

if(parseInt($current)>1){
	$(this).parent().find('span.count').html(parseInt($current) - 1);
} else if(parseInt($current)==1){
	$(this).parent().css('color' , 'gray');
	$(this).parent().find('span.count').html(parseInt($current) - 1);
}
});
//////////////////////////////////////////////////////////

$('img#btnSave').click(function(){
	
	arrayIngredients = new Array; 
	arrayUnits = new Array;
	arrayName = new Array;
	$flag = false;
	$message="";
	$(this).parent().find("ul li").each(function() {
                                    //myVar = $("input:checked").get(id);
                                    if (parseInt($(this).find('span.count').html()) > 0) {
                                    	$flag="true";
                                    	arrayIngredients.push($(this).attr('id'));
                                    	arrayUnits.push($(this).find('span.count').html()); 
                                   	 	arrayName.push($(this).find('span.name').html());
                                    }
   });
   
	

  	if ( $(this).parent().find('input:first').val() == "") {
    	$(this).parent().find('input:first').animate({ backgroundColor: "red" }, "slow");
    	$flag = false;
    	$message = " \'name field must contain at least one character\' " ; 
  	} 
      
   
   if ($flag){
		$.post("save.php", {item:'pizza' , ids : arrayIngredients , units : arrayUnits , names : arrayName , pname: $('#txtName').val() , desc : $('#txtDiscription').val()  });
		$message = "successfully added!";		
		alert($message);
	}else{
		$message += " \'at least one ingredient required\' ";
		alert($message);
	}
});

//////////////////////////////////////////////////////////

$('#pizzaEditor img#btnUpdate').click(function(){
	

	arrayUnits = new Array;

	$(this).parent().find('input.amounts').each(function() {

                                    arrayUnits.push($(this).val()); 

   });
	$.post("update.php", {item : 'pizza' , pid : $(this).parent().parent().attr('id') , units : arrayUnits ,  pname: $(this).parent().find('input.txtPname').val() , desc : $(this).parent().find('input.txtDescription').val()  });
	
	
	$(this).parent().parent().find('span:first').html($(this).parent().find('input.txtPname').val());
	$(this).parent().hide();
});
/////////////////////////////////////////////////////////

$('img#btnEditIngredient').click(function(){

	$(this).parent().parent().find('td').each(function(){
		if ($(this).attr('class') == 'data'){		
		var $val = $(this).find('span').html();
		var $input = $(this).find('input');
		$(this).find('span').toggleClass("hidden");
		$input.val($val);		
		$input.toggleClass("visible");
		//$input.show();
		
		}
		else if($(this).attr('class') == 'manage'){
		
		$(this).find('img').hide();
		$(this).find('img.hidden').show();		
		//var $val = $(this).html();
		//var $button = '<img class="button" id="hej" src="images/save.png" />' ;	
		//$(this).html('');
		//$(this).append($button);
		}
	});
	
});

//////////////////////////////////////////////////////////
$('#mnuShowPizzaList').click(function(){

	$('#contents').find('div').each(function(){ $(this).hide()});
	$('#pizzaList').show('slow');

});

//////////////////////////////////////////////////////////

$('#mnuShowNewPizza').click(function(){

	$('#contents').find('div').each(function(){ $(this).hide()});
	$('#newpizza').show('slow');

});

//////////////////////////////////////////////////////////


$('#mnuShowTop10').click(function(){

	$('#contents').find('div').each(function(){ $(this).hide()});
	$('#topten').show('slow');

});

//////////////////////////////////////////////////////////

$('#mnuShowIngredients').click(function(){

	$('#contents').find('div').each(function(){ $(this).hide()});
	$('#ingredientManager').show('slow');

});
//////////////////////////////////////////////////////////
$('img#btnUpdateIngredient').click(function(){
	

	$.post("update.php", {item : 'ingredient' , iid : $(this).parent().parent().find('td.hidden').html() ,
								name: $(this).parent().parent().find('input:first').val() ,
								instorage : $(this).parent().parent().find('input:last').val()  });
								
								
	$(this).parent().parent().find('td').each(function(){
		if ($(this).attr('class') == 'data'){		
			var $val = $(this).find('input').val();
			$(this).find('span').html($val ).toggleClass("hidden");
			$(this).find('input').toggleClass("visible");
			
		}
		else if($(this).attr('class') == 'manage'){

			$(this).find('img').show();
			$(this).find('img.hidden').hide();

		}
	});							
								
});
////////////////////////////////////////////////////////////
$('img#btnCancelIngredient').click(function(){
	

									
	$(this).parent().parent().find('td').each(function(){
		if ($(this).attr('class') == 'data'){		
			var $val = $(this).find('span').html();
			$(this).find('input').toggleClass("visible");
			$(this).find('span').toggleClass("hidden");			
			//$(this).html($val );
		}
		else if($(this).attr('class') == 'manage'){

			$(this).find('img').show();
			$(this).find('img.hidden').hide();

		}
	});							
								
});

/////////////////////////////////////////////////////////////////////

$('img#btnDeleteIngredient').click(function(){
	
	var $confirm = confirm('are you sure you want to delete this recepie?');
	
	if ($confirm){
	
		$.post("delete.php", {item : 'ingredient' , iid : $(this).parent().parent().find('td.hidden').html() });
		$(this).parent().parent().fadeOut('slow');							
	}							
														
});
/////////////////////////////////////////////////////////////////////
$('img#btnAddIngredient').click(function(){

	var $name = $(this).parent().parent().find('input:first').val();
	var $instorage =  $(this).parent().parent().find('input:last').val();
	
	$.post("save.php", {item:'ingredient' , name: $name  ,
							  instorage : $instorage  });
	
	var $newRow = '<td class="data">' + $name + '</td><td class="data">' + $instorage ;
		 $newRow += '</td><td class="manage"><img class="hidden" id="btnUpdateIngredient" src="images/save.png" />';
		 $newRow += '<img id="btnDeleteIngredient"  src="images/delete.png" />';			
		 $newRow += '<img id="btnEditIngredient"   src="images/button_edit.png" /></td></tr>';
				
	$(this).parent().parent().parent().append($newRow);

});
///////////////////////////////////////////////////////////////////
$('.txtDescription').click(function(){
 if ($(this).val() == 'description') $(this).val(''); 
});


 $('#newpizza input:first').focus(function () {
         $(this).animate({ backgroundColor: "white" }, "slow");
         
  });
 ////////////////////////////////////////////////////////////////// 
//  $('#pizzaEditor table img.button').click(function(){
  		
 // });

  
  /////////////////////////////////////////////////////////////////////
  $('#pizzaEditor table tr td.deleteCell img').click(function(){
  
	  $(this).parent().parent().fadeTo("slow", 0.33);
		$(this).parent().parent().find('input.amounts').val("0");	  
  
  });

});