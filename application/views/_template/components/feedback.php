<!-- Feedback -->
<div id="feedback-component" class="feedback-form slide-out hidden">
    <a id="handle-feedback" href="#" class="transition-400">{{feedback}}</a>

    <form id="feedback-form" role="form">
        <div class="form-group">
            <label>{{feedback_we_want_your_opinion}}</label>
        </div>

        <div class="form-group">
            <?php if (isset($session['ainc_id_usuario'])) { ?>
                <input id="feedback-nome"
                    type="text"
                    class="form-control"
                    placeholder="{{feedback_your_name}}"
                    value="<?php echo $session['char_nome_usuario'] . ' ' .$session['char_sobrenome_usuario'] ?>"
                    data-fbid="<?php echo $session['char_fbid_usuario'] ?>"
                    data-uid="<?php echo $session['ainc_id_usuario'] ?>"
                    readonly />
            <?php } else { ?>
                <input id="feedback-nome"
                    type="text"
                    class="form-control"
                    placeholder="{{feedback_your_name}}" />
            <?php } ?>
        </div>

        <div class="form-group">
            <?php if (isset($session['ainc_id_usuario'])) { ?>
                <input id="feedback-email"
                    type="email"
                    class="form-control"
                    placeholder="{{feedback_your_email}}"
                    value="<?php echo $session['char_email_usuario'] ?>"
                    readonly />
            <?php } else { ?>
                <input id="feedback-email"
                    type="email"
                    class="form-control"
                    placeholder="{{feedback_your_email}}" />
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="feedback-mensagem">{{feedback_something_we_can_improve}}</label>
            <textarea id="feedback-mensagem"
                class="form-control"
                rows="6"></textarea>
        </div>

        <div class="form-group">
            <div class="col-sm-8 no-padding">
                <small id="feedback-result-ok" class="text-success hidden">{{feedback_thanks_for_your_contribution}}</small>
                <small id="feedback-result-error" class="text-danger hidden"><b>{{feedback_an_error_occurred}}</b></small>
            </div>

            <div class="col-sm-1 no-padding">
                <img src="/assets/images/icons/feedback-preloader.gif" class="hidden preloader" />
            </div>

            <div class="col-sm-3 no-padding">
                <button id="feedback-send" type="submit" class="btn btn-primary pull-right">{{send}}</button>
            </div>
        </div>
    </form>
</div>
