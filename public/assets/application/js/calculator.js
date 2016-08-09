$(document).ready(function(){

  $('.corner').mouseover(function(){
        $('.corner').removeClass('corner_hover');
        $('.corner').removeClass('corner_on_hover');
        if($(this).hasClass('corner_on')){
               $(this).addClass('corner_on_hover');
        }else{
               $(this).addClass('corner_hover');
         }      

  });

    $('.corner').mouseout(function(){
       
        $(this).removeClass('corner_hover');
        $(this).removeClass('corner_on_hover');

  });

   $('.wall').mouseover(function(){
        $('.wall').removeClass('wall_hover');
        $(this).addClass('wall_hover');
            

  });

    $('.wall').mouseout(function(){
       
        $(this).removeClass('wall_hover');
       

  });

   $('.sink').mouseover(function(){
        $('.sink').removeClass('sink_hover');
        $(this).addClass('sink_hover');
            

  });

    $('.sink').mouseout(function(){
       
        $(this).removeClass('sink_hover');
       

  });
       $('.stove').mouseover(function(){
        $('.stove').removeClass('stove_hover');
        $(this).addClass('stove_hover');
            

  });

    $('.stove').mouseout(function(){
       
        $(this).removeClass('stove_hover');
       

  });
   

$('.handle').click(function(){
     var obj = $(this).attr('data-calc-form');

     //to form

     var target_object = obj + '_obj';
     var target_object_on = target_object + '_on';

     if($('.' + target_object).hasClass(target_object_on)){
                $('.' + target_object).removeClass(target_object_on);

                if($(this).hasClass('corner')){
                         $(this).removeClass('corner_on');

                }
                if($(this).hasClass('wall')){
                         $(this).removeClass('wall_on');

                }    
                if($(this).hasClass('sink')){
                         $(this).removeClass('sink_on');

                }  
                if($(this).hasClass('stove')){
                         $(this).removeClass('stove_on');

                }                 

     }else{
                $('.' + target_object).addClass(target_object_on);
                if($(this).hasClass('corner')){
                         $(this).addClass('corner_on');

                }
                if($(this).hasClass('wall')){
                         $(this).addClass('wall_on');

                }  
                if($(this).hasClass('sink')){
                         $(this).addClass('sink_on');

                }  
                if($(this).hasClass('stove')){
                         $(this).addClass('stove_on');

                }  



     }

});
	
/*

       if(arr.length == 0){       	     
           if ($(this).hasClass('byAjax')){
                     var action = $(form_id).attr('action');
                     var data   = $(form_id).serialize();
//console.log(data);
//console.log(action);
          var data_param = ($(this).hasClass('withAddingAction')) ? $(this).attr('data-params') : 0;
          var elem_checker = $(this);

           $.ajax({
                       type        : 'POST', 
                       url         :  action, 
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
           .done(function(res) {
                    
                    console.log(res.data);
                    $('#window_id').val((res.window_id)?res.window_id:0);

                  if (data_param){

                    	addingAction(data_param, new Object({'elem' : elem_checker,'window_id' : (res.window_id)?res.window_id:0}));
                    	
                  }
                 }); 


           }else{
           $(form_id).submit();
       }

       }

});
    });*/

});

