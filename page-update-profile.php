<!-- BEGIN  page-update-profile.php  -->
<?php
/*
 * Template Name: Update Profile
 * Description: Template for updating member information.  
 *    
 * Also used for creating member accounts, along with member information.
 *
 * This page will display forms for submitting information.
 * Multi-part AJAX requests are used to submit partial information.
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
?>


<link rel='stylesheet' id='buttons-css'  href='<?php echo site_url(); ?>/wp-includes/css/buttons.min.css?ver=3.9' type='text/css' media='all' />
<link rel='stylesheet' id='open-sans-css'  href='//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=3.9' type='text/css' media='all' />
<link rel='stylesheet' id='dashicons-css'  href='<?php echo site_url(); ?>/wp-includes/css/dashicons.min.css?ver=3.9' type='text/css' media='all' />
<link rel='stylesheet' id='login-css'  href='<?php echo site_url(); ?>/wp-admin/css/login.min.css?ver=3.9' type='text/css' media='all' />

<body class="login login-action-login wp-core-ui  locale-en-us">
	<div id="login">
<form name="loginform" id="loginform" action="<?php echo site_url(); ?>/wp-login.php" method="post">
	<p>
		<label for="user_login">Username<br>
		<input type="text" name="log" id="user_login" class="input" value="" size="20"></label>
	</p>
	<p>
		<label for="user_pass">Password<br>
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20"></label>
	</p>
		<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In">
		<input type="hidden" name="redirect_to" value="<?php echo site_url(); ?>/wp-admin/">
		<input type="hidden" name="testcookie" value="1">
	</p>
</form>

<p id="nav">
	<a href="/wp-login.php?action=lostpassword" title="Password Lost and Found">Lost your password?</a>
</p>

<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
d = document.getElementById('user_login');
d.focus();
d.select();
} catch(e){}
}, 200);
}

if(typeof wpOnload=='function')wpOnload();
</script>
	</div>
		<div class="clear"></div>


			</div><!-- #content -->
<?php		weaverii_get_sidebar_bottom('page'); ?>
		</div><!-- #container -->
		</div><!-- #container_wrap -->

<?php	weaverii_get_sidebar_right('page');
	weaverii_get_footer('page');
?>
<!-- END  page.php  -->

?>
<!-- END  page-update-profile.php  -->
