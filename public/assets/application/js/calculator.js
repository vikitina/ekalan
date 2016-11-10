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
                         $('.' + target_object).removeClass('corner_obj_on');
                         $('#'+obj).val('0');

                }
                if($(this).hasClass('wall')){
                         $(this).removeClass('wall_on');
                         $('.' + target_object).removeClass('wall_obj_on');
                         $('#'+obj).val('0');

                }    
                if($(this).hasClass('sink')){
                         $(this).removeClass('sink_on');
                         $('#'+obj).val('0');

                }  
                if($(this).hasClass('stove')){
                         $(this).removeClass('stove_on');
                         $('#'+obj).val('0');

                }                 

     }else{
                $('.' + target_object).addClass(target_object_on);
                if($(this).hasClass('corner')){
                         $(this).addClass('corner_on');
                         $('.' + target_object).addClass('corner_obj_on');
                         $('#'+obj).val('1');

                }
                if($(this).hasClass('wall')){
                         $(this).addClass('wall_on');
                         $('.' + target_object).addClass('wall_obj_on');
                         $('#'+obj).val('1');

                }  
                if($(this).hasClass('sink')){
                         $(this).addClass('sink_on');
                         $('#'+obj).val('1');

                }  
                if($(this).hasClass('stove')){
                         $(this).addClass('stove_on');
                         $('#'+obj).val('1');

                }  



     }
  data_update()
  calculate();  

});

$('.length input').keyup(function(){


       var elem = $(this).parent().attr('data-calc-form');
       $('#' + elem).val($(this).val());
       data_update()
       calculate();  
});

$('.calc_params li a').mouseup(function(){

  
      $('#' + $(this).attr('data-calc-form')).val($(this).attr('data-calc-form-value'));
       data_update()
       calculate();       
      
});

$('#send_order').click(function(){
      $('#sendOrderModal').modal();


});
$('#sendOrderBtn').click(function(){
      var str_type = $('#cf_type').val();
      var data = {

                 'schema'  :    '<div id="schema_'+ str_type.toUpperCase() +'" class="'+ str_type +'">' + $('.' + str_type).html() + '</div>',
                 'table'   :    '<div class="calc_table_container">' + $('.calc_table_container').html() + '</div>',
                 'message' :    '<b>Имя:</b> :  ' + $('#name').val() + '<br />' + '<b>Номер телефона :  </b> :  ' + $('#phone').val()+ '<br />' + '<b>Адрес элестронной почты : </b> :  ' + $('#email').val() + '<br />' + '<b>Комментарии заказчика :  </b> :  ' + $('#comments').val() + '<br />-------------------------------------------------------------------------------------'
      };
      var reg = new RegExp(/\S/);
      $( '#sendOrderModal .error' ).removeClass('error');
      var i = 0;
      $( '#sendOrderModal .required' ).each(function(){
                    
                     var str = $(this).val();                
                     if( !reg.test(str) ){

                                  $(this).addClass('error');
                                  i = 1;
                     }

      });
      if( i > 0 ){

         }else{



             $('#sendOrderModal').modal('hide');
             $('#thank_for_order').modal();
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/sendorder',  
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
           .done(function(res) {
                    
                    $( '#sendOrderModal input' ).each(function(){
                                  $(this).val('');

                        });
                    $('#thank_for_order').modal('hide');

                 }); 

         }


});
$('#sendme').click(function(){
      var str_type = $('#cf_type').val();
      var data = {

                 'schema'  :    '<div id="schema_'+ str_type.toUpperCase() +'" class="'+ str_type +'">' + $('.' + str_type).html() + '</div>',
                 'table'   :    '<div class="calc_table_container">' + $('.calc_table_container').html() + '</div>',
                 'message' :    'Это сообщение сформировано и отправлено с сайта Ekalan.com.ua'+ '<br /><br />-------------------------------------------------------------------------------------',
                 'email'   :    $('#emailme').val()

      };  
      var emailme = $('#emailme').val();
      var reg = new RegExp(/\S/);
      if (reg.test(emailme)){
            $('#sendOrderModal').modal('hide');
            $('#mailmeModal').modal();
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/sendorder',  
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
           .done(function(res) {
                    
                    $('#emailme').val('');
                    $('#thank_for_order').modal('hide');

                 }); 
                 $('#emailme').val('');

       }else{

                $('#emailme').addClass('error');

       }

});
$('#sendOrderModal .error').change(function(){
                    $(this).removeClass('error');

});
$('#print_order').mousedown(function(){
      var str_type = $('#cf_type').val();
      $('#blueprint').val('<div id="schema_'+ str_type.toUpperCase() +'" class="'+ str_type +'">' + $('.' + str_type).html() + '</div>');
      $('#order_table').val('<div class="calc_table_container">' + $('.calc_table_container').html() + '</div>');
      
      console.log($('#blueprint').val());
});
//$('#print_order').click(function(){return false;});



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
                               $('.u_length_1 input').val() * 1,
                               $('.u_length_2 input').val() * 1,
                               $('.u_length_3 input').val() * 1,
                               $('.u_length_4 input').val() * 1,
                               $('.u_length_5 input').val() * 1,
                               0,
                               0,
                               $('.u_length_8 input').val() * 1
                         ];
                          if( (length_arr[2] > length_arr[4]) && (length_arr[0] > length_arr[4]) && (length_arr[1] > (length_arr[7] + length_arr[3])) ){
                                   
                                   length_arr[5] = length_arr[2] - length_arr[4];
                                   length_arr[6] = length_arr[0] - length_arr[4];
                                   
                                   sq = ( length_arr[1] * length_arr[4] + (length_arr[0] - length_arr[4]) * length_arr[7] + (length_arr[2] - length_arr[4]) * length_arr[3] )/1000000;
                         }else{

                                   sq = 0;

                         }
                  break;

                  case 'i':
                         length_arr = [

                               $('.i_length_1 input').val() * 1,
                               $('.i_length_2 input').val() * 1
  
                         ];
                          if( (length_arr[0] > 0) && (length_arr[1] > 0) ){
                                   length_arr[2] = length_arr[0];
                                   length_arr[3] = length_arr[1];

                                   sq = length_arr[0]*length_arr[1]/1000000;
                         }else{

                                   sq = 0;

                         }

                  break;

                  case 'l':
                         length_arr = [
                               
                               $('.l_length_1 input').val() * 1,
                               $('.l_length_2 input').val() * 1,
                               $('.l_length_3 input').val() * 1,
                               0,
                               0,
                               $('.l_length_6 input').val() * 1
                              
                         ];
                          if( (length_arr[0] > length_arr[2]) && (length_arr[1] > length_arr[5]) ){
                                   
                                   length_arr[3] = length_arr[1] - length_arr[5];
                                   length_arr[4] = length_arr[0] - length_arr[2];

                                   sq = (length_arr[1] * length_arr[2] + (length_arr[0] - length_arr[2]) * length_arr[5])/1000000;
                         }else{

                                   sq = 0;

                         }

                  break;
      }

      if(sq){
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
      var price_material = $('#price_material_val').val() * 1;
      console.log(price_material);
          plinth_len = plinth_len/1000 * 0.04;
      var cost_plinth = plinth_len.toFixed(2) * price_material;
          edge_len   = edge_len/1000 * 0.04;
      var cost_edge  = edge_len.toFixed(2) * price_material;    
      var cost_material = sq.toFixed(2) * price_material;  
      var cost_corner =  $(typus_class+' .corner_obj_on').length * 30;  

      var sink;
      if ($(typus_class+' .sink').hasClass('sink_on')) {

                      sink = 'есть';
                      var sink_val = $('#db_sink').val()*1;
                      sq = sq - sink_val;
      }else{
                      sink = 'нет';
                    }
      var stove;
      if ($(typus_class+' .stove').hasClass('stove_on')){

                      stove =  'есть';
                      sq = sq -  $('#db_stove').val()*1;
      }else{
                      stove =  'нет';
        }              
     

             $('#result_edge_len').text(edge_len.toFixed(2));
             $('#cost_edge').text(cost_edge.toFixed(2));
             $('#result_plinth_len').text(plinth_len.toFixed(2));
             $('#cost_plinth').text(cost_plinth.toFixed(2));
             $('#result_sq').text(sq.toFixed(2));
             $('#result_corner').text($(typus_class+' .corner_obj_on').length);
             $('#cost_corner').text(cost_corner);
             $('#cost_material').text(cost_material);
             $('#result_sink').text(sink);
             $('#result_stove').text(stove);
              
             sum = 0; 
             $.map( $('.sum'), function(elem,i){
                     
                     sum  +=  $(elem).text() * 1;

             });
             $('#sum').text(sum);
     }else{
             $('#result_sq').html('<span style="color:#e6ae49"><i class="icon ion-ios-information" style="font-size:1.6em"></i> Параметры столешни не корректны.<br /> Калькулятор ожидает уточнения данных.</span>');
             $('#result_edge_len').text('');
             $('#result_plinth_len').text('');
             $('#result_corner').text('');
             $('#result_sink').text('');
             $('#result_stove').text('');
     }
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



