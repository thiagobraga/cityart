<?php

/**
 * MY_Controller.php
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
 *
 */
class MY_Parser extends CI_Parser
{

    /**
     *
     */
    const LANG_REPLACE_REGEXP = '!\{\{\s*(?<key>[^\}]+)\}\}!';

    /**
     * [$CI description]
     *
     * @var [type]
     */
    public $CI;

    /**
     * [parse description]
     *
     * @param  [type]  $template [description]
     * @param  [type]  $data     [description]
     * @param  boolean $return   [description]
     * @return [type]
     */
    public function parse($template, $data, $return = false)
    {
        $this->CI =& get_instance();
        $template = $this->CI->load->view($template, $data, true);
        $template = $this->replace_lang_keys($template);

        return $this->_parse($template, $data, $return);
    }

    /**
     * [replace_lang_keys description]
     *
     * @param  [type] $template [description]
     * @return [type]
     */
    protected function replace_lang_keys($template)
    {
        return preg_replace_callback(
            self::LANG_REPLACE_REGEXP,
            array(
                $this,
                'replace_lang_key'
            ),
            $template
        );
    }

    /**
     * [replace_lang_key description]
     *
     * @param  [type] $key [description]
     * @return [type]
     */
    protected function replace_lang_key($key)
    {
        return $this->CI->lang->line($key[1]);
    }

    /**
     * Sobrescreve método _parse(). Não iremos manipular o vetor de dados $data,
     * por isso omitimos a busca pelo array neste método.
     * @param  [type]  $template [description]
     * @param  [type]  $data     [description]
     * @param  boolean $return   [description]
     * @return [type]            [description]
     */
    public function _parse($template, $data, $return = false)
    {
        if ($template == '') {
            return false;
        }

        if ($return == false) {
            $this->CI->output->append_output($template);
        }

        return $template;
    }
}

