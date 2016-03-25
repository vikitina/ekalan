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
       
           $(form_id).submit();

       }

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
console.log('click');
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
		$('#name_testimonials').parent().parent().removeClass('show_hidden_star');

        $('#text_testimonials').removeClass('required');
		$('#text_testimonials').parent().removeClass('required_container');
		$('#text_testimonials').parent().parent().removeClass('show_hidden_star');


	}
});



});