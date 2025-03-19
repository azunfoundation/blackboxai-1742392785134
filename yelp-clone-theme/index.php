<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero-section flex items-center justify-center">
    <div class="container mx-auto px-4 py-16 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-8">Find the Best Local Businesses</h1>
        <div class="max-w-3xl mx-auto">
            <form action="<?php echo esc_url(home_url('/search')); ?>" method="get" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="find" placeholder="restaurants, bars, spa, etc." 
                           class="w-full px-6 py-4 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div class="flex-1">
                    <input type="text" name="location" placeholder="Location" 
                           class="w-full px-6 py-4 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <button type="submit" class="bg-red-600 text-white px-8 py-4 rounded-lg text-lg hover:bg-red-700 transition duration-300">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Popular Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php
            $categories = get_terms([
                'taxonomy' => 'business_category',
                'hide_empty' => false,
                'number' => 8
            ]);

            if (!empty($categories) && !is_wp_error($categories)) :
                foreach ($categories as $category) : ?>
                    <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                       class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition duration-300">
                        <i class="fas fa-utensils text-3xl text-red-500 mb-4"></i>
                        <h3 class="text-xl font-semibold"><?php echo esc_html($category->name); ?></h3>
                        <p class="text-gray-600"><?php echo esc_html($category->count); ?> places</p>
                    </a>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- Featured Businesses -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Featured Businesses</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            $args = array(
                'post_type' => 'business',
                'posts_per_page' => 6,
                'meta_query' => array(
                    array(
                        'key' => '_featured',
                        'value' => 'yes',
                        'compare' => '='
                    )
                )
            );

            $featured_query = new WP_Query($args);

            if ($featured_query->have_posts()) :
                while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
                    <div class="business-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="aspect-w-16 aspect-h-9">
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-red-600">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="flex items-center mb-2">
                                <div class="rating-stars mr-2">
                                    <?php
                                    $rating = get_post_meta(get_the_ID(), '_average_rating', true);
                                    $rating = $rating ? $rating : 0;
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <span class="text-gray-600">(<?php echo get_comments_number(); ?> reviews)</span>
                            </div>
                            <p class="text-gray-600 mb-4"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <?php echo esc_html(get_post_meta(get_the_ID(), '_business_address', true)); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
        <div class="text-center mt-12">
            <a href="<?php echo esc_url(home_url('/businesses')); ?>" 
               class="inline-block bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition duration-300">
                View All Businesses
            </a>
        </div>
    </div>
</section>

<!-- Recent Reviews -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Latest Reviews</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php
            $args = array(
                'post_type' => 'review',
                'posts_per_page' => 4
            );

            $reviews_query = new WP_Query($args);

            if ($reviews_query->have_posts()) :
                while ($reviews_query->have_posts()) : $reviews_query->the_post(); ?>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-start mb-4">
                            <?php echo get_avatar(get_the_author_meta('ID'), 60, '', '', ['class' => 'rounded-full']); ?>
                            <div class="ml-4">
                                <h4 class="font-semibold"><?php the_author(); ?></h4>
                                <div class="rating-stars my-1">
                                    <?php
                                    $rating = get_post_meta(get_the_ID(), '_review_rating', true);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <p class="text-gray-500 text-sm"><?php echo get_the_date(); ?></p>
                            </div>
                        </div>
                        <p class="text-gray-700"><?php echo wp_trim_words(get_the_content(), 30); ?></p>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="<?php echo esc_url(get_permalink(get_post_meta(get_the_ID(), '_business_id', true))); ?>" 
                               class="text-red-600 hover:text-red-700 font-medium">
                                <?php echo get_the_title(get_post_meta(get_the_ID(), '_business_id', true)); ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-red-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Own a Business?</h2>
        <p class="text-xl mb-8">List your business on our platform and reach thousands of potential customers.</p>
        <a href="<?php echo esc_url(home_url('/add-business')); ?>" 
           class="inline-block bg-white text-red-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            Add Your Business
        </a>
    </div>
</section>

<?php get_footer(); ?>