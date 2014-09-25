<header class="header">
    <div class="container">
        <a href="/">
            <img src="/assets/images/logo/logo.png"
                alt="Barpedia"
                class="img-logo pull-left visible-lg visible-md"
                width="230"
                height="162" />
        </a>

        <h1>{{header_find_a_bar}} <?php echo $location->char_nomelocal_cidade ?></h1>
        <h3>{{header_what_youre_looking_for}}</h3>

        <form class="form-horizontal" role="search">
            <input id="search-feature"
                type="text"
                class="form-control input-lg typeahead"
                autocomplete="off"
                data-provide="typeahead"
                placeholder="{{header_find_a_bar_placeholder}}" />

            <!-- Preloader -->
            <span id="search-feature-preloader" class="form-control-feedback hidden">
                <img src="/assets/images/icons/typeahead-preloader.gif">
            </span>
        </form>
    </div>
</header>
