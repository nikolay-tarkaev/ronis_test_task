    $(document).ready(function(){
		$('#modal_banner_submit').on('click', function(e){
            var bannerName = $("#modal_banner_name").val();
            var bannerUrlProtocol = $("#modal_banner_url_protocol").val();
            var bannerUrlLink = $("#modal_banner_url_link").val();
            var bannerStatus = $("#modal_banner_status").val();
            var bannerFile = $("#modal_banner_file").val();
            
            if(!bannerName){
                $('.modal-banner-error').text("Введите название");
                $('.modal-banner-error').removeClass('hidden');
                return;
            }
            if(!bannerUrlProtocol){
                $('.modal-banner-error').text("Введите URL");
                $('.modal-banner-error').removeClass('hidden');
                return;
            }
            if(!bannerUrlLink){
                $('.modal-banner-error').text("Введите URL");
                $('.modal-banner-error').removeClass('hidden');
                return;
            }
            if(!bannerStatus){
                $('.modal-banner-error').text("Выберите статус");
                $('.modal-banner-error').removeClass('hidden');
                return;
            } else {
                formData = new FormData($('#modal_banner_form').get(0));
                $.ajax({
                    url: $("#modal_banner_form").attr('action'),
                    type: $("#modal_banner_form").attr('method'),
                    contentType: false,
				    processData: false,
                    data: formData,
                    dataType: 'json',
                    success: function(msg){
                        if(msg.error == "1"){
                            $('.modal-banner-error').text(msg.info);
                            $('.modal-banner-error').removeClass('hidden');
                        } else if(msg.error == "0") {
                            if(!$('.modal-banner-error').hasClass('hidden')){
                                $('.modal-banner-error').addClass('hidden');
                            }
                            $('#modal_banner').modal('hide');
                            $("#modal_banner_name").val("");
                            $("#modal_banner_url_protocol").val("http");
                            $("#modal_banner_url_link").val("");
                            $("#modal_banner_status").val("off");
                            $("#modal_banner_file").val("");
                                
                            location.reload();
                        }
                    }
                });
            }
		});
    });

    function banner_new(){
        clear_modal_banner();
        $('#modal_banner').modal('show');
    }

    function banner_edit(banner_id){
        
        $.ajax({
            url: $("#modal_banner_form").attr('action'),
            type: $("#modal_banner_form").attr('method'),
            data: "modal_banner_mode=get&modal_banner_id=" + banner_id,
            dataType: 'json',
            success: function(msg){
                $("#modal_banner_mode").val("edit");
                $("#modal_banner_id").val(banner_id);
                $("#modal_title_banner").text("Редактировать баннер");
                $('.modal-banner-error').addClass('hidden');
                $("#modal_banner_name").val(msg.banner_name);
                $("#modal_banner_status").val(msg.banner_status);
                $("#modal_banner_url_protocol").val(msg.banner_url_protocol);
                $("#modal_banner_url_link").val(msg.banner_url_link);
                $("#modal_banner_note").addClass("alert alert-success");
                $("#modal_banner_note div").removeClass("hidden");
                $("#modal_banner_file").val("");
                $("#modal_banner_file_current").val(msg.banner_img);
                $("#modal_banner_submit").text("Сохранить");
                $('#modal_banner').modal('show');
            }
        });
    }

    function clear_modal_banner(){
        if($("#modal_banner_mode").val() == "edit"){
            $("#modal_title_banner").text("Новый баннер");
            $('.modal-banner-error').addClass('hidden');
            $("#modal_banner_name").val("");
            $("#modal_banner_status").val("off");
            $("#modal_banner_url_protocol").val("http");
            $("#modal_banner_url_link").val("");
            $("#modal_banner_note").removeClass("alert alert-success");
            $("#modal_banner_note div").addClass("hidden");
            $("#modal_banner_file").val("");
            $("#modal_banner_mode").val("new");
            $("#modal_banner_id").val("0");
            $("#modal_banner_submit").text("Добавить");
        } 
    }

    function modal_banner_delete(banner_id){
        $.ajax({
            url: $("#modal_banner_form").attr('action'),
            type: $("#modal_banner_form").attr('method'),
            data: "modal_banner_mode=get&modal_banner_id=" + banner_id,
            dataType: 'json',
            success: function(msg){
                $("#modal_delete_banner_name").text(msg.banner_name);
                $("#modal_delete_banner_submit").attr("onclick", "banner_delete(" + banner_id + ");");
                $('#modal_delete_banner').modal('show');
            }
        });
    }
    function banner_delete(banner_id){
        $.ajax({
            url: $("#modal_banner_form").attr('action'),
            type: $("#modal_banner_form").attr('method'),
            data: "modal_banner_mode=delete&modal_banner_id=" + banner_id,
            dataType: 'json',
            success: function(msg){
                if(msg.error == "0"){
                    $('#modal_delete_banner').modal('hide');
                    location.reload();
                }
            }
        });
    }
    function banner_position_change(banner_id, move){
        $.ajax({
            url: $("#modal_banner_form").attr('action'),
            type: $("#modal_banner_form").attr('method'),
            data: "button_banner_mode=position&banner_position=" + banner_id + "&banner_move=" + move,
            dataType: 'json',
            success: function(msg){
                if(msg.error == "0"){
                    location.reload();
                } else if(msg.error == "1"){
                    alert(msg.info);    
                }
            }
        });
    }