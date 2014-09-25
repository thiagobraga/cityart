<div id="info-office-hours" class="col-xs-12 margin-15"  style="margin-bottom:0 !important">

    <?php

    $days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun', 'holi');

    foreach ($days as $day) {
        $day_of_week = $day;
        $open        = $day . '-open';
        $close       = $day . '-close';
        ?>

        <div id="<?php echo $day ?>" class="info-office-hours-day row text-muted">
            <div class="col-xs-1">
                {{<?php echo $day_of_week ?>}}.
            </div>

            <!-- Open -->
            <div class="form-group col-xs-4">
                <div class="input-group date" rel="timepicker">
                    <input id="<?php echo $open ?>" type="text" class="form-control" disabled/>
                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                </div>
            </div>

            <div class="col-xs-1 text-center">
                {{to}}
            </div>

            <!-- Close -->
            <div class="form-group col-xs-4">
                <div class="input-group date" rel="timepicker">
                    <input id="<?php echo $close ?>" type="text" class="js-timepicker form-control" disabled/>
                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                </div>
            </div>

            <div class="col-xs-3 margin-left-15 margin-bottom-0">
                <label>
                    <input type="checkbox" class="no-hours" value="<?php echo $day ?>" checked>
                        <small>{{closed}}</small>
                </label>
            </div>
        </div>
    <?php } ?>
</div>
