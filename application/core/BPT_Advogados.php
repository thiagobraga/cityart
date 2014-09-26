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

}

/* End of file BPT_Advogados.php */
/* Location: ./application/core/BPT_Advogados.php */
