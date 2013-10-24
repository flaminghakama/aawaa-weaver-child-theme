<!-- BEGIN  page-events.php  -->
<?php
/*
 * Template Name: Events
 * Description: Template for the events page.
 *
 * This page will display the content of the events page, 
 * plus excerpts from several other events pages/posts.
 *
 * The number of exceprted events is defined in the events page's 
 * custom variable, "How Many Featured Events".
 *  
 * A query is issued to grab the pages/posts that have the custom variable 
 * "Events Expiration Date (YYYY-MM-DD)", sorted in most-recent-first order.
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 *
 */

weaverii_get_header('page');
if (weaverii_getopt('wii_infobar_location') == 'top') get_template_part('infobar');
weaverii_inject_area('premain'); ?>

<?php 

echo("\t<div id=\"main\">\n");
weaverii_trace_template(__FILE__);

weaverii_get_sidebar_left('page');
?>

		<div id="container_wrap"<?php weaverii_get_page_class('page', 'container-page'); ?>>
<?php		if (weaverii_getopt('wii_infobar_location') == 'content') get_template_part('infobar');
		weaverii_inject_area('precontent'); ?>
		<div id="container">
<?php		weaverii_get_sidebar_top('page'); ?>

		    <div id="content" role="main">

<?php 			while ( have_posts() ) {
			    weaverii_post_count_clear(); the_post();

			    get_template_part( 'content', 'page' );

			    comments_template( '', true );
			}

global $post;
$max_events = get_post_meta($post->ID, 'How Many Featured Events', true);
//echo "<p>max events for post id $post->ID is $max_events</p>\n" ; 

 $querystr = "
    SELECT $wpdb->posts.* 
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = 'Events Expiration Date (YYYY-MM-DD)' 
    AND $wpdb->posts.post_status = 'publish' 
    ORDER BY $wpdb->postmeta.meta_value DESC
    LIMIT 0, $max_events
 ";

 $pageposts = $wpdb->get_results($querystr, OBJECT);
 $events_content = "" ; 

 foreach ($pageposts as $post):
   setup_postdata($post);
   $this_title = get_the_title() ;
   $this_permalink = get_permalink() ;
   $this_excerpt = get_post_meta($post->ID, 'Events Excerpt', true) ; 
   $events_content .= "<div class='events-excerpt'>\n<h3><a href='$this_permalink'>$this_title</a></h3>\n$this_excerpt\n</div>\n" ; 
endforeach ; 
 
 echo $events_content ; 
?>
			</div><!-- #content -->

<?php		weaverii_get_sidebar_bottom('page'); ?>
		</div><!-- #container -->
		</div><!-- #container_wrap -->

<?php	weaverii_get_sidebar_right('page');
	weaverii_get_footer('page');
?>
<!-- END  page.php  -->
