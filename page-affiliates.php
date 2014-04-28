<!-- BEGIN  page-affiliates.php  -->
<?php
/**
 * Used for Artists page
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
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
			    get_template_part( 'content', 'affiliate-search' );
			    comments_template( '', true );
			}
?>
			</div><!-- #content -->
<?php		weaverii_get_sidebar_bottom('page'); ?>
		</div><!-- #container -->
		</div><!-- #container_wrap -->

<?php	weaverii_get_sidebar_right('page');
	weaverii_get_footer('page');
?>
<!-- END  page-affiliates.php  -->
