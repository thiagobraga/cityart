<?php
$name   = $session['char_nome_usuario'] . ' ' . $session['char_sobrenome_usuario'];
$fbid   = $session['char_fbid_usuario'];
$imgSrc = "//graph.facebook.com/$fbid/picture?width=24&height=24";
?>

<!-- User pic and name -->
<img src="<?php echo $imgSrc ?>" width="24" height="24" />
<span id="user"><?php echo $name ?></span>
<b class="caret"></b>
