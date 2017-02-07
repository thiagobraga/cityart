<div class="content-wrapper">
    <div class="text-justify">
        <h2>Processo Criativo</h2>
        <p>Criatividade e inspiração são as chaves para o sucesso de um projeto visual. Com uma linguagem adequada, a sua marca se destaca no mercado e ganha posicionamento em relação ao público-alvo que pretende atingir.</p>
        <p>Desde a concepção do logotipo, buscando sintetizar os conceitos que sua empresa pretende transmitir, até o desenvolvimento de todo material necessário, nós estamos preparados para formular idéias criativas e inovadoras para promover o seu negócio.</p>
        <p>Nosso conhecimento técnico em processos gráficos nos permite garantir o sucesso do produto final, dando suporte adequado para a produção do seu material.</p>
        <p><b>Estamos prontos para colorir as suas idéias!</b></p>
    </div>

    <div>
        <img src="assets/images/dist/photos/processo-criativo.jpg" class="grid-image image-shadow" />
    </div>
</div>

<div class="carousel-images">
    <div class="flexslider thumbnails">
        <div id="thumbnails" class="thumbnails-wrapper">
            <ul class="slides">
                <?php foreach ($carousel as $key => $item) { ?>
                    <li><img src="assets/images/dist/carousel/icon-<?php echo $item[0] ?>.jpg" alt="<?php echo $item[1] ?>" /></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div id="carousel" class="flexslider carousel">
        <ul class="slides">
            <?php foreach ($carousel as $key => $item) { ?>
                <li><img src="assets/images/dist/carousel/portfolio-<?php echo $item[0] ?>.png" alt="<?php echo $item[1] ?>" /></li>
            <?php } ?>
        </ul>
    </div>
</div>
