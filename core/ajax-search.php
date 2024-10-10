<?php
$post_type = $args['post_type'] ?? 'post';
$posts_per_page = $args['posts_per_page'] ?? 5;
?>

<input type="text" class="search-input" data-post-type="<?php echo esc_attr($post_type); ?>" data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>" placeholder="Buscar...">
<div class="results"></div>

<script>
    jQuery(document).ready(function($) {
        $('.search-input').on('input', function() {
            let query = $(this).val();
            let postType = $(this).data('post-type');
            let postsPerPage = $(this).data('posts-per-page');

            if (query.length > 2) {
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php') ?>',
                    type: 'POST',
                    data: {
                        action: 'search_posts',
                        query: query,
                        post_type: postType,
                        posts_per_page: postsPerPage
                    },
                    success: function(response) {
                        $(this).next('.results').html(response);
                    }.bind(this)
                });
            } else {
                $(this).next('.results').html('');
            }
        });
    });
</script>