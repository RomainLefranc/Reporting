<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nautilus Social Manager - Export PPTX Instagral</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Bundle: Easiest to use, supports all browsers -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/dist/pptxgen.bundle.js"></script>

    <!-- Individual files: Add only what's needed to avoid clobbering loaded libraries -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/libs/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/libs/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@2.6.0/dist/pptxgen.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

    <script type="module" src="js/html2canvas.esm.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/html2canvas.min.js"></script>

    <script src="https://rawgit.com/gitbrent/PptxGenJS/master/dist/pptxgen.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/PptxGenJS/dist/pptxgen.shapes.js"></script>


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
                        <h1 class="h3 mb-0 text-gray-800">Generation PowerPoint Instagram</h1>
                    </div>
                    <form id='bilan'>
                        <div class="form-group row">
                            <label for="example-page-input" class="col-lg-2 col-form-label">Pages disponible</label>
                            <div class="col-lg-10">
                                <select class="form-control" id='choixPageInsta' style="max-width: 300px;" required>
                                    <option value="" data-nom=""></option>
                                    <?php
                                        echo $selectPageInsta;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label for="example-date-input" class="col-lg-2 col-form-label">Mois 1</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="month" id="dateDebut" style="max-width: 300px;" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Generer PowerPoint
                            <section>
                                <progress value="0" max="100" id="progress_bar"></progress>
                            </section>
                        </button>
                    </form>
                    <div id="erreur"></div>

                    <div class="card mb-3 mt-2">
                        <div class="card-header">
                            <i class="fas fa-chart-area"></i>
                            Nombre d'interaction par post</div>
                        <div class="card-body audience">
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
                            </div>`;
                            return alert;
                        }
                        function formatterDateAPI(date) {
                            return date.getFullYear() + '-' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));
                        }
                        function formatterDate(date) {
                            return ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear() + ' ' + date.getHours() + 'h' +  ((date.getMinutes() > 9) ? date.getMinutes() : ('0' + date.getMinutes()));
                        }
                        $('#bilan').submit(function (e) {
                            e.preventDefault();
                            $('#erreur').html('');
                            $("#progress_bar").val("0");
                            //on réinitialise le contenu de le l'HTML contenant le canvas, évitant un bug d'affichage
                            $("#chartdiv").html('');
                            $("#myAreaChart2").remove();
                            $(".audience").append('<canvas id="myAreaChart2" width="100%" height="30"></canvas>');

                            var idPageInsta = $('#choixPageInsta').val();
                            var nomPageInsta = $('#choixPageInsta').find('option:selected').data('nom');

                            var token = $('#choixPageInsta').find('option:selected').data('value');

                            var mois = $('#dateDebut').val();
                            mois = new Date(mois);

                            var tabMois = [];
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

                                var dateFin = new Date(mois.getFullYear(), mois.getMonth() + index + 1, 0);
                                var dateUntil = formatterDateAPI(dateFin);

                                tabMois[index].mois = nomMois;
                                tabMois[index].dateDebut = dateDebut;
                                tabMois[index].dateSince = dateSince;
                                tabMois[index].dateFin = dateFin;
                                tabMois[index].dateUntil = dateUntil;

                            }
                            console.log(tabMois);
                            
                            $.get(`https://graph.facebook.com/v8.0/${idPageInsta}?fields=id,media{id,caption,like_count,media_type,comments_count,thumbnail_url,media_url,timestamp}&access_token=${token}`, function (data) {
                                var tabDateMedia = [];
                                var tabEngagementMedia = [];
                                var nbMediaTrimestre = 0;
                                var totalInteractionTrimestre = 0;
                                var totalReachTrimestre = 0
                                var totalImpressionTrimestre = 0;
                                var trimestre = [];
                                var tabPost = [];
                                data.media.data.reverse();
                                data.media.data.forEach(media => {
                                    var dateMedia = new Date(media.timestamp);
                                    if (dateMedia >= tabMois[0].dateDebut && dateMedia <= tabMois[2].dateFin) {
                                        nbMediaTrimestre++;
                                        media.date = formatterDate(dateMedia)
                                        tabDateMedia.push(media.date);
                                        tabEngagementMedia.push(media.like_count + media.comments_count);
                                        totalInteractionTrimestre += media.like_count + media.comments_count;
                                        var idMedia = media.id;
                                        switch (media.media_type) {
                                            case 'VIDEO':
                                                media.media_url = media.thumbnail_url;
                                                var url =`https://graph.facebook.com/v8.0/${idMedia}/insights?metric=impressions,reach,engagement,video_views&access_token=${token}`;
                                                break;
                                        
                                            default:
                                                var url =`https://graph.facebook.com/v8.0/${idMedia}/insights?metric=impressions,reach,engagement&access_token=${token}`;
                                                break;
                                        }
                                        $.ajax({
                                            type: "GET",
                                            url: url,
                                            async: false,
                                            dataType: "json",
                                            success: function (response) {
                                                media.impression = response.data[0].values[0].value
                                                totalImpressionTrimestre += response.data[0].values[0].value
                                                media.reach = response.data[1].values[0].value
                                                totalReachTrimestre += response.data[1].values[0].value
                                                media.interaction = response.data[2].values[0].value
                                                media.TauxInteraction = ((media.interaction / media.reach)*100).toFixed(2);
                                                if (response.data.length == 4) {
                                                    media.nbVueVideo = response.data[3].values[0].value
                                                }
                                            }
                                        });
                                        tabPost.push(media);
                                    }
                                });
                                if (nbMediaTrimestre == 0) {
                                    $('#erreur').html(msgErreur('Aucun post trouvé dans ce mois'));
                                } else {
                                    trimestre.nbMedia = nbMediaTrimestre;
                                    trimestre.totalInteraction = totalInteractionTrimestre;
                                    trimestre.totalReach = totalReachTrimestre;
                                    trimestre.totalImpression = totalImpressionTrimestre;
                                    trimestre.totalFollowerGagne = 0;
                                    $("#progress_bar").val("10");
                                    /* Tableau top 3 interaction */
                                    var tabInteraction = [...tabPost];
                                    tabInteraction.sort((a,b) => (b.interaction/b.reach) - (a.interaction/a.reach));
                                    tabInteraction = tabInteraction.slice(0,3);

                                    /* Tableau top 3 reach */
                                    var tabReach = [...tabPost];
                                    tabReach.sort((a,b) => b.reach - a.reach);
                                    tabReach = tabReach.slice(0,3);

                                    /* top 1 post */
                                    var topMedia = [...tabPost];
                                    topMedia.sort((a,b) => b.reach - a.reach || b.interaction - a.interaction);
                                    topMedia = topMedia[0];

                                    /* Tableau top 3 flop reach */
                                    var flopReach = [...tabPost];
                                    flopReach.sort((a,b) => a.reach - b.reach);
                                    flopReach = flopReach.slice(0,3);

                                    //on défini l'échelle maximale de notre graphique
                                    var max = Math.ceil(Math.max(...tabEngagementMedia)) + 5;
                                    var ctx = document.getElementById("myAreaChart2");

                                    var myLineChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: tabDateMedia,
                                            datasets: [{
                                                label: "Engagement",
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
                                                data: tabEngagementMedia,
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
                                    $("#progress_bar").val("20");
                                    $.get(`https://graph.facebook.com/v4.0/${idPageInsta}/insights/audience_gender_age/lifetime?&access_token=${token}`,function (data) {
                                        
                                        function verifValeur(params) {
                                            if (typeof params === 'number') {
                                                return params
                                            } else {
                                                return 0
                                            }
                                        }

                                        totalFans = 0;
                                        totalFans += verifValeur(data.data[0].values[0].value["F.13-17"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.18-24"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.25-34"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.35-44"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.45-54"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.55-64"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["F.65+"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.13-17"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.18-24"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.25-34"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.35-44"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.45-54"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.55-64"]);
                                        totalFans += verifValeur(data.data[0].values[0].value["M.65+"]);
                                        
                                        femme13 = verifValeur(data.data[0].values[0].value["F.13-17"]);
                                        femme18 = verifValeur(data.data[0].values[0].value["F.18-24"]);
                                        femme25 = verifValeur(data.data[0].values[0].value["F.25-34"]);
                                        femme35 = verifValeur(data.data[0].values[0].value["F.35-44"]);
                                        femme45 = verifValeur(data.data[0].values[0].value["F.45-54"]);
                                        femme55 = verifValeur(data.data[0].values[0].value["F.55-64"]);
                                        femme65 = verifValeur(data.data[0].values[0].value["F.65+"]);
                                        homme13 = verifValeur(data.data[0].values[0].value["M.13-17"]);
                                        homme18 = verifValeur(data.data[0].values[0].value["M.18-24"]);
                                        homme25 = verifValeur(data.data[0].values[0].value["M.25-34"]);
                                        homme35 = verifValeur(data.data[0].values[0].value["M.35-44"]);
                                        homme45 = verifValeur(data.data[0].values[0].value["M.45-54"]);
                                        homme55 = verifValeur(data.data[0].values[0].value["M.55-64"]);
                                        homme65 = verifValeur(data.data[0].values[0].value["M.65+"]);

                                        am4core.ready(function() {

                                            // Themes begin
                                            am4core.useTheme(am4themes_animated);
                                            // Themes end

                                            // Create chart instance
                                            var chart = am4core.create("chartdiv", am4charts.XYChart);

                                            // Add data
                                            chart.data = [{
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
                                            }];

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
                                            maleRange.label.text = "Femme";
                                            maleRange.label.fill = chart.colors.list[0];
                                            maleRange.label.dy = 20;
                                            maleRange.label.fontWeight = '600';
                                            maleRange.grid.strokeOpacity = 1;
                                            maleRange.grid.stroke = male.stroke;

                                            var femaleRange = valueAxis.axisRanges.create();
                                            femaleRange.value = 0;
                                            femaleRange.endValue = 10;
                                            femaleRange.label.text = "Homme";
                                            femaleRange.label.fill = chart.colors.list[1];
                                            femaleRange.label.dy = 20;
                                            femaleRange.label.fontWeight = '600';
                                            femaleRange.grid.strokeOpacity = 1;
                                            femaleRange.grid.stroke = female.stroke;

                                        }); 
                                        $("#progress_bar").val("40");
                                    });
                                    
                                    tabMois.forEach((mois,index) => {
                                        $.get(`https://graph.facebook.com/v8.0/${idPageInsta}?fields=id,media{id,caption,like_count,media_type,comments_count,thumbnail_url,media_url,timestamp}&access_token=${token}`,
                                            function (data, textStatus, jqXHR) {
                                                var nbMediaMensuel = 0;
                                                var totalInteractionMensuel = 0;
                                                var totalReachMensuel = 0
                                                var totalImpressionMensuel = 0;
                                                var followergagneMensuel = 0;
                                                data.media.data.reverse();
                                                data.media.data.forEach(media => {
                                                    var dateMedia = new Date(media.timestamp);
                                                    if (dateMedia >= mois.dateDebut && dateMedia <= mois.dateFin) {
                                                        nbMediaMensuel++;
                                                        var idMedia = media.id;
                                                        var url =`https://graph.facebook.com/v8.0/${idMedia}/insights?metric=impressions,reach,engagement&access_token=${token}`;
                                                        $.ajax({
                                                            type: "GET",
                                                            url: url,
                                                            async: false,
                                                            dataType: "json",
                                                            success: function (response) {
                                                                totalImpressionMensuel += response.data[0].values[0].value
                                                                totalReachMensuel += response.data[1].values[0].value
                                                                totalInteractionMensuel += response.data[2].values[0].value
                                                                $.ajax({
                                                                    type: "GET",
                                                                    async: false,
                                                                    url: `https://graph.facebook.com/v4.0/${idPageInsta}/insights?metric=follower_count,reach,impressions&period=day&since=${mois.dateSince}&until=${mois.dateUntil}&access_token=${token}`,
                                                                    dataType: "json",
                                                                    success: function (response) {
                                                                        response.data[0].values.forEach(element => {
                                                                            followergagneMensuel += element.value
                                                                            trimestre.totalFollowerGagne += element.value
                                                                        });
                                                                        
                                                                    }
                                                                });
                                                            }
                                                        });
                                                    }
                                                });
                                                mois.nbMediaMensuel = nbMediaMensuel;
                                                mois.totalInteractionMensuel = totalInteractionMensuel;
                                                mois.totalReachMensuel = totalReachMensuel;
                                                mois.totalImpressionMensuel = totalImpressionMensuel;   
                                                mois.totalFollowerGagneMensuel = followergagneMensuel; 
                                                mois.tauxInteraction = ((totalInteractionMensuel / totalReachMensuel)*100).toFixed(2)
                                            }

                                        );
                                    });

                                    var donneesPowerPoint = [];
                                    donneesPowerPoint.trimestre = trimestre;
                                    donneesPowerPoint.mois = tabMois
                                    donneesPowerPoint.topPostMois = topMedia;
                                    donneesPowerPoint.top3ReachMois = tabReach;
                                    donneesPowerPoint.top3Interaction = tabInteraction;
                                    donneesPowerPoint.top3FlopReach = flopReach;

                                    $("#progress_bar").val("60");

                                    function toDataURL(url, callback) {
                                        var xhr = new XMLHttpRequest();
                                        xhr.onload = function() {
                                            var reader = new FileReader();
                                            reader.onloadend = function() {
                                                callback(reader.result);
                                            }
                                            reader.readAsDataURL(xhr.response);
                                        };
                                        xhr.open('GET', url);
                                        xhr.responseType = 'blob';
                                        xhr.send();
                                    }
                                    var imageMeilleurPost = donneesPowerPoint.topPostMois.media_url;

                                    var imgTop1Interaction = donneesPowerPoint.top3Interaction[0].media_url;
                                    var imgTop2Interaction = '';
                                    var imgTop3Interaction = '';
                                    if (donneesPowerPoint.top3Interaction.length >= 2) {
                                        imgTop2Interaction = donneesPowerPoint.top3Interaction[1].media_url;
                                    }
                                    if (donneesPowerPoint.top3Interaction.length == 3) {
                                        imgTop3Interaction = donneesPowerPoint.top3Interaction[2].media_url;
                                    }
                                    
                                    var imgTop1Reach = donneesPowerPoint.top3ReachMois[0].media_url;
                                    var imgTop2Reach = '';
                                    var imgTop3Reach = '';
                                    if (donneesPowerPoint.top3ReachMois.length >= 2) {
                                        imgTop2Reach = donneesPowerPoint.top3ReachMois[1].media_url;
                                    }
                                    if (donneesPowerPoint.top3ReachMois.length >= 3) {
                                        imgTop3Reach = donneesPowerPoint.top3ReachMois[2].media_url;
                                    }
                                    
                                    var imgFlop1Reach = donneesPowerPoint.top3FlopReach[0].media_url;
                                    var imgFlop2Reach = '';
                                    var imgFlop3Reach = '';
                                    if (donneesPowerPoint.top3FlopReach.length >= 2) {
                                        imgFlop2Reach = donneesPowerPoint.top3FlopReach[1].media_url;
                                    }
                                    if (donneesPowerPoint.top3FlopReach.length >= 3) {
                                        imgFlop3Reach = donneesPowerPoint.top3FlopReach[2].media_url;
                                    }
                                    $("#progress_bar").val("70");
                                    toDataURL(imageMeilleurPost, function(imageMeilleurPost) {
                                        toDataURL(imgTop1Interaction, function(imgTop1Interaction) {
                                            toDataURL(imgTop2Interaction, function(imgTop2Interaction) {
                                                toDataURL(imgTop3Interaction, function(imgTop3Interaction) {
                                                    toDataURL(imgTop1Reach, function(imgTop1Reach) {
                                                        toDataURL(imgTop2Reach, function(imgTop2Reach) {
                                                            toDataURL(imgTop3Reach, function(imgTop3Reach) {
                                                                toDataURL(imgFlop1Reach, function(imgFlop1Reach) {
                                                                    toDataURL(imgFlop2Reach, function(imgFlop2Reach) {
                                                                        toDataURL(imgFlop3Reach, function(imgFlop3Reach) {
                                                                            //on initialise notre Powerpoint
                                                                            var pptx = new PptxGenJS();
                                                                            var slide = pptx.addSlide();
                                                                            
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
                                                                                        var img2 = new Image();
                                                                                        img2.src = "images/capture3.png";
                                                                                        var img3 = new Image();
                                                                                        img3.src = "images/bandeau1.png";
                                                                                        var img4 = new Image();
                                                                                        img4.src = "images/fin.png";
                                                                                        var img6 = new Image();
                                                                                        img6.src = "images/screen-page.png";
                                                                                        var img7 = new Image();
                                                                                        img7.src = "images/screen-post1.png";

                                                                                        //page de garde
                                                                                        slide.addImage({ path:img2.src, x:0, y:0, w:10, h:5.6 });

                                                                                        //page de garde
                                                                                        slide = pptx.addSlide();
                                                                                        slide.bkgd = 'f1bf00';
                                                                                        slide.addText( nomPageInsta ,  { x:'30%', y:'25%', w:4, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:45 });
                                                                                        slide.addText('PAGE Instagram',  { x:'35%', y:'40%', w:3, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:22 });
                                                                                        slide.addText('BILAN trimestriel',  { x:'30%', y:'57%', w:4, color:'FFFFFF', align: 'center', fontFace:'Avenir 85 Heavy', fontSize:30 });
                                                                                        slide.addText(donneesPowerPoint.mois[0].mois + ' / ' + donneesPowerPoint.mois[1].mois + ' / ' + donneesPowerPoint.mois[2].mois + ' 2020',  { x:'25%', y:'72%', w:5, color:'FFFFFF', fontFace:'Avenir 85 Heavy', align: 'center', fontSize:22 });


                                                                                        $("#progress_bar").val("85");
                                                                                        
                                                                                        //seconde page "LA PAGE FACEBOOK"
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addText([
                                                                                            { text:  ((donneesPowerPoint.trimestre.totalInteraction/donneesPowerPoint.trimestre.totalReach)*100).toFixed(2) + ' %', options: {bold:true, fontSize:12}},
                                                                                            { text: ' Taux d\'interaction moyen', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'15%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.trimestre.totalFollowerGagne.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' abonnés gagné', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'30%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text:  donneesPowerPoint.trimestre.nbMedia.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'45%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.trimestre.totalInteraction.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' interactions soit une moyenne de ', options: {}},
                                                                                            { text: (donneesPowerPoint.trimestre.totalInteraction/donneesPowerPoint.trimestre.nbMedia).toFixed(0) + '/post', options: {bold:true}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.trimestre.totalReach.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' reach total posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'75%', y:'80%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('LE COMPTE INSTAGRAM',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                        slide.addImage({ path:img6.src, x:"18%", y:"18%", w:"64%", h:"55%" });
                                                                                        
                                                                                        // 3eme paga 
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('CHIFFRES CLES',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                                                        slide.addText(donneesPowerPoint.mois[0].mois,  { x:'5%', y:'18%', w:'100%', color:'000000', fontSize:18 });
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[0].tauxInteraction + ' %', options: {bold:true, fontSize:12}},
                                                                                            { text: ' Taux d\'interaction', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'15%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[0].totalFollowerGagneMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' abonnés gagné', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'30%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[0].nbMediaMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'45%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        
                                                                                        if (donneesPowerPoint.mois[0].nbMediaMensuel == 0) {
                                                                                            slide.addText([
                                                                                                { text: donneesPowerPoint.mois[0].totalInteractionMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                                { text: ' interactions', options: {}},
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        } else {
                                                                                            slide.addText([
                                                                                                { text: donneesPowerPoint.mois[0].totalInteractionMensuel, options: {bold:true, fontSize:12}},
                                                                                                { text: ' interactions soit une moyenne de ', options: {}},
                                                                                                { text: Math.round(donneesPowerPoint.mois[0].totalInteractionMensuel / donneesPowerPoint.mois[0].nbMediaMensuel).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '/post', options: {bold:true}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        }
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[0].totalReachMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' reach total posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'75%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        

                                                                                        slide.addText(donneesPowerPoint.mois[1].mois,  { x:'5%', y:'45%', w:'100%', color:'000000', fontSize:18 });
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[1].tauxInteraction.toString() + ' %', options: {bold:true, fontSize:12}},
                                                                                            { text: ' Taux d\'interaction', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'15%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[1].totalFollowerGagneMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' abonnés gagné', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'30%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[1].nbMediaMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'45%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        if (donneesPowerPoint.mois[1].nbMediaMensuel == 0) {
                                                                                            slide.addText([
                                                                                                { text: donneesPowerPoint.mois[1].totalInteractionMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                                { text: ' interactions', options: {}},
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'25%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        } else {
                                                                                            slide.addText([
                                                                                                { text: donneesPowerPoint.mois[1].totalInteractionMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                                { text: ' interactions soit une moyenne de ', options: {}},
                                                                                                { text: Math.round(donneesPowerPoint.mois[1].totalInteractionMensuel / donneesPowerPoint.mois[1].nbMediaMensuel).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '/post', options: {bold:true}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        }
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[1].totalReachMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' reach total posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'75%', y:'52%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});


                                                                                        slide.addText(donneesPowerPoint.mois[2].mois,  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:18 });
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[2].tauxInteraction.toString() + ' %', options: {bold:true, fontSize:12}},
                                                                                            { text: ' Taux d\'interaction', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'15%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[2].totalFollowerGagneMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' abonnés gagné', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'30%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[2].nbMediaMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'45%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        if (donneesPowerPoint.mois[2].nbMediaMensuel == 0) {
                                                                                            slide.addText([
                                                                                                { text: donneesPowerPoint.mois[2].totalInteractionMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                                { text: ' interactions', options: {}},
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        } else {
                                                                                            slide.addText([
                                                                                                { text: donneesPowerPoint.mois[2].totalInteractionMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                                { text: ' interactions soit une moyenne de ', options: {}},
                                                                                                { text: Math.round(donneesPowerPoint.mois[2].totalInteractionMensuel / donneesPowerPoint.mois[2].nbMediaMensuel).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '/post', options: {bold:true}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'60%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        }
                                                                                        slide.addText([
                                                                                            { text: donneesPowerPoint.mois[2].totalReachMensuel.toString(), options: {bold:true, fontSize:12}},
                                                                                            { text: ' reach total posts', options: {}}
                                                                                        ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'75%', y:'79%', w:1, h:1, fill:'0088CC', line:'006699', lineSize:2 , fontSize:10, color:'FFFFFF'});
                                                                                        
                                                                                        
                                                                                        //quatrième page FOCUS FANS
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('FOCUS FANS',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                        slide.addImage({ data:img5.src, x:1, y:1, w:8, h:4 });

                                                                                        //cinquième page FOCUS LIKE
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('FOCUS LIKE',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                        slide.addImage({ data:img.src, x:0.2, y:1, w:6.1, h:2.5 });
                                                                                        slide.addImage({ path:img7.src, x:"67%", y:"18%", w:"28%", h:"42%" });
                                                                                        
                                                                                        //sixième page TOP POST
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('TOP POST',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                        slide.addText([
                                                                                                { text: 'TOP REACH', options: {}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'55%', y:'17%', w:2.2, h:0.4, fill:'0088CC', line:'006699', lineSize:2 , fontSize:13, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                                { text: 'TOP INTERACTION*', options: {}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'55%', y:'25%', w:2.2, h:0.4, fill:'0088CC', line:'006699', lineSize:2 , fontSize:13, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.topPostMois.date, options: {}}
                                                                                            ],  { x:'55%', y:'35%', w:'100%', color:'000000', fontSize:15 });
                                                                                        slide.addText('Thème : ',  { x:'55%', y:'40%', w:'100%', color:'000000', fontSize:15 });
                                                                                        slide.addText('Format : ',  { x:'55%', y:'45%', w:'100%', color:'000000', fontSize:15 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.topPostMois.comments_count == "" ? '0' : donneesPowerPoint.topPostMois.comments_count), options: {}},
                                                                                                { text: ' Commentaires', options: {bold:true}}
                                                                                            ],  { x:'55%', y:'50%', w:'100%', color:'000000', fontSize:15 });
                                                                                            slide.addText([
                                                                                                { text: (donneesPowerPoint.topPostMois.like_count == "" ? '0' : donneesPowerPoint.topPostMois.like_count), options : {}},
                                                                                                { text: ' Likes', options: {bold:true}}
                                                                                            ],  { x:'55%', y:'55%', w:'100%', color:'000000', fontSize:15 });
                                                                                            slide.addText([
                                                                                                { text:  (donneesPowerPoint.topPostMois.reach == "" ? '0' : donneesPowerPoint.topPostMois.reach), options: {}},
                                                                                                { text: ' Personnes atteintes', options: {bold:true}}
                                                                                            ],  { x:'55%', y:'60%', w:'100%', color:'0088CC', fontSize:15 });
                                                                                        slide.addText([
                                                                                                { text: donneesPowerPoint.topPostMois.TauxInteraction, options: {}},
                                                                                                { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                            ],  { x:'55%', y:'65%', w:'100%', color:'000000', fontSize:15 });

                                                                                        slide.addImage({ data:imageMeilleurPost, x:"10%", y:"18%", w:"40%", h:"65%" });

                                                                                        //septième page TOP 3 (taux d'interaction)
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('TOP 3',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                        slide.addText([
                                                                                                { text: 'Top intéraction', options: {}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'25%', y:'4%', w:2.5, h:0.3, fill:'0088CC', line:'006699', lineSize:2 , fontSize:15, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3Interaction[0].date, options: {}}
                                                                                            ],  { x:'5%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText('Thème : ',  { x:'5%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText('Format : ',  { x:'5%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3Interaction[0].comments_count == "" ? '0' : donneesPowerPoint.top3Interaction[0].comments_count), options: {}},
                                                                                                { text: ' Commentaires', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3Interaction[0].like_count == "" ? '0' : donneesPowerPoint.top3Interaction[0].like_count), options: {}},
                                                                                                { text: ' Likes', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3Interaction[0].reach == "" ? '0' : donneesPowerPoint.top3Interaction[0].reach), options: {}},
                                                                                                { text: ' Personnes atteintes', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: donneesPowerPoint.top3Interaction[0].TauxInteraction, options: {}},
                                                                                                { text: ' % Taux d\'interaction', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'84%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                            slide.addImage({ data:imgTop1Interaction, x:"5%", y:"18%", w:"22%", h:"39%" });
                                                                                        
                                                                                        if (donneesPowerPoint.top3Interaction.length >= 2) {
                                                                                            slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3Interaction[1].date, options: {}}
                                                                                            ],  { x:'40%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Thème : ',  { x:'40%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Format : ',  { x:'40%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3Interaction[1].comments_count == "" ? '0' : donneesPowerPoint.top3Interaction[1].comments_count), options: {}},
                                                                                                    { text: ' Commentaires', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3Interaction[1].like_count == "" ? '0' : donneesPowerPoint.top3Interaction[1].like_count), options: {}},
                                                                                                    { text: ' Likes', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3Interaction[1].reach == "" ? '0' : donneesPowerPoint.top3Interaction[1].reach), options: {}},
                                                                                                    { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: donneesPowerPoint.top3Interaction[1].TauxInteraction, options: {}},
                                                                                                    { text: ' % Taux d\'interaction', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'84%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                            
                                                                                            slide.addImage({ data:imgTop2Interaction, x:"40%", y:"18%", w:"22%", h:"39%" });
                                                                                        }
                                                                                        
                                                                                        if (donneesPowerPoint.top3Interaction.length >= 3) {
                                                                                            slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3Interaction[2].date, options: {}}
                                                                                            ],  { x:'75%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Thème : ',  { x:'75%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Format : ',  { x:'75%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3Interaction[2].comments_count == "" ? '0' : donneesPowerPoint.top3Interaction[2].comments_count), options: {}},
                                                                                                    { text: ' Commentaires', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3Interaction[2].like_count == "" ? '0' : donneesPowerPoint.top3Interaction[2].like_count), options: {}},
                                                                                                    { text: ' Likes', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3Interaction[2].reach == "" ? '0' : donneesPowerPoint.top3Interaction[2].reach), options: {}},
                                                                                                    { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'80%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: donneesPowerPoint.top3Interaction[2].TauxInteraction, options: {}},
                                                                                                    { text: ' % Taux d\'interaction', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'84%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                            
                                                                                            slide.addImage({ data:imgTop3Interaction, x:"75%", y:"18%", w:"22%", h:"39%" });
                                                                                        }
                                                                                        

                                                                                        
                                                                                        
                                                                                        //huitième page TOP 3 (personnes atteintes)
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('TOP 3',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                        slide.addText([
                                                                                                { text: 'Top reach', options: {}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'25%', y:'4%', w:2.5, h:0.3, fill:'0088CC', line:'006699', lineSize:2 , fontSize:15, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3ReachMois[0].date, options: {}}
                                                                                            ],  { x:'5%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText('Thème : ',  { x:'5%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText('Format : ',  { x:'5%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                    
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3ReachMois[0].comments_count == "" ? '0' : donneesPowerPoint.top3ReachMois[0].comments_count), options: {}},
                                                                                                { text: ' Commentaires', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3ReachMois[0].like_count == "" ? '0' : donneesPowerPoint.top3ReachMois[0].like_count), options: {}},
                                                                                                { text: ' Likes', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3ReachMois[0].reach == "" ? '0' : donneesPowerPoint.top3ReachMois[0].reach), options: {}},
                                                                                                { text: ' Personnes atteintes', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'80%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: donneesPowerPoint.top3ReachMois[0].TauxInteraction, options: {}},
                                                                                                { text: ' % Taux d\'interaction', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addImage({ data:imgTop1Reach, x:"5%", y:"18%", w:"22%", h:"39%" });

                                                                                        if (donneesPowerPoint.top3ReachMois.length >= 2) {
                                                                                            slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3ReachMois[1].date, options: {}}
                                                                                            ],  { x:'40%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Thème : ',  { x:'40%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Format : ',  { x:'40%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                            
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3ReachMois[1].comments_count == "" ? '0' : donneesPowerPoint.top3ReachMois[1].comments_count), options: {}},
                                                                                                    { text: ' Commentaires', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3ReachMois[1].like_count == "" ? '0' : donneesPowerPoint.top3ReachMois[1].like_count), options: {}},
                                                                                                    { text: ' Likes', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3ReachMois[1].reach == "" ? '0' : donneesPowerPoint.top3ReachMois[1].reach), options: {}},
                                                                                                    { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'80%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: donneesPowerPoint.top3ReachMois[1].TauxInteraction, options: {}},
                                                                                                    { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'84%', w:'100%', color:'000000', fontSize:10 });

                                                                                            slide.addImage({ data:imgTop2Reach, x:"40%", y:"18%", w:"22%", h:"39%" });

                                                                                        }
                                                                                        
                                                                                        if (donneesPowerPoint.top3ReachMois.length >= 3) {
                                                                                            slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3ReachMois[2].date, options: {}}
                                                                                            ],  { x:'75%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Thème : ',  { x:'75%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Format : ',  { x:'75%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                            
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3ReachMois[2].comments_count == "" ? '0' : donneesPowerPoint.top3ReachMois[2].comments_count), options: {}},
                                                                                                    { text: ' Commentaires', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3ReachMois[2].like_count == "" ? '0' : donneesPowerPoint.top3ReachMois[2].like_count), options: {}},
                                                                                                    { text: ' Likes', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3ReachMois[2].reach == "" ? '0' : donneesPowerPoint.top3ReachMois[2].reach), options: {}},
                                                                                                    { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'80%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: donneesPowerPoint.top3ReachMois[2].TauxInteraction,options: {}},
                                                                                                    { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'84%', w:'100%', color:'000000', fontSize:10 });

                                                                                            slide.addImage({ data:imgTop3Reach, x:"75%", y:"18%", w:"22%", h:"39%" });

                                                                                        }
                                                                                        



                                                                                        //neuvième page FLOP POST
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('FLOP POST',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });
                                                                                        slide.addText([
                                                                                                { text: 'Flop reach', options: {}}
                                                                                            ], { shape:pptx.shapes.RECTANGLE, align:'center', x:'35%', y:'4%', w:2.5, h:0.3, fill:'0088CC', line:'006699', lineSize:2 , fontSize:15, color:'FFFFFF'});
                                                                                        slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3FlopReach[0].date, options: {}}
                                                                                            ],  { x:'5%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText('Thème : ',  { x:'5%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText('Format : ',  { x:'5%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                        
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3FlopReach[0].comments_count == "" ? '0' : donneesPowerPoint.top3FlopReach[0].comments_count), options: {}},
                                                                                                { text: ' Commentaires', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3FlopReach[0].like_count == "" ? '0' : donneesPowerPoint.top3FlopReach[0].like_count), options: {}},
                                                                                                { text: ' Likes', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: (donneesPowerPoint.top3FlopReach[0].reach == "" ? '0' : donneesPowerPoint.top3FlopReach[0].reach), options: {}},
                                                                                                { text: ' Personnes atteintes', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'80%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                        slide.addText([
                                                                                                { text: donneesPowerPoint.top3FlopReach[0].TauxInteraction, options: {}},
                                                                                                { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                            ],  { x:'5%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                        slide.addImage({ data:imgFlop1Reach, x:"5%", y:"18%", w:"22%", h:"39%" });
                                                                                        if (donneesPowerPoint.top3FlopReach.length >=2) {
                                                                                            slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3FlopReach[1].date, options: {}}
                                                                                            ],  { x:'40%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Thème : ',  { x:'40%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Format : ',  { x:'40%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                            
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3FlopReach[1].comments_count == "" ? '0' : donneesPowerPoint.top3FlopReach[1].comments_count), options: {}},
                                                                                                    { text: ' Commentaires', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3FlopReach[1].like_count == "" ? '0' : donneesPowerPoint.top3FlopReach[1].like_count), options: {}},
                                                                                                    { text: ' Likes', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3FlopReach[1].reach == "" ? '0' : donneesPowerPoint.top3FlopReach[1].reach), options: {}},
                                                                                                    { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'80%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: donneesPowerPoint.top3FlopReach[1].TauxInteraction, options: {}},
                                                                                                    { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                ],  { x:'40%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                            
                                                                                            slide.addImage({ data:imgFlop2Reach, x:"40%", y:"18%", w:"22%", h:"39%" });
                                                                                        }
                                                                                        
                                                                                        if (donneesPowerPoint.top3FlopReach.length >=3) {
                                                                                            slide.addText([
                                                                                                { text: 'Date du post : ', options: {bold:true}},
                                                                                                { text: donneesPowerPoint.top3FlopReach[2].date, options: {}}
                                                                                            ],  { x:'75%', y:'60%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Thème : ',  { x:'75%', y:'64%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText('Format : ',  { x:'75%', y:'68%', w:'100%', color:'000000', fontSize:10 });
                                                                                            
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3FlopReach[2].comments_count == "" ? '0' : donneesPowerPoint.top3FlopReach[2].comments_count), options: {}},
                                                                                                    { text: ' Commentaires', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'72%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3FlopReach[2].like_count == "" ? '0' : donneesPowerPoint.top3FlopReach[2].like_count), options: {}},
                                                                                                    { text: ' Likes', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'76%', w:'100%', color:'000000', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: (donneesPowerPoint.top3FlopReach[2].reach == "" ? '0' : donneesPowerPoint.top3FlopReach[2].reach), options: {}},
                                                                                                    { text: ' Personnes atteintes', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'80%', w:'100%', color:'0088CC', fontSize:10 });
                                                                                            slide.addText([
                                                                                                    { text: donneesPowerPoint.top3FlopReach[2].TauxInteraction, options: {}},
                                                                                                    { text: '% Taux d\'interaction', options: {bold:true}}
                                                                                                ],  { x:'75%', y:'84%', w:'100%', color:'000000', fontSize:10 });
                                                                                            
                                                                                            slide.addImage({ data:imgFlop3Reach, x:"75%", y:"18%", w:"22%", h:"39%" });
                                                                                        }
                                                                                        
                                                                                        //dixième page CONCLUSION
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('CONCLUSION',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                                                        //onxième page CONCLUSION ET RECOMMANDATIONS
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img3.src, x:0, y:0, w:10, h:0.8 });
                                                                                        slide.addText('CONCLUSION ET RECOMMANDATIONS',  { x:'9%', y:'7%', w:'100%', color:'FFFFFF', fontFace:'Avenir 85 Heavy', fontSize:25 });

                                                                                        //douzième page FIN
                                                                                        slide = pptx.addSlide();
                                                                                        slide.addImage({ path:img4.src, x:0, y:0, w:'100%', h:'100%' });
                                                                                        slide.addText('Merci',  { x:'35%', y:'40%', w:3, color:'FFFFFF', align: 'center', fontFace:'Avenir 85 Heavy', fontSize:35 });
                                                                                        
                                                                                        $("#progress_bar").val("100");

                                                                                        //on enregistre le powerpoint
                                                                                        pptx.writeFile('bilan-reporting-Instagram ' + nomMois + ' ' + nomPageInsta);
                                                                                    }).catch(function (error) {
                                                                                        console.error('oops, something went wrong!', error);
                                                                                    });
                                                                                    //fin du 2eme domtoimage
                                                                                    
                                                                                }).catch(function (error) {
                                                                                    console.error('oops, something went wrong!', error);
                                                                                });
                                                                                //fin du 1er domtoimage
                                                                            });
                                                                            //fin de html2canvas
                                                                            
                                                                        //debut convertion image
                                                                        });
                                                                    });
                                                                });
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                    
                                }
                            });
                        });
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