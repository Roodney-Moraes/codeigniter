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

    public function get_data($id, $select = NULL) {
        // VERIFICANDO SE ESTÁ VAZIO
        if (!empty($select)) {
            $this->db->select($select);
        }
        $this->db->from("users");
        $this->db->where("user_id", $id);

        return $this->db->get();

    }

    public function insert($data) {
    
        $this->db->insert("users", $data);

    }

    public function update($id, $data) {
        
        $this->db->where("user_id", $id);
        $this->db->update("users", $data);

    }

    public function delete($id) {
       
        $this->db->where("user_id", $id);
        $this->db->delete("users");
  
    }

    public function is_duplicated($field, $value, $id = NULL) {
        // FAZENDO UM SELECT DIFERENTE DO MEU ID
        if(!empty($id)) {
            $this->db->where("user_id <>", $id);
        }
        $this->db->from("users");
        $this->db->where($field, $value);

        return $this->db->get()->num_rows() > 0;
    }
    
}
