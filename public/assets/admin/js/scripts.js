
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




});