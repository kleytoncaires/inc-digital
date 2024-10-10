<div class="">
    <h2 class="">
        <?php the_title(); ?>
    </h2>

    <div class="remove-last-margin">
        <?php the_content(); ?>
    </div>

    <?php
    $image_args = array(
        'class' => 'img-fluid',
        'loading' => 'lazy',
    );

    the_post_thumbnail('full', $image_args);
    ?>
</div>