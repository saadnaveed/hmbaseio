<?php

/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

add_filter('filter_entries','add_entry_id' );
function add_entry_id($entries) {
    foreach ($entries as &$entry) {
        $entry["16"] = $entry["id"];
    }
    return $entries;
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Custom shortcode to display form entries in a table.
 *
 * Usage [wpforms_entries_table id="FORMID"]
 *
 * @param array $atts
 */
function wpf_dev_entries_table( $atts ) {
	$atts = shortcode_atts( array(
		'id' => ''
	), $atts );
	if ( empty( $atts['id'] ) || !function_exists( 'wpforms' ) ) {
		return;
	}
	$form = wpforms()->form->get( absint( $atts['id'] ) );
	if ( empty( $form ) ) {
		return;
	}
	$form_data = !empty( $form->post_content ) ? wpforms_decode( $form->post_content ) : '';
	$entries   = wpforms()->entry->get_entries( array( 'form_id' => absint( $atts['id'] ) ) );
	$disallow  = apply_filters( 'wpforms_frontend_entries_table_disallow', array( 'divider', 'html', 'pagebreak', 'captcha' ) );
	$ids       = array();
	ob_start();
	echo '<table class="wpforms-frontend-entries">';
		echo '<thead><tr>';
			foreach( $form_data['fields'] as $field ) {
				if ( !in_array( $field['type'], $disallow ) ) {
					$ids[] = $field['id'];
					echo '<th>' . sanitize_text_field( $field['label'] ) . '</th>';
				}
			}
		echo '</tr></thead>';
		echo '<tbody>';
			foreach( $entries as $entry ) {
				echo '<tr>';
				$fields = wpforms_decode( $entry->fields );
				foreach( $fields as $field ) {
					if ( in_array( $field['id'], $ids ) ) {
						echo '<td>' . apply_filters( 'wpforms_html_field_value', wp_strip_all_tags( $field['value'] ), $field, $form_data, 'entry-frontend-table' );
					}
				}
				echo '</tr>';
			}
		echo '</tbody>';
	echo '</table>';
	$output = ob_get_clean();
	return $output;
}
add_shortcode( 'wpforms_entries_table', 'wpf_dev_entries_table' );

function ar_post_to_slack($message, $channel, $username, $icon_emoji) {

	// Slack webhook endpoint from Slack settings
	$slack_endpoint = "https://hooks.slack.com/services/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";

	// Prepare the data / payload to be posted to Slack
	$data = array(
		'payload'   => json_encode( array(
			"channel"       =>  $channel,
			"text"          =>  $message,
			"username"	=>  $username,
			"icon_emoji"    =>  $icon_emoji
			)
		)
	);
	// Post our data via the slack webhook endpoint using wp_remote_post
	$posting_to_slack = wp_remote_post( $slack_endpoint, array(
		'method' => 'POST',
		'timeout' => 30,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'headers' => array(),
		'body' => $data,
		'cookies' => array(),
		'parse' => 'full',
		'link_names' => true
		)
	);
}

function ar_user_login( $user_login, $user ) {

	// get the user ID
	$user_id = $user->ID;

	// get the user's slack username (this is custom meta)
	$user_slackname = $user->first_name;

	// get the current site url
	$site_url = get_bloginfo('url');

	// prepare a message to be posted to slack
	$message = $user_slackname .' just logged in to '.$site_url;
	//$message = 'hello world!';
	// post the message to slack in the general channel
	ar_post_to_slack($message,'#hmbaseio','CSDashboardBot',':taco:');
}
add_action('wp_login', 'ar_user_login', 99, 2);

add_action('admin_menu', 'test_button_menu');

function test_button_menu(){
  add_menu_page('CS Alerts', 'CS Alerts', 'manage_options', 'test-button-slug', 'test_button_admin_page');

}

function test_button_admin_page() {

  // This function creates the output for the admin page.
  // It also checks the value of the $_POST variable to see whether
  // there has been a form submission.

  // The check_admin_referer is a WordPress function that does some security
  // checking and is recommended good practice.

  // General check for user permissions.
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient pilchards to access this page.')    );
  }

  // Start building the page

  echo '<div class="wrap">';

  echo '<h2>CS Alerts</h2>';

  // Check whether the button has been pressed AND also check the nonce
  if (isset($_POST['test_button']) && check_admin_referer('test_button_clicked')) {
    // the button has been pressed AND we've passed the security check
    test_button_action();
  }

  echo '<form action="options-general.php?page=test-button-slug" method="post">';

  // this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
  wp_nonce_field('test_button_clicked');
  echo '<input type="hidden" value="true" name="test_button" />';
  submit_button('Alert IB Agents on Slack');
  echo '</form>';

  echo '</div>';

}

$agentSlackIDs = array (
							'saad' => 'U9MS7DU65',
							'mariam' => 'invalid',
							'david' => 'U6N5Z6S48',
							'ryan' => 'U8KHGU675',
							'cindy' => 'U9QSJNQ5P',
							'ciara' => 'U6MU2AHQE',
							'alexander' => 'U90F42C5B',
							'chris' => 'U6ZEWR9B9',
							'liza' => 'U0PGVPE1K',
							'rosvy' => 'UA71T4GE5',
							'molly' => 'U7VJ8G3RQ',
							'brandon' => 'UA7EYA49Z',
							'cat' => 'U789XP3QS',
							'doc' => 'U7VKQGB6G',
							'daveen' => 'U9RE7AVD0',
							'kyle' => 'U9WDZQW3X',
							'katarina' => 'U9X5A8R4N',
							'bridgette' => 'U9VPJFM7T',
							'connie' => 'U552KAZ1R',
							'dexter' => 'UA8ELQWKY',
							'daniel' => 'UAKQAED26',
							'missy' => 'UALM57BEJ',
);

/* $agents = array (
							'saad',
							'mariam',
							'david',
							'ryan',
							'cindy',
							'ciara',
							'alexander',
							'chris',
							'liza',
							'rosvy',
							'molly',
							'brandon',
							'cat',
							'doc',
							'daveen',
							'kyle',
							'katarina',
							'bridgette',
							'connie',
							'dexter',
							'daniel',
							'missy',
); */

function startsWith2($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function test_button_action()
{
  $table2 = TablePress::$model_table->load( 4, true, false );

	$totalAgents2 = count($table2['data']);
	$colTimes2 = count($table2['data'][2]);
	$colTimesRowStart2 = $table2['data'][2];

	$date2 = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date2->setTimeZone(new DateTimeZone('America/Chicago'));
$currentHour2 = $date2->format('G');
$lastUpdated2 = $date2->format('g:i a');
$dayOfWeek2 = $date2->format('D');

$tableTimes2 = array (
							'8' => '8a',
							'9' => '9a',
							'10' => '10a',
							'11' => '11a',
							'12' => '12p',
							'13' => '1p',
							'14' => '2p',
							'15' => '3p',
							'16' => '4p',
							'17' => '5p',
							'18' => '6p',
							'19' => '7p',
							'8a' => '8',
							'9a' => '9',
							'10a' => '10',
							'11a' => '11',
							'12p' => '12',
							'1p' => '13',
							'2p' => '14',
							'3p' => '15',
							'4p' => '16',
							'5p' => '17',
							'6p' => '18',
							'7p' => '19',
);

$messagePeeps2 = '';

  for ($i2 = 3; $i2 < $totalAgents2; $i2++) {
		for ($j2 = 0; $j2 < $colTimes2; $j2++) {
			if (startsWith2($table2['data'][$i2][$j2], 'ZD/') && $colTimesRowStart2[$j2] == $tableTimes2[$currentHour2]) {
				$messagePeeps2 .= '<@'.$agentSlackIDs[$table2['data'][$i2][0]].'> ';
			}
		}
	}


  ar_post_to_slack('<!here> '.$messagePeeps2.' IB Team, mobilize! There\'s currently 4+ calls in queue','#hmbaseio','CSDashboardBot',':taco:');
}

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args' );

add_filter( 'auth_cookie_expiration', 'wploop_never_log_out' );

	function wploop_never_log_out( $expirein ) {
	    return 1421150815; // 40+ years shown in seconds
	}


	function wpa_filter_nav_menu_objects( $items ){
    foreach( $items as $key => $item ){
        if( '[MGMT] Escalations' == $item->title && !current_user_can( 'administrator' ) ){
            unset( $items[$key] );
        }
				if( '[MGMT] phpMyAdmin' == $item->title && !current_user_can( 'administrator' ) ){
            unset( $items[$key] );
        }
				if( '[MGMT] Reports' == $item->title && !current_user_can( 'administrator' ) ){
            unset( $items[$key] );
        }

				if( 'MGMT' == $item->title && !current_user_can( 'administrator' ) ){
            unset( $items[$key] );
        }

				if( '[MGMT] Task Hours' == $item->title && !current_user_can( 'administrator' ) ){
            unset( $items[$key] );
        }
				if( '[MGMT] Reports *OLD*' == $item->title && !current_user_can( 'administrator' ) ){
            unset( $items[$key] );
        }
    }
    return $items;
}


add_filter( 'gform_field_value_category', 'populate_category' );
function populate_category( $value, $field, $name ) {
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$parts = parse_url($actual_link);
	parse_str($parts['query'], $query);
	global $category;
	$category = $query['category'];
	return $query['category'];
}

add_filter( 'gform_field_value_subcategory', 'populate_subcategory' );
function populate_subcategory( $value, $field, $name ) {
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$parts = parse_url($actual_link);
	parse_str($parts['query'], $query);
	global $category;
	$category = $query['subcategory'];
	return $query['subcategory'];
}

function returnCategory() {
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$parts = parse_url($actual_link);
	parse_str($parts['query'], $query);
	return $query['category'];
}

function returnSubCategory() {
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$parts = parse_url($actual_link);
	parse_str($parts['query'], $query);
	return $query['subcategory'];
}

add_filter( 'wp_nav_menu_objects', 'wpa_filter_nav_menu_objects' );

add_filter('gform_pre_render', 'populate_movies');

//Note: when changing drop down values, we also need to use the gform_pre_validation so that the new values are available when validating the field.
add_filter( 'gform_pre_validation', 'populate_movies' );

//Note: when changing drop down values, we also need to use the gform_admin_pre_render so that the right values are displayed when editing the entry.
add_filter( 'gform_admin_pre_render', 'populate_movies' );

//Note: this will allow for the labels to be used during the submission process in case values are enabled
add_filter( 'gform_pre_submission_filter', 'populate_movies' );

function populate_movies( $form ) {

    if ( $form['title'] == "Discounts" && $form['title'] == "Billing Requests") return $form;

//print_r($form['fields']);

// form field 4 = feature request category
// form field 5 = feature request subcategory
    foreach ( $form['fields'] as &$field ) {

        if ( $field->type != 'select' || strpos( $field->cssClass, 'movies-dropdown' ) === false ) {
            continue;
        }

        // you can add additional parameters here to alter the posts that are retrieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        //$movie_ids = get_posts('fields=ids&posts_per_page=-1&post_status=publish&post_type=movie&order=asc&orderby=title');

        // update 'Not listed Here' to whatever you'd like the instructive option to be
				global $wpdb;

				$feature_category = returnCategory();
				$feature_subcategory = returnSubCategory();

				$features = $wpdb->get_results( "select id, feature_name from cs_feature_requests where category = '".$feature_category."' AND subcategory = '".$feature_subcategory."' order by feature_name;", ARRAY_N);

        $choices = array(array('text' => 'Not listed Here', 'value' => 'Not listed Here' ));

        for ($i = 0; $i < count($features); $i++) {
            $choices[] = array( 'text' => $features[$i][1], 'value' => $features[$i][1], 'isSelected' => false );
        }

        $field['choices'] = $choices;
    }
    return $form;
}

/* Timesheets: Tips */
add_action( 'gform_after_submission_104', 'access_entry_via_field', 10, 2 );
function access_entry_via_field( $entry, $form ) {
    foreach ( $form['fields'] as $field ) {
        $inputs = $field->get_entry_inputs();
        if ( is_array( $inputs ) ) {

            foreach ( $inputs as $input ) {
                $value = rgar( $entry, (string) $input['id'] );
                //echo $value;
								//var_dump($inputs);


            }
        } else {
            $value = rgar( $entry, (string) $field->id );
        }
    }

	$tierForUpgrade = $entry['5'];
	$currentPlan = $entry['3'];
	$cs_requested = $entry['17.1'];
	$cs_agent_name = $entry['16'];
	$category = $entry['13'];
	$subcategory = $entry['14'];
	$user_adminLink = $entry['2'];
	$location_adminLink = $entry['20'];
	$existing_feature_name = $entry['9'];
	$new_feature_name = $entry['12'];
	$new_feature_description = $entry['18'];
	$merchant_reason = $entry['11'];
	$additional_notes = $entry['15'];
	$ticketLink = $entry['19'];

	if ($cs_requested != 'Yes') {
		$cs_requested = 'No';
	}

	if ($additional_notes == '') {
		$additional_notes = 'N/A';
	}

	if ($merchant_reason == '') {
		$merchant_reason = 'N/A';
	}

	if ($new_feature_description == '') {
		$new_feature_description = 'N/A';
	}

	global $wpdb;

	$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
	$date->setTimeZone(new DateTimeZone('America/Chicago'));
	$submission_date = $date->format("Y-m-d h:i:s");

	$location_id = NULL;
	$user_id = NULL;
	if(preg_match("/\/(\d+)$/",$user_adminLink,$matches))
	{
	  $user_id=$matches[1];
	}
	if(preg_match("/\/(\d+)$/",$location_adminLink,$matches))
	{
	  $location_id=$matches[1];
	}

	// If it's a feature that currently does NOT exist
	if ($existing_feature_name == 'Not listed Here') {
		$wpdb->insert('cs_feature_requests', array(
			'date_submitted' => $submission_date,
			'agent_name' => $cs_agent_name,
			'feature_name' => $new_feature_name,
			'feature_description' => $new_feature_description,
			'cs_requested' => $cs_requested,
			'tierForUpgrade' => $tierForUpgrade,
			'location_id' => $location_id,
			'user_id' => $user_id,
			'ticketlink' => $ticketLink,
			'currentplan' => $currentPlan,
			'category' => $category,
			'subcategory' => $subcategory,
			'merchant_reason' => $merchant_reason,
			'additional_notes' => $additional_notes,
			'requests' => 1,
		));

		$feature = $wpdb->get_row( "SELECT id FROM cs_feature_requests WHERE feature_name LIKE '%".$new_feature_name."%'");

		$wpdb->insert('cs_feature_requests_comments', array(
			'date_submitted' => $submission_date,
			'agent_name' => $cs_agent_name,
			'feature_id' => $feature->id,
			'feature_description' => $new_feature_description,
			'merchant_reason' => $merchant_reason,
			'additional_notes' => $additional_notes,
			'location_id' => $location_id,
			'user_id' => $user_id,
			'ticketlink' => $ticketLink,
		));

	}
	else {

		$wpdb->query("UPDATE cs_feature_requests SET
			requests = (`requests` + 1)
			WHERE feature_name = '".$existing_feature_name."'");

			$feature = $wpdb->get_row( "SELECT id FROM cs_feature_requests WHERE feature_name LIKE '%".$existing_feature_name."%'");

			$wpdb->insert('cs_feature_requests_comments', array(
				'date_submitted' => $submission_date,
				'agent_name' => $cs_agent_name,
				'feature_id' => $feature->id,
				'feature_description' => $new_feature_description,
				'merchant_reason' => $merchant_reason,
				'additional_notes' => $additional_notes,
				'location_id' => $location_id,
				'user_id' => $user_id,
				'ticketlink' => $ticketLink,
			));
	}
}

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

add_role(
    'trainee',
    __( 'Trainee' ),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
    )
);
