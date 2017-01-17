<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Design extends MY_Controller
{

    public function index()
    {
        $this->data = array_merge($this->data, [
            'page'    => 'Design',
            'content' => 'design/design'
        ]);

        MY_Controller::setTitle($this->data['title'] . ' | ' . $this->data['page']);

        $this->load->view('template', $this->data);
    }

}
