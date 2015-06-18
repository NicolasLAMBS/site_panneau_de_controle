/**
 * Created by dev on 16/06/2015.
 */

$(document).ready(function() {

    $("#form").on('submit', function(e) {

        $.post(
            $(this).attr('action'),
            {
                url: $("#form_url_id").val()
            },
            function listUrl(reponse) {

                if(!reponse) {
                    console.log("fail no reponse");
                } else {
                    console.log("gg");
                    console.log(reponse);
                    var urlreponse = reponse.urlreponse;
                    console.log(urlreponse);
                    var idreponse = reponse.idreponse;
                    console.log(idreponse);

                    $('#list_url').append("<li>" + urlreponse + " <button class=\"delete\" id=" + idreponse + " type=\"submit\"> Supprimer" + "</button></li>" );
                }
            },
            'json'
        );
        return false;
    });

    $("#list_url").on('click', 'button', function(e) {

        var iddelete = $(this).attr("id");

        $.post(
            '/app_dev.php/admin/ajax/delete',
            {
                id: iddelete
            },
            function deleteUrl(reponse) {
                if(reponse){

                    var idtestcc = '#'+iddelete+'';
                    $(idtestcc).parent().remove();
                } else{

                    console.log("fail remove");
                }
            },
            'json'
        );
        return false;
    });

    setInterval(function() {checkSite()}, 60000000);

    function checkSite() {
        $.post(
            '/app_dev.php/ajax/checkedTime',
            {},
            function checkUrlSite(reponse) {
                if(!reponse) {

                    console.log("fail no reponse check");
                } else {

                    var idreponse = reponse;
                    var rowCount = reponse.length;

                    for (var i = 0; i<= rowCount ; i++){

                        var idcontruc = '#'+ idreponse[i] +'';
                        $(idcontruc).addClass( "redError" );
                    }
                }
            },
            'json'
        );
    }
});
