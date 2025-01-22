<?php
/*This file is part of AvadaChild, Avada child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {
	function AvadaChild_enqueue_child_styles() {
	    // loading parent style
	    wp_register_style(
	      'parente2-style',
	      get_template_directory_uri() . '/style.css'
	    );

	    wp_enqueue_style( 'parente2-style' );
	    // loading child style
	    wp_register_style(
	      'childe2-style',
	      get_stylesheet_directory_uri() . '/style.css'
	    );
	    wp_enqueue_style( 'childe2-style');
	 }
}
add_action( 'wp_enqueue_scripts', 'AvadaChild_enqueue_child_styles' );

/*Write here your own functions */

/**
 * Enqueue child theme scripts and styles.
 *
 * @return void
 */
function cln_child_theme_enqueue_scripts() {

    // Enqueue Font Awesome.
    wp_enqueue_style(
        'cln-font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
        array(),
        rand(1000, 9999),
        //wp_get_theme()->get( 'Version' ),
    );

    // Enqueue the child theme's stylesheet.
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        array(),
        rand(1000, 9999),
        //wp_get_theme()->get( 'Version' )
    );

    // Enqueue the child theme's JavaScript file.
    wp_enqueue_script(
        'child-custom-script',
        get_stylesheet_directory_uri() . '/assets/js/script.min.js',
        array( 'jquery' ),
        rand(1000, 9999),
        //wp_get_theme()->get( 'Version' ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'cln_child_theme_enqueue_scripts' );


if ( ! function_exists( 'avada_main_menu' ) ) {
	/**
	 * The main menu.
	 *
	 * @param bool $flyout_menu Whether we want the flyout menu or not.
	 */
	function avada_main_menu( $flyout_menu = false ) {

        echo '';
        ?>
        <div class="menu-container">
            <button class="menu-button" aria-expanded="false" aria-controls="site-header-menu" aria-label="<?php esc_attr_e( 'Menu', 'textdomain' ); ?>"></button>
            <div id="site-header-menu" class="site-header-menu">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'       => 'main_navigation',
                        'container'            => 'nav',
                        'container_class'      => 'main-navigation',
                        'container_id'         => 'site-navigation',
                        'container_aria_label' => 'Primary Menu',
                    ),
                );
                ?>
            </div>
        </div>
        <?php
		
	}
}

//add_action('wp_nav_menu', 'debug_menu_data', 10, 2);

function debug_menu_data($nav_menu, $args) {
    // Get all menu items for the current menu
    $menu_items = wp_get_nav_menu_items($args->menu);

    if ($menu_items) {
        echo '<pre>';
        print_r($menu_items); // Output raw menu data
        echo '</pre>';
    }

    return $nav_menu; // Return the menu as it is
}

/**
 * Adds the Fusion Mega Menu Icon inside the <a> tag of menu items.
 *
 * This function retrieves the Fusion Mega Menu Icon metadata for a menu item
 * and prepends the corresponding icon HTML inside the `<a>` tag.
 *
 * @param string   $item_output The HTML output of the menu item.
 * @param WP_Post  $item        The current menu item object.
 * @param int      $depth       Depth of the menu item. Used for nested menus.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 *
 * @return string The modified menu item output with the icon HTML prepended inside the <a> tag.
 */
function cln_add_fusion_megamenu_icon($item_output, $item, $depth, $args) {
    // Retrieve the Fusion Mega Menu Icon metadata
    $icon = isset($item->fusion_megamenu_icon) ? $item->fusion_megamenu_icon : null;

    if (!empty($icon)) {
        // Extract the <a> tag from the $item_output
        if (preg_match('/(<a.*?>)(.*?)(<\/a>)/i', $item_output, $matches)) {
            $icon_html = '<span class="fusion-megamenu-icon" aria-hidden="true"><i class="' . esc_attr($icon) . '"></i></span>';
            // Reconstruct the <a> tag with the icon inside
            $item_output = $matches[1] . $icon_html . $matches[2] . $matches[3];
        }
    }

    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'cln_add_fusion_megamenu_icon', 10, 4);
