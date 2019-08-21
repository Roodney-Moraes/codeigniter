<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersModel extends CI_Model {

	public function __construct(){

        // REFERENCIANDO O CONSTRUCT DO USERSMODEL
        parent::__construct(); 
        $this->load->database();
    
    }
    
    public function get_user_data($user_login){

        //  CRIANDO UMA QUERY PARA BUSCAR AS INFORMAÇÕES NO BANCO
        $this->db 
            ->select("user_id, password_hash, user_full_name, user_email")
            ->from("users")
            ->where("user_login", $user_login);

            // ESSE COMANDO GET EXECUTA A QUERY NO BANCO
            $result = $this->db->get();

            // VERIFICANDO SE EXISTE ALGUMA INFORMAÇÃO NO BANCO DE DADOS COM A QUERY ACIMA
            if ($result->num_rows() > 0) {
                return $result->row();
            } else {
                return NULL;
            }
    }
}
