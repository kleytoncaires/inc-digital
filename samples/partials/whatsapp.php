<?php
$whatsapp = get_field('whatsapp', 'option');
$linkWhatsapp = preg_replace('/\D/', '', $whatsapp);
?>

<?php if ($whatsapp) : ?>
    <a href="https://wa.me/55<?php echo $linkWhatsapp ?>" class="" target="_blank">
        <?php echo $whatsapp; ?>
    </a>
<?php endif; ?>