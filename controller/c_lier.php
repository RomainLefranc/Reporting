<?php
if (isset($_SESSION['user'])) {
    $username = htmlspecialchars($_SESSION['user']);

    include 'model/m_utilisateurs.php';
    include 'model/m_compteFB.php';
    include 'model/m_pagesInsta.php';
    $view = 'v_lier';
    
    if(!isset($_GET['token']) && !isset($_GET['pagefb'])){
        echo "
        <script>
            function init() {
              FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
    
                  window.location.href = \"index.php?page=ajout&token=\" + response.authResponse.accessToken;
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
}
?>