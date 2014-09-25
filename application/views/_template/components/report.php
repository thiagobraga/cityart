<!-- REPORT -->
<div id="reportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-report">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{report_an_error}}</h4>
            </div>

            <div class="modal-body">
                <form id="report-form" class="form-horizontal" role="form">

                    <!-- Nome -->
                    <div class="form-group">
                        <label for="report-nome" class="col-sm-4 control-label">{{report_your_name}}</label>
                        <div class="col-sm-8">
                            <?php if (isset($session['ainc_id_usuario'])) { ?>
                                <input id="report-nome"
                                    type="text"
                                    class="form-control"
                                    placeholder="{{report_type_your_name}}"
                                    value="<?php echo $session['char_nome_usuario'] . ' ' .$session['char_sobrenome_usuario'] ?>"
                                    data-fbid="<?php echo $session['char_fbid_usuario'] ?>"
                                    data-uid="<?php echo $session['ainc_id_usuario'] ?>"
                                    readonly />
                            <?php } else { ?>
                                <input id="report-nome"
                                    type="text"
                                    class="form-control"
                                    placeholder="{{report_type_your_name}}" />
                            <?php } ?>
                        </div>
                    </div>

                    <!-- E-mail -->
                    <div class="form-group">
                        <label for="report-email" class="col-sm-4 control-label">{{report_your_email}}</label>
                        <div class="col-sm-8">
                            <?php if (isset($session['ainc_id_usuario'])) { ?>
                                <input id="report-email"
                                    type="text"
                                    class="form-control"
                                    placeholder="{{report_type_your_email}}"
                                    value="<?php echo $session['char_email_usuario'] ?>"
                                    readonly />
                            <?php } else { ?>
                                <input id="report-email"
                                    type="email"
                                    class="form-control"
                                    placeholder="{{report_type_your_email}}" />
                            <?php } ?>
                        </div>
                    </div>

                    <!-- URL -->
                    <div class="form-group">
                        <label for="report-url" class="col-sm-4 control-label">{{report_current_url}}</label>
                        <div class="col-sm-8">
                            <input id="report-url"
                                type="text"
                                class="form-control"
                                value="<?php echo current_url() ?>"
                                readonly />
                        </div>
                    </div>

                    <!-- Mensagem -->
                    <div class="form-group">
                        <label for="report-mensagem" class="col-sm-4 control-label">{{report_your_message}}</label>
                        <div class="col-sm-8">
                            <textarea id="report-mensagem"
                                class="form-control"
                                placeholder="{{report_details_of_your_report}}"
                                rows="6"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div class="col-sm-7 no-padding">
                    <small id="report-result-ok" class="text-success hidden">{{feedback_thanks_for_your_contribution}}</small>
                    <small id="report-result-error" class="text-danger hidden"><b>{{feedback_an_error_occurred}}</b></small>
                </div>

                <div class="col-sm-1 no-padding">
                    <img src="/assets/images/icons/feedback-preloader.gif" class="hidden preloader" />
                </div>

                <div class="col-sm-4 no-padding">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{close}}</button>
                    <button id="report-send" type="submit" class="btn btn-primary pull-right">{{send}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
