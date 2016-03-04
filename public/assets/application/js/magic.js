
$(document).ready(function() {
  //$('.stickem-container').stickem();
    // process the form
    $('form#selling_campaign').submit(function(event) {

        var formData = $( this ).serialize() ;
        
console.log( $( this ).serialize() );
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/application/ajax', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
            // using the done promise callback
           .done(function(data) {
                //$('#selling_campaign')[0].reset();
                //$('.timer').countdown('stop');
                $('.sales').hide().find('right').html('');
                
                $('#thanksModal').modal('show');
                // log data to the console so we can see
                console.log(data.res); 

                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });


/* <form>
                                                           <input type="hidden" value="{{ sale.id }}" />
                                                           <textarea name="code_{{ sale.id }}">{{ sale.sales_markup }}</textarea>
                                                           <input type="submit" value="Запомнить" />
                                                       </form>*/

$('.sales_update').submit(function(event) {
   
        var formData = $( this ).serialize() ;
        
       // console.log( $( this ).serialize() );

        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/admin/ajax/sales', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
        .done(function(data) {
                //$('#selling_campaign')[0].reset();
                //$('.timer').countdown('stop');
                //$('.sales').hide().find('right').html('');
                $(this).parents('.accordion-content').find('.preview_action').html(data.sales_markup);//data.sales_markup
                
                // log data to the console so we can see
                //console.log('asdasdasdasdasd     '+data.res); 

                // here we will handle errors and validation messages
            });

   event.preventDefault();

});
     $(window).scroll(function(){
                 if ($(window).scrollTop() >= $(document).height() - $(window).height() - 800){
                           var start_count = (parseInt($("#start").val()) - 1)*parseInt($("#limit").val());
                           if(start_count <= parseInt($("#rowcount").val())) {
                                       var start = parseInt($("#start").val()) +1;
                                       $("#start").val(start);
                                       getmaterial();
                                  }


                                  console.log('scroll');
                           }
                        });

$('.filter').click(function(){
       var data = new Object();

       $(this).parent().find('.selected').removeClass('selected');
       $(this).addClass('selected');
       var name = '#'+$(this).attr('data-name');
       var value = $(this).attr('data-value');
       $(name).val(value);
       $(name).attr('data-title',$(this).attr('data-title'))
       

       data['manufacturer'] = $('#id_manufacturer').attr('data-title');
       data['id_color'] = $('#id_color').val();
       
       data['id_texture'] = $('#id_texture').val();
       Hash.set(data);
       $("#start").val(1);
       $('.set_material').html('');
       getmaterial();
});

function getmaterial(){
       var data = $('#filter').serialize();
       $('.ajax_loader').addClass('.ajax_loader_show');
 $.ajax({
            type        : 'POST', 
            url         : 'http://' + location.hostname + '/materialajax', 
            data        : data, 
            dataType    : 'json', 
            encode          : true
                                 
        })
        .done(function(data) {
               
                $('.ajax_loader').removeClass('.ajax_loader_show');
                $('.set_material').append(data.res);
                $('#rowcount').val(data.rowcount);
               // var stickyContainer = $('.stickem-container');
                //stickyContainer.stickem().destroy();
                //stickyContainer.stickem();
                console.log('query     '+data.query); 
                 console.log('id_color =      '+data.id_color); 
                 //console.log('html =      '+data.res); 
                
            });       

}

$('.set_material').on('click','li',function(){

       var id = $(this).attr('data-sample');
       var data = new Object();
       data['id'] = id;
       data['analog_color'] = $('#id_color').val();
       data['analog_texture'] = $('#id_texture').val();
       
 $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/sampleajax', // the url where we want to POST
            data        : data, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
        .done(function(data) {
               
 
               
                $('#materialModal').modal('show');
                $('#materialModal').find('.modal-body').html(data.html);
 
            });         

});



$('#materialModal .modal-body').on('click','.analogs dl',function(){

       var id = $(this).attr('data-sample');
       var data = new Object();
       data['id'] = id;
       data['analog_color'] = $('#id_color').val();
       data['analog_texture'] = $('#id_texture').val();
       
 $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/sampleajax', // the url where we want to POST
            data        : data, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
        .done(function(data) {
               
 
               
                //$('#materialModal').modal('show');
                $('#materialModal').find('.modal-body').html('');
                $('#materialModal').find('.modal-body').html(data.html);
 
            });         

});


});
