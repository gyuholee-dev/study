$(document).ready(()=>{

    $('#partner').click(() => {
        $('#partner_up').addClass('active');
        /* if (!$('#partner_up').hasClass('active')) {
            $('#partner_up').addClass('active');
        } else {
            $('#partner_up').removeClass('active');
        }  */
    });

    $('#partner_up .close').click(() => {
        $('#partner_up').removeClass('active');
    });

});