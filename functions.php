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
function add_accessible_menu_script_inline() {
    ?>
	<style>
		@media (min-width: 1301px) {
			/* Rotate the icon when the submenu is toggled open */
			.fusion-main-menu .menu-item-has-children.menu-open .dropdown-toggle i {
				transform: rotate(180deg);
				transition: transform 0.3s ease;
			}

			/* Default icon state */
			.fusion-main-menu .dropdown-toggle i {
				transition: transform 0.3s ease;
			}

			/* Remove background and border from toggle button */
			.fusion-main-menu .dropdown-toggle {
				height: 24px;
				width: 24px;
				background: none;
				border: none;
				padding: 0;
				margin: 0;
				cursor: pointer;
				position: absolute;
				top: 40%;
				right: 10px;
				color: #155d97;
			}

			/* Hide .fusion-caret inside <li><a> */
			.fusion-main-menu li > a .fusion-caret {
				display: none;
			}

			.fusion-main-menu li.menu-item-has-children {
				padding-right: 35px !important;
			}

			header.fusion-is-sticky .fusion-main-menu .dropdown-toggle {
				top: 33%;
			}
		}
	</style>
    function add_accessible_menu_script_inline() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const applyMenuEnhancements = () => {
                const menuItems = document.querySelectorAll('.menu-item-has-children');

                const closeOtherSubmenus = (currentItem) => {
                    menuItems.forEach(item => {
                        if (item !== currentItem) {
                            const button = item.querySelector('.dropdown-toggle');
                            if (button) {
                                button.setAttribute('aria-expanded', 'false');
                            }
                            item.classList.remove('menu-open');
                            item.style.overflow = ''; // Remove inline style
                            const submenu = item.querySelector('.sub-menu');
                            if (submenu) {
                                submenu.style.opacity = '';
                                submenu.style.visibility = ''; // Reset visibility
                            }

                            const submenuLinks = item.querySelectorAll('.sub-menu a');
                            submenuLinks.forEach(link => {
                                link.setAttribute('tabindex', '-1'); // Disable focus
                            });
                        }
                    });
                };

                menuItems.forEach(item => {
                    // Ensure the toggle button is added only to top-level menu items
                    if (!item.parentElement.classList.contains('sub-menu') && !item.dataset.enhanced) {
                        // Mark as enhanced to prevent duplicate toggles
                        item.dataset.enhanced = true;

                        // Create the toggle button
                        const toggleButton = document.createElement('button');
                        toggleButton.classList.add('dropdown-toggle');
                        toggleButton.setAttribute('aria-expanded', 'false');
                        toggleButton.setAttribute('aria-label', `${item.querySelector('a').textContent.trim()}: submenu`);
                        toggleButton.setAttribute('aria-haspopup', 'true');

                        // Add the icon to the toggle button
                        const toggleIcon = document.createElement('i');
                        toggleIcon.classList.add('glyphicon', 'fa-chevron-down', 'fas');
                        toggleIcon.setAttribute('aria-hidden', 'true');
                        toggleButton.appendChild(toggleIcon);

                        // Append the button after the anchor tag
                        const anchor = item.querySelector('a');
                        anchor.after(toggleButton);

                        // Handle toggle button click
                        toggleButton.addEventListener('click', function (event) {
                            event.stopPropagation(); // Prevent bubbling to document click handler
                            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';

                            // Close other submenus
                            closeOtherSubmenus(item);

                            // Toggle the current submenu
                            toggleButton.setAttribute('aria-expanded', !isExpanded);
                            item.classList.toggle('menu-open', !isExpanded);

                            // Apply or remove the inline styles on the parent <li>
                            item.style.overflow = !isExpanded ? 'visible' : '';

                            // Apply visibility and opacity to the submenu
                            const submenu = item.querySelector('.sub-menu');
                            if (submenu) {
                                submenu.style.opacity = !isExpanded ? '1' : '';
                                submenu.style.visibility = !isExpanded ? 'visible' : '';
                            }

                            // Update tabindex for submenu links
                            const submenuLinks = item.querySelectorAll('.sub-menu a');
                            submenuLinks.forEach(link => {
                                link.setAttribute('tabindex', isExpanded ? '-1' : '0');
                            });

                            // Move focus to the first submenu link if expanded
                            if (!isExpanded) {
                                const firstLink = item.querySelector('.sub-menu a');
                                if (firstLink) {
                                    firstLink.focus();
                                }
                            }
                        });

                        // Initialize submenu links to be unfocusable
                        const submenuLinks = item.querySelectorAll('.sub-menu a');
                        submenuLinks.forEach(link => {
                            link.setAttribute('tabindex', '-1');
                        });

                        // Handle focus on parent menu item to close others
                        item.addEventListener('focusin', function () {
                            closeOtherSubmenus(item);
                        });
                    }
                });

                // Close all submenus when clicking outside the menu
                document.addEventListener('click', function () {
                    closeOtherSubmenus(null);
                });

                // Close submenu on pressing the "Escape" key
                menuItems.forEach(item => {
                    item.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape') {
                            const button = item.querySelector('.dropdown-toggle');
                            if (button && button.getAttribute('aria-expanded') === 'true') {
                                button.setAttribute('aria-expanded', 'false');
                                item.classList.remove('menu-open');
                                item.style.overflow = ''; // Remove the inline style

                                // Reset visibility and opacity for submenu
                                const submenu = item.querySelector('.sub-menu');
                                if (submenu) {
                                    submenu.style.opacity = '';
                                    submenu.style.visibility = '';
                                }

                                // Reset tabindex for submenu links
                                const submenuLinks = item.querySelectorAll('.sub-menu a');
                                submenuLinks.forEach(link => {
                                    link.setAttribute('tabindex', '-1');
                                });

                                // Return focus to the toggle button
                                button.focus();
                            }
                        }
                    });
                });
            };

            // Match media query for viewport width > 1300px
            const mediaQuery = window.matchMedia('(min-width: 1301px)');

            // Function to handle media query changes
            const handleMediaChange = (e) => {
                if (e.matches) {
                    applyMenuEnhancements();
                } else {
                    // Clean up enhancements if viewport width is <= 1300px
                    const enhancedItems = document.querySelectorAll('.menu-item-has-children[data-enhanced="true"]');
                    enhancedItems.forEach(item => {
                        const button = item.querySelector('.dropdown-toggle');
                        if (button) {
                            button.remove();
                        }
                        item.removeAttribute('data-enhanced');
                        item.style.overflow = '';
                        item.classList.remove('menu-open');

                        const submenu = item.querySelector('.sub-menu');
                        if (submenu) {
                            submenu.style.opacity = '';
                            submenu.style.visibility = '';
                        }

                        const submenuLinks = item.querySelectorAll('.sub-menu a');
                        submenuLinks.forEach(link => {
                            link.setAttribute('tabindex', '0'); // Allow focus
                        });
                    });
                }
            };

            // Initial check
            handleMediaChange(mediaQuery);

            // Listen for changes in the viewport width
            mediaQuery.addEventListener('change', handleMediaChange);
        });
    </script>
    <?php
}
add_action('wp_footer', 'add_accessible_menu_script_inline');