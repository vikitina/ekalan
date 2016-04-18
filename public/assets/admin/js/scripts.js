
$(document).ready(function(){

  $(".alert").addClass("in").fadeOut(4500);

/* swap open/close side menu icons */
$('[data-toggle=collapse]').click(function(){
  	// toggle icon
  	$(this).find("i").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
});








$('.check_msg > input').on('click', function(ev) {
    
    var cur_index = parseInt($(this).attr('data-id'));
     
    if ($(this)[0].checked){

        already_read = 1;
    }else{

        already_read = 0;
    }

    data = {'id' : cur_index, 'already_read' : already_read};

$.ajax({
                    type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url         : 'http://' + location.hostname + '/admin/ajax/msgread', // the url where we want to POST
                    data        :  data, // our data object
                    dataType    : 'json', // what type of data do we expect back from the server
                    encode      : true
                                 
            })
            // using the done promise callback
           .done(function(data) {
                
               $('#uread_msgs').text(data.new_count_unread_msgs);
       
            });

});



$('.system_list').on('click',function(event){
       $('#system_modal').modal('show');
       $('#system_name').text($(this).text());
       $('#system_new_value').val($(this).attr('data-content'));
       $(this).addClass('blockig_for_processing');
       $('#system_new_value').attr('data-id', $(this).attr('data-id'));
       $('#system_comments').text($(this).attr('data-comment'));


 event.preventDefault();
});


$('#system_save_new_value').on('click',function(event){

    var data={
        'id'   : parseInt($('#system_new_value').attr('data-id')),
        'data' : $('#system_new_value').val()

    }
       $.ajax({
                    type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url         : 'http://' + location.hostname + '/admin/ajax/updatesystem', // the url where we want to POST
                    data        :  data, // our data object
                    dataType    : 'json', // what type of data do we expect back from the server
                    encode      : true
                                 
            })
            // using the done promise callback
           .done(function(data) {
                
               /*
                                                   <div class="alert alert-info">
                                                           <button type="button" class="close" data-dismiss="alert">×</button>
                                                         This message will checked as read
                                                   </div>

               */
               edited_elem = $('.blockig_for_processing');
               edited_elem.attr('data-content',$('#system_new_value').val()).removeClass('blockig_for_processing');

               $('#system_modal').modal('hide');

       
            });


event.preventDefault();

});
$('#system_modal').on('hide', function(){

               edited_elem = $('.blockig_for_processing');
               edited_elem.attr('data-content',$('#system_new_value').val()).removeClass('blockig_for_processing');

});


$('#system_save_new_value').on('click',function(event){

    
});


 $(".tabs").tabs();

      $(".accordion-title").click(function() {
        $(this).next().slideToggle("easeOut"), $(this).toggleClass("active"), $("accordion-title").toggleClass("active"), $(".accordion-content").not($(this).next()).slideUp("easeIn"), $(".accordion-title").not($(this)).removeClass("active")
    });
     $(".accordion-content").addClass("defualt-hidden");





/*scripts for sales*/
$('.edit').mouseover(function(){
  if(!($(this).parents('.preview_action').hasClass('locked') )){
  $(this).addClass('hover');
}

});
$('.edit').mouseout(function(){
  $(this).removeClass('hover');

});
$('.edit').click(function(){
 if(!($(this).parents('.preview_action').hasClass('locked') )){
  $(this).removeClass('hover').addClass('active');
  if(!($(this).hasClass('locked'))){
        var input = '<div class="textedit"><textarea>'+$(this).text()+'</textarea></div>';
        var html=$(this).html();
        $(this).html(html + input);
         $(this).addClass('locked');
         $(this).parents('.preview_action').addClass('locked');
      }
    }
  //console.log($(this).text());
});


$('.edit').on('keydown', 'div.textedit>textarea', function (e) {
    var key = e.which;
    if(key == 13) {
      var el_edit = $(this).parents('.edit');
        el_edit.text($(this).val());
        el_edit.removeClass('locked');
        el_edit.parents('.preview_action').removeClass('locked');


//собираем значения

       var markup = el_edit.parents('.preview_action').html();
       var id     = el_edit.parents('.accordion-section').find('input[name="id"]').val();
       //var data = new object();
       var data = {
        'markup' : markup,
        'id'     : id
      }
console.log('markup : '+markup+', id:'+id);


    $.ajax({
                    type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url         : 'http://' + location.hostname + '/admin/ajax/updatemarkupsales', // the url where we want to POST
                    data        :  data, // our data object
                    dataType    : 'json', // what type of data do we expect back from the server
                    encode      : true
                                 
            })
     .done(function(data) {
                
               //console.log(data.res);

       
            });



        return false;
    }
});
/*------------------------------------------------------------------*/
$('.radio-check').click(function(){

   if(!($(this).hasClass('radio-check-checked'))){
        $('#sales').find('.radio-check-checked').removeClass('radio-check-checked');
        $(this).addClass('radio-check-checked');
        $(this).find('input').attr('checked','checked');
        var id = $(this).parents('.accordion-section').find('input[name="id"]').val();
        var data={
            'active' : 1,
            'id'     :  id

        }
  $.ajax({
                    type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url         : 'http://' + location.hostname + '/admin/ajax/updateactivesales', // the url where we want to POST
                    data        :  data, // our data object
                    dataType    : 'json', // what type of data do we expect back from the server
                    encode      : true
                                 
            })
     .done(function(data) {
                
               //console.log(data.res);

       
            });


   }

});


$('.radio-check').mouseover(function(){
          $(this).addClass('radio-check-hover');

});
$('.radio-check').mouseout(function(){

             $(this).removeClass('radio-check-hover');
});

});