<?php

if (!empty($fotos)) {
    $count = count($fotos);

    foreach ($fotos as $i => $foto) {
        // Slice the char_label_photobar if the size is bigger than 170 characters.
        $strlen = strlen($foto->char_label_photobar);

        if ($strlen > 170) {
            $label = sliceSentence($foto->char_label_photobar, 170);
        } else {
            $label = $foto->char_label_photobar;
        }

        // Verify if the char_label_photobar does not contain 'Fonte Facebook'.
        if (strpos($foto->char_label_photobar, 'Fonte Facebook') === false) {
            if ($foto->char_label_photobar != '') {
                $label = htmlentities(' | ' . $label, null, 'UTF-8');
            }

            $label .= htmlentities(' | {{bar_added_by}} <a href="http://facebook.com/' . $foto->char_fbid_usuario . '" target="_blank" class="text-warning">' . $foto->nome_usuario . '</a>');

        // If contains, show the text in the user language.
        } else {
            if ($strlen > 170) {
                $label .= ' | {{source}} Facebook';
            }

            $label = str_replace('Fonte Facebook', '{{source}} Facebook', $label);
            $label = htmlentities(' | ' . $label, null, 'UTF-8');
        }

        // Show only 5 photos in the page and hide the others.
        // All photos will be shown on Lightbox.
        $class = 'hidden';

        if ($i < 5) {
            $class = '';

            if ($i === 0) {
                $image_class = 'first-row';
            } else if ($i <= 2) {
                $image_class = 'second-row';
            } else {
                $image_class = 'third-row';
            } ?>
        <?php }?>

        <a href="/assets/images/bares/<?php echo $foto->char_filename_photobar ?>.jpg" data-lightbox="image-1" class="<?php echo $class ?>" data-title="<?php echo $bar->char_nome_bar . $label ?>">
            <img src="/image/bares/<?php echo $foto->char_filename_photobar ?>/240/140/c" class="img-responsive img-shadow <?php echo $image_class ?>" />
        </a>
    <?php }

    // Show a no-image box with link depending on how many photos.
    switch ($count) {
        case 1: ?>
            <div class="no-image img-shadow second-row"><a href="#">+</a></div>
            <div class="no-image img-shadow second-row"><a href="#">+</a></div>
            <?php break;

        case 2: ?>
            <div class="no-image img-shadow second-row"><a href="#">+</a></div>
            <?php break;

        case 3: ?>
            <div class="no-image img-shadow third-row"><a href="#">+</a></div>
            <div class="no-image img-shadow third-row"><a href="#">+</a></div>
            <div class="no-image img-shadow third-row"><a href="#">+</a></div>
            <?php break;

        case 4: ?>
            <div class="no-image img-shadow third-row"><a href="#">+</a></div>
            <div class="no-image img-shadow third-row"><a href="#">+</a></div>
            <?php break;

        default: ?>
            <div class="no-image img-shadow third-row"><a href="#">+</a></div>
            <?php break;
    }
} else { ?>
    <div class="no-image img-shadow first-row"><a href="#">+</a></div>
<?php } ?>
