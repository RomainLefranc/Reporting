<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Bilan Facebook</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include 'view/admin/sidebar.php'
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include 'view/admin/navbar.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Bilan Facebook</h1>
                    </div>
                    <div class="form-group row" >
                        <label for="example-page-input" class="col-lg-2 col-form-label">Pages disponible</label>
                        <div class="col-lg-10">
                            <select class="form-control monForm" name="selectedValue" style="max-width: 300px;" id="example-page-input">
                                <option value="null"  data-nom=""> </option>
                                <?php
                                    foreach($listePageFB as $pageFB){
                                    $token = getComptesFB($pageFB['id_comptes']);
                                    echo '<option value="' . $pageFB['id'] . '" data-value="' . $token . '" data-nom="' . $pageFB['nom'] . '">' . $pageFB['nom'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" >
                        <label for="example-date-input" class="col-lg-2 col-form-label">Date de début</label>
                        <div class="col-lg-10">
                            <input class="form-control monForm" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input" style="max-width: 300px;">
                        </div>
                    </div>

                    <div id="erreur"></div>

                    <div id="result" class="container row" style="max-width: initial;"></div>

                    <script>
                        //a chaque changement de mes select dans mon formulaire, on execute la fonction
                        $( ".monForm" ).change(function() {
                            //on récupère l'id de la page en value
                            var str = $("#example-page-input").val();
                            //on récupère le token correspondant a la page en data-value
                            var selected = $('#example-page-input').find('option:selected');
                            var token = selected.data('value'); 
                            //on récupère la date sélectionné par l'utilisateur
                            var date1 = $("#example-date-input").val();

                            var monUrl = 'https://graph.facebook.com/v4.0/' + str + '?fields=id,name,posts{id,full_picture,message,reactions.summary(true),created_time,comments.summary(true),shares},fan_count&access_token=' + token;               
                            console.log(monUrl);
                            $.ajax(                  
                                {
                                url : monUrl,
                                complete :
                                    function(xhr, textStatus){
                                    if (textStatus == "success") {
                                        var response = JSON.parse(xhr.responseText);                        
                                        var htm = "";
                                        var nbPost = 0;
                                        //si l'utilisateur n'a pas selectionné de page, on lui propose de selectionner une page
                                        if(selected.data("nom") == ""){
                                        htm += "<p>Veuillez selectioner une page</p>";
                                        }
                                        else if(response.posts === undefined || str == "null"){
                                        htm += "<p>Il n'y a aucun post sur cette page !</p>";
                                        }else{
                                        //boucle for pour afficher les posts de la page en prenant en compte la date sélectionné
                                        for (var pos = 0; pos < response.posts.data.length; pos++) {
                                            //on converti la date dans un format lisible et compréhensible
                                            var date = new Date(response.posts.data[pos].created_time);
                                            var maDate = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));

                                            //on fait un tri et on selectionne uniquement les posts qui ont été postés après la date selectionné
                                            if(response.posts.data[pos].created_time > date1){
                                            nbPost += 1;
                                            htm += '<div class="col-5 post" id="post' + pos + '">';

                                            //s'il n'y a aucune image, on affiche TEXTE
                                            if(response.posts.data[pos].full_picture === undefined) {

                                                htm +=    '<p>TEXTE</p>';

                                            }else{
                                                htm +=    '<img src="' + response.posts.data[pos].full_picture +  '" width="auto" height="200px">';
                                            }
                                            htm +=    '<p><strong>Date du post :</strong> ' + maDate + '</p>';
                                            htm +=    '<p>' + response.posts.data[pos].reactions.summary.total_count + ' <strong>Réactions</strong></p>';
                                            htm +=    '<p>' + response.posts.data[pos].comments.summary.total_count + ' <strong>Commentaires</strong></p>';

                                            if(response.posts.data[pos].shares === undefined) {

                                                htm +=    '<p>0 <strong>Partages</strong></p>';

                                            }else{
                                                htm +=    '<p>' + response.posts.data[pos].shares.count + ' <strong>Partages</strong></p>';
                                            }
                                            //obtient un jeton d'accès de page et on affiche les insights de la page (clics et personnes atteintes) avec une succession de 2 appels ajax
                                            getAccessTokenPages(token, response.posts.data[pos].id, pos);


                                            htm += '</div>';
                                            
                                            }


                                        }
                                        if(nbPost == 0){
                                            htm += "<p>Aucun post pour cette periode, veuillez choisir une date plus ancienne</p>";
                                        }
                                        }

                                        $( "#result" ).html( htm );
                                    }else{
                                        if(selected.data("nom") != ""){
                                        $( "#erreur" ).addClass( "erreur" );
                                        $('#erreur').html("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application");
                                        }
                                    }
                                    
                                    }
                                }
                            );
                        

                        })
                        .trigger( "change" );
                    </script>
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
        include 'view/admin/footer.php';
    ?>
    <!-- Logout Modal-->
    <?php
        include 'view/admin/modalDeconnexion.php'
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>