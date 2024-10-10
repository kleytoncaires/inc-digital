<?php

// -----------
// DYNAMIC TAXONOMY REGISTRATION
// -----------
function dynamic_register_taxonomy($taxonomy, $post_types, $args = array())
{
    $labels = array(
        'name' => ucfirst($taxonomy) . 's', // Nome plural da taxonomia, capitalizado
        'singular_name' => ucfirst($taxonomy), // Nome singular da taxonomia, capitalizado
        'menu_name' => ucfirst($taxonomy) . 's', // Nome do menu para a taxonomia, capitalizado
        'all_items' => 'Todas as ' . ucfirst($taxonomy) . 's', // Texto para exibir todos os itens na taxonomia
        'edit_item' => 'Editar ' . ucfirst($taxonomy), // Texto para editar um único item na taxonomia
        'view_item' => 'Ver ' . ucfirst($taxonomy), // Texto para visualizar um único item na taxonomia
        'update_item' => 'Atualizar ' . ucfirst($taxonomy), // Texto para atualizar um único item na taxonomia
        'add_new_item' => 'Adicionar nova ' . ucfirst($taxonomy), // Texto para adicionar um novo item na taxonomia
        'new_item_name' => 'Nome da nova ' . ucfirst($taxonomy), // Texto para o nome de um novo item
        'search_items' => 'Buscar ' . ucfirst($taxonomy) . 's', // Texto para buscar itens na taxonomia
        'not_found' => 'Nenhuma ' . ucfirst($taxonomy) . ' encontrada', // Mensagem exibida quando nenhum item é encontrado
    );

    $default_args = array(
        'labels' => $labels, // Custom labels defined earlier
        'public' => true, // Defines if the taxonomy is public and can be displayed in the user interface
        'hierarchical' => true, // Specifies whether the taxonomy behaves like categories (true) or tags (false)
        'rewrite' => array('slug' => $taxonomy), // Sets the URL structure (slug) for this taxonomy
        'show_admin_column' => true, // Displays the taxonomy in the admin column
        'show_in_rest' => true, // Enables support for the WordPress block editor (Gutenberg)
    );

    $args = wp_parse_args($args, $default_args);

    register_taxonomy($taxonomy, (array)$post_types, $args);
}

// -----------
// REGISTER TAXONOMIES
// -----------
add_action('init', function () {

    // PLACE YOUR TAXONOMIES HERE

});
