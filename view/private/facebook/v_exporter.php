<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Export PPTX Facebook</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Page level plugin CSS-->

    <!-- Bundle: Easiest to use, supports all browsers -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/dist/pptxgen.bundle.js"></script>

    <!-- Individual files: Add only what's needed to avoid clobbering loaded libraries -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/libs/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/libs/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/dist/pptxgen.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

    <script type="module" src="js/html2canvas.esm.js"></script>
    <script src="js/html2canvas.min.js"></script>

    <script src="https://rawgit.com/gitbrent/PptxGenJS/master/dist/pptxgen.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/PptxGenJS/dist/pptxgen.shapes.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include 'view/private/inc/sidebar.php'
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include 'view/private/inc/navbar.php'
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Generation PowerPoint Facebook</h1>
                    </div>
                    <form id='bilan'>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Pages disponible</label>
                            <div class="col-lg-10">
                                <select class="form-control" id='choixPageFB' style="max-width: 300px;" required>
                                    <option value=""  data-nom=""></option>
                                    <?php
                                        foreach($listePageFB as $pageFB){
                                            $token = getComptesFB( $pageFB['id_comptes']);
                                            echo '<option value="' . $pageFB['id'] . '" data-value="' . $token . '" data-nom="' . $pageFB['nom'] . '" data-id="' . $pageFB['id_comptes'].'">' . $pageFB['nom'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-lg-2 col-form-label">De</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="month" id="dateDebut" style="max-width: 300px;" required>
                                <small class="form-text text-muted">
                                Sélectionner le mois de départ, la période sera de 3 mois à compter du mois choisi (ex : je choisis janvier 2020, le bilan se fera sur Janvier, Février et Mars)
                                </small>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-lg-2 col-form-label">À</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="month" id="dateFin" style="max-width: 300px;" required readOnly>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning">Generer PowerPoint
                            <section>
                                <progress value="0" max="100" id="progress_bar"></progress>
                            </section>
                        </button>
                    </form>
                    <div id="erreur"></div>

                    <div class="card mb-3 mt-2">
                        <div class="card-header">
                            <i class="fas fa-chart-area"></i>
                            Nombre de likes par post</div>
                        <div class="card-body" id="like">
                            <canvas id="myAreaChart2" width="100%" height="30"></canvas>
                        </div>
                    </div>
                    
                    <div class="card mb-3 mt-2">
                        <div class="card-header">
                            <i class="fas fa-chart-area"></i>
                            Audience</div>
                        <div class="card-body">
                            <div id="chartdiv" style='width: 100%;height: 500px;'></div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <!-- Resources -->
                <script src="https://www.amcharts.com/lib/4/core.js"></script>
                <script src="https://www.amcharts.com/lib/4/charts.js"></script>
                <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <script>
                    function msgErreur(texte) {
                        var alert = `
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" >
                                <strong>Erreur !</strong> ${texte}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `;
                        return alert;
                    }
                    function formatterDateAPI(date) {
                        return date.getFullYear() + '-' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));
                    }
                    function formatterDate(date) {
                        return ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' à ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                    }
                    $('#dateDebut').change(function () { 
                        var mois = $('#dateDebut').val();
                        mois = new Date(mois);
                        var dernierMois = new Date(mois.getFullYear(), mois.getMonth() + 2)
                        dernierMois = dernierMois.getFullYear() + '-' + ((dernierMois.getMonth() > 8) ? (dernierMois.getMonth() + 1) : ('0' + (dernierMois.getMonth() + 1)))
                        $('#dateFin').val(dernierMois);
                    });
                    $('#bilan').submit(function (e) {
                        e.preventDefault();

                        $('#erreur').html('');
                        $("#progress_bar").val("0");
                        $("#chartdiv").html('');
                        $("#myAreaChart2").remove();
                        $("#like").append('<canvas id="myAreaChart2" width="100%" height="30"></canvas>');

                        /* Récuperation de l'id de la page Facebook choisi */
                        var idPageFB = $('#choixPageFB').val();
                        var idUser = $('#choixPageFB').find('option:selected').data('id');

                        /* Récuperation du nom de la page Instagram choisi */
                        var nomPageFB = $('#choixPageFB').find('option:selected').data('nom');

                        /* Récuperation du token utilisateur */
                        var token = $('#choixPageFB').find('option:selected').data('value');

                        /* Récuperation du 1er mois choisi */
                        var mois = $('#dateDebut').val();
                        mois = new Date(mois);  

                        var tabMois = [];
                        /* Récuperation de la periode trimestriel à partir du 1er mois choisi */
                        for (let index = 0; index < 3; index++) {

                            tabMois[index] = new Date(mois.getFullYear(), mois.getMonth() + index)
                            listeMois = [
                                    'Janvier',
                                    'Février',
                                    'Mars',
                                    'Avril',
                                    'Mai',
                                    'Juin',
                                    'Juillet',
                                    'Août',
                                    'Septembre',
                                    'Octobre',
                                    'Novembre',
                                    'Decembre'
                                    ]
                            
                            nomMois = listeMois[mois.getMonth() + index];
                            
                            var dateDebut = new Date(mois.getFullYear(), mois.getMonth() + index, 1);
                            var dateSince = formatterDateAPI(dateDebut);

                            var dateFin = new Date(mois.getFullYear(), mois.getMonth() + index + 1, 1);
                            var dateUntil = formatterDateAPI(dateFin);

                            tabMois[index].mois = nomMois;
                            tabMois[index].dateDebut = dateDebut;
                            tabMois[index].dateSince = dateSince;
                            tabMois[index].dateFin = dateFin;
                            tabMois[index].dateUntil = dateUntil;
                        }

                        $.get(`https://graph.facebook.com/${idUser}/accounts?limit=50&access_token=${token}`,
                            function (data, textStatus) {
                                switch (textStatus) {
                                    case 'success':
                                        var tokenPageFB = '';
                                        data.data.forEach(post => {
                                            if (post.id == idPageFB) {
                                                tokenPageFB = post.access_token;
                                            }
                                        });
                                        /* Preparation données graphique */
                                        var lesDates = [];
                                        var lesFans = [];

                                        /* Tableau des données */
                                        var tabPost = [];
                                        var trimestre = [];

                                        /* Données trimestre */
                                        var nbMediaTrimestre = 0;
                                        var totalInteractionTrimestre = 0;
                                        var totalReachTrimestre = 0
                                        var totalReachOrganiqueTrimestre = 0;
                                        
                                        tabMois.forEach((mois,index) => {
                                            $.ajax({
                                                type: "GET",
                                                async: false,
                                                url: `https://graph.facebook.com/v4.0/${idPageFB}?fields=id,name,posts.limit(70).since(${mois.dateSince}).until(${mois.dateUntil}){id,full_picture,message,reactions.summary(true),created_time,comments.summary(true).limit(0),shares},fan_count&access_token=${token}`,
                                                dataType: "json",
                                                success: function (response) {
                                                    var nbMedia = 0;
                                                    var totalInteraction = 0;
                                                    var totalReachUnique = 0
                                                    var totalReachUniqueOrganique = 0
                                                    var totalClics = 0;
                                                    response.posts.data.reverse();
                                                    response.posts.data.forEach(media => {
                                                        if (media.created_time >= mois.dateSince && media.created_time <= mois.dateUntil) {
                                                            nbMediaTrimestre++;
                                                            nbMedia++;
                                                            media.created_time = formatterDate(new Date(media.created_time));
                                                            lesDates.push(media.created_time);
                                                            lesFans.push(media.reactions.summary.total_count);
                                                            $.ajax({
                                                                type: "GET",
                                                                url: `https://graph.facebook.com/v4.0/${media.id}/insights/post_engaged_users,post_impressions_unique,post_impressions_organic_unique,post_clicks,post_video_views?access_token=${tokenPageFB}`,
                                                                async: false,
                                                                dataType: "json",
                                                                success: function (response) {
                                                                    totalInteraction += response.data[0].values[0].value
                                                                    totalReachUnique += response.data[1].values[0].value
                                                                    totalReachUniqueOrganique += response.data[2].values[0].value
                                                                    totalClics += response.data[3].values[0].value
                                                                    media.interaction = response.data[0].values[0].value;                    /* Engaged User */
                                                                    media.reach = response.data[1].values[0].value;                          /* Total reach */
                                                                    media.reachOrganique = response.data[2].values[0].value;                 /* reach organic */
                                                                    media.clic = response.data[3].values[0].value;                           /* Total clicks */
                                                                    media.tauxInteraction = ((media.interaction/media.reach)*100).toFixed(2)
                                                                    if (response.data[4].values[0].value > 0) {
                                                                        media.videovue = response.data[4].values[0].value
                                                                    }
                                                                    totalInteractionTrimestre += media.interaction
                                                                    totalReachTrimestre += media.reach
                                                                    totalReachOrganiqueTrimestre += media.reachOrganique
                                                                }
                                                            });
                                                            tabPost.push(media);
                                                        }
                                                    });
                                                    mois.nbMedia = nbMedia;
                                                    mois.interaction = totalInteraction;
                                                    mois.reach = totalReachUnique;
                                                    mois.reachOrganique = totalReachUniqueOrganique;
                                                    mois.clics = totalClics;
                                                    mois.interactionParPost = (mois.interaction/mois.nbMedia).toFixed(0);
                                                    if (totalReachUnique == 0) {
                                                        mois.tauxInteraction = 0;
                                                    } else {
                                                        mois.tauxInteraction = ((mois.interaction / mois.reach)*100).toFixed(2);
                                                    }
                                                }
                                            });
                                            $.ajax({
                                                type: "GET",
                                                url: `https://graph.facebook.com/v4.0/${idPageFB}/insights/page_fans/day?&since=${mois.dateSince}&until=${mois.dateUntil}&access_token=${tokenPageFB}`,
                                                async:false,
                                                dataType: "json",
                                                success: function (response) {
                                                    mois.fan = response.data[0].values[response.data[0].values.length-1].value
                                                }
                                            });
                                        });
                                        if (nbMediaTrimestre == 0) {
                                            $('#erreur').html(msgErreur("Aucun post Facebook n'a été trouvé"));
                                        } else {                                        
                                            $("#progress_bar").val("20");
                                            trimestre.interaction = totalInteractionTrimestre
                                            trimestre.reachTotal = totalReachTrimestre
                                            trimestre.reachOrganique = totalReachOrganiqueTrimestre
                                            trimestre.tauxInteraction = ((totalInteractionTrimestre/totalReachTrimestre)*100).toFixed(2)
                                            trimestre.nbPost = nbMediaTrimestre;
                                            trimestre.nbFan = tabMois[2].fan;
                                            trimestre.interactionParPost = (trimestre.interaction/trimestre.nbPost).toFixed(0)
                                            trimestre.tauxReachOrganique = ((100*trimestre.reachOrganique)/trimestre.reachTotal).toFixed(1)
                                            
                                            var top3Reach = [...tabPost];
                                            top3Reach.sort((a,b) => b.reach - a.reach)
                                            top3Reach = top3Reach.slice(0,3);

                                            $("#progress_bar").val("30");

                                            var top3Interaction = [...tabPost];
                                            top3Interaction.sort((a,b) => (b.tauxInteraction) - (a.tauxInteraction));
                                            top3Interaction = top3Interaction.slice(0,3);
                                            
                                            $("#progress_bar").val("40");

                                            var topPost = [...tabPost];
                                            topPost.sort((a,b) => b.reach - a.reach || b.tauxInteraction - a.tauxInteraction);
                                            topPost = topPost[0];

                                            $("#progress_bar").val("50");

                                            var flop3Reach = [...tabPost];
                                            flop3Reach.sort((a,b) => a.reach - b.reach);
                                            flop3Reach = flop3Reach.slice(0,3);

                                            $("#progress_bar").val("60");
                                            
                                            //on défini l'échelle maximale de notre graphique
                                            var max = Math.ceil(Math.max(...lesFans)) + 5;

                                            // on défini un font et une couleur
                                            Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                                            Chart.defaults.global.defaultFontColor = '#292b2c';

                                            var ctx = document.getElementById("myAreaChart2");
                                                                
                                            var myLineChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: lesDates,
                                                    datasets: [{
                                                        label: "like",
                                                        lineTension: 0.3,
                                                        backgroundColor: "rgba(2,117,216,0.2)",
                                                        borderColor: "rgba(2,117,216,1)",
                                                        pointRadius: 5,
                                                        pointBackgroundColor: "rgba(2,117,216,1)",
                                                        pointBorderColor: "rgba(255,255,255,0.8)",
                                                        pointHoverRadius: 5,
                                                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                                                        pointHitRadius: 50,
                                                        pointBorderWidth: 2,
                                                        data: lesFans,
                                                    }],
                                                },
                                                options: {
                                                    scales: {
                                                    xAxes: [{
                                                        time: {
                                                            unit: 'date'
                                                        },
                                                        gridLines: {
                                                            display: false
                                                        },
                                                        ticks: {
                                                            maxTicksLimit: 7
                                                        }
                                                    }],
                                                    yAxes: [{
                                                        ticks: {
                                                            min: 0,
                                                            max: max,
                                                            maxTicksLimit: 5
                                                        },
                                                        gridLines: {
                                                            color: "rgba(0, 0, 0, .125)",
                                                        }
                                                    }],
                                                    },
                                                    legend: {
                                                        display: false
                                                    }
                                                }
                                            });

                                            $("#progress_bar").val("70");
                                            $.get(`https://graph.facebook.com/v4.0/${idPageFB}/insights/page_fans_gender_age?since=${tabMois[0].dateSince}&until=${tabMois[2].dateUntil}&access_token=${tokenPageFB}`,
                                                function (data) {
                                                    if (typeof data.data[0] != "undefined") {
                                                        totalFans = data.data[0].values[0].value["F.13-17"];
                                                        totalFans += data.data[0].values[0].value["F.18-24"];
                                                        totalFans += data.data[0].values[0].value["F.25-34"];
                                                        totalFans += data.data[0].values[0].value["F.35-44"];
                                                        totalFans += data.data[0].values[0].value["F.45-54"];
                                                        totalFans += data.data[0].values[0].value["F.55-64"];
                                                        totalFans += data.data[0].values[0].value["F.65+"];
                                                        totalFans += data.data[0].values[0].value["M.13-17"];
                                                        totalFans += data.data[0].values[0].value["M.18-24"];
                                                        totalFans += data.data[0].values[0].value["M.25-34"];
                                                        totalFans += data.data[0].values[0].value["M.35-44"];
                                                        totalFans += data.data[0].values[0].value["M.45-54"];
                                                        totalFans += data.data[0].values[0].value["M.55-64"];
                                                        totalFans += data.data[0].values[0].value["M.65+"];
                                                        totalFemme = 0;
                                                        totalHomme = 0;
                                                        totalFemme += femme13 = data.data[0].values[0].value["F.13-17"];
                                                        totalFemme += femme18 = data.data[0].values[0].value["F.18-24"];
                                                        totalFemme += femme25 = data.data[0].values[0].value["F.25-34"];
                                                        totalFemme += femme35 = data.data[0].values[0].value["F.35-44"];
                                                        totalFemme += femme45 = data.data[0].values[0].value["F.45-54"];
                                                        totalFemme += femme55 = data.data[0].values[0].value["F.55-64"];
                                                        totalFemme += femme65 = data.data[0].values[0].value["F.65+"];
                                                        totalHomme += homme13 = data.data[0].values[0].value["M.13-17"];
                                                        totalHomme += homme18 = data.data[0].values[0].value["M.18-24"];
                                                        totalHomme += homme25 = data.data[0].values[0].value["M.25-34"];
                                                        totalHomme += homme35 = data.data[0].values[0].value["M.35-44"];
                                                        totalHomme += homme45 = data.data[0].values[0].value["M.45-54"];
                                                        totalHomme += homme55 = data.data[0].values[0].value["M.55-64"];
                                                        totalHomme += homme65 = data.data[0].values[0].value["M.65+"];

                                                        totalFemme = (totalFemme/totalFans*100).toFixed(2)
                                                        totalHomme = (totalHomme/totalFans*100).toFixed(2)

                                                    } else {
                                                        totalFans = 0;
                                                        totalFemme = 0;
                                                        totalHomme = 0;
                                                        femme13 = 0;
                                                        femme18 = 0;
                                                        femme25 = 0;
                                                        femme35 = 0;
                                                        femme45 = 0;
                                                        femme55 = 0;
                                                        femme65 = 0;
                                                        homme13 = 0;
                                                        homme18 = 0;
                                                        homme25 = 0;
                                                        homme35 = 0;
                                                        homme45 = 0;
                                                        homme55 = 0;
                                                        homme65 = 0;
                                                    } 


                                                    am4core.ready(function() {

                                                        // Themes begin
                                                        am4core.useTheme(am4themes_animated);
                                                        // Themes end

                                                        // Create chart instance
                                                        var chart = am4core.create("chartdiv", am4charts.XYChart);

                                                        // Add data
                                                        chart.data = [
                                                            {
                                                                "age": "65+",
                                                                "female": -Math.abs((femme65/totalFans*100).toFixed(2)),
                                                                "male": (homme65/totalFans*100).toFixed(2)
                                                            }, {
                                                                "age": "55-64",
                                                                "female": -Math.abs((femme55/totalFans*100).toFixed(2)),
                                                                "male": (homme55/totalFans*100).toFixed(2)
                                                            }, {
                                                                "age": "45-54",
                                                                "female": -Math.abs((femme45/totalFans*100).toFixed(2)),
                                                                "male": (homme45/totalFans*100).toFixed(2)
                                                            }, {
                                                                "age": "35-44",
                                                                "female": -Math.abs((femme35/totalFans*100).toFixed(2)),
                                                                "male": (homme35/totalFans*100).toFixed(2)
                                                            }, {
                                                                "age": "25-34",
                                                                "female": -Math.abs((femme25/totalFans*100).toFixed(2)),
                                                                "male": (homme25/totalFans*100).toFixed(2)
                                                            }, {
                                                                "age": "18-24",
                                                                "female": -Math.abs((femme18/totalFans*100).toFixed(2)),
                                                                "male": (homme18/totalFans*100).toFixed(2)
                                                            }, {
                                                                "age": "13-17",
                                                                "female": -Math.abs((femme13/totalFans*100).toFixed(2)),
                                                                "male": (homme13/totalFans*100).toFixed(2)
                                                            }
                                                        ];

                                                        // Use only absolute numbers
                                                        chart.numberFormatter.numberFormat = "#.#s";

                                                        // Create axes
                                                        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                                                        categoryAxis.dataFields.category = "age";
                                                        categoryAxis.renderer.grid.template.location = 0;
                                                        categoryAxis.renderer.inversed = true;

                                                        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                                                        valueAxis.extraMin = 0.1;
                                                        valueAxis.extraMax = 0.1;
                                                        valueAxis.renderer.minGridDistance = 40;
                                                        valueAxis.renderer.ticks.template.length = 5;
                                                        valueAxis.renderer.ticks.template.disabled = false;
                                                        valueAxis.renderer.ticks.template.strokeOpacity = 0.4;
                                                        valueAxis.renderer.labels.template.adapter.add("text", function(text) {
                                                            return text == "Male" || text == "Female" ? text : text + "%";
                                                        })

                                                        // Create series
                                                        var male = chart.series.push(new am4charts.ColumnSeries());
                                                        male.dataFields.valueX = "female";
                                                        male.dataFields.categoryY = "age";
                                                        male.clustered = false;

                                                        var maleLabel = male.bullets.push(new am4charts.LabelBullet());
                                                        maleLabel.label.text = "{valueX}%";
                                                        maleLabel.label.hideOversized = false;
                                                        maleLabel.label.truncate = false;
                                                        maleLabel.label.horizontalCenter = "right";
                                                        maleLabel.label.dx = -10;

                                                        var female = chart.series.push(new am4charts.ColumnSeries());
                                                        female.dataFields.valueX = "male";
                                                        female.dataFields.categoryY = "age";
                                                        female.clustered = false;

                                                        var femaleLabel = female.bullets.push(new am4charts.LabelBullet());
                                                        femaleLabel.label.text = "{valueX}%";
                                                        femaleLabel.label.hideOversized = false;
                                                        femaleLabel.label.truncate = false;
                                                        femaleLabel.label.horizontalCenter = "left";
                                                        femaleLabel.label.dx = 10;

                                                        var maleRange = valueAxis.axisRanges.create();
                                                        maleRange.value = -10;
                                                        maleRange.endValue = 0;
                                                        maleRange.label.text = "Femme " + totalFemme;
                                                        maleRange.label.fill = chart.colors.list[0];
                                                        maleRange.label.dy = 20;
                                                        maleRange.label.fontWeight = '600';
                                                        maleRange.grid.strokeOpacity = 1;
                                                        maleRange.grid.stroke = male.stroke;

                                                        var femaleRange = valueAxis.axisRanges.create();
                                                        femaleRange.value = 0;
                                                        femaleRange.endValue = 10;
                                                        femaleRange.label.text = "Homme " + totalHomme;
                                                        femaleRange.label.fill = chart.colors.list[1];
                                                        femaleRange.label.dy = 20;
                                                        femaleRange.label.fontWeight = '600';
                                                        femaleRange.grid.strokeOpacity = 1;
                                                        femaleRange.grid.stroke = female.stroke;

                                                        });
                                                }
                                            );

                                            $("#progress_bar").val("80");
                                            var donneesPowerPoint = [];
                                            donneesPowerPoint.trimestre = trimestre;
                                            donneesPowerPoint.mois = tabMois
                                            donneesPowerPoint.topPost = topPost;
                                            donneesPowerPoint.top3Reach = top3Reach;
                                            donneesPowerPoint.top3Interaction = top3Interaction;
                                            donneesPowerPoint.top3FlopReach = flop3Reach;
                                            
                                            var pptx = new PptxGenJS();
                                            var slide = pptx.addSlide();
                                            $("#progress_bar").val("90");
                                            html2canvas(document.body).then(function(canvas) {
                                                //on récupère les graphiques de la page et les images dans notre dossier
                                                var node = document.getElementById('myAreaChart2');
                                                var node2 = document.getElementById('chartdiv');
                                                //domtoimage va servir a faire une capture de nos canvas (graphiques) et des les convertir en image base64
                                                domtoimage.toPng(node).then(function (dataUrl) {
                                                    domtoimage.toPng(node2).then(function (dataUrl2) {
                                                        var img = new Image();
                                                        img.src = dataUrl;
                                                        var img5 = new Image();
                                                        img5.src = dataUrl2;
                                                        var pageGuarde = "images/capture3.png";
                                                        var header = "images/bandeau1.png";
                                                        var fin = "images/fin.png";
                                                        var screenPage = "images/screen-page.png";
                                                        var screenPost = "images/screen-post1.png";

                                                        //page de garde
                                                        slide.addImage({ path:pageGuarde, x:0, y:0, w:10, h:5.6 });

                                                        //page de garde
                                                        slide = pptx.addSlide();
                                                        slide.bkgd = 'f1bf00';
                                                        slide.addText( nomPageFB ,  { x:'30%', y:'25%', w:4, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:45 });
                                                        slide.addText('PAGE FACEBOOK',  { x:'35%', y:'40%', w:3, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:22 });
                                                        slide.addText('BILAN Trimestriel',  { x:'30%', y:'57%', w:4, color:'FFFFFF', align: 'center', fontFace:'Avenir 85 Heavy', fontSize:30 });
                                                        slide.addText('(' + donneesPowerPoint.mois[0].mois + ' / ' + donneesPowerPoint.mois[1].mois + ' / ' + donneesPowerPoint.mois[2].mois + ') 2020',  { x:'25%', y:'72%', w:5, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:22 });

                                                        //seconde page "LA PAGE FACEBOOK"
                                                        slide = pptx.addSlide();
                                                        slide.addText([
                                                                { text: donneesPowerPoint.trimestre.tauxInteraction.toString() + ' %', options: {bold:true, fontSize:12}},
                                                                { text: ' Taux d\'interaction', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'7%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                        slide.addText([
                                                                { text: donneesPowerPoint.trimestre.nbFan.toLocaleString(), options: {bold:true, fontSize:12}},
                                                                { text: ' fans', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'22%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                        slide.addText([
                                                                { text: donneesPowerPoint.trimestre.nbPost.toString(), options: {bold:true, fontSize:12}},
                                                                { text: ' posts', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'37%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                        slide.addText([
                                                                { text: donneesPowerPoint.trimestre.interaction.toLocaleString(), options: {bold:true, fontSize:12}},
                                                                { text: ' interactions soit une moyenne de ', options: {}},
                                                                { text: donneesPowerPoint.trimestre.interactionParPost + '/post', options: {bold:true}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'52%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                        slide.addText([
                                                                { text: donneesPowerPoint.trimestre.reachTotal.toLocaleString(), options: {bold:true, fontSize:12}},
                                                                { text: ' reach total posts', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'67%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                        slide.addText([
                                                                { text: donneesPowerPoint.trimestre.reachOrganique.toLocaleString(), options: {bold:true, fontSize:12}},
                                                                { text: ' reach organique soit ' + donneesPowerPoint.trimestre.tauxReachOrganique + '%', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'82%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                        slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                        slide.addText('LA PAGE FACEBOOK',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                        slide.addImage({ path:screenPage, x:"18%", y:"18%", w:"64%", h:"55%" });
                                                        
                                                        //troisième page CHIFFRES CLES
                                                        slide = pptx.addSlide();
                                                        slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                        slide.addText('CHIFFRES CLES',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                        var posXShape = 15
                                                        var posYShape = 25
                                                        var posXTitre = 5;
                                                        var posYTitre = 18;
                                                        donneesPowerPoint.mois.forEach(mois => {
                                                            slide.addText(mois.mois.toString(),  { x: posXTitre + '%', y:posYTitre + '%', w:'100%', color:'000000', fontSize:18 });
                                                            slide.addText([
                                                                { text: mois.tauxInteraction.toString() + ' %', options: {bold:true, fontSize:12}},
                                                                { text: ' Taux d\'interaction', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x: posXShape + '%', y:posYShape + '%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                            posXShape += 15
                                                            slide.addText([
                                                                { text: mois.fan.toLocaleString(), options: {bold:true, fontSize:12}},
                                                                { text: ' fans', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:posXShape + '%', y:posYShape + '%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                            posXShape += 15
                                                            slide.addText([
                                                                { text: mois.nbMedia.toString(), options: {bold:true, fontSize:12}},
                                                                { text: ' posts', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:posXShape + '%', y:posYShape + '%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                            posXShape += 15
                                                            slide.addText([
                                                                { text: mois.interaction.toLocaleString(), options: {bold:true, fontSize:12}},
                                                                { text: ' interactions soit une moyenne de ', options: {}},
                                                                { text: mois.interactionParPost.toLocaleString() + '/post', options: {bold:true}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:posXShape + '%', y:posYShape + '%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                            posXShape += 15
                                                            slide.addText([
                                                                { text: mois.reach.toLocaleString(), options: {bold:true, fontSize:12}},
                                                                { text: ' reach total posts', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:posXShape + '%', y:posYShape + '%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                            posXShape = 15
                                                            posYShape += 27
                                                            posYTitre += 27
                                                        });
                                                        
                                                        //quatrième page FOCUS FANS
                                                        slide = pptx.addSlide();
                                                        slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                        slide.addText('FOCUS FANS',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                        slide.addImage({ data:img5.src, x:1, y:1, w:8, h:3 });

                                                        //cinquième page FOCUS LIKE
                                                        slide = pptx.addSlide();
                                                        slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                        slide.addText('FOCUS LIKE',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                        slide.addImage({ data:img.src, x:0.2, y:1, w:6.1, h:2.5 });
                                                        slide.addImage({ path:screenPost, x:"67%", y:"18%", w:"28%", h:"42%" });

                                                        //sixième page TOP POST
                                                        slide = pptx.addSlide();
                                                        slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                        slide.addText('TOP POST',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                        slide.addText([
                                                                { text: 'TOP REACH', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'55%', y:'17%', w:2.2, h:0.4, fill:'0088CC', line:'006699', lineSize:2 , fontSize:13, color:'FFFFFF'});
                                                        slide.addText([
                                                                { text: 'TOP INTERACTION*', options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'55%', y:'25%', w:2.2, h:0.4, fill:'0088CC', line:'006699', lineSize:2 , fontSize:13, color:'FFFFFF'});
                                                        slide.addText([
                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                { text: donneesPowerPoint.topPost.created_time, options: {}}
                                                            ],  { x:'55%', y:'35%', w:'100%', color:'000000', fontSize:15 });
                                                        slide.addText('Thème : ',  { x:'55%', y:'40%', w:'100%', color:'000000', fontSize:15 });
                                                        slide.addText('Format : ',  { x:'55%', y:'45%', w:'100%', color:'000000', fontSize:15 });
                                                        slide.addText([
                                                                { text: donneesPowerPoint.topPost.reactions.summary.total_count == "undefined" ? '0' : donneesPowerPoint.topPost.reactions.summary.total_count.toLocaleString(), options: {}},
                                                                { text: ' Réactions', options: {bold:true}}
                                                            ],  { x:'55%', y:'50%', w:'100%', color:'000000', fontSize:15 });
                                                        slide.addText([
                                                                { text: donneesPowerPoint.topPost.comments.summary.total_count == "undefined" ? '0' : donneesPowerPoint.topPost.comments.summary.total_count.toLocaleString(), options: {}},
                                                                { text: ' Commentaires', options: {bold:true}}
                                                            ],  { x:'55%', y:'55%', w:'100%', color:'000000', fontSize:15 });
                                                        slide.addText([
                                                                { text: donneesPowerPoint.topPost.hasOwnProperty('shares') ? donneesPowerPoint.topPost.shares.count.toLocaleString() : '0', options: {}},
                                                                { text: ' Partages', options: {bold:true}}
                                                            ],  { x:'55%', y:'60%', w:'100%', color:'000000', fontSize:15 });
                                                        slide.addText([
                                                                { text: donneesPowerPoint.topPost.clic == "undefined" ? '0' : donneesPowerPoint.topPost.clic.toLocaleString(), options: {}},
                                                                { text: ' Clics', options: {bold:true}}
                                                            ],  { x:'55%', y:'65%', w:'100%', color:'000000', fontSize:15 });
                                                        slide.addText([
                                                                { text: donneesPowerPoint.topPost.reach == "undefined" ? '0' : donneesPowerPoint.topPost.reach.toLocaleString(), options: {}},
                                                                { text: ' Personnes atteintes', options: {bold:true}}
                                                            ],  { x:'55%', y:'70%', w:'100%', color:'0088CC', fontSize:15 });
                                                        slide.addText([
                                                                { text: donneesPowerPoint.topPost.tauxInteraction == "undefined" ? '0' : donneesPowerPoint.topPost.tauxInteraction.toString(), options: {}},
                                                                { text: '% Taux d\'interaction', options: {bold:true}}
                                                            ],  { x:'55%', y:'75%', w:'100%', color:'000000', fontSize:15 });
                                                        if (donneesPowerPoint.topPost.hasOwnProperty('videovue')) {
                                                            slide.addText([
                                                                { text: donneesPowerPoint.topPost.videovue.toLocaleString(), options: {}},
                                                                { text: ' vue', options: {bold:true}}
                                                            ],  { x:'55%', y:'80%', w:'100%', color:'000000', fontSize:15 });

                                                        }
                                                        slide.addImage({ path:donneesPowerPoint.topPost.full_picture, x:"10%", y:"18%", w:"40%", h:"65%" });
                                                        
                                                        function ajoutTop3(array,nomtop) {
                                                            slide = pptx.addSlide();
                                                            slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                            slide.addText('TOP 3',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                            slide.addText([
                                                                { text: nomtop, options: {}}
                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'25%', y:'4%', w:2.5, h:0.3, fill:'0088CC', line:'006699', lineSize:2 , fontSize:15, color:'FFFFFF'});
                                                            var posXImage = 5
                                                            var posYImage = 18
                                                            var posXText = 5
                                                            var posYText = 60;
                                                            array.forEach(post => {
                                                                slide.addImage({ path:post.full_picture, x:posXImage + "%", y:posYImage + "%", w:"22%", h:"39%" });
                                                                posXImage += 35
                                                                slide.addText([
                                                                    { text: 'Date du post : ', options: {bold:true}},
                                                                    { text: post.created_time, options: {}}
                                                                ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText('Thème : ',  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText('Format : ',  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText([
                                                                    { text: post.reactions.summary.total_count == "undefined" ? '0' : post.reactions.summary.total_count.toLocaleString(), options: {}},
                                                                    { text: ' Réactions', options: {bold:true}}
                                                                ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText([
                                                                    { text: post.comments.summary.total_count == "undefined" ? '0' : post.comments.summary.total_count.toLocaleString(), options: {}},
                                                                    { text: ' Commentaires', options: {bold:true}}
                                                                ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText([
                                                                    { text: post.hasOwnProperty('shares') ? post.shares.count.toLocaleString() :'0', options: {}},
                                                                    { text: ' Partages', options: {bold:true}}
                                                                ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText([
                                                                    { text: post.clic == "undefined" ? '0' : post.clic.toLocaleString(), options: {}},
                                                                    { text: ' Clics', options: {bold:true}}
                                                                ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText([
                                                                    { text: post.reach == "undefined" ? '0' : post.reach.toLocaleString(), options: {}},
                                                                    { text: ' Personnes atteintes', options: {bold:true}}
                                                                ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'000000', fontSize:10 });
                                                                posYText += 4;
                                                                slide.addText([
                                                                    { text: post.tauxInteraction == "undefined" ? '0' : post.tauxInteraction.toString(), options: {}},
                                                                    { text: '% Taux d\'interaction', options: {bold:true}}
                                                                ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'0088CC', fontSize:10 });
                                                                if (post.hasOwnProperty('videovue')) {
                                                                    posYText += 4;
                                                                    slide.addText([
                                                                        { text: post.videovue.toLocaleString(), options: {}},
                                                                        { text: ' vue', options: {bold:true}}
                                                                    ],  { x:posXText + '%', y:posYText + '%', w:'100%', color:'0088CC', fontSize:10 });

                                                                }
                                                                posYText = 60
                                                                posXText += 35

                                                            });
                                                        }

                                                        //septième page TOP 3 (taux d'interaction)
                                                        ajoutTop3(donneesPowerPoint.top3Interaction,'Top interaction')
                                                        
                                                        //huitième page TOP 3 (personnes atteintes)
                                                        ajoutTop3(donneesPowerPoint.top3Reach, 'Top reach')

                                                        //neuvième page FLOP POST
                                                        ajoutTop3(donneesPowerPoint.top3FlopReach, 'Flop reach')

                                                        var nbDiapo = donneesPowerPoint.trimestre.nbPost%12;
                                                        var numMedia = 1;
                                                        for (let diapo = 1; diapo < nbDiapo ; diapo++) {
                                                            var posXImage = 7
                                                            var posYImage = 15
                                                            var posXText = 18
                                                            var posYText = 22;
                                                            if (tabPost.length >= numMedia) {
                                                                slide = pptx.addSlide();
                                                                slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                                for (let index = 0; index < 3; index++) {

                                                                    for (let i = 0; i < 4; i++) {
                                                                        if (tabPost.length >= numMedia) {
                                                                            slide.addImage({ path: tabPost[numMedia-1].full_picture, x:posXImage + "%", y:posYImage + "%", w:"10%", h:"20%" });
                                                                            slide.addText([
                                                                                    { text:  tabPost[numMedia-1].reach.toLocaleString(), options: {}},
                                                                                    { text: ' personnes atteintes', options: {bold:true}}
                                                                                ],  { x:posXText + '%', y: posYText + '%', w:'100%', color:'0088CC', fontSize:10 });
                                                                            slide.addText([
                                                                                { text: tabPost[numMedia-1].tauxInteraction, options: {}},
                                                                                { text: ' % Taux d\'interaction', options: {bold:true}}
                                                                            ],  { x:posXText + '%', y:(posYText + 5) +'%', w:'100%', color:'000000', fontSize:10 }); 
                                                                        }
                                                                        posYImage += 21;
                                                                        posYText += 21;
                                                                        numMedia++;
                                                                    }
                                                                /* Modification de la position de la colonne */
                                                                posXImage += 30;
                                                                posXText += 30; 
                                                                /* Reset pour remonter en haut de la colonne */
                                                                posYText = 22; 
                                                                posYImage = 15;
                                                                }
                                                            }
                                                        }

                                                        //dixième page CONCLUSION
                                                        slide = pptx.addSlide();
                                                        slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                        slide.addText('CONCLUSION',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                        //onxième page CONCLUSION ET RECOMMANDATIONS
                                                        slide = pptx.addSlide();
                                                        slide.addImage({ path:header, x:0, y:0, w:10, h:0.8 });
                                                        slide.addText('CONCLUSION ET RECOMMANDATIONS',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                        //douzième page FIN
                                                        slide = pptx.addSlide();
                                                        slide.addImage({ path:fin, x:0, y:0, w:'100%', h:'100%' });
                                                        slide.addText('Merci',  { x:'35%', y:'40%', w:3, color:'FFFFFF', align: 'center', fontFace:'Avenir 85 Heavy', fontSize:35 });
                                                        

                                                        //on enregistre le powerpoint
                                                        $("#progress_bar").val("100");
                                                        pptx.writeFile('bilan-reporting-Facebook ' + donneesPowerPoint.mois[0].mois + ' - ' + donneesPowerPoint.mois[1].mois  + ' - ' + donneesPowerPoint.mois[2].mois + ' ' +  nomPageFB);
                                                    }).catch(function (error) {
                                                        console.error('oops, something went wrong!', error);
                                                    });
                                                    //fin du 2eme domtoimage
                                                    
                                                }).catch(function (error) {
                                                    console.error('oops, something went wrong!', error);
                                                });
                                                //fin du 1er domtoimage
                                            });
                                        }
                                        break;
                                
                                    default: $('#erreur').html(msgErreur('Soucis avec l\'API de Facebook'));
                                        break;
                                }
                            }
                        );
                        
                    });
                </script>
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
        include 'view/private/inc/footer.php';
    ?>
    <!-- Logout Modal-->
    <?php
        include 'view/private/inc/modalDeconnexion.php'
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>