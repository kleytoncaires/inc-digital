<div class="">
    <?php if (get_the_title()) : ?>
        <h2 class="">
            <?php the_title(); ?>
        </h2>
    <?php endif; ?>

    <?php if (get_the_content()) : ?>
        <div class="remove-last-margin">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>

    <?php if (has_post_thumbnail()) : ?>
        <?php
        $image_args = array(
            'class' => '',
            'loading' => 'lazy',
        );
        the_post_thumbnail('full', $image_args);
        ?>
    <?php endif; ?>
</div>