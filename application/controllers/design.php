<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Design extends MY_Controller
{

    public function index()
    {
        $this->data = array_merge($this->data, [
            'page'     => 'Design',
            'content'  => 'design/design',
            'carousel' => [
                ['aguiar', 'Aguiar Advogados'],
                ['neusa', 'Neusa'],
                ['othon', 'Othon Management & Training'],
                ['candy', 'Candy Toy Brinquedos e Doces'],
                ['green', 'Green Brothers'],
                ['nosso-tempero', 'Nosso Tempero'],
                ['mirage', 'Mirage'],
                ['iron', 'Iron T. Jorge Fotografia'],
                ['brilar', 'Brilar'],
                ['mayara', 'Mayara Rochelle Store']
            ]
        ]);

        $this->data['title'] = $this->data['title'] . ' | ' . $this->data['page'];

        MY_Controller::loadAssets([
            'flexslider/flexslider.css',
            'flexslider/jquery.flexslider-min.js',
        ]);

        $this->load->view('template', $this->data);
    }

}
