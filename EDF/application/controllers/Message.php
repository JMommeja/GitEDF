<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

	//
    // Fonction renvoyant les messages
    //
	public function index()
	{
		echo $this->Message_model->getMessages_ajax();
    }
    
    //
    // Fonction renvoyant les messages avec des réponse positive ou négative
    //
	public function reponse()
	{
        if(!$this->session->userdata('connecte')){
			redirect('user');
		}

		$data['title'] = 'Accueil des utilisateurs | Électricité de France';
        $this->load->view('reponse', $data);
        
    }
    
    //
    // Fonction renvoyant les messages avec des réponse positive ou négative ajax
    //
    public function getReponse(){
        echo $this->Message_model->getReponse_ajax();
    }

    //
    // Fonction permettant de créer un nouveau message
    //
    public function add(){
		if(!$this->session->userdata('connecte')){
			redirect('user');
		}

		//
		//Initialise une variable à 0 afin de vérifier chacune des variables passé en méthode post pour savoir si les champs de saisi sont correctement rempli
		//
		$validation = 0;

		//
		//Récupération des variables passé en méthode post
		//
		$message = $this->input->post('message');
		if(empty($message)){
			$data['errorMessage'] = "Le champ Message est obligatoire.";
		}
		else{		
			$validation ++;	
		}

		$region = $this->input->post('region');
		if(empty($region)){
			$data['errorRegion'] = "La région doit être sélectionnée.";
		}
		else{
			$validation ++;
        }
        
        $date = date('Y-m-d');

        $heure = date('H:i:s');

        $etat = "En Cours";

        $idUser = $this->session->userdata('idUser');

		//
		//Vérification que l'utilisateur a bien rentré les données nécessaires
		//
		$this->form_validation->set_rules('message', 'Le Message', 'required');
		$this->form_validation->set_rules('region', 'La Région', 'required');

		if($validation == 2){

			//
			//Si les données nécessaires ne sont pas renseignées
			//
			if($this->form_validation->run() === FALSE){

				$data['title'] = 'Accueil des utilisateurs | Électricité de France';
				$this->load->view('accueil', $data);
			}
			else{
	
				$this->Message_model->registration($message, $date, $heure, $etat, $idUser, $region);
			
				$data['title'] = 'Accueil des utilisateurs | Électricité de France';
				$this->load->view('accueil', $data);
			}
		}
		else{
			$data['title'] = 'Accueil des utilisateurs | Électricité de France';
			$this->load->view('accueil', $data);
		}	
	
    }
    
    //
    // Fonction permettant de créer une nouvelle réponse
    //
    public function addReponse(){
		if(!$this->session->userdata('connecte')){
			redirect('user');
		}

		//
		//Initialise une variable à 0 afin de vérifier chacune des variables passé en méthode post pour savoir si les champs de saisi sont correctement rempli
		//
		$validation = 0;

		//
		//Récupération des variables passé en méthode post
        //
        $idDemande = $this->input->post('idDemande');
        $idUserDemande = $this->input->post('idUser');

		$commentaire = $this->input->post('commentaire');

		$etat = $this->input->post('validation');
		if(empty($etat)){
			$data['errorEtat'] = "La validation doit être sélectionnée.";
		}
		else{
			$validation ++;
        }
        
        $date = date('Y-m-d');

        $heure = date('H:i:s');

        $idUser = $this->session->userdata('idUser');

		//
		//Vérification que l'utilisateur a bien rentré les données nécessaires
		//
		$this->form_validation->set_rules('validation', 'La validation', 'required');

		if($validation == 1){

			//
			//Si les données nécessaires ne sont pas renseignées
			//
			if($this->form_validation->run() === FALSE){

				$data['title'] = 'Accueil des utilisateurs | Électricité de France';
				$this->load->view('accueil', $data);
			}
			else{
	
                $this->Message_model->registrationReponse($commentaire, $date, $heure, $idUserDemande, $idUser, $idDemande);
                
                $this->Message_model->modify($idDemande, $etat);
			
				$data['title'] = 'Accueil des utilisateurs | Électricité de France';
				$this->load->view('accueil', $data);
			}
		}
		else{
			$data['title'] = 'Accueil des utilisateurs | Électricité de France';
			$this->load->view('accueil', $data);
		}	
	
	}

}
