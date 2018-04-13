/**
 * Function for displaying a message
 * @param {String} message
 * @param {String} type
 * @returns {void}
 */
function showFlashMessage(message, type)
{
    var html = '<div class="alert alert-' + type + '">';
    html += '<button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>';
    html += message + '</div>';

    $('#message').html(html);

    setTimeout( function() { $('.alert').hide('slow'); } , 10000);
}