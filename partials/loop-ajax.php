<?php
$args = array(
    'post_type'      => 'post', // CHANGE
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'post_date',
    'order'          => 'desc',
    'paged'          => $paged,
);

$posts_query = new WP_Query($args);
?>

<?php if ($posts_query->have_posts()) : ?>
    <div id="post-container">
        <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
            <h2 class="">
                <?php the_title(); ?>
            </h2>

            <div class="remove-last-margin">
                <?php the_content(); ?>
            </div>

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
    </div>

    <button id="load-more">Load More</button>

    <script>
        jQuery(document).ready(function($) {
            let page = 1;

            function loadPosts() {
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php') ?>', // AJAX URL
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
<?php endif; ?>