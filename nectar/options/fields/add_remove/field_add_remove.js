jQuery(document).ready(function($){
   
   var count = $('.add-remove-controls input[type=hidden]').val();
   
   if(count.length == 0) count = 1;
 
   
   $('.add-remove-controls .add').click(function(){
   		
   		if(count < 10){
   			$('.add-remove-controls .remove').stop(true,true).fadeIn();
   			count++;
   		}
   		if(count == 10) {
   			$('.add-remove-controls .add').hide();
   		}
   		 console.log(count);
   		$('#map-point-'+count).parent().parent().parent().fadeIn();
   		if( $('#map-point-'+count).attr('checked') == 'checked') $('#map-point-'+count).parent().parent().parent().nextAll('tr').slice(0,3).stop(true,true).fadeIn();
   		
   		return false;
   });
   
   
   $('.add-remove-controls .remove').click(function(){
		
   		$('#map-point-'+count).parent().parent().parent().fadeOut();
   		if( $('#map-point-'+count).attr('checked') == 'checked') $('#map-point-'+count).parent().parent().parent().nextAll('tr').slice(0,3).stop(true,true).fadeOut();
   		
   		if(count > 1){
   			$('.add-remove-controls .add').stop(true,true).fadeIn();
   			count--;
   		}
   		if(count == 1) {
   			$('.add-remove-controls .remove').hide();
   		}
   		console.log(count);
   	
   		return false;
   });
   
   
   //update the value for saving
   $('.add-remove-controls .remove, .add-remove-controls .add').click(function(){
   	   $('.add-remove-controls input[type=hidden]').attr('value',count);	
   });
   
   //init
   $('#map-point-'+count).parent().parent().parent().next('tr').next('tr').next('tr').nextAll('tr').not('tr:has(".add-remove-controls")').hide();
   if(count == 1){ $('.add-remove-controls .remove').hide(); }
   
});
