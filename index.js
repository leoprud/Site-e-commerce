$(function(){  
   var position = 0;
   var items_count = $('.carousel .item').length;      

   	$('.canvas').css('width', 1176*items_count);

    var canva = 1176*items_count;     
         
        $('.carousel-prev').click(function()
    	{  
            if(position > 0)
            {     
               	position = position-1176;         
               	$('.canvas').css('transform', 'translateX(-'+position+'px)');        
			}  

			else
       		{
       			position = position+canva-1176;       
           		$('.canvas').css('transform', 'translateX(-'+position+'px)'); 
       		}  

       	}); 

         $('.carousel-next').click(function()
      	{
       		if(position < canva-1176)
       		{
                position = position+1176;       
           		$('.canvas').css('transform', 'translateX(-'+position+'px)');         
       		}

       		else
       		{
       			position = position-canva+1176;       
           		$('.canvas').css('transform', 'translateX(-'+position+'px)'); 
       		}                
    	});
});