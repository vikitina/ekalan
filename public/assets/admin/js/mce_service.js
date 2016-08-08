$(document).on('focusin', function(e) {
  if ($(e.target).closest(".mce-window").length) {
    e.stopImmediatePropagation();
  }
});
  
  
$(document).ready(function(){

                    tinymce.init({
                                selector: 'textarea.tiny'
                               , height: 500
                               , plugins: []
                               , toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent'
                               , content_css: [
                                    
                                           "{{ basePath('assets/admin/js/tinymce.min.js') }}"
                                       ] 
                                , setup : function(ed) {
                                            
                                             var el= this;
                                             var id = '#' + $(el).attr('id');

                                             ed.on('keypress', function(e) {
                                                          //console.log('Editor was clicked '+this.getContent() + '    '+id);
                                                          $(id).val(this.getContent());
                                                          $(id).parent().removeClass('error');
                                                          //console.log($(id).val() + '    ------------    ');
                                              });
                                   }
 



                             });
                  
 

});