/**
 * Created by dev on 16/06/2015.
 */

$(document).ready(function(){

    $(".form_save_id").click(function(e) {
        e.preventDefault();

        //var data = $(".form_url_id").val();

        $.post(
            '@UserBundle/Controller/AdminController.php',
            {
                data :$(".form_url_id").val()
            },
            'show_url',
            'json'
        );

        function show_url(data_return){
            if(data_return == 'Success'){

            } else{

            }
        }
    })
})
