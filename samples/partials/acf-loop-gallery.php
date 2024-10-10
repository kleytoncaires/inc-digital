<?php
$swiper_id = 'gallery-' . uniqid();
$images = get_field('gallery', 'option');
?>

<?php if ($images): ?>
    <ul>
        <?php foreach ($images as $image): ?>
            <li>
                <a data-src="<?php echo esc_url($image['url']); ?>" data-fancybox="gallery-<?php echo $swiper_id; ?>" data-caption="<?php echo esc_attr($image['alt']); ?>">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy" />
                    <p><?php echo esc_html($image['caption']); ?></p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>