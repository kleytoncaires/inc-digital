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