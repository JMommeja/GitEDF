
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title ?></title>
        <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" type="text/css">

        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/edf.png" />

        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    </head>

    <script>
        $(document).ready(function(){
            $.ajax({
                url:"<?php echo base_url(); ?>message",
                method:"POST",
                data:{},
                success:function(data){
                    $('.container_table').html(data);
                }
            });

            setInterval(function(){
                    $.ajax({
                        url:"<?php echo base_url(); ?>message",
                        method:"POST",
                        data:{},
                        success:function(data){
                            $('.container_table').html(data);
                        }
                    });
            },30000); // ici toutes les 3 secondes (remettre 3000)
        });
    </script>

    <body>
        <div class="container"> 
            <p>
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
            </p>

            <!--
                Div contenant la requête ajax afin d'actualiser le tableau de message toute les 3 secondes
                        -->
            <div class="container_table">

            </div>

            <div class="new_message">
                <a href="#popup">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </div>

            <div id="popup" class="overlay">
                <div class="popup">
                    <i class="fas fa-pencil-alt"></i>
                    <h2> Nouvelle demande </h2>
                    <a class="close" href="<?php echo base_url(); ?>user/home">&times;</a>
                    <?php
                        echo form_open('message/add');
                    ?>
                    <div class="content">
                        <label for="message">Message</label>
                        <br>
                        <textarea name="message" id="message" cols="30" rows="10" required></textarea>
                        <br>
                        <label for="region">Region</label>
                        <br>
                        <select name="region" id="region">
                            <option value="" selected disabled> Sélectionner la région </option>
                            <?php
                            foreach($regions as $r){
                                echo '<option value="'.htmlentities($r['idRegion']).'">'.htmlentities($r['libelleRegion']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="ajouter" value="Ajouter">
                    </form>
                    <a class="" href="<?php echo base_url(); ?>user/home">
                        <input class="button__in" type="button" name="message_fermer" value="Fermer">
                    </a>
                </div>
            </div>

            <footer>
                <article class="footer_column">    </article>
            </footer>
        </div>
    </body>
</html>
