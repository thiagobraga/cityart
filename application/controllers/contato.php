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

        MY_Controller::setTitle($this->data['title'] . ' | ' . $this->data['page']);

        $this->load->view('template', $this->data);
    }

}
