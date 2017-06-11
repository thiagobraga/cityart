<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Design
 */
class Design extends MY_Controller {

    /**
     * Carrega a página de design.
     *
     * @return  void
     */
    public function index() {
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
                ['mayara', 'Mayara Rochelle Store'],
                ['atelier', 'Atelier Valentinna'],
                ['brunna', 'Estúdio Brunna Marques'],
                ['estetica', 'Estética & Cia. Cuidado Feminino'],
                ['kelly', 'Kelly Karina Make Up'],
                ['nobre', 'Nobre Minas Cachaça'],
                ['concreto', 'Concreto Imóveis'],
                ['basecar', 'Basecar Estética Automotiva'],
                ['versatil', 'Versátil Etiquetas Inteligentes'],
                ['miragebomba', 'Mirage Bomba Capilar'],
                ['mjrn', 'Marin, Jordão, Romeiro & Ribeiro Neto'],
            ]
        ]);

        $this->data['title'] = $this->data['title'] . ' | ' . $this->data['page'];

        MY_Controller::loadAssets([
            'flexslider/flexslider.css',
            'flexslider/jquery.flexslider-min.js',
        ], false);

        $this->load->view('template', $this->data);
    }
}
