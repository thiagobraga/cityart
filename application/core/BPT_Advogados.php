<?php

/**
 * BPT_Advogados.php
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
 * @author    Thiago Braga <thiago@institutosoma.org.br>
 * @author    Matheus Cesario <matheus@institutosoma.org.br>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT:
 * @link      http://barpedia.org
 * @since     File available since Release 0.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BPT_Advogados
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @access public
 * @version 1.0
 */
class BPT_Advogados extends CI_Controller
{

    /**
     * Variável que armazena dados no controller
     * e envia para as views.
     *
     * @var {stdClass}
     */
    public $data;

    /**
     * Variável response utilizada nas requisições ajax.
     *
     * @var {stdClass}
     */
    public $response;

    /**
     * Armazena o nome do controller
     *
     * @var {String}
     */
    public $controller;

    /**
     * Armazena o nome do método
     *
     * @var {String}
     */
    public $method;

    /**
     * The city of the user.
     *
     * @var {Int}
     */
    public $ainc_id_cidade;

    /**
     * Call the Controller constructor
     * This function is used to call
     * default languages, layout views, etc.
     * @since 1.0
     */
    public function __construct()
    {
        parent::__construct();

        // Data
        $this->data             = new stdClass;
        $this->response         = new stdClass;
        $this->data->is_logged  = false;

        // Controller/Method
        $this->data->controller = $this->router->fetch_class();
        $this->data->method     = $this->router->fetch_method();

        // Default info
        BPT_Advogados::setDescription('BPT Advogados');
        BPT_Advogados::setKeywords('advogado, bauru, direito, tributario, trabalhista');

        // Loading scripts and stylesheet
        BPT_Advogados::loadCss(array('css/dist/styles.min'));
        BPT_Advogados::loadJs(array('js/dist/scripts.min'));
    }

    /**
     * [setLang description]
     *
     * @return {Void}
     */
    public function setLang()
    {
        // Getting cookie and loading language
        $locale = get_cookie('locale');

        if ($locale) {
            $language = $this->data->config_global['languages']['available'][$locale];
        } else {
            $locale = $this->cidades_model->getCityInfoByURI(uri_string())->locale;

            // Getting keys for search
            $available_langs = array_keys($this->data->config_global['languages']['available']);

            // Check if this language is supported
            $found = array_search($locale, $available_langs);

            // If not, load default language
            $language = ($found != false)
                ? $this->data->config_global['languages']['available'][$locale]
                : $this->data->config_global['languages']['default'];

            // Saving cookie
            $cookie_data = array(
                'name'   => 'locale',
                'value'  => $language['file'],
                'expire' => '850000'
            );
            set_cookie($cookie_data);
        }

        $this->lang->load($language['file'], $language['lang']);

        return $language['file'];
    }

    /**
     * [setUserCity description]
     *
     * @return {Void}
     */
    public function setUserCity()
    {
        // System Log variables
        $user = $this->session->userdata('ainc_id_usuario')
            ? (int) $this->session->userdata('ainc_id_usuario')
            : 0;

        // Checking session
        $this->ainc_id_cidade = $this->session->userdata('inte_last_place');
        $redirect_type = 'Session inte_last_place';

        // Trying Geoip
        if (!$this->ainc_id_cidade) {
            $location = $this->get_location_by_ip(
                $this->input->ip_address()
            );

            // Location couldn't be found. Setting a default place
            if ($location == null) {

                // Use default city from Barpedia config.
                $this->data->config_cities = $this->config->item('cities');
                $this->ainc_id_cidade      = $this->data->config_cities['default'];
                $redirect_type             = 'Default Barpedia city';

                // Creating temp cookie
                $data = array(
                    'name'   => 'geoip_failed', // Geoip Positioning failed
                    'path'   => '/',
                    'value'  => 1,
                    'expire' => '850000'
                );
                set_cookie($data);

            // If the city wasn't found, try to get the hottest city of the region
            // Found city
            } else if ($location->city != '') {
                $this->ainc_id_cidade = Cidades_model::isCity($location->country, $location->state, $location->city);
                $redirect_type        = 'GeoIP';

            // Found at least state
            } else if ($location->state != '') {
                $this->ainc_id_cidade = Cidades_model::get_hottest_city($location->country, $location->state);
                $redirect_type        = 'GeoIP - Hottest city in state';

            // Just country was detected
            } else {
                $this->ainc_id_cidade = Cidades_model::get_hottest_city($location->country);
                $redirect_type        = 'GeoIP - Hottest city in country';
            }
        }

        // Is a mobile device
        // Require search for nearby places
        if ($this->agent->is_mobile()) {
            $data = array(
                'name'   => 'is_mobile', // IsMobile
                'path'   => '/',
                'value'  => 1,
                'expire' => '850000'
            );
            set_cookie($data);
        }

        if (preg_match('/bares|cities/', $this->data->controller)) {
            // Registering action in System Log
            Usuarios_model::callInsertSystemLog(
               $user,
               'action_redirected',
               $this->input->ip_address(),
               $this->agent->agent,
               uri_string(),
               $redirect_type
            );
        }
    }

    /**
     * Check if there is some cookie to the persistent login
     *
     * @return {Void}
     */
    public function checkActivity()
    {
        $char_name_oauth  = sha1(ENC_KEY);
        $char_value_oauth = get_cookie($char_name_oauth);

        if ($char_value_oauth != false) {
            $OAuth = Usuarios_model::checkActivity($char_value_oauth);

            if ($OAuth != null) {
                $this->loadSession($OAuth->ainc_id_usuario);
            }
        }
    }

    /**
     * Verify if some place that user owns is already registered on db.
     *
     * @param  {Array}   $places          Array of objects with facebook fanpage of the user.
     * @param  {Boolean} $remove_existing If true,
     * @return [type]
     */
    public function checkBarsExistence($places, $remove_existing = false)
    {
        $count = count($places);

        // Verify if some bar is already registered on db
        if (!$remove_existing) {
            for ($i = 0; $i < $count; $i++) {
                $link = Bares_model::getLinkBar($places[$i]['id']);

                $places[$i]['is_registered'] = ($link != null);

                if ($places[$i]['is_registered']) {
                    $places[$i]['barpedia_link'] = $link;
                }
            }

        // Verify if some bar is already registered on db
        // Retutn just the places that wasn't registerd yet.
        } else {
            for ($i = 0; $i < $count; $i++) {
                $link = Bares_model::getLinkBar($places[$i]['id']);

                $is_allowed_page = array_search(
                    $places[$i]['category'],
                    $this->facebook->allowed_categories
                );

                // If link is null, it means that this place is not registered yet.
                if ($link == null && $is_allowed_page) {
                    $new_places[$i] = $places[$i];
                }
            }
            $places = $new_places;
        }

        return $places;
    }

    /**
     * Load information about user (persistent loging).
     *
     * @param  {Int}   $ainc_id_usuario  The ID of the user.
     * @return {void}
     */
    public function loadSession($ainc_id_usuario)
    {
        // Get User's current db city
        $user_info = Usuarios_model::userInfo($ainc_id_usuario);

        // Load session
        $dados_session = array(
            'ainc_id_usuario'        => $ainc_id_usuario,
            'char_fbid_usuario'      => $user_info->char_fbid_usuario,
            'char_nome_usuario'      => $user_info->char_nome_usuario,
            'char_sobrenome_usuario' => $user_info->char_sobrenome_usuario,
            'char_email_usuario'     => $user_info->char_email_usuario,
            'char_lingua_usuario'    => $user_info->char_lingua_usuario,
            'char_apelido_usuario'   => $user_info->char_apelido_usuario,
            'inte_last_place'        => $user_info->inte_last_place, // Place got from facebook
            'ainc_id_cidade'         => $user_info->ainc_id_cidade // Place registered in the system
        );

        $this->session->set_userdata($dados_session);
    }

    /**
     * Retorna a pontuação do usuário logado.
     *
     * @return {Object|Boolean}
     */
    public function getUserPoints()
    {
        $usuario = $this->session->userdata('ainc_id_usuario');
        return ($usuario == false)
            ? 0
            : Usuarios_model::pontosUsuario($usuario);
    }

    /**
     * [get_location_by_ip description]
     *
     * @param  [type] $ip [description]
     * @return [type]
     */
    public function get_location_by_ip($ip)
    {
        include(APPPATH . 'libraries/geoip/geoipcity.inc');

        $gi     = geoip_open('assets/data/GeoLiteCity.dat', GEOIP_STANDARD);
        $record = geoip_record_by_addr($gi, $ip);
        geoip_close($gi);

        if ($record == null) {
            return null;
        }

        $obj          = new stdClass;
        $obj->country = strtolower(utf8_encode($record->country_code));
        $obj->state   = utf8_encode($record->region);
        $obj->city    = url_title2(utf8_encode($record->city));

        return $obj;
    }

    /**
     * Set page title.
     *
     * @access protected
     * @param  string $title
     */
    protected function setTitle($title)
    {
        $this->load->vars(array('title' => $title));
    }

    /**
     * Set meta description.
     *
     * @access protected
     * @param  string $description
     */
    protected function setDescription($description)
    {
        $this->load->vars(array('description' => $description));
    }

    /**
     * Set meta keywords.
     *
     * @access protected
     * @param  string $keywords
     */
    protected function setKeywords($keywords)
    {
        $this->load->vars(array('keywords' => $keywords));
    }

    /**
     * Load css styles.
     *
     * @access protected
     * @param  array $css
     */
    protected function loadCss(array $css)
    {
        if ($og_css = $this->load->get_var('css')) {
            $css = array_merge($og_css, $css);
            $css = array_unique($css);
        }

        $this->load->vars('css', $css);
    }

    /**
     * Load javascript files.
     *
     * @access protected
     * @param  array $js
     */
    protected function loadJs(array $js)
    {
        if ($og_js = $this->load->get_var('js')) {
            $js = array_merge($og_js, $js);
            $js = array_unique($js);
        }

        $this->load->vars('js', $js);
    }

    /**
     * TIMEZONES
     * {{AQUI}} Document it
     * @param   $location Object in the format {char_id_estado, char_id_pais, lat, lon}
     *                           Check bares_model->getBarLocation();
     * @return  $gmt_offset Gmt offset of this timezone
     */
    public function getGMTOffset($location = null, $flag_dst_offset=false)
    {
        $gmt_offset = 0;

        if ($location == null) {
            return $gmt_offset;
        }

        // Timezone
        $timezone = $this->cidades_model->getTimezone(
            $location->char_id_estado,
            $location->char_id_pais );

        // There is no timezone
        if ($timezone == null) {

            $new_timezone = $this->google_API_getTimezoneByCoord(
                $location->deci_latitude_bar,
                $location->deci_longitude_bar);

            $gmt_offset = $new_timezone->rawOffset;

            // Creating new timezone
            $ainc_id_timezone = $this->cidades_model->setNewTimezone($new_timezone);

            // Attributing brand new timezone to this place
            $this->cidades_model->setNewZone(
                $location->char_id_estado,
                $location->char_id_pais,
                $ainc_id_timezone);

            date_default_timezone_set($new_timezone->timeZoneId);

        // If timezone was found
        } else {

            $must_update = strtotime($timezone->stam_lastupdate_timezone) < strtotime("-4 months");
            // Updating the timezone
            // We need to check constantly because the Day Saving Time changes for 4 months
            if ($must_update) {

                // Requiring timezone data
                $new_timezone = $this->google_API_getTimezoneByCoord(
                    $location->deci_latitude_bar,
                    $location->deci_longitude_bar);

                // Updating dst of the timezone
                $this->cidades_model->updateTimezone(
                    $timezone->ainc_id_timezone,
                    $new_timezone);

                $gmt_offset = $new_timezone->rawOffset;

            // If data is still fresh, get its gmt_offset
            } else {
                $gmt_offset = $timezone->stam_offset_timezone;
            }

            date_default_timezone_set($timezone->char_id_timezone);
        }

        $dst_offset = (date('I')) ? 3600 : 0;

        date_default_timezone_set('UTC');   // Default
        return ($gmt_offset + $dst_offset); // Checking for daylight save time
    }

    /**
     * [google_API_getTimezoneByCoord description]
     *
     * @param  [type] $lat [description]
     * @param  [type] $lon [description]
     * @return [type]
     */
    public function google_API_getTimezoneByCoord($lat=null, $lon=null)
    {
        if ($lat == null || $lon == null) {
            return null;
        }

        // Google API
        $google_API_url = 'https://maps.googleapis.com/maps/api/timezone/json?location='
            . $lat . ','
            . $lon . '&timestamp=' . time();

        return json_decode(file_get_contents($google_API_url));
    }


    /**
     * Requesting a new access token
     * The Facebook access token has a short live of 2 hours. When the access token
     * expires, we must request a new one. Hence, we request a new token using
     * the method Facebook::getLoginUrl(), that will return a url where we
     * can access the parameter 'code'. This $_GET parameter we will use to get the
     * new access token by adding it to the request_token url.
     * In the end, we change the tokens using the methods Facebook::setAccessToken()
     * and Facebook::setExtendedAccessToken
     *
     * @param [String] $redirect_to Url to be used to redirect in the end of the process
     */
    public function getNewAccessToken($redirect_to = '')
    {
        $code         = $this->input->get('code');
        $has_code     = $code != false;
        $redirect_uri = base_url('/usuarios/getNewAccessToken/');

        // Requesting code
        if(!$has_code) {

            // Cleaning all user session
            $this->facebook->destroySession();

            //Saving redirection url in session
            $this->session->set_userdata('getnewaccesstoken_redirect_to', $redirect_to);

            // Defining new scope (permissions) and the redirection address
            $params = array(
                'scope' => 'email', 'user_birthday', 'user_location',
                    'user_work_history', 'user_hometown', 'user_photos',
                    'basic_info', 'publish_actions', 'publish_stream',
                    'manage_pages',
                'redirect_uri' => $redirect_uri);

            // Get FB link to get the new code
            $fb_login_url = $this->facebook->getLoginUrl($params);

            echo $fb_login_url;

            // Redirecting
            redirect($fb_login_url);

        // Requesting access token
        } else {

            $params = array(
                'client_id'     => '237267543113267',
                'client_secret' => '2b24835cfc6521cc05d62d232591da78',
                'code'          => $code,
                'redirect_uri'  => $redirect_uri
            );

            // URL to get the access token
            $request_access_token = 'https://graph.facebook.com/oauth/access_token?'
                . http_build_query($params, null, '&');

            // Get access token
            $response = file_get_contents($request_access_token);

            // Converting response into variables
            parse_str($response);

            // New access token
            $this->facebook->setAccessToken($access_token);
            $this->facebook->setExtendedAccessToken();

            // Getting saved redirection url
            $redirect_to = $this->session->userdata('getnewaccesstoken_redirect_to');

            // If there is no url, redirect to home
            if($redirect_to === false) {
                redirect(base_url());
            }

            // Remove session data
            $this->session->unset_userdata('getnewaccesstoken_redirect_to');

            // Redirect to destiny
            redirect($redirect_to);
        }
    }

}

/* End of file BPT_Advogados.php */
/* Location: ./application/core/BPT_Advogados.php */
