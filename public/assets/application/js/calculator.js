$(document).ready(function(){

  calculate();  


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
                         $('.' + target_object).removeClass('wall_obj_on');
                         $('#'+obj).val('0');

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
                         $('.' + target_object).addClass('wall_obj_on');
                         $('#'+obj).val('1');

                }  
                if($(this).hasClass('sink')){
                         $(this).addClass('sink_on');

                }  
                if($(this).hasClass('stove')){
                         $(this).addClass('stove_on');

                }  



     }
  data_update()
  calculate();  

});



});
    //================================================================
//--------------functions-----------------------------------------
//================================================================

function calculate(){

      var typus = $('#cf_type').val();
      var length_arr;
      
      switch(typus){

                  case 'u':
                         length_arr = [
                               0,
                               $('.u_length_2 input').val() * 1,
                               $('.u_length_3 input').val() * 1,
                               $('.u_length_4 input').val() * 1,
                               $('.u_length_5 input').val() * 1,
                               0,
                               $('.u_length_7 input').val() * 1,
                               $('.u_length_8 input').val() * 1
                         ];

                         length_arr[0] = (length_arr[2] - length_arr[4]) + length_arr[6];
                         length_arr[5] = length_arr[1] - (length_arr[7] + length_arr[3]);

                         sq = (length_arr[2] - length_arr[4])*length_arr[1] + length_arr[6]*length_arr[7] + length_arr[4]*length_arr[3]

                  break;

                  case 'i':
                  break;

                  case 'l':
                  break;
      }
      var plinth_len = 0;
      var edge_len = 0;
      var typus_class = '.' + $('#cf_type').val();
      var num;
      $.map( $(typus_class+' .wall_obj'), function( elem, i ) {
                num = $(elem).attr('data-num');
                if($(elem).hasClass('wall_obj_on')){
                       
                       plinth_len += length_arr[num-1];
                       

                }else{

                       edge_len +=  length_arr[num-1];

                }


      });
      $('#result_edge_len').text(edge_len + ' мм');
      $('#result_plinth_len').text(plinth_len + ' мм');
      $('#result_sq').text(sq + ' кв.мм');

} 

function data_update(){
       var data   = $('#calc_form').serialize();

                 $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/ajax/calculator',  
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
           .done(function(res) {
                    
                    console.log(res.data);

                 }); 


}



