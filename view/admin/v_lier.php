<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Nautilus Social Manager - Liaison RS</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php
            include 'inc/sidebar.php'
        ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php
                    include 'inc/navbar.php'
                ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Lier un compte</h1>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Facebook</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-fw fa-facebook fa-2x text-gray-300"></i>
                                        </div>
                                        <div class="fb-login-button" data-width="" data-size="large" data-button-type="login_with" data-auto-logout-link="true" data-use-continue-as="false" data-scope="public_profile, manage_pages, read_insights" onlogin=" init();checkLoginState();"></div>
                                        <div id="fb-root"></div>
                                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v5.0&appId=941052469578811&autoLogAppEvents=1"></script>
                                        <div id="btn" style="justify-content: center;display: flex;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $fb = new Facebook\Facebook([
                            'app_id'                => '941052469578811',
                            'app_secret'            => 'a4b8c333c1be79a3376c8cc148bb508e',
                            'default_graph_version' => 'v4.0',
                        ]);
                        if (isset($_GET['token'])) {
                            $token = htmlspecialchars($_GET['token']);
                            $json = file_get_contents('https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=941052469578811&client_secret=a4b8c333c1be79a3376c8cc148bb508e&fb_exchange_token=' . $token);
                            $token = $parsed_json = json_decode($json);
                            $token = $token->access_token;
                            try {
                                // Retourne l'objet de `Facebook\FacebookResponse`
                                $response = $fb->get('/me?fields=id,name', $token);
                            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                                echo 'Graph retourne une erreur: ' . $e->getMessage();
                                exit;
                            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                                echo 'Facebook SDK retourne une erreur: ' . $e->getMessage();
                                exit;
                            }
                    
                            $user = $response->getGraphUser();
                            function httpPost($url, $data){
                                $options = array(
                                    'http' => array(
                                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                        'method'  => 'POST',
                                        'content' => http_build_query($data)
                                    )
                                );
                                $context  = stream_context_create($options);
                                return file_get_contents($url, false, $context);
                            }
                            //on récupère toutes les pages que l'utilisateur connecté nous a autorisé à ajouter
                            $json = file_get_contents('https://graph.facebook.com/v4.0/' . $user['id'] . '/accounts?fields=access_token,name,picture&access_token='. $token);
                            $listePageFB = $parsed_json = json_decode($json, true);
                            $listePageFB = $listePageFB['data'];
                            foreach ($listePageFB as $pageFB) {
                                $idPageFB = $pageFB['id'];
                                $tokenPageFb = $pageFB['access_token'];
                                $url = 'https://graph.facebook.com/v9.0/'.$idPageFB.'/subscribed_apps?subscribed_fields=feed&access_token='.$tokenPageFb;
                                httpPost($url, []);
                            }
                            die();
                            
                            $listeComptesFB = getListeComptesFB();
                            $compteFBtrouver = false;
                    
                            foreach ($listeComptesFB as $compteFB) {
                                if ($compteFB['id'] == $user['id']) {
                                    $compteFBtrouver = true;
                                }
                            }
                            if (!$compteFBtrouver) {
                                ajouterCompteFB($user['id'],$user['name'],$token);
                            } else {
                                $token_BDD = getToken($user['id']);
                                if (empty($token_BDD) || $token_BDD != $token) {
                                    setToken($user['id'], $token);
                                }
                            }
                    
                            echo "<h2>Voici la liste des pages récupérées :</h2>"; 
                            $listePageFBrecupere = 'Facebook :<br/>';
                            $listePageInstarecupere = 'Instagram :<br/>';

                            foreach ($listePageFB as $pageFB) {
                                $nomPageFB = $pageFB['name'];
                                $idPageFB = $pageFB['id'];
                                $imgPageFB = $pageFB['picture']['data']['url'];
                                $listePageFBrecupere.= "<img src='" . $imgPageFB . "' width='25' height='25' style='border-radius:30px'> ".$nomPageFB.'<br>';
                        
                                $json = file_get_contents('https://graph.facebook.com/v8.0/'.$pageFB['id'].'?fields=instagram_business_account&access_token='.$token);
                                $parsed_json = json_decode($json, true);
                                $pageInsta = $parsed_json = json_decode($json, true);
                    
                                if (array_key_exists('instagram_business_account', $pageInsta)) {
                                    $idPageInsta = $pageInsta['instagram_business_account']['id'];
                                    $json = file_get_contents('https://graph.facebook.com/v3.2/'.$idPageInsta.'?fields=name,profile_picture_url&access_token='.$token);
                                    $parsed_json = json_decode($json, true);
                                    $nomPageInsta = $parsed_json['name'];
                                    $imgPageInsta = $parsed_json['profile_picture_url'];
                                    $listePageInstarecupere.= "<img src='" . $imgPageInsta . "' width='25' height='25' style='border-radius:30px'> ".$nomPageInsta.'<br>';
                                }
                    
                                $listepagesFB_BDD = getPagesFB_BDD();
                                $trouve = false;
                                foreach ($listepagesFB_BDD as $pageFB_BDD) {
                                    //s'il y a des pages dans la BDD, on vérifie que chaque page de l'utilisateur dans la boucle for se trouve dans notre BDD
                                    if ($pageFB_BDD['id'] == $idPageFB) {
                                        $trouve = true;
                                    }
                                }
                                //si la page de l'utilisateur n'a pas été trouvé, on l'ajoute
                                if(!$trouve){
                                    ajouterPageFB($idPageFB,$nomPageFB,$user['id']);
                                }
                        
                                $listepagesInsta_BDD = getPagesInsta_BDD();
                                $trouve = false;
                                foreach ($listepagesInsta_BDD as $pageInsta_BDD) {
                                    if ($pageInsta_BDD[0] == $idPageInsta) {
                                        $trouve = true;
                                    }
                                }
                                if(!$trouve){
                                    ajouterPageInsta($idPageFB,$idPageInsta,$nomPageInsta);
                                }
                            }
                            echo $listePageFBrecupere;
                            echo '<br>';
                            echo $listePageInstarecupere;

                        }
                        if(!isset($_GET['token']) && !isset($_GET['pagefb'])){
                            echo "
                                <script>
                                    function init() {
                                        FB.getLoginStatus(function(response) {
                                            if (response.status === 'connected') {
                                                window.location.href = \"index.php?a=l&token=\" + response.authResponse.accessToken;
                                            }
                                        });
                                    }
                            
                                    window.fbAsyncInit = function() {
                                        FB.init({
                                            appId            : '941052469578811',
                                            autoLogAppEvents : true,
                                            xfbml            : true,
                                            version          : 'v4.0'
                                        });
                                        init();
                                    };
                            
                                    (function(d, s, id){
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) {return;}
                                        js = d.createElement(s); js.id = id;
                                        js.src = \"https://connect.facebook.net/fr_FR/sdk.js\";
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));

                                </script>";
                        }
                    ?>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Nautilus 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php
        include 'inc/footer.php';
    ?>
    <!-- Logout Modal-->
    <?php
        include 'inc/modalDeconnexion.php';
    ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
<script>
    //connexion a l'app et execute le code du bouton
    window.fbAsyncInit = function() {
      FB.init({
        appId            : '941052469578811',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v4.0'
      });
    };
</script>
<script async defer src="https://connect.facebook.net/fr_FR/sdk.js"></script>