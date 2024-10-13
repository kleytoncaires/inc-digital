# Useful WordPress Snippets

This is a list of useful WordPress functions that I often reference to enhance or clean up my sites. Please be careful and make backups.

-   [Post Thumbnail With Lazy Loading](#post-thumbnail-with-lazy-loading)
-   [Embedded Video Display with Modal Option and Custom Thumbnail](#embedded-video-display-with-modal-option-and-custom-thumbnail)
-   [Swiper Integration with WordPress Posts](#swiper-integration-with-wordpress-posts)
-   [Repeater Field Display from ACF in PHP](#repeater-field-display-from-acf-in-php)
-   [Post List and Pagination in PHP with WP_Query](#post-list-and-pagination-in-php-with-wp_query)
-   [Display Specific Page Content in PHP with WP_Query](#display-specific-page-content-in-php-with-wp_query)
-   [AJAX to Load More Posts in WordPress Without Reloading](#ajax-to-load-more-posts-in-wordpress-without-reloading)
-   [AJAX Search Implementation for Posts](#ajax-search-implementation-for-posts)
-   [Contact Form with Name, Phone, Email, and Message Fields](#contact-form-with-name-phone-email-and-message-fields)
-   [Contact Form 7 Select Field for Brazilian States](#contact-form-7-select-field-for-brazilian-states)
-   [Contact Form 7 Body Message](#contact-form-7-body-message)
-   [Generate dynamic WhatsApp link with sanitized number](#generate-dynamic-whatsapp-link-with-sanitized-number)
-   [Dynamic Image Gallery with Fancybox Integration and Unique Gallery ID](#dynamic-image-gallery-with-fancybox-integration-and-unique-gallery-id)
-   [Dynamic Repeater Field Rendering with Optional Title, Description, and Image](#dynamic-repeater-field-rendering-with-optional-title-description-and-image)

## Post Thumbnail With Lazy Loading

```php
<?php if (has_post_thumbnail()) : ?>
    <?php
    $image_args = array(
        'class' => '',
        'loading' => 'lazy',
    );
    the_post_thumbnail('full', $image_args);
    ?>
<?php endif; ?>
```

## Embedded Video Display with Modal Option and Custom Thumbnail

```php
<?php get_template_part('core/embed-video', null, [
    'video_link' => $video_link, // Link to the video
    'modal' => true, // Set to true for modal, false for direct display
    'thumbnail_image' => $thumbnail_image // Custom thumbnail image, if available
]); ?>
```

## Swiper Integration with WordPress Posts

```php
<?php $swiper_id = 'swiper-' . uniqid(); ?>

<?php if (have_posts()) : ?>
    <div class="swiper-container" id="<?php echo $swiper_id; ?>">
        <div class="swiper-wrapper">
            <?php while (have_posts()) : the_post(); ?>
                <div class="swiper-slide">
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <!-- Initialize Swiper with responsiveness -->
    <script>
        var swiper = new Swiper('#<?php echo $swiper_id; ?>', {
            navigation: {
                nextEl: '#<?php echo $swiper_id; ?> .swiper-button-next',
                prevEl: '#<?php echo $swiper_id; ?> .swiper-button-prev',
            },
            pagination: {
                el: '#<?php echo $swiper_id; ?> .swiper-pagination',
                clickable: true,
            },
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
            }
        });
    </script>
<?php endif; ?>
```

## Repeater Field Display from ACF in PHP

```php
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
```

## Gallery Display from ACF Field in PHP

```php
<?php
$gallery_id = 'gallery-' . uniqid();
$images = get_field('gallery', 'option');
?>

<?php if ($images): ?>
    <ul>
        <?php foreach ($images as $image): ?>
            <li>
                <a data-src="<?php echo esc_url($image['url']); ?>" data-fancybox="gallery-<?php echo $gallery_id; ?>" data-caption="<?php echo esc_attr($image['alt']); ?>">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy" />
                    <p><?php echo esc_html($image['caption']); ?></p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
```

## Post List and Pagination in PHP with WP_Query

```php
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type'      => '', // CHANGE
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post_date',
    'order'          => 'desc',
    'paged'          => $paged,
);

$posts_query = new WP_Query($args);
?>

<?php if ($posts_query->have_posts()) : ?>
    <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
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
    <?php endwhile; ?>

    <?php
    echo paginate_links(array(
        'total'   => $posts_query->max_num_pages,
        'current' => max(1, get_query_var('paged')),
    ));
    ?>
<?php endif; ?>
```

## Display Specific Page Content in PHP with WP_Query

```php
<?php
$args = array(
    'post_type'      => 'page',
    'pagename'       => '', // CHANGE
);

$posts_query = new WP_Query($args);
?>

<?php if ($posts_query->have_posts()) : ?>
    <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
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
    <?php endwhile; ?>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
```

## AJAX to load more posts in WordPress without reloading.

```php
<?php
// Set the post type to be queried
set_query_var('post_type', 'post');

// Set the number of posts to load per request
set_query_var('posts_per_page', 4);

// Include the template for loading more posts via AJAX
get_template_part('core/ajax-load-more');
?>
```

> [!NOTE]\
> After this, create a file in the 'partials' folder named 'loop-{post_type}.php' (replace {post_type} with the actual post type name) and implement the loop to display the posts.
> // Example:

```php
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
```

## AJAX Search Implementation for Posts

```php
<?php
get_template_part('core/ajax-search', null, [
    'post_type' => 'post', // Set the post type to be queried
    'posts_per_page' => 2  // Set the number of posts to load per request
]);
?>
```

## Contact form with name, phone, email, and message fields.

```html
<div class="form-group">
    [text* nome id:form-nome class:form-control placeholder "Nome"]
    <label class="form-label" for="form-nome">Nome</label>
</div>

<div class="form-group">
    [tel* telefone id:form-telefone class:form-control class:form-tel
    placeholder "Telefone"]
    <label class="form-label" for="form-telefone">Telefone</label>
</div>

<div class="form-group">
    [email* email id:form-email class:form-control placeholder "E-mail"]
    <label class="form-label" for="form-email">E-mail</label>
</div>

<div class="form-group">
    [text cpf id:form-cpf class:form-control class:form-cpf placeholder "CPF"]
    <label class="form-label" for="form-cpf">CPF</label>
</div>

<div class="form-group">
    [text cnpj id:form-cnpj class:form-control class:form-cnpj placeholder
    "CNPJ"]
    <label class="form-label" for="form-cnpj">CNPJ</label>
</div>

<div class="form-group">
    [textarea* mensagem id:form-mensagem class:form-control placeholder
    "Mensagem"]
    <label class="form-label" for="form-mensagem">Mensagem</label>
</div>

<div class="form-group">
    [text cep id:form-cep class:form-control class:form-cep placeholder "CEP"]
    <label class="form-label" for="form-cep">CEP</label>
</div>

<div class="form-group">
    [text endereco id:form-endereco class:form-control placeholder "Endereço"]
    <label class="form-label" for="form-endereco">Endereço</label>
</div>

<div class="form-group">
    [text numero id:form-numero class:form-control placeholder "Número"]
    <label class="form-label" for="form-numero">Número</label>
</div>

<div class="form-group">
    [text complemento id:form-complemento class:form-control placeholder
    "Complemento"]
    <label class="form-label" for="form-complemento">Complemento</label>
</div>

<div class="form-group">
    [text bairro id:form-bairro class:form-control placeholder "Bairro"]
    <label class="form-label" for="form-bairro">Bairro</label>
</div>

<div class="form-group">
    [text cidade id:form-cidade class:form-control placeholder "Cidade"]
    <label class="form-label" for="form-cidade">Cidade</label>
</div>

<div class="form-group">
    [text estado id:form-estado class:form-control placeholder "Estado"]
    <label class="form-label" for="form-estado">Estado</label>
</div>

<div class="form-group">[submit class:btn "Enviar"]</div>
```

## Contact Form 7 Select Field for Brazilian States

```html
<div class="form-group">
    [select estado id:form-select-estado class:form-select first_as_label
    "Selecione o Estado" "Acre" "Alagoas" "Amazonas" "Amapá" "Bahia" "Ceará"
    "Distrito Federal" "Espírito Santo" "Goiás" "Maranhão" "Mato Grosso" "Mato
    Grosso do Sul" "Minas Gerais" "Pará" "Paraíba" "Paraná" "Pernambuco" "Piauí"
    "Rio de Janeiro" "Rio Grande do Norte" "Rondônia" "Rio Grande do Sul"
    "Roraima" "Santa Catarina" "Sergipe" "São Paulo" "Tocantins"]
    <label class="form-label" for="form-select-estado">Estado</label>
</div>

<div class="form-group">
    [select cidade id:form-select-cidade class:form-select first_as_label
    "Selecione a Cidade"]
    <label class="form-label" for="form-select-cidade">Cidade</label>
</div>
```

## Contact Form 7 Body Message

```php
Nome: [nome]
Telefone: [telefone]
E-mail: [email]
CPF: [cpf]
CNPJ: [cnpj]
Mensagem: [mensagem]
CEP: [cep]
Endereço: [endereco]
Número: [numero]
Complemento: [complemento]
Bairro: [bairro]
Cidade: [cidade]
Estado: [estado]
```

## Generate dynamic WhatsApp link with sanitized number

```php
<?php
$whatsapp = get_field('whatsapp', 'option');
$linkWhatsapp = preg_replace('/\D/', '', $whatsapp);
?>

<?php if ($whatsapp) : ?>
    <a href="https://wa.me/+55<?php echo $linkWhatsapp ?>" class="" target="_blank">
        <?php echo $whatsapp; ?>
    </a>
<?php endif; ?>
```

## Dynamic Image Gallery with Fancybox Integration and Unique Gallery ID

```php
<?php
$gallery_id = 'gallery-' . uniqid();
$images = get_field('gallery', 'option');
?>

<?php if ($images): ?>
    <ul>
        <?php foreach ($images as $image): ?>
            <li>
                <a data-src="<?php echo esc_url($image['url']); ?>" data-fancybox="gallery-<?php echo $gallery_id; ?>" data-caption="<?php echo esc_attr($image['alt']); ?>">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy" />
                    <p><?php echo esc_html($image['caption']); ?></p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
```

## Dynamic Repeater Field Rendering with Optional Title, Description, and Image

```php
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
```

## License & Attribution

MIT © [Kleyton Caires](https://linkedin.com/in/kleytoncaires).

This project is inspired by the work of many awesome developers especially those who contribute to this project, Gulp.js, Babel, and many other dependencies as listed in the `package.json` file. FOSS (Free & Open Source Software) for the win.
