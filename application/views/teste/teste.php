<div id="fb-root"></div>
<script>
    var fbApiInit = false,

        fbEnsureInit = (function fbEnsureInit(callback) {
            console.log('fbApiInit = ', fbApiInit);
            if(!fbApiInit) {
                setTimeout(function() {fbEnsureInit(callback);}, 50);
            } else {
                console.log('FB API initalized');
                if(callback) {
                    callback();
                }
            }
        }());

  window.fbAsyncInit = function() {
    FB.init({
        cookie : true,
        appId  : '237267543113267',
        cookie : true,
        xfbml  : true,
        version: 'v2.1'
    });
    fbApiInit = true;
  };

  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "https://connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));

</script>
<a href="#" onclick="checkIfLoaded();">Check</a>
