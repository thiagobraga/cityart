<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Empresa extends MY_Controller
{

    public function index()
    {
        $this->data = array_merge($this->data, [
            'page'    => 'A Empresa',
            'content' => 'empresa/empresa'
        ]);

        MY_Controller::setTitle($this->data['title'] . ' | ' . $this->data['page']);

        $this->load->view('template', $this->data);
    }

}
