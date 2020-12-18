<?php

class User_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    //
    // Fonction récupérant tous les utilisateurs
    //
    public function getUsers(){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('fonction', 'fonction.idFonction = user.idFonction');
        $this->db->join('statut', 'statut.idStatut = user.idStatut');

        $query = $this->db->get();
        return $query->result_array();
    }

    //
    // Fonction récupérant toutes les fonctions
    //
    public function getFonctions(){
        $this->db->select('*');
        $this->db->from('fonction');

        $query = $this->db->get();
        return $query->result_array();
    }

    //
    // Fonction récupérant tous les status
    //
    public function getStatut(){
        $this->db->select('*');
        $this->db->from('statut');

        $query = $this->db->get();
        return $query->result_array();
    }

    //
    // Fonction enregistrant un nouvel utilisateur
    //
    public function registration($nom, $prenom, $matricule, $passwword_hash, $fonction, $statut){
        $data = array(
            'nomUser' => $nom,
            'prenomUser' => $prenom,
            'matricule' => $matricule,
            'password' => $passwword_hash,
            'idFonction' => $fonction,
            'idStatut' => $statut
        );
    
        $this->db->insert('user', $data);
    }
       
}

   
?>