
$(document).ready(function() {

    $('form#selling_campaign').submit(function(event) {
        var formData = $( this ).serialize() ;
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/application/ajax', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
           .done(function(data) {
                $('.sales').hide().find('right').html('');
                $('#thanksModal').modal('show');
            });
        event.preventDefault();
    });

    $('form#footer_contact').submit(function(event) {
        var formData = $( this ).serialize() ;
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'http://' + location.hostname + '/application/ajax', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
                                 
        })
           .done(function(data) {
                $('form#footer_contact')[0].reset();
                $('#thanksModal').modal('show');
            });
        event.preventDefault();
    });



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
                $(this).parents('.accordion-content').find('.preview_action').html(data.sales_markup);

   event.preventDefault();

});
});        
     $(window).scroll(function(){
                 if ($(window).scrollTop() >= $(document).height() - $(window).height() - 800){
                           var start_count = (parseInt($("#start").val()) - 1)*parseInt($("#limit").val());
                           if(start_count <= parseInt($("#rowcount").val())) {
                                       var start = parseInt($("#start").val()) +1;
                                       $("#start").val(start);
                                       getmaterial();
                                  }
                           }
                        });

$('ul').on('click','.filter',function(){
       var data = new Object();
      
       $(this).parent().find('.selected').removeClass('selected');
       $(this).addClass('selected');
       if ($(this).parents('ul').hasClass('manufact')){

                $('#id_collection').val('0');
                $('#id_collection').attr('data-title','0');
       }
       var name = '#'+$(this).attr('data-name');
       var value = $(this).attr('data-value');
       $(name).val(value);
       $(name).attr('data-title',$(this).attr('data-title'));
       

       data['manufacturer'] = $('#id_manufacturer').attr('data-title');
       data['id_color'] = $('#id_color').val();
       
       data['id_texture'] = $('#id_texture').val();
       data['id_collection'] = $('#id_collection').val();
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
                var li = '<li class="filter all col-lg-12 col-md-12 col-sm-12 col-xs-12" data-name="id_collection" data-value="0" data-title="0"><span>Все</span></li>';
                //console.log(data.set_collections);
                var set_collections = data.set_collections;
                set_collections.map(function(el, i){
                  //console.log(el); 
                  li += '<li class="filter col-lg-4 col-md-6 col-sm-12 col-xs-12" data-name="id_collection" data-value="'+ el.id + '" data-title="' + el.name_collection + '"><span>' + el.name_collection + '</span></li>';
                       

                });
                $('#collections_line').html(li);

                //console.log(li); 
                
                
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
