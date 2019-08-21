<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller {

    public function __construct(){

        // REFERENCIANDO O CONSTRUCT PARA USO DA SESSÃO
        parent::__construct(); 
        $this->load->library("session");
    
    }

	public function index()
	{
         // VERIFICANDO SE EXISTE UMA SESSÃO NO SISTEMA
        if ($this->session->userdata("user_id")) {
            $this->template->show("restrict.php");
        }else{
            // CRIAR UM ARRAY PARA CARREGAR OS SCRIPTS
            $data = array(
                "scripts" => array(
                    "util.js",
                    "login.js"
                )
            );

            $this->template->show('login.php', $data);
        } 

        // CHAMANDO UMA MODEL
        //$this->load->model("UsersModel");
        //$this->UsersModel->get_user_data('root');
        
        // GERANDO UM HASH PARA A SENHA
        //echo password_hash("root", PASSWORD_DEFAULT);
        
    }

    public function logout() {
        // DESTRUINDO A SESSÃO
        $this->session->sess_destroy();
        header("Location: ".base_url()."restrict");
    }
    
    public function ajax_login() {

        // VERIFICANDO SE A REQUISIÇÃO ESTÁ VINDO VIA AJAX
        if (!$this->input->is_ajax_request()) {
            exit("Acesso Negado!");
        }

        // CRIANDO ALGUNS ARRAYS
        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        // CAPTURANDO OS DADOS DO FORMULÁRIO E COLOCANDO NAS VARIAVEIS
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        // VERIFICANDO SE FOI DIGITADO O NOME
        if (empty($username)) {   
            // RETORNANDO UM JSON QUANDO OS DADOS ESTIVEREM VAZIO
            $json['status'] = 0;
            $json["error_list"]["#username"] = "Usuário não pode ser vazio!";

        }else {
            // CHAMANDO UMA MODEL
            $this->load->model("UsersModel");
            $result = $this->UsersModel->get_user_data($username);

            if ($result) {
                //SE EXISTE ALGUM REGISTRO ELE IRÁ ATRIBUIR ESSES DADOS PARA AS VARIAVEIS A SEGUIR
                $user_id = $result->user_id;
                $password_hash = $result->password_hash;

                if (password_verify($password, $password_hash)) {
                    // CRIANDO UMA SESSAO CASO A SENHA ESTEJA CERTO
                    $this->session->set_userdata("user_id", $user_id);

                } else {
                    // RETORNANDO UM JSON QUANDO OS DADOS ESTIVEREM VAZIO
                    $json['status'] = 0;
                }

            } else {
                // RETORNANDO UM JSON QUANDO OS DADOS ESTIVEREM VAZIO
                $json['status'] = 0;
            }
            
            if ($json['status'] == 0) {
                // RETORNANDO UM JSON QUANDO OS DADOS ESTIVEREM VAZIO
                $json['error_list']['#btn_login'] = "Usuário e /ou senha incorretos!"; 
            }

        }

        // COLOCANDO OS DADOS NO JSON PARA SER LIDOS PELO JAVASCRIPT
        echo json_encode($json);


    }
}
