<div class="panel panel-default panel-contact panel-send-message">
    <div class="panel-heading">
        {{contact_send_a_message}}
        <small>{{contact_send_a_message_description}}</small>
    </div>
    <div class="panel-body">
        <div class="row row-form">
            <div class="col-xs-6 form-group">
                <input id="contact-name"
                    name="contact-name"
                    type="text"
                    class="form-control"
                    placeholder="{{contact_your_name}}"
                    value="<?php if (isset($session['ainc_id_usuario'])) { echo $session['char_nome_usuario'] . ' ' . $session['char_sobrenome_usuario']; } ?>" />
            </div>
            <div class="col-xs-6 form-group">
                <input id="contact-email"
                    name="contact-email"
                    type="email"
                    class="form-control"
                    placeholder="{{contact_your_email}}"
                    value="<?php if (isset($session['ainc_id_usuario'])) { echo $session['char_email_usuario']; } ?>" />
            </div>
        </div>

        <div class="row row-form">
            <div class="col-xs-12 form-group">
                <textarea id="contact-message"
                    name="contact-message"
                    class="form-control"
                    rows="6"
                    placeholder="{{contact_your_message}}"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 text-right">
                <img class="preloader invisible" src="/assets/images/icons/typeahead-preloader.gif">
                <button class="btn btn-primary btn-lg">{{send}}</button>
            </div>
        </div>
    </div>
</div>
