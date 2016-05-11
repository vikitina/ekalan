$(document).ready(function(){
	
    $('body').on('click', '.add_photo_btn',function(){
	//add_photo_btn" data-form-id="photos_for_folio"
	var id_form = $(this).attr('data-form-id');

	//console.log('qqqid_form '+id_form);
    $('#'+id_form).find('.input_file_hidden').click();
    });
/*---------------------------------------------------------*/
     $('#materials_folio_open_window').click(function(){

            	$('#material_list_modal').modal('show');
     });

/*----------------------------------------------------------*/   

$('body').on('mouseover','.photos_list li',function(){

	        $(this).addClass('hover');
});
$('.photos_list').on('mouseout','li',function(){

	        $(this).removeClass('hover');
});
/*----------------------------------------------------------*/   
$('body').on('click','.photos_list > li > span',function(){
    var list = $(this).parent().parent().find('li');
    if(list.length < 2){
         $(this).parent().parent().addClass('empty');
         $(this).parent().parent().find('.required_container .checker_input').val('');
         $(this).parent().parent().parent().find('.add_photo_btn').removeClass('add_photo_btn_hidden');

    }
    
	$(this).parent().remove();
	
});
/*-------check form required------------------------------------------------------*/

$('body').on('click','.checker', function(){

       var form_id = '#' + $(this).attr('data-form');

       $(form_id .error).map(function(){
               $(this).removeClass('error');



       });

       $(form_id+' .required').map(function(){

       	           if($(this).val() == ''){

       	           	       $(this).parent().addClass('error');
                           if ($(this).attr('type') == 'hidden'){

                           	console.log('here hidden');
                           	console.log($(this));


                           }
       	           }
       });
       
             var arr = $(form_id).find('.error');
       	     console.log('mistake --'+arr.length);


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

function addingAction(params, data){

	switch (params) {

		case 'updatekarusel':

		               //заголовок окна
		               
		       var text = $(data.elem).parents('.accordion-content').find('.title_windowkarusel').val();
               $(data.elem).parents('.accordion-section').find('.myaccordion-title span.title').text(text);
		               //сообщение об успехе
		       $(data.elem).parents('.accordion-content').find('.alert').css('display','block');
               $(data.elem).parents('.accordion-content').find('.alert').find('input.focus_alert').focus();

		break;
		case 'addkarusel':

		
    	       $(data.elem).parents('form').attr('action','/admin/updatekarusel');
    	       $(data.elem).parents('form').find('h3').text('Редактирование экрана карусели');
		       $(data.elem).parents('.accordion-section').find('.del_window_ajax').attr('data-id',$('#window_id').val());
		       $(data.elem).parents('.accordion-section').find('input[name="id_window"]').val($('#window_id').val())
		       $(data.elem).parents('.accordion-section').removeClass('new_section');
		       var text = $(data.elem).parents('.accordion-content').find('.title_windowkarusel').val();
               $(data.elem).parents('.accordion-section').find('.myaccordion-title span.title').text(text);
		               //сообщение об успехе
		       $(data.elem).parents('.accordion-content').find('.alert').css('display','block');
               $(data.elem).parents('.accordion-content').find('.alert').find('input.focus_alert').focus();
               $(data.elem).parents('.adding_button_block').remove();
               $('#add_new_window_karusel').removeClass('adding_window');
		break;
		default:
		break;
	}
}
$('input.focus_alert').blur(function(){

	$(this).parents('.alert').css('display','none');
});
/*----------------------------------------------------*/
$('li').on('keyup', '.required',function(){

	$(this).parent().removeClass('error');
});
/*----------------------------------------------------*/
$('.required').on('change', function(){

	$(this).parent().removeClass('error');
});
/*--------------------------------------------------------*/
$('.required').parent().addClass('required_container');

/*------------------------------------------------------*/

$('#public_on_home_testimonials').click(function(){
//console.log('click');
	if($(this).prop('checked') == true){

		$('#name_testimonials').addClass('required');
		$('#name_testimonials').parent().addClass('required_container');
		$('#name_testimonials').parent().parent().addClass('show_hidden_star');

		$('#text_testimonials').addClass('required');
		$('#text_testimonials').parent().addClass('required_container');
		$('#text_testimonials').parent().parent().addClass('show_hidden_star');



	}else{
		$('#name_testimonials').removeClass('required');
		$('#name_testimonials').parent().removeClass('required_container');
		$('#name_testimonials').parent().removeClass('error');
		$('#name_testimonials').parent().parent().removeClass('show_hidden_star');

        $('#text_testimonials').removeClass('required');
		$('#text_testimonials').parent().removeClass('required_container');
		$('#text_testimonials').parent().removeClass('error');
		$('#text_testimonials').parent().parent().removeClass('show_hidden_star');


	}
});

$('.text_data').on('click','li .del_category_ajax',function(){
      $(this).parents('li').addClass('deleting_category');
      var action = $(this).find('form').attr('action');
      var data   = $(this).find('form').serialize();
      //console.log(data);
           $.ajax({
                       type        : 'POST', 
                       url         :  action, 
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
               .done(function(res) {
                    $('#'+res.status).modal('show');
                    //console.log(res.res);
                 });        

});


$('.cannot_deleting_category .btn_ok').click(function(){

       $('.cannot_deleting_category').modal('hide');
       $('.deleting_category').removeClass('deleting_category');

});
$('.can_deleting_category .btn_confirm_deleting').click(function(){

	   var data   = $('.deleting_category').find('.del_category_ajax').find('form').serialize();


            $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/deletingcategory', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
               .done(function(data) {
                     
                             $('.can_deleting_category').modal('hide');
	                         $('.deleting_category').remove();
                 });      

});

$('.can_deleting_category .btn_cancel_deleting').click(function(){
	      $('.can_deleting_category').modal('hide');
	      $('.deleting_category').removeClass('deleting_category');
	  });


/*--------------------------------------------*/

$('#karusel').on('click','.frame .type_frame .change_type',function(){

	var active_block = $(this).attr('data-type-frame');
	$(this).parent().parent().find('.active').removeClass('active');
	$(this).parent().parent().find('.content_block .'+active_block).addClass('active');

});

/*-----------------------------------------------*/

$('#btn_pick_karusel_photo').click(function(){
              var i              = $('.adding_photo').parents('.frame').attr('data-num-frame');
              var url_photo      = $("#tmp_new_sample").val();
              var id_sample      = $("#tmp_id_sample").val();
              var prepared_photo = $('#sample_modal').find('.img_container > div').css('background-image');
//console.log(prepared_photo);
              var html =  '<li><span><i class="fa fa-times"></i></span>';
                  html += '<div style=\'background-image: ' + prepared_photo + ';\'>';
                  html += '<input type="hidden" name="data['+ i +'][url_photo]" value="'+ url_photo +'">';
                  html += '<input type="hidden" name="data['+ i +'][id_photo]" value="'+ id_sample +'"></div></li>';

              $('.adding_photo').find('.photos_list').removeClass('empty').html(html);
              $('#sample_modal .img_container div').css('background-image','');
              $('#tmp_new_sample').val(0);
              $('#tmp_id_sample').val(0);
              $('#list_sample li span input').attr('checked',false);

              $('#sample_modal').modal('hide');
              
              $('.adding_photo').find('.only_one').addClass('add_photo_btn_hidden');
              $('.adding_photo').removeClass('adding_photo');
              return false;

});

/*--------------------------------------------------------*/


//удаление проекта
$('#folios .material_list').on('click','li span.del_folio_ajax', function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');
              $(this).parent('li').addClass('confirm_deleting_state');
              $('#deleting_id').val(id);
});
$('#articles .material_list').on('click','li span.del_article_ajax', function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');
              $(this).parent('li').addClass('confirm_deleting_state');
              $('#deleting_id').val(id);
});
$('.del_article').on('click', function(){

              
              $('#delete_confirm_window').modal('show');
             
});
// ------------------------------------------------   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
/*$('#delete_confirm_window #btn_confirm_deleting').click(function(){
         $('.material_list li.confirm_deleting_state').remove();
         var data = new Object();
         data['id'] = $('#deleting_id').val();
         console.log('folio строка 299');
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajaxdelfolio', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
                     $('#deleting_id').val('');
                     $('#delete_confirm_window').modal('hide');
                 }); 

                    $('#selected_list_length').text('('+$('.material_list li .check input:checked').length+')');  

});*/

/*--------------------------------------------------------*/


//удаление окна карусели
$('#karusel').on('click','span.del_window_ajax', function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');
              $(this).parents('.accordion-section').addClass('confirm_deleting_state');
              $('#deleting_id').val(id);
              return false;
});
// ------------------------------------------------   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
/*$('#delete_confirm_window #btn_confirm_deleting').click(function(){
         $('.confirm_deleting_state').remove();
         var data = new Object();
         data['id'] = $('#deleting_id').val();
         console.log('folio строка 334');
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajaxdelkarusel', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
                     $('#deleting_id').val('');
                     $('#delete_confirm_window').modal('hide');
//console.log(data.id);
                 }); 

                   

});
*/
$('#delete_confirm_window').on('hidden.bs.modal',function(){

	$('.confirm_deleting_state').removeClass('.confirm_deleting_state');
});

$('#add_new_window_karusel').click(function(){
     if(!$(this).hasClass('adding_window')){
	          $('#karusel').find('.accordion-section').first().before($('#template_new_window .accordion-section').clone(true));

	          var new_id = 'addkarusel_'+Date.now();
	          $('#karusel .new_section').find('form').attr('id',new_id);
	          $('#karusel .new_section').find('.adding_button_block input.checker').attr('data-form',new_id);
	          $('#karusel .new_section').find('.editing_button_block input.checker').attr('data-form',new_id);
	          $(this).addClass('adding_window');
	     }     
});

$('#karusel').on('click','.cancel_adding_window',function(){

    $(this).parents('.accordion-section').remove();
    $('#add_new_window_karusel').removeClass('adding_window');
    return false;

});

$('.accordion').on('click', '.accordion-section .myaccordion-title', function(){

    if(!$(this).hasClass('active')){
	             $(this).addClass('active');
	             $(this).parents('.accordion-section').find('.accordion-content').css('display','block');
	 }else{

	 	         $(this).removeClass('active');
	 	         $(this).parents('.accordion-section').find('.accordion-content').css('display','none');
	 }            
});


var spectrum_params = new Object(

{
    showPaletteOnly: true,
    togglePaletteOnly: true,
    togglePaletteMoreText: 'more',
    togglePaletteLessText: 'less',
   // color: 'blanchedalmond',
    palette: [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ]
}	
);





$(".colors").each(function(){
         $(this).spectrum({
                showPaletteOnly: true,
                togglePaletteOnly: true,
                togglePaletteMoreText: 'more',
                togglePaletteLessText: 'less',
                color: $(this).prop('data-color'),
                palette: [
                              ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
                              ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
                              ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
                              ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
                              ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
                              ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
                              ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
                              ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
                         ]
         });


});

$(".ajax_art_public input").click(function(){
        if($(this).prop('checked')){
             var id = $(this).attr('data-id');
             var data = new Object({'public':'1','id': id, 'type' : 'public'});
        }else{
             $(this).parents('li').find(".ajax_art_on_home input").prop('checked',false);
             var id = $(this).attr('data-id');
             var data = new Object({'on_home':'0','public':'0','id': id, 'type' : 'public_and_on_home'});
        }
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajaxpublicart', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
                     console.log(data.res);
                 }); 


});


$(".ajax_art_on_home input").click(function(){
         if($(this).prop('checked')){
                  $(this).parents('li').find(".ajax_art_public input").prop('checked',true);
                  var id = $(this).attr('data-id');
                  var data = new Object({'on_home':'1','public':'1','id': id, 'type' : 'public_and_on_home'});                  

         }else{
                  var id = $(this).attr('data-id');
                  var data = new Object({'on_home':'0','id': id, 'type' : 'on_home'});

         }
               $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajaxpublicart', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
                     console.log(data.res);
                 }); 
         });

});

