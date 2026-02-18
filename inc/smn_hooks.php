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

function smn_get_anchor_menu_items() {

    $anchor_menu = get_field('anchor_menu' );
    if ( ! $anchor_menu ) return false;

    $items = array_map('trim', explode(',', $anchor_menu));
    if (empty($items)) return false;

    $output = '';

    foreach ($items as $item) {
        list($id, $label) = array_map('trim', explode(':', $item, 2));
        if ($id && $label) {
            $id = ltrim($id, '#');
            $output .= sprintf(
            '<li class="wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content" href="#%s"><span class="wp-block-navigation-item__label">%s</span></a></li>',
                esc_attr($id),
                esc_html($label)
            );
        }
    }

    return $output;

}

add_filter( 'render_block_core/navigation', 'wpdocs_modify_nav_menu_for_admins', 10, 2 );
function wpdocs_modify_nav_menu_for_admins( $block_content, $block ) {

    if ( isset( $block['blockName'] ) && 'core/navigation' === $block['blockName'] ) {

        $anchor_menu_items = smn_get_anchor_menu_items();
        if ( ! $anchor_menu_items ) return $block_content;

        // Remove all HTML inside <ul class="wp-block-navigation__container">...</ul>
        // Usa una función DOM para reemplazar solo el contenido del ul principal con la clase wp-block-navigation__container
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Suprime warnings por HTML5
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $block_content);

        $xpath = new DOMXPath($dom);
        $ul_nodes = $xpath->query('//ul[contains(concat(" ", normalize-space(@class), " "), " wp-block-navigation__container ")]');

        if ($ul_nodes->length > 0) {
            $ul = $ul_nodes->item(0);

            // Elimina todos los hijos actuales del ul
            while ($ul->firstChild) {
            $ul->removeChild($ul->firstChild);
            }

            // Crea un fragmento con los nuevos items
            $fragment = $dom->createDocumentFragment();
            $fragment->appendXML($anchor_menu_items);
            $ul->appendChild($fragment);

            // Guarda el HTML modificado, quitando el doctype y html/body extra
            $body = $dom->getElementsByTagName('body')->item(0);
            $block_content = '';
            foreach ($body->childNodes as $child) {
            $block_content .= $dom->saveHTML($child);
            }
        }
        libxml_clear_errors();

    }

    return $block_content;
}