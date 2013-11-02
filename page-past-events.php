<!-- BEGIN  page-past-events.php  -->
<?php
/*
 * Template Name: Past Events
 * Description: Template for the past events page.
 *
 * This page will display the content of the past events page, 
 * plus excerpts from all expired events pages/posts.
 *
 * A query is issued to grab the pages/posts that have the custom variable 
 * "Events Expiration Date (YYYY-MM-DD)", sorted in most-recent-first orde, 
 * and filtered to exclude any events that have not yet expired.
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

 $today = date('Y-m-d') ; 

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
   //echo "<p>Looking at post <b>$this_title</b></p>\n" ; 
 
   //  Make sure this event has expired.
   //  Compare the expiration date with today.
   //  If the expiration is greater than today, it has not yet expired.
   $this_expiration = get_post_meta($post->ID, 'Events Expiration Date (YYYY-MM-DD)', true) ; 
   if ( strcmp($this_expiration, $today) >= 0 ) { 
     echo "<!-- omitting current event $this_title which expires $this_expiration -->\n" ; 
     continue ;
   }  

   $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
   //echo "<p>featured image URL for $this_title is $image_url</p>\n" ; 
   $this_excerpt = get_post_meta($post->ID, 'Events Excerpt', true) ; 
   $this_permalink = get_permalink( $post->ID ); 
   $events_content .= "<div class='events-excerpt'>\n<a href='$this_permalink'><img src='$image_url' width='200' height='133'></a>\n<div><h3><a href='$this_permalink'>$this_title</a></h3>\n$this_excerpt\n</div>\n</div>\n" ; 

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
<!-- END  page-past-events.php  -->
