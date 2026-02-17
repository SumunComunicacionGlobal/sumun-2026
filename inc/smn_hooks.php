<?php

// Agrega un filtro para el bloque de consulta de WordPress
// que muestra los posts relacionados en la página de un post y los filtra por categorías
add_filter('render_block_data', function ($parsed_block) {
    if (
        is_single() &&
        isset($parsed_block['blockName']) &&
        $parsed_block['blockName'] === 'core/query' &&
        isset($parsed_block['attrs']['className']) &&
        strpos($parsed_block['attrs']['className'], 'is-style-is-related-posts') !== false
    ) {
        $category_ids = wp_get_post_categories(get_the_ID());

        if (!empty($category_ids)) {
            $parsed_block['attrs']['query']['categoryIds'] = $category_ids;
            $parsed_block['attrs']['query']['exclude'] = [get_the_ID()];
            $parsed_block['attrs']['query']['sticky'] = '';
            $parsed_block['attrs']['query']['perPage'] = 6;
        }
    }

    return $parsed_block;
});

add_action( 'pre_get_posts', 'smn_pre_get_posts' );
function smn_pre_get_posts($query) {
    if (!$query->is_main_query() || is_admin() ) return;

    if (is_search()) {
        $query->set('posts_per_page', 30);
    } elseif( is_tax( 'portfolio_category') ) {
        $query->set('posts_per_page', 24);
    }
}

function cmplz_show_banner_on_click() {
	?>
	<script>
        function addEvent(event, selector, callback, context) {
            document.addEventListener(event, e => {
                if ( e.target.closest(selector) ) {
                    callback(e);
                }
            });
        }
        addEvent('click', 'a.cmplz-show-banner, .menu-item.cmplz-show-banner > a', function(){
            event.preventDefault();
            document.querySelectorAll('.cmplz-manage-consent').forEach(obj => {
                obj.click();
            });
        });
	</script>
	<?php
}
add_action( 'wp_footer', 'cmplz_show_banner_on_click' );

function smn_get_anchor_menu() {

    if ( ! is_page() ) return false;

    $anchor_menu = get_field('anchor_menu' );
    if ( ! $anchor_menu ) return false;

    $items = array_map('trim', explode(',', $anchor_menu));
    if (empty($items)) return false;

    $output = '<div id="navbarNavDropdown" class="collapse navbar-collapse">';
        $output .= '<ul class="navbar-nav ml-auto anchor-menu">';
        foreach ($items as $item) {
            list($id, $label) = array_map('trim', explode(':', $item, 2));
            if ($id && $label) {
                $id = ltrim($id, '#');
                $output .= sprintf(
                    '<li class="nav-item"><a class="nav-link" href="#%s">%s</a></li>',
                    esc_attr($id),
                    esc_html($label)
                );
            }
        }
        $output .= '</ul>';
    $output .= '</div>';

    return $output;

}