
    // QUANDO O ARQUIVO FOR SUBMETIDO
    $(function() {
        // QUANDO O BOTÃO SUBMIT FOR SUBMETIDO
        $("#login_form").submit(function() {
            
            // AJAX
            $.ajax({
                type: "post",
                url: BASE_URL + "restrict/ajax_login",
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function() {
                    clearErrors();
                    $("#btn_login").parent().siblings(".help-block").html(loadingImg("Verificando..."));
                },
                success: function(json) {
                    if(json["status"] == 1){
                        clearErrors();
                        $("#btn_login").parent().siblings(".help-block").html(loadingImg("Logando..."));
                        //console.log("Foi ");
                        window.location = BASE_URL + "restrict";
                    } else {
                        showErrors(json['error_list']);
                    }
                },
                erro: function(response) {
                    console.log(response);
                }
            })

            return false;

        })
    })