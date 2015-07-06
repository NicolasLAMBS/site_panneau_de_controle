/**
 * Created by dev on 16/06/2015.
 */

$(document).ready(function() {
    console.log("jQuery du fichier ajax.js est prêt !");

    $("#form").on('submit', function(e) {

        $.post(
            $(this).attr('action'),
            {
                url: $("#form_url_id").val()
            },
            function listUrl(reponse) {
                $(form_url_id).removeClass( "redError" );

                if(!reponse) {

                    console.log("fail no reponse");
                    return false;
                }

                if (reponse == 'fail') {

                    console.log("fail url is wrong");
                    $(form_url_id).addClass( "redError" );
                    return false;
                }

                if (reponse ) {

                    console.log("gj");
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
});
