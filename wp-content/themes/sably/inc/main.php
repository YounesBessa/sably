<?php

/**
 * sably functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sably
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('sably_setup')) :

	function sably_setup()
	{
		load_theme_textdomain('sably', get_template_directory() . '/languages');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'sably'),
			)
		);
		add_theme_support('customize-selective-refresh-widgets');
	}
endif;
add_action('after_setup_theme', 'sably_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sably_content_width()
{
	$GLOBALS['content_width'] = apply_filters('sably_content_width', 640);
}
add_action('after_setup_theme', 'sably_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sably_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'sably'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'sably'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'sably_widgets_init');

//Custom redirect on logout
function redirect_to_custom_login_page()
{
	wp_redirect(site_url());
	exit();
}
add_action('wp_logout', 'redirect_to_custom_login_page');
/**
 * Enqueue scripts and styles.
 */
function sably_scripts()
{

	//Include custom Jquery
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.5.1.min.js', array(), null, true);

	//font awesome
	wp_enqueue_script('fontAwesome-js', 'https://kit.fontawesome.com/ceee3d5b7f.js', array(), null, true);

	//Magnific popup
	wp_enqueue_script('magnific-popup-js', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.js', array(), null, true);
	wp_enqueue_style('magnific-popup-style', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '');

	//Micromodal
	wp_enqueue_script('micromodal-js', get_template_directory_uri() . '/assets/js/micromodal.min.js', array(), null, true);
	wp_enqueue_style('micromodal-style', get_template_directory_uri() . '/assets/css/micromodal-style.css', array(), '');

	//Main js
	wp_enqueue_script('mainJs', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);
	//AJAX
	wp_localize_script('mainJs', 'ajaxurl', admin_url('admin-ajax.php'));

	wp_enqueue_style('sably-style-2', get_template_directory_uri() . '/assets/css/style.css', array(), '');
	wp_enqueue_style('sably-style', get_stylesheet_uri(), array(), _S_VERSION);
}
add_action('wp_enqueue_scripts', 'sably_scripts');




//// CUSTOM ADMIN ////


/**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page()
{
	add_menu_page(
		__('Custom Menu Title', 'textdomain'),
		'Contact',
		'manage_options',
		'custompage',
		'my_custom_menu_page',
		'images/marker.png',
		6
	);
}
add_action('admin_menu', 'wpdocs_register_my_custom_menu_page');

/**
 * Display a custom menu page
 */
function my_custom_menu_page()
{
	esc_html_e('Admin Page Test', 'textdomain');
	$email = 'basile@gmail.com';
	global $wpdb;
	$wpdb_prefix = $wpdb->prefix;
	$wpdb_tablename = $wpdb_prefix . 'contact';
	$sql = "SELECT * FROM $wpdb_tablename";
	$users = $wpdb->get_results($sql);
?>
	<table class="tablemain">
				<thead>
					<tr>
						<th class="cellulemain">Nom</th>
						<th class="cellulemain">Prénom</th>
						<th class="cellulemain">Email</th>
						<th class="cellulemain">Sujet</th>
						<th class="cellulemain">Message</th>
					</tr>
				</thead>

		<tbody>
				<?php foreach ($users as $user) { ?>
			<tr>
				<td class="cellulemain"><?= $user->lastname ?></td>
				<td class="cellulemain"><?= $user->firstname ?></td>
				<td class="cellulemain"><?= $user->email ?></td>
				<td class="cellulemain"><?= $user->subject ?></td>
				<td class="cellulemain"><?= $user->message ?></td>
			</tr>
		</tbody><?php }
		?>
			</table>
		<?php
}
