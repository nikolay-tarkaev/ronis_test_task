function registration_form(){
    var formData = new FormData($('#registration_form').get(0));
    $.ajax({
        url: $('#registration_form').attr('action'),
        type: $('#registration_form').attr('method'),
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: function(json){
            if(json){
                if(json.error == "1"){
				    $('#registration_result').text(json.info);
				    $('#registration_result').addClass('alert alert-danger');
				    $('#registration_result').removeClass('hidden');
                    $('body,html').animate({scrollTop: 0}, 200); 
				}
				else {
				    $('#registration_form').addClass('hidden');
				    $('#registration_result').text(json.info);
				    $('#registration_result').append("<br /> Теперь Вы можете войти на сайт используя свой логин и пароль");
				    $('#registration_result').removeClass('hidden alert-danger');
				    $('#registration_result').addClass('alert alert-success');
				}
                        
            }
        }
    });
}   