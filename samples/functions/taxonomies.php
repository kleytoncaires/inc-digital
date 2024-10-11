<?php

// -----------
// REGISTER TAXONOMIES
// -----------
add_action('init', function () {

    // 1. Basic Example: Default hierarchical taxonomy
    dynamic_register_taxonomy(
        'genero',
        'livro'
    );

    // 2. Custom Non-hierarchical Taxonomy (like Tags)
    dynamic_register_taxonomy(
        'tags_personalizadas',
        'filme',
        array('hierarchical' => false)
    );

    // 3. Custom Taxonomy with Custom Rewrite
    dynamic_register_taxonomy(
        'categoria_especial',
        'evento',
        array('rewrite' => array('slug' => 'categorias-especiais'))
    );

    // 4. Taxonomy for Multiple Post Types
    dynamic_register_taxonomy(
        'pais',
        array('livro', 'filme', 'evento')
    );

    // 5. Complex Example: Custom Labels and Arguments
    dynamic_register_taxonomy(
        'faixa_etaria',
        'produto',
        array(
            'labels' => array(
                'name' => 'Faixas Etárias',
                'singular_name' => 'Faixa Etária',
                'menu_name' => 'Faixas Etárias',
                'all_items' => 'Todas as Faixas Etárias',
                'edit_item' => 'Editar Faixa Etária',
                'view_item' => 'Ver Faixa Etária',
                'update_item' => 'Atualizar Faixa Etária',
                'add_new_item' => 'Adicionar Nova Faixa Etária',
                'new_item_name' => 'Nome da Nova Faixa Etária',
                'search_items' => 'Buscar Faixas Etárias',
                'not_found' => 'Nenhuma Faixa Etária Encontrada'
            ),
            'public' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'faixa-etaria', 'with_front' => false)
        )
    );

    // 6. Private Taxonomy Example
    dynamic_register_taxonomy(
        'privada',
        'relatorio',
        array(
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_admin_column' => false,
            'show_in_rest' => false
        )
    );
});
