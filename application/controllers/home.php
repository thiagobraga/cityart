<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Home extends MY_Controller
{

    public function index()
    {
        $this->data = array_merge($this->data, [
            'page'    => 'Página Inicial',
            'content' => 'home/home'
        ]);

        $this->data['title'] = $this->data['title'] . ' | ' . $this->data['page'];

        $this->load->view('template', $this->data);
    }

}
