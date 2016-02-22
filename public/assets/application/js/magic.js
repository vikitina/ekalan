
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

       var data = $('#filter').serialize();
 $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/materialajax', // the url where we want to POST
            data        : data, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
        .done(function(data) {
               
               
                $('.set_material').html(data.res);
                console.log('query     '+data.query); 
                 console.log('id_color =      '+data.id_color); 
                 //console.log('html =      '+data.res); 
                
            });       
});


$('.set_material').on('click','li',function(){

       var id = $(this).attr('data-sample');
       var data = new Object();
       data['id'] = id;
 $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/sampleajax', // the url where we want to POST
            data        : data, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
        .done(function(data) {
               
                var material = data.res;
                // log data to the console so we can see
                console.log('asdasdasdasdasd     '+material.url); 
                console.log('asdasdasdasdasd     '+data.query); 
               
                $('#materialModal').modal('show');
                url = ((material.url != '') && material.url != null) ? "/assets/application/samples/"+material.url : "/assets/application/img/no_photo.png";
                console.log('url     '+url); 
                $('#materialModal').find('.modal-body dl dt').css('background', 'url('+url+') no-repeat top left');

                var list = '<ul>';
                list += '<li><strong>Наименование</strong><span>'+material.name_material+'</span></li>';
                list += '<li><strong>Артикул</strong><span>'+material.articul+'</span></li>';
                list += '<li><strong>Производитель</strong><span>'+material.manufacturer+'</span></li>';
                list += '<li><strong>Коллекция</strong><span>'+material.collection+'</span></li>';
                list += '<li><strong>Цвет</strong><span>'+material.color+'</span></li>';
                list += '<li><strong>Текстура</strong><span>'+material.texture+'</span></li>';
                list += '<li><strong>Цена</strong><span>'+material.price_material+'</span></li>';
                list += '<li><strong>sample(for trace)</strong><span>'+material.sample+'</span></li>';
                list += '</ul>';
                $('#materialModal').find('.modal-body dl dd').html(list);
            });         

});


});
