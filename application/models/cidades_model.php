<?php

/**
 * cidades_model.php
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
 * @package   Beta
 * @author    Matheus Cesario <matheus@institutosoma.org.br>
 * @author    Thiago Braga <thiago@institutosoma.org.br>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $Id$
 * @link      http://beta.institutosoma.org.br
 * @since     File available since Release 0.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cidades_model
 * @author Matheus Santos <matheus.cesario.santos@gmail.com>
 * @access public
 */
class Cidades_model extends CI_Model
{

    /**
     * {{AQUI}} document it
     */
    public function setNewZone($char_id_estado, $char_id_pais, $ainc_id_timezone)
    {
        $query = "INSERT INTO Zone
            VALUES (DEFAULT, $ainc_id_timezone, '$char_id_pais', '$char_id_estado')";

        return $this->db->query($query);
    }

    /**
     * {{AQUI}} document it
     */
    public function setNewTimezone($new_timezone)
    {
        $stam_offset_timezone = $new_timezone->rawOffset;
        $stam_dst_timezone    = $new_timezone->dstOffset;
        $char_id_timezone     = $new_timezone->timeZoneId;
        $char_name_timezone   = $new_timezone->timeZoneName;

        $query = "INSERT INTO Timezone
            VALUES (DEFAULT,
                $stam_offset_timezone,
                $stam_dst_timezone,
                '$char_id_timezone',
                '$char_name_timezone',
                DEFAULT)";

        $this->db->query($query);
        return $this->db->insert_id();
    }

    /**
     * {{AQUI}} document it
     * Default: 'America/Sao_Paulo'
     */
    public function getTimezone($char_id_estado = '27', $char_id_pais = 'BR')
    {
        $query = "SELECT
            Timezone.ainc_id_timezone,
            Timezone.stam_offset_timezone,
            Timezone.stam_dst_timezone,
            Timezone.char_id_timezone,
            Timezone.char_name_timezone,
            Timezone.stam_lastupdate_timezone

            FROM Timezone INNER JOIN Zone
                ON Timezone.ainc_id_timezone = Zone.ainc_id_timezone
            WHERE
                Zone.char_id_estado   = '$char_id_estado'
                AND Zone.char_id_pais = '$char_id_pais'
            LIMIT 1";

        return $this->db->query($query)->row();
    }

    /**
     * {{AQUI}} document it
     */
    public function updateTimezone($ainc_id_timezone, $new_timezone)
    {
        $stam_dst_timezone = $new_timezone->dstOffset;

        $query =
            "UPDATE Timezone SET
                stam_dst_timezone = $stam_dst_timezone,
                stam_lastupdate_timezone = CURRENT_DATE()

            WHERE ainc_id_timezone = $ainc_id_timezone";

        return $this->db->query($query);
    }

    /**
     * [getCityInfoByURI description]
     *
     * @param  [string] $uri String in format 'country/region/city'
     * @return [type]
     */
    public function getCityInfoByURI($uri)
    {
        if (!is_array($uri)) {
            $uri = explode('/', $uri);
        } else {
            $uri = explode('/', $uri['href']);
        }

        $location .= ($uri[2] == null) ? '': $uri[2] . ', ';
        $location .= ($uri[1] == null || $uri[1] == '-') ? '': $uri[1] . ', ';
        $location .= ($uri[0] == null) ? '': $uri[0];

        return Cidades_model::selecionarId($location);
    }

    /**
     * Get a list of most active cities in Barpedia.
     * If $ainc_id_cidade is not null, get a list of the cities
     * in the country of the user.
     *
     * Used by Barpedia Footer.
     *
     * @param  {Int}    $limit          The amout of citites to get.
     * @param  {Int}    $ainc_id_cidade The city of the user.
     * @return {Object}
     */
    public function getMostActiveCities($limit = '', $ainc_id_cidade = null)
    {
        if ($limit) {
            $limit = "LIMIT $limit";
        }

        if ($ainc_id_cidade) {
            $condition =
                "AND Cidades.char_id_pais = (
                    SELECT char_id_pais
                    FROM   Cidades
                    WHERE  ainc_id_cidade = $ainc_id_cidade
                )";
        }

        $query =
            "SELECT
                Cidades.char_nome_cidade,
                Estados.char_uf_estado,
                Paises.char_nome_pais,
                COUNT(Bares.ainc_id_bar) AS count,
                CONCAT(
                    '/', LOWER(Paises.char_id_pais), '/',
                    IF (Estados.char_nome_estado IS NULL,
                        '-/',
                        CONCAT(
                            IF (Estados.char_uf_estado = '',
                                Estados.char_nomeamigavel_estado,
                                LOWER(Estados.char_uf_estado)
                            ), '/'
                        )
                    ),
                    Cidades.char_nomeamigavel_cidade
                ) AS char_uri_cidade

            FROM
                Cidades

            INNER JOIN
                Bares ON
                Bares.ainc_id_cidade = Cidades.ainc_id_cidade

            LEFT JOIN
                Estados ON (
                    Estados.char_id_estado = Cidades.char_id_estado
                    AND Estados.char_id_pais = Cidades.char_id_pais
                )

            INNER JOIN
                Paises ON
                Paises.char_id_pais = Cidades.char_id_pais

            WHERE
                Cidades.ainc_id_cidade IN (
                    SELECT ainc_id_cidade
                    FROM   Bares
                )
                $condition

            GROUP BY
                char_nome_cidade

            $limit";

        return $this->db->query($query)->result();
    }

    /**
     * [select_id_by_position description]
     *
     * @param  integer $lat [description]
     * @param  integer $lon [description]
     * @return [type]
     */
    // {{AQUI}} coordenadas desse link https://www.facebook.com/botecojh/info
    // Não funcionam
    public function select_id_by_position($lat = 90, $lon = 90)
    {
        return $this->selecionarId('', $lat, $lon);
    }

    /**
     * Seleciona o ID da cidade passada por parâmetro
     *
     * @param  {String} $location String Containing the city, state and iso_country.
     *                                    Also, accepts city, state or city, iso_country
     *
     * @return {Object}           Object with city's information.
     *                                   If city wasn't found, return null
     */
    public function selecionarId($location = '', $lat = 90, $lon = 90)
    {
        $condition = '';
        $order_by  = '';

        // Has location
        if ($location != '') {
            $location = explode(', ', $location); // splitting location

            // Getting data from location:
            // First param: city
            $condition = " WHERE Cidades.char_nomeamigavel_cidade = '" . url_title2($location[0]) . "' ";

            // Found 3 parts: so we have state and country
            if (count($location) == 3) {
                $condition .= "AND (
                    Estados.char_uf_estado           = '$location[1]' OR
                    Estados.char_id_estado           = '$location[1]' OR
                    Estados.char_nome_estado         = '$location[1]' OR
                    Estados.char_nomeamigavel_estado = '" . url_title2($location[1]) . "'
                ) AND (
                    Cidades.char_id_pais = '$location[2]' OR
                    Paises.char_nome_pais = '$location[2]' OR
                    Paises.char_nomelocal_pais = '$location[2]'
                ) ";

            // Found 2 parts: the second param can be a state or a country
            } else if (count($location) == 2) {
                $condition .= "AND (
                    (
                        Estados.char_uf_estado           = '$location[1]' OR
                        Estados.char_id_estado           = '$location[1]' OR
                        Estados.char_nome_estado         = '$location[1]' OR
                        Estados.char_nomeamigavel_estado = '" . url_title2($location[1]) . "'
                    ) OR (
                        Cidades.char_id_pais = '$location[1]' OR
                        Paises.char_nome_pais = '$location[1]' OR
                        Paises.char_nomelocal_pais = '$location[1]'
                    )
                ) ";
            }
        }

        // Latitude and longitude range
        if ($lat < 90 && $lon < 90) {

            $distance .= ',ROUND(
                    SQRT(
                        POW(deci_latitude_cidade  - ' . $this->db->escape($lat) . ', 2) +
                        POW(deci_longitude_cidade - ' . $this->db->escape($lon) . ', 2)
                    ),
                    8
                ) as distance';

            $order_by  = ' ORDER BY distance ASC';
        }

        $query = "SELECT
                Cidades.ainc_id_cidade,
                Cidades.char_nome_cidade,
                Cidades.char_nomelocal_cidade,
                Cidades.char_nomeamigavel_cidade,
                Cidades.deci_latitude_cidade,
                Cidades.deci_longitude_cidade,

                Estados.char_id_estado,
                Estados.char_nomelocal_estado,
                IF(Estados.char_id_estado IS NULL,
                    '-',
                    IF(Estados.char_uf_estado = '',
                        Estados.char_nomeamigavel_estado,
                        Estados.char_uf_estado)
                ) as char_estado,

                LOWER(
                    CONCAT(
                        '/', Cidades.char_id_pais, '/',
                        IF (Estados.char_id_estado IS NULL,
                            '-/', CONCAT(
                                    IF(Estados.char_uf_estado = '',
                                        Estados.char_nomeamigavel_estado,
                                        Estados.char_uf_estado
                                    ), '/'
                                )
                        ),
                        Cidades.char_nomeamigavel_cidade
                    )
                ) as url,

                LOWER(Paises.char_id_pais) as char_id_pais,
                Paises.char_nomelocal_pais,
                Paises.char_nome_pais,

                CONCAT(Paises.char_lang_pais, '_',
                       Paises.char_id_pais) as 'locale'

                $distance

            FROM
                Cidades
                LEFT JOIN Estados  ON
                    (Estados.char_id_estado = Cidades.char_id_estado
                        AND Estados.char_id_pais = Cidades.char_id_pais)
                INNER JOIN Paises
                    ON Cidades.char_id_pais = Paises.char_id_pais

                $condition
                $order_by
            LIMIT 1";

        // Executing query
        $return = $this->db->query($query)->row();

        if(isset($return->ainc_id_cidade)) return $return;
        else return null;
    }

    /**
     * Retorna o nome e ID da cidade passada por parâmetro
     *
     * @return {Object}
     */
    public function selecionarCidade($cidade)
    {
        if (is_numeric($cidade)) {
            $condition = "WHERE ainc_id_cidade = $cidade";
        } else if(strlen($cidade) > 0) {
            $condition = "WHERE char_nomeamigavel_cidade = '$cidade' OR
                char_nome_cidade = '" . ucfirst($cidade) . "'";
        }

        return $this->db->query(
            "SELECT
                Cidades.ainc_id_cidade,
                Cidades.char_nome_cidade,
                Cidades.char_nomelocal_cidade,
                Cidades.char_nomeamigavel_cidade,

                IF(Estados.char_uf_estado = '',
                    Estados.char_nomeamigavel_estado,
                    Estados.char_uf_estado) as char_estado,

                Estados.char_id_estado,
                Estados.char_uf_estado,
                Estados.char_nome_estado,
                Estados.char_nomelocal_estado,

                LOWER(
                    CONCAT(
                        '/', Cidades.char_id_pais,
                        '/',
                        IF (Estados.char_id_estado IS NULL,
                            '-/',
                            CONCAT(
                                IF(Estados.char_uf_estado = '',
                                    Estados.char_nomeamigavel_estado,
                                    Estados.char_uf_estado
                                ), '/'
                            )
                        ),
                        Cidades.char_nomeamigavel_cidade
                    )
                ) as url,

                Cidades.char_id_pais

            FROM
                Cidades LEFT JOIN Estados
                    ON (Cidades.char_id_estado = Estados.char_id_estado
                        AND Cidades.char_id_pais = Estados.char_id_pais)

                $condition
            LIMIT 1")->row();
    }

    /**
     * Seleciona as coordenadas da cidade
     *
     * @param  {String} $cidade O nome amigável da cidade
     * @return {Object}
     */
    public function selecionarPosicaoCidade($cidade)
    {
        return $this->db->query(
            "SELECT
                deci_latitude_cidade,
                deci_longitude_cidade
            FROM
                Cidades
            WHERE
                char_nomeamigavel_cidade = '$cidade'
            LIMIT
                1")->row();
    }

    /**
     * [selecionarIdioma description]
     *
     * @param  [type] $cidade [description]
     * @return [type]
     */
    // public function selecionarIdioma($cidade)
    // {
    //     return $this->db->query(
    //         "SELECT
    //             char_id_pais
    //         FROM
    //             Cidades
    //         WHERE
    //             char_nomeamigavel_cidade = '$cidade' OR
    //             char_nome_cidade = '$cidade'
    //         LIMIT
    //             1")->row()->char_id_pais;
    // }

    /**
     * [loadCities description]
     *
     * @param  {String}  $q  Parâmetro de busca. Nome da cidade ou parte desse nome
     * @return {Object}      Cidades encontradas que condizem com o argumento de busca
     */
    public function loadCities($q)
    {
        $search  = $this->db->escape_like_str($q);
        $replace = str_replace(' ', '-', $q);

        $query =
            "SELECT
                Cidades.char_nome_cidade AS cidade,
                Cidades.char_nomelocal_cidade AS alt_cidade,
                Cidades.inte_pop_cidade AS populacao,

                COUNT(Usuarios.ainc_id_usuario) AS usuarios,

                IF (Estados.char_nome_estado IS NULL,
                    '-',
                    IF (Estados.char_uf_estado = '',
                        Estados.char_nome_estado,
                        Estados.char_uf_estado)
                ) AS estado,

                IF (Estados.char_nome_estado IS NULL,
                    '-',
                    IF(Estados.char_uf_estado = '',
                        Estados.char_nomelocal_estado,
                        Estados.char_uf_estado)
                )  AS alt_estado,

                CONCAT('/',
                        LOWER(Paises.char_id_pais), '/',
                        IF(Estados.char_nome_estado IS NULL,
                            '-/',
                            CONCAT(
                                IF(Estados.char_uf_estado = '',
                                    Estados.char_nomeamigavel_estado,
                                    LOWER(Estados.char_uf_estado)
                                ), '/'
                            )
                        ),
                        Cidades.char_nomeamigavel_cidade) AS uri,

                Paises.char_nome_pais AS pais,
                Paises.char_nomelocal_pais AS alt_pais,
                LOWER(Paises.char_id_pais) AS iso_pais,

                CONCAT(
                    Cidades.char_nomelocal_cidade, ' ',
                    Cidades.char_nome_cidade, ' ',
                    REPLACE(Cidades.char_nomeamigavel_cidade, '-', ' '), ' ',

                    Estados.char_nomelocal_estado, ' ',
                    Estados.char_uf_estado, ' ',

                    Paises.char_nomelocal_pais, ' ',
                    Paises.char_nome_pais) AS name

            FROM
                Cidades

            LEFT JOIN
                Estados ON (
                    Estados.char_id_estado = Cidades.char_id_estado
                    AND Estados.char_id_pais = Cidades.char_id_pais
                )

            INNER JOIN
                Paises ON
                Paises.char_id_pais = Cidades.char_id_pais

            LEFT JOIN
                Usuarios ON
                Usuarios.ainc_id_cidade = Cidades.ainc_id_cidade

            WHERE
                Cidades.char_id_pais <> 'BR'
                AND (
                    Cidades.char_nome_cidade LIKE '%$q%'
                    OR Cidades.char_nomelocal_cidade LIKE '%$q%'
                    OR Cidades.char_nomeamigavel_cidade LIKE '%$replace%'

                    OR Estados.char_nome_estado LIKE '%$q%'
                    OR Estados.char_nomelocal_estado LIKE '%$q%'
                    OR Estados.char_nomeamigavel_estado LIKE '%$q%'

                    OR Paises.char_nomelocal_pais LIKE '%$q%'
                    OR Paises.char_nome_pais LIKE '%$q%'
                )

            GROUP BY
                Cidades.ainc_id_cidade

            ORDER BY
                Cidades.inte_pop_cidade DESC,
                usuarios DESC";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * [isCountry description]
     *
     * @param  [type]  $id_country [description]
     * @return boolean
     */
    public function isCountry($id_country) {
        $response = $this->db->query(
            "SELECT char_id_pais
            FROM Paises
            WHERE char_id_pais = '$id_country'
            LIMIT 1")->row();

        if($response != NULL) {
            return $response->char_id_pais;
        } else {
            return null;
        }
    }

    /**
     * [isState description]
     *
     * @param  [type]  $country [description]
     * @param  [type]  $state   [description]
     * @return boolean
     */
    public function isState($country, $state) {
        $response = $this->db->query(
            "SELECT char_id_estado
            FROM Estados
            WHERE
                (char_nomeamigavel_estado = '$state'
                    OR char_uf_estado = '$state'
                        OR  char_id_estado = '$state')
                AND char_id_pais = '$country'
            LIMIT 1")->row();

        if($response != NULL) {
            return $response->char_id_estado;
        } else {
            return null;
        }
    }

    /**
     * [isCity description]
     *
     * @param  [type]  $country [description]
     * @param  [type]  $state   [description]
     * @param  [type]  $city    [description]
     * @return boolean
     */
    public function isCity($country, $state, $city) {
        if($state != '') {
            $state_condition = "AND (char_id_estado = '$state')";
        } else {
            $state_condition = '';
        }

        $response = $this->db->query(
            "SELECT ainc_id_cidade
            FROM Cidades
            WHERE
                char_nomeamigavel_cidade = '$city'
                $state_condition
                AND char_id_pais = '$country'
            LIMIT 1")->row();

        if($response != NULL) {
            return $response->ainc_id_cidade;
        } else {
            return null;
        }
    }

    /**
     * Insere o nome amigável da cidade na tabela
     *
     * @return {void}
     */
    public function atualizarNomeAmigavel()
    {
        $result = $this->db->query(
            "SELECT
                ainc_id_cidade,
                char_nome_cidade
            FROM
                Cidades")->result();

        foreach ($result as $row) {
            $nome_amigavel = url_title2($row->char_nome_cidade, 'dash', true);

            $this->db->query(
                "UPDATE
                    Cidades
                SET
                    char_nomeamigavel_cidade = \"$nome_amigavel\"
                WHERE
                    ainc_id_cidade = " . $row->ainc_id_cidade . ";");
        }
    }

    /**
     * [get_hottest_city description]
     *
     * @param  [type] $iso_country [description]
     * @param  string $iso_region  [description]
     * @return [type]
     */
    public function get_hottest_city($iso_country, $iso_region = '')
    {
        $condition = '';
        if($iso_region != '') {
            $condition = "AND Cidades.char_id_estado = '$iso_region'";
        }

        $query = "SELECT Cidades.ainc_id_cidade, COUNT(ainc_id_bar) as total
            FROM Cidades
                INNER JOIN Paises ON Cidades.char_id_pais = Paises.char_id_pais
                LEFT JOIN Bares ON Bares.ainc_id_cidade = Cidades.ainc_id_cidade
            WHERE Paises.char_id_pais = '$iso_country'
                $condition
            GROUP BY ainc_id_cidade
            ORDER BY total DESC, inte_pop_cidade DESC
            LIMIT 1";

        $data = $this->db->query($query)->row();

        return $data->ainc_id_cidade;
    }

}
