<!DOCTYPE html>
<html lang="fr">
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/edf.png" />

    </head>

    <body>

        <header class="menu">
            <div class="left_menu">
                <a href="<?php echo base_url(); ?>user/home">
                    <img src="<?php echo base_url(); ?>assets/images/edf.png" alt="Logo EDF">
                </a>
            </div>
            <div class="right_menu">
                <a href="<?php echo base_url(); ?>user/home">
                    <h3> Accueil </h3>
                </a>
                <a href="<?php echo base_url(); ?>message/reponse">
                    <h3> Réponse </h3>
                </a>

                <?php
                    if($this->session->userdata('statut') == "Administrateur"){
                ?>

                <a href="<?php echo base_url(); ?>user/addUser">
                    <h3> Ajouter un utilisateur </h3>
                </a>

                <?php
                    }
                ?>

                <a href="<?php echo base_url(); ?>user/logout">
                    <h3> Déconnexion </h3>
                </a>
            </div>
        </header>
        
        <div class="align">
            <div class="grid align__item">
                <div class="register">
                    <div class = "logo">
                        <img src="<?php echo base_url(); ?>assets/images/edf.png" alt="logo EDF" width="100%" height="100%" ></img>
                    </div>

                    <defs>
                        <linearGradient id="a" x1="0%" y1="0%" y2="0%"><stop offset="0%" stop-color="#8ceabb"/><stop offset="100%" stop-color="#378f7b"/></linearGradient>
                    </defs>
                    <path fill="url(#a)" d="M215 214.9c-83.6 123.5-137.3 200.8-137.3 275.9 0 75.2 61.4 136.1 137.3 136.1s137.3-60.9 137.3-136.1c0-75.1-53.7-152.4-137.3-275.9z"/></svg>
            
                    <h2 style="font-size: 120%; margin-bottom: 10%;">Inscription </h2>

                    <?php
                        echo validation_errors();

                        echo form_open('user/newUser');
                    ?>
                    
                    <div class="form__field">
                        <input name="nom" type="text" placeholder="Nom">
                    </div>

                    <div class="form__field">
                        <input name="prenom" type="text" placeholder="Prenom">
                    </div>

                    <div class="form__field">
                        <input name="matricule" type="text" placeholder="Matricule">
                    </div>

                    <div class="form__field">
                        <input name="password" type="password" placeholder="••••••••••••">
                    </div>

                    <div class="form__field">
                        <input name="confpassword" type="password" placeholder="••••••••••••">
                    </div>
  
                    <div class="row">
                        <div class="custom-select">
                            <select class ="box">
                                <option value="" selected disabled>Choisir une fonction</option>
                                <?php
                                    foreach($fonction as $f) {
                                        echo '<option value="'.htmlentities($f['idFonction']).'">'.htmlentities($f['libelleFonction']).' </option>'; 
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
                    
                    <br>

                    <div class="row">
                        <div class="custom-select">
                            <select class="box">
                                <option value="" selected disabled>Choisir un statut</option>
                                <?php 
                                    foreach($statut as $s) {
                                        echo '<option value="'.htmlentities($s['idStatut']).'">'.htmlentities($s['libelleStatut']).' </option>'; 
                                    }
                                ?>

                            </select>
                        </div>
                    </div>
                            <br>
                    <div class="form__field">
                        <input type="submit" value="Ajouter">
                    </div>

                    </form>

                </div>
            </div>
        </div>
    </body>
</html>