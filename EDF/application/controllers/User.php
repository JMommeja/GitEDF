<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	//
    // Fonction renvoyant sur le formulaire de connection
    //
	public function index()
	{
		$data['title'] = 'Connexion des utilisateurs | Électricité de France';
		$this->load->view('login', $data);
	}

	//
    // Fonction permettant à un utilisateur de se connecter
    //
	public function login()
	{

		//
    	// Vérifie que les champs obligatoires soient bien rempli
		//
		$this->form_validation->set_rules('login', 'Login', 'required', array('required' => 'Veuillez rentrer un login ! '));
		$this->form_validation->set_rules('password', 'Mot de Passe', 'required', array('required' => 'Veuillez rentrer un mot de passe ! '));

		if($this->form_validation->run() === FALSE){

			$data['title'] = 'Connexion des utilisateurs | Électricité de France';
			$this->load->view('login', $data);
		}
		else{
			$connexion = "FALSE";

			$login = $this->input->post('login');
			$password = $this->input->post('password');

			$users = $this->User_model->getUsers();

			foreach($users as $u){

				$decryptNom = $this->encryption->decrypt($u['nomUser']);
				$decryptPrenom = $this->encryption->decrypt($u['prenomUser']);
				$decryptMatricule = $this->encryption->decrypt($u['matricule']);
				$fonction = $u['libelleFonction'];
				$statut = $u['libelleStatut'];

				//
				// Vérifie que le matricule et le password soient correct
				//
				if(htmlentities($decryptMatricule) == $login){
					if(password_verify($password, htmlentities($u['password']))){

						//
						// Création d'une variable session
						//
						$utilisateur_data = array(
							'idUser' => htmlentities($u['idUser']),
							'fonction' => htmlentities($fonction),
							'statut' => htmlentities($statut),
							'nom' => htmlentities($decryptNom),
							'prenom' => htmlentities($decryptPrenom),
							'connecte' => true
						);
	
						$this->session->set_userdata($utilisateur_data);

						$connexion = "TRUE";
						
						$data['messages'] =  $this->Message_model->getMessages();
						$data['regions'] =  $this->Region_model->getRegions();
						$data['title'] = 'Accueil des utilisateurs | Électricité de France';
						$this->load->view('accueil', $data);
					}
				}
			}

			if($connexion == "FALSE"){
					
				$data['erreurConnexion'] = 'Votre login ou votre Mot de Passe est incorrect.';
				$data['title'] = 'Connexion des utilisateurs | Électricité de France';
				$this->load->view('login', $data);
			}
		}
	}

	public function logout(){
		if(!$this->session->userdata('connecte')){
			redirect('port/espace_admin');
		}

		$this->session->unset_userdata('idUser');
		$this->session->unset_userdata('fonction');
		$this->session->unset_userdata('statut');
		$this->session->unset_userdata('nom');
		$this->session->unset_userdata('prenom');
		$this->session->unset_userdata('connecte');

		$data['title'] = 'Connexion des utilisateurs | Électricité de France';
		$this->load->view('login', $data);
	}

	public function home(){
		if(!$this->session->userdata('connecte')){
			redirect('user');
		}

		$data['messages'] =  $this->Message_model->getMessages();
		$data['regions'] =  $this->Region_model->getRegions();
		$data['title'] = 'Accueil des utilisateurs | Électricité de France';
		$this->load->view('accueil', $data);
	}

	public function addUser(){
		if(!$this->session->userdata('connecte')){
			redirect('user');
		}

		$data['statut'] = $this->User_model->getStatut();
		$data['fonction'] = $this->User_model->getFonctions();
		$data['title'] = 'Ajouter des utilisateurs | Électricité de France';
		$this->load->view('newUser', $data);
	}

	public function newUser(){
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
		$nomUser = mb_strtoupper($this->input->post('nom'));
		if(empty($nomUser)){
			$data['errorNomUser'] = "Le champ Nom de l'utilisateur est obligatoire.";
		}
		else{
			if(mb_strlen($nomUser) < 225){
				$validation ++;
			}
			else{
				$data['errorNomUser'] = "Le nom n'est pas valide, car le champ rempli contient trop de caractères (225 max).";
			}
		}

		$prenomUser = ucfirst(mb_strtolower($this->input->post('prenom')));
		if(empty($prenomUser)){
			$data['errorPrenomUser'] = "Le champ Prénom de l'utilisateur est obligatoire.";
		}
		else{
			if(mb_strlen($prenomUser) < 225){
				$validation ++;
			}
			else{
				$data['errorPrenomUser'] = "Le prénom n'est pas valide, car le champ rempli contient trop de caractères (225 max).";
			}
		}

		$matriculeUser = $this->input->post('matricule');
		if(empty($matriculeUser)){
			$data['errorMatriculeUser'] = "Le champ Matricule de l'utilisateur est obligatoire.";
		}
		else{
			if(mb_strlen($prenomUser) == 6){
				$validation ++;
			}
			else{
				$data['errorMatriculeUser'] = "Le matricule n'est pas valide, car le champ rempli doit contenir 6 caractères.";
			}
		}

		$sameMatricule = 0;
		$users = $this->User_model->getUsers();
		foreach($users as $u){
			$decryptMatricule = $this->encryption->decrypt($u['matricule']);
			if(htmlentities($decryptMatricule) == $matriculeUser){
				$sameMatricule ++;
			}
		}
		if($sameMatricule == 0){
			$validation ++;
		}
		else{
			$data['errorSameMatricule'] = "Le matricule n'est pas valide, car il est déjà utilisé par un autre utilisateur.";
		}

		$password = $this->input->post('password');
		if(empty($password)){
			$data['errorPassword'] = "Le champ Mot de passe de l'utilisateur est obligatoire.";
		}
		else{
			if(mb_strlen($password) < 225){
				$validation ++;
			}
			else{
				$data['errorPassword'] = "Le mot de passe n'est pas valide, car le champ rempli contient trop de caractères (225 max).";
			}
		}

		$confpassword = $this->input->post('confpassword');
		if(empty($confpassword)){
			$data['errorConfPassword'] = "Le champ Confirmation du Mot de passe de l'utilisateur est obligatoire.";
		}
		else{
			if(mb_strlen($confpassword) < 225){
				$validation ++;
			}
			else{
				$data['errorConfPassword'] = "La confirmation du mot de passe n'est pas valide, car le champ rempli contient trop de caractères (225 max).";
			}
		}

		if($password == $confpassword){
			$validation ++;
		}
		else{
			$data['errorSamePassword'] = "Le mot de passe et la confirmation du mot de passe doivent être identique.";
		}

		$fonction = $this->input->post('fonction');
		
		$statut = $this->input->post('statut');

		//
		//Vérification que l'utilisateur a bien rentré les données nécessaires
		//
		$this->form_validation->set_rules('nom', 'Le Nom de l\'utilisateur', 'required');
		$this->form_validation->set_rules('prenom', 'Le Prenom de l\'utilisateur', 'required');
		$this->form_validation->set_rules('matricule', 'Le Matricule de l\'utilisateur', 'required');
		$this->form_validation->set_rules('password', 'Le Mot de passe de l\'utilisateur', 'required');
		$this->form_validation->set_rules('confpassword', 'La Confirmation du Mot de passe de l\'utilisateur', 'required');
		$this->form_validation->set_rules('fonction', 'La Fonction de l\'utilisateur', 'required');
		$this->form_validation->set_rules('statut', 'Le Statut de l\'utilisateur', 'required');

		if($validation == 7){

			//
			//Si les données nécessaires ne sont pas renseignées
			//
			if($this->form_validation->run() === FALSE){

				$data['title'] = 'Ajouter des utilisateurs | Électricité de France';
				$this->load->view('login', $data);
			}
			else{

				$nom = $this->encryption->encrypt($nomUser);
				$prenom = $this->encryption->encrypt($prenomUser);
				$matricule = $this->encryption->encrypt($matriculeUser);

				$passwword_hash = password_hash($password, PASSWORD_DEFAULT);
	
				$this->User_model->registration($nom, $prenom, $matricule, $passwword_hash, $fonction, $statut);
			
				$data['title'] = 'Ajouter des utilisateurs | Électricité de France';
				$this->load->view('login', $data);
			}
		}
		else{
			$data['title'] = 'Ajouter des utilisateurs | Électricité de France';
			$this->load->view('login', $data);
		}	
	
	}
}
