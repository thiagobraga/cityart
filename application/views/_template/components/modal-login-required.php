<!-- Login required -->
<div id="modal-login-required" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-login-required" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{login}}
                </h4>
            </div>
            <div class="modal-body">
                {{perform_login_with_facebook}}<br>
                {{click_here_to_login}}
            </div>
            <div class="modal-footer">
                <a class="btn btn-default no-border-radius"  data-dismiss="modal" aria-hidden="true">
                    {{close}}</a>

                <a href="/novo-bar" class="btn btn-facebook facebook-login no-border-radius">
                    {{navbar_login_with_facebook}}
                    <span class="fa fa-facebook-square"></span>
                </a>
            </div>
        </div>
    </div>
</div>
