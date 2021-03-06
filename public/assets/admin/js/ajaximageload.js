
;(function (win, doc, $, undefined) {
    /**
     * use strict doesn't play nice with IIS/.NET
     * http://bugs.jquery.com/ticket/13335
     */
    'use strict';

        /**
         * @namespace
         * @return {Object}
         */
    var request,
        ajaxImageUpload = {

        init: function () {

            $("button.upload").on("click", function (event) {
                event.preventDefault();
                $(".uploader-inline").show();
                $(".gallery-view").hide().find("figure.centered").remove();
            });

            ajaxImageUpload.abourtXHR(request);


            $("#sample").on("change", function (event) {
                event.preventDefault();
                $("#sample_form").submit();


                $("#sample").replaceWith($("#sample").val('').clone(true));

            });


            $("#sample_form").on("submit", function (event) {
                event.preventDefault();
                $('#sample_modal .loaded_img').addClass('loading');

                request = $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: new FormData($(this)[0]),
                    processData: false,
                    contentType: false,
                    cache: false,
                    error       : function(xhr, textStatus, errorThrown) {
                                       if(xhr.status == 403) {
                                              //alert(' error [403]');
                                              window.location.replace('http://' + location.hostname+'/admin');
                                          }}                    
                });

                request.done(function (result, request, headers) {
                   $('#tmp_id_sample').val(0);
                   $('#tmp_new_sample').val(result.name);
                   $('#sample_modal .loaded_img .img_container div').css('background-color','#fff').css('background-image','url("'+result.url+'")');
                   $('#sample_modal .loaded_img').removeClass('loading');
                   //console.log(result);
                });


                request.fail(function (error, textStatus, errorThrown) {
                    //console.error(error, textStatus, errorThrown); //TODO must create a dialog popup
                    if(error.status == 403) {
                                              //alert(' error [403]');
                                              window.location.replace('http://' + location.hostname+'/admin');
                                          }                    
                });
            });



/*----------------------------------------------------------*/

           $('.input_file_hidden').on("change", function (event) {
                event.preventDefault();
                $(this).parent().submit();


                $(this).replaceWith($(this).val('').clone(true));

            });
/*

//id
//url
                    var list = $(elem_list).val();
                    var arr = list.split('&');
                    arr.push(res.id).join('&');*/



            $(".form_photos").on("submit", function (event) {
                event.preventDefault();
                var list_class = $(this).prop('id');

               // console.log('list_class!! '+list_class);
                var id = "id"+(new Date).getTime();
                var new_el_li = '<li id="'+id+'"><span><i class="fa fa-times"></i></span><div></div></li>';

                $('.'+list_class+' .photos_list').removeClass('empty').append(new_el_li);
                
                request = $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: new FormData($(this)[0]),
                    processData: false,
                    contentType: false,
                    cache: false,
                                      
                });

                request.done(function (result, request, headers) {
                    var radio = '';
             //  console.log('result '+result);
                    if($('#'+id).parent().parent().hasClass('with_main_photo_radio')){
                            var check = ($('#'+id).parent().find('li').length > 1) ? "" :"checked" ;
                            radio = '<label class="main_radio"><input type="radio" name="main_photo" value="'+result.name+'" '+check+'>Главная</label>';

                    }
                        
                        $('#'+id).find('div').css('background-color','#fff').css('background-image', "url('"+result.url+"')");
                        $('#'+id).find('div').append('<input type="hidden" name="'+list_class+'[]" value="'+result.name+'">' + radio);

                        if($('.'+list_class).find('.add_photo_btn').hasClass('only_one')){

                            $('.'+list_class).find('.add_photo_btn').addClass('add_photo_btn_hidden');
                        }

                        $('.'+list_class).find('.required_container .checker_input').val('1');
                        $('.'+list_class).find('.required_container').removeClass('error');
                });


                request.fail(function (error, textStatus, errorThrown) {
                    //console.error(error, textStatus, errorThrown); //TODO must create a dialog popup
                    if(error.status == 403) {
                                              //alert(' error [403]');
                                              window.location.replace('http://' + location.hostname+'/admin');
                                          }
                });
            });


        },



        abourtXHR: function (xhr) {
            if (xhr && xhr.readyState !== 4) {
                xhr.abort();
                xhr = null;
            }
        }
    };


    $(doc).ready(function ($) {
        'use strict';
        ajaxImageUpload.init();
    });
})(this, document, jQuery);
