<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $subject ?></title>
    </head>
    <body>
        <p>
            O usuário <a href="https://facebook.com/<?php echo $fbid_user ?>"><?php echo $nome ?></a>
            enviou o seguinte feedback:<br/>
            <br/>
            ----------------------<br/>
            <?php echo $mensagem ?><br/>
            ----------------------
        </p>
        <br/>
        <b>Informações adicionais</b><br/>
        <ul>
            <li>Navegador: <?php echo $browser ?></li>
            <li>Versão: <?php echo $version ?></li>
            <li>Mobile: <?php echo $mobile == null ? 'Não' : $mobile ?></li>
            <li>Plataforma: <?php echo $platform ?></li>
        </ul>
    </body>
</html>
