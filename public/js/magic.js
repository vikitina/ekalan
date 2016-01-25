// magic.js
$(document).ready(function() {

    // process the form
    $('form#selling_campaign').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = $( this ).serialize() ;
            //amount=%241000+-+%243299   firstName=asdasdasd  company=asdasdasd  email=asd%40gmail.com  phone=123123123123  msg_text=asdasdasdasdasd#
           /* 'firstName'              : $('input[name=firstName]').val(),
            'company'           : $('input[name=company]').val(),
            'email'             : $('input[name=email]').val(),
            'msg_text'    : $('textarea[name=msg_text]').val(),
            'services'     :$('.services checkbox').val(),
            'solutions' :$('checkbox[name="solutions[]"]').val(),
            'amount' :$('input[name=amount]').val(),
            'phone':$('input[name=phone]').val(),
*/

            //curl 'http://app2.lo/application/ajax?firstName=asdasdasd&company=vikitina%26co&email=vikitina%40gmail.com&msg_text=asadasd+asd+asd+asd&amount=%241000+-+%244431&phone=123123123' -H 'Host: app2.lo' -H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:39.0) Gecko/20100101 Firefox/39.0' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Accept-Language: en-US,en;q=0.5' -H 'Accept-Encoding: gzip, deflate' -H 'X-Requested-With: XMLHttpRequest' -H 'Referer: http://app2.lo/' -H 'Cookie: zdt-hidden=0; zdt-hidden=0; PHPSESSID=5fr4smja8c7goi6ak8atrssic6'
//'http://app2.lo/application/ajax?firstName=asdasdasd&company=vikitina%26co&email=vikitina%40gmail.com&msg_text=asadasd+asd+asd+asd&amount=%241000+-+%244431&phone=123123123'
        
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

});
