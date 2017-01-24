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
                ['candy', 'Candy Toy Brinquedos e Doces'],
                ['othon', 'Othon Management & Training'],
                ['mirage', 'Mirage'],
                ['nosso-tempero', 'Nosso Tempero']
            ]
        ]);

        $this->data['title'] = $this->data['title'] . ' | ' . $this->data['page'];

        MY_Controller::loadAssets([
            'owl.carousel/dist/assets/owl.carousel.min.css',
            'owl.carousel/dist/assets/owl.theme.default.min.css',
            'owl.carousel/dist/owl.carousel.min.js',
            'owl.carousel2.thumbs/dist/owl.carousel2.thumbs.min.js',
            'assets/js/src/modules/design.js'
        ]);

        $this->load->view('template', $this->data);
    }

}
