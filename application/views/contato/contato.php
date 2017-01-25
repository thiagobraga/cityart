<div class="flex">
    <div class="col-xs-12 col-md-6">
        <h2>Contato</h2>

        <form class="form-horizontal" role="form">
            <!-- Nome -->
            <input id="name"
                type="text"
                class="form-control input-lg form-name"
                placeholder="Informe seu nome"
                required />

            <!-- E-mail -->
            <input id="email"
                type="email"
                class="form-control input-lg form-email"
                placeholder="E-mail para entrarmos em contato"
                required />

            <!-- Message -->
            <textarea id="message"
                class="form-control input-lg form-message"
                rows="6"
                placeholder="Envie-nos sua dúvida, opinião ou sugestão"
                required></textarea>

            <!-- Actions -->
            <div class="col-xs-12 text-center">
                <button id="send"
                    class="btn btn-success btn-lg">
                    Enviar

                    <span class="ionicons ion-ios-email-outline"></span>
                    <span class="ionicons ion-load-c fa-spin hidden"></span>
                </button>
            </div>
        </form>
    </div>

    <div class="col-xs-12 col-md-6">

    </div>
</div>
