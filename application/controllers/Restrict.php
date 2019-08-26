<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller {

    public function __construct(){

        // REFERENCIANDO O CONSTRUCT PARA USO DA SESSÃO
        parent::__construct(); 
        $this->load->library("session");
    
    }

	public function index(){
         // VERIFICANDO SE EXISTE UMA SESSÃO NO SISTEMA
        if ($this->session->userdata("user_id")) {
            // CRIAR UM ARRAY PARA CARREGAR OS SCRIPTS
            $data = array(
                "styles" => array(
                    "dataTables.bootstrap.min.css",
                    "datatables.min.css"
                ),
                "scripts" => array(
                    "sweetalert2.js",
                    "dataTables.bootstrap.min.js",
                    "datatables.js",
                    "util.js",
                    "restrict.js"
                ),
                "user_id" => $this->session->userdata("user_id")
            );
            $this->template->show("restrict.php", $data);

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

    public function ajax_import_image() {

        // VERIFICANDO SE A REQUISIÇÃO ESTÁ VINDO VIA AJAX
        if (!$this->input->is_ajax_request()) {
            exit("Acesso Negado!");
        }

        // GRAVANDO UM ARQUIVO EM UMA PASTA TEMPORARIA
        $config["upload_path"] = "./tmp/";
        $config["allowed_types"] = "gif|png|jpg";
        $config["overwrite"] = TRUE;

        // REFERENCIANDO A BIBLIOTECA UPLOAD
        $this->load->library("upload", $config);

        // CRIANDO ALGUNS ARRAYS
        $json = array();
        $json["status"] = 1;
        

        // VERIFICANDO SE A IMAGEM CORRESPONDE AS CONFIGURAÇÕES
        if (!$this->upload->do_upload("image_file")) {
            $json["status"] = 0;
            $json["error"] = $this->upload->display_errors("","");
        } else {
            // CASO A IMAGEM FOI IMPORTADA
            if ($this->upload->data()["file_size"] <= 1024) {
                $file_name = $this->upload->data()["file_name"];
                $json["img_path"] = base_url() . "tmp/" . $file_name;
            } else {
                $json["status"] = 0;
                $json["error"] = "Arquivo não deve ser maior que 1MB!";
            }
        }

        echo json_encode($json);
    }

    public function ajax_save_movie() {


        // VERIFICANDO SE A REQUISIÇÃO ESTÁ VINDO VIA AJAX
        if (!$this->input->is_ajax_request()) {
            exit("Acesso Negado!");
        }

        // CRIANDO ALGUNS ARRAYS
        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        // CHAMANDO A MODEL
        $this->load->model("MoviesModel");
        $data = $this->input->post();

        // CRIANDO VALIDAÇÕES
        if (empty($data["movie_name"])) {
            $json["error_list"]["#movie_name"] = "Nome do filme é obrigatório!";
        } else {
            if ($this->MoviesModel->is_duplicated("movie_name", $data['movie_name'], $data['movie_id'])) {
                $json["error_list"]["#movie_name"] = "Nome do filme já cadastrado no banco!";
            }
        }


        // CONVERTENDO A DURAÇÃO PARA FLOAT
        $data["movie_duration"] = floatval($data["movie_duration"]);

        // CRIANDO VALIDAÇÕES
        if (empty($data["movie_duration"])) {
            $json["error_list"]["#movie_duration"] = "Duração do filme é obrigatório!";
        } else {
            if (!($data["movie_duration"] > 0 && $data["movie_duration"] < 100)) {
                $json["error_list"]["#movie_duration"] = "Duração do filme deve ser maior que 0 (h) e menor que 100 (h)!";
            }
        }

        // VERIFICANDO SE ESTÁ VAZIO OS ERROS
        if (!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {

            if (!empty($data["movie_img"])) {
                // CONFIGURANDO PATH DA IMAGEM
                $file_name = basename($data["movie_img"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/movies/" . $file_name;
                rename($old_path, $new_path);

                $data["movie_img"] = "/public/images/movies/" . $file_name;
            }

            // VERIFICANDO SE  IRA INSERIR NO BANCO OU ATUALIZAR
            if (empty($data["movie_id"])) {
                $this->MoviesModel->insert($data);
            } else {
                $movie_id = $data["movie_id"];
                unset($data["movie_id"]);
                $this->MoviesModel->update($movie_id, $data);
            }
        }

        echo json_encode($json);

    }

    public function ajax_save_member() {


        // VERIFICANDO SE A REQUISIÇÃO ESTÁ VINDO VIA AJAX
        if (!$this->input->is_ajax_request()) {
            exit("Acesso Negado!");
        }

        // CRIANDO ALGUNS ARRAYS
        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        // CHAMANDO A MODEL
        $this->load->model("TeamModel");
        $data = $this->input->post();

        // CRIANDO VALIDAÇÕES
        if (empty($data["member_name"])) {
            $json["error_list"]["#member_name"] = "Nome do membro é obrigatório!";
        }else {
            if ($this->TeamModel->is_duplicated("member_name", $data['member_name'], $data['member_id'])) {
                $json["error_list"]["#member_name"] = "Nome do membro já cadastrado no banco!";
            }
        }

        // VERIFICANDO SE ESTÁ VAZIO OS ERROS
        if (!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {

            if (!empty($data["member_photo"])) {
                // CONFIGURANDO PATH DA IMAGEM
                $file_name = basename($data["member_photo"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/team/" . $file_name;
                rename($old_path, $new_path);

                $data["member_photo"] = "/public/images/team/" . $file_name;
            }

            // VERIFICANDO SE  IRA INSERIR NO BANCO OU ATUALIZAR
            if (empty($data["member_id"])) {
                $this->TeamModel->insert($data);
            } else {
                $member_id = $data["member_id"];
                unset($data["member_id"]);
                $this->TeamModel->update($member_id, $data);
            }
        }

        echo json_encode($json);

    }

    public function ajax_save_user() {


        // VERIFICANDO SE A REQUISIÇÃO ESTÁ VINDO VIA AJAX
        if (!$this->input->is_ajax_request()) {
            exit("Acesso Negado!");
        }

        // CRIANDO ALGUNS ARRAYS
        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        // CHAMANDO A MODEL
        $this->load->model("UsersModel");
        $data = $this->input->post();

        // CRIANDO VALIDAÇÕES
        if (empty($data["user_login"])) {
            $json["error_list"]["#user_login"] = "Login é obrigatório!";
        } else {
            if ($this->UsersModel->is_duplicated("user_login", $data['user_login'], $data['user_id'])) {
                $json["error_list"]["#user_login"] = "Login já cadastrado no banco!";
            }
        }

        if (empty($data["user_full_name"])) {
            $json["error_list"]["#user_full_name"] = "Nome completo é obrigatório!";
        }

        // VALIDANDO E-MAIL
        if (empty($data["user_email"])) {
            $json["error_list"]["#user_email"] = "E-mail é obrigatório!";
        } else {
            if ($this->UsersModel->is_duplicated("user_email", $data['user_email'], $data['user_id'])) {
                $json["error_list"]["#user_email"] = "E-mail já cadastrado banco!";
            } else {
                if ($data["user_email"] != $data["user_email_confirm"]) {
                    $json["error_list"]["#user_email"] = "";
                    $json["error_list"]["#user_email_confirm"] = "E-mail não conferem!";
                }
            }
        }

          // VALIDANDO SENHA
        if (empty($data["user_password"])) {
            $json["error_list"]["#user_password"] = "Senha é obrigatório!";
        } else {
            if ($data["user_password"] != $data["user_password_confirm"]) {
                $json["error_list"]["#user_password"] = "";
                $json["error_list"]["#user_password_confirm"] = "Senhas não conferem!";
            }
        }
        


        // VERIFICANDO SE ESTÁ VAZIO OS ERROS
        if (!empty($json["error_list"])) {
            $json["status"] = 0;
        } else {

            // CRIANDO UM HASH PARA A SENHA
            $data['password_hash'] = password_hash($data['user_password'], PASSWORD_DEFAULT);

            // LIMPANDO OS DADOS ANTES DE DAR O INSERT
            unset($data['user_password']);
            unset($data['user_password_confirm']);
            unset($data['user_email_confirm']);


            // VERIFICANDO SE  IRA INSERIR NO BANCO OU ATUALIZAR
            if (empty($data["user_id"])) {
                $this->UsersModel->insert($data);
            } else {
                $user_id = $data["user_id"];
                unset($data["user_id"]);
                $this->UsersModel->update($user_id, $data);
            }
        }

        echo json_encode($json);

    }

    public function ajax_get_user_data() {


        // VERIFICANDO SE A REQUISIÇÃO ESTÁ VINDO VIA AJAX
        if (!$this->input->is_ajax_request()) {
            exit("Acesso Negado!");
        }

        // CRIANDO ALGUNS ARRAYS
        $json = array();
        $json["status"] = 1;
        $json["input"] = array();

        // CHAMANDO A MODEL
        $this->load->model("UsersModel");

        // CAPTURANDO OS DADOS
        $user_id = $this->input->post("user_id");
        $data = $this->UsersModel->get_data($user_id)->result_array()[0];
        

        // MONTANDO OS ARRAY COM AS INFORMAÇÕES DO BANCO
        $json["input"]["user_id"] = $data["user_id"];
        $json["input"]["user_login"] = $data["user_login"];
        $json["input"]["user_full_name"] = $data["user_full_name"];
        $json["input"]["user_email"] = $data["user_email"];
        $json["input"]["user_email_confirm"] = $data["user_email"];
        $json["input"]["user_password"] = $data["password_hash"];
        $json["input"]["user_password_confirm"] = $data["password_hash"];

        echo json_encode($json);
        

    }

    

}
