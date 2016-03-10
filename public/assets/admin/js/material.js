$(document).ready(function(){



      $(window).scroll(function(){
                 if ($(window).scrollTop() == $(document).height() - $(window).height()){
                           var start_count = (parseInt($("#start").val()) - 1)*parseInt($("#limit").val());
                           if(start_count <= parseInt($("#rowcount").val())) {
                                       var start = parseInt($("#start").val()) +1;
                                       $("#start").val(start);
                                       getmaterial();
                                  }


                                  console.log('scroll');
                           }
                        });


      //смена в фильтрах

      $('.mfilter select').change(function(){

             var id = '#' + $(this).parent().attr('data-name');
             $(id).val($(this).val());
             $("#start").val(1);
             
             $('.material_list').html('');
             getmaterial();
             
      });

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
                      //console.log('query     '+data.query); 
                      //console.log('id_color =      '+data.id_color); 
                 
                
                 });          
      }

$('#filter_articul').on('keyup',function(){

   console.log($(this).val());
   var word = $(this).val();
   $("#start").val(1);
   $("#articul").val(word);
   $('.material_list').html('');
   getmaterial();


});


$('.editable').mouseover(function(){
   if(!$(this).hasClass('editopen')){
         $(this).addClass('editablehover');
   }

});

$('.editable').mouseout(function(){
      $(this).removeClass('editablehover');
  
});
$('.editable').click(function(){
      $(this).addClass('editopen');
      $(this).find('.editarea input').focus();
      $(this).find('.editarea textarea').focus();
      $(this).select();


});

$('.editarea>input').blur(function(){

     $(this).parents('.editable').removeClass('editopen');
     var id='#'+$(this).attr('data-name');
     var set_value = $(this).val();
     $(id).val(set_value);
     $(this).parents('.editable').find('span').text(set_value);

    // console.log($(id).val());
});
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

$('.selectable').mouseover(function(){
   if(!$(this).hasClass('selectopen')){
         $(this).addClass('selectablehover');
   }

});

$('.selectable').mouseout(function(){
      $(this).removeClass('selectablehover');
  
});
$('.selectable').click(function(){
      $(this).addClass('selectopen');
      $(this).find('.editarea input').focus();
      $(this).select();


});

$('.custom_select li').click(function(){

     $(this).parents('.selectable').removeClass('selectopen');

});

$('#material_list_open_window').click(function(){

      $('#material_list_modal').modal(); 

});

$('#sample_list_open_window').click(function(){
       $('#sample_list_modal').modal();

});

$('#btn_pick_analogs').click(function(){
        
         var analogs_html='';
         var form_analogs_list = '';
         var f=0;
         $('#form_analogs li input:checked').map(function (i, el) {
                    console.log(i+'    '+$(el).val());
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

$('#analogs_list').on('mouseover', 'li', function(){

  $(this).addClass('hover');
});

$('#analogs_list').on('mouseout', 'li', function(){

  $(this).removeClass('hover');
});

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

//удаление материала
$('.material_list').on('click','li span.del_material_ajax', function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');
              $(this).parent('li').addClass('confirm_deleting_state');
              $('#deleting_id').val(id);
});
$('#delete_confirm_window #btn_confirm_deleting').click(function(){
         $('.material_list li.confirm_deleting_state').remove();
         var data = new Object();
         data['id'] = $('#deleting_id').val();
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajax/deletematerial', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
                     $('#deleting_id').val('');
                     $('#delete_confirm_window').modal('hide');
                 });   

});
$('#btn_cancel_deleting').click(function(){

        $('#deleting_id').val('');
        $('.material_list li.confirm_deleting_state').removeClass('confirm_deleting_state');
        $('#delete_confirm_window').modal('hide');
        return false;
});
$('.material_open a.del_material').click(function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');

              return false;
});


$('.edit_sample').click(function(){

      $('#sample_modal').modal('show');
});

$('#sample_modal #list_sample li span input').click(function(){

              $("#sample_modal .loaded_img .img_container div").css('background-image',$(this).parents('li').find('div').css('background-image'));
              $('#tmp_new_sample').val(0);
              $('#tmp_id_sample').val($(this).val());
});

$('#btn_pick_sample').click(function(){
               $('#new_sample').val($('#tmp_new_sample').val());
               $('#id_sample').val($('#tmp_id_sample').val());
               $('.material_open .sample_data em').css('background-image',$("#sample_modal .loaded_img .img_container div").css('background-image'));
               $(this).parents('.modal').modal('hide');

});

$('#save_open_material').click(function(){
         $('#editmaterial').submit();


});
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
});