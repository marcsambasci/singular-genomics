<?php
$parent_cat_obj = get_queried_object();

if ($parent_cat_obj) {
    $parent_cat_id = $parent_cat_obj->term_id;
    $child_cats = get_terms([
        'taxonomy'   => 'support-category',
        'parent'     => $parent_cat_id,
        'hide_empty' => true,
    ]);

    foreach ($child_cats as $child_cat) {
        $section_id = strtolower(str_replace(' ', '-', $child_cat->name));
        echo '<div class="sd-section-documents-container">
            <h3 class="sd-section-category-title" id="' . $section_id . '">' . esc_html($child_cat->name) . '</h3>';

        $args = [
            'post_type'      => 'support',
            'posts_per_page' => -1,
            'tax_query'      => [
                [
                    'taxonomy' => 'support-category',
                    'field'    => 'term_id',
                    'terms'    => $child_cat->term_id,
                ],
            ],
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            echo '<ul class="sd-section-document-list list-unstyled">';

            while ($query->have_posts()) {
                $query->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }

            echo '</ul>
                <div class="mt-2">
                    <a href="#" class="toggleButton">Show more</a>
                </div>
            </div>';

            echo '<div class="sep-line my-4"></div>';
        }

        wp_reset_postdata();
    }
} else {
    echo 'No category found with that slug.';
}
