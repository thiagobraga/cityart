<?php

/**
 * feedback_model.php
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Geoprocessamento de dados
 * @package   Barpedia
 * @author    Matheus Cesario <matheus@institutosoma.org.br>
 * @author    Thiago Braga <thiago@institutosoma.org.br>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $Id$
 * @link      http://barpedia.org
 * @since     File available since Release 0.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Feedback_model
 * @author Matheus Santos <matheus@institutosoma.org.br>
 * @access public
 */
class Feedback_model extends CI_Model
{

    /**
     * Salva os dados enviados no banco de dados.
     *
     * @param  {Object} $data Informações obtidas no site
     * @return {Int}          Quantidade de linhas afetadas
     */
    public function save($data)
    {
        if (!isset($data->url))
            $data->url = '';

        $this->db->query(
            "INSERT INTO
                Feedback
            VALUES
                (DEFAULT,
                '{$data->type}',
                '{$data->fbid_user}',
                '{$data->id_user}',
                '{$data->nome}',
                '{$data->email}',
                '{$data->mensagem}',
                '{$data->url}',
                DEFAULT,
                '{$data->browser}',
                '{$data->version}',
                '{$data->mobile}',
                '{$data->platform}'
            );");

        return $this->db->affected_rows();
    }
}
?>
