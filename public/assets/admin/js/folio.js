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
         $(this).parent().parent().parent().find('.add_photo_btn').removeClass('add_photo_btn_hidden');

    }
    
	$(this).parent().remove();
	
});


});