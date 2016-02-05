// magic.js
$(document).ready(function() {

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


$('.filter').click(function(){
       $(this).parent().find('.selected').removeClass('selected');
       $(this).addClass('selected');
       var name = '#'+$(this).attr('data-name');
       var value = $(this).attr('data-value');
       $(name).val(value);
       var data = $('#filter').serialize();
 $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/materialajax', // the url where we want to POST
            data        : data, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
        .done(function(data) {
               
                
                // log data to the console so we can see
                console.log('asdasdasdasdasd     '+data.res); 
                $('.set_material').html(data.res);
                // here we will handle errors and validation messages
            });       
});


});
