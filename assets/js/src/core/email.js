/**
 * @file   email.js
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @author Matheus Cesario <matheus@institutosoma.org.br>
 */

/**
 * Barpedia
 * @namespace
 */
var Barpedia = Barpedia || {};

/**
 * Core
 *
 * @type {Object}
 */
Barpedia.Core = Barpedia.Core || {};

/**
 * Email
 *
 * @type {Object}
 */
Barpedia.Core.Email = (function () {

    'use strict';
    var

        /**
         * Cria o elemento feedback no canto direito da tela.
         * TODO: traduzir
         *
         * @return {void}
         */
        feedbackComponent = (function () {
            var feedback_component = $('#feedback-component'),
                form   = $('#feedback-form')[0],
                send   = $('#feedback-send'),
                handle = $('#handle-feedback');

            // Config
            feedback_component.tabSlideOut({
                tabHandle: '#handle-feedback',
                pathToTabImage: '/assets/images/sprites/feedback.png',
                tabLocation: 'right',
                speed: 300,
                action: 'click',
                imageHeight: '122px',
                imageWidth: '40px',
                topPos: '110px',
                fixedPosition: true
            });

            handle.css({
                'left': '0px',
                'top':  '-1px'
            });

            feedback_component.removeClass('hidden');

            setTimeout(function () {
                handle.css({
                    'left': '-41px',
                    'top':  '-1px'
                });
            }, 1000);

            // Focus
            handle.on('click', function () {
                form.reset();
                setFocus('feedback');
            });

            // Submit form
            send.on('click', function () {
                var err = checkFields('feedback'),
                    loader = feedback_component.find('.preloader');

                if (err.length) {
                    alert(Barpedia.Helpers.I18n.get('alert_feedback_form'));
                } else {
                    loader.removeClass('hidden');
                    sendFeedback();
                }
            });
        }()),

        /**
         * Ao abrir o componente de Reportar um problema,
         * define automaticamente o focus.
         * TODO: traduzir
         *
         * @return {void}
         */
        reportComponent = (function () {
            var report = $('#reportModal'),
                form   = $('#report-form')[0],
                send   = $('#report-send');

            report.on('shown.bs.modal', function (event) {
                setFocus('report');
            });

            send.on('click', function (event) {
                var err = checkFields('report');

                if (err.length) {
                    alert(Barpedia.Helpers.I18n.get('alert_feedback_form'));
                    console.log(err);
                } else {
                    sendReport();
                }
            });
        }()),

        /**
         * Oculta o formulário de Feedback.
         * TODO: traduzir
         *
         * @param  {void} form [description]
         * @return {void}
         */
        slideOut = function (form) {
            form.removeClass('open').animate({
                right: '-300px'
            }, 300);
        },

        /**
         * Seta o foco no elemento dinamicamente.
         *
         * Define o focus no elemento nome caso o usuário
         * não esteja logado ou no elemento mensagem caso esteja.
         *
         * É utilizado o atributo readonly do HTML5 para
         * realizar a verificação no input.
         *
         * TODO: traduzir
         *
         * @param {String} type [description]
         */
        setFocus = function (type) {
            var nome = $('#' + type + '-nome'),
                mensagem = $('#' + type + '-mensagem');

            if (nome.prop('readonly')) {
                mensagem.focus();
            } else {
                nome.focus();
            }
        },

        /**
         * Valida os campos do formulário antes de submeter a requisição.
         * TODO: traduzir
         *
         * @param  {String} type Define se é um feedback ou report.
         * @return {Array}       Retorna um array com os campos vazios.
         */
        checkFields = function (type) {
            var nome = $('#' + type + '-nome'),
                email = $('#' + type + '-email'),
                mensagem = $('#' + type + '-mensagem'),
                err = [];

            if (!nome.val().length) {
                err.push('Campo nome vazio.');
            }

            if (!email.val().length) {
                err.push('Campo e-mail vazio.');
            }

            if (!mensagem.val().length) {
                err.push('Campo mensagem vazio.');
            }

            return err;
        },

        /**
         * Envia um e-mail com os dados obtidos na caixa
         * Feedback e salva os dados na tabela Feedback
         * caso o envio ocorra com sucesso.
         * TODO: traduzir
         *
         * @return {void}
         */
        sendFeedback = function () {
            var component= $('#feedback-component'),
                form     = $('#feedback-form'),
                nome     = $('#feedback-nome'),
                email    = $('#feedback-email'),
                mensagem = $('#feedback-mensagem'),
                preloader   = form.find('.preloader');

            $.ajax({
                url: '/feedback/send',
                beforeSend: function () { preloader.removeClass('hidden'); },
                complete:   function () { preloader.addClass('hidden');    },
                data: {
                    fbid_user: nome.data('fbid'),
                    id_user: nome.data('uid'),
                    nome: nome.val(),
                    email: email.val(),
                    mensagem: mensagem.val(),
                    type: 'feedback'
                }
            }).done(function (response) {
                var result = $('#feedback-result'),
                    result_ok = $('#feedback-result-ok'),
                    result_error = $('#feedback-result-error');

                if (response === true) {
                    result_ok.removeClass('hidden');
                    setTimeout(function () {
                        form[0].reset();
                        result_ok.addClass('hidden');
                        slideOut(component);
                    }, 1000);
                } else {
                    result_error.removeClass('hidden');
                    setTimeout(function () {
                        result_error.addClass('hidden');
                    }, 1000);
                }
            });
        },

        /**
         * Envia um e-mail com dados obtidos na caixa
         * Reportar um problema e salva os dados na tabela
         * Feedback caso o envio ocorra com sucesso.
         * TODO: traduzir
         *
         * @return {void}
         */
        sendReport = function () {
            var modal    = $('#reportModal'),
                form     = $('#report-form')[0],
                nome     = $('#report-nome'),
                email    = $('#report-email'),
                mensagem = $('#report-mensagem'),
                url      = $('#report-url'),
                preloader= modal.find('.preloader');

            $.ajax({
                url: '/feedback/send',
                beforeSend: function () { preloader.removeClass('hidden'); },
                complete: function ()   { preloader.addClass('hidden');    },
                data: {
                    fbid_user: nome.data('fbid'),
                    id_user: nome.data('uid'),
                    nome: nome.val(),
                    email: email.val(),
                    mensagem: mensagem.val(),
                    url: url.val(),
                    type: 'report'
                }
            }).done(function (response) {
                var result = $('#report-result'),
                    result_ok = $('#report-result-ok'),
                    result_error = $('#report-result-error');

                if (response === true) {
                    result_ok.removeClass('hidden');
                    setTimeout(function () {
                        form.reset();
                        result_ok.addClass('hidden');
                        modal.modal('hide');
                    }, 1000);
                } else {
                    result_error.removeClass('hidden');
                    setTimeout(function () {
                        result_error.addClass('hidden');
                    }, 1000);
                }
            });
        };

    return {
        feedbackComponent: feedbackComponent,
        reportComponent: reportComponent,
        slideOut: slideOut,
        setFocus: setFocus,
        checkFields: checkFields,
        sendFeedback: sendFeedback,
        sendReport: sendReport,
    };

}());
