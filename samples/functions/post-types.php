<?php

// -----------
// REGISTER POST TYPES
// -----------
function register_post_types()
{
    // 1. Basic Example: Default supports and icon
    dynamic_post_type(
        'Livro',
        'Livros',
        'livro'
    );

    // 2. Custom Supports and Icon
    dynamic_post_type(
        'Filme',
        'Filmes',
        'filme',
        array('title', 'editor', 'thumbnail', 'comments'),
        'dashicons-video-alt3'
    );

    // 3. Custom Arguments Example
    dynamic_post_type(
        'Evento',
        'Eventos',
        'evento',
        array('title', 'editor', 'thumbnail'),
        'dashicons-calendar-alt',
        array(
            'exclude_from_search' => true,
            'show_in_nav_menus' => false
        )
    );

    // 4. Complex Example: Fully customized
    dynamic_post_type(
        'Produto',
        'Produtos',
        'produto',
        array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions'),
        'dashicons-cart',
        array(
            'public' => false,
            'has_archive' => false,
            'exclude_from_search' => true,
            'show_in_nav_menus' => true,
            'menu_position' => 5,
            'capability_type' => 'post',
            'hierarchical' => true
        )
    );

    // 5. Private Post Type
    dynamic_post_type(
        'Relatório',
        'Relatórios',
        'relatorio',
        array('title', 'editor', 'custom-fields'),
        'dashicons-chart-line',
        array(
            'public' => false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'show_in_menu' => true,
            'menu_position' => 25
        )
    );

    // 6. Custom Post Type with Archive and Rewrite
    dynamic_post_type(
        'Curso',
        'Cursos',
        'curso',
        array('title', 'editor', 'thumbnail', 'excerpt'),
        'dashicons-welcome-learn-more',
        array(
            'has_archive' => true,
            'rewrite' => array('slug' => 'cursos', 'with_front' => false),
            'public' => true,
            'show_in_rest' => true
        )
    );

    // 7. Hierarchical Post Type
    dynamic_post_type(
        'Página Personalizada',
        'Páginas Personalizadas',
        'pagina-personalizada',
        array('title', 'editor', 'page-attributes'),
        'dashicons-admin-page',
        array(
            'hierarchical' => true,
            'public' => true,
            'show_in_rest' => true
        )
    );

    // 8. Custom Post Type with Taxonomies
    dynamic_post_type(
        'Notícia',
        'Notícias',
        'noticia',
        array('title', 'editor', 'thumbnail', 'excerpt'),
        'dashicons-megaphone',
        array(
            'taxonomies' => array('category', 'post_tag'),
            'public' => true
        )
    );
}

add_action('init', 'register_post_types');
