# Useful WordPress Functions

This is a list of useful WordPress functions that I often reference to enhance or clean up my sites. Please be careful and make backups.

-   [Post Thumbnail With Lazy Loading](#post-thumbnail-with-lazy-loading)
-   [Gallery Display from ACF Field in PHP](#gallery-display-from-acf-field-in-php)
-   [Repeater Field Display from ACF in PHP](#repeater-field-display-from-acf-in-php)
-   [Post List and Pagination in PHP with WP_Query](#post-list-and-pagination-in-php-with-wp_query)
-   [Display Specific Page Content in PHP with WP_Query](#display-specific-page-content-in-php-with-wp_query)
-   [AJAX to Load More Posts in WordPress Without Reloading](#ajax-to-load-more-posts-in-wordpress-without-reloading)
-   [Phone and ZIP Code Masks with Autocomplete in jQuery](#phone-and-zip-code-masks-with-autocomplete-in-jquery)
-   [Contact Form with Name, Phone, Email, and Message Fields](#contact-form-with-name-phone-email-and-message-fields)
-   [jQuery Code for Appending Labels to CPT UI Plugin Menu Items](#jquery-code-for-adding-labels-to-cpt-ui-plugin-menu-items)
-   [jQuery Code for Appending Labels to Taxonomy Fields in CPT UI Plugin](#jquery-code-for-adding-labels-to-taxonomy-fields-in-cpt-ui-plugin)
-   [Change More Excerpt](#change-more-excerpt)
-   [Contact Form 7 Select Field for Brazilian States](#contact-form-7-select-field-for-brazilian-states)

## Post Thumbnail With Lazy Loading

```php
/**
 * Post Thumbnail With Lazy Loading
 */

<?php
$image_args = array(
    'class' => 'img-fluid',
    'loading' => 'lazy',
);

the_post_thumbnail('full', $image_args);
?>
```

## Gallery Display from ACF Field in PHP

Make sure to remove the `<title>` tag from your header.

```php
<?php
$images = get_field('galeria');

if( $images ): ?>
    <ul>
        <?php foreach( $images as $image ): ?>
            <li>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy" />
                <p><?php echo esc_html($image['caption']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
```

## Repeater Field Display from ACF in PHP

```php
<?php
$rows = get_field('repetidor');

if( $rows ): ?>
    <ul>
        <?php foreach( $rows as $row ):
            $titulo = isset($row['titulo']) ? $row['titulo'] : '';
            $descricao = isset($row['descricao']) ? $row['descricao'] : '';
            $imagem = isset($row['imagem']) ? $row['imagem'] : '';
        ?>
            <li>
                <?php if( $titulo ): ?>
                    <h3><?php echo esc_html($titulo); ?></h3>
                <?php endif; ?>

                <?php if( $descricao ): ?>
                    <p><?php echo esc_html($descricao); ?></p>
                <?php endif; ?>

                <?php if( $imagem ): ?>
                    <img src="<?php echo esc_url($imagem['url']); ?>" alt="<?php echo esc_attr($imagem['alt']); ?>" loading="lazy">
                <?php endif; ?>
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
        <h2 class=""><?php the_title(); ?></h2>
        <div class="remove-last-margin"><?php the_content(); ?></div>
        <?php if (has_post_thumbnail()) : ?>
            <?php
            $image_args = array(
                'class' => 'img-fluid',
                'loading' => 'lazy',
            );

            the_post_thumbnail('full', $image_args);
            ?>
        <?php endif; ?>
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
        <h2 class=""><?php the_title(); ?></h2>
        <div class="remove-last-margin"><?php the_content(); ?></div>
        <?php if (has_post_thumbnail()) : ?>
            <?php
            $image_args = array(
                'class' => 'img-fluid',
                'loading' => 'lazy',
            );

            the_post_thumbnail('full', $image_args);
            ?>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
```

## AJAX to load more posts in WordPress without reloading.

```php
<div id="post-container">
    <!-- Posts will be loaded here -->
</div>
<button id="load-more">Load More</button>

<script>
    jQuery(document).ready(function($) {
        let page = 1;

        function loadPosts() {
            $.ajax({
                url: ajaxurl, // AJAX URL
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: page,
                },
                beforeSend: function() {
                    $('#load-more').text('Loading...'); // Change button text
                },
                success: function(response) {
                    if (response) {
                        $('#post-container').append(response); // Append loaded posts
                        page++; // Increment the page
                        $('#load-more').text('Load More'); // Restore button text
                    } else {
                        $('#load-more').hide(); // Hide button if no more posts
                    }
                }
            });
        }

        $('#load-more').on('click', function() {
            loadPosts(); // Load posts on button click
        });
    });
</script>

<?php
// Place the following PHP code in your theme's functions.php file
function load_more_posts() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $args = array(
        'post_type' => 'post',
        'paged' => $paged,
        'posts_per_page' => 5, // Number of posts to load
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Customize the post output here:
            ?>
            <div class="post-item">
                <h2><?php the_title(); ?></h2>
                <div><?php the_excerpt(); ?></div>
            </div>
            <?php
        }
    } else {
        wp_send_json_error('No more posts'); // Send error if no posts found
    }

    wp_reset_postdata();
    die();
}

add_action('wp_ajax_load_more_posts', 'load_more_posts'); // For logged-in users
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts'); // For non-logged-in users
?>

```

## Contact form with name, phone, email, and message fields.

```php
<div class="form-group">
    <label class="form-label" for="nome">Nome</label>
    [text* nome id:nome class:form-control placeholder "Nome"]
</div>

<div class="form-group">
    <label class="form-label" for="telefone">Telefone</label>
    [tel* telefone id:telefone class:form-control class:form-tel placeholder "Telefone"]
</div>

<div class="form-group">
    <label class="form-label" for="email">E-mail</label>
    [email* email id:email class:form-control placeholder "E-mail"]
</div>

<div class="form-group">
    <label class="form-label" for="mensagem">Mensagem</label>
    [textarea* mensagem id:mensagem class:form-control placeholder "Mensagem"]
</div>

<div class="form-group">
    [submit class:btn "Enviar"]
</div>
```

## Contact Form 7 Select Field for Brazilian States

```php
[select Estado class:form-control first_as_label "Selecione o Estado" "Acre" "Alagoas" "Amazonas" "Amapá" "Bahia" "Ceará" "Distrito Federal" "Espírito Santo" "Goiás" "Maranhão" "Mato Grosso" "Mato Grosso do Sul" "Minas Gerais" "Pará" "Paraíba" "Paraná" "Pernambuco" "Piauí" "Rio de Janeiro" "Rio Grande do Norte" "Rondônia" "Rio Grande do Sul" "Roraima" "Santa Catarina" "Sergipe" "São Paulo" "Tocantins"]
```

## jQuery Code for Appending Labels to CPT UI Plugin Menu Items

```javascript
jQuery('#menu_name').val(jQuery('#menu_name').val() + 'X')
jQuery('#all_items').val(jQuery('#all_items').val() + 'Todos os itens')
jQuery('#add_new').val(jQuery('#add_new').val() + 'Adicionar novo')
jQuery('#add_new_item').val(
    jQuery('#add_new_item').val() + 'Adicionar novo item'
)
jQuery('#edit_item').val(jQuery('#edit_item').val() + 'Editar item')
jQuery('#new_item').val(jQuery('#new_item').val() + 'Novo item')
jQuery('#view_item').val(jQuery('#view_item').val() + 'Ver item')
jQuery('#view_items').val(jQuery('#view_items').val() + 'Ver itens')
jQuery('#search_items').val(jQuery('#search_items').val() + 'Procurar item')
jQuery('#not_found').val(jQuery('#not_found').val() + 'Nenhum item encontrado')
jQuery('#not_found_in_trash').val(
    jQuery('#not_found_in_trash').val() + 'Nenhum item encontrado na lixeira'
)
jQuery('#parent').val(jQuery('#parent').val() + 'Item ascendente')
jQuery('#featured_image').val(
    jQuery('#featured_image').val() + 'Imagem destacada'
)
jQuery('#set_featured_image').val(
    jQuery('#set_featured_image').val() + 'Definir imagem destacada'
)
jQuery('#remove_featured_image').val(
    jQuery('#remove_featured_image').val() + 'Remover imagem destacada'
)
jQuery('#use_featured_image').val(
    jQuery('#use_featured_image').val() + 'Usar imagem destacada'
)
jQuery('#archives').val(jQuery('#archives').val() + 'Arquivos')
jQuery('#insert_into_item').val(
    jQuery('#insert_into_item').val() + 'Insira neste item'
)
jQuery('#uploaded_to_this_item').val(
    jQuery('#uploaded_to_this_item').val() + 'Enviado para este item'
)
jQuery('#filter_items_list').val(
    jQuery('#filter_items_list').val() + 'Filtrar lista de itens'
)
jQuery('#items_list_navigation').val(
    jQuery('#items_list_navigation').val() + 'Navegação na lista de itens'
)
jQuery('#items_list').val(jQuery('#items_list').val() + 'Lista de itens')
jQuery('#attributes').val(jQuery('#attributes').val() + 'Atributos')
jQuery('#name_admin_bar').val(jQuery('#name_admin_bar').val() + 'X')
jQuery('#item_published').val(
    jQuery('#item_published').val() + 'Item publicado'
)
jQuery('#item_published_privately').val(
    jQuery('#item_published_privately').val() + 'Item publicado em particular'
)
jQuery('#item_reverted_to_draft').val(
    jQuery('#item_reverted_to_draft').val() + 'Item revertido para rascunho'
)
jQuery('#item_scheduled').val(jQuery('#item_scheduled').val() + 'Item agendado')
jQuery('#item_updated').val(jQuery('#item_updated').val() + 'Item atualizado')
```

## jQuery Code for Appending Labels to Taxonomy Fields in CPT UI Plugin

```javascript
jQuery('#menu_name').val(jQuery('#menu_name').val() + 'X')
jQuery('#all_items').val(jQuery('#all_items').val() + 'Todos os itens')
jQuery('#edit_item').val(jQuery('#edit_item').val() + 'Editar item')
jQuery('#view_item').val(jQuery('#view_item').val() + 'Ver item')
jQuery('#update_item').val(jQuery('#update_item').val() + 'Atualizar item')
jQuery('#add_new_item').val(
    jQuery('#add_new_item').val() + 'Adicionar novo item'
)
jQuery('#new_item_name').val(jQuery('#new_item_name').val() + 'Novo item')
jQuery('#parent_item').val(jQuery('#parent_item').val() + 'Item ascendente')
jQuery('#parent_item_colon').val(
    jQuery('#parent_item_colon').val() + 'Item ascendente:'
)
jQuery('#search_items').val(jQuery('#search_items').val() + 'Pesquisar item')
jQuery('#popular_items').val(jQuery('#popular_items').val() + 'Itens populares')
jQuery('#separate_items_with_commas').val(
    jQuery('#separate_items_with_commas').val() + 'Separar itens com vírgulas'
)
jQuery('#add_or_remove_items').val(
    jQuery('#add_or_remove_items').val() + 'Adicionar ou excluir itens'
)
jQuery('#choose_from_most_used').val(
    jQuery('#choose_from_most_used').val() + 'Escolher entre os mais usados'
)
jQuery('#not_found').val(jQuery('#not_found').val() + 'Nenhum item encontrado')
jQuery('#no_terms').val(jQuery('#no_terms').val() + 'Nenhum item')
jQuery('#items_list_navigation').val(
    jQuery('#items_list_navigation').val() + 'Navegação da lista de itens'
)
jQuery('#items_list').val(jQuery('#items_list').val() + 'Lista de itens')
```

## License & Attribution

MIT © [Kleyton Caires](https://linkedin.com/in/kleytoncaires).

This project is inspired by the work of many awesome developers especially those who contribute to this project, Gulp.js, Babel, and many other dependencies as listed in the `package.json` file. FOSS (Free & Open Source Software) for the win.
