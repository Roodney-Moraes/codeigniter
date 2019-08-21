
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

// CRIANDO UM LOAD PARA CARREGAR UMA IMAGEM
function loadingImg(message="") {
    return "<i class='fa fa-circle-o-notch fa-spin'></i>&nbsp;" + message
}