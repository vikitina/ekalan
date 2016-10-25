Hash = {
  // Получаем данные из адреса
  get:      function() {
       var indexes = ['manufacturer','id_color','id_texture','id_collection'];
    // [0] - производитель
    // [1] - цвет
    // [2] - текстура
    // [3] - материал

                 var data = {};
                     if(location.search) {
                              var param_str = decodeURIComponent(location.search.substr(1)).split('&');
                              for(var i = 0; i < param_str.length; i ++) {
                                        //var param = pair[i].split('=');
                                        //var key = param[0].match(/^.*\[(.*)\].*?/);
                                        //data[key[1]] = param[1];
                                        data[indexes[i]] = param_str;

                                }
                      }
                      
                      
              return data;
    
  }
  
  
  
  
  // Заменяем данные в адресе на полученный массив ======================================================
  
  ,set:          function(vars) {
                     var hash = '';

                    for (var i in vars) {
                            hash += '&' + vars[i];

                    }


                     if (!this.oldbrowser()) {
                              if (hash.length != 0) {
                                    hash = '/' + hash.substr(1);
                               }
                              // console.log("location: " + location.hostname);
                            window.history.pushState(hash, '', '/material'+hash);

                     
                      }
                    else {
                        window.location.hash = hash.substr(1);
                     }
                 }
                 
                 
                 
  // Добавляем одно значение в адрес
  ,add: function(key, val) {
    var hash = this.get();
    hash[key] = val;
    this.set(hash);
  }
  // Удаляем одно значение из адреса
  ,remove: function(key) {
    var hash = this.get();
    delete hash[key];
    this.set(hash);
  }
  
  
  
  // Очищаем все значения в адресе====================================================================
  ,clear:           function() {
                         this.set({});
  }
  
  
  // Проверка на поддержку history api браузером======================================================
  ,oldbrowser:      function() {
                          return !(window.history && history.pushState);
  }
};

$(document).ready(function(){
       var data = new Object();
       //data = Hash.get();
       //indexes = ['manufacturer','id_color','id_texture','id_material'];
       data['manufacturer'] = $('#id_manufacturer').attr('data-name');
       data['id_color'] = $('#id_color').val();
       data['id_texture'] = $('#id_texture').val();
       data['id_collection'] = $('#id_collection').val();
       //Hash.set();
       Hash.set(data);
       //console.log(data['manufacturer']+' '+data['id_color']+' '+data['id_texture']);
});