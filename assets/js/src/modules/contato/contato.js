$(function () {
  'use strict';
  
  /**
   * Send an e-mail with the data from contact form
   * in landing page.
   *
   * @return {void}
   */
  function sendEmail (event) {
    var form  = $('#contact-form'),
      name    = $('#name'),
      email   = $('#email'),
      message = $('#message'),
      btn     = $(event.target);

    if (btn.is('span')) {
      btn = btn.parents('.btn');
    }

    btn.addClass('disabled');
    btn.find('.ion-ios-email-outline').addClass('hidden');
    btn.find('.ion-load-c').removeClass('hidden');

    $.ajax({
      url: '/contato/send',
      type: 'post',
      dataType: 'json',
      data: {
        name:    name.val(),
        email:   email.val(),
        message: message.val()
      }
    }).done(function (response) {
      if (response) {
        window.noty({
          text: 'Seu e-mail foi enviado com sucesso.',
          type: 'success'
        });
        form[0].reset();
      } else {
        window.noty({
          text: 'Ocorreu um erro no envio do seu e-mail. Tente novamente mais tarde.',
          type: 'error'
        });
      }
    }).fail(function () {
      window.noty({
        text: 'Ocorreu um erro no envio do seu e-mail. Tente novamente mais tarde.',
        type: 'error'
      });
    }).always(function () {
      btn.removeClass('disabled');
      btn.find('.ion-ios-email-outline').removeClass('hidden');
      btn.find('.ion-load-c').addClass('hidden');
    });
  }

  $('#send').on('click', function (event) {
    event.preventDefault();
    sendEmail(event);
  });
});
