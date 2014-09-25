 /**
 * @file   typeahead.js
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @author Matheus Cesario <matheus@institutosoma.org.br>
 */

/**
 * Barpedia
 * @namespace
 */
var Barpedia = Barpedia || {};

/**
 * Components
 *
 * @type {Object}
 */
Barpedia.Components = Barpedia.Components || {};

/**
 * Typeahead
 *
 * @type {Object}
 */
Barpedia.Components.Typeahead = (function () {

    'use strict';
    var

        /**
         * Cache of Barpedia element.
         *
         * @type {Object}
         */
        i18n             = Barpedia.Helpers.I18n,
        scripts          = Barpedia.Helpers.Scripts,
        sorry_no_results = i18n.get('sorry_no_results'),

        /**
         * Input que seleciona cidades
         *
         * @return input typeahead.js com cidades para seleção; eventos de clique e keyup
         */
        cities = function () {
            var cidadeAtual = $('#cidade-atual'),
                position = cidadeAtual.parents('ul').position(),
                novaCidade = $('#nova-cidade'),
                preloader = $('#nova-cidade-preloader'),
                typeaheadForm = $('#typeahead-form'),
                uri = '',
                datasetPath = '/assets/data/cidades.json',
                componentClicked = false,

                // Criando objeto BloodHound para popular typeAhead
                cidades = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'), // Define chave de busca
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    limit: 7,
                    prefetch: {
                        url: datasetPath
                    },
                    remote: {
                        url: '/cities/loadCities?q=%QUERY',
                        ajax: {
                            beforeSend: function () {
                                preloader.removeClass('hidden');
                            },
                            complete: function () {
                                preloader.addClass('hidden');
                            }
                        }
                    }
                });

            cidades.initialize();

            // Inicializando typeahead
            novaCidade.typeahead({
                autoselect: true,
                highlight: true,
                minLength: 1,
                hint: true,
                limit: 7
            }, {
                name: 'Cidades',
                displayKey: Handlebars.compile('{{cidade}}, {{alt_estado}}'),
                source: cidades.ttAdapter(),
                templates: {
                    'suggestion': Handlebars.compile([
                        '<div class="row">',
                        '<div class="col-xs-1 no-padding-right">',
                        '<a href="{{uri}}">',
                        '<span class="flag flag16 {{iso_pais}}"></span>',
                        '</a>',
                        '</div>',
                        '<div class="col-xs-8 no-padding-left no-padding-right">',
                        '<a href="{{uri}}">',
                        '<span class="name">',
                        '{{alt_cidade}}, {{alt_estado}}, {{alt_pais}}',
                        '</span>',
                        '<span class="location">{{cidade}}, {{estado}}, {{pais}}</span>',
                        '</a>',
                        '</div>',
                        '<div class="col-xs-3 no-padding-left text-right">',
                        '<a href="{{uri}}">',
                        '<span class="count">{{usuarios}} <small>usuários</small></span>',
                        '</a>',
                        '</div>',
                        '</div>'
                    ].join(''))
                }
            });

            // Eventos
            // Se clicar fora, esconde o input
            $(document).on('click', function (event) {
                if (cidadeAtual.data('isopen') && !componentClicked) {
                    hideTypeaheadForm();
                } else {
                    componentClicked = false;
                }
            });

            // Esconde e exibe componente de busca de cidade (form typeahead)
            var hideTypeaheadForm = function () {
                    typeaheadForm.addClass('hidden');
                    cidadeAtual.data('isopen', false);
                },
                showTypeAheadForm = function () {
                    typeaheadForm.css({
                        top: position.top + 52,
                        left: position.left
                    }); // Posiciona form
                    typeaheadForm.removeClass('hidden'); // Exibe
                    cidadeAtual.data('isopen', true); // Atualiza seu estado
                };

            // Ao clicar no link cidade atual, exibe input para efetuar buscas
            cidadeAtual.on('click', function () {
                componentClicked = true; // Sinaliza click em componente do typeahead

                // Simula toggle (fechar)
                if (cidadeAtual.data('isopen')) {
                    hideTypeaheadForm();
                } else {
                    showTypeAheadForm();
                    novaCidade.val('');
                    novaCidade.focus();
                }
            });

            // Click no input.text do typeahead
            novaCidade.on('click', function () {
                componentClicked = true; // Sinaliza click em componente do typeahead
            });

            // Selecionando cidade na lista
            novaCidade.on('typeahead:selected', function (event, suggestion, dataset) {
                uri = suggestion.uri; // Armazena Url da cidade
                window.location = uri;
            });

            // Se autocompletar a consulta, atualiza seu link
            novaCidade.on('typeahead:autocompleted', function (event, suggestion, dataset) {
                uri = suggestion.uri;
            });

            // Teclas especiais
            novaCidade.on('keyup', function (event) {
                switch (event.which) {
                case 13:
                    if (uri !== '') {
                        window.location = uri;
                    }
                    break;
                case 27: // Esc: esconde form
                    hideTypeaheadForm();
                    break;
                }
            });

            // Se a página perder o foco, o input estiver aberto e não clicado
            window.onblur = function (event) {
                hideTypeaheadForm();
            };
        },

        /**
         * Constrói objeto Bloodhound para ser consumido
         *
         * @param {Object} dataset Dados com informações a serem buscadas e exibidas
         */
        setBloodHoundObject = function (dataset) {
            var preloader = $('#search-feature-preloader'),
                bhObj = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: dataset,
                remote: {
                    url: ' ',
                    ajax: {
                        beforeSend: function () {
                            if (dataset) {
                                preloader.removeClass('hidden');
                            }
                        },
                        complete: function () {
                            setTimeout(function () {
                                preloader.addClass('hidden');
                            }, 300);
                        }
                    }
                }
            });

            bhObj.initialize();
            return bhObj;
        },

        /**
         * Popula com dados o typeahead no header, com informações
         * dos bares, usuários, cardápios e eventos da cidade.
         *
         * @return {void}
         */
        populate = function () {
            var url = '',
                searchFeature = $('#search-feature'),
                baresObject,
                eventsObject,
                menuObject,
                usersObject;

            getDataByCity('Bars', function (data) {
                baresObject = data;
            });

            getDataByCity('Events', function (data) {
                eventsObject = data;
            });

            getDataByCity('MenuItems', function (data) {
                menuObject = data;
            });

            getDataByCity('Users', function (data) {
                usersObject = data;
            });

            setTimeout(function () {
                searchFeature.typeahead({
                    autoselect: true,
                    highlight: true,
                    minLength: 1,
                    hint: true
                }, {
                    name: 'bares',
                    displayKey: 'name',
                    source: setBloodHoundObject(baresObject).ttAdapter(),
                    templates: {
                        'header': '<h6>Bares</h6>',
                        'empty': '<div class="row"><div class="col-xs-12"><span class="no-results">' + sorry_no_results + '</span></div></div>',
                        'suggestion': Handlebars.compile([
                            '<div class="row">',
                            '<div class="col-xs-2 no-padding-right">',
                            '<a href="{{url}}">',
                            '<img src="/image/bares/{{image_source}}/48/48" width="48" height="48" class="pull-left thumbnail thumbnail-bar">',
                            '</a>',
                            '</div>',
                            '<div class="col-xs-7 bar-info no-padding-left no-padding-right">',
                            '<a href="{{url}}">',
                            '<span class="name no-margin-left">{{name}}</span>',
                            '<span class="location no-margin-left">{{address}}</span>',
                            '</a>',
                            '</div>',
                            '<div class="col-xs-3 bar-info no-padding-left text-right">',
                            '<a href="{{url}}">',
                            '<span class="bar-rate" data-toggle="tooltip" data-placement="left" title="{{rateText}}">',
                            '<span class="beer beer-{{rateClass}}"></span>',
                            '<span class="label label-warning">{{rate}}</span>',
                            '</span>',
                            '</a>',
                            '</div>',
                            '</div>'
                        ].join(''))
                    }
                }, {
                    name: 'eventos',
                    displayKey: 'name',
                    source: setBloodHoundObject(eventsObject).ttAdapter(),
                    templates: {
                        'header': '<h6>Eventos</h6>',
                        'empty': '<div class="row"><div class="col-xs-12"><span class="no-results">' + sorry_no_results + '</span></div></div>',
                        'suggestion': Handlebars.compile([
                            '<a href="{{url}}" target="_blank">',
                            '{{name}}',
                            '</a>'
                        ].join(''))
                    }
                }, {
                    name: 'cardapio',
                    displayKey: 'name',
                    source: setBloodHoundObject(menuObject).ttAdapter(),
                    templates: {
                        'header': '<h6>Cardápio</h6>',
                        'empty': '<div class="row"><div class="col-xs-12"><span class="no-results">' + sorry_no_results + '</span></div></div>',
                        'suggestion': Handlebars.compile([
                            '<a href="#">',
                            '{{name}} <span class="pull-right">{{info}}</span>',
                            '</a>'
                        ].join(''))
                    }
                }, {
                    name: 'usuarios',
                    displayKey: 'name',
                    source: setBloodHoundObject(usersObject).ttAdapter(),
                    templates: {
                        'header': '<h6>Usuários</h6>',
                        'empty': '<div class="row"><div class="col-xs-12"><span class="no-results">' + sorry_no_results + '</span></div></div>',
                        'suggestion': Handlebars.compile([
                            '<div class="row">',
                            '<div class="col-xs-1">',
                            '<a href="{{url}}" target="_blank">',
                            '<img src="{{thumbnail}}"',
                            ' class="thumbnail thumbnail-user"',
                            ' width="32"',
                            ' height="32" />',
                            '</a>',
                            '</div>',
                            '<div class="col-xs-9 no-padding-right">',
                            '<a href="{{url}}" target="_blank">',
                            '<span class="name">{{name}}</span>',
                            '</a>',
                            '</div>',
                            '<div class="col-xs-2 no-padding-left">',
                            '<a href="{{url}}" target="_blank">',
                            '<span class="count">{{info}} <small>pontos</small></span>',
                            '</a>',
                            '</div>',
                            '</div>'
                        ].join(''))
                    }
                });
            }, 1500);

            // Selecionando cidade na lista
            searchFeature.on('typeahead:selected', function (event, suggestion, dataset) {
                // Armazena Url da cidade
                url = suggestion.url;

                if (url.indexOf('facebook.com') == -1) {
                    window.location = url;
                } else {
                    var newWindow = window.open('about:blank');
                    newWindow.location.replace(url);
                }
            });

            // Se autocompletar a consulta, atualiza seu link
            searchFeature.on('typeahead:autocompleted', function (event, suggestion, dataset) {
                url = suggestion.url;
            });

            searchFeature.on('typeahead:opened', function (event, suggestion, dataset) {
                console.log(searchFeature.siblings('.tt-dropdown-menu').val());
            });

            // Teclas especiais
            searchFeature.on('input', function (event) {
                if (event.which == 13 && url !== '') {
                    if (url.indexOf('facebook.com') == -1) {
                        window.location = url;
                    } else {
                        var newWindow = window.open('about:blank');
                        newWindow.location.replace(url);
                    }
                }

                console.log(searchFeature.siblings('.tt-dropdown-menu').val());
            });
        },

        /**
         * Obtém dados da cidade.
         *
         * @param  {void} table [description]
         * @param  {void} city  [description]
         * @return {void}
         */
        getDataByCity = function (table, callback) {
            $.ajax({
                url: '/bares/ajax_get' + table,
                data: {
                    href: Barpedia.Core.URI.location.href
                }
            }).done(callback);
        };

    return {
        cities: cities,
        populate: populate,
        setBloodHoundObject: setBloodHoundObject,
        getDataByCity: getDataByCity
    };

}());
