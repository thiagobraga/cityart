<!-- FACEBOOK REDIRECT -->
<div id="facebookRedirect" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-redirect">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="facebookRedirectLabel">
                    <span class="fa fa-facebook-square"></span>
                    {{redirect_connecting_with_facebook}}
                </h4>
            </div>

            <div class="modal-body">
                {{redirect_facebook_returned_different_city}}<br/><br/>
                <b>
                    {{redirect_do_you_want_to_be_redirected_to}}
                    <span id="facebook-cidade"></span>?
                </b>
            </div>

            <div class="modal-footer text-center">
                <button id="dont-redirect" type="button" class="btn btn-default" data-dismiss="modal">{{redirect_not_close}}</button>
                <button id="redirect" type="submit" class="btn btn-success" autofocus>{{redirect_yes_redirect}}</button>
            </div>
        </div>
    </div>
</div>
