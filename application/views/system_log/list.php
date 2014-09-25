<?php if (!$system_log) { ?>
    <article class="well">{{no_action_was_registered_in_the_site}}</article>
<?php } else { ?>
    <table class="table table-hover table-striped system-log">
        <colgroup>
            <col class="user" />
            <col class="action" />
            <col class="redirect" />
            <col class="page" />
            <col class="ip" />
            <col class="user-agent" />
            <col class="date" />
        </colgroup>

        <thead>
            <th>{{system_log_user}}</th>
            <th>{{system_log_action}}</th>
            <th>{{system_log_redirect}}</th>
            <th>{{system_log_page}}</th>
            <th>{{system_log_ip}}</th>
            <th>{{system_log_user_agent}}</th>
            <th>{{system_log_date}}</th>
        </thead>

        <tbody>
            <?php foreach ($system_log as $log) {
                $time = strtotime($log->stam_criacao_logsistema);
                $date = date('c', $time); ?>

                <tr>
                    <td>
                        <?php
                        echo ($log->char_nomecompleto_usuario)
                            ? $log->char_nomecompleto_usuario
                            : '{{undefined}}';
                        ?>
                    </td>
                    <td>{{<?php echo $log->char_name_action ?>}}</td>
                    <td><?php echo $log->char_redirecionamento_logsistema ?></td>
                    <td><?php echo $log->char_pagina_logsistema ?></td>
                    <td class="text-center"><?php echo $log->char_ip_logsistema ?></td>
                    <td title="<?php echo $log->char_agent_logsistema ?>">
                        <?php echo sliceSentence($log->char_agent_logsistema, 50) ?>
                    </td>
                    <td class="text-center"><?php echo date('d/m/Y H:m:s', strtotime($log->stam_criacao_logsistema)) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
