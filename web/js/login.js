
function login_form(){
    var formData = new FormData($('#login_form').get(0));
    $.ajax({
        url: $('#login_form').attr('action'),
        type: $('#login_form').attr('method'),
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: function(json){
            if(json){      
                if(json.error == "1"){
                    $('#login_result').text(json.info);
				    $('#login_result').addClass('alert alert-danger');
				    $('#login_result').removeClass('hidden');
                    $('body,html').animate({scrollTop: 0}, 200); 
				}
                else {
                    window.location.href = "/";
                }
            }
        }
    });
}