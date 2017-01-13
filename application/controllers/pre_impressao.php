<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Portfolio
 *
 * @category  Geoprocessamento de dados
 * @package   Barpedia
 * @author    Matheus Cesario <matheus@institutosoma.org.br>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://barpedia.org
 * @access    public
 */
class Pre_Impressao extends MY_Controller
{

    /**
     * [index description]
     *
     * @return  [type]
     */
    public function index()
    {
        $this->data = array_merge($this->data, array(
            'page'    => 'Pré-Impressao',
            'content' => 'pre-impressao/pre-impressao'
        ));

        $title = $this->data['title'] . ' | ' . $this->data['page'];
        MY_Controller::setTitle($title);

        $this->load->view('template', $this->data);
    }

}

/* End of file bares.php */
/* Location: ./application/controllers/bares.php */
