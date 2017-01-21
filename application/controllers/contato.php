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

}
