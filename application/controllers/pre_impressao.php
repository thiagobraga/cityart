<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Pre_Impressao extends MY_Controller
{

    public function index()
    {
        $this->data = array_merge($this->data, [
            'page'    => 'Pré-Impressao',
            'content' => 'pre-impressao/pre-impressao'
        ]);

        $this->data['title'] = $this->data['title'] . ' | ' . $this->data['page'];

        $this->load->view('template', $this->data);
    }

}
