
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
                });

                request.done(function (result, request, headers) {
                   $('#tmp_id_sample').val(0);
                   $('#tmp_new_sample').val(result.name);
                   $('#sample_modal .loaded_img .img_container div').css('background-image','url("'+result.url+'")');
                   $('#sample_modal').find('.new_upload_img_container').html('<img src="'+result.url+'" />');
                   $('.new_upload_img_container img').cropper({
                                aspectRatio: 1,
                                preview: $('.loaded_img .img_container'),
                                       crop: function(e) {
    // Output the result data for cropping image.

                                                var json = [
                                                     '{"x":' + e.x,
                                                     '"y":' + e.y,
                                                     '"height":' + e.height,
                                                     '"width":' + e.width,
                                                     '"rotate":' + e.rotate + '}'
                                              ].join();

                                               $('#crop_img_data').val(json);

                                              /*   console.log(e.x);
                                                 console.log(e.y);
                                                 console.log(e.width);
                                                 console.log(e.height);
                                                 console.log(e.rotate);
                                                 console.log(e.scaleX);
                                                 console.log(e.scaleY);*/
                                        }
                    });

                   $('#sample_modal .loaded_img').removeClass('loading');
                   //console.log(result);
                });


                request.fail(function (error, textStatus, errorThrown) {
                    console.error(error, textStatus, errorThrown); //TODO must create a dialog popup
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

                console.log('list_class '+list_class);
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
               
                    if($('#'+id).parent().parent().hasClass('with_main_photo_radio')){
                            var check = ($('#'+id).parent().find('li').length > 1) ? "" :"checked" ;
                            radio = '<label class="main_radio"><input type="radio" name="main_photo" value="'+result.name+'" '+check+'>Главная</label>';

                    }
                        
                        $('#'+id).find('div').css('background-image', "url('"+result.url+"')");
                        $('#'+id).find('div').append('<input type="hidden" name="'+list_class+'[]" value="'+result.name+'">' + radio);

                        if($('.'+list_class).find('.add_photo_btn').hasClass('only_one')){

                            $('.'+list_class).find('.add_photo_btn').addClass('add_photo_btn_hidden');
                        }
                });


                request.fail(function (error, textStatus, errorThrown) {
                    console.error(error, textStatus, errorThrown); //TODO must create a dialog popup
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
