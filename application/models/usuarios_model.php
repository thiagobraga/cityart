<?php

/**
 * usuarios_model.php
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
 * Usuarios_model
 * @author Matheus Santos <matheus.cesario.santos@gmail.com>
 * @access public
 */
class Usuarios_model extends CI_Model
{

    /**
     * @todo: Document it.
     *
     * @param [type] $locale [description]
     */
    public function setLang($locale)
    {
        $ainc_id_usuario = $this->session->userdata('ainc_id_usuario');

        // Updating
        if ($ainc_id_usuario) {
            $this->db->query(
                "UPDATE Usuarios
                SET char_lingua_usuario = '$locale'
                WHERE ainc_id_usuario = $ainc_id_usuario");
        }
    }

    /**
     * @todo: Document it.
     *
     * @param  [type] $ainc_id_usuario [description]
     * @return [type]
     */
    public function getLang($ainc_id_usuario)
    {
        return $this->db->query(
            "SELECT char_lingua_usuario
            FROM Usuarios
            WHERE ainc_id_usuario = $ainc_id_usuario
                OR char_fbid_usuario = '$ainc_id_usuario'
            LIMIT 1")->row()->char_lingua_usuario;
    }

    /**
     * Método de verificação de existencia do usuário dado o Id.
     *
     * @todo: Translate it.
     *
     * @access public
     * @param  {String} $id O ID do Facebook.
     * @return {int}        Return user's id. If there is no user, return false.
     */
    public function selecionarId($id)
    {
        $id = $this->db->query(
            "SELECT
                ainc_id_usuario
            FROM
                Usuarios
            WHERE
                char_fbid_usuario = '$id'
            LIMIT
                1")->row();

        if ($id != null)
            return $id->ainc_id_usuario;
        else
            return false;
    }

    /**
     * Seleciona 5 usuários com maior pontuação
     *
     * @todo: Translate it.
     *
     * @access public
     * @param  [type] $cidade [description]
     * @return [type]         [description]
     */
    public function getUsersByScore($ainc_id_cidade, $limit = 5)
    {
        $query =
            "SELECT
                Usuarios.ainc_id_cidade,
                Usuarios.char_fbid_usuario,
                Usuarios.inte_pontos_usuario,
                Usuarios.ainc_id_usuario,
                CONCAT(
                    Usuarios.char_nome_usuario, ' ',
                    Usuarios.char_sobrenome_usuario
                ) AS char_nomecompleto_usuario,
                (
                    SELECT
                        CONCAT(
                            Cidades.char_nomelocal_cidade, ', ',
                            IF(
                                Estados.char_id_estado IS NULL,
                                Paises.char_nome_pais,
                                Estados.char_nomelocal_estado
                            )
                        )
                    FROM
                        Cidades
                    LEFT JOIN
                        Estados ON (
                            Estados.char_id_estado = Cidades.char_id_estado
                            AND Estados.char_id_pais = Cidades.char_id_pais
                        )
                    INNER JOIN
                        Paises ON
                        Cidades.char_id_pais = Paises.char_id_pais
                    WHERE
                        Cidades.ainc_id_cidade = Usuarios.ainc_id_cidade
                ) AS char_local_usuario,
                (
                    SELECT SUM(int_reward_User_Bar_Contribution)
                    FROM   User_Bar_Contribution
                    WHERE  User_Bar_Contribution.ainc_id_usuario = Usuarios.ainc_id_usuario
                    AND    User_Bar_Contribution.ainc_id_bar IN (
                        SELECT Bares.ainc_id_bar
                        FROM   Bares
                        WHERE  Bares.ainc_id_cidade = $ainc_id_cidade
                    )
                ) AS inte_pontos_cidade

            FROM
                Usuarios

            HAVING
                inte_pontos_cidade IS NOT NULL
            ORDER BY
                inte_pontos_cidade DESC
            LIMIT
                $limit";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * Seleciona 5 usuários com maior pontuação.
     * Utilizado no typeahead do header.
     *
     * @todo: Translate it
     *
     * @access public
     * @param  [type] $cidade [description]
     * @return [type]         [description]
     */
    public function getUsers($cidade)
    {
        return $this->db->query(
            "SELECT
                char_nome_usuario,
                char_sobrenome_usuario,
                char_fbid_usuario,
                inte_pontos_usuario,
                CONCAT(char_nomelocal_cidade, ', ', char_nomelocal_estado) AS 'char_local_usuario',
                CONCAT('http://facebook.com/', char_fbid_usuario) AS 'url'
            FROM
                Usuarios
            LEFT JOIN
                Cidades ON
                (Cidades.ainc_id_cidade = Usuarios.ainc_id_cidade)
            LEFT JOIN
                Estados ON
                (Estados.char_id_estado = Cidades.char_id_estado
                AND Estados.char_id_pais = Cidades.char_id_pais)
            WHERE
                bit_status_usuario = 1
            ORDER BY
                inte_pontos_usuario DESC,
                char_nome_usuario ASC
            LIMIT
                10")->result();
    }

    /**
     * Criando novo perfil
     *
     * @todo: Translate it.
     *
     * @access public
     * @param  [type] $dados [description]
     * @return [type]        [description]
     */
    public function inserirUsuario($dados)
    {
        $campos = '';
        $valores = '';

        foreach ($dados as $key => $value) {
            $campos .= $key . ', ';
            $valores .= (is_string($value) ? "'$value'" : $value) . ', ';
        }

        // Remove útilma vírgula da string
        $campos = rtrim($campos, ', ');
        $valores = rtrim($valores, ', ');

        $query =
            "INSERT INTO
                Usuarios ($campos)
            VALUES
                ($valores)";

        $this->db->query($query);
        return $this->db->insert_id();
    }

    /**
     * Atualizar usuario
     *
     * @access public
     * @param  {Object} $dados Dados do usuário.
     * @param  {String} $id    Facebook or System user's ID.
     * @return {Object}        Affected rows
     */
    public function atualizarUsuario($dados, $uid)
    {
        $query =
            "UPDATE
                Usuarios
            SET ";

        foreach ($dados as $key => $value) {
            if($value != NULL) {
                $query .= $key . ' = ' . (is_string($value) ? "'$value'" : $value) . ', ';
            }
        }

        $query = rtrim($query, ', ');
        $query .= " WHERE char_fbid_usuario = '$uid' OR ainc_id_usuario = $uid ";

        $this->db->query($query);

        return $this->db->affected_rows();
    }

    /**
     * Recupera o idioma do usuário
     *
     * @param  {String} $fbid_usuario ID do Facebook do usuário
     * @return {Object}
     */
    public function language($fbid_usuario)
    {
        return $this->db->query(
            "SELECT
                char_lingua_usuario
            FROM
                Usuarios
            WHERE
                char_fbid_usuario = '$fbid_usuario'")->result();
    }

    /**
     * Retorna pontuação do usuário
     * @param  INT $id_usuario    Id do usuário
     * @return INT                pontuação do usuário
     */
    public function pontosUsuario($id)
    {
        $pontos = $this->db->query(
            "SELECT
                inte_pontos_usuario
            FROM
                Usuarios
            WHERE
                ainc_id_usuario = $id
                OR char_fbid_usuario = $id
            LIMIT
                1")->row();

        if ($pontos != null)
            return $pontos->inte_pontos_usuario;
        else
            return 0;
    }

    /**
     * Obtém dados dos usuários do Facebook.
     *
     * @param  [type] $uids           [description]
     * @param  [type] $ainc_id_cidade [description]
     * @param  [type] $ainc_id_bar    The ID of the bar (default: null)
     * @return [type]
     */
    public function usersInfo($uids, $ainc_id_cidade, $ainc_id_bar = null)
    {
        $query = "SELECT
                    Usuarios.char_fbid_usuario,
                    Usuarios.inte_pontos_usuario,
                    CONCAT(char_nome_usuario, ' ', char_sobrenome_usuario) AS char_nomecompleto_usuario,
                    CONCAT(char_nomelocal_cidade, ', ', char_nomelocal_estado) AS char_local_usuario,
                    (
                        SELECT SUM(int_reward_User_Bar_Contribution)
                        FROM User_Bar_Contribution
                        WHERE ainc_id_usuario = Usuarios.ainc_id_usuario
                            AND ainc_id_bar IN
                                (
                                    SELECT ainc_id_bar
                                    FROM Bares
                                    WHERE ainc_id_cidade  = $ainc_id_cidade
                                )
                    ) as inte_pontos_cidade
                FROM
                    Usuarios
                    INNER JOIN Cidades ON
                        Cidades.ainc_id_cidade = Usuarios.ainc_id_cidade
                    LEFT JOIN Estados ON
                        (Estados.char_id_estado = Cidades.char_id_estado
                        AND Estados.char_id_pais = Cidades.char_id_pais)
                WHERE
                    char_fbid_usuario IN ($uids)
                HAVING inte_pontos_cidade IS NOT NULL
                ORDER BY
                    inte_pontos_usuario DESC,
                    char_nomecompleto_usuario ASC
                LIMIT 5";

        return $this->db->query($query)->result();
    }

    /**
     * [userInfo description]
     *
     * @param  [type] $id [description]
     * @return [type]
     */
    public function userInfo($id) {
        return $this->db->query(
            "SELECT
                Usuarios.ainc_id_cidade,
                Usuarios.ainc_id_usuario,
                Usuarios.bit_status_usuario,
                Usuarios.char_fbid_usuario,
                Usuarios.char_nome_usuario,
                Usuarios.char_sobrenome_usuario,
                Usuarios.char_email_usuario,
                Usuarios.char_lingua_usuario,
                Usuarios.char_apelido_usuario,
                Usuarios.inte_last_place
            FROM
                Usuarios
            WHERE
                char_fbid_usuario = '$id'
                OR ainc_id_usuario = $id
            LIMIT
                1")->row();
    }

    /**
     * Adiciona ponto para o usuário baseado numa ação
     */
    public function adicionarPontos($usuario, $pontos)
    {
        $this->db->query(
            "UPDATE
                Usuarios
            SET
                inte_pontos_usuario = inte_pontos_usuario + $pontos
            WHERE
                ainc_id_usuario = $usuario");
    }

    /**
     * Get current interations of the user with Barpedia.
     *
     * @param  {Int}    $id_usuario The ID of the user.
     * @param  {Int}    $start      The LIMIT start.
     * @param  {Int}    $limit      The LIMIT amount.
     * @return {Object}
     */
    public function log($id_usuario, $start, $limit)
    {
        $query =
            "SELECT
                Log.ainc_id_subject,
                Log.stam_criacao_log AS stam_criacao_log,
                Log.ainc_id_object AS object,
                Log.ainc_id_bar,
                CONCAT(Usuarios.char_nome_usuario, ' ', Usuarios.char_sobrenome_usuario) AS subject,
                Actions.char_name_action AS action,
                Actions.int_value_action AS points,
                Reference_Object.char_name_ReferenceObject AS objType,
                Reference_Object.char_relatedtable_ReferenceObject AS objTable

            FROM
                Log

            INNER JOIN
                Actions ON
                Log.ainc_id_action = Actions.ainc_id_action
            INNER JOIN
                Reference_Object ON
                Log.ainc_id_ReferenceObject = Reference_Object.ainc_id_ReferenceObject
            INNER JOIN
                Usuarios ON
                Log.ainc_id_subject = Usuarios.ainc_id_usuario

            WHERE
                ainc_id_subject = $id_usuario

            ORDER BY
                stam_criacao_log DESC

            LIMIT
                $start, $limit";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * Get current actions of users with Barpedia.
     * Only visible for Barpedia admins.
     *
     * @param  {Int}     $start  The LIMIT start.
     * @param  {Int}     $limit  The LIMIT amount.
     * @return {Object}
     */
    public function getSystemLog($start, $limit)
    {
        $query =
            "SELECT
                Log_Sistema.ainc_id_usuario,
                Log_Sistema.stam_criacao_logsistema,
                Log_Sistema.char_ip_logsistema,
                Log_Sistema.char_agent_logsistema,
                Log_Sistema.char_pagina_logsistema,
                Log_Sistema.char_redirecionamento_logsistema,
                CONCAT(
                    Usuarios.char_nome_usuario, ' ',
                    Usuarios.char_sobrenome_usuario
                ) AS char_nomecompleto_usuario,
                Actions.char_name_action

            FROM
                Log_Sistema

            INNER JOIN
                Actions ON
                Log_Sistema.ainc_id_action = Actions.ainc_id_action
            LEFT JOIN
                Usuarios ON
                Log_Sistema.ainc_id_usuario = Usuarios.ainc_id_usuario

            ORDER BY
                Log_Sistema.stam_criacao_logsistema DESC

            LIMIT
                $start, $limit";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * Manually execute the stored procedure
     * to include values on Log_Sistema.
     *
     * @todo: Document it
     */
    public function callInsertSystemLog($id_user, $char_action, $ip, $user_agent, $page, $redirect)
    {
        $query =
            "CALL Insert_Into_SystemLog(
                $id_user,
                '$char_action',
                '$ip',
                '$user_agent',
                '$page',
                '$redirect'
            )";

        return $this->db->query($query);
    }

    /**
     * [lastUsers description]
     * @param  [type] $bar [description]
     * @return [type]      [description]
     */
    public function lastUsers($ainc_id_bar)
    {
        return $this->db->query(
            "SELECT
                Log.ainc_id_subject,
                Log.stam_criacao_log,

                Usuarios.char_fbid_usuario,
                Usuarios.ainc_id_usuario,
                Usuarios.inte_pontos_usuario,

                CONCAT(char_nome_usuario,' ', char_sobrenome_usuario) as 'char_nomecompleto_usuario',
                getUserTotalAddedBars(ainc_id_usuario) as 'inte_user_total_added_bars',
                getUserTotalBarsReviews(ainc_id_usuario) as 'inte_user_total_bars_reviews'

            FROM Log
            INNER JOIN Usuarios ON Usuarios.ainc_id_usuario = Log.ainc_id_subject
            WHERE Log.ainc_id_bar = $ainc_id_bar
            GROUP BY Log.ainc_id_subject
            ORDER BY Log.stam_criacao_log DESC, inte_pontos_usuario DESC
            LIMIT 5")->result();
    }

    /** {{AQUI}} GET INFO FROM LOG
     * [lastUsers description]
     * @param  [type] $bar [description]
     * @return [type]      [description]
     */
    public function topContributions($ainc_id_bar)
    {
        $query =
        "SELECT
            Usuarios.ainc_id_usuario,
            Usuarios.char_fbid_usuario,
            CONCAT (char_nome_usuario, ' ', char_sobrenome_usuario) as char_nomecompleto_usuario,

            User_Bar_Contribution.int_reward_User_Bar_Contribution,

            CONCAT(char_nomelocal_cidade, ', ', char_nomelocal_estado) AS char_local_usuario
        FROM
            User_Bar_Contribution
            INNER JOIN Usuarios
                ON User_Bar_Contribution.ainc_id_usuario = Usuarios.ainc_id_usuario
            INNER JOIN Cidades
                ON Usuarios.ainc_id_cidade = Cidades.ainc_id_cidade
            INNER JOIN Estados
                ON Cidades.char_id_estado  = Estados.char_id_estado
        WHERE
            Cidades.char_id_pais = Estados.char_id_pais
            AND User_Bar_Contribution.ainc_id_bar = $ainc_id_bar

        ORDER BY int_reward_User_Bar_Contribution DESC
        LIMIT 3";

        return $this->db->query($query)->result();
    }

    /**
     * [userContribution description]
     *
     * @param  [type] $friends_list [description]
     * @param  [type] $ainc_id_bar  [description]
     * @return [type]
     */
    public function userContribution($friends_list, $ainc_id_bar)
    {
        $query =
            "SELECT
                CONCAT(char_nome_usuario, ' ', char_sobrenome_usuario) AS char_nomecompleto_usuario,
                char_fbid_usuario,
                int_reward_User_Bar_Contribution,
                CONCAT(char_nomelocal_cidade, ', ', char_nomelocal_estado) AS char_local_usuario
            FROM
                Usuarios
            INNER JOIN
                Cidades ON
                Cidades.ainc_id_cidade = Usuarios.ainc_id_cidade
            INNER JOIN
                Estados ON (
                    Estados.char_id_estado = Cidades.char_id_estado
                    AND Estados.char_id_pais = Cidades.char_id_pais
                )
            INNER JOIN
                User_Bar_Contribution ON
                User_Bar_Contribution.ainc_id_usuario = Usuarios.ainc_id_usuario
            WHERE
                char_fbid_usuario IN ($friends_list) AND
                ainc_id_bar = $ainc_id_bar
            ORDER BY
                int_reward_User_Bar_Contribution DESC,
                char_nomecompleto_usuario ASC
            LIMIT 5";

        return $this->db
            ->query($query)
            ->result();
    }

    /**
     * Check if the user is active on db
     * @param  [int]  $ainc_id_usuario User id or facebook user id
     * @return [bool]                  Return status 1 if it is active or 0 if it is deactive
     */
    public function checkActivity($char_login_oauth)
    {
        return $this->db->query(
            "SELECT *
            FROM OAuth
            WHERE char_login_oauth = '$char_login_oauth'
            LIMIT 1")->row();
    }

    /**
     * [registerActivity description]
     *
     * @param  [type] $char_login_oauth [description]
     * @param  [type] $ainc_id_usuario  [description]
     * @param  [type] $char_ip_oauth    [description]
     * @param  [type] $char_agent_oauth [description]
     * @return [type]
     */
    public function registerActivity(
        $char_login_oauth,
        $ainc_id_usuario,
        $char_ip_oauth,
        $char_agent_oauth
    ) {
        $this->db->query(
            "DELETE FROM OAuth
            WHERE ainc_id_usuario = $ainc_id_usuario
            AND char_ip_oauth   = '$char_ip_oauth'
            AND char_agent_oauth= '$char_agent_oauth'");

        $this->db->query(
            "INSERT INTO OAuth
                VALUES ('$char_login_oauth',
                    $ainc_id_usuario,
                    '$char_ip_oauth',
                    '$char_agent_oauth'
                )");
    }

    /**
     * [removeActivity description]
     *
     * @param  [type] $char_login_oauth [description]
     * @return [type]
     */
    public function removeActivity($char_login_oauth)
    {
        $this->db->query(
            "DELETE FROM OAuth
            WHERE char_login_oauth = '$char_login_oauth'");
    }
}
