
// CRIANDO CONSTANTE
const BASE_URL = "http://127.0.0.1/CRUD_Codelgniter/";

// FUNÇÃO PARA LIMPAR ERROS
function clearErrors() {
    $(".has-error").removeClass("has-error");
    $(".help-block").html("");
}

// FUNÇÃO PARA EXIBIR ERROS
function showErrors(error_list) {
    clearErrors();

    $.each(error_list, function(id, message) {
        $(id).parent().parent().addClass("has-error");
        $(id).parent().siblings(".help-block").html(message);

    })

}

// FUNÇÃO PARA EXIBIR ERROS MODAL
function showErrorsModal(error_list) {
    clearErrors();

    $.each(error_list, function(id, message) {
        $(id).parent().parent().addClass("has-error");
        $(id).siblings(".help-block").html(message);

    })

}

// CRIANDO UM LOAD PARA CARREGAR UMA IMAGEM
function loadingImg(message="") {
    return "<i class='fa fa-circle-o-notch fa-spin'></i>&nbsp;" + message
}


// CRIANDO UMA AJAX PARA TRATAR O UPLOAD DE IMAGEM
function uploadImg(input_file, img, input_path) {

    // DADOS PADROES
    src_before = img.attr("src");
    img_file = input_file[0].files[0];
    form_data = new FormData();

    form_data.append("image_file", img_file);

    $.ajax({
        url: BASE_URL + "restrict/ajax_import_image",
        dataType: "json",
        // VALORES PADRAO QUANDO É FEITA UPLOUD DE IMAGEM
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: "POST",
        beforeSend: function(){
            clearErrors();
            input_path.siblings(".help-block").html(loadingImg("Carregando imagem..."));
        },
        success: function(response){
            clearErrors();
            if (response["status"]) {
                img.attr("src", response["img_path"]);
                input_path.val(response["img_path"]);
            }else {
                img.attr("src", src_before);
                input_path.siblings(".help-block").html(response["error"]);
            }
        },
        error: function() {
            img.attr("src", src_before);
        }

    });
}