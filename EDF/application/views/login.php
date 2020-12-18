<!DOCTYPE html>
<html lang="fr">
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" />
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/edf.png" />

    </head>

    <body class="align">
        <div class="grid align__item">
            <div class="register">
                <div class = "logo">
                    <img src="<?php echo base_url(); ?>assets/images/edf.png" alt="logo EDF" width="100%" height="100%" ></img>
                </div>

                <defs>
                    <linearGradient id="a" x1="0%" y1="0%" y2="0%"><stop offset="0%" stop-color="#8ceabb"/><stop offset="100%" stop-color="#378f7b"/></linearGradient>
                </defs>
                <path fill="url(#a)" d="M215 214.9c-83.6 123.5-137.3 200.8-137.3 275.9 0 75.2 61.4 136.1 137.3 136.1s137.3-60.9 137.3-136.1c0-75.1-53.7-152.4-137.3-275.9z"/></svg>
        
                <h2 style="font-size: 120%; margin-bottom: 10%;">Connectez vous </h2>

                <?php
					echo form_open('user/login');
				?>

                <div class="form__field">
                    <input name="login" type="text" placeholder="Votre Login">
                    <?php echo form_error('login'); ?>
                </div>

                <div class="form__field">
                    <input name="password" type="password" placeholder="••••••••••••">
                    <?php echo form_error('password'); ?>
                </div>

                <br>

                <div class="form__field">
                    <input type="submit" value="Se connecter">
                </div>

                </form>

            </div>
        </div>
    </body>
</html>