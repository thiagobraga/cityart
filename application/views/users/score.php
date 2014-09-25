<div class="panel panel-default margin-top-20">
    <div class="panel-heading">
        <i class="fa fa-trophy"></i> {{users_your_score}}
    </div>

    <div class="panel-body">
        <?php
        $count = count($notifications->events);
        if ($count) {
            for ($i = 0; $i < $count; $i++) {

                // Data da mensagem anterior
                if ($i > 0) {
                    $previous = date('d/m/Y', $lista[$i - 1]['stamp']);
                }

                // Log da mensagem atual
                $actual = date('d/m/Y', $notifications->events[$i]['stamp']);

                if ($i == 0 || $previous != $actual) { ?>
                    <br/>
                    <div class="label label-default">
                        <?php echo $actual ?>
                    </div>
                <?php } ?>

                <!-- Exibindo mensagem -->
                <div style="line-height:25px">
                    <?php echo $notifications->events[$i]['subject']
                        . ' {{' . $notifications->events[$i]['action'] . '}}'
                        . $notifications->events[$i]['object'];?>
                </div>

            <?php } ?>
        <?php } else { ?>
            {{users_actions_not_found}}
        <?php }?>
    </div>
</div>
