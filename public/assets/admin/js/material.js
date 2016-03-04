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
      $(this).select();


});

$('.editarea>input').blur(function(){

     $(this).parents('.editable').removeClass('editopen');
     var id='#'+$(this).attr('data-name');
     var set_value = $(this).val();
     $(id).val(set_value);
     $(this).parents('.editable').find('span').text(set_value);

     console.log($(id).val());
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
    // var id='#'+$(this).attr('data-name');
     //var set_value = $(this).val();
    // $(id).val(set_value);
    // $(this).parents('.editable').find('span').text(set_value);

    // console.log($(id).val());
});

$('#material_list_open_window').click(function(){
//сверять со списком выбранных
  data = new Object();
  data['exclude'] = $('#exclude').val();//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajax/windowanalogs', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
               
               
                      $('#material_list_modal').find('.modal-body').html(data.modal_material_list_html);
                      $('#material_list_modal').modal();
                     
                
                 });      
       

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
                    analogs_html += '<li>'+$(el).parent().html()+'</li>';
                    
                    form_analogs_list += (f==1) ?','+$(el).val() :$(el).val();
                    f = 1;
             });
         $('#analogs_list').html(analogs_html);
         $('#analogs_list').removeClass('empty');
         $('#form_analogs_list').val(form_analogs_list);
         $('#material_list_modal').modal('hide');


return false;

});

});