<?php

/**
 * Contact.php
 *
 * Classes, métodos e propriedades do controller Contact.
 * A classe Contact estende a classe MY_Controller.
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
 * Contact
 *
 * @category  Geoprocessamento de dados
 * @package   Barpedia
 * @author    Matheus Cesario <matheus@institutosoma.org.br>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://barpedia.org
 * @access    public
 */
class Contact extends BPT_Advogados
{

    public function index()
    {
        // Getting cookie and loading language
        $this->data->locale = $this->setLang();

        // User session
        // Valor relacionado à nota do bar
        // O usuário precisa estar logado
        if ($this->session->userdata('ainc_id_usuario') != null) {
            $ainc_id_usuario = $this->session->userdata('ainc_id_usuario');
        }

        // Carregando dados da session
        $this->data->session = $this->session->all_userdata();
        $this->data->city    = $this->cidades_model->selecionarCidade($this->session->userdata('inte_last_place'));
        $this->data->page    = '{{contact_page}}';
        $this->data->content = 'contact/contact';

        $this->setTitle('Barpedia.org | ' . $this->data->page . ' | {{head_title}}');
        $this->setDescription('{{head_description}}');
        $this->loadJs(array('js/dist/contact.min'));

        $this->parser->parse('template', $this->data);
    }

}

/* End of file bares.php */
/* Location: ./application/controllers/bares.php */
