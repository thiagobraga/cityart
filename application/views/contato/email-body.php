<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>CityArt Artes Gráficas | <?php echo $subject ?></title>
    </head>
    <body>
        <p>
            O usuário <?php echo $name ?> enviou a seguinte mensagem:<br/>
            <br/>
            <blockquote style="border-left: 3px solid #999; margin-left: 0; padding-left: 10px;">
                <?php echo nl2br($message) ?>
            </blockquote>
        </p>

        <div style="font-size: 12px; margin-top: 30px; background: #eee; padding: 10px; border-radius: 2px">
            <b>Informações adicionais</b><br/>
            <br/>
            Navegador: <?php echo $browser ?><br/>
            Versão: <?php echo $version ?><br/>
            Mobile: <?php echo $mobile === '' ? 'Não' : $mobile ?><br/>
            Plataforma: <?php echo $platform ?>
        </div>
    </body>
</html>
