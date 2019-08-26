//REFERENCIANDO OS MODAIS
$(function() {
    // MODAL FILMES
    $("#btn_add_movie").click(function() {
        clearErrors();
        $("#form_movie")[0].reset();
        $("#movie_img_path").attr("src", "");
        $("#modal_movie").modal();
    });

    // MODAL MEMBROS
    $("#btn_add_member").click(function() {
        clearErrors();
        $("#form_member")[0].reset();
        $("#member_photo_path").attr("src", "");
        $("#modal_member").modal();
    });

    // MODAL USUÁRIO
    $("#btn_add_user").click(function() {
        clearErrors();
        $("#form_user")[0].reset();
        $("#modal_user").modal();
    });

    // CHAMANDO A FUNÇÃO
    $("#btn_upload_movie_img").change(function() {
        uploadImg($(this), $("#movie_img_path"), $("#movie_img"));
    });

    $("#btn_upload_member_photo").change(function() {
        uploadImg($(this), $("#member_photo_path"), $("#member_photo"));
    });

    // FUNÇÃO PARA SUBMETER OS DADOS VIA AJAX
    $("#form_movie").submit(function() {
        // AJAX PARA SALVAR DADOS
         $.ajax({
            type: "post",
            url: BASE_URL + "restrict/ajax_save_movie",
            dataType: "json",
            data: $(this).serialize(),
            beforeSend: function() {
                clearErrors();
                $("#btn_save_movie").siblings(".help-block").html(loadingImg("Verificando..."));
            },
            success: function(response) {
                clearErrors();
                if(response["status"]){
                    $("#modal_movie").modal("hide");
                } else {
                    showErrorsModal(response['error_list']);
                }
            },
            erro: function(response) {
                console.log(response);
            }
        });

        return false;

    })

    // FUNÇÃO PARA SUBMETER OS DADOS VIA AJAX
    $("#form_member").submit(function() {
        // AJAX PARA SALVAR DADOS
         $.ajax({
            type: "post",
            url: BASE_URL + "restrict/ajax_save_member",
            dataType: "json",
            data: $(this).serialize(),
            beforeSend: function() {
                clearErrors();
                $("#btn_save_member").siblings(".help-block").html(loadingImg("Verificando..."));
            },
            success: function(response) {
                clearErrors();
                if(response["status"]){
                    $("#modal_member").modal("hide");
                } else {
                    showErrorsModal(response['error_list']);
                }
            },
            erro: function(response) {
                console.log(response);
            }
        });

        return false;

    });

    // FUNÇÃO PARA SUBMETER OS DADOS VIA AJAX
    $("#form_user").submit(function() {
        // AJAX PARA SALVAR DADOS
         $.ajax({
            type: "post",
            url: BASE_URL + "restrict/ajax_save_user",
            dataType: "json",
            data: $(this).serialize(),
            beforeSend: function() {
                clearErrors();
                $("#btn_save_user").siblings(".help-block").html(loadingImg("Verificando..."));
            },
            success: function(response) {
                clearErrors();
                if(response["status"]){
                    $("#modal_user").modal("hide");
                } else {
                    showErrorsModal(response['error_list']);
                }
            },
            erro: function(response) {
                console.log(response);
            }
        });

        return false;

    });

    // FUNÇÃO PARA SUBMETER OS DADOS VIA AJAX
    $("#btn_your_user").click(function() {
        // AJAX PARA SALVAR DADOS
         $.ajax({
            type: "post",
            url: BASE_URL + "restrict/ajax_get_user_data",
            dataType: "json",
            data: {"user_id": $(this).attr("user_id")},
            success: function(response) {
                clearErrors();
                $("#form_user")[0].reset();
                $.each(response["input"], function(id, value) {
                    $("#"+id).val(value);
                });
                $("#modal_user").modal();

            },
            erro: function(response) {
                console.log(response);
            }
        });

        return false;

    });
})