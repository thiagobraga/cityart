<?php

/**
 * feedback.php
 *
 * Classes, métodos e propriedades do controller feedback.
 * A classe Feedback estende a classe MY_Controller.
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
 * Feedback
 *
 * @category  Geoprocessamento de dados
 * @package   Barpedia
 * @author    Thiago Braga <thiago@institutosoma.org.br>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://barpedia.org
 * @access    public
 */
class Feedback extends BPT_Advogados
{
    /**
     * Send a feedback email and save its information on db
     * @return Boolean/Array If the email was successfuly saved, returns true.
     *                          Else, return an array with the error's messages
     */
    public function send()
    {
        // Helper
        $this->load->helper('email');

        // General information
        $this->data->browser  = $this->agent->browser();
        $this->data->version  = $this->agent->version();
        $this->data->mobile   = $this->agent->mobile();
        $this->data->platform = $this->agent->platform();

        // Informações
        $this->data->fbid_user = $this->input->post('fbid_user');
        $this->data->id_user   = $this->input->post('id_user');
        $this->data->nome      = $this->input->post('nome');
        $this->data->email     = $this->input->post('email');
        $this->data->mensagem  = $this->input->post('mensagem');
        $this->data->type      = $this->input->post('type');

        // Checking data
        $errors = array();

        /**
         *  Checking data consistency
         */
        // Name is empty
        if ( strlen($this->data->nome) == 0 ) {
            $errors['name'] = array(
                'id' => 'contact-name',
                'message' => 'O campo nome não pode estar vazio'
            );
        }

        // Email is invalid
        if ( !valid_email($this->data->email) ) {
            $errors['email'] = array(
                'id' => 'contact-email',
                'message' => 'O email digitado não é válido'
            );
        }

        // Email is empty
        if ( strlen($this->data->email) == 0 ) {
            $errors['email'] = array(
                'id' => 'contact-email',
                'message' => 'O campo email não pode estar vazio'
            );
        }

        // Message is empty
        if ( strlen($this->data->mensagem) == 0 ) {
            $errors['message'] =array(
                'id' => 'contact-message',
                'message' => 'O campo mensagem não pode estar vazio'
            );
        }

        // If there are errors, send back
        if ( count( $errors ) > 0 ) {
            echo json_encode($errors);
            exit;
        }

        /**
         * Defining type of message
         */

        // Body
        switch ( $this->data->type ) {
            case 'feedback':
                $this->data->assunto = 'Feedback do usuário ' . $this->data->nome;
                $html = $this->load->view('_template/components/feedback-email', $this->data, true);
                break;

            case 'report':
                $this->data->assunto = 'Problema reportado por ' . $this->data->nome;
                $this->data->url = $this->input->post('url');
                $html = $this->load->view('_template/components/report-email', $this->data, true);
                break;
        }

        // Header
        $to = array(
            'Barpedia <info@barpedia.org>',
            //'Matheus Cesario <matheus.cesario.santos@gmail.com>',
            //'Miguel Axcar <miguel.axcar@gmail.com>',
            //'André Moraes <andremoraes.72@gmail.com>'
        );

        $this->email->from($this->data->email, $this->data->nome);
        $this->email->to(implode(',', $to));
        $this->email->subject($this->data->assunto);
        $this->email->message($html);

        // Caso envie o e-mail corretamente,
        // salva os dados no banco de dados.
        if ($this->email->send()) {
            $return = $this->feedback_model->save($this->data) == 1;
        } else {
            $return = false;
        }

        echo json_encode($return);
    }

}

/* End of file feedback.php */
/* Location: ./application/controllers/feedback.php */
