Hash = {
  // Получаем данные из адреса
  get:      function() {
       var indexes = ['manufacturer','id_color','id_texture','id_material'];
    // [0] - производитель
    // [1] - цвет
    // [2] - текстура
    // [3] - материал

                 var data = {};
                     if(location.search) {
                              var param_str = decodeURIComponent(location.search.substr(1)).split('&');
                              for(var i = 0; i < param_str.length; i ++) {
                                        //var param = pair[i].split('=');
                                        //var key = param[0].match(/^.*\[(.*)\].*?/);
                                        //data[key[1]] = param[1];
                                        data[indexes[i]] = param_str;

                                }
                      }
                      
                      
              return data;
    
  }
  
  
  
  
  // Заменяем данные в адресе на полученный массив ======================================================
  
  ,set:          function(vars) {
                     var hash = '';

                    for (var i in vars) {
                            hash += '&' + vars[i];

                    }


                     if (!this.oldbrowser()) {
                              if (hash.length != 0) {
                                    hash = '/' + hash.substr(1);
                               }
                              // console.log("location: " + location.hostname);
                              console.log(location.search);
                            window.history.pushState(hash, '', '/admin/materials'+hash);

                     
                      }
                    else {
                        window.location.hash = hash.substr(1);
                     }
                 }
                 
                 
                 
  // Добавляем одно значение в адрес
  ,add: function(key, val) {
    var hash = this.get();
    hash[key] = val;
    this.set(hash);
  }
  // Удаляем одно значение из адреса
  ,remove: function(key) {
    var hash = this.get();
    delete hash[key];
    this.set(hash);
  }
  
  
  
  // Очищаем все значения в адресе====================================================================
  ,clear:           function() {
                         this.set({});
  }
  
  
  // Проверка на поддержку history api браузером======================================================
  ,oldbrowser:      function() {
                          return !(window.history && history.pushState);
  }
};
// ------------------------------------------------
function getMaterialsCount(count){
  
  var dictionary_Materials = new Object();
  dictionary_Materials = {
    '0' : 'материалов',
    '1' : 'материал',
    '2' : 'материала',
    '3' : 'материала',
    '4' : 'материала',
    '5' : 'материалов',
    '6' : 'материалов',
    '7' : 'материалов',
    '8' : 'материалов',
    '9' : 'материалов'
    }
    var material = '';
        var reg_last_symb = new RegExp(".*(.)$"); 
        var reg_teen = new RegExp("(.)*.$");  
        var tens_digit = reg_teen.exec(count);
        if(tens_digit[1] == '1'){
               material = 'материалов';
      }else{
          var key = reg_last_symb.exec(count);
          material = dictionary_Materials[key[1]];
      
      }
  
           return material;
 
  } 

// ------------------------------------------------  
$(document).ready(function(){



      $('.material_list_container').scroll(function(){
        //console.log('top:  '+$('.material_list_container').scrollTop());


                 if ($('.material_list_container').scrollTop() >= $('.material_list').height() - $('.material_list_container').height()){
                           var start_count = (parseInt($("#start").val()) - 1)*parseInt($("#limit").val());
                           if(start_count <= parseInt($("#rowcount").val())) {
                                       var start = parseInt($("#start").val()) +1;
                                       $("#start").val(start);
                                       delta = parseInt($("#rowcount").val()) - start_count;
                                      

                                       if (delta<=parseInt($("#limit").val())){

                                            $('#more').removeClass('visible');

                                       }else{

                                            $('#more').addClass('visible');
                                       }
                                       getmaterial();
                                  }


                                 // console.log('scroll');  
                           }
                        });

// ------------------------------------------------
      //смена в фильтрах

      $('.mfilter select').change(function(){

             var id = '#' + $(this).parent().attr('data-name');
             $(id).val($(this).val());

             $("#start").val(1);
             data['manufacturer'] = $('#id_manufacturer').val();
             data['id_color'] = $('#id_color').val();
       
             data['id_texture'] = $('#id_texture').val();
             Hash.set(data);             
             $('.material_list').html('');
             getmaterial();

             $('#crumbs').html('<div>'+hash_crumbs['manufacturer'][$('#id_manufacturer').val()]+'</div><em>/</em><div>'+hash_crumbs['texture'][$('#id_texture').val()]+'</div><em>/</em><div>'+hash_crumbs['color'][$('#id_color').val()])+'</div>'

           $('.material_list li .check input').map(function (i, el){
                      $(el).prop('checked',false);
            
              }); 
            $('#check_all').prop('checked',false);
            $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');             
             
      });
// ------------------------------------------------
      function getmaterial(){


            var data = $('#filter').serialize();
             $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajax/materialfilter', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
                     
                      
                      $('.material_list').append(data.html);
                      $('#rowcount').val(data.rowcount);
                      $('.count_text').html('Найдено <span class="count">'+data.rowcount+'</span> '+getMaterialsCount(data.rowcount));
                      //console.log('query     '+data.query); 
                      //console.log('id_color =      '+data.id_color); 
                      $('.loaded_count').text('('+$('.material_list li').length+')');
                 
                
                 });          
      }

     
// ------------------------------------------------
$('#filter_articul').on('keyup',function(){

   console.log($(this).val());
   var word = $(this).val();
   $("#start").val(1);
   $("#articul").val(word);
   $('.material_list').html('');
   getmaterial();
           $('.material_list li .check input').map(function (i, el){
                      $(el).prop('checked',false);
            
              }); 
            $('#check_all').prop('checked',false);
            $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');

});

// ------------------------------------------------
$('body').on('mouseover','.editable',function(){
   if(!$(this).hasClass('editopen')){
         $(this).addClass('editablehover');
   }

});
// ------------------------------------------------
$('body').on('mouseout','.editable',function(){
      $(this).removeClass('editablehover');
  
});
// ------------------------------------------------
$('body').on('click','.editable',function(){
      $(this).addClass('editopen');
      $(this).find('.editarea input').focus();
      $(this).find('.editarea textarea').focus();
      $(this).select();


});
// ------------------------------------------------

$('body').on('blur','.editarea>input',function(){

     $(this).parents('.editable').removeClass('editopen');
     var id='#'+$(this).attr('data-name');
     var set_value = $(this).val();
     $(id).val(set_value);
     $(this).parents('.editable').find('span').text(set_value);
     if( $(this).parents('li').hasClass('ajax_edit_obj')){
        var form = $(this).parents('li').find('form');
        var action = $(form).prop('action');
        var data = $(form).serialize();
        console.log(action);
        console.log(data);
        play_ajax(action,data,null);
     }

    // console.log($(id).val());
});
// ------------------------------------------------




function play_ajax(action,data,father){
       
           $.ajax({
                       type        : 'POST', 
                       url         :  action, 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(res) {
                     if(father){
                          var new_element = res.li;
                          append_to_stack(new_element, father);
                       }   
                
                 });           
               

}
// ------------------------------------------------
$('.editarea>textarea').blur(function(){

     $(this).parents('.editable').removeClass('editopen');
     var id='#'+$(this).attr('data-name');
     var set_value = $.trim($(this).val());
     if(set_value != ''){
          $(id).val(set_value);
          $(this).parents('.editable').find('span').text(set_value);
}else{
           $(id).val(0);
           $(this).parents('.editable').find('span').text('Не указано');

}
    // console.log($(id).val());
});
// ------------------------------------------------
$('.selectable').mouseover(function(){
   if(!$(this).hasClass('selectopen')){
         $(this).addClass('selectablehover');
   }

});
// ------------------------------------------------
$('.selectable').mouseout(function(){
      $(this).removeClass('selectablehover');
  
});
// ------------------------------------------------

$('.selectable').click(function(){
      $(this).addClass('selectopen');
      $(this).find('.editarea input').focus();
      $(this).select();


});
// ------------------------------------------------

$('.custom_select li').click(function(){

     $(this).parents('.selectable').removeClass('selectopen');

});
// ------------------------------------------------


$('#material_list_open_window').click(function(){

      $('#material_list_modal').modal(); 

});
// ------------------------------------------------



$('#sample_list_open_window').click(function(){
       $('#sample_list_modal').modal();

});
// ------------------------------------------------


$('#btn_pick_analogs').click(function(){
        
         var analogs_html='';
         var form_analogs_list = '';
         var f=0;
         $('#form_analogs li input:checked').map(function (i, el) {
                    //console.log(i+'    '+$(el).val());
                    analogs_html += '<li>'+$(el).parent().html()+'<span class="remove_analog" data-id="a_'+$(el).val()+'"><i class="fa fa-times"></i></span></li>';
                    
                    form_analogs_list += (f==1) ?','+$(el).val() :$(el).val();
                    f = 1;
             });
         $('#analogs_list').html(analogs_html);
         $('#analogs_list').removeClass('empty');
         $('#form_analogs_list').val(form_analogs_list);
         $('#material_list_modal').modal('hide');


return false;

});
// ------------------------------------------------



$('#analogs_list').on('mouseover', 'li', function(){

  $(this).addClass('hover');
});
// ------------------------------------------------

$('#analogs_list').on('mouseout', 'li', function(){

  $(this).removeClass('hover');
});
// ------------------------------------------------

$('#analogs_list').on('click', 'li > .remove_analog', function(){

     var id = '#material_list_modal input#' + $(this).attr('data-id');
     $(id).attr('checked', false);
     var form_analogs_list = '';
     var f=0;
     $(this).parent().remove();
     $('#analogs_list li input').map(function (i, el){
            form_analogs_list += (f==1) ?','+$(el).val() :$(el).val();
            f = 1;
     });
     form_analogs_list = ((form_analogs_list != '')?form_analogs_list:0);
     $('#form_analogs_list').val(form_analogs_list);
     if(form_analogs_list == 0){
          $('#analogs_list').addClass('empty');
     }
     console.log($('#form_analogs_list').val());
});
// ------------------------------------------------




//смена производителя - смена списка коллекций
 
$('.editable_select').change(function(){

if ($(this).attr('id') == 'id_manufacturer_select'){
   console.log($('#id_manufacturer_select').val());
   var collection_by_manuf = '';
   var id_manuf = $('#id_manufacturer_select').val();
   $('#id_manufacturer').val(id_manuf);
   var f = 0;
   $.each(hash_collections[id_manuf]['collections'], function(i, item){

         console.log(i+'   '+item);
         collection_by_manuf += '<option value="'+i+'">'+item+'</option>'
         if (f == 0){

            $('#id_collection').val(i);
         }
         f = 1;

   });
   $('#id_collection_select').html(collection_by_manuf);
   console.log('производитель');
}else{
    var id = $(this).attr('data-name');
    var value = $(this).val();
    $(id).val(value);

}

});
// ------------------------------------------------

//удаление материала
$('.material_list').on('click','li span.del_material_ajax', function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');
              $(this).parent('li').addClass('confirm_deleting_state');
              $('#deleting_id').val(id);
});
// ------------------------------------------------   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$('#delete_confirm_window #btn_confirm_deleting').click(function(){
         
         var data = new Object();
         console.log('materials строка 456');
         data['id'] = $('#deleting_id').val();
         var action = $('#deleting_id').parent('form').attr('action');
         var data_type =$('#type').val();
               $.ajax({
                       type        : 'POST', 
                       url         :  action,
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
               .done(function(data) {
                     $('#deleting_id').val('');
                     $('#delete_confirm_window').modal('hide');
                     if( data_type == 'testimonial'){
                            if(data.status)   {
                                $('.material_list li.confirm_deleting_state .testimonials_second_col a').text("(пустой)");
                                $('.material_list li.confirm_deleting_state .del_testimonial_ajax').remove();
                                $('.material_list li.confirm_deleting_state').removeClass('confirm_deleting_state');
                             }else{
                                $('.material_list li.confirm_deleting_state').remove();

                             }   

                     }else{

                                $('.material_list li.confirm_deleting_state').remove();
                     }
                     console.log(data.res);
                 }); 

                    $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');  
       return false;

});
// ------------------------------------------------
$('#btn_cancel_deleting').click(function(){

        $('#deleting_id').val('');
        $('.material_list li.confirm_deleting_state').removeClass('confirm_deleting_state');
        $('#delete_confirm_window').modal('hide');
        return false;
});
// ------------------------------------------------
$('.material_open a.del_material').click(function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');

              return false;
});
// ------------------------------------------------


/*$('.edit_sample').click(function(){

      $('#sample_modal').modal('show');
      $(this).parents('.photo_type').addClass('adding_photo');
});*/
$('body').on('click','.edit_sample', function(){

      $('#sample_modal').modal('show');
      $(this).parents('.photo_type').addClass('adding_photo');
});

// ------------------------------------------------

$('#sample_modal #list_sample li span input').click(function(){
              
              $("#sample_modal .loaded_img .img_container div").css('background-image',$(this).parents('li').find('div').css('background-image'));
              $('#tmp_new_sample').val(0);
              $('#tmp_id_sample').val($(this).val());
});
// ------------------------------------------------

$('#btn_pick_sample').click(function(){
               $('#new_sample').val($('#tmp_new_sample').val());
               $('#id_sample').val($('#tmp_id_sample').val());
               $('.material_open .sample_data em').css('background-image',$("#sample_modal .loaded_img .img_container div").css('background-image'));
               $(this).parents('.modal').modal('hide');

});
// ------------------------------------------------
$('#save_open_material').click(function(){
         $('#editmaterial').submit();


});
// ------------------------------------------------
$('#id_manufacturer_select').change(function(){
 var collection_by_manuf = '';
   var id_manuf = $('#id_manufacturer_select').val();
   $('#id_manufacturer').val(id_manuf);
   var f = 0;
   $.each(hash_collections[id_manuf]['collections'], function(i, item){

         console.log(i+'   '+item);
         collection_by_manuf += '<option value="'+i+'">'+item+'</option>'
         if (f == 0){

            $('#id_collection').val(i);
         }
         f = 1;

   });
   $('#id_collection_select').html(collection_by_manuf);


});
// ------------------------------------------------

$('#clear_filter').click(function(){

           $('#id_manufacturer').val(0);
           $('#id_color').val(0);
           $('#id_texture').val(0);
           $('#articul').val('');

           var data = new Object();
           data['manufacturer'] = $('#id_manufacturer').val();
           data['id_color'] = $('#id_color').val();
           data['id_texture'] = $('#id_texture').val();
           $('.material_list').html('');
           getmaterial();

           $('#crumbs').html('<div>'+hash_crumbs['manufacturer'][$('#id_manufacturer').val()]+'</div><em>/</em><div>'+hash_crumbs['texture'][$('#id_texture').val()]+'</div><em>/</em><div>'+hash_crumbs['color'][$('#id_color').val()])+'</div>'

           Hash.set(data); 
           //$('#filter_line')[0].reset();
           $('#filter_line select').each(function(){
                   $(this).find('option[value=0]').prop('selected','selected');
              });

            $('.material_list li .check input').map(function (i, el){
                      $(el).prop('checked',false);
            
              }); 
            $('#check_all').prop('checked',false);
            $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');
            $('.loaded_count').text('('+$('.material_list li').length+')');
 
       });

// ------------------------------------------------

$('.loaded_count').text('('+$('.material_list li').length+')');
// ------------------------------------------------
$('#check_all').click(function(){

       if($(this).is(":checked")) {
              $('.material_list li .check input').map(function (i, el){
                      $(el).prop('checked',true);
            
              });
              
        }else{

              $('.material_list li .check input').map(function (i, el){
                      $(el).prop('checked',false);
            
              });   
       }

       $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');


});
// ------------------------------------------------

$('.material_list li .check input').change(function(){

      $('#check_all').prop('checked',false);
      $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');

});
// ------------------------------------------------

$('#del_group').click(function(){
  var deleting_list = '';
  deleting_list_li ='';
  var f = 0;
   $('.material_list li .check input:checked').map(function (i, el){
            deleting_list += ((f > 0)? ",":"") + $(this).val();
            deleting_list_li += '<li>'+$(this).parents('li').find('a').html()+'</li>';
            $(this).parents('li').addClass('deleting');
            f = 1;
    });
    if(f){  
            $('#deleting_list').val(deleting_list);
            $('#list_for_deleting').html(deleting_list_li);
            $('#delete_group_confirm_modal').modal('show');
            
      }
});
// ------------------------------------------------

$('#btn_confirm_group_deleting').click(function(){

             

});
// ------------------------------------------------

$('#price_group').click(function(){
  var pricing_list = '';
  pricing_list_li ='';
  var f = 0;
   $('.material_list li .check input:checked').map(function (i, el){
            pricing_list += ((f > 0)? ",":"") + $(this).val();
            pricing_list_li += '<li>'+$(this).parents('li').find('a').html()+'</li>';
            f = 1;
    });
    if(f){  
            $('#pricing_list').val(pricing_list);
            $('#list_for_pricing').html(pricing_list_li);
            $('#pricing_group_confirm_modal').modal('show');
            
      }
});

// ------------------------------------------------


 $('#more').click(function(){

           var limit    = $('#limit').val();
           var rowcount = $('#rowcount').val();
           $('#limit').val($('#rowcount').val());
           $('#start').val(0);
           $('.material_list').html('');
           getmaterial();

           $('#limit').val(limit);
           $("#start").val($("#rowcount").val());
           $('.loaded_count').text('('+$('.material_list li').length+')');

 });
 // ------------------------------------------------
$('#load_all').click(function(){

           var limit    = $('#limit').val();
           var rowcount = $('#rowcount').val();
           $('#limit').val($('#rowcount').val());
           $('#start').val(0);
           $('.material_list').html('');
           getmaterial();

           $('#limit').val(limit);
           $("#start").val($("#rowcount").val());
           $('#more').removeClass('visible');
           $('.loaded_count').text('('+$('.material_list li').length+')');

 });
 // ------------------------------------------------

$('#btn_confirm_group_pricing').click(function(){

      


               var data = new Object();
                   data = $('#form_pricing_group_update').serialize();
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajax/pricinggroup', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true,
                       error       : function(xhr, textStatus, errorThrown) {
                                       if(xhr.status == 403) {
                                              //alert(' error [403]');
                                              window.location.replace('http://' + location.hostname+'/admin');
                                          }}                       
                                 
                    })
               .done(function(data) {
                     
                     $('#pricing_group_confirm_modal').modal('hide');
                     //console.log(data.query);
                     //console.log(data.id);

                 }); 
               $('#pricing_group_confirm_modal').modal('hide');
  return false;
});
 // ------------------------------------------------
$('#btn_cancel_pricing').click(function(){
         $('#pricing_group_confirm_modal').modal('hide');

});

 // ------------------------------------------------

$('#btn_confirm_group_deleting').click(function(){

      


               var data = new Object();
                   data = $('#form_deleting_group').serialize();
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajax/deletinggroup', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true,    
                       error       : function(xhr, textStatus, errorThrown) {
                                       if(xhr.status == 403) {
                                              //alert(' error [403]');
                                              window.location.replace('http://' + location.hostname+'/admin');
                                          }}
                                 
                    })
               .done(function(data) {
                     $('.material_list li.deleting').remove();
                     $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');
                     $('.loaded_count').text('('+$('.material_list li').length+')');
                     $('#delete_group_confirm_modal').modal('hide');
                     //console.log(data.query);
                     //console.log(data.id);

                 }); 
                     $('.material_list li.deleting').remove();
                     $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');
                     $('.loaded_count').text('('+$('.material_list li').length+')');
                     $('#delete_group_confirm_modal').modal('hide');

                     //перегрузить "найдено" и ошибка!!!
  return false;
});
 // ------------------------------------------------
$('#btn_cancel_deleting').click(function(){
         $('#delete_group_confirm_modal').modal('hide');

});



//---------------------------------------------------
$('.textures li.add span').click(function(){
           if(!$(this).parent().hasClass('adding')){
                      $(this).parent().addClass('adding');
           }

});

$('.textures li.add .form_to_add form div #adding').click(function(){
              var action = $(this).parents('form').prop('action');
              var data = $(this).parents('form').serialize();
              var list = $(this).parents('ul');
              play_ajax(action,data,list);
              
              
              $($(this).parents('form').find('div input')).map(function(i,el){ if($(el).prop('type')!='button'){$(el).val('');}});
              $(this).parents('li').removeClass('adding');
  return false;
});

function append_to_stack(new_element, list){
       var elems = $(list).find('.ajax_edit_obj');
       $(list).find('.ajax_edit_obj').remove();
       $(list).append(new_element);
       $(list).append(elems);


}

$('#search_by_articul').keyup(function(){
    
    var word = $(this).val();
    var reg = new RegExp("(^"+word+")", "i");
 
    $.each($('#form_analogs li div small'),function(){
      if(!$(this).parents('li').find('input').is(':checked')){
             var str = $(this).text();
             if (!reg.test(str)) {$(this).parents('li').addClass('hidden'); }else{$(this).parents('li').removeClass('hidden');}
       }      
    });
    

});

$('#search_by_file_name').keyup(function(){
    
    var word = $(this).val();
    var reg = new RegExp("(^"+word+")", "i");
 
    $.each($('#list_sample li span.file_name'),function(){
      if(!$(this).parents('li').find('input').is(':checked')){
             var str = $(this).text();
             if (!reg.test(str)) {$(this).parents('li').addClass('hidden'); }else{$(this).parents('li').removeClass('hidden');}
       }      
    });
    

});


});