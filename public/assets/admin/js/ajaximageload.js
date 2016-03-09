
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
                   $('#sample_modal .loaded_img').removeClass('loading');
                   //console.log(result);
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
