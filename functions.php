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

    // Enqueue the child theme's stylesheet
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/assets/css/style.css', // Added leading slash
        array(),
        wp_get_theme()->get( 'Version' )
    );

    // Enqueue the child theme's JavaScript file
    wp_enqueue_script(
        'child-custom-script',
        get_stylesheet_directory_uri() . '/assets/js/script.js', // Added leading slash
        array( 'jquery' ),
        wp_get_theme()->get( 'Version' ),
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
                        'theme_location'       => 'primary',
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
