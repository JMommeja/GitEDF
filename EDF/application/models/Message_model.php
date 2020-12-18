<?php

class Message_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    //
    // Fonction récupérant tous les messages en cours
    //
    public function getMessages_ajax(){
        $this->db->select('*');
        $this->db->from('demande');
        $this->db->where('validation', "En cours");
        $this->db->join('region', 'region.idRegion = demande.regionCible');
        $this->db->join('user', 'user.idUser = demande.userDemandant');
        $this->db->join('fonction', 'fonction.idFonction = user.idFonction');

        $query = $this->db->get();
        
        $output = '<table class="table">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th width="147">Date</th>';
        $output .= '<th width="82">Numéro message émis</th>';
        $output .= '<th width="128">Nom</th>';
        $output .= '<th width="83">Fonction</th>';
        $output .= '<th width="711">Message</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';

        foreach($query->result() as $row){
            $output .= '<tr>';

            date_default_timezone_set('Europe/Paris');

            $date = strtotime($row->dateD);
            $date = date("d/m/Y", $date);

            $output .= '<td>'.$date.' <br> '.$row->heureD.'</td>';
            $output .= '<td>'.$row->idDemande.'</td>';

            $decryptNom = $this->encryption->decrypt($row->nomUser);
            $decryptPrenom = $this->encryption->decrypt($row->prenomUser);
            $output .= '<td>'.$decryptNom.' <br> '.$decryptPrenom.'</td>';
            $output .= '<td>'.$row->libelleFonction.'</td>';
            $output .= '<td><a href="#popup'.$row->idDemande.'">'.$row->messageD.'</a></td>';
            $output .= '</tr>';
        }

        $output .= '</tbody>';
        $output .= '</table>';

        foreach($query->result() as $row){
            $output .= '<div id="popup'.$row->idDemande.'" class="overlay">';
            $output .= '<div class="popup">';
            $output .= '<i class="fas fa-pencil-alt"></i>';
            $output .= '<h2> Répondre </h2>';

            $output .= '<a class="close" href="'.base_url().'user/home">&times;</a>';
            $output .= ''.form_open('message/addReponse').'';
            $output .= '<div class="content">';
            $output .= '<label for="commentaire">Commentaire</label>';
            $output .= '<br>';
            $output .= '<textarea name="commentaire" id="commentaire" cols="30" rows="10" required></textarea>';
            $output .= '<br>';
            $output .= '<label for="validation">Validation</label>';
            $output .= '<br>';
            $output .= '<select name="validation" id="validation">';
            $output .= '<option value="" selected disabled> Sélectionner la validation </option>';
            $output .= '<option value="Valider"> Valider </option>';
            $output .= '<option value="Refuser"> Refuser </option>';
            $output .= '</select>';
            $output .= '</div>';
            $output .= '<input type="text" name="idDemande" value="'.$row->idDemande.'" hidden>';
            $output .= '<input type="text" name="idUser" value="'.$row->idUser.'" hidden>';
            $output .= '<input type="submit" name="envoyer" value="Envoyer">';
            $output .= '</form>';
            $output .= '<a class="" href="'.base_url().'user/home">';
            $output .= '<input class="button__in" type="button" name="message_fermer" value="Fermer">';
            $output .= '</a>';
            $output .= '</div>';
            $output .= '</div>';
        }

        return $output;
    }

    //
    // Fonction récupérant tous les messages acceptés ou refusés
    //
    public function getReponse_ajax(){
        $this->db->select('*');
        $this->db->from('demande');
        $this->db->where('validation', "Valider");
        $this->db->or_where('validation', "Refuser");
        $this->db->join('region', 'region.idRegion = demande.regionCible');
        $this->db->join('user', 'user.idUser = demande.userDemandant');
        $this->db->join('fonction', 'fonction.idFonction = user.idFonction');

        $query = $this->db->get();
        
        $output = '<table class="table">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th width="147">Date</th>';
        $output .= '<th width="82">Numéro message émis</th>';
        $output .= '<th width="128">Nom</th>';
        $output .= '<th width="83">Fonction</th>';
        $output .= '<th width="711">Message</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';

        foreach($query->result() as $row){
            if($row->validation == "Valider"){
                $output .= '<tr class="valider">';
            }
            else{
                $output .= '<tr class="refuser">';
            }
            

            date_default_timezone_set('Europe/Paris');

            $date = strtotime($row->dateD);
            $date = date("d/m/Y", $date);

            $output .= '<td>'.$date.' <br> '.$row->heureD.'</td>';
            $output .= '<td>'.$row->idDemande.'</td>';

            $decryptNom = $this->encryption->decrypt($row->nomUser);
            $decryptPrenom = $this->encryption->decrypt($row->prenomUser);
            $output .= '<td>'.$decryptNom.' <br> '.$decryptPrenom.'</td>';
            $output .= '<td>'.$row->libelleFonction.'</td>';
            $output .= '<td>'.$row->messageD.'</td>';
            $output .= '</tr>';
        }

        $output .= '</tbody>';
        $output .= '</table>';

        return $output;
    }

    //
    // Fonction récupérant tous les messages
    //
    public function getMessages(){
        $this->db->select('*');
        $this->db->from('demande');
        $this->db->where('validation', "En cours");
        $this->db->join('region', 'region.idRegion = demande.regionCible');
        $this->db->join('user', 'user.idUser = demande.userDemandant');
        $this->db->join('fonction', 'fonction.idFonction = user.idFonction');

        $query = $this->db->get();
        return $query->result_array();
    }

    //
    // Fonction enregistrant un nouveau message
    //
    public function registration($message, $date, $heure, $etat, $idUser, $region){
        $data = array(
            'messageD' => $message,
            'dateD' => $date,
            'heureD' => $heure,
            'validation' => $etat,
            'userDemandant' => $idUser,
            'regionCible' => $region
        );
    
        $this->db->insert('demande', $data);
    }

    //
    // Fonction enregistrant une réponse
    //
    public function registrationReponse($commentaire, $date, $heure, $idUserDemande, $idUser, $idDemande){
        $data = array(
            'messageR' => $commentaire,
            'dateR' => $date,
            'heureR' => $heure,
            'userDemandant' => $idUserDemande,
            'userRepondant' => $idUser,
            'messageDemande' => $idDemande
        );
    
        $this->db->insert('reponse', $data);
    }

    //
    // Fonction modifiant l'état d'une demande
    //
    public function modify($idDemande, $etat){
        $data = array(
            'validation' => $etat
        );
    
        $this->db->where('idDemande', $idDemande);
        $this->db->update('demande', $data);
    }
       
}

   
?>