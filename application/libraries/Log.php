<?php

/**
 * Log.php
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
 * @version   GIT:
 * @link      http://barpedia.org
 * @since     File available since Release 0.0.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Log
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @author Matheus Cesario <matheus@institutosoma.org.br>
 * @access public
 * @version 1.0
 */
class Log
{

    /**
     * [$action description]
     *
     * @var {String}
     */
    public $action;

    /**
     * [$object description]
     *
     * @var {String}
     */
    public $object = '';

    /**
     * [$log description]
     *
     * @var [type]
     */
    public $log;

    /**
     * Public variable to pass bar data between functions.
     *
     * @var {Int}
     */
    public $bar;

    /**
     * Public variable to pass user data between functions.
     *
     * @var {Int}
     */
    public $user;

    /**
     * [log description]
     *
     * @return [type] [description]
     */
    public function get($start, $limit)
    {
        // Setting up language
        $this->data->locale   = MY_Controller::setLang();

        // Variables
        $lista                = array();
        $index                = 0;
        $period_notifications = '';
        $this->user           = $this->session->userdata('ainc_id_usuario');
        $events_log           = Usuarios_model::log($this->user, $start, $limit);

        // Listing events
        foreach ($events_log as $log) {
            $this->log = $log;

            // Pontos
            $points = ($this->log->points > 0 ? '+' : '') . $this->log->points;

            // Sujeito que executa ação
            $subject = ($this->log->ainc_id_subject == $this->user)
                ? '{{you}}'
                : $this->log->subject;

            $this->bar = Bares_model::load($this->log->ainc_id_bar);

            // Medium bold text for char_nome_bar
            $this->bar->char_nome_bar = '<b>' . $this->bar->char_nome_bar . '</b>';

            // Get the URL of the bar
            $this->bar->href = strtolower(
                  '/' . $this->bar->char_id_pais
                . '/' . $this->bar->char_nomeamigavel_estado
                . '/' . $this->bar->char_nomeamigavel_cidade
                . '/' . $this->bar->char_nomeamigavel_bar
            );

            switch ($this->log->objType) {
                case 'log_photo'  : Log::photoLog();   break;
                case 'log_event'  : Log::eventsLog();  break;
                case 'log_page'   : Log::pageLog();    break;
                case 'log_menu'   : Log::menuLog();    break;
                case 'log_comment': Log::commentLog(); break;
                case 'log_filter' : Log::filterLog();
            }

            $time = strtotime($this->log->stam_criacao_log) - $this->bar->gmt_offset;
            $date = date('c', $time);

            $lista[$index] = array(
                'ponto'   => $points,
                'subject' => $subject,
                'action'  => $this->action,
                'object'  => $this->object,
                'bar'     => $this->bar->char_nome_bar,
                'href'    => $this->bar->href,
                'stamp'   => $date
            );

            $index++;
        }

        $period_notifications = $lista[--$index]['stamp'];

        $aux = (object) array(
            'period_notifications' => $period_notifications,
            'events'               => $lista
        );

        return $aux;
    }

    /**
     * Get contents from System Log table.
     * Visible only for Barpedia admin.
     *
     * @param  {Int}    $start The start of limit clause.
     * @param  {Int}    $limit The amount of items on limit clause.
     * @return {Object}
     */
    public function getSystemLog($start, $limit)
    {
        return Usuarios_model::getSystemLog($start, $limit);
    }

    /**
     * Generate the HTML output log entries referring to photos of the bars.
     *
     * @return {Void}
     */
    protected function photoLog()
    {
        $photo        = Bares_model::getPhoto($this->log->object);
        $this->action = '<p>{{' . $this->log->action . '}} {{a_photo_in}} ' . $this->bar->char_nome_bar . '</p>';
        $this->object = '<img src="/image/bares/' . $photo->char_filename_photobar . '/42/42/c" />';
    }

    /**
     * Generate the HTML output log entries referring to events of the bars.
     *
     * @return {Void}
     */
    protected function eventsLog()
    {
        $evento       = Bares_model::exibirDadosEvento($this->log->object);
        $this->action = '<p>{{' . $this->log->action . '}} {{a_photo_in}} ' . $this->bar->char_nome_bar . '</p>';
        $this->object = $this->log->objType . ' <i>"' . $evento->char_titulo_eventobar . '"</i>';
    }

    /**
     * Generate the HTML output log entries referring to the bars.
     *
     * @return {Void}
     */
    protected function pageLog()
    {
        if ($this->log->action == 'action_evaluated') {
            $rate         = Bares_model::getRate($this->user, $this->bar->ainc_id_bar);
            $this->action = '<p>{{' . $this->log->action . '}} ' . $this->bar->char_nome_bar . '</p>';
            $this->object = '<span class="fa fa-thumbs-o-up"></span>'
                . '<small>{{note}}: ' . i18n($rate) . '</small>';
        } else {
            $this->action = '<p>{{' . $this->log->action . '}} {{the_page}} ' . $this->bar->char_nome_bar . '</p>';
            $this->object = '<img src="/image/bares/' . $this->bar->char_logo_bar . '/42/42/c" />';
        }
    }

    /**
     * Generate the HTML output log entries referring to menu items of the bars.
     *
     * @return {Void}
     */
    protected function menuLog()
    {
        $item = Bares_model::itemCardapio($this->log->object);
        $link = '/' . strtolower($this->bar->char_uf_estado)
            . '/' . $this->bar->char_nomeamigavel_cidade
            . '/' . $this->bar->char_nomeamigavel_bar;

        $this->action = '<p>{{' . $this->log->action . '}} ' . $this->bar->char_nome_bar . '</p>';
        $this->object = $item->char_nome_itemcardapio . ' ao cardápio da página '
            . $this->bar->char_nome_bar;
    }

    /**
     * Generate the HTML output log entries referring to comments of the bars.
     *
     * @return {Void}
     */
    protected function commentLog()
    {
        $comment      = Bares_model::getComment($this->log->object)->char_textocomentario_comentariobar;
        $this->action = '<p>{{action_commented}} {{in}} ' . $this->bar->char_nome_bar . '</p>';
        $this->object = '<span class="fa fa-comments-o"></span>'
            . '<small>"' . sliceSentence($comment, 80) . '"</small>';
    }

    /**
     * Generate the HTML output log entries referring to filters of the bars.
     *
     * @return {Void}
     */
    protected function filterLog()
    {
        $filtro       = Bares_model::selecionarFiltro($this->log->object);
        $this->action = '<p>{{' . $this->log->action . '}} ' . $this->bar->char_nome_bar . '</p>';
        $this->object = '<span class="fa fa-tags"></span>'
            . '<small>{{' . $filtro->char_titulo_filtrobarcategoria . '}}:'
            . ' {{' . $filtro->char_texto_filtrobar . '}}</small>';
    }

}

/* End of file Log.php */
/* Location: ./application/libraries/Log.php */
