<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="media/logo.png" class="rounded my-4 img-fluid">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue !</h1>
                                    </div>
                                    
                                    <form action="index.php?a=c" method="post" class="user" id="captcha">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Saisissez votre identifiant..." name="id">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Saisissez votre mot de passe" name="mdp">
                                        </div>
                                        <button class="g-recaptcha btn btn-primary btn-user btn-block" 
                                            name="submitConnexion"
                                            data-sitekey="6LeQn-EZAAAAAI-ScUYpCb3pPIC9ecFscMRZfFuZ" 
                                            data-callback='onSubmit' 
                                            data-action='submit' >Se connecter</button>

                                        <!-- <button type="submit" class="btn btn-primary btn-user btn-block" name="submitConnexion">Se connecter</button> -->
                                    </form>
                                    
                                    <?php
                                        if (isset($_POST['erreur'])) {
                                            $erreur = htmlspecialchars($_POST['erreur']);
                                            switch (true) {
                                                case $erreur == 1:
                                                    $msg =  'Mot de passe ou identifiant invalide';
                                                    $typeMsg = 'danger';
                                                    break;
                                            }
                                            echo '                
                                            <div class="mt-2 alert alert-'.$typeMsg.' alert-dismissible fade show btn-user" role="alert">
                                                '.$msg.'
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>  
                                            ';
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
    <script>
        function onSubmit(token) {
            $('#captcha').submit();
        }
    </script>

</html>