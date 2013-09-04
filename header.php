<!-- BEGIN  header.php  -->
<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till < div id="main" >
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 *
 */
if (function_exists('weaverii_ts_pp_switch'))
    weaverii_ts_pp_switch();
weaverii_setup_mobile();
?><!DOCTYPE html>
<!--[if IE 7]>	<html id="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>	<html id="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>	<html id="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8) ] | !(IE 9) ><!-->	<html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php
    $viewport = "<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes' />\n";
    // Need to see if the visitor has opened Full View on a mobile device - use viewport to get full desktop view
    if ((weaverii_sim_mobile() && !weaverii_in_mobile_view())
	|| (weaverii_is_mobile() && weaverii_mobile_gettype() != 'tablet')) {
	if (!weaverii_in_mobile_view()) {
	    $tw = weaverii_getopt('wii_theme_width_int');
	    if (!$tw) $tw = 940;
	    $viewport = "<meta name='viewport' content='width=" . $tw . "px, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes' />\n";
	}
    }
    if (weaverii_getopt_checked('wii_theme_width_fixed') || weaverii_getopt_checked('_wii_mobile_disable'))
	$viewport = "<!-- no viewport -->\n";
    echo $viewport;

     // comments_popup_script(400, 500);
?>
<title><?php		// ++++++ HEAD TITLE ++++++
    wp_title('');		// the title - will run through our filter
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php

    $sheet_dev = get_stylesheet_directory_uri() . '/style.css';	// get style.css
    $sheet = str_replace('.css', WEAVER_MINIFY.'.css',$sheet_dev); // default sheet
    $sheet_file = get_stylesheet_directory() . '/style' . WEAVER_MINIFY . '.css';
    if (! @file_exists($sheet_file))
	$sheet = $sheet_dev;		// no style.min.css available (need this check for child themes)
    $sheet_name = 'weaverii-main-style-sheet';

    if (($custom = weaverii_getopt('_wii_custom_style')) != '') {	// set which style sheet we are using
	$sheet = $custom;
	$sheet_name = 'weaverii-main-style-sheet-custom';
    } else if (weaverii_getopt_checked('wii_minimial_style')) {
	$sheet = get_template_directory_uri() . '/style-minimal'.WEAVER_MINIFY.'.css';
	$sheet_name = 'weaverii-main-style-sheet-min';
    }

    wp_register_style($sheet_name,$sheet,array(),WEAVERII_VERSION,'all');
    wp_enqueue_style($sheet_name);
    // the mobile style sheet

    if (!weaverii_getopt_checked('_wii_mobile_disable')) {
	$sheet = get_template_directory_uri() . '/style-mobile'.WEAVER_MINIFY.'.css';
	$msheet_name = 'weaverii-mobile-style-sheet';
	wp_register_style($msheet_name,$sheet,array(),WEAVERII_VERSION,'all');
	wp_enqueue_style($msheet_name);
    }
?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php			// ++++ CSS AND CUSTOM SCRIPTS ++++
    $icon = weaverii_getopt('_wii_favicon_url');
    if ($icon != '') {
	$url = apply_filters('weaverii_css',parse_url($icon,PHP_URL_PATH));
	echo "<link rel=\"shortcut icon\"  href=\"$url\" />\n";
    }
    $icon = weaverii_getopt('_wii_apple_touch_icon_url');
    if ($icon != '') {
	$url = apply_filters('weaverii_css',parse_url($icon,PHP_URL_PATH));
	echo "<link rel=\"apple-touch-icon\"  href=\"$url\" />\n";
    }
    weaverii_facebook_meta();

    if ( !weaverii_use_inline_css(weaverii_get_css_filename()) ) { // don't generate inline CSS
	$vers = weaverii_getopt('wii_style_version');
	if (!$vers) $vers = '1';
	else $vers = sprintf("%d",$vers);
	wp_register_style('weaverii-style-sheet',weaverii_get_css_url(),array($sheet_name),$vers);
	wp_enqueue_style('weaverii-style-sheet');
    }

    weaverii_pro_wp_head();	// anything needed for Pro Version

    wp_head();
?>
</head>

<body <?php body_class(); ?>>
<a href="#page-bottom" id="page-top">&darr;</a> <!-- add custom CSS to use this page-bottom link -->
<?php
    weaverii_trace_template(__FILE__);
    weaverii_trace_mobile();

    if (weaverii_getopt('wii_top_menu_before_wrapper'))
	get_template_part('nav','top');

    weaverii_inject_area('prewrapper');

    weaverii_e_notopt('wii_header_first',"<div id=\"wrapper\" class=\"hfeed\">\n");	// put the header before the wrapper?

    weaverii_inject_area('preheader');

    if ( !weaverii_is_checked_page_opt('ttw-hide-header') ) {
	if (!weaverii_getopt('wii_top_menu_before_header') && !weaverii_getopt('wii_top_menu_before_wrapper'))
	    get_template_part('nav','top');
?>
	<header id="branding" role="banner">
<?php
	    /* ======== SITE LOGO and TITLE ======== */
	    $title = (weaverii_getopt('_wii_mobile_site_title') && weaverii_use_mobile('mobile') )
		? esc_html(weaverii_getopt('_wii_mobile_site_title')) : esc_attr( get_bloginfo( 'name', 'display' ) );
?>
<!--	    <div id="site-logo"><a href='<?php echo home_url( '/' ); ?>'><img src="<?php bloginfo('stylesheet_directory'); ?>/images/graphics/aawaa-header-logo.png" width="191" height="103"></a></div> -->
	    <div id="site-logo-link" onclick="location.href='';"></div>

<?php
	    $h_class = ' class="title-description"';
	    if ( weaverii_getopt('wii_hide_site_title') || weaverii_is_checked_page_opt('ttw-hide-site-title') ) {
		if (!weaverii_use_mobile('mobile') || weaverii_getopt('wii_hide_site_title_mobile')) {
		    $h_class = '';
		}
	    }
	    if (weaverii_getopt('wii_title_over_header') || weaverii_getopt('wii_desc_over_header'))
		$h_class = '';

	    $t_class = weaverii_getopt_checked('wii_title_on_header') ? ' class="title-on-header"' : '';
?>
	    <hgroup<?php echo $h_class; ?>>
	    	<h1 id="site-title" <?php echo $t_class; ?>><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo $title; ?></a></span></h1>
			<h2 id="site-description"> <?php bloginfo( 'description' ); ?></h2>
<?php		if (($extra = weaverii_getopt('wii_header_html')) != '') {
		    $hide_mobile = weaverii_getopt('wii_header_html_hide_mobile') ? 'wvr-hide-mobile-mobile' : '';
		    if ($hide_mobile == '' && weaverii_getopt_checked('wii_title_on_header'))
			$hide_mobile = 'title-on-header';
		    if ($hide_mobile != '')
			$hide_mobile = ' class="' . $hide_mobile . '"';
?>
		<div id="header-extra-html"<?php echo $hide_mobile;?>><?php echo do_shortcode($extra); ?></div>
<?php
		}
?>
	    </hgroup>

<?php
	    if (weaverii_getopt('wii_top_menu_before_header') && !weaverii_getopt('wii_top_menu_before_wrapper'))
		get_template_part('nav','top');
	    weaverii_mobile_toggle('header');	// display toggle button
	    weaverii_inject_area('header');	// inject header HTML

	    if (!weaverii_getopt('_wii_hdr_widg_afterimg'))
		get_sidebar('header');

	    weaveriip_header_insert();			// add W-II Pro injection

	    /* The Dynamic Headers shows headers on a per page basis - will also optionally add site link */
	    if (function_exists('show_media_header'))
		show_media_header(); 			// Plugin support: **Dynamic Headers**

	    /* ======== HEADER IMAGE ======== */
	    global $weaverii_header;

	    if ( !( weaverii_is_checked_page_opt('ttw-hide-header-image') && !is_search() )
		&& !( weaverii_getopt_checked('wii_normal_hide_header_image') && !weaverii_use_mobile('mobile') )
		&& !( weaverii_getopt_checked('wii_mobile_hide_header_image') && weaverii_use_mobile('mobile'))
		|| ( weaverii_getopt_checked('wii_ipad_show_header_image') && weaverii_use_mobile('tablet')) ) {

		if ( !weaverii_getopt_checked('wii_hide_header_image')
		    && !(weaverii_getopt('wii_hide_header_image_front') && is_front_page() ) ) {

		    echo("\t\t<div id=\"header_image\">\n");
		    if (weaverii_getopt('wii_link_site_image')) {
?>
		    <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
<?php
		    }
		    global $weaverii_header;
		    /* Check if this is a post or page, if it has a thumbnail,  and if it's a big one */
		    if ( is_singular()
			&& !(weaverii_use_mobile('mobile') && weaverii_getopt('wii_hide_mobile_fi'))
			&& !weaverii_getopt('wii_hide_featured_header')
			&& has_post_thumbnail( $post->ID )
			&& ($image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ) )  /* $src, $width, $height */
			&& $image[1] >= $weaverii_header['width']
		       ) {
			echo '<!-- line 202 -->' ; 
			echo get_the_post_thumbnail( $post->ID, 'full' );
			echo '<!-- line 204 -->' ; 
		    } else {
			if (weaverii_use_mobile('mobile') && weaverii_getopt('_wii_mobile_header_url')) {
			    echo '<img src="' . esc_attr(apply_filters('weaverii_css',weaverii_getopt('_wii_mobile_header_url'))) .
				'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />' . "\n";
			} else if (weaverii_use_mobile('tablet') && weaverii_getopt('_wii_mobile_tablet_header_url')) {
			    echo '<img src="' . esc_attr(apply_filters('weaverii_css',weaverii_getopt('_wii_mobile_tablet_header_url'))) .
				'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />' . "\n";
			} else if (($alt_img = weaverii_getopt('wii_alt_header_img')) != '') {
			    if (strstr($alt_img,'<img') === FALSE)
				echo '<img src="' . apply_filters('weaverii_css',esc_attr($alt_img)) .
				    '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />' . "\n";
			    else
				echo esc_attr($alt_img);
			} else {
			    $hdr = get_header_image();
			    if ($hdr) {
?>
                        <!-- <img src="<?php echo $hdr ?>" width="<?php echo $weaverii_header['width']; ?>" height="<?php echo  $weaverii_header['height']; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /> -->
			<!-- <img src="<?php echo $hdr ?>" width="800" height="12" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /> -->
<?php			    } else {
				echo '<div class="weaver-clear"></div>'; // needs a clear if not an img
			    }
			}
		    }
		    weaverii_e_opt('wii_link_site_image',"</a>\n");	/* need to close link */
		    echo("\t\t</div><!-- #header_image -->\n");
		} /* closes header > 0 */
	    } /* end wii_hide-header-image */

	    if (weaverii_getopt('_wii_hdr_widg_afterimg'))
		get_sidebar('header');
?>
	</header><!-- #branding -->
<?php
	    /* ======== BOTTOM MENU ======== */
	    get_template_part('nav','bottom');
    }	// end hide-header

    weaverii_e_opt('wii_header_first', "<div id=\"wrapper\" class=\"hfeed\">\n"); // wrapper after header
?>
<!-- END  header.php  -->
