<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Export CSV Facebook</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Generation CSV Facebook</h1>
                    </div>

                    <div class="form-group row">
                        <label for="example-page-input" class="col-lg-2 col-form-label">Pages disponible</label>
                        <div class="col-lg-10">
                            <select class="form-control monForm" name="selectedValue" style="max-width: 300px;" id="example-page-input">
                            <option value="null" data-nom=""> </option>
                            <?php
                                foreach($listePageFB as $pageFB){
                                    $token = getComptesFB( $pageFB['id_comptes']);
                                    echo '<option value="' . $pageFB['id'] . '" data-value="' . $token . '" data-nom="' . $pageFB['nom'] . '">' . $pageFB['nom'] . '</option>';
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-date-input" class="col-lg-2 col-form-label">Date de début</label>
                        <div class="col-lg-10">
                            <input class="form-control monForm" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input"
                            style="max-width: 300px;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-date-input2" class="col-lg-2 col-form-label">Date de fin</label>
                        <div class="col-lg-9">
                            <input class="form-control monForm" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input2"
                            style="max-width: 300px;">
                        </div>
                    </div>

                    <section>
                        <progress value="0" max="100" id="progress_selectionne"></progress>
                    </section>

                    <button class="btn btn-warning" id="cmd2" type="button">Générer le CSV</button>

                    <div id="erreur"></div>

                    <div id="result" class="container row" style="max-width: initial;"></div>

                    <script>
                    //a chaque changement de mes select dans mon formulaire, on execute la fonction
                    $("#cmd2").click(function () {

                        //on récupère l'id de la page en value
                        var idPageFBChoisi = $("#example-page-input").val();

                        //on récupère le token correspondant a la page en data-value
                        var pageFBChoisi = $('#example-page-input').find('option:selected');
                        var token = pageFBChoisi.data('value');

                        //on récupère la date de debut sélectionné par l'utilisateur
                        var dateDebutNonFormatte = $("#example-date-input").val();
                        var dateDebutFormatte = new Date(dateDebutNonFormatte);

                        //on récupère la date de fin sélectionné par l'utilisateur
                        var dateFinNonFormatte = $("#example-date-input2").val();
                        var dateFinFormatte = new Date(dateFinNonFormatte);

                        /* Formatage dateDebut */
                        dateDebutFormatte = `${((dateDebutFormatte.getDate() > 9) ? dateDebutFormatte.getDate() : ('0' + dateDebutFormatte.getDate()))}-${((dateDebutFormatte.getMonth() > 8) ? (dateDebutFormatte.getMonth() + 1) : ('0' + (dateDebutFormatte.getMonth() + 1)))}-${dateDebutFormatte.getFullYear()}`;

                        /* Formatage dateFin */
                        dateFinFormatte = `${((dateFinFormatte.getDate() > 9) ? dateFinFormatte.getDate() : ('0' + dateFinFormatte.getDate()))}-${((dateFinFormatte.getMonth() > 8) ? (dateFinFormatte.getMonth() + 1) : ('0' + (dateFinFormatte.getMonth() + 1)))}-${dateFinFormatte.getFullYear()}`;

                        $("#progress_selectionne").val("15");
                        var monUrl = `https://graph.facebook.com/v4.0/${idPageFBChoisi}?fields=id,name,posts.since(${dateDebutFormatte}).until(${dateFinFormatte}){id,full_picture,message,reactions.summary(true),created_time,comments.summary(true),shares,attachments},fan_count&access_token=${token}`
                        console.log(monUrl);
                        $.ajax({
                        url: monUrl,
                        complete: function (xhr, textStatus) {
                            if (textStatus == "success") {
                            var response = JSON.parse(xhr.responseText);
                            var htm = "";
                            var nbPost = 0;
                            console.log(response);
                            $("#progress_selectionne").val("25");
                            //si l'utilisateur n'a pas selectionné de page, on lui propose de selectionner une page
                            if (pageFBChoisi.data("nom") == "") {
                                htm += "<p>Veuillez selectioner une page</p>";
                            } else if (response.posts === undefined || idPageFBChoisi == "null") {
                                htm += "<p>Il n'y a aucun post sur cette page !</p>";
                            } else {
                                $("#progress_selectionne").val("35");
                                var progressActuel = 35;
                                var progressCount = 60 / response.posts.data.length;
                                var itemsNotFormatted = []
                                //boucle for pour afficher les posts de la page en prenant en compte la date sélectionné
                                for (var pos = 0; pos < response.posts.data.length; pos++) {
                                //on converti la date dans un format lisible et compréhensible
                                var date = new Date(response.posts.data[pos].created_time);
                                var maDate =`${((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()))}/${((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)))}/${date.getFullYear()} ${date.getHours()}h${((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()))}`;
                                //on fait un tri et on selectionne uniquement les posts qui ont été postés après la date selectionné
                                if (response.posts.data[pos].created_time > dateDebutNonFormatte) {
                                    nbPost += 1;

                                    /* Reactions */
                                    var reactions = response.posts.data[pos].reactions.summary.total_count;

                                    /* Commentaires */
                                    var commentaires = response.posts.data[pos].comments.summary.total_count;

                                    /* Message */
                                    if (response.posts.data[pos].message === undefined) {
                                    var message = "";
                                    } else {
                                    var message = response.posts.data[pos].message;
                                    }

                                    /* Shares */
                                    if (response.posts.data[pos].shares === undefined) {
                                    var shares = 0;
                                    } else {
                                    var shares = response.posts.data[pos].shares.count;
                                    }

                                    /* Title */
                                    if (response.posts.data[pos].attachments.data[0].title === undefined) {
                                    var title = "";
                                    } else {
                                    var title = response.posts.data[pos].attachments.data[0].title
                                    }

                                    /* Type */
                                    if (response.posts.data[pos].attachments.data[0].type === undefined) {
                                    var type = "";
                                    } else {
                                    var type = response.posts.data[pos].attachments.data[0].type
                                    }

                                    //obtient un jeton d'accès de page et on affiche les insights de la page (clics et personnes atteintes) avec une succession de 2 appels ajax
                                    var idPage = response.posts.data[pos].id;

                                    ///////////////////////////////////////////////////////////////////////////////////////////////////
                                    var monUrl2 = `https://graph.facebook.com/me/accounts?access_token=${token}`;
                                    $.ajax({
                                    url: monUrl2,
                                    async: false,
                                    complete: function (xhr, textStatus) {
                                        var response = JSON.parse(xhr.responseText);

                                        for (var i = 0; i < response.data.length; i++) {
                                        if (response.data[i].id == idPage.substr(0, 15)) {
                                            var tokenPage = response.data[i].access_token;
                                        }
                                        }
                                        //recuperationDesInsights(idPage,pos,tokenPage);
                                        var monUrl2 = `https://graph.facebook.com/v4.0/${idPage}/insights/post_clicks_unique,post_impressions_organic,post_impressions_paid,post_impressions,post_engaged_users,post_video_views?access_token=${tokenPage}`;
                                        console.log(monUrl2)
                                        $.ajax({
                                        url: monUrl2,
                                        async: false,
                                        complete: function (xhr, textStatus) {
                                            var response = JSON.parse(xhr.responseText);
                                            var htm = "";

                                            /* Nb Vues */
                                            if (response.data[5].values[0].value === undefined) {
                                            var nbVues = "";
                                            } else {
                                            var nbVues = response.data[5].values[0].value
                                            }

                                            itemsNotFormatted.push({
                                            type: type,
                                            date: maDate,
                                            nom: '"' + message.replace(/,/g, '.').replace(/\n/g, '').replace(/;/g, '.').substr(0, 50) + '"',
                                            depense: "",
                                            interet: "",
                                            age: "",
                                            reachOrganique: response.data[1].values[0].value,
                                            reachPublicitaire: response.data[2].values[0].value,
                                            reachTotal: response.data[3].values[0].value,
                                            objectif: "",
                                            impression: response.data[3].values[0].value,
                                            engagement: ((response.data[4].values[0].value / response.data[3].values[0].value) * 100).toFixed(2).replace(/,/g, '.'),
                                            react: reactions,
                                            com: commentaires,
                                            partages: shares,
                                            clics: response.data[0].values[0].value,
                                            nbVues: nbVues
                                            });
                                        }
                                        });
                                    }
                                    });
                                    ///////////////////////////////////////////////////////////////////////////////////////////////////
                                    htm += '</div>';

                                }
                                progressActuel += progressCount;
                                $("#progress_selectionne").val(progressActuel);

                                }
                                if (nbPost == 0) {
                                htm += "<p>Aucun post pour cette periode, veuillez choisir une date plus ancienne</p>";
                                }
                            }

                            $("#result").html(htm);
                            console.log(itemsNotFormatted)

                            function convertToCSV(objArray) {
                                var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
                                var str = '';

                                for (var i = 0; i < array.length; i++) {
                                var line = '';
                                for (var index in array[i]) {
                                    if (line != '') line += ','

                                    line += array[i][index];
                                }

                                str += line + '\r\n';
                                }

                                return str;
                            }

                            function exportCSVFile(headers, items, fileTitle) {
                                if (headers) {
                                items.unshift(headers);
                                }

                                // Convert Object to JSON
                                var jsonObject = JSON.stringify(items);

                                var csv = convertToCSV(jsonObject);

                                var exportedFilenmae = fileTitle + '.csv' || 'export.csv';

                                var blob = new Blob([csv], {
                                type: 'text/csv;charset=utf-8;'
                                });
                                if (navigator.msSaveBlob) { // IE 10+
                                navigator.msSaveBlob(blob, exportedFilenmae);
                                } else {
                                var link = document.createElement("a");
                                if (link.download !== undefined) { // feature detection
                                    // Browsers that support HTML5 download attribute
                                    var url = URL.createObjectURL(blob);
                                    link.setAttribute("href", url);
                                    link.setAttribute("download", exportedFilenmae);
                                    link.style.visibility = 'hidden';
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                }
                                }
                            }

                            var headers = {
                                type: "Type",
                                date: 'Date de campagne',
                                nom: "Nom de la campagne",
                                depense: "Dépensé",
                                interet: "Centre d'intérêt",
                                age: "Âge",
                                reachOrganique: "Reach Organique",
                                reachPublicitaire: "Reach publicitaire",
                                reachTotal: "Reach Total",
                                objectif: "Objectif",
                                impression: "Impression",
                                engagement: "Taux engagement",
                                react: "Nb réact.",
                                com: "Nb com.",
                                partages: "Nb partages",
                                clics: "Nb Clics ",
                                nbVues: "Nb vues (vidéo)"

                            };

                            var itemsFormatted = [];

                            // format the data
                            itemsNotFormatted.forEach((item) => {
                                itemsFormatted.push({
                                type: item.type,
                                date: item.date,
                                nom: item.nom,
                                depense: item.depense,
                                interet: item.interet,
                                age: item.age,
                                reachOrganique: item.reachOrganique,
                                reachPublicitaire: item.reachPublicitaire,
                                reachTotal: item.reachTotal,
                                objectif: item.objectif,
                                impression: item.impression,
                                engagement: item.engagement,
                                react: item.react,
                                com: item.com,
                                partages: item.partages,
                                clics: item.clics,
                                nbVues: item.nbVues
                                });
                            });

                            var fileTitle = 'orders'; // or 'my-unique-title'
                            $("#progress_selectionne").val("99");
                            exportCSVFile(headers, itemsFormatted,fileTitle); // call the exportCSVFile() function to process the JSON and trigger the download
                            $("#progress_selectionne").val("100");
                            } else {
                            if (pageFBChoisi.data("nom") != "") {
                                $("#erreur").addClass("erreur");
                                $('#erreur').html("Serveur indisponible ! Veuillez réessayer plus tard ou reliez votre compte à l'application");
                            }
                            }
                        }
                        });
                    })
                    .trigger("change");
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pret à partir ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Voulez vous vous deconnecter ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" href="index.php?a=d">Se deconnecter</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>