<!-- BEGIN  sidebar-header.php  -->
<?php
/**
 * The Header widget area.
 *
 */
    global $weaverii_cur_page_ID;

    $extra = trim(get_post_meta($weaverii_cur_page_ID,'replace_horiz_header',true)); // per page replacement area?
    $xarea = '';

    if (strlen($extra) > 0) {		// want to display some areas
	$xarea = 'per-page-' . $extra;  // retrieve meta value
	if (!is_active_sidebar($xarea)) {
?>
	    <h3>*** Note: Per Page widget area: <?php echo $extra; ?> not found. You've likely mistyped the name or haven't defined the area yet. Using default area. ***</h3>
<?php
	    $xarea = '';
	}
    }

    $harea = ($xarea) ? $xarea : 'header-widget-area';

if (is_active_sidebar($harea)
    && !(weaverii_use_mobile('mobile') && weaverii_getopt_checked('_wii_hdr_widg_hide_mobile'))
    && !(!is_front_page() && !is_home() && weaverii_getopt_checked('_wii_hdr_widg_frontpage'))
    && !(weaverii_getopt_checked('_wii_hdr_widg_hide_normal') && !weaverii_use_mobile('mobile'))
    && !weaverii_is_checked_page_opt('ttw-hide-header-widget')) { // weaver header widget area
    // header-widget-1
    // wii_hdr_widg_1 -- _bgcolor _w_int _w_mobile_int
    // wii_hdr_widg_bgcolor wii_hdr_widg_h_int wii_hdr_widg_w_int wii_hdr_widg_hide_mobile
    // #sidebar_header {background:yellow;clear:both;font-size:120%;min-height:200px;}
    if (weaverii_use_mobile('mobile')) {
    ?>
	<div id="sidebar_header" class="sidebar-header-mobile">
    <?php } else { ?>
    	<div id="sidebar_header" class="sidebar-header">
<?php }
    weaverii_trace_sidebar(__FILE__);
?>

	<table id="header_widget_table">
          <tr>

<!-- BEGIN adapted content for sidebar-header, basically a loop for the tools category -->
            <td>
<?php

 $querystr = "
    SELECT $wpdb->posts.* 
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = 'Tool Order' 
    AND $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'post'
    ORDER BY $wpdb->postmeta.meta_value ASC
 ";

 $pageposts = $wpdb->get_results($querystr, OBJECT);
 global $post; ?>

              <ul class="header-toolbar">
 <?php foreach ($pageposts as $post): ?>
   <?php setup_postdata($post); ?>
   <?php $this_title = get_the_title() ; ?>
   <?php $this_permalink = get_permalink() ?>
   <?php if ($this_title == "Home") { $this_permalink = get_site_url() ; } ?>
   <?php if ($this_title == "Log In") { $this_permalink = get_site_url() . "/wp-admin" ; } ?>
   <?php if (($this_title == "Social Media Toolbar Buttons") ||
             ($this_title == "Donate Toolbar Button")) { ?>
                <li><?php the_content() ; ?></li>
   <?php } else { ?> 
                <li><a href="<?php echo $this_permalink ?>"><?php echo get_the_title(); ?></a></li>
   <?php } ?>
 <?php endforeach; ?>
              </ul>
            </td>

<!-- END adapted content for sidebar-header -->

<?php
    // here, we duplicate the functionality of dynamic_sidebar so we can add our own styling
    for (;;) {		// so we can break instead of return
    	global $wp_registered_sidebars, $wp_registered_widgets;
	$index = sanitize_title($harea);
	foreach ( (array) $wp_registered_sidebars as $key => $value ) {
	    if ( sanitize_title($value['name']) == $index ) {
		$index = $key;
		break;
	    }
	}
	// ok, got our index

	$sidebars_widgets = wp_get_sidebars_widgets();
	if ( empty( $sidebars_widgets ) )
		break;		// break the for (;;)

	if ( empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $sidebars_widgets)
	    || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
		break;

	$sidebar = $wp_registered_sidebars[$index];

	$did_one = false;
	$widget_num = 0;
	foreach ( (array) $sidebars_widgets[$index] as $id ) {

		if ( !isset($wp_registered_widgets[$id]) ) continue;

		if ($widget_num > 0 && ($widget_num % 4) == 0) {	// new row every 4 widgets
		    echo '</tr><tr>';
		}
/*
		$params = array_merge(
			array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
			(array) $wp_registered_widgets[$id]['params']
		);

		// Substitute HTML id and class attributes into before_widget
		$classname_ = '';
		foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn ) {
			if ( is_string($cn) )
				$classname_ .= '_' . $cn;
			elseif ( is_object($cn) )
				$classname_ .= '_' . get_class($cn);
		}
		$classname_ = ltrim($classname_, '_');

		$classname_ .= ' header-widget-' . (($widget_num % 4) + 1);	// also add unique class to apply styling

		$params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_ );

		//$params = apply_filters( 'dynamic_sidebar_params', $params );

		$callback = $wp_registered_widgets[$id]['callback'];
		do_action( 'dynamic_sidebar', $wp_registered_widgets[$id] );

		if ( is_callable($callback) ) {
			call_user_func_array($callback, $params);
			$did_one = true;
		}
*/
		$widget_num++;
	} // do each widget
	break;	// get out of the for (;;)
    }
?>
<!-- end of sidebar-header loop -->
	  </tr>
        </table>
	</div><!-- #sidebar_header -->

<?php
}
?>
<!-- END  sidebar-header.php  -->
