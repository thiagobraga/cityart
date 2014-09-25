/**
 * @file   facebook.js
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
 * Facebook
 *
 * @type {Object}
 */
Barpedia.Core.Facebook = (function () {

    'use strict';
    var

        /**
         * Facebook friends that are using BP
         * Saves user's friends info
         * @type {Array}
         */
        _myFriends = [],

        /**
         * Javascript getter for _myFriends
         */
        myFriends = function () {
            return _myFriends;
        },

        /**
         * Configurações padrão de inicialização da API do Facebook.
         *
         * @type {Object}
         */
        FBinitConfig = {
            appId  : '237267543113267',
            cookie : true,
            xfbml  : true,
            version: 'v2.1'
        },

        /**
         * Ensure init
         * (Further info: http://stackoverflow.com/questions/3548493/how-to-detect-when-facebooks-fb-init-is-complete)
         */

        fbApiInit = false,

        fbEnsureInit = function fbEnsureInit(callback) {

            // API still not loaded
            if(!fbApiInit) {

                // Watching SDK finish loading
                setTimeout(function() {fbEnsureInit(callback);}, 50);

            // SDK loaded!
            } else {

                // Return callback
                if(callback) {
                    callback();
                }
            }
        },

        /**
         * Define configurações iniciais, permissões e inicia API do facebook.
         *
         * @return {void}
         */
        // {{AQUI}} Implement MY_Controller::getNewAccessToken  method
        load = function () {
            var facebook_login = $('.facebook-login');

            // Loading Facebook API SDK
            // Note: We must use a callback here because at first time,
            // window.fbAsyncInit doesn't exist. We must have sure that the SDK
            // will load before call window.fbAsyncInit(). After ensure it,
            // we may initialize the FB object. We do this using the Watcher
            // pattern (fbEnsureInit()). This method will watch the boolean
            // fbApiInit until it becomes true. Afterwards, the method will return
            // a callback, assuring us that we can execute all pertinent FB methods.
            Barpedia.Helpers.Scripts.loadJsWithCallback(
                'https://connect.facebook.net/en_US/all.js',
                function(is_loaded) {

                    // Start watcher
                    fbEnsureInit(function() {
                        FB.getLoginStatus(function(response) {
                            // console.log(response);

                            if(response.status === "connected") {
                                // console.log('User is connected.');

                                var uid         = response.authResponse.userID,
                                    accessToken = response.authResponse.accessToken;

                                _friends(uid, accessToken);

                                // @TODO Implement AccessToken refresh
                                // Calling watcher
                                // If expire time is lower than 1 minute,
                                // refresh access token
                                if(response.authResponse.expiresIn < 8000 ) {
                                    // console.log('Token will expire in ', response.authResponse.expiresIn,'. Must refresh');

                                    // Requesting login
                                    /*FB.login(function(response) {
                                        if (response.authResponse) {
                                            console.log('Welcome!  Fetching your information.... ');
                                            FB.api('/me', function(response) {
                                                console.log('Good to see you, ' + response.name + '.');
                                            });
                                        } else {
                                            console.log('User cancelled login or did not fully authorize.');
                                       }
                                    });

                                    $.ajax({
                                        url: '/usuarios/ajax_refreshToken',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            redirect_to: Barpedia.Core.URI.location.href
                                        }
                                    })
                                    .done(function(response) {
                                        console.log(response);
                                    });*/


                                } else {
                                    // call again
                                }
                            }
                        });
                    });

                    // Calling fbAsyncInit (must call after file is totally load)
                    window.fbAsyncInit = function () {

                        // Initializing FB module
                        FB.init(FBinitConfig);

                        // FB module successfully load. Assign as true
                        fbApiInit = true;
                    };
                }
            );

            // Botão de login
            facebook_login.on('click', function (event) {
                event.preventDefault();

                var self     = $(this),
                    href     = self.attr('href'),
                    has_link = (href !== '#' && href !== ''),
                    prefix   = Barpedia.Core.URI.location.prefix,
                    cookie   = prefix + '_redirect_to';

                // Create cookie to redirect to the href link, if there is some
                if (has_link) {
                    $.cookie(cookie, href, {path:'/',  domain: prefix + '.barpedia.org'});
                }

                // Performing request to Facebook
                facebookLogin();
            });
        },

        /**
         * Realiza o login com Facebook.
         *
         * @return {void}
         */
        facebookLogin = function () {
            // Facebook permissions
            var scope = [
                'email',
                'user_about_me',
                'user_birthday',
                'user_location',
                'user_work_history',
                'user_hometown',
                'user_photos',
                'basic_info',
                'publish_actions',
                'publish_stream',
                'manage_pages'
            ].join(', ');

            // Requesting login
            FB.login(function (response) {
                if (response.authResponse) {
                    parent.location = '/usuarios/entrar';
                }
            }, {
                scope: scope
            });
        },

        /**
         * Performe a POST action on user's facebook feed
         * @return {void} [description]
         */
        writePost = function (url, page_name, callback) {
            $.ajax({
                url: '/bares/ajax_writePostOnFacebook',
                type: 'post'
            }).done(function (data) {
                return callback(data);
            });
        },

        /**
         * [friends description]
         *
         * @param  {Function} callback [description]
         * @return {void}
         */
        friends = function (callback) {
            $.ajax({
                url: '/usuarios/ajax_getFriendsFromFacebook',
                type: 'post'
            }).done(function (data) {
                return callback(data);
            });
        },

        /**
         * Private method that select user's friends from Facebook
         * @return {[type]} [description]
         */
        _friends = function (uid, accessToken) {
            var users = [],
                query = [
                    'SELECT uid FROM user WHERE is_app_user AND uid IN (',
                    'SELECT uid2 FROM friend WHERE uid1 = ' + uid + ')'
                ].join(''),
                url = [
                    'https://graph.facebook.com/fql?q=',
                    encodeURI(query),
                    '&access_token=' + accessToken
                ].join('');

            // Executing FQL query
            $.get(url, function (response) {

                // Load Barpedia information
                _selectUsersInfo(response.data, function(response) {

                    // Fire trigger after load
                    $(document).trigger('facebookFriendsLoaded');
                });
            });
        },

        /**
         * Select information about users base in Facebook uid.
         * Retrieve a list with Barpedia information.
         *
         * @param  {array} list List with Facebook information
         * @return {array}      List with Barpedia information
         */
        _selectUsersInfo = function (list, callback) {

            // Return BP info
            $.ajax({
                url: '/usuarios/ajax_usersInfo',
                type: 'post',
                async: false,
                data: {
                    uids: _selectUids(list)
                },
                success: function (data) {

                    // Saving friends
                    _myFriends = data;

                    // Returning
                    return callback(data);
                }
            });
        },

        /**
         * Select uid fields from a list
         *
         * @param  {Object} list List of users
         * @return {string}      Concatenated list of selected uids
         */
        _selectUids = function (list) {
            var response = '';

            $.each(list, function (index, obj) {
                response += obj.uid + ',';
            });

            return response.substring(0, response.length - 1);
        },

        /**
         * [validate description]
         *
         * @param  {void}   id       [description]
         * @param  {Function} callback [description]
         * @return {void}
         */
        validate = function (id, callback) {
            $.ajax({
                url: '/new_bar/ajax_isFacebookPage',
                type: 'post',
                data: {
                    id: id
                }
            }).done(function (data) {
                return callback(data);
            });
        },

        /**
         * [getPageInfo description]
         *
         * @param  {void}   id       [description]
         * @param  {Function} callback [description]
         * @return {void}
         */
        getPageInfo = function (id, callback) {
            $.ajax({
                url: '/new_bar/ajax_getPageInfo',
                type: 'post',
                data: {
                    id: id
                }
            }).done(function (data) {
                return callback(data);
            });
        },

        // {{AQUI}} Is it better this way or with PHP?
        getEventInfo = function (url, callback) {
            FB.api('/' + url, 'get', function(data) {
                callback(data);
            });
        },

        /**
         * [getMostLikedPhotos description]
         * @param  {long}     id        Page id
         * @param  {int}      limit     Number of photos to be retrieved
         * @param  {Object}   exception List of ids that were already caught
         * @param  {Function} callback  Response
         * @return {void}               Nothing
         */
        getMostLikedPhotos = function (id, limit, exception, callback) {

            if (id    === '') return callback([]);
            if (limit === undefined) limit = 20;

            $.ajax({
                url: '/new_bar/ajax_getMostLikedPhotos',
                type: 'post',
                data: {
                    id       : id,
                    limit    : limit,
                    exception: exception
                }
            }).done(function (data) {
                return callback(data);
            });
        },

        /**
         * Check on cookie if user is admin of some page
         * Note: this cookie is created at Usuarios::entrar()
         * @return {Boolean} true if has, false if not
         */
        hasPage = function () {
            var prefix = (Barpedia.Core.URI.location.domain === 'dev.barpedia.org') ? 'dev' : 'local',

                // Has page?
                cookie   = prefix + '_hp',
                has_page = $.cookie(cookie);

            // After check, delete cookie
            $.removeCookie(cookie, {path: '/', domain: prefix + '.barpedia.org' });

            // Return
            return (has_page !== undefined) ? true : false;
        },

        /**
         * Verify is user has page whose is admin of. If true, open a modal
         *
         * @return {void} [description]
         */
        checkAdminPages = function () {
            if (hasPage()) {
                var modal = $('#modal-add-your-facebook-page');

                // Create a cookie indicating that this redirects came from this modal
                // Redirects to new-bar
                modal.on('click', '.btn-success', function() {
                    var prefix = Barpedia.Core.URI.location.prefix,
                        cookie = prefix + '_type';

                    $.cookie(cookie, 'owner', {path:'/',  domain: prefix + '.barpedia.org'});
                });

                modal.modal('show');
            }
        },

        /**
         * Verify validity of the token. If access token expired, try to
         * get another one.
         * @return {Object} Return object with user info and Token info.
         *                         If could not refresh, return false
         */
        refreshToken = function () {

            // Facebook permissions
            var scope = [
                'email',
                'user_birthday',
                'user_location',
                'user_work_history',
                'user_hometown',
                'user_photos',
                'basic_info',
                'publish_actions',
                'publish_stream',
                'manage_pages'
            ].join(', ');

            console.log('refreshToken():', 'Refreshing access token.');

            FB.login(function(response) {
                if (response.authResponse) {
                    console.log('Welcome!  Fetching your information.... ');
                    FB.api('/me', function(response) {
                        console.log('Good to see you, ' + response.name + '.');
                    });
                } else {
                    console.log('User cancelled login or did not fully authorize.');
               }
            }, {
                scope: scope
            });

        };

    return {
        load: load,
        FBinitConfig: FBinitConfig,
        writePost: writePost,
        friends: friends,
        validate: validate,
        getPageInfo: getPageInfo,
        getEventInfo: getEventInfo,
        getMostLikedPhotos: getMostLikedPhotos,
        hasPage: hasPage,
        checkAdminPages: checkAdminPages,
        refreshToken: refreshToken,
        myFriends: myFriends
    };

}());
