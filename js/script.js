function recuperationDesInsights(id,pos,token){

    var monUrl2 = 'https://graph.facebook.com/v4.0/' + id + '/insights/post_clicks_unique,post_impressions_unique?access_token=' + token;
    $.ajax(
        {
            url : monUrl2,
            async: false,
            complete :
            function(xhr, textStatus){
                var response = JSON.parse(xhr.responseText);
                var htm = "";
                htm +=    '<p>' + response.data[0].values[0].value + ' <strong>Clics</strong></p>';
                htm +=    '<p>' + response.data[1].values[0].value + ' <strong>Personnes atteintes</strong></p>';

                $( "#post" + pos + "" ).append( htm );
            } 
                        
        }
    );
}


function getAccessTokenPages(token, idPage, pos){
    var monUrl2 = 'https://graph.facebook.com/me/accounts?access_token=' + token;
    console.log(monUrl2);
    $.ajax({
        url : monUrl2,
        complete :
        function(xhr){
            var response = JSON.parse(xhr.responseText);
            response.data.forEach(page => {
                if (page.id == idPage.substr(0,15)) {
                    var tokenPage = page.access_token;
                    recuperationDesInsights(idPage,pos,tokenPage);
                }
            });
        }
             
    });
}