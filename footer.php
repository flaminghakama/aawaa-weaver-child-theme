<!-- BEGIN  footer.php  -->
<?php
/**
 * The template for displaying the footer.
 *
 * Contains all content after the closing of the id=main div
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */
weaverii_trace_template(__FILE__);
?>
<?php
    if (weaverii_getopt_checked('wii_footer_last'))	// move footer outside of page, allows wide footer
	echo("</div><!-- #wrapper -->\n");

    if ((weaverii_use_mobile('mobile') && weaverii_getopt('_wii_mode_mobile') != 'weaver-mobile-smart-stacked')
	|| weaverii_getopt('_wii_mode_mobile') == 'weaver-mobile-resp-nostack')
	weaverii_put_widgetarea('mobile-widget-area', 'mobile_widget_area');

    weaverii_inject_area('prefooter');		// put the prefooter optional area
    if (!weaverii_getopt('wii_hide_footer') && !weaverii_is_checked_page_opt('ttw-hide-footer')) {
?>
	<footer id="colophon" role="contentinfo">
<!-- BEGIN footer nav -->
<?php

  /* loop through pages/posts with the properties 
     "Footer Group" and "Footer Sort Order" and Footer Group Sort Order" 
   */

 $querystr = "
    SELECT $wpdb->posts.* 
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = 'Footer Group' 
    AND $wpdb->posts.post_status = 'publish' 
    ORDER BY $wpdb->postmeta.meta_value ASC
 ";

 $pageposts = $wpdb->get_results($querystr, OBJECT);
 global $post; 

 //  Array to let us determine the order of the columns in the footer
 $footer_group_order = array() ; 

 //  Array to let us assemble the HTML for each column in the footer
 $footer_group = array();
  
 foreach ($pageposts as $post) { 

   $postID = get_the_ID() ; 
   $postCustom = get_post_custom($postID) ;
   $postFooterGroup = $postCustom['Footer Group'][0] ; 
   $postFooterSortOrder = $postCustom['Footer Sort Order'][0] ; 
   $postFooterGroupSortOrder = $postCustom['Footer Group Sort Order'][0]  ; 

   //echo("<p>") ; 
   //print_r($postCustom) ; 
   //echo("</p>\n\n") ;

   //  If this post has a footer group sort order, 
   //  make note of the sort order of this group.
   if ( $postFooterGroupSortOrder != "" )  {
     $footer_group_order[$postFooterGroupSortOrder] = $postFooterGroup ; 
   }

   $this_title = get_the_title() ;
   $this_permalink = get_permalink() ; 

   //  If we have not yet seen entries for this group, 
   //  initialize the array of entries for this group.
   if ( ! array_key_exists($postFooterGroup, $footer_group) ) {
     $footer_group[$postFooterGroup] = array() ;
   }

   //  Determine if this is the first (sort order = 0) entry in the list
   //  or a subsequent one, format it accordingly, then add it to the list
   $list_item = "" ; 
   if ( $postFooterSortOrder == 0 ) { 
     $list_item = "    <span><a href='$this_permalink'>$this_title</a></span>\n" ; 
   } else {
     $list_item = "        <li><a href='$this_permalink'>$this_title</a></li>\n" ; 
   }
   $footer_group[$postFooterGroup][$postFooterSortOrder] = $list_item ; 
 }


 $footer_html = "<div class='footer_links'>\n" ; 

 ksort($footer_group_order) ; 
 foreach ($footer_group_order as $order => $group_name ) { 

   //echo "<p>dealing with group order $order: $group_name</p>\n" ;   
   $footer_html .= "  <div class='footer_group_column'>\n" ; 

   $this_group = $footer_group[$group_name] ; 
   ksort($this_group) ; 
   //echo("<p>") ; print_r($this_group) ; echo("</p>\n") ; 

   $count = 0 ; 
   foreach ($this_group as $html ) { 

     //echo("<p>\$html = $html</p>\n") ; 

     if ( $count == 0 ) { 
       $footer_html .= $html ; 

     } else if ( ($count % 4) == 1 ) { 
       $footer_html .= "    <div class='footer_list'>\n" . 
                       "      <ul class='footer_entry'>\n" . 
     		       $html ; 
     } else if ( ($count % 4) == 0 ) { 
       $footer_html .= $html . "      </ul for='footer_entry'>\n" .
                               "    </div for='footer_list'>\n" ;
     } else { 
       $footer_html .= $html ; 
     }
     $count++ ; 
   }
   if ( ($count % 4) != 1 ) { 
     $footer_html .= "      </ul for='footer_entry'>\n" . 
       		     "    </div for='footer_list'>\n" ;
   }
   $footer_html .= "  </div for='footer_group_column'>\n" ;
 }
 $footer_html .= "</div for='footer_links'>\n" ;

 echo $footer_html ; 
?>

<!-- END footer nav -->

<?php
	if (weaverii_getopt_checked( 'wii_footer_inject_move' )) {
	    weaverii_inject_area('footer');	// here is where the footer options get inserted
	    get_sidebar( 'footer' );		// get the sidebar-footer temeplate
	} else {
	    get_sidebar( 'footer' );
	    weaverii_inject_area('footer');
	}

	$date = getdate();
	$year = $date['year'];
?>
	    <div id="site-ig-wrap">
		<span id="site-info">
<?php
	    $cp = weaverii_getopt('_wii_copyright');
	    if (strlen($cp) > 0) {
		if ($cp != '&nbsp;')	// really leave nothing if specify blank
		    echo(do_shortcode($cp));
	    } else {
?>
	    <!-- &copy; <?php echo($year); ?> - <a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> -->
	    &copy; <?php echo($year); ?> <a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">AAWAA</a> | San Francisco CA USA | <a target=_"blank" href="mailto:info@aawaa.net">info@aawaa.net</a>
<?php
	    }
?>
	    </span> <!-- #site-info -->
<?php	    if (! weaverii_getopt('_wii_hide_poweredby')) { ?>
	    <span id="site-generator">
		<a href="<?php echo esc_url( __( 'http://wordpress.org/','weaver-ii') ); ?>" title="wordpress.org" rel="generator" target="_blank"><?php printf( __( 'Proudly powered by %s','weaver-ii'), 'WordPress' ); ?></a>&nbsp;
<?php 		echo(WEAVERII_THEMENAME); ?> by <?php weaverii_site(); ?>WP Weaver</a>
   	    </span> <!-- #site-generator -->
<?php	    }
	    weaverii_mobile_toggle('footer');	// display toggle button
?>
	    </div><!-- #site-ig-wrap -->
	    <div class="weaver-clear"></div>
	  </div>
	</footer><!-- #colophon -->
<?php
    } // end if !hide_footer
    if (!weaverii_getopt_checked('wii_footer_last'))	// normally, #colophon inside #page
	echo("</div><!-- #wrapper -->\n");
    weaverii_inject_area('postfooter');		// and this is the end options insertion
    echo "<a href=\"#page-top\" id=\"page-bottom\">&uarr;</a>\n";

    if ( !weaverii_getopt_checked('_wii_no_final_div') ) {
	if (weaverii_getopt_checked('wii_hide_final')) {
	echo '<div id="weaver-final" class="weaver-final-normal wvr-hide-bang">';
	} else {
	    echo '<div id="weaver-final" class="weaver-final-normal">';
	}
    }
    wp_footer();

    weaverii_masonry('invoke-code');

    if ( !weaverii_getopt_checked('_wii_no_final_div') )
	echo '</div> <!-- #weaver-final -->' . "\n";

    if (weaverii_dev_mode() && weaverii_getopt_checked('_weaverii_diag_timer')) {
	global $weaverii_timer;
	$end_time = microtime(true);
	echo '<span class="wvr-timer-msg">Page generated in: '. round($end_time-$weaverii_timer, 3) . ' seconds.</span>' . "\n";
    }
?>
</body>
</html>
<!-- END footer.php  -->
