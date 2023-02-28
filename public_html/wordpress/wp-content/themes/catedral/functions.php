<?php
/*
 *  WP Bootstrap 4 Sass Custom functions, support, custom post types and more.
 *  Author: tone4hook
 *  URL: https://github.com/tone4hook
 *
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('wp_deseo', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// WP Bootstrap Sass navigation
function wp_deseo_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'collapse navbar-collapse',
        'container_id'    => 'bs-example-navbar-collapse-1',
        'menu_class'      => 'nav navbar-nav',
        'menu_id'         => '',
        'echo'            => true,
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="nav navbar-nav navbar-right">%3$s</ul>',
        )
	);
}

// add bootstrap css class to menu <li> element
function atg_menu_classes($classes, $item, $args) {
    if ($args->theme_location == 'header-menu') {
      $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'atg_menu_classes', 1, 3);

// add bootstrap css class to menu <a> element
function add_specific_menu_location_atts( $atts, $item, $args ) {
    // check if the item is in the header menu
    if( $args->theme_location == 'header-menu' ) {
      // add the desired attributes:
      $atts['class'] = 'nav-link';
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_specific_menu_location_atts', 10, 3 );

// Load WP Bootstrap Sass scripts (header.php)
function wp_deseo_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        // Custom scripts
        wp_register_script('wp_deseoscripts', get_template_directory_uri() . '/dist/main.bundle.js', array('jquery'), '1.0.0');

        // Enqueue it!
        wp_enqueue_script( array('wp_deseoscripts') );

    }
}

// Add attributes to the script tag
// async or defer
// *** for CDN integrity and crossorigin attributes ***
function add_script_tag_attributes($tag, $handle)
{
    switch ($handle) {

    	// adding async to main js bundle
    	// for defer, replace async="async" with defer="defer"
    	case ('wp_deseoscripts'):
    		return str_replace( ' src', ' async="async" src', $tag );
    	break;

    	// example adding CDN integrity and crossorigin attributes
    	// Note: popper.js is loaded into the main.bundle.js from npm
    	// This is just an example
        case ('popper-js'):
            return str_replace( ' min.js', 'min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"', $tag );
        break;

    	// example adding CDN integrity and crossorigin attributes
    	// Note: bootstrap.js is loaded into the main.bundle.js from npm
    	// This is just an example
        case ('bootstrap-js'):
            return str_replace( ' min.js', 'min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"', $tag );
        break;

        default:
            return $tag;

    } // /switch
}

// Load WP Bootstrap Sass conditional scripts
function wp_deseo_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load WP Bootstrap Sass styles
function wp_deseo_styles()
{
    // Normalize is loaded in Bootstrap and both are imported into the style.css via Sass
    wp_register_style('wp_deseo', get_template_directory_uri() . '/bootstrap.css', array(), '1.0.0', 'all');
    wp_enqueue_style('wp_deseo'); // Enqueue it!
}

// Register WP Bootstrap Sass Navigation
function register_wp_deseo_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'wp_deseo'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'wp_deseo'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'wp_deseo') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Sidebar 1', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-sidebar-1',
        'before_widget' => '<div id="%1$s" class="%2$s card mb-2"><div class="card-body">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="card-title">',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Sidebar 2', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-sidebar-2',
        'before_widget' => '<div id="%1$s" class="%2$s card mb-2"><div class="card-body">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="card-title">',
        'after_title' => '</h3>'
    ));
     // Define Sidebar Widget Area 3
    register_sidebar(array(
        'name' => __('Widget Sidebar 3', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-sidebar-3',
        'before_widget' => '<div id="%1$s" class="%2$s card mb-2"><div class="card-body">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="card-title">',
        'after_title' => '</h3>'
    ));
     // Define Sidebar Widget Sidebar 4
    register_sidebar(array(
        'name' => __('Widget Sidebar 4', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-sidebar-4',
        'before_widget' => '<div id="%1$s" class="%2$s card mb-2"><div class="card-body">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="card-title">',
        'after_title' => '</h3>'
    ));
     // Define Sidebar Widget Footer  1
    register_sidebar(array(
        'name' => __('Widget Footer 1', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-footer-1',
        'before_widget' => '<div id="%1$s" class="%2$s menu-widget"><ul class="check">',
        'after_widget' => '</ul></div>',
        'before_title' => '<div class="section-title text-left"><h5>',
        'after_title' => '</h5><hr></div>'
    ));
     // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Footer 2', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-footer-2',
        'before_widget' => '<div id="%1$s" class="%2$s card mb-2"><div class="card-body">',
        'after_widget' => '</div></div>',
        'before_title' => '<div><h3 class="card-title">',
        'after_title' => '</h3></div>'
    ));
     // Define Sidebar Widget Area 3
    register_sidebar(array(
        'name' => __('Widget Footer 3', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-footere-3',
        'before_widget' => '<div id="%1$s" class="%2$s "><div class="card-body">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="card-title">',
        'after_title' => '</h3>'
    ));
     // Define Sidebar Widget Footer 4
    register_sidebar(array(
        'name' => __('Widget Footer Copyright', 'wp_deseo'),
        'description' => __('Description for this widget-area...', 'wp_deseo'),
        'id' => 'widget-footer-copyright',
        'before_widget' => '<div id="%1$s" class="%2$s card"><div class="card-body">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="card-title">',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function wp_deseo_pagination()
{
    global $wp_query;
    $big = 999999999;
    $links = paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<span class="border p-1">&lt;</span>',
        'next_text' => '<span class="border p-1">&gt;</span>',
        'before_page_number' => '<span class="border p-1">',
        'after_page_number' => '</span>',
    ));

    if ( $links ) :

        echo $links;

    endif;

}

// Custom Excerpts
function wp_deseo_index($length) // Create 20 Word Callback for Index page Excerpts, call using wp_deseo_excerpt('wp_deseo_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using wp_deseo_excerpt('wp_deseo_custom_post');
function wp_deseo_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function wp_deseo_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function wp_deseo_view_article($more)
{
    global $post;
    return '... <p><a class="view-article btn btn-secondary" href="' . get_permalink($post->ID) . '" role="button">' . __('Read more', 'wp_deseo') . ' </a></p>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function wp_deseo_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function wp_deseogravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function wp_deseocomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

// add Bootstrap 4 .img-fluid class to images inside post content
function add_class_to_image_in_content($content) 
{

	$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
	$document = new DOMDocument();
	libxml_use_internal_errors(true);
	$document->loadHTML(utf8_decode($content));

	$imgs = $document->getElementsByTagName('img');
	foreach ($imgs as $img) {           
		$img->setAttribute('class','img-fluid');
	}

	$html = $document->saveHTML();
	return $html;  	

}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'wp_deseo_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'wp_deseo_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'wp_deseo_styles'); // Add Theme Stylesheet
add_action('init', 'register_wp_deseo_menu'); // Add WP Bootstrap Sass Menu
add_action('init', 'create_post_type_custom_post_type_demo'); // Add our WP Bootstrap Sass Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'wp_deseo_pagination'); // Add our wp_deseo Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('script_loader_tag', 'add_script_tag_attributes', 10, 2); // Add attributes to CDN script tag
add_filter('avatar_defaults', 'wp_deseogravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'wp_deseo_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'wp_deseo_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
// add .img-fluid class to images in the content
add_filter('the_content', 'add_class_to_image_in_content');

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('wp_deseo_shortcode_demo', 'wp_deseo_shortcode_demo'); // You can place [wp_deseo_shortcode_demo] in Pages, Posts now.
add_shortcode('wp_deseo_shortcode_demo_2', 'wp_deseo_shortcode_demo_2'); // Place [wp_deseo_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [wp_deseo_shortcode_demo] [wp_deseo_shortcode_demo_2] Here's the page title! [/wp_deseo_shortcode_demo_2] [/wp_deseo_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called custom-post-type
function create_post_type_custom_post_type_demo()
{
    register_taxonomy_for_object_type('category', 'custom-post-type'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'custom-post-type');
    register_post_type('custom-post-type', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('WP Bootstrap Sass Custom Post', 'wp_deseo'), // Rename these to suit
            'singular_name' => __('WP Bootstrap Sass Custom Post', 'wp_deseo'),
            'add_new' => __('Add New', 'wp_deseo'),
            'add_new_item' => __('Add New WP Bootstrap Sass Custom Post', 'wp_deseo'),
            'edit' => __('Edit', 'wp_deseo'),
            'edit_item' => __('Edit WP Bootstrap Sass Custom Post', 'wp_deseo'),
            'new_item' => __('New WP Bootstrap Sass Custom Post', 'wp_deseo'),
            'view' => __('View WP Bootstrap Sass Custom Post', 'wp_deseo'),
            'view_item' => __('View WP Bootstrap Sass Custom Post', 'wp_deseo'),
            'search_items' => __('Search WP Bootstrap Sass Custom Post', 'wp_deseo'),
            'not_found' => __('No WP Bootstrap Sass Custom Posts found', 'wp_deseo'),
            'not_found_in_trash' => __('No WP Bootstrap Sass Custom Posts found in Trash', 'wp_deseo')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom WP Bootstrap Sass post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function wp_deseo_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function wp_deseo_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}


/* Basic WP SEO
    Usage: 
        1. add this code to functions.php
        2. replace the $default_keywords with your own
        3. addbasic_wp_seo();  to header.php
        4. test well and fine tune as needed

    Optional: add custom description, keywords, and/or title
    to any post or page using these custom field keys:

        mm_seo_desc
        mm_seo_keywords
        mm_seo_title

    To migrate from any SEO plugin, replace its custom field 
    keys with those listed above. More information:

        @ https://digwp.com/2013/08/basic-wp-seo/
*/
function basic_wp_seo() {
    global $page, $paged, $post;
    $default_keywords = 'wordpress, plugins, themes, design, dev, development, security, htaccess, apache, php, sql, html, css, jquery, javascript, tutorials'; // customize
    $output = '';

    // description
    $seo_desc = get_post_meta($post->ID, 'mm_seo_desc', true);
    $description = get_bloginfo('description', 'display');
    $pagedata = get_post($post->ID);
    if (is_singular()) {
        if (!empty($seo_desc)) {
            $content = $seo_desc;
        } else if (!empty($pagedata)) {
            $content = apply_filters('the_excerpt_rss', $pagedata->post_content);
            $content = substr(trim(strip_tags($content)), 0, 155);
            $content = preg_replace('#\n#', ' ', $content);
            $content = preg_replace('#\s{2,}#', ' ', $content);
            $content = trim($content);
        } 
    } else {
        $content = $description;    
    }
    $output .= '<meta name="description" content="' . esc_attr($content) . '">' . "\n";

    // keywords
    $keys = get_post_meta($post->ID, 'mm_seo_keywords', true);
    $cats = get_the_category();
    $tags = get_the_tags();
    if (empty($keys)) {
        if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ', ';
        if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ', ';
        $keys .= $default_keywords;
    }
    $output .= "\t\t" . '<meta name="keywords" content="' . esc_attr($keys) . '">' . "\n";

    // robots
    if (is_category() || is_tag()) {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if ($paged > 1) {
            $output .=  "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
        } else {
            $output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
        }
    } else if (is_home() || is_singular()) {
        $output .=  "\t\t" . '<meta name="robots" content="index,follow">' . "\n";
    } else {
        $output .= "\t\t" . '<meta name="robots" content="noindex,follow">' . "\n";
    }

    // title
    $title_custom = get_post_meta($post->ID, 'mm_seo_title', true);
    $url = ltrim(esc_url($_SERVER['REQUEST_URI']), '/');
    $name = get_bloginfo('name', 'display');
    $title = trim(wp_title('', false));
    $cat = single_cat_title('', false);
    $tag = single_tag_title('', false);
    $search = get_search_query();

    if (!empty($title_custom)) $title = $title_custom;
    if ($paged >= 2 || $page >= 2) $page_number = ' | ' . sprintf('Page %s', max($paged, $page));
    else $page_number = '';

    if (is_home() || is_front_page()) $seo_title = $name . ' | ' . $description;
    elseif (is_singular())            $seo_title = $title . ' | ' . $name;
    elseif (is_tag())                 $seo_title = 'Tag Archive: ' . $tag . ' | ' . $name;
    elseif (is_category())            $seo_title = 'Category Archive: ' . $cat . ' | ' . $name;
    elseif (is_archive())             $seo_title = 'Archive: ' . $title . ' | ' . $name;
    elseif (is_search())              $seo_title = 'Search: ' . $search . ' | ' . $name;
    elseif (is_404())                 $seo_title = '404 - Not Found: ' . $url . ' | ' . $name;
    else                              $seo_title = $name . ' | ' . $description;

    $output .= "\t\t" . '<title>' . esc_attr($seo_title . $page_number) . '</title>' . "\n";

    return $output;
}
// Add Shortcode para relative post
function deseo_cluster_shortcode_custom_post_callback( $atts, $content ) {

   /*  Attributes
    $atts = shortcode_atts(
        array(
            'cat' => '1',
            'post' => '1',
            'max' => '3',
        ),
        $atts,
        'deseo_cluster_shortcode'
    );*/
    // print_r($atts['posts']);
     $posts = explode(',',$atts['posts']);
    //query arguments
    $args = array(
 
        'post_status' => 'publish',
      
        'posts_per_page' => $atts['max'],
      
            
        'post__in' => $posts,
    );
  //die( print_r($args));
    //the query
    $posts = new WP_Query( $args ); 
    $html ='<div class="col-md-12 col-lg-12 col-sm-12"></div>';
    $html .= '<h3>'.$content.'</h3>';
    //loop through query
    switch ($atts['max']) {
        case '4':
            // code...
         $col ='col-lg-3 col-md-3 col-sm-12';
            break;
        case '3':
 $col ='col-lg-4 col-md-4 col-sm-12';
            break;
     case '2':
 $col ='col-lg-6 col-md-6 col-sm-12';
            break;
         
    }
   
    if($posts->have_posts()){
     $html .= '<div class"row">';

    while($posts->have_posts()){ 
        $posts->the_post();
           $html .= '<div class="'.$col.'">
                                    <div class="post-media clearfix">';
                                       
                                     
       if ( has_post_thumbnail()) : // Check if thumbnail exists 
    $html.='   <!-- post thumbnail -->';
    $html .=' <a href="'.get_the_permalink().'" title="'.get_the_title().' " alt="'.get_the_title().'">';
            $html .=get_the_post_thumbnail(get_the_ID(),'post-thumbnail', array('height'=>'180px','width'=>'180px','class' => 'thumbnail') ); // Declare pixel size you need inside the array
            $html.='</a>';

            
    
       $html .='<!-- /post thumbnail -->';
         endif; 
        $html .=' <a href="'.get_the_permalink().'" title="'.get_the_title().' "><h4>'.get_the_title().'</h4></a>
                                    </div><!-- end post-media -->

                                </div><!-- end col -->';
       

    }

   $html .= '</div>'; 
   $html .='</div>';
}else{
    //no posts found
}

wp_reset_postdata();
    return $html;
}

//add custom cat 
// Add Shortcode para relative post
function deseo_cluster_shortcode_custom_cat_callback( $atts, $content ) {

   /*  Attributes
    $atts = shortcode_atts(
        array(
            'cat' => '1',
            'post' => '1',
            'max' => '3',
        ),
        $atts,
        'deseo_cluster_shortcode'
    );*/
    // print_r($atts['posts']);
     $cats = explode(',',$atts['cats']);
     $atts['max']=count($cats);
    //query arguments
    $args = array(
        'post_type' =>'term',
       
        'posts_per_page' =>$atts['max'],
      
            
        'category__in ' => $cats,
    );
  //die( print_r($args));
    //the query
    $posts = new WP_Query( $args ); 
    $html ='<div class="col-md-12 col-lg-12 col-sm-12"></div>';
    $html .= '<h3>'.$content.'</h3>';
    //loop through query
    switch ($atts['max']) {
        case '4':
            // code...
         $col ='col-lg-3 col-md-3 col-sm-12';
            break;
        case '3':
 $col ='col-lg-4 col-md-4 col-sm-12';
            break;
     case '2':
 $col ='col-lg-6 col-md-6 col-sm-12';
            break;
         
    }
   
    if($posts->have_posts()){
     $html .= '<div class"row">';

    while($posts->have_posts()){ 
        $posts->the_post();
           $html .= '<div class="'.$col.'">
                                    <div class="post-media clearfix">';
                                       
                                     
       if ( has_post_thumbnail()) : // Check if thumbnail exists 
    $html.='   <!-- post thumbnail -->';
    $html .=' <a href="'.single_cat_title().'" title="'.single_cat_title().' " alt="'.get_the_title().'">';
            $html .=get_the_post_thumbnail(get_the_ID(),'post-thumbnail', array('height'=>'180px','width'=>'180px','class' => 'thumbnail') ); // Declare pixel size you need inside the array
            $html.='</a>';

            
    
       $html .='<!-- /post thumbnail -->';
         endif; 
        $html .=' <a href="'.get_the_permalink().'" title="'.get_the_title().' "><h4>'.get_the_title().'</h4></a>
                                    </div><!-- end post-media -->

                                </div><!-- end col -->';
       

    }

   $html .= '</div>'; 
   $html .='</div>';
}else{
    //no posts found
}

wp_reset_postdata();
    return $html;
}
// Add Shortcode para relative post
function deseo_cluster_shortcode_relative_post_callback( $atts, $content ) {

   /*  Attributes
    $atts = shortcode_atts(
        array(
            'cat' => '1',
            'post' => '1',
            'max' => '3',
        ),
        $atts,
        'deseo_cluster_shortcode'
    );*/
    // print_r($atts);
    //query arguments
    $args = array(
 
        'post_status' => 'publish',
        'posts_per_page' => $atts['max'],
        'orderby' => 'rand',
        
        'post__not_in' => array ($atts['post']),
    );

   // print_r($args);
    //the query
    $posts = new WP_Query( $args );
    $html ='<div class="col-md-12 col-lg-12 col-sm-12"></div>';
    $html .= '<h3>'.$content.'</h3>';
        //loop through query
    switch ($atts['max']) {
        case '4':
            // code...
         $col ='col-lg-3 col-md-3 col-sm-12';
            break;
        case '3':
 $col ='col-lg-4 col-md-4 col-sm-12';
            break;
     case '2':
 $col ='col-lg-6 col-md-6 col-sm-12';
            break;
         
    }
    //loop through query
    if($posts->have_posts()){
     $html .= '<div class"row">';

    while($posts->have_posts()){ 
        $posts->the_post();
           $html .= '<div class="'.$col.'">
                                    <div class="post-media clearfix">';
                                       
                                     
       if ( has_post_thumbnail()) : // Check if thumbnail exists 
    $html.='   <!-- post thumbnail -->';
    $html .=' <a href="'.get_the_permalink().'" title="'.get_the_title().' " alt="'.get_the_title().'">';
            $html .=get_the_post_thumbnail(get_the_ID(),'thumbnail', array('height'=>'180px','width'=>'180px','class' => 'thumbnail') ); // Declare pixel size you need inside the array
            $html.='</a>';

            
    
       $html .='<!-- /post thumbnail -->';
         endif; 
        $html .=' <a href="'.get_the_permalink().'" title="'.get_the_title().' "><h4>'.get_the_title().'</h4></a>
                                    </div><!-- end post-media -->

                                </div><!-- end col -->';
       

    }

   $html .= '</div>'; 
   $html .='</div>';
}else{
    //no posts found
}

wp_reset_postdata();
    return $html;
}
add_shortcode( 'deseo-cluster-relative-post', 'deseo_cluster_shortcode_relative_post_callback' );

add_shortcode( 'deseo-cluster-custom-post', 'deseo_cluster_shortcode_custom_post_callback' );
add_shortcode( 'deseo-cluster-custom-cat', 'deseo_cluster_shortcode_custom_cat_callback' );

?>
