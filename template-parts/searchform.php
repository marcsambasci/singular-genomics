<div class="sd-search-form">
    <form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
        <input type="text" name="s" placeholder="<?php echo esc_html__('Search for answers', 'hello-elementor'); ?>" value="<?php echo esc_html(get_search_query()); ?>" data-rlvlive="true" data-rlvparentel="#rlvlive" data-rlvconfig="default" />
        <input type="hidden" name="post_type" value="support" />
        <div id="rlvlive"></div>
    </form>
</div>