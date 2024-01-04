<div class="sd-related-articles">
    <h4 class="sd-related-articles-title mt-0 mb-2">Related articles</h4>

    <?php
    // Assuming you're inside the loop and $post is the current post object
    $current_post_id = $post->ID;
    $current_post_subcategories = get_the_terms($post->ID, 'support-category');
    $sub_category_ids = [];

    if ($current_post_subcategories) {
        foreach ($current_post_subcategories as $cat) {
            if ($cat->parent != 0) { // Check if the category is a sub-category
                $sub_category_ids[] = $cat->term_id;
            }
        }

        $args = array(
            'post_type'      => 'support', // Replace with your custom post type
            'posts_per_page' => 5,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'support-category', // Replace with your custom taxonomy if necessary
                    'field'    => 'term_id',
                    'terms'    => $sub_category_ids,
                ),
            ),
            'post__not_in' => array($current_post_id), // Exclude current post
            'orderby'       => 'rand' // Order by random
        );

        $related_posts = new WP_Query($args);

        if ($related_posts->have_posts()) {
            echo '<ul class="sd-related-articles-list list-unstyled">';
            while ($related_posts->have_posts()) {
                $related_posts->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo 'No related posts found';
        }

        wp_reset_postdata();
    }
    ?>

</div>