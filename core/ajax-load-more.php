<?php
$post_type = get_query_var('post_type', 'post'); // Default value 'post'
$posts_per_page = get_query_var('posts_per_page', 4); // Default value 4
$unique_id = uniqid($post_type . '-'); // Generate a unique identifier based on post type

$args = array(
    'post_type'      => $post_type,
    'post_status'    => 'publish', // Only show published posts
    'posts_per_page' => $posts_per_page,
    'orderby'        => 'post_date', // Order posts by date
    'order'          => 'desc', // Show latest posts first
    'paged'          => 1, // Pages start at 1
);

$posts_query = new WP_Query($args); // Execute the query to get posts

if ($posts_query->have_posts()) : ?>
    <div id="post-container-<?php echo esc_attr($unique_id); ?>">
        <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
            <?php get_template_part('partials/loop', $post_type); ?>
        <?php endwhile; ?>
    </div>

    <button id="load-more-<?php echo esc_attr($unique_id); ?>">Load More</button>

    <script>
        jQuery(document).ready(function($) {
            let page = 2; // Already displayed the first page
            let postType = '<?php echo esc_js($post_type); ?>';
            let postsPerPage = <?php echo esc_js($posts_per_page); ?>; // Receives the value of posts_per_page

            // Function to load more posts via AJAX
            function loadPosts() {
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php') ?>',
                    type: 'POST',
                    data: {
                        action: 'load_more_posts', // Action for AJAX to hook into
                        page: page,
                        post_type: postType,
                        posts_per_page: postsPerPage, // Sends posts_per_page dynamically
                    },
                    beforeSend: function() {
                        $('#load-more-<?php echo esc_js($unique_id); ?>').text('Loading...'); // Update button text while loading
                    },
                    success: function(response) {
                        if (response) {
                            $('#post-container-<?php echo esc_js($unique_id); ?>').append(response); // Append new posts to the container
                            page++; // Increment page number
                            $('#load-more-<?php echo esc_js($unique_id); ?>').text('Load More'); // Reset button text
                        } else {
                            $('#load-more-<?php echo esc_js($unique_id); ?>').hide(); // Hide button if no more posts
                        }
                    }
                });
            }

            $('#load-more-<?php echo esc_js($unique_id); ?>').on('click', function() {
                loadPosts(); // Trigger loadPosts function on button click
            });
        });
    </script>
<?php endif;
wp_reset_postdata(); ?>