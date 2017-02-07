// JSHint
/* global noty */

$(function () {
  'use strict';

  // Noty Defaults
  $.noty.defaults.layout  = 'topRight';
  $.noty.defaults.theme   = 'bootstrapTheme';
  $.noty.defaults.timeout = 7000;

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
    btn.find('.email-icon').addClass('hidden');
    btn.find('.loading-icon').removeClass('hidden');

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
        noty({
          text: 'Seu e-mail foi enviado com sucesso.',
          type: 'success'
        });
        form[0].reset();
      } else {
        noty({
          text: 'Ocorreu um erro no envio do seu e-mail. Tente novamente mais tarde.',
          type: 'error'
        });
      }
    }).fail(function () {
      noty({
        text: 'Ocorreu um erro no envio do seu e-mail. Tente novamente mais tarde.',
        type: 'error'
      });
    }).always(function () {
      btn.removeClass('disabled');
      btn.find('.email-icon').removeClass('hidden');
      btn.find('.loading-icon').addClass('hidden');
    });
  }

  $('#send').on('click', function (event) {
    event.preventDefault();
    sendEmail(event);
  });
});
