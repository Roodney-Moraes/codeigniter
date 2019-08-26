<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MoviesModel extends CI_Model {

	public function __construct(){

        // REFERENCIANDO O CONSTRUCT DO MOVIESMODEL
        parent::__construct(); 
        $this->load->database();
    
    }

    public function get_data($id, $select = NULL) {
        // VERIFICANDO SE ESTÁ VAZIO
        if (!empty($select)) {
            $this->db->select($select);
        }
        $this->db->from("movies");
        $this->db->where("movie_id", $id);

        return $this->db->get();

    }

    public function insert($data) {
    
        $this->db->insert("movies", $data);

    }

    public function update($id, $data) {
        
        $this->db->where("movie_id", $id);
        $this->db->update("movies", $data);

    }

    public function delete($id) {
       
        $this->db->where("movie_id", $id);
        $this->db->delete("movies");

    }

    public function is_duplicated($field, $value, $id = NULL) {
        // FAZENDO UM SELECT DIFERENTE DO MEU ID
        if(!empty($id)) {
            $this->db->where("movie_id <>", $id);
        }
        $this->db->from("movies");
        $this->db->where($field, $value);

        return $this->db->get()->num_rows() > 0;
    }
    
}
