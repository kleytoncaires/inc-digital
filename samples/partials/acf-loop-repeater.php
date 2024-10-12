<?php $rows = get_field('repeater'); ?>

<?php if ($rows): ?>
    <ul>
        <?php foreach ($rows as $row):
            $titulo = isset($row['titulo']) ? $row['titulo'] : '';
            $descricao = isset($row['descricao']) ? $row['descricao'] : '';
            $imagem = isset($row['imagem']) ? $row['imagem'] : '';
        ?>
            <li>
                <?php if ($titulo): ?>
                    <h3 class="">
                        <?php echo esc_html($titulo); ?>
                    </h3>
                <?php endif; ?>

                <?php if ($descricao): ?>
                    <div class="remove-last-margin">
                        <?php echo $descricao; ?>
                    </div>
                <?php endif; ?>

                <?php if ($imagem): ?>
                    <img src="<?php echo esc_url($imagem['url']); ?>" alt="<?php echo esc_attr($imagem['alt']); ?>" loading="lazy" class="">
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>