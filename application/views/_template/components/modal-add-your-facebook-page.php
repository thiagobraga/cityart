<!-- MODAL -->
<div id="modal-add-your-facebook-page"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-add-your-facebook-page"
    aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <header class="modal-header">
                <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{your_establishment_in_barpedia}}</h4>
            </header>

            <section class="modal-body">
                {{you_manage_facebook_pages}}
            </section>

            <footer class="modal-footer text-right">
                <button class="btn btn-default"
                    data-dismiss="modal"
                    aria-hidden="true">
                    {{not_now}}
                </button>

                <a href="<?php echo base_url(uri_string() . '/novo-bar') ?>"
                    class="btn btn-success">
                    {{yes_include}}
                </a>
            </footer>
        </div>
    </div>
</div>
