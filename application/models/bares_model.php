<?php

/**
 * bares_model.php
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
 * @author    Thiago Braga <thiago@institutosoma.org.br>
 * @author    Matheus Cesario <matheus@institutosoma.org.br>
 * @copyright 1997-2005 The PHP Group
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   GIT: $Id$
 * @link      http://barpedia.org
 * @since     File available since Release 0.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bares_model
 * @author Matheus Santos <matheus.cesario.santos@gmail.com>
 * @access public
 */
class Bares_model extends CI_Model
{

    /**
     * Select the ID of the bar using the friendly URL.
     *
     * @param  {String} $nomeamigavel_bar URI que contém nome do bar
     * @return {Object}
     */
    public function getIdBar($nomeamigavel_bar)
    {
        $query =
            "SELECT
                ainc_id_bar
            FROM
                Bares
            WHERE
                char_nomeamigavel_bar = '$nomeamigavel_bar'
                OR char_fbid_bar = '$nomeamigavel_bar'
            LIMIT
                1";

        return $this->db
            ->query($query)
            ->row()
            ->ainc_id_bar;
    }

    /**
     * Get link by bar's id
     * @param  [type] $arg [description]
     * @return [type]      [description]
     */
    public function getLinkBar($arg)
    {
        $query =
            "SELECT
                LOWER(
                    CONCAT('/',
                        Cidades.char_id_pais, '/',
                        IF(Estados.char_id_estado IS NULL,
                            '-',
                            IF(Estados.char_uf_estado = '',
                                Estados.char_nomeamigavel_estado,
                                Estados.char_uf_estado)
                        ), '/',
                        Cidades.char_nomeamigavel_cidade, '/',
                        char_nomeamigavel_bar
                    )
                ) AS link

            FROM
                Bares

            INNER JOIN
                Cidades ON
                Bares.ainc_id_cidade = Cidades.ainc_id_cidade

            INNER JOIN
                Estados ON (
                    Cidades.char_id_pais = Estados.char_id_pais
                    AND Cidades.char_id_estado = Estados.char_id_estado
                )

            WHERE
                char_nomeamigavel_bar = '$arg'
                OR char_fbid_bar = '$arg'

            LIMIT
                1";

        return $this->db
            ->query($query)
            ->row()
            ->link;
    }

    /**
     * Get the categories of filters for each bar.
     *
     * For each bar, gets the categories that the bar has filters
     * and the most voted filter for each category.
     *
     * @param  {Int}     $id      The ID of the bar.
     * @param  {String}  $filter  Get specific filter categories.
     * @return {Object}
     */
    public function getCategoriesMostVotedFilter($ainc_id_bar, $filter = 'unique')
    {
        if ($filter == 'multiple') {
            $additional_field =
                ", (
                    SELECT
                        GROUP_CONCAT(DISTINCT f_b.ainc_id_usuario)
                    FROM
                        Filtros_Bares f_b
                    WHERE
                        f_b.ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar
                        AND f_b.ainc_id_bar = $ainc_id_bar
                ) AS usuarios";
        } else {
            $additional_field = '';
        }

        $query =
            "SELECT
                FiltrosBarCategorias.ainc_id_filtrobarcategoria,
                FiltrosBarCategorias.char_titulo_filtrobarcategoria,
                FiltrosBar.char_texto_filtrobar,
                (
                    SELECT
                        COUNT(DISTINCT f_b.ainc_id_usuario)
                    FROM
                        Filtros_Bares f_b
                    WHERE
                        f_b.ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar
                        AND f_b.ainc_id_bar = $ainc_id_bar
                ) AS total_usuarios
                $additional_field

            FROM
                Filtros_Bares

            INNER JOIN
                FiltrosBar ON
                (FiltrosBar.ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar)

            INNER JOIN
                FiltrosBarCategorias ON
                (FiltrosBarCategorias.ainc_id_filtrobarcategoria = FiltrosBar.ainc_id_filtrobarcategoria)

            WHERE
                Filtros_Bares.ainc_id_bar = $ainc_id_bar
                AND FiltrosBarCategorias.enum_tipo_filtrobarcategoria = '$filter'

            GROUP BY
                FiltrosBar.char_texto_filtrobar

            ORDER BY
                char_titulo_filtrobarcategoria,
                total_usuarios DESC";

        return $this->db->query($query)->result();
    }

    /**
     * Return the count of users that voted in a specific filter for the bar.
     *
     * @param  [type] $ainc_id_bar [description]
     * @param  [type] $filter      [description]
     * @return [type]
     */
    public function countUsersByFilter($ainc_id_bar, $filter)
    {
        $query =
            "SELECT
                COUNT(Filtros_Bares.ainc_id_usuario) AS total

            FROM
                Bares

            INNER JOIN
                Filtros_Bares ON
                Filtros_Bares.ainc_id_bar = Bares.ainc_id_bar

            INNER JOIN
                FiltrosBar ON
                FiltrosBar.ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar

            WHERE
                Bares.ainc_id_bar = $ainc_id_bar
                AND FiltrosBar.ainc_id_filtrobar = $filter

            LIMIT
                1";

        return (int) $this->db
            ->query($query)
            ->row()
            ->total;
    }

    /**
     * Gets a list of states.
     *
     * Realiza um SELECT trazendo código e sigla
     * de todos os estados cadastrados. Método utilizado
     * no cadastro de novos bares.
     *
     * @return {Object} Lista com código e sigla dos estados
     */
    public function selecionarEstados()
    {
        $query =
            "SELECT
                ainc_id_estado,
                char_uf_estado
            FROM
                Estados";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * Obtém uma lista de cidades
     *
     * Realiza um SELECT trazendo código, nome e
     * nome amigável das cidades cadastradas, passando
     * o código do estado como parâmetro. Método utilizado
     * no cadastro de novos bares.
     *
     * @param  {Int}   $estado O código do estado
     * @return {Object}        Lista de cidades deste estado
     */
    public function selecionarCidades($estado)
    {
        return $this->db->query(
            "SELECT
                ainc_id_cidade
                char_nome_cidade
                char_nomeamigavel_cidade
            FROM
                Cidades
            WHERE
                char_id_regiao = $estado ")->result();
    }

    /**
     * Verifica a existência de um bar
     *
     * @param  {String} $bar O nome amigável do bar
     * @return {Object}
     */
    public function verificarBar($bar)
    {
        return $this->db->query(
            "SELECT
                char_nomeamigavel_bar
            FROM
                Bares
            WHERE
                char_nomeamigavel_bar = '$bar'")->row();
    }

    /**
     * Seleciona os bares da cidade passada por parâmetro
     *
     * @access public
     * @param  [type] $cidade  [description]
     * @param  [type] $filtros [description]
     * @return [type]          [description]
     */
    public function getBarsByFilter($ainc_id_cidade, $limit, $filters = null)
    {
        $order = null;

        if ($filters != null) {
            $filters = " AND Filtros_Bares.ainc_id_filtrobar IN ($filters)";
            $order = 'count_filters DESC,';
        }

        $query =
            "SELECT
                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar,
                Bares.char_logo_bar,
                Bares.char_endereco_bar,
                ROUND(Bares.inte_somatorionotas_bar / Bares.inte_qtdenotas_bar, 1) AS inte_nota_bar,
                GROUP_CONCAT(
                    DISTINCT FiltrosBar.char_texto_filtrobar
                    ORDER BY FiltrosBar.char_texto_filtrobar ASC
                    SEPARATOR ', '
                ) AS char_texto_filtrobar,
                COUNT(
                    DISTINCT FiltrosBar.ainc_id_filtrobar
                ) AS count_filters

            FROM
                Bares
            LEFT JOIN
                Filtros_Bares ON
                Filtros_Bares.ainc_id_bar = Bares.ainc_id_bar
            LEFT JOIN
                FiltrosBar ON
                FiltrosBar.ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Bares.ainc_id_cidade
            WHERE
                Cidades.ainc_id_cidade = $ainc_id_cidade
                $filters
            GROUP BY
                Bares.ainc_id_bar
            ORDER BY
                $order
                inte_nota_bar DESC,
                inte_qtdenotas_bar DESC,
                char_nome_bar ASC
            LIMIT
                " . $limit['start'] . "," . $limit['amount'];

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * Get all data from bars of a city.
     * Used in Places page.
     *
     * @param  {Int}    $ainc_id_cidade The ID of the city.
     * @return {Object}
     */
    public function getBarsByPlace($ainc_id_cidade)
    {
        $query =
            "SELECT
                Bares.ainc_id_bar,
                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar,
                Bares.char_descricao_bar,
                Bares.char_endereco_bar,
                Bares.char_logo_bar,
                Bares.inte_qtdenotas_bar,
                Bares.inte_somatorionotas_bar,
                GROUP_CONCAT(
                    DISTINCT FiltrosBar.char_texto_filtrobar
                    ORDER BY FiltrosBar.char_texto_filtrobar ASC
                    SEPARATOR ', '
                ) AS char_texto_filtrobar,
                ROUND(
                    Bares.inte_somatorionotas_bar / Bares.inte_qtdenotas_bar, 1
                ) AS inte_nota_bar

            FROM
                Bares
            LEFT JOIN
                Filtros_Bares ON
                Filtros_Bares.ainc_id_bar = Bares.ainc_id_bar
            LEFT JOIN
                FiltrosBar ON
                FiltrosBar.ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Bares.ainc_id_cidade
            WHERE
                Cidades.ainc_id_cidade = $ainc_id_cidade
            GROUP BY
                Bares.ainc_id_bar
            ORDER BY
                inte_nota_bar DESC,
                inte_qtdenotas_bar DESC,
                char_nome_bar ASC";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * [getCarouselPhotos description]
     *
     * @param integer $num [description]
     */
    public function getCarouselPhotos($num = 5, $ainc_id_cidade)
    {
        $query =
            "SELECT
                char_nome_bar,
                char_endereco_bar,
                char_nomeamigavel_bar,
                ROUND(inte_somatorionotas_bar/inte_qtdenotas_bar, 1) AS nota_bar,
                (
                    SELECT   char_filename_photobar
                    FROM     Photos_Bar
                    WHERE    ainc_id_bar = Bares.ainc_id_bar
                    ORDER BY int_likes_photobar DESC
                    LIMIT    1
                ) AS char_filename
            FROM
                Bares
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Bares.ainc_id_cidade
            WHERE
                Cidades.ainc_id_cidade = $ainc_id_cidade
            HAVING
                char_filename IS NOT NULL
            ORDER BY
                nota_bar DESC
            LIMIT
                $num";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * [QuantidadeBares description]
     *
     * @param [type] $filtros [description]
     * @param [type] $cidade  [description]
     */
    public function getAmountOfBars($ainc_id_cidade, $filters = '')
    {
        if ($filters != '')
            $filters = "AND Filtros_Bares.ainc_id_filtrobar IN ($filters)";

        return $this->db->query(
            "SELECT
                COUNT(DISTINCT Bares.ainc_id_bar) AS total
            FROM
                Bares
            LEFT JOIN
                Filtros_Bares ON
                Filtros_Bares.ainc_id_bar = Bares.ainc_id_bar
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Bares.ainc_id_cidade
            WHERE
                Cidades.ainc_id_cidade = $ainc_id_cidade
                $filters
            LIMIT 1")->row()->total;
    }

    /**
     * Gets the rank position of the bar.
     *
     * In a list of all bars in a city, passed as $ainc_id_cidade,
     * gets the rank position of the bar passed as $ainc_id_bar.
     *
     * If the bar doesn't have a minimun of 20 votes, the rank will
     * be displayed as "#?" with the text "In review".
     *
     * @param  {Int} $ainc_id_bar    The ID of the bar
     * @param  {Int} $ainc_id_cidade The ID of the city
     * @return {Object}
     */
    public function getIndexBar($ainc_id_bar, $ainc_id_cidade)
    {
        $config_bar = $this->config->item('bar');
        $review = $config_bar['review'];

        if ($review['below_minimum_hidden_all']) {
            $rank = '';
        } else {
            if ($review['below_minimum_hidden_rank']) {
                $rank =
                    ", CASE
                        WHEN Temp2.inte_qtdenotas_bar >= " . $review['minimum_reviews'] . "
                        THEN Temp2.rank
                        ELSE '?'
                    END AS rank";
            } else {
                $rank = ', Temp2.rank';
            }
        }

        $this->db->query("SET @i = 0;");
        return $this->db->query(
            "SELECT
                Temp2.inte_nota_bar
                $rank
            FROM (
                SELECT
                    Temp1.ainc_id_bar,
                    Temp1.inte_nota_bar,
                    Temp1.inte_qtdenotas_bar,
                    @i := @i + 1 AS rank
                FROM (
                    SELECT
                        Bares.ainc_id_bar,
                        Bares.inte_qtdenotas_bar,
                        ROUND(Bares.inte_somatorionotas_bar / Bares.inte_qtdenotas_bar, 1) AS inte_nota_bar
                    FROM
                        Bares
                    LEFT JOIN
                        Filtros_Bares ON
                        (Filtros_Bares.ainc_id_bar = Bares.ainc_id_bar)
                    INNER JOIN
                        Cidades ON
                        (Cidades.ainc_id_cidade = Bares.ainc_id_cidade)
                    WHERE
                        Cidades.ainc_id_cidade = $ainc_id_cidade
                    GROUP BY
                        Bares.ainc_id_bar
                    ) AS Temp1

                ORDER BY
                    inte_nota_bar DESC
            ) AS Temp2

            WHERE
                Temp2.ainc_id_bar = $ainc_id_bar")->result();
    }

    /**
     * Selecting bar categories
     *
     * @param  (string) $type  Type of category: unique, multiple
     * @return (array)         Array with categories that belong to $type
     */
    public function getCategories($type='unique')
    {
        return $this->db->query(
            "SELECT
                FiltrosBarCategorias.ainc_id_filtrobarcategoria,
                FiltrosBarCategorias.char_titulo_filtrobarcategoria,
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        FiltrosBar.ainc_id_filtrobar, ',',
                        FiltrosBar.char_texto_filtrobar
                    )
                    ORDER BY FiltrosBar.ainc_id_filtrobar ASC
                    SEPARATOR ';'
                ) AS filtros
            FROM
                FiltrosBarCategorias
            INNER JOIN
                FiltrosBar ON
                FiltrosBarCategorias.ainc_id_filtrobarcategoria = FiltrosBar.ainc_id_filtrobarcategoria
            WHERE
                enum_tipo_filtrobarcategoria = UPPER('$type')
            GROUP BY
                FiltrosBarCategorias.ainc_id_filtrobarcategoria
            ORDER BY
                ainc_id_filtrobarcategoria ASC")->result();
    }

    /**
     * [selecionarFiltros description]
     *
     * @return [type] [description]
     */
    public function selecionarFiltros()
    {
        return $this->db->query(
            "SELECT DISTINCT
                FiltrosBar.ainc_id_filtrobar,
                char_texto_filtrobar,
                FiltrosBarCategorias.ainc_id_filtrobarcategoria,
                char_titulo_filtrobarcategoria
            FROM
                FiltrosBar
            INNER JOIN
                FiltrosBarCategorias
                ON FiltrosBarCategorias.ainc_id_filtrobarcategoria = FiltrosBar.ainc_id_filtrobarcategoria
            WHERE
                FiltrosBarCategorias.ainc_id_lingua = 1
            ORDER BY
                char_titulo_filtrobarcategoria")->result();
    }

    /**
     * Seleciona todos os filtros que caracterizam um bar de determinada cidade
     * Todos os filtros registrados na cidade
     *
     * @param  [type] $ainc_id_cidade [description]
     * @return [type]
     */
    public function selecionarFiltrosPorCidade($ainc_id_cidade)
    {
        return $this->db->query(
            "SELECT
                DISTINCT
                FiltrosBarCategorias.ainc_id_filtrobarcategoria,
                FiltrosBarCategorias.char_titulo_filtrobarcategoria,
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        FiltrosBar.ainc_id_filtrobar, ',',
                        FiltrosBar.char_texto_filtrobar
                    )
                    ORDER BY FiltrosBar.char_texto_filtrobar
                    DESC SEPARATOR ';'
                ) as filtros

            FROM
                Filtros_Bares

            INNER JOIN
                Bares ON
                Filtros_Bares.ainc_id_bar = Bares.ainc_id_bar
            INNER JOIN
                FiltrosBar ON
                Filtros_Bares.ainc_id_filtrobar = FiltrosBar.ainc_id_filtrobar
            INNER JOIN
                FiltrosBarCategorias ON
                FiltrosBar.ainc_id_filtrobarcategoria = FiltrosBarCategorias.ainc_id_filtrobarcategoria

            WHERE
                Bares.ainc_id_cidade = '$ainc_id_cidade'
            GROUP BY
                FiltrosBarCategorias.ainc_id_filtrobarcategoria
            ORDER BY
                ainc_id_filtrobarcategoria ASC")->result();
    }

    /**
     * [selecionarFiltro description]
     *
     * @return [type] [description]
     */
    public function selecionarFiltro($id_filtro)
    {
        return $this->db->query(
            "SELECT
                ainc_id_filtrosbares,
                ainc_id_bar,
                char_texto_filtrobar,
                char_titulo_filtrobarcategoria

            FROM
                Filtros_Bares
            INNER JOIN
                FiltrosBar
                ON Filtros_Bares.ainc_id_filtrobar = FiltrosBar.ainc_id_filtrobar
            INNER JOIN
                FiltrosBarCategorias
                ON FiltrosBarCategorias.ainc_id_filtrobarcategoria = FiltrosBar.ainc_id_filtrobarcategoria

            WHERE
                ainc_id_filtrosbares = $id_filtro
            ORDER BY
                char_texto_filtrobar
            LIMIT 1")->row();
    }

    /**
     * [ description] {{AQUI}} NOTE: DEPRECATED
     *
     * @return [type] [description]
     */
    public function salvarTag($id_bar, $usuario, $tag)
    {
        $query =
            "INSERT INTO
                Filtros_Bares
                (ainc_id_bar, ainc_id_usuario, ainc_id_filtrobar)
            VALUES
                ($id_bar, $usuario, $tag)";

        $this->db->query($query);
        return $this->db->insert_id();
    }

    /**
     * Carrega os dados do bar
     *
     * @param  [int]    $ainc_id_bar  Bar's id
     * @return [string] Friendly name
     */
    public function getFriendlyName($ainc_id_bar)
    {
        $query = "SELECT char_nomeamigavel_bar FROM Bares WHERE ainc_id_bar = $ainc_id_bar LIMIT 1";
        $friendly_name = $this->db->query($query)->row();

        return ($friendly_name == null) ? '': $friendly_name->char_nomeamigavel_bar;
    }

    /**
     * Carrega os dados do bar
     *
     * @param  [type] $nome_bar [description]
     * @return [type]           [description]
     */
    public function load($id_bar)
    {
        $query = $this->db->query(
            "SELECT
                Bares.ainc_id_bar,
                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar,
                Bares.char_descricao_bar,
                Bares.char_logo_bar,
                Bares.char_facebook_bar,
                Bares.char_website_bar,
                Bares.char_endereco_bar,
                Bares.char_zip_bar,
                Bares.char_telefone_bar,
                Bares.stam_datainclusao_bar,
                Bares.inte_qtdenotas_bar,
                Bares.inte_somatorionotas_bar,
                Bares.deci_longitude_bar,
                Bares.deci_latitude_bar,
                Bares.char_fbid_bar,

                Cidades.ainc_id_cidade,
                Cidades.char_nomelocal_cidade,
                Cidades.char_nomeamigavel_cidade,

                Estados.char_id_estado,
                Estados.char_uf_estado,
                Estados.char_nome_estado,
                Estados.char_nomelocal_estado,
                IFNULL(
                    IF(Estados.char_uf_estado = '',
                        Estados.char_nomeamigavel_estado,
                        Estados.char_uf_estado)
                    , '-') as char_nomeamigavel_estado,

                Paises.char_nomelocal_pais,
                Paises.char_id_pais,

                Usuarios.ainc_id_usuario,
                Usuarios.char_nome_usuario,
                Usuarios.char_sobrenome_usuario,
                Usuarios.char_fbid_usuario

            FROM
                Bares
            LEFT JOIN
                Cidades ON
                (Bares.ainc_id_cidade = Cidades.ainc_id_cidade)
            LEFT JOIN
                Estados ON
                (Estados.char_id_estado = Cidades.char_id_estado)
            LEFT JOIN
                Paises ON
                (Estados.char_id_pais = Paises.char_id_pais)
            INNER JOIN
                Bar_User ON
                (Bares.ainc_id_bar = Bar_User.ainc_id_bar
                    AND Bar_User.enum_level = 'HERALD')
            INNER JOIN
                Usuarios ON
                (Bar_User.ainc_id_usuario = Usuarios.ainc_id_usuario)
            WHERE
                Bares.ainc_id_bar = $id_bar
            LIMIT
                1")->row();

        return ($query);
    }

    /**
     * [getBarLocation description]
     *
     * @param   [type]  $ainc_id_bar
     * @return  [type]
     */
    public function getBarLocation ($ainc_id_bar)
    {
        $query = "SELECT
            Bares.deci_latitude_bar,
            Bares.deci_longitude_bar,

            Cidades.ainc_id_cidade,
            Cidades.char_id_estado,
            Cidades.char_id_pais

            FROM Bares
                INNER JOIN Cidades ON Bares.ainc_id_cidade = Cidades.ainc_id_cidade
            WHERE ainc_id_bar = $ainc_id_bar LIMIT 1";

        return $this->db->query($query)->row();
    }

    /**
     * Get the tags of a bar of a specific category.
     *
     * @param  [type] $ainc_id_bar   [description]
     * @param  [type] $category_type [description]
     * @return [type]
     */
    public function getBarTags($ainc_id_bar, $category_type)
    {
        $query =
            "SELECT
                char_titulo_filtrobarcategoria,
                COUNT(Filtros_Bares.ainc_id_filtrobar) AS total_filtros,
                GROUP_CONCAT(
                    DISTINCT CONCAT(
                        char_texto_filtrobar,
                        ',',
                        (
                            SELECT DISTINCT COUNT(ainc_id_filtrobar)
                            FROM   Filtros_Bares fb
                            WHERE  ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar
                            AND    ainc_id_bar = $ainc_id_bar
                        )
                    )
                    ORDER BY char_texto_filtrobar DESC
                    SEPARATOR ';'
                ) AS filtros

            FROM
                Filtros_Bares

            INNER JOIN
                FiltrosBar ON
                Filtros_Bares.ainc_id_filtrobar = FiltrosBar.ainc_id_filtrobar

            INNER JOIN
                FiltrosBarCategorias ON
                FiltrosBarCategorias.ainc_id_filtrobarcategoria = FiltrosBar.ainc_id_filtrobarcategoria

            WHERE
                Filtros_Bares.ainc_id_bar = $ainc_id_bar
                AND FiltrosBarCategorias.enum_tipo_filtrobarcategoria = '$category_type'

            GROUP BY
                FiltrosBarCategorias.ainc_id_filtrobarcategoria

            ORDER BY
                char_titulo_filtrobarcategoria";

        return $this->db->query($query)->result();
    }

    /**
     * [show description]
     *
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function getMenu($ainc_id_bar, $page=0)
    {
        return $this->db->query(
            "SELECT DISTINCT
                MenuItems.ainc_id_menuitem,
                MenuItems.char_name_menuitem,
                MenuItems.stamp_creation_menuitem,
                (SELECT COUNT(ainc_id)
                    FROM MenuItems_Indications
                    WHERE ainc_id_menuitem = MenuItems.ainc_id_menuitem
                        AND ainc_id_bar = $ainc_id_bar
                ) as 'inte_total_indications'
            FROM MenuItems
                INNER JOIN MenuItems_Indications
                    ON MenuItems.ainc_id_menuitem = MenuItems_Indications.ainc_id_menuitem
            WHERE MenuItems_Indications.ainc_id_bar = $ainc_id_bar
            ORDER BY
                inte_total_indications DESC,
                MenuItems.char_name_menuitem ASC
            LIMIT $page, 5")->result();
    }

    /**
     * [getIndications description]
     * @param  [type] $ainc_id_bar [description]
     * @param  [type] $page        [description]
     * @return [type]              [description]
     */
    public function getIndications($ainc_id_bar, $ainc_id_menuitem, $page)
    {
        return $this->db->query(
            "SELECT
                Usuarios.ainc_id_usuario,
                Usuarios.char_fbid_usuario,
                CONCAT(Usuarios.char_nome_usuario, ' ',
                       Usuarios.char_sobrenome_usuario) as char_nomecompleto_usuario,

                MenuItems_Indications.char_comment,
                MenuItems_Indications.stamp_creation
            FROM
                MenuItems_Indications INNER JOIN Usuarios
                    ON MenuItems_Indications.ainc_id_usuario =
                        Usuarios.ainc_id_usuario
            WHERE
                MenuItems_Indications.ainc_id_menuitem = $ainc_id_menuitem
                AND MenuItems_Indications.ainc_id_bar = $ainc_id_bar
            LIMIT $page, 5
        ")->result();
    }

    /**
     * TYPEAHEAD
     */

    /**
     * [getMenuItems description]
     *
     * @param  [type] $ainc_id_cidade [description]
     * @return [type]
     */
    public function getMenuItems($ainc_id_cidade)
    {
        return $this->db->query(
            "SELECT
                MenuItems.char_name_menuitem
            FROM
                MenuItems
            ORDER BY
                MenuItems.char_name_menuitem DESC")->result();
    }

    /**
     * Seleciona os bares da cidade passada por parâmetro.
     *
     * @param  [type] $cidade [description]
     * @return [type]         [description]
     */
    public function getBars($ainc_id_cidade)
    {
        return $this->db->query(
            "SELECT
                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar,
                Bares.char_endereco_bar,
                Bares.char_logo_bar,

                ROUND(Bares.inte_somatorionotas_bar/Bares.inte_qtdenotas_bar, 1) AS 'nota',
                LOWER(
                    CONCAT(
                        Cidades.char_nome_cidade, '/',
                        Bares.char_nomeamigavel_bar
                    )
                ) AS 'url'
            FROM
                Bares INNER JOIN Cidades
                    ON Bares.ainc_id_cidade = Cidades.ainc_id_cidade
            WHERE
                Bares.ainc_id_cidade = '$ainc_id_cidade'")->result();
    }

    /**
     * Selecionando eventos aleatorios de uma cidade
     * @param  [type] $ainc_id_cidade [description]
     * @return [type]                 [description]
     */
    public function getEvents($ainc_id_cidade)
    {
        $agora = date('Y-m-d H:i:s', strtotime('now'));

        return $this->db->query(
            "SELECT
                ainc_id_eventobar,
                char_titulo_eventobar,
                inte_faixapreco_eventobar,
                int_likes,
                int_dislikes,
                char_nome_bar,
                char_endereco_bar,
                char_nomeamigavel_bar,
                stam_inicio_evento,
                CONCAT('http://facebook.com/events/', char_fbid_eventobar) AS 'url'
            FROM
                EventosBar
            INNER JOIN
                Bares ON
                (EventosBar.ainc_id_bar = Bares.ainc_id_bar)
            INNER JOIN
                Cidades ON
                (Bares.ainc_id_cidade = Cidades.ainc_id_cidade)
            WHERE
                Cidades.ainc_id_cidade = '$ainc_id_cidade'
                AND EventosBar.stam_inicio_evento > '$agora'
            ORDER BY
                stam_inicio_evento,
                RAND()
            LIMIT
                4")->result();
    }

    /**
     * /TYPEAHEAD
     */

    /**
     * [todosItensCardapio description]
     *
     * @return [type]
     */
    public function todosItensCardapio()
    {
        return $this->db->query(
            "SELECT DISTINCT
                char_nome_itemcardapio,
                char_nome_itemcardapio AS 'value'
            FROM
                ItensCardapio
            ORDER BY
                char_nome_itemcardapio")->result();
    }

    /**
     * [itemCardapio description]
     *
     * @param  [type] $id_tem [description]
     * @return [type]         [description]
     */
    public function itemCardapio($id_tem)
    {
        return $this->db->query(
            "SELECT
                char_nome_itemcardapio,
                char_descricao_itemcardapio,
                enum_faixapreco_itemcardapio,
                bit_pontuacao_itemcardapio,
                char_imagem_itemcardapio,
                ainc_id_bar,
                ainc_id_usuario
            FROM
                ItensCardapio
            WHERE
                ainc_id_itemcardapio = $id_tem
            LIMIT
                1")->row();
    }

    /**
     * [show description]
     *
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function reviewsCardapio($id_itemcardapio)
    {
        return $this->db->query(
            "SELECT
                char_comentario_votoItemCardapio,
                bit_nota_votoItemCardapio,
                char_nome_usuario,
                char_sobrenome_usuario
            FROM
                VotosItensCardapio
            INNER JOIN
                Usuarios ON
                (VotosItensCardapio.ainc_id_usuario = Usuarios.ainc_id_usuario)
            WHERE
                ainc_id_itemcardapio = $id_itemcardapio
            ORDER BY
                ainc_id_itemcardapio ASC")->result();
    }

    public function insertMenuItem ($char_name_menuitem, $ainc_id_usuario)
    {
        $query =
            'INSERT INTO MenuItems (char_name_menuitem, ainc_id_usuario) VALUES ('
            . $this->db->escape($char_name_menuitem) . ','
            . $ainc_id_usuario . ')';

        $this->db->query($query);
        return $this->db->insert_id();
    }

    /**
     * [insertMenuItem description]
     * @param  [type] $user_id     [description]
     * @param  [type] $bar_id      [description]
     * @param  [type] $suggestions [description]
     * @return [type]              [description]
     */
    public function insertMenuIndications ($user_id, $bar_id, $suggestions)
    {

        $indications_insert_query = '';

        foreach ($suggestions as $suggestion) {

            // Getting id
            $is_new_suggestion = ($suggestion['id'] == 0);

            // If is a new suggestion, insert it in menuitem table
            // Else, get the referent id
            $ainc_id_menuitem  = ($is_new_suggestion)
                ? $this->insertMenuItem($suggestion['name'], $user_id)
                : $suggestion['id'];

            // Adding to final query
            $indications_insert_query .=
            '('
                . $this->db->escape($suggestion['description']) . ','
                . $ainc_id_menuitem . ','
                . $user_id . ','
                . $bar_id
            . '),';
        }
        // Removing last comma
        $indications_insert_query = rtrim($indications_insert_query, ',');

        // Inserting new indications from users
        $query = "INSERT INTO MenuItems_Indications
            (char_comment, ainc_id_menuitem, ainc_id_usuario, ainc_id_bar)
            VALUES
            $indications_insert_query";

        // Exec.
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    /**
     * Selecionando eventos aleatorios de uma cidade
     *
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function eventosCidade($ainc_id_cidade)
    {
        $agora = date('Y-m-d H:i:s', strtotime('now'));

        return $this->db->query(
            "SELECT
                ainc_id_eventobar,
                char_titulo_eventobar,
                inte_faixapreco_eventobar,
                int_likes,
                int_dislikes,
                char_nome_bar,
                char_endereco_bar,
                char_nomeamigavel_bar,
                char_fbid_eventobar,
                stam_inicio_evento
            FROM
                EventosBar
            INNER JOIN
                Bares ON
                (EventosBar.ainc_id_bar = Bares.ainc_id_bar)
            INNER JOIN
                Cidades ON
                (Bares.ainc_id_cidade = Cidades.ainc_id_cidade)
            WHERE
                Cidades.ainc_id_cidade = $ainc_id_cidade
                AND EventosBar.stam_inicio_evento > '$agora'
            ORDER BY
                stam_inicio_evento,
                RAND()
            LIMIT
                4")->result();
    }

    /**
     * Selecionando eventos do bar por ordem de data
     *
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function events($id_bar)
    {
        return $this->db->query(
            "SELECT
                ainc_id_eventobar,

                inte_faixapreco_eventobar,
                int_likes,
                int_dislikes,

                char_descricao_eventobar,
                char_fbid_eventobar,
                char_nome_bar,
                char_endereco_bar,
                char_nomeamigavel_bar,
                char_titulo_eventobar,

                stam_inicio_evento,
                stam_fim_evento,

                CONCAT('https://facebook.com/events/', char_fbid_eventobar) AS 'url',

                Usuarios.char_nome_usuario,
                Usuarios.char_sobrenome_usuario,
                Usuarios.char_fbid_usuario

            FROM
                EventosBar
                INNER JOIN
                    Bares ON
                    (Bares.ainc_id_bar = EventosBar.ainc_id_bar)
                INNER JOIN
                    Usuarios ON Usuarios.ainc_id_usuario = EventosBar.ainc_id_usuario
            WHERE
                EventosBar.ainc_id_bar = $id_bar
            LIMIT 5")->result();
    }

    /**
     * Traz as informações de um evento específico
     *
     * @param  [type] $id_evento [description]
     * @return [type]            [description]
     */
    public function exibirDadosEvento($id_evento)
    {
        return $this->db->query(
            "SELECT
                ainc_id_eventobar,
                char_titulo_eventobar,
                char_descricao_eventobar,
                inte_faixapreco_eventobar,
                CONCAT(char_nome_usuario, ' ', char_sobrenome_usuario) AS 'char_nomecompleto_usuario',
                char_fbid_usuario,
                int_likes,
                int_dislikes
            FROM
                EventosBar
            RIGHT JOIN
                Usuarios
                ON EventosBar.ainc_id_usuario = Usuarios.ainc_id_usuario
            WHERE
                ainc_id_eventobar = $id_evento
            LIMIT
                1")->row();
    }

    /**
     * [verificaAvaliacaoEvento description]
     *
     * @param  [type] $usuario  [description]
     * @param  [type] $idEvento [description]
     * @return [type]           [description]
     */
    public function verificaAvaliacaoEvento($usuario, $idEvento)
    {
        $result = $this->db->query(
            "SELECT ainc_id_eventobar as 'usuario_existe'
             FROM NotaEventos
             WHERE ainc_id_usuario = $usuario
                AND ainc_id_eventobar = $idEvento
             LIMIT 1")->row();

        if(isset($result->usuario_existe)) return 1;
        else return 0;
    }

    /**
     * [avaliarEvento description]
     *
     * @param  [type] $idEvento [description]
     * @param  [type] $usuario  [description]
     * @param  [type] $value    [description]
     * @return [type]           [description]
     */
    public function avaliarEvento($idEvento, $usuario, $value)
    {
        // Verifica se o usuario ja votou
        if($this->verificaAvaliacaoEvento($usuario, $idEvento) == 0) {
            // Insere dados no log
            $this->db->query(
                "INSERT INTO NotaEventos (ainc_id_eventobar, ainc_id_usuario)
                 VALUES ($idEvento, $usuario)"
            );

            // Atribui nota
            $this->db->query(
                "UPDATE EventosBar
                SET
                    inte_pontuacao_eventobar = inte_pontuacao_eventobar + $value
                WHERE
                    ainc_id_eventobar = $idEvento");

            return $this->db->affected_rows();
        }
        else return 0;
    }

    /**
     * Seleciona as últimas promoções
     *
     * @param  [type] $cidade [description]
     * @return [type]
     */
    public function getHotListDeals($ainc_id_cidade)
    {
        $stamp_finish = date('Y-m-d', time());

        $query = "SELECT
                Bar_Deals.title,
                Bar_Deals.stamp_start,
                Bar_Deals.stamp_finish,
                Bar_Deals.description,
                Bar_Deals.char_filename,
                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar

            FROM
                Bar_Deals

            INNER JOIN
                Bares ON
                Bares.ainc_id_bar = Bar_Deals.fk_bar
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Bares.ainc_id_cidade

            WHERE
                stamp_finish >= '$stamp_finish'
                AND Cidades.ainc_id_cidade = $ainc_id_cidade
            LIMIT
                3";

        return $this->db->query($query)->result();
    }

    /**
     * [getDeals description]
     * @return [type] [description]
     */
    public function getDeals ($ainc_id_bar)
    {
        $query = "SELECT
                Bar_Deals.title,

                Bar_Deals.stamp_start,
                DAYOFMONTH( Bar_Deals.stamp_start ) as stamp_day_start,
                SUBSTR( LOWER( MONTHNAME( Bar_Deals.stamp_start ) ), 1, 3) as stamp_month_start,

                Bar_Deals.stamp_finish,
                DAYOFMONTH( Bar_Deals.stamp_finish ) as stamp_day_finish,
                SUBSTR( LOWER( MONTHNAME( Bar_Deals.stamp_finish ) ), 1, 3) as stamp_month_finish,

                Bar_Deals.description,
                Bar_Deals.char_filename,
                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar

            FROM
                Bar_Deals

            INNER JOIN
                Bares ON
                Bares.ainc_id_bar = Bar_Deals.fk_bar
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Bares.ainc_id_cidade

            WHERE fk_bar = " . $this->db->escape($ainc_id_bar) . "
                AND stamp_finish >= CURDATE()
                AND stamp_start  <= CURDATE()
            ORDER BY Bar_Deals.stamp_finish
            LIMIT 3";

        return $this->db->query($query)->result();
    }

    /**
     * [insertDeals description]
     *
     * @param   [type]  $ainc_id_user
     * @param   [type]  $ainc_id_bar
     * @param   [type]  $data
     * @return  [type]
     */
    public function insertDeals($ainc_id_user, $ainc_id_bar, $data)
    {
        // Serializing data to query for insert on db
        $query = 'INSERT INTO Bar_Deals VALUES';

        //id, title, description, stamp_start, stamp_finish fk_bar, fk_user, char_filename
        foreach ($data as $key => $value) {

            // Upload image
            $char_filename = '';

            $query .= "(DEFAULT, "
                   .  "'". $value["name"] . "',"
                   .  "DEFAULT,"
                   .  "'" . $value["date_start"] . "',"
                   .  "'" . $value["date_end"] . "',"
                   .  $ainc_id_bar . ","
                   .  $ainc_id_user . ","
                   .  "'". $char_filename . "'),";
        }

        $query = rtrim($query, ',');

        // Exec query
        echo $query;
    }

    /**
     * Get feedback from users of a specific bar.
     *
     * @param  {Int}    $ainc_id_bar The ID of the bar to get the comments.
     * @param  {Int}    $start       The start of the limit statement in SQL.
     * @param  {Int}    $amount      The amount of items to get.
     * @return {Object}
     */
    public function getComments($ainc_id_bar, $start = null, $amount = null)
    {
        if (isset($start) && !isset($amount)) {
            $limit = "LIMIT $start";
        } else if (isset($start) && isset($amount)) {
            $limit = 'LIMIT ' . $start++ . ', ' . $amount;
        } else {
            $limit = '';
        }

        $query =
            "SELECT
                ComentariosBar.ainc_id_comentariobar,
                ComentariosBar.char_titulocomentario_comentariobar,
                ComentariosBar.char_textocomentario_comentariobar,
                ComentariosBar.stam_inclusao_comentariobar,
                ComentariosBar.int_likes,
                ComentariosBar.int_dislikes,
                CONCAT(
                    Usuarios.char_nome_usuario, ' ',
                    Usuarios.char_sobrenome_usuario
                ) AS char_nome_usuario,
                Usuarios.char_fbid_usuario,
                Usuarios.ainc_id_usuario,
                Usuarios.inte_pontos_usuario
            FROM
                ComentariosBar
            INNER JOIN
                Usuarios ON
                ComentariosBar.ainc_id_usuario = Usuarios.ainc_id_usuario
            WHERE
                ComentariosBar.ainc_id_bar = $ainc_id_bar
                AND ComentariosBar.ainc_id_comentariobar NOT IN (
                    getMostVotedComments($ainc_id_bar, 1)
                )
            GROUP BY
                ComentariosBar.ainc_id_comentariobar
            ORDER BY
                ComentariosBar.stam_inclusao_comentariobar DESC

            $limit";

        return $this->db->query($query)->result();
    }

    /**
     * Obtém comentários de usuários de um bar específico.
     *
     * @param  {Int}    $ainc_id_bar O ID do bar a trazer os comentários.
     * @param  {Int}    $qtde        Quantidade de comentários desejado.
     * @return {Object}
     */
    public function getCommentsMostVoted($ainc_id_bar, $start = null)
    {
        if ($start) {
            $limit = "LIMIT $start";
        } else {
            $limit = '';
        }

        $query =
            "SELECT
                ComentariosBar.ainc_id_comentariobar,
                ComentariosBar.char_titulocomentario_comentariobar,
                ComentariosBar.char_textocomentario_comentariobar,
                ComentariosBar.stam_inclusao_comentariobar,
                ComentariosBar.int_likes,
                ComentariosBar.int_dislikes,
                CONCAT(
                    Usuarios.char_nome_usuario, ' ',
                    Usuarios.char_sobrenome_usuario
                ) AS char_nome_usuario,
                Usuarios.char_fbid_usuario,
                Usuarios.ainc_id_usuario,
                Usuarios.inte_pontos_usuario
            FROM
                ComentariosBar
            INNER JOIN
                Usuarios ON
                ComentariosBar.ainc_id_usuario = Usuarios.ainc_id_usuario
            WHERE
                ComentariosBar.ainc_id_bar = $ainc_id_bar
            GROUP BY
                ComentariosBar.ainc_id_comentariobar
            ORDER BY
                ComentariosBar.int_likes DESC

            $limit";

        return $this->db->query($query)->result();
    }

    /**
     * Returns the amount of comments of a bar.
     *
     * @param  {Int} $ainc_id_bar The ID of the bar to get the amount.
     * @return {Int}
     */
    public function countComments($ainc_id_bar)
    {
        return $this->db->query(
            "SELECT
                COUNT(ainc_id_comentariobar) AS countComments
            FROM
                ComentariosBar
            INNER JOIN
                Bares ON
                (Bares.ainc_id_bar = ComentariosBar.ainc_id_bar)
            WHERE
                ComentariosBar.ainc_id_bar = $ainc_id_bar")->row()->countComments;
    }

    /**
     * Verify if has more pages to load
     * @param  int  $ainc_id_bar Bar id
     * @param  int  $start       Index
     * @return boolean           if has more pages, return next index.
     *                              Otherwise, return -1
     */
    public function hasMoreComments($ainc_id_bar, $start, $amount)
    {
        $query = "SELECT ComentariosBar.ainc_id_comentariobar
                    FROM ComentariosBar
                WHERE ComentariosBar.ainc_id_bar = $ainc_id_bar
                    AND ComentariosBar.ainc_id_comentariobar NOT IN (
                        getMostVotedComments($ainc_id_bar, 1)
                    )
            LIMIT $start, $amount";

        $result = $this->db->query($query)->result();

        $has_more_pages = count($result) > 0;
        $next_index     = $start + $amount;

        return ($has_more_pages) ? $next_index : -1;
    }

    /**
     * [comment description]
     *
     * @param  [type] $ainc_id_comentariobar [description]
     * @return [type]             [description]
     */
    public function getComment($ainc_id_comentariobar)
    {
        $query =
            "SELECT
                ComentariosBar.ainc_id_bar,
                Usuarios.ainc_id_usuario,
                Usuarios.char_fbid_usuario,
                ComentariosBar.char_textocomentario_comentariobar,
                ComentariosBar.stam_inclusao_comentariobar
            FROM
                ComentariosBar
            RIGHT JOIN
                Usuarios ON
                ComentariosBar.ainc_id_usuario = Usuarios.ainc_id_usuario
            WHERE
                ainc_id_comentariobar = $ainc_id_comentariobar
            LIMIT
                1";

        return $this->db
            ->query($query)
            ->row();
    }

    /**
     * Retorna soma do numero de comentarios de um bar
     *
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function n_comments($id_bar)
    {
        return $this->db->query(
            "SELECT
                COUNT(ainc_id_usuario) AS 'total'
            FROM
                ComentariosBar
            WHERE
                ainc_id_bar = $id_bar
            LIMIT 1")->row()->total;
    }

    /**
     * Verifica se  o comentário já foi feito.
     * Se sim, então atualiza ele. Caso contrario, insere.
     *
     * @param  [int]    $user_id          User id
     * @param  [int]    $bar_id           Bar id
     * @param  [String] $something_to_say Comment
     * @return [int]                      If success, return the new comment id.
     *                                       Otherwise, return 0 (false)
     */
    public function insertComment($user_id, $bar_id, $something_to_say)
    {
        $query =
            "INSERT INTO
                ComentariosBar
                (ainc_id_usuario, ainc_id_bar,
                char_titulocomentario_comentariobar, char_textocomentario_comentariobar, stam_inclusao_comentariobar)
            VALUES
                ($user_id, $bar_id, '', '$something_to_say', DEFAULT)";

        $this->db->query($query);

        return ($this->db->affected_rows())
            ? $this->db->insert_id()
            : 0;
    }

    /**
     * [show description]
     *
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function getTotalOfFilters ($ainc_id_bar)
    {
        $query =
            "SELECT COUNT(ainc_id_filtrobar) as 'count_ainc_id_filtrobares'
                FROM Filtros_Bares
                WHERE ainc_id_bar = $ainc_id_bar";

        $total = $this->db->query($query)->row();

        return ($total == null) ? 0 : $total->count_ainc_id_filtrobares;
    }


    /**
     * [similarPlaces description]
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function getFilters($id_bar, $categories_list = NULL)
    {
        if ($categories_list != 'ALL' || $categories_list == NULL) {
            // Allowed filters
            $categories = '2,3,100';
            $SELECT_FILTERS = "AND FiltrosBarCategorias.ainc_id_filtrobarcategoria IN ($categories)";
            unset($categories);
        }

        // View
        // Select all filters from allowed categories
        $query_view =
            "SELECT

                FiltrosBarCategorias.ainc_id_filtrobarcategoria,
                FiltrosBarCategorias.char_titulo_filtrobarcategoria,

                Filtros_Bares.ainc_id_filtrosbares,

                FiltrosBar.char_texto_filtrobar,
                FiltrosBar.ainc_id_filtrobar

            FROM Filtros_Bares INNER JOIN FiltrosBar
                    ON FiltrosBar.ainc_id_filtrobar = Filtros_Bares.ainc_id_filtrobar

                INNER JOIN FiltrosBarCategorias
                    ON FiltrosBarCategorias.ainc_id_filtrobarcategoria =
                        FiltrosBar.ainc_id_filtrobarcategoria

            WHERE Filtros_Bares.ainc_id_bar = $id_bar
                $SELECT_FILTERS

            ORDER BY FiltrosBarCategorias.ainc_id_filtrobarcategoria";

        // Total count
        // Get total of filters for each allowed category from Bar
        $query =
            "SELECT
                filters.ainc_id_filtrobarcategoria,
                filters.char_titulo_filtrobarcategoria,
                COUNT(filters.ainc_id_filtrosbares)  as total
            FROM ($query_view) as filters
            GROUP BY filters.ainc_id_filtrobarcategoria";

        $filters_count = $this->db->query($query)->result();

        // Gathering information about categories
        $categories = array();
        foreach ($filters_count as $category) {
            $categories[$category->ainc_id_filtrobarcategoria] =
                (object) array(
                    'char_titulo_filtrobarcategoria' => $category->char_titulo_filtrobarcategoria,
                    'total' => $category->total
                );
        }

        // Get main filter of each category
        $query =
            " SELECT
                main_filters.char_texto_filtrobar,
                main_filters.ainc_id_filtrobar,
                main_filters.ainc_id_filtrobarcategoria,
                total

                FROM (
                    SELECT
                        COUNT(filters.ainc_id_filtrosbares) as total,
                        filters.char_texto_filtrobar,
                        filters.ainc_id_filtrobar,
                        filters.ainc_id_filtrobarcategoria
                    FROM ($query_view) as filters
                    GROUP BY filters.ainc_id_filtrobar
                    ORDER BY total DESC
                ) as main_filters";

        $main_filters = $this->db->query($query)->result();

        // Gathering information about the bar filters
        $result = array();
        $count  = count($main_filters);
        $allowed_filters = '';
        for ($i=0; $i < $count; $i++) {

            $category_index = $main_filters[$i]->ainc_id_filtrobarcategoria;
            $filter_index   = $main_filters[$i]->ainc_id_filtrobar;

            // Initializing array (object)
            if ($result[$category_index] == NULL) {
                $result[$category_index] = array(
                    'category' => (object) array(
                            'ainc_id_filtrobarcategoria'     => $category_index,
                            'char_titulo_filtrobarcategoria' =>
                                $categories[$category_index]->char_titulo_filtrobarcategoria,
                            'total'              => $categories[$category_index]->total,
                            'predominant_filter' => $main_filters[$i]->ainc_id_filtrobar
                        ),
                    'filters'  => array()
                );
            };

            // Information about filter
            $aux = (object) array(
                'ainc_id_filtrobar' => $main_filters[$i]->ainc_id_filtrobar,
                'char_texto_filtrobar' => $main_filters[$i]->char_texto_filtrobar,
                'total'             => $main_filters[$i]->total,
                'pct'               => $main_filters[$i]->total/$categories[$category_index]->total
            );

            // Hashtable
            $result[$category_index]['filters'][$filter_index] = $aux;

            // List of filters
            $result[$category_index]['category']->filters_list .=
                $main_filters[$i]->ainc_id_filtrobar . ',';
        }

        return $result;
    }

    /**
     * [getBarsByFilter description]
     * @param  [type] $filters_list [description]
     * @return [type]               [description]
     */
    public function getSimilarBarsByFilter($filters_list)
    {
        // Searching for places that shares some filter
        $query =
        "SELECT DISTINCT ainc_id_bar
            FROM Filtros_Bares
            WHERE ainc_id_filtrobar IN ($filters_list)";

        $result = $this->db->query($query)->result();

        return $result;
    }

    /**
     * [createSimilarityLink description]
     * @param  [type] $ainc_id_bar [description]
     * @param  [type] $node        [description]
     * @return [type]              [description]
     */
    public function createSimilarityLink($ainc_id_bar, $node)
    {
        $insert_query = 'INSERT INTO Bar_Bar_similarity(ainc_id,
            ainc_id_bar1, ainc_id_bar2, float_similarity, stam_creation)
           VALUES '
            . '(DEFAULT'
            . ',' . $ainc_id_bar
            . ',' . $node->ainc_id_bar
            . ',' . $node->similarity
            . ',' . 'DEFAULT);';

        $update_query = 'UPDATE Bar_Bar_similarity
            SET float_similarity = '. $node->similarity .',
                stam_creation    = CURRENT_TIMESTAMP
            WHERE ainc_id_bar1 = '. $ainc_id_bar .
                ' AND ainc_id_bar2 = '. $node->ainc_id_bar;

        $this->db->query($update_query);
        $is_updated = ($this->db->affected_rows() == 1);

        // If wasn't updated, insert query
        if (!$is_updated) {
            $this->db->query($insert_query);
        }

        return $this->db->affected_rows();
    }


    /**
     * [getSimilarPlaces description]
     * @param  [type] $ainc_id_bar [description]
     * @return [type]              [description]
     */
    public function getSimilarPlaces($ainc_id_bar)
    {
        $query =
            "SELECT DISTINCT
                ainc_id_bar2,
                float_similarity,

                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar,
                Bares.char_logo_bar,
                Bares.char_endereco_bar,

                LOWER(
                    CONCAT(
                        '/', Cidades.char_id_pais,
                        '/', IF(Estados.char_uf_estado = '',
                            Estados.char_nomeamigavel_estado,
                            Estados.char_uf_estado),
                        '/', Cidades.char_nomeamigavel_cidade,
                        '/', Bares.char_nomeamigavel_bar)
                ) as char_link_bar

             FROM     Bar_Bar_similarity
                INNER JOIN Bares
                    ON Bar_Bar_similarity.ainc_id_bar2 = Bares.ainc_id_bar

                INNER JOIN Cidades
                    ON Bares.ainc_id_cidade = Cidades.ainc_id_cidade
                INNER JOIN Estados
                    ON Estados.char_id_estado = Cidades.char_id_estado
                        AND Estados.char_id_pais = Cidades.char_id_pais
                INNER JOIN Paises
                    ON Paises.char_id_pais = Cidades.char_id_pais

             WHERE    ainc_id_bar1 = $ainc_id_bar
             ORDER BY float_similarity DESC
             LIMIT 5";

        return $this->db->query($query)->result();
    }

    /**
     * Manually execute the stored procedure
     * to include values on Log.
     *
     * @param  [type] $value [description]
     * @return [type]
     */
    public function callInsertLog($ainc_id_usuario, $action, $ainc_id_bar, $object)
    {
        $query =
            "CALL Insert_Into_Log(
                $ainc_id_usuario,
                '$action',
                $ainc_id_bar,
                '$object'
            )";

        return $this->db->query($query);
    }

    /**
     * FOTOS
     */

    /**
     * [newPhoto description]
     * @param  [type] $ainc_id_usuario [description]
     * @param  [type] $ainc_id_bar     [description]
     * @param  [type] $file_name       [description]
     * @param  string $char_label      [description]
     * @return [type]                  [description]
     */
    public function newPhoto($ainc_id_usuario, $ainc_id_bar, $file_name, $char_label = '')
    {
        $file_name  = $this->db->escape($file_name);
        $char_label = $this->db->escape($char_label);

        $query =
            "INSERT INTO Photos_Bar (ainc_id_usuario, ainc_id_bar, char_filename_photobar, char_label_photobar)
            VALUES ($ainc_id_usuario, $ainc_id_bar, $file_name, $char_label)";

        $this->db->query($query);
        return $this->db->insert_id();
    }

    /**
     * [getPhotos description]
     *
     * @param  [type] $id_bar [description]
     * @return [type]         [description]
     */
    public function getPhotos($id_bar)
    {
        return $this->db->query(
            "SELECT
                ainc_id_photobar,
                ainc_id_bar,
                stam_date_photobar,
                int_likes_photobar,
                int_dislikes_photobar,
                char_filename_photobar,
                char_label_photobar,
                CONCAT(char_nome_usuario, ' ', char_sobrenome_usuario) AS nome_usuario,
                Usuarios.ainc_id_usuario,
                Usuarios.char_fbid_usuario
            FROM
                Photos_Bar
            INNER JOIN
                Usuarios ON
                Photos_Bar.ainc_id_usuario = Usuarios.ainc_id_usuario
            WHERE
                ainc_id_bar = $id_bar")->result();
    }

    /**
     * [getPhotosFromUsers description]
     *
     * @param   [type]  $ainc_id_bar
     * @return  [type]
     */
    public function getPhotosFromUsers($ainc_id_bar)
    {
        $query =
            "SELECT
                Photos_Bar.ainc_id_photobar,
                Photos_Bar.ainc_id_bar,
                Photos_Bar.stam_date_photobar,
                Photos_Bar.int_likes_photobar,
                Photos_Bar.int_dislikes_photobar,
                Photos_Bar.char_filename_photobar,
                Photos_Bar.char_label_photobar,

                Bares.char_nome_bar,

                CONCAT(char_nome_usuario, ' ', char_sobrenome_usuario) AS nome_usuario,
                Usuarios.ainc_id_usuario,
                Usuarios.char_fbid_usuario
            FROM
                Photos_Bar
            INNER JOIN
                Usuarios ON
                Photos_Bar.ainc_id_usuario = Usuarios.ainc_id_usuario
            INNER JOIN
                Bares ON
                Photos_Bar.ainc_id_bar = Bares.ainc_id_bar
            WHERE
                Bares.ainc_id_bar = $ainc_id_bar
                AND Photos_Bar.ainc_id_usuario
                    NOT IN (
                        SELECT ainc_id_usuario
                        FROM Bar_User
                        WHERE ainc_id_bar = Bares.ainc_id_bar
                    )
            ORDER BY
                Photos_Bar.stam_date_photobar DESC";

        return $this->db->query($query)->result();
    }

    /**
     * [getAttrImage description]
     * @param  [type] $id_image [description]
     * @return [type]           [description]
     */
    public function getPhoto($id_image)
    {
        return $this->db->query(
            "SELECT
                ainc_id_photobar,
                ainc_id_bar,
                stam_date_photobar,
                int_likes_photobar,
                int_dislikes_photobar,
                char_filename_photobar,
                char_label_photobar,

                CONCAT(char_nome_usuario, char_sobrenome_usuario) AS 'nome_usuario',
                Usuarios.ainc_id_usuario,
                Usuarios.char_fbid_usuario
            FROM
                Photos_Bar
            RIGHT JOIN
                Usuarios ON
                (Photos_Bar.ainc_id_usuario = Usuarios.ainc_id_usuario)
            WHERE
                ainc_id_photobar = $id_image
            LIMIT
                1;")->row();
    }

    /**
     * Save the rate given by some user
     * @param  [int] $usuario        User id
     * @param  [int] $id_bar         Bar's id
     * @param  [int] $nota_avaliacao rate
     * @return [int]                 Inserted id
     */
    public function avaliarBar($usuario, $id_bar, $avaliacao)
    {
        // Inserindo nota na tabela NotasBar
        $this->db->query(
            "INSERT INTO NotasBar
                VALUES (DEFAULT, $usuario, $id_bar, $avaliacao)");

        return $this->db->insert_id();
    }

    /**
     * [verificaNotaBar description]
     * Verifica se o usuário já realizou alguma avaliação sobre o bar
     * @param  [type] $usuario [description]
     * @param  [type] $id_bar  [description]
     * @return [type]          Se não houve avaliação, retorna 0 (zero),
     *                         caso contrário, retorna valor da nota
     */
    public function hasRated($ainc_id_usuario, $ainc_id_bar)
    {
        $result = $this->db->query(
            "SELECT
                ainc_id_User_Bar_Rate
            FROM
                User_Bar_Rate
            WHERE
                ainc_id_bar = $ainc_id_bar
                AND ainc_id_usuario = $ainc_id_usuario
            LIMIT
                1")->row();

        return ($result != null) ? true : false;
    }

    /**
     * [valorAcao description]
     *
     * @param  [type] $acao [description]
     * @return [type]       [description]
     */
    public function valorAcao($acao)
    {
        return $this->db->query(
            "SELECT
                int_value_action
            FROM
                Actions
            WHERE
                char_name_action='$acao'
            LIMIT 1")->row()->int_value_action;
    }

    /**
     * [insert_rate description]
     *
     * @param  string $name_table   nome da tabela
     * @param  [type] $id_user
     * @param  [type] $id_reference
     * @param  [type] $bit_rate
     * @return [type]
     */
    public function insert_rate($name_table, $id_user, $id_reference, $bit_rate)
    {
        $this->db->query("DELETE FROM " . ucfirst($name_table) . "_Ratings WHERE id_user=$id_user AND id_reference=$id_reference");
        $this->db->query("INSERT INTO " . ucfirst($name_table) . "_Ratings VALUES (DEFAULT, $id_user, $id_reference, $bit_rate)");

        // Retornando total de likes e dislikes
        return $this->db->query(
            "SELECT
                (SELECT COUNT(id) FROM " . ucfirst($name_table) . "_Ratings WHERE id_reference=$id_reference AND bit_rate=1) as 'likes',
                (SELECT COUNT(id) FROM " . ucfirst($name_table) . "_Ratings WHERE id_reference=$id_reference AND bit_rate=0) as 'dislikes'
            LIMIT 1
        ")->row();
    }

    /**
     * [insert_rate description]
     *
     * @param  string $name_table   nome da tabela
     * @param  [type] $id_user
     * @param  [type] $id_reference
     * @param  [type] $bit_rate
     * @return [type]
     */
    public function insertBarRate($id_user, $ainc_id_bar)
    {
        $this->db->query("INSERT INTO Bar_Ratings VALUES (DEFAULT, $id_user, $ainc_id_bar, 1)");

        // Retornando total de likes e dislikes
        return $this->countBarRates($ainc_id_bar);
    }

    /**
     * [removeBarRate description]
     *
     * @param   [type]  $id_user
     * @param   [type]  $ainc_id_bar
     * @return  [type]
     */
    public function removeBarRate($id_user, $ainc_id_bar)
    {
        $this->db->query(
            "DELETE FROM Bar_Ratings
             WHERE   id_user      = $id_user
                 AND id_reference = $ainc_id_bar");

        // Retornando total de likes e dislikes
        return $this->countBarRates($ainc_id_bar);
    }

    /**
     * [countBarRates description]
     *
     * @param   [type]  $ainc_id_bar
     * @param   string  $id_user
     * @return  [type]
     */
    public function countBarRates($ainc_id_bar, $id_user = '') {
        $condition = ($id_user != '') ? " AND id_user = $id_user": '';

        $response = $this->db->query(
            "SELECT
                COUNT(id) as 'total'
            FROM  Bar_Ratings
            WHERE id_reference = $ainc_id_bar
                AND   bit_rate = 1
                $condition
            LIMIT 1
        ")->row();

        if ($response == null) return 0;
        else return $response->total;
    }

    /**
     * [createBar description]
     *
     * @param   [type]  $data
     * @return  [type]
     */
    public function createBar($data)
    {
        $query = 'INSERT INTO Bares (';

        foreach ($data as $key => $value) { $query .= $key . ','; }

        $query = rtrim($query, ',') . ') VALUES (';

        foreach ($data as $key => $value) {
            $query .= $this->db->escape($value) . ",";
        }

        $query = rtrim($query, ',') . ')';

        $this->db->query($query);

        return $this->db->insert_id();
    }

    /**
     * Create relationship between User and Bar
     */
    public function setBarUserRelationship($ainc_id_bar, $ainc_id_usuario, $enum_level)
    {
        $query = "INSERT INTO Bar_User (ainc_id_bar, ainc_id_usuario, enum_level)
            VALUES ($ainc_id_bar, $ainc_id_usuario, '$enum_level');";

        $this->db->query($query);

        return ($this->db->affected_rows() > 0);
    }


    /**
     * [criarinfo description]
     * @return [type] [description]
     */
    public function criarPagina($usuario, $info)
    {
        $query = 'INSERT INTO Bares ( char_nome_bar, char_nomeamigavel_bar, char_website_bar,'
            . 'char_endereco_bar, char_zip_bar, deci_latitude_bar, deci_longitude_bar,'
            . 'ainc_id_cidade, ainc_id_usuario) VALUES ('
            . '"' . $info['char_nome_bar'] . '",'
            . '"' . $info['char_nomeamigavel_bar'] . '",'
            . '"' . $info['char_website_bar'] . '",'
            . '"' . $info['char_endereco_bar'] . '",'
            . '"' . $info['char_zip_bar'] . '",'
            . $info['deci_latitude_bar'] . ','
            . $info['deci_longitude_bar']. ','
            . $info['ainc_id_cidade']. ','
            . $usuario . ')';

        $this->db->query($query);

        return ($this->db->affected_rows() == 1)
            ? array('ainc_id_bar' => $this->db->insert_id(), 'char_nomeamigavel_bar' => $info['char_nomeamigavel_bar'])
            : false;
    }

    /**
     * Retorna o Bar em
     *
     * @return [type]
     */
    public function getFeaturedBar($ainc_id_cidade, $limit = 1)
    {
        $query =
            "SELECT
                ainc_id_bar,
                char_nome_bar,
                char_nomeamigavel_bar,
                char_descricao_bar,
                char_endereco_bar,
                char_logo_bar,
                inte_qtdenotas_bar,
                inte_somatorionotas_bar,
                ROUND(inte_somatorionotas_bar / inte_qtdenotas_bar, 1) AS 'inte_nota_bar'
            FROM
                Bares
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Bares.ainc_id_cidade
            WHERE
                Cidades.ainc_id_cidade = $ainc_id_cidade
            ORDER BY
                inte_nota_bar DESC,
                inte_qtdenotas_bar DESC
            LIMIT
                $limit";

        return ($limit == 1)
            ? $this->db->query($query)->row()
            : $this->db->query($query)->result();
    }

    /**
     * Retorna as ultimas imagens adicionadas
     * @param  [time]    $date timestamp referente ao alcance da busca
     * @return [array()]       vetor com as imagens e informações sobre elas
     */
    public function getRecentlyImages($date = null, $ainc_id_cidade)
    {
        if ($date == null) {
            $date = strtotime('-2 weeks');
        }

        return $this->db->query(
            "SELECT DISTINCT
                Bares.ainc_id_bar,
                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar,
                Photos_Bar.int_likes_photobar,
                Photos_Bar.char_filename_photobar

            FROM
                Photos_Bar

            INNER JOIN
                Bares ON
                (Photos_Bar.ainc_id_bar = Bares.ainc_id_bar)
            INNER JOIN
                Cidades ON
                (Cidades.ainc_id_cidade = Bares.ainc_id_cidade)

            WHERE
                Photos_Bar.stam_date_photobar >= $date
                AND Cidades.ainc_id_cidade = '$ainc_id_cidade'

            GROUP BY
                Bares.ainc_id_bar

            ORDER BY
                Photos_Bar.int_likes_photobar DESC

            LIMIT
                10")->result();
    }

    /**
     * [menuSuggestion description]
     * @param  [type] $q [description]
     * @return [type]    [description]
     */
    public function menuSuggestion($q)
    {
        return $this->db->query(
            "SELECT
                DISTINCT ainc_id_menuitem,
                char_name_menuitem as name
             FROM MenuItems
             WHERE char_name_menuitem LIKE '%$q%'")->result();
    }

    /**
     * {{AQUI}} Document it
     *
     */
    public function insertFilters($user_id, $bar_id, $filters_list)
    {
        $list = '';

        // Getting filter_list
        foreach ($filters_list as $filter) {
            $list .= "($user_id, $bar_id, $filter),";
        }

        $list = rtrim($list, ',');

        $query = "INSERT INTO Filtros_Bares
                (ainc_id_usuario, ainc_id_bar, ainc_id_filtrobar)
            VALUES
                $list";

        $this->db->query($query);

        return $this->db->affected_rows();
    }

    /**
    * Set office hours of a place.
    *
    * @param  [int]       $id_bar [description]
    * @param  [Array]     $days   [description]
    * @return [bool]              affected_rows
    */
    public function setOfficeHours($ainc_id_bar, $office_hours)
    {
        $query = " INSERT INTO OfficeHoursBar (ainc_id_bar, byte_days_OfficeHoursBar,
            time_start_OfficeHoursBar, time_end_OfficeHoursBar) VALUES ";

        foreach ($office_hours as $office_hour) {

            $query .= '(' . $ainc_id_bar . ', '
                . $this->db->escape($office_hour['weekToBin']) . ', '
                . $this->db->escape($office_hour['open']) . ', '
                . $this->db->escape($office_hour['close']). '),';
        }

        $query = trim($query, ',');

        $this->db->query($query);

        return $this->db->affected_rows() > 0;
    }

    /**
    * Get office hours of a place.
    *
    * @param  [int]       $id_bar [description]
    * @param  [byte]      $days   [description]
    * @param  [timestamp] $start  [description]
    * @param  [timestamp] $end    [description]
    * @return [bool]              affected_rows
    */
    public function getOfficeHoursBar($ainc_id_bar)
    {
        $query =
            "SELECT
                byte_days_OfficeHoursBar,
                time_start_OfficeHoursBar,
                time_end_OfficeHoursBar
             FROM
                OfficeHoursBar
             WHERE
                ainc_id_bar = $ainc_id_bar";

        return $this->db->query($query)->result();
    }

    /**
     * [findBar description]
     * @param  integer $lat            [description]
     * @param  integer $lon            [description]
     * @param  [type]  $ainc_id_cidade [description]
     * @return [type]                  [description]
     */
    public function findBar($lat = -90, $lon = -90, $ainc_id_cidade = 0)
    {
        $condition = '';
        $result = array();

        if ($lat == -90 && $lon == -90) return null;
        if ($ainc_id_cidade > 0) $condition = "WHERE ainc_id_cidade = $ainc_id_cidade ";

        $query = "SELECT
                char_nomeamigavel_bar,
                deci_latitude_bar,
                deci_longitude_bar,
                ROUND(
                    SQRT(
                        POW(deci_latitude_bar  - $lat, 2) +
                        POW(deci_longitude_bar - $lon, 2)
                    ),
                    8
                ) as distance
            FROM Bares
            $condition
            ORDER BY distance ASC
            LIMIT 10";

        $places = $this->db->query($query)->result();

        // Filtering places
        // Nearest places smaller than 100 meters
        $R = 6371; // Earth's radius (km)

        foreach ($places as $key => $place)
        {
            $p1  =    deg2rad( $place->deci_latitude_bar); //φ1
            $p2  =    deg2rad( $lat);                          //φ2
            $phi =    deg2rad( $lat - $place->deci_latitude_bar);//Δφ
            $lambda = deg2rad( $lon - $place->deci_longitude_bar); //Δλ

            // Haversine formula
            // (font:http://en.wikipedia.org/wiki/Haversine_formula)
            $a = sin($phi/2)    * sin($phi/2)    +
                 cos($p1)       * cos($p2)       *
                 sin($lambda/2) * sin($lambda/2);

            $c = 2 * atan2(sqrt($a), sqrt(1-$a));

            $d = $R * $c; // Distance in kilometers

            // If the distance between user and place is smaller than 100 meters,
            // add this place to the list
            if ($d < 0.1) {
                $place->km_distance = $d;
                array_push($result, $place);
            }
        }

        return $result;
    }

    /**
     * Register total of contributions made by the user to the bar
     * @return int Affected rows
     */
    public function insertUserContribution ($ainc_id_usuario, $ainc_id_bar,
        $int_reward_User_Bar_Contribution)
        {
            $this->db->query("INSERT INTO User_Bar_Contribution
                VALUES ($ainc_id_usuario, $ainc_id_bar,
                    $int_reward_User_Bar_Contribution, DEFAULT)");

            return $this->db->affected_rows();
        }

    /**
     * [registerRate description]
     * @param  [type] $ainc_id_usuario [description]
     * @param  [type] $ainc_id_bar     [description]
     * @return [type]                  [description]
     */
    public function registerRate($ainc_id_usuario, $ainc_id_bar)
    {
        $this->db->query("INSERT INTO User_Bar_Rate
            VALUES (DEFAULT, $ainc_id_usuario, $ainc_id_bar, DEFAULT)");

        return $this->db->insert_id();
    }

    /**
     * Get the rate of a user in a specific bar.
     *
     * @param  {Int} $ainc_id_usuario The ID of the user.
     * @param  {Int} $ainc_id_bar     The ID of the bar.
     * @return {Int}                  The rate of the user.
     */
    public function getRate($ainc_id_usuario, $ainc_id_bar)
    {
        $query =
            "SELECT bit_nota_votobar
            FROM    NotasBar
            WHERE   ainc_id_bar = $ainc_id_bar
            AND     ainc_id_usuario = $ainc_id_usuario";

        return $this->db
            ->query($query)
            ->row()
            ->bit_nota_votobar;
    }


    /***************************************************************************
    *
    *   Managing pages
    *
    ***************************************************************************/

    /**
     * Return the number of bars that user owns with its
     * facebook user ID.
     *
     * @param  {Int} $ainc_id_usuario The Barpedia ID of the user.
     * @return {Int}                  The count of bars.
     */
    public function countBarUserOwns($ainc_id_usuario)
    {
        $query =
            "SELECT
                COUNT(ainc_id_bar) AS count

            FROM
                Bar_User

            WHERE
                ainc_id_usuario = $ainc_id_usuario
                AND enum_level = 'ADMIN'

            LIMIT
                1";

        return $this->db
            ->query($query)
            ->row()
            ->count;
    }

    /**
     * [getBarUserOwns description]
     * @param  [type] $ainc_id_usuario [description]
     * @return [type]                  [description]
     */
    public function getBarUserOwns($ainc_id_usuario, $user_bars_to_show = false)
    {
        $limit = ($user_bars_to_show)
            ? "LIMIT $user_bars_to_show"
            : '';

        $query =
            "SELECT

                Bares.char_nome_bar,
                Bares.char_nomeamigavel_bar,
                Bares.char_logo_bar,

                IF (inte_qtdenotas_bar = 0, FALSE, TRUE) AS has_ratings,
                IF (inte_somatorionotas_bar / inte_qtdenotas_bar >= 4.5, TRUE, FALSE) AS is_premium,
                ROUND(inte_somatorionotas_bar/inte_qtdenotas_bar, 1) AS ratings,
                CONCAT(
                    Bares.char_endereco_bar, ', ',
                    Cidades.char_nomelocal_cidade, ' - ',
                    Estados.char_nomelocal_estado, ', ',
                    Bares.char_zip_bar, ', ',
                    Paises.char_nomelocal_pais
                ) AS address

            FROM
                Bar_User

            /* Relationship */
            INNER JOIN
                Bares ON
                Bar_User.ainc_id_bar = Bares.ainc_id_bar

            /* Defining location */
            INNER JOIN
                Cidades ON
                Bares.ainc_id_cidade = Cidades.ainc_id_cidade

            LEFT JOIN
                Estados ON (
                    Cidades.char_id_estado = Estados.char_id_estado
                    AND Cidades.char_id_pais = Estados.char_id_pais
                )

            INNER JOIN
                Paises ON
                Cidades.char_id_pais = Paises.char_id_pais

            WHERE
                Bar_User.ainc_id_usuario = $ainc_id_usuario
                AND Bar_User.enum_level = 'ADMIN'

            $limit";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * [isOwner description]
     * @param  [type]  $char_nomeamigavel_bar [description]
     * @param  [type]  $ainc_id_usuario       [description]
     * @return boolean                        true, false
     */
    public function isOwner($char_nomeamigavel_bar, $ainc_id_usuario)
    {
        $query =
            "SELECT ainc_id_bar
            FROM    Bares
            WHERE   char_nomeamigavel_bar = " . $this->db->escape($char_nomeamigavel_bar)
            . " AND ainc_id_usuario   = " . $ainc_id_usuario
            . " LIMIT 1";

        return $this->db
            ->query($query)
            ->num_rows() == 1;
    }

    /**
     * [createDeals description]
     * @return [type] [description]
     */
    public function createDeals($deals)
    {
        $query = "INSERT INTO Bar_Deals (title, description, stamp_start, stamp_finish,
            fk_bar, fk_user, char_filename) VALUES ";

        foreach ($deals as $key => $deal) {
            $query .= '('
                . $this->db->escape($deal->name) .','
                . $this->db->escape($deal->other) .','
                . $this->db->escape($deal->date_start) .','
                . $this->db->escape($deal->date_end) .','
                . $this->db->escape($deal->ainc_id_bar) .','
                . $this->db->escape($deal->ainc_id_usuario) .','
                . $this->db->escape($deal->char_filename) . '),';
        }

        $query = rtrim($query, ',');

        $this->db->query($query);

        return $this->db->affected_rows();
    }

    /**
     * Expects an array of events
     * @return [type] [description]
     */
    public function createEvents($events)
    {

        $query = "INSERT INTO EventosBar (char_titulo_eventobar, char_descricao_eventobar,
            char_fbid_eventobar, inte_faixapreco_eventobar, ainc_id_usuario, ainc_id_bar,
            stam_inicio_evento, stam_fim_evento) VALUES ";

        foreach ($events as $key => $event) {
            $query .= '(' . $this->db->escape($event['char_titulo_eventobar']) . ','
                          . $this->db->escape($event['char_descricao_eventobar']) . ','
                          . $this->db->escape($event['char_fbid_eventobar']) . ','
                          . $this->db->escape($event['inte_faixapreco_eventobar']) . ','
                          . $this->db->escape($event['ainc_id_usuario']) . ','
                          . $this->db->escape($event['ainc_id_bar']) . ','
                          . $this->db->escape($event['stam_inicio_evento']) . ','
                          . $this->db->escape($event['stam_fim_evento']) . '),';
        }

        $query = rtrim($query, ',');

        $this->db->query($query);

        return $this->db->affected_rows();
    }

}

/* End of file bares_model.php */
/* Location: ./application/models/bares_model.php */
