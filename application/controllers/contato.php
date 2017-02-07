<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Contato extends MY_Controller
{

    public function index()
    {
        $this->data = array_merge($this->data, [
            'page'    => 'Fale Conosco',
            'content' => 'contato/contato'
        ]);

        $this->data['title'] = $this->data['title'] . ' | ' . $this->data['page'];

        $this->load->view('template', $this->data);
    }

    /**
     * Send landing page e-mail.
     *
     * Send an e-mail with data obtained in landing page form.
     * If the email was successfuly saved, returns true.
     * Else, return an array with the error's messages.
     *
     * @return  {Boolean/Array}  Success or array with errors.
     */
    public function send()
    {
        // Load Email helper
        $this->load->helper('email');

        // Browser and platform information
        $this->data['browser']  = $this->agent->browser();
        $this->data['version']  = $this->agent->version();
        $this->data['mobile']   = $this->agent->mobile();
        $this->data['platform'] = $this->agent->platform();

        // Form data via post
        $this->data['name']     = $this->input->post('name');
        $this->data['email']    = $this->input->post('email');
        $this->data['message']  = $this->input->post('message');

        // Array for store errors and
        // initial value of sent state.
        $errors = [];
        $sent   = false;

        /**
         * Checking data consistency
         *
         * @todo: Create a validation method or use CodeIgniter form_validation
         */
        // Name is empty
        if (strlen($this->data['name']) == 0) {
            $errors['name'] = 'O campo nome não pode estar vazio';
        }

        // Email is invalid
        if (!valid_email($this->data['email'])) {
            $errors['email'] = 'O e-mail digitado não é válido';
        }

        // Email is empty
        if (strlen($this->data['email']) == 0) {
            $errors['email'] = 'O campo e-mail não pode estar vazio';
        }

        // Message is empty
        // Don't check this if is a premiere invite
        if (strlen($this->data['message']) == 0) {
            $errors['message'] = 'O campo mensagem não pode estar vazio';
        }

        // If there are errors, send back
        if (count($errors)) {
            echo json_encode($errors);
            exit();
        }

        // Set the message body to recipient.
        $this->data['subject'] = 'E-mail enviado pelo usuário ' . $this->data['name'];
        $html = $this->load->view('contato/email-body', $this->data, true);

        // Header
        $to = (ENVIRONMENT === 'development')
            ? ['Thiago Braga <thibraga06@gmail.com>']
            : ['CityArt <contato@cityart.com.br>'];

        $this->email->clear();

        $this->email->from($this->data['email'], $this->data['name']);
        $this->email->to(implode(',', $to));
        $this->email->subject($this->data['subject']);
        $this->email->message($html);

        try {
            $result = $this->email->send();
            if ($result) {
                $sent = true;
            }
        } catch (Exception $err) {
            $errors['form'] = $err->getMessage();
        }

        if ($sent) {
            // Send confirmation email to user.
            $from = implode($to, '');
            preg_match('/([^<]+)\s<(.*)>/', $from, $match);

            // Header
            $to = array("{$this->data['name']} <{$this->data['email']}>");

            $this->data['subject'] = 'A CityArt agradece seu contato.';
            $html = $this->load->view('contato/user-email', $this->data, true);

            $this->email->clear();

            $this->email->from($match[2], $match[1]);
            $this->email->to($to);
            $this->email->subject($this->data['subject']);
            $this->email->message($html);

            try {
                $result = $this->email->send();
                if ($result) {
                    $sent = true;
                }
            } catch (Exception $err) {
                $errors['form'] = $err->getMessage();
                $sent = false;
            }
        } else {
            $errors['form'] = 'Ocorreu um erro no envio do e-mail';
            $sent = false;
        }

        // Return
        echo $sent ? json_encode($result) : json_encode($errors);
        exit();
    }

}
