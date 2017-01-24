<div class="flex">
    <div class="text-justify">
        <h2>Processo Criativo</h2>
        <p>Criatividade e inspiração são as chaves para o sucesso de um projeto visual. Com uma linguagem adequada, a sua marca se destaca no mercado e ganha posicionamento em relação ao público-alvo que pretende atingir.</p>
        <p>Desde a concepção do logotipo, buscando sintetizar os conceitos que sua empresa pretende transmitir, até o desenvolvimento de todo material necessário, nós estamos preparados para formular idéias criativas e inovadoras para promover o seu negócio.</p>
        <p>Nosso conhecimento técnico em processos gráficos nos permite garantir o sucesso do produto final, dando suporte adequado para a produção do seu material.</p>
        <p>Estamos prontos para colorir as suas idéias!</p>
    </div>

    <div>
        <img src="assets/images/dist/photos/processo-criativo.jpg" class="grid-image" />
    </div>
</div>

<!-- Carousel -->
<div class="owl-thumbs" data-slider-id="1">
    <?php foreach ($carousel as $key => $item) { ?>
        <button class="owl-thumb-item owl-thumb-<?php echo $item[0] ?>"></button>
    <?php } ?>
</div>

<div class="owl-carousel owl-theme" data-slider-id="1">
    <?php foreach ($carousel as $key => $item) { ?>
        <img src="assets/images/dist/carousel/portfolio-<?php echo $item[0] ?>.png" alt="<?php echo $item[1] ?>" />
    <?php } ?>
</div>

