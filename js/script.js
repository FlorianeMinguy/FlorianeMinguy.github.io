// -------------------------------------------------------------------------------------
// AJAX : avec JQuery
// -------------------------------------------------------------------------------------
$(function(){
  $('#contact-form').submit(function(e){
    e.preventDefault();
    $('.comments').empty();
    let postdata = $('#contact-form').serialize();

    // AJAX : on transmet un objet JSON avec les caractéristiques de la requête AJAX :
    $.ajax({
      type: 'POST', // quel type de requête envoyer
      url: 'php/contact.php',// vers quelle url envoyer cette data
      data: postdata, // quelle data envoyer
      dataType: 'json',
      success: function(result){
        
        if(result.isSuccess){
          $('#contact-form').append("<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>");
          $('#contact-form')[0].reset();
        } else {
          $('#firstname + .comments').html(result.firstnameError);
          $('#name + .comments').html(result.nameError);
          $('#email + .comments').html(result.emailError);
          $('#phone + .comments').html(result.phoneError);
          $('#message + .comments').html(result.messageError);
        }
      }
    });
  });
});