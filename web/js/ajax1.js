/**
 * Created by dev on 16/06/2015.
 */

$(document).ready(function() {
    console.log("jQuery est prêt !");

    setInterval(function checkSite() {
        $.post(
            '/app_dev.php/ajax/checkedTime',
            {},
            function checkUrlSite(reponse) {
                if(!reponse) {
                    console.log("fail no reponse check");
                } else {
                    console.log(reponse);

                    var idReponseBug = reponse[0];
                    var idReponseOk = reponse[1];

                    /* Count number of arg to one object :
                     Object.keys(idReponseBug).length; */

                    var rowCountBug = idReponseBug.length;
                    var rowCountOk = idReponseOk.length;

                    for (var i = 0; i < rowCountBug ; i++){

                        var idconstruc = '#'+ idReponseBug[i] +'';
                        $(idconstruc).addClass( "redError" );
                    }

                    for (var i = 0; i < rowCountOk ; i++){

                        var idconstruc = '#'+ idReponseOk[i] +'';
                        $(idconstruc).removeClass( "redError" );
                    }
                }
            },
            'json'
        );
    }, 3000);
});
/**
 * Created by dev on 22/06/2015.
 */
