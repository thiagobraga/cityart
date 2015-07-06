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
class Portfolio extends CityArt
{

    /**
     * [index description]
     *
     * @return  [type]
     */
    public function index()
    {
        $this->data = array_merge($this->data, array(
            'page'    => 'Portfolio',
            'content' => 'portfolio/portfolio'
        ));

        $title = $this->data['title'] . ' | ' . $this->data['page'];
        CityArt::setTitle($title);

        $this->load->view('template', $this->data);
    }

}

/* End of file bares.php */
/* Location: ./application/controllers/bares.php */
