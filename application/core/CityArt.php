<?php

/**
 * CityArt.php
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

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * CityArt
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @access public
 * @version 1.0
 */
class CityArt extends CI_Controller
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
     * Call the Controller constructor
     * This function is used to call
     * default languages, layout views, etc.
     * @since 1.0
     */
    public function __construct()
    {
        parent::__construct();

        $this->response = array();
        $this->data     = array(
            'controller' => $this->router->fetch_class(),
            'method'     => $this->router->fetch_method(),
            'title'      => 'CityArt | Press & Web | Design, desenvolvimento web, consultoria'
        );

        // Default info
        CityArt::setDescription('Empresa bauruense no ramo de design e desenvolvimento web com visão de mercado, usabilidade e simplicidade. Também prestamos consultoria e suporte para essas áreas.');
        CityArt::setKeywords('design, sites, bauru, desenvolvimento web');

        // Loading scripts and stylesheet
        CityArt::loadCss(array('css/dist/styles'));
        CityArt::loadJs(array('js/dist/scripts'));
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
     * Load CSS styles.
     *
     * @access  protected
     * @param   {Array}    $css     Array of paths to CSS files.
     * @param   {Boolean}  $concat  Concatenate new files to existent array or not.
     * @return  {String}
     */
    protected function loadCss(array $css, $concat = true)
    {
        $count             = count($css);
        $main_path         = '/assets/';

        // for ($i = 0; $i < $count; $i++) {

        //     // The application may reference JavaScript or CSS files
        //     // from respective src folder, then the application should
        //     // not concatenate timestamp nor concat the min to the path
        //     // of this file.
        //     if (!strpos($css[$i], '/src/')) {

        //         // Use minified files only in production and testing.
        //         if (ENVIRONMENT !== 'development') {
        //             $css[$i] .= '.min';
        //         }
        //     }
        // }

        $og_css = $this->load->get_var('css');

        if ($og_css && $concat) {
            $css = array_merge($og_css, $css);
            $css = array_unique($css);
        }

        $this->load->vars('css', $css);
        return $css;
    }

    /**
     * Load JavaScript files.
     *
     * @access  protected
     * @param   {Array}    $js      Array of paths to JS files.
     * @param   {Boolean}  $concat  Concatenate new files to existent array or not.
     * @return  {String}
     */
    protected function loadJs(array $js, $concat = true)
    {
        $count             = count($js);
        $main_path         = '/assets/';

        // Adding version for each js file
        // for ($i = 0; $i < $count; $i++) {

        //     // The application may reference JavaScript or CSS files
        //     // from respective src folder. Then the application should
        //     // not concatenate timestamp nor min to the path of this file.
        //     if (!strpos($js[$i], '/src/')) {

        //         // Use minified files only in production and testing.
        //         if (ENVIRONMENT !== 'development') {
        //             $js[$i] .= '.min';
        //         }
        //     }
        // }

        $og_js = $this->load->get_var('js');

        if ($og_js && $concat) {
            $js = array_merge($og_js, $js);
            $js = array_unique($js);
        }

        $this->load->vars('js', $js);
        return $js;
    }

}

/* End of file CityArt.php */
/* Location: ./application/core/CityArt.php */
