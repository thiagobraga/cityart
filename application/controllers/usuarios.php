<?php

/**
 * usuarios.php
 *
 * Classes, métodos e propriedades do controller user.
 * A classe Home estende a classe MY_Controller.
 * Funções utilizadas para login com Facebook.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Geoprocessamento de dados
 * @package   Barpedia
 * @author    Matheus Cesario <matheus@institutosoma.org.br>
 * @author    Thiago Braga <thiago@institutosoma.org.br>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $Id$
 * @link      http://barpedia.org
 * @since     File available since Release 0.0.0
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Usuarios
 *
 * @category  Geoprocessamento de dados
 * @package   Barpedia
 * @author    Matheus Santos <matheus@institutosoma.org.br>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://barpedia.org
 * @access    public
 */
class Usuarios extends CityArt
{

    /**
     * Defines the type of user redirection on login.
     *
     * @var {String}
     */
    public $redirect_type = '';

    /**
     * Redireciona para o perfil
     *
     * Ao carregar o método principal da classe,
     * redireciona para o perfil do usuário.
     *
     * @return {void}
     */
    public function index($args)
    {
        redirect(base_url());
    }

    /**
     * [pontuacao description]
     *
     * @return [type] [description]
     */
    public function pontuacao()
    {
        // Getting cookie and loading language
        $this->data->locale = $this->setLang();

        // Carregando dados da session
        $this->data->session = $this->session->all_userdata();
        $this->data->city    = $this->cidades_model->selecionarCidade($this->session->userdata('inte_last_place'));

        // Dados da content
        $this->data->notifications = Log::get(0, 1000);

        // Pagina
        $this->data->page = '{{score_page}}';
        $this->data->content = 'users/users';

        $this->setTitle('Barpedia.org ' . $this->data->page . ' | {{head_title}}');
        $this->setDescription('{{head_description}}');

        $this->parser->parse('template', $this->data);
    }

    /**
     * Load the System Log page visible only to Barpedia admins.
     *
     * @return {void}
     */
    public function system_log()
    {
        $allowed_access =
            $this->session->userdata('ainc_id_usuario')
            && array_search(
                $this->session->userdata('char_fbid_usuario'),
                $this->data->config_global['fb_admins']
            ) !== false;

        if (!$allowed_access) {
            redirect(base_url());
        } else {
            // Getting cookie and loading language
            $this->data->locale = $this->setLang();

            // Carregando dados da session
            $this->data->session = $this->session->all_userdata();
            $this->data->city    = $this->cidades_model->selecionarCidade($this->session->userdata('inte_last_place'));

            // Dados da content
            $this->data->system_log = Log::getSystemLog(0, 1000);

            // Pagina
            $this->data->page    = '{{system_log}}';
            $this->data->content = 'system_log/system_log';

            $this->setTitle('Barpedia.org ' . $this->data->page . ' | {{head_title}}');
            $this->setDescription('{{head_description}}');

            $this->parser->parse('template', $this->data);
        }
    }

    /**
     * [account description]
     * @return [type] [description]
     */
    public function account()
    {
        // Getting cookie and loading language
        $this->data->locale = $this->setLang();

        // Loading session
        $this->data->session = $this->session->all_userdata();
        $this->data->city    = $this->cidades_model->selecionarCidade($this->data->session['inte_last_place']);

        // If user is logged, redirect to home
        if ($this->data->session['ainc_id_usuario']) {
            redirect(base_url());
        }

        // If there visitor tried to access page and was redirected to here
        // Save redirection link to show in component
        // Defaults
        $this->data->redirect_to = '#';
        $this->data->redirect_to_title = 'navbar_login_with_facebook';
        // Verifying
        if ($this->data->session['redirect_to'] != false)
        {
            $this->data->redirect_to       = $this->data->session['redirect_to'];
            $this->data->redirect_to_title = 'confirm_account';
            $this->session->unset_userdata('redirect_to');
        }

        // If city wasn't load, redirect to home
        if ($this->data->city == NULL) {
            redirect(base_url());
        }

        // Template
        $this->data->page    = '{{bar_including}}';
        $this->data->content = 'users/change-account';

        // Setting Js file and header title
        $this->setTitle('Barpedia.org - {{verify_account}} | {{head_title}}');
        $this->setDescription('{{head_description}}');

        // Erasing infomation about page
        $this->session->unset_userdata('page');

        // Requesting view
        $this->parser->parse('template', $this->data);
    }

    /**
     * [getRedirectionURI description]
     *
     * @return [type]
     */
    public function getRedirectionURI()
    {
        // Redirecting uri
        $redirect_to = get_cookie('redirect_to');
        $redirect_to = ($redirect_to != false) ? $redirect_to : '';

        // Redirection requests from cookie has priority
        if ($redirect_to != '') {

            // Erase redirect session data
            delete_cookie('redirect_to');
            if ($this->redirect_type == '') {
                $this->redirect_type = 'Cookie redirect_to';
            }

            // Return link
            return $redirect_to;
        }

        $redirect_to = '';

        // Get last place that user visited
        $last_place  = $this->session->userdata('inte_last_place');

        // If there is a place, get its uri
        if ($last_place) {
            $redirect_to = $this->cidades_model->selecionarCidade($last_place)->url;
            $ainc_id_bar = $this->session->userdata('ainc_id_bar');
            $redirect_to .= ($ainc_id_bar)
                ? '/' . $this->bares_model->getFriendlyName($ainc_id_bar)
                : '';

            if ($this->redirect_type == '') {
                $this->redirect_type = 'Session inte_last_place';
            }
        }

        return $redirect_to;
    }

    /**
     * Atualiza ou insere dados do usuário
     *
     * Realiza o login do usuário, salvando
     * suas informações no banco de dados.
     *
     * @return {void}
     */
    public function entrar()
    {
        $redirect_to = $this->getRedirectionURI();

        $id_cidade   = -1;
        $iso_country = '';

        // Verifica se o ID do usuário no Facebook está preenchido
        if ($this->facebook->getUser()) {
            try {
                // The fields to get from Facebook
                $fields = array(
                    'id',
                    'name',
                    'first_name',
                    'last_name',
                    'username',
                    'email',
                    'gender',
                    'birthday',
                    'locale',
                    'location'
                );

                // Getting data
                $profile = (object) $this->facebook->api(
                    '/me',
                    array('fields' => $fields)
                );

                // Get Facebook pages whose user is admin
                $facebook_pages = $this->facebook->getPages();

                // Return just pages that is not registered on Barpedia
                $not_registered_pages = MY_Controller::checkBarsExistence(
                    $facebook_pages,
                    true
                );

                $has_pages = count($not_registered_pages) > 0;

                // Check for pages whose user is admin
                if ($has_pages) {
                    $dados_cookie = array(
                        'name'   => 'hp', // HasPage
                        'path'   => '/',
                        'value'  => 1,
                        'expire' => '850000'
                    );
                    echo 'Cookie criado';
                    set_cookie($dados_cookie);
                }

                // Obtém a data de aniversário do usuário
                // e converte para o formato Y-m-d.
                $bday = explode('/', $profile->birthday);
                $profile->birthday = $bday[2] . '-' . $bday[0] . '-' . $bday[1];

                // Faz um cache do horário atual para atualizar
                // o último acesso do usuário.
                $time = date('Y-m-d H:i:s');

                // Verifica se o usuário já existe no banco de dados
                $id_usuario = Usuarios_model::selecionarId($profile->id);

                // First login
                if (!$id_usuario) {

                    // Setting user's current city
                    $aux = explode('_', $profile->locale);
                    $iso_country = $aux[1];

                    // Checking if the facebook's profile has a current city
                    $has_location = isset($profile->location);

                    if ($has_location) {

                        // Getting name and position(lat, lon) of the location
                        $page = (object) $this->facebook->api(
                            '/' . $profile->location['id'],
                            array('fields' => array('id, location, name'))
                        );

                        // Searching for this city on db
                        $cidade = $this->cidades_model->selecionarId(
                            '',
                            $page->location['latitude'],
                            $page->location['longitude']
                        );

                        // City's Id
                        $ainc_id_cidade = ($cidade == null) ? null : $cidade->ainc_id_cidade;
                        $this->redirect_type = 'Facebook';
                    }

                    // Couldn't find the city on db or facebook user doesn't have location
                    // Trying Geoip
                    if (!$has_location || $ainc_id_cidade == null) {

                        $ip       = $this->input->ip_address();
                        $location = $this->get_location_by_ip($ip); //Geoip

                        // If the city wasn't found, try to get the hottest city of the region
                        // Location couldn't be found. Setting a default place
                        if ($location == NULL) {
                            $ainc_id_cidade = $this->cidades_model->get_hottest_city('BR');
                            $this->redirect_type = 'GeoIP - Hottest city in country';

                        } else if ($location->city != '') {
                            $ainc_id_cidade = $this->cidades_model->isCity($location->country, $location->state, $location->city);
                            $this->redirect_type = 'GeoIP';

                        // Found at least state
                        } else if ($location->state != '') {
                            $ainc_id_cidade = $this->cidades_model->get_hottest_city($location->country, $location->state);
                            $this->redirect_type = 'GeoIP - Hottest city in state';

                        // Just country was detected
                        } else {
                            $ainc_id_cidade = $this->cidades_model->get_hottest_city($location->country);
                            $this->redirect_type = 'GeoIP - Hottest city in country';
                        }
                    }

                    // Setting up a supported language (EN, PT, ES)
                    $global = $this->config->item('global');         // Global config
                    $user_language = substr($profile->locale, 0, 2); // Get language name

                    $locale = '';
                    foreach ($global['languages']['available'] as $language) {
                        // If user language is equal to a supported language,
                        // set it up as standard user language
                        if ($user_language == $language['lang']) {
                            $locale = $language['file'];
                            break;
                        }
                    }
                    if ($locale == '') $locale = $global['languages']['default']['file'];

                    // Creating profile
                    $dados = array(
                        'char_fbid_usuario'         => $profile->id,
                        'char_sexo_usuario'         => $profile->gender == 'male' ? 'MASC' : 'FEMI',
                        'char_nome_usuario'         => $profile->first_name,
                        'char_sobrenome_usuario'    => $profile->last_name,
                        'char_apelido_usuario'      => $profile->username,
                        'char_email_usuario'        => $profile->email,
                        'char_lingua_usuario'       => $locale,
                        'bit_status_usuario'        => 1,
                        'stam_datainclusao_usuario' => $time,
                        'ainc_id_cidade'            => $ainc_id_cidade,
                        'inte_last_place'           => $ainc_id_cidade,
                        'data_nascimento_usuario'   => $profile->birthday
                    );

                    // Return new Id
                    $id_usuario = $this->usuarios_model->inserirUsuario($dados);

                // Update information
                } else {

                    // Já é cadastrado e entrou com conta do facebook
                    // Atualiza informações
                    $dados = array(
                        'char_sexo_usuario'          => $profile->gender == 'male' ? 'MASC' : 'FEMI',
                        'char_nome_usuario'          => $profile->first_name,
                        'char_sobrenome_usuario'     => $profile->last_name,
                        'char_apelido_usuario'       => $profile->username,
                        'char_email_usuario'         => $profile->email,
                        'bit_status_usuario'         => 1,
                        'stam_dataalteracao_usuario' => $time
                    );

                    $this->usuarios_model->atualizarUsuario($dados, $profile->id);
                    $this->redirect_type = 'Facebook';
                }

            // If the user is logged out, you can have a
            // user ID even though the access token is invalid.
            // In this case, we'll get an exception, so we'll
            // just ask the user to login again here.
            } catch (FacebookApiException $e) {
                error_log($e->getType());
                error_log($e->getMessage());
            }

            // Starting user session
            // Core/My_Controller
            $this->loadSession($id_usuario);

            // First time login
            $dados_cookie = array(
                'name' => $this->session->userdata('session_id') . '_f',
                'value' => 1,
                'expire' => '850000'
            );
            set_cookie($dados_cookie);

            // Persistent login cookie
            $char_name_oauth  = sha1(ENC_KEY);
            $char_value_oauth = sha1(time() . $id_usuario);

            $dados_cookie = array(
                'name'   => $char_name_oauth,
                'value'  => $char_value_oauth,
                'expire' => '850000'
            );
            set_cookie($dados_cookie);

            // Locale of the user
            $dados_cookie = array(
                'name'   => 'locale',
                'value'  => $this->usuarios_model->getLang($id_usuario),
                'expire' => '850000'
            );
            set_cookie($dados_cookie);

            // Registering cookie on db
            $char_ip_oauth    = $this->session->userdata('ip_address'); // Ip
            $char_agent_oauth = $this->agent->browser() . $this->agent->mobile(); // Browser

            Usuarios_model::registerActivity(
                $char_value_oauth,
                $id_usuario,
                $char_ip_oauth,
                $char_agent_oauth
            );
        }

        // Redirecting
        // Note: check line 93;
        // If there is no previous redirect link, update redirect link with the user's db information
        if ($redirect_to == '') {
            $redirect_to = $this->getRedirectionURI();
        }

        // Registering action in System Log
        Usuarios_model::callInsertSystemLog(
           $id_usuario,
           'action_login',
           $char_ip_oauth,
           $this->agent->agent,
           uri_string(),
           $this->redirect_type
        );

        redirect(base_url($redirect_to));
    }

    /**
     * Logout
     * Destroi a session do Facebook e do CodeIgniter
     * e remove o cookie de autenticação.
     *
     * @return {void}
     */
    public function sair()
    {
        $ainc_id_usuario = $this->session->userdata('ainc_id_usuario');

        // Redirecting
        $last_place  = $this->session->userdata('inte_last_place');
        $redirect_to = $this->cidades_model->selecionarCidade($last_place)->url;
        $ainc_id_bar = $this->session->userdata('ainc_id_bar');
        $redirect_to .= ($ainc_id_bar)
            ? '/' . $this->bares_model->getFriendlyName($ainc_id_bar)
            : '';

        // Updating last place visited by user
        $data = array('inte_last_place' => $last_place);
        $response = $this->usuarios_model->atualizarUsuario($data, $ainc_id_usuario);

        // Deleting auth register in db
        $this->usuarios_model->removeActivity(get_cookie(sha1(ENC_KEY)));

        // Delete first login cookie
        delete_cookie($this->session->userdata('char_fbid_usuario') . '_f');

        // Delete 'is_admin_pages' cookie
        delete_cookie('hp');

        // Delete persistent login cookie
        delete_cookie(sha1(ENC_KEY));

        // Destroying session and CI sessions
        $this->facebook->destroySession();
        $this->session->sess_destroy();

        Usuarios_model::callInsertSystemLog(
           $ainc_id_usuario,
           'action_logout',
           $this->input->ip_address(),
           $this->agent->agent,
           uri_string(),
           'Session inte_last_place'
        );

        redirect(base_url($redirect_to));
    }

    /**
     * [ajax_verificaPontos description]
     *
     * @return [type] [description]
     */
    public function ajax_verificaPontos()
    {
        $id = $this->session->userdata('ainc_id_usuario');

        if ($id != null) {
            $this->response = $this->usuarios_model->pontosUsuario($id);
            echo json_encode($this->response);
        } else {
            echo json_encode(-1);
        }
    }

    /**
     * Obtém dados dos usuários do Facebook
     *
     * @return [type]
     */
    public function ajax_usersInfo()
    {
        $uids           = $this->input->post('uids');
        $ainc_id_cidade = $this->session->userdata('inte_last_place');

        if (strlen($uids) > 0) {
            $this->response = $this->usuarios_model->usersInfo($uids, $ainc_id_cidade);
            echo json_encode($this->response);
        } else {
            echo json_encode(false);
        }
    }

    /**
     * [ajax_getFriendsFromFacebook description]
     *
     * @return [type]
     */
    public function ajax_getFriendsFromFacebook()
    {
        // Getting Access Token
        $access_token = $this->facebook->getAccessToken();

        // User's data
        $char_fbid_usuario = $this->session->userdata('char_fbid_usuario');
        $ainc_id_cidade    = $this->session->userdata('inte_last_place');
        $ainc_id_bar       = $this->session->userdata('ainc_id_bar');

        // There is no user, exit.
        if (!$char_fbid_usuario) echo json_encode(array());

        // Getting data from facebook
        $query = 'SELECT uid
            FROM user
            WHERE is_app_user
            AND uid IN (SELECT uid2 FROM friend WHERE uid1 = me())';

        $fql_response = $this->facebook->api(array(
            "method" => "fql.query",
            "query"  => $query
        ));

        // Converting to string
        $friends_list = '';
        foreach ($fql_response as $friend) {
            $friends_list .= $friend['uid'] . ',';
        }
        $friends_list = rtrim($friends_list, ',');

        if ($friends_list) {
            $this->response = $this->usuarios_model->userContribution($friends_list, $ainc_id_bar);
            echo json_encode($this->response);
        } else {
            echo json_encode(array());
        }
    }

    /**
     * Adiciona pontos ao usuário
     *
     * Adiciona pontos a cada interação no site
     * realizada pelo usuário.
     *
     * @return {JSON}
     */
    public function ajax_adicionarPontos()
    {
        $acao = $this->input->post('acao');
        $usuario = $this->session->userdata('ainc_id_usuario');
        $this->response = $this->usuarios_model->adicionarPontos($usuario, $acao);
        echo json_encode($this->response);
    }

    /**
     * Verify if the facebook user's city is the same that the system has on db
     *
     * @ss_city [int] Id of the city
     * @fb_city [int] Id of the fb. If -1, there is no city assigned on facebook account
     *
     * @return  [bool] 1: the cities are the same;
     *                 0: the cities are different;
     */
    public function ajax_verifyLocation()
    {
        $this->response = new stdClass();
        $this->response->is_equal = 0;

        $registered_city = $this->session->userdata('ainc_id_cidade');
        $last_place      = $this->session->userdata('inte_last_place');

        // Checking
        if ($registered_city != $last_place) {

            // Get info about city
            $obj = $this->cidades_model->selecionarCidade($registered_city); // ainc_id_cidade

            $this->response->is_equal = 0;
            $this->response->ainc_id_cidade        = $obj->ainc_id_cidade;
            $this->response->char_nomelocal_cidade = $obj->char_nomelocal_cidade;
            $this->response->char_estado           = $obj->char_estado;
            $this->response->url = $obj->url;

            echo json_encode($this->response);
        } else {
            $this->response->is_equal = 1;
            echo json_encode($this->response);
        }

        //Remove logged check from cookies
        delete_cookie($this->session->userdata('session_id') . '_f');
    }

    /**
     * Update the main city of the user
     *
     * @ainc_id_usuario   [int] User's id
     * @data              [int|string] Related city's data. If @data is numeric, it is the city's ID.
     *                        Otherwise, @data is an URL in the format "/country/state/city" and need to be
     *                            treated. The method getCityInfoByURI returns the city's ID based on a valid url.
     *
     * @return            [int] Affected rows
     */
    public function ajax_updateLocation()
    {
        $ainc_id_usuario = $this->session->userdata('ainc_id_usuario');
        $inte_last_place = 0;

        $data = $this->input->post('data');

        // Checking if data is a url or a valid Id
        if (is_numeric($data)) {
            $inte_last_place = $data;
        } else {
            $inte_last_place = $this->cidades_model->getCityInfoByURI($data)->ainc_id_cidade;
        }

        if ($inte_last_place == 0) {
            echo json_encode(false);
        } else {
            // Updating db
            if ($ainc_id_usuario != false) {
                $data = array('inte_last_place' => $inte_last_place);
                $response = $this->usuarios_model->atualizarUsuario($data, $ainc_id_usuario);
            }

            // Updating session
            $this->session->set_userdata('inte_last_place', $inte_last_place);

            echo json_encode($inte_last_place != 0) ? true : false;
        }
    }

    public function ajax_positioningByGeoLocation ()
    {
        $lat       = $this->input->post('lat');
        $lon       = $this->input->post('lon');
        $is_mobile = $this->input->post('is_mobile');
        $response  = array();

        $location  = $this->cidades_model->select_id_by_position($lat, $lon);

        // Found something!
        if ($location != null) {

            $response['location_found'] = true;
            $response['location'] = $location->url;
            $response['url']      = $location->url;

            // Is is mobile device, find nearby place
            // and add to url
            if ($is_mobile) {
                $bar = $this->bares_model->findBar($lat, $lon, $location->ainc_id_cidade);
                // Get the nearest one (first)
                if (count($bar) > 0) {
                    $response['place_found']  = true;
                    $response['place']        = $bar[0]->char_nomeamigavel_bar;
                    $response['url']         .= '/' . $bar[0]->char_nomeamigavel_bar;
                }
            }

            echo json_encode($response);

        // $location return null (position is not registered on db)
        } else {
            echo json_encode(null);
        }
    }

    /**
     * Verifica se o usuário está autenticado
     *
     * @return {JSON}
     */
    public function checkFirstLogin() {
        echo json_encode(get_cookie($this->session->userdata('char_fbid_usuario') . '_f'));
    }

    /**
     *
     * @return [type] [description]
     */
    public function ajax_getNotification()
    {
        $ainc_id_usuario = $this->session->userdata('ainc_id_usuario');
        $start           = $this->input->post('start');
        $limit           = $this->input->post('limit');

        if ($ainc_id_usuario == false) {
            echo json_encode(
                (object)
                array('period_notifications' => '',
                      'events'               => array())
                );
        } else {
            echo json_encode($this->log($start, $limit));
        }
    }

    /**
     * [ajax_refreshToken description]
     * @return [type] [description]
     */
    public function ajax_refreshToken()
    {
        // Cleaning FB session
        $this->facebook->destroySession();

        // Defining permissions
        $params = array(
            'scope' => 'email', 'user_birthday', 'user_location',
                'user_work_history', 'user_hometown', 'user_photos',
                'basic_info', 'publish_actions', 'publish_stream',
                'manage_pages',
            'redirect_uri' => base_url(uri_string())
        );

        // Requiring login url
        $fb_login_url = $this->facebook->getLoginUrl($params);

        // Return link to refresh access token
        echo json_encode($fb_login_url);
    }

}

/* End of file usuarios.php */
/* Location: ./application/controllers/users.php */
