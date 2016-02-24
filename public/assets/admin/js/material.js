$(document).ready(function(){



      $(window).scroll(function(){
                 if ($(window).scrollTop() == $(document).height() - $(window).height()){
                           var start_count = (parseInt($("#start").val()) - 1)*parseInt($("#limit").val());
                           if(start_count <= parseInt($("#rowcount").val())) {
                                       var start = parseInt($("#start").val()) +1;
                                       $("#start").val(start);
                                       getmaterial();
                                  }


                                  console.log('scroll');
                           }
                        });


      //смена в фильтрах

      $('.mfilter select').change(function(){

             var id = '#' + $(this).parent().attr('data-name');
             $(id).val($(this).val());
             $("#start").val(1);
             getmaterial();
             $('.material_list').html('');
             
      });

      function getmaterial(){


            var data = $('#filter').serialize();
             $.ajax({
                       type        : 'POST', 
                       url         : 'http://' + location.hostname + '/admin/ajax/materialfilter', 
                       data        :  data, 
                       dataType    : 'json', 
                       encode          : true
                                 
                    })
               .done(function(data) {
               
               
                      $('.material_list').append(data.html);
                      $('#rowcount').val(data.rowcount);
                      console.log('query     '+data.query); 
                      //console.log('id_color =      '+data.id_color); 
                 
                
                 });          
      }
});