<?php get_header(); ?>

<?php get_template_part('partials/embed-video', null, [
    // 'video_link' => $video_link,      // Link to the video
    'video_link' => 'https://www.youtube.com/watch?v=LJV0NZY5p94',
    'modal' => false,                   // Set to true for modal, false for direct display
    // 'thumbnail_image' => $thumbnail_image // Custom thumbnail image, if available
]); ?>

<?php get_template_part('partials/loop-ajax'); ?>

<?php get_footer(); ?>