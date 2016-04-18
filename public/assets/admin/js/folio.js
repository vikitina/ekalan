$(document).ready(function(){
	
    $('.add_photo_btn').click(function(){
	//add_photo_btn" data-form-id="photos_for_folio"
	var id_form = $(this).attr('data-form-id');

	console.log('id_form '+id_form);
    $('#'+id_form).find('.input_file_hidden').click();
    });
/*---------------------------------------------------------*/
     $('#materials_folio_open_window').click(function(){

     	$('#material_list_modal').modal('show');
     });

/*----------------------------------------------------------*/   

$('.photos_list').on('mouseover','li',function(){

	$(this).addClass('hover');
});
$('.photos_list').on('mouseout','li',function(){

	$(this).removeClass('hover');
});
/*----------------------------------------------------------*/   
$('.photos_list').on('click','li>span',function(){
    var list = $(this).parent().parent().find('li');
    if(list.length < 2){
         $(this).parent().parent().addClass('empty');
         $(this).parent().parent().find('.required_container .checker_input').val('');
         $(this).parent().parent().parent().find('.add_photo_btn').removeClass('add_photo_btn_hidden');

    }
    
	$(this).parent().remove();
	
});
/*-------check form required------------------------------------------------------*/

$('.checker').click(function(){

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
           $.ajax({
                       type        : 'POST', 
                       url         :  action, 
                       data        :  data, 
                       dataType    : 'json', 
                       encode      : true
                                 
                    })
           .done(function(res) {
                    
                    console.log(res.data);
 
                  
                 }); 
                   if ($(this).hasClass('withAddingAction')){

                    	addingAction($(this).attr('data-params'), new Object({'elem' : $(this)}));
                    	
  }
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
               $(data.elem).parents('.accordion-section').find('.accordion-title span.title').text(text);
		               //сообщение об успехе
		       $(data.elem).parents('.accordion-content').find('.alert').css('display','block');
               $(data.elem).parents('.accordion-content').find('.alert').find('input.focus_alert').focus();

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
console.log(prepared_photo);
              var html =  '<li><span><i class="fa fa-times"></i></span>';
                  html += '<div style=\'background-image: ' + prepared_photo + ';\'>';
                  html += '<input type="hidden" name="data['+ i +'][url_photo]" value="'+ url_photo +'">';
                  html += '<input type="hidden" name="data['+ i +'][id_photo]" value="'+ id_sample +'"></div></li>';

              $('.adding_photo').find('.photos_list').removeClass('empty').html(html);
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
// ------------------------------------------------
$('#delete_confirm_window #btn_confirm_deleting').click(function(){
         $('.material_list li.confirm_deleting_state').remove();
         var data = new Object();
         data['id'] = $('#deleting_id').val();
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

});

/*--------------------------------------------------------*/


//удаление окна карусели
$('#karusel').on('click','span.del_window_ajax', function(){

              var id = $(this).attr('data-id');
              $('#delete_confirm_window').modal('show');
              $(this).parents('.accordion-section').addClass('confirm_deleting_state');
              $('#deleting_id').val(id);
              return false;
});
// ------------------------------------------------
$('#delete_confirm_window #btn_confirm_deleting').click(function(){
         $('.confirm_deleting_state').remove();
         var data = new Object();
         data['id'] = $('#deleting_id').val();
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
$('#delete_confirm_window').on('hidden.bs.modal',function(){

	$('.confirm_deleting_state').removeClass('.confirm_deleting_state');
});

$('#add_new_window_karusel').click(function(){
     if(!$(this).hasClass('adding_window')){
	          $('#karusel').find('.accordion-section').first().before($('#template_new_window').html());
	          $(this).addClass('adding_window');
	     }     
});

$('#karusel').on('click','.cancel_adding_window',function(){

    $(this).parents('.accordion-section').remove();
    $('#add_new_window_karusel').removeClass('adding_window');
    return false;

});
});