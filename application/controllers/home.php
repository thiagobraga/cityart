<?php

/**
 * home.php
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
 * @category  Advocacia
 * @package   BPT Advogados
 * @author    Thiago Braga <thiago@institutosoma.org.br>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version
 * @link      http://bptadvogados.com.br
 * @since     File available since Release 0.0.0
 */

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Home
 *
 * @category  Advocacia
 * @package   BPT Advogados
 * @author    Thiago Braga <contato@thiagobraga.org>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://bptadvogados.com.br
 * @access    public
 */
class Home extends MY_Controller
{

    /**
     * Redireciona para o perfil
     *
     * Ao carregar o método principal da classe,
     * redireciona para o perfil do u
     * suário.
     *
     * @return {void}
     */
    public function index()
    {
        $this->data = array_merge($this->data, array(
            'page'    => 'Página Inicial',
            'content' => 'home/home'
        ));

        MY_Controller::setTitle($this->data['title'] . ' | ' . $this->data['page']);
        $this->load->view('template', $this->data);
    }

}

/* End of file usuarios.php */
/* Location: ./application/controllers/users.php */
