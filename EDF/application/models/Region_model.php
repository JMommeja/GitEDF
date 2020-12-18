<?php

class Region_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    //
    // Fonction récupérant tous les utilisateurs
    //
    public function getRegions(){
        $this->db->select('*');
        $this->db->from('region');

        $query = $this->db->get();
        return $query->result_array();
    }
       
}

   
?>