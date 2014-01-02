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

<LINK href="<?php echo get_stylesheet_directory_uri() ; ?>/css/members.css" rel="stylesheet" type="text/css">

<!--  Underscore provides support that you would expect in Prototype.js (or Ruby), but without extending any of the built-in JavaScript objects.  Underscore provides functions: map, select, invoke — as well as more specialized helpers: function binding, javascript templating, deep equality testing, and so on.-->
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/underscore.min.js" type="text/javascript"></script>
<!-- Prototype adds useful extensions to the browser scripting environment and provides elegant APIs around the clumsy interfaces of Ajax and the Document Object Model. -->
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/prototype.1.7.min.js" type="text/javascript"></script>
<!-- script.aculo.us is an add-on to the Prototype framework that provides cross-browser libraries: animation framework, drag and drop, Ajax controls DOM utilities, and unit testing. -->
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/scriptaculous.all.min.js" type="text/javascript"></script>
<!-- This script is part of the Feedback Ruby on Rails Plugin -->
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/prototype.feedback.js" type="text/javascript"></script>

<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-query-string-parser.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-prototype.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-members.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-image-lightbox.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-cookies.js" type="text/javascript"></script>

<!-- for all elements with 'send-mau-a-note' class, popup a form to fill out the appropriate info and fire off a note to mau emails.  avoids 'mailto' links -->
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-notes.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-admin.js" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/js/members/aawaa-search.js" type="text/javascript"></script>

<div class='edit-sections'>
<form action="/artists/283" class="edit_artist" id="edit_artist_283" method="post">
<div class='open-close-div acct'>
<span class='title' id='info_toggle'>
Personal Info
</span>
<span class='edit'>
<a href='#info' id='info_toggle_lnk'>change</a>
</span>
</div>
<div class='edit-profile-sxn' id='info' style='display:none;'>
<div class='inner-sxn'>
<table class='entry-table'>
<tr>
<td class='input-name'>
First Name
</td>
<td>
<input id="artist_firstname" name="artist[firstname]" size="30" type="text" value="Flaming Hakama" />
</td>
<td class='input-err'></td>
</tr>
<tr>
<td class='input-name'>
Last Name
</td>
<td>
<input id="artist_lastname" name="artist[lastname]" size="30" type="text" value="by Elaine" />
</td>
<td class='input-err'></td>
</tr>
<tr>
<td class='input-name'>
Display Name
</td>
<td>
<input id="artist_nomdeplume" name="artist[nomdeplume]" size="30" type="text" />
</td>
<td class='input-err'>
(only if you want something different from your first name + last name)
</td>
</tr>
<tr>
<td class='input-name'>
Email
</td>
<td>
<input id="artist_email" name="artist[email]" size="30" type="text" value="elaine@flaminghakama.com" />
</td>
<td class='input-err'></td>
</tr>
</table>
<div class='buttons'>
<input id="artist_submit" name="commit" type="submit" value="Save Changes" />
<input id="artist_submit" name="commit" type="submit" value="Cancel" />
</div>
</div>
</div><div class='open-close-div acct'>
<span class='title' id='events_toggle'>Open Studios</span><span class='edit'><a href='#events' id='events_toggle_lnk'>change</a></span></div><div class='clear'></div>
<div class='edit-profile-sxn' id='events' style='display:none;'>
<div class='inner-sxn'>
<p class='markdown editable' data-cmsid='10' data-page='artists_edit' data-section='openstudios_question'>
<p>Are you planning to open your studio in April 26-27, 2013 for Spring Open Studios in the Mission?</p>

</p>
<p class='os-status'>
Your current answer is :
<span>Nope</span>
</p>

<input id="artist_os_participation" name="artist_os_participation" type="hidden" />
<div class='buttons'>
<div class='formbutton yep'>Yep</div>
<div class='formbutton nope'>Nope</div>
</div>
<div class='clear donate'>
And if you'd like to donate to help with our Open Studios promotion and keep this system running, here's a paypal donate button.  Thanks!
<a href='#' id='donate_for_openstudios'>
<div class='donate_btn'></div>
</a>
</div>
<div class='clear'></div>
</div>
</div>

<div class="open-close-div acct" ><span id="notification_toggle" class="title">Notifications</span><span class="edit"><a href="#notifications" id="notification_toggle_lnk">change</a></span><div class="clear"></div></div>
<div  class="edit-profile-sxn"  id="notification" style="display:none;">
  <div class="inner-sxn">
    <table class="entry-table">
      <tr>
	<td class="input-name">
	  Favorites:
	</td>
	<td valign="top" colspan="2">
	  <div><input name="emailsettings[favorites]" type="hidden" value="0" /><input checked="checked" id="emailsettings_favorites" name="emailsettings[favorites]" type="checkbox" value="1" />Notify me when someone favorites me or my art</div>
	</td>
      </tr>
      <tr>
	<td class="input-name">
	  Allow notes from:
	</td>
	<td valign="top">
	  <div><input name="emailsettings[fromall]" type="hidden" value="0" /><input checked="checked" id="emailsettings_fromall" name="emailsettings[fromall]" type="checkbox" value="1" />Everyone</div>
	  <div>
	    <input name="emailsettings[fromartist]" type="hidden" value="0" /><input checked="checked" id="emailsettings_fromartist" name="emailsettings[fromartist]" type="checkbox" value="1" />Registered MAU Artists
	  </div>
	</td>
	<td class="input-err" width="200">
	  Check these boxes if would like other registered MAU artists or any website visitors the ability to send you a note.
	</td>
      </tr>
    </table>
    <div class="buttons">
      <input id="artist_submit" name="commit" type="submit" value="Save Changes" />
      <input id="artist_submit" name="commit" type="submit" value="Cancel" />
    </div>
  </div>
</div>

<div class="open-close-div acct" ><span id="links_toggle" class="title">Links</span><span class="edit"><a href="#links" id="links_toggle_lnk">change</a></span></div>
<div class="edit-profile-sxn" id="links" style="display:none;">
  <div class="inner-sxn">
    <table class="entry-table">
      <tr>
	<td class="input-name"><label for="artist_url">Website</label></td>
	<td><input class="url-input" id="artist_url" name="artist[url]" size="30" type="text" value="flaminghakama.com" /></td>
	<td class="input-err"></td>
      </tr>
      <tr>
	<td class="input-name"><label for="artist_artist_info_facebook">Facebook</label></td>
	<td><input class="url-input" id="artist_artist_info_facebook" name="artist[artist_info[facebook]]" type="text" value="" /></td>
	<td class="input-err"></td>
      </tr>
      <tr>
	<td class="input-name"><label for="artist_artist_info_flickr">Flickr</label></td>
	<td><input class="url-input" id="artist_artist_info_flickr" name="artist[artist_info[flickr]]" type="text" value="" /></td>
	<td class="input-err"></td>
      </tr>
      <tr>
	<td class="input-name"><label for="artist_artist_info_twitter">Twitter</label></td>
	<td><input class="url-input" id="artist_artist_info_twitter" name="artist[artist_info[twitter]]" type="text" value="flaminghakama" /></td>
	<td class="input-err"></td>
      </tr>
      <tr>
	<td class="input-name"><label for="artist_artist_info_blog">Blog</label></td>
	<td><input class="url-input" id="artist_artist_info_blog" name="artist[artist_info[blog]]" type="text" value="" /></td>
	<td class="input-err"></td>
      </tr>
      <tr>
	<td class="input-name"><label for="artist_artist_info_myspace">MySpace</label></td>
	<td><input class="url-input" id="artist_artist_info_myspace" name="artist[artist_info[myspace]]" type="text" value="" /></td>
	<td class="input-err"></td>
      </tr>
    </table>
    <div  class="buttons">
      <input id="artist_submit" name="commit" type="submit" value="Save Changes" />
      <input id="artist_submit" name="commit" type="submit" value="Cancel" />
    </div>
  </div>
</div>

<div class='open-close-div acct'>
<span class='title' id='studio_info_toggle'>Address/Studio Info</span>
<span class='edit'>
<a href='#address' id='studio_info_toggle_lnk'>change</a>
</span>
</div>
<div class='edit-profile-sxn' id='address' style='display:none;'>
<div class='inner-sxn left'>
<div class='edit-table-header'>Studio</div>
<table class='entry-table'>
<tr>
<td class='input-name'>&nbsp;</td>
<td>
<select id="artist_studio_id" name="artist[studio_id]"><option value="0">None</option>
<option value="1" selected="selected">1890 Bryant St Studios</option>
<option value="2">ActivSpace</option>
<option value="20">Art, Wine and Dine Artists</option>
<option value="16">CELLspace (now Inner Mission?)</option>
<option value="4">Developing Environments</option>
<option value="24">Gallery del Grotto at Sports Basement</option>
<option value="21">Live Art Studios</option>
<option value="26">Melting Point Studios</option>
<option value="5">Project Artaud</option>
<option value="10">Red Brick Studio</option>
<option value="27">Root Division</option>
<option value="23">Secret Studios</option>
<option value="25">Studio 17</option>
<option value="12">Studio Valencia</option>
<option value="7">The Art Explosion 17th Street</option>
<option value="8">The Art Explosion Alabama</option>
<option value="9">The Art Explosion Harrison</option>
<option value="15">The Box Factory</option>
<option value="11">The SUB</option>
<option value="6">Workspace Limited</option>
<option value="0">Independent Studios</option></select>
</td>
<td class='input-err'></td>
</tr>
<tr class='studio-number-row'>
<td class='input-name'>Studio #</td>
<td>
<input id="artist_artist_info_studionumber" name="artist[artist_info[studionumber]]" type="text" value="313" />
</td>
</tr>
<td class='input-err'></td>
</table>
</div>
<div class='edit-table-header splitter'>(or)</div>
<div class='inner-sxn right'>
<div class='edit-table-header'>Address</div>
<table class='entry-table'>
<tr>
<td class='input-name'>Street</td>
1890 Bryant St., #313
<td>
<input id="artist_artist_info_street" name="artist[artist_info[street]" type="text" value="1890 Bryant St., #313" />
</td>
<td class='input-err'></td>
</tr>
<tr>
<td class='input-name'>City</td>
San Francisco
<td>
<input id="artist_artist_info_city" name="artist[artist_info[city]" type="text" value="San Francisco" />
</td>
<td class='input-err'></td>
</tr>
<tr>
<td class='input-name'>State</td>
CA
<td>
<input id="artist_artist_info_addr_state" name="artist[artist_info[addr_state]" type="text" value="CA" />
</td>
<td class='input-err'></td>
</tr>
<tr>
<td class='input-name'>ZIP</td>
94110
<td>
<input id="artist_artist_info_zip" name="artist[artist_info[zip]" type="text" value="94110" />
</td>
<td class='input-err'></td>
</tr>
</table>
</div>
<div class='clear'></div>
<div class='buttons'>
<input id="artist_submit" name="commit" type="submit" value="Save Changes" />
<input id="artist_submit" name="commit" type="submit" value="Cancel" />
</div>
</div>
<div class='open-close-div acct'>
<span class='title' id='bio_toggle'>Bio/Artist's Statement</span>
<span class='edit'>
<a href='#bio' id='bio_toggle_lnk'>change</a>
</span>
</div>
<div class='edit-profile-sxn' id='bio' style='display:none;'>
<div class='inner-sxn'>
<div class='title'>Artist's Bio:</div>
</div>
<div>
<textarea class="artist-bio" id="artist_artist_info_bio" name="artist[artist_info[bio]]">Flaming Hakama designs are rooted within the tradition of Japanese martial arts clothing. They ride the dialectical joys of elegance and simplicity, function and ceremony, and are offered in both custom and off-the-rack designs.&#x000A;&#x000A;Elaine executes Flaming Hakama's vibrations using modern construction, fabrics and design perks. Working with with superbly long lines, Flaming Hakama indulges traditional designs in gorgeous fabrics while designing clothes that facilitate motion.&#x000A;&#x000A;Authentic Hakama, Kimono, Haori and Obi are complimented by original Motion Pants and accessories to furnish complete outfits for martial arts practice, or to be dressed to kill.</textarea>
<div class='input-help'>Please avoid html tags and any fancy formatting.  Newlines will be preserved.</div>
</div>
<div class='buttons'>
<input id="artist_submit" name="commit" type="submit" value="Save Changes" />
<input id="artist_submit" name="commit" type="submit" value="Cancel" />
</div>
</div>
</form>
<div class="open-close-div acct" ><span id="passwd_toggle" class="title">Password</span><span class="edit"><a href="#passwd" id="passwd_toggle_lnk">change</a></span></div>
<form action="/change_password_update" method="post"><div style="margin:0;padding:0;display:inline"><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="BgdspGQJ/OT9YTxuA+R4Qi+GCsVzUA3X3j9zG8P6MQk=" /></div><div  class="edit-profile-sxn" id="passwd" style="display:none;">
  <div class="inner-sxn">
    <table class="entry-table">
      <tr>
	<td colspan="3" align="center">
	  <div class="chpasswd-instructions">
	    <ul>
	      <li>Do not use the same password that you use for other online accounts.</li>
	      <li>Your new password must be at least 6 characters in length.</li>
	      <li>Use a combination of letters, numbers, and punctuation.</li>
	      <li>Passwords are case-sensitive. Remember to check your CAPS lock key.</li>
	    </ul>
	  </div>
	</td>
      </tr>
      <tr>
        <td class="input-name" width="224">Old Password</td>
        <td class="input" width="179"><input class="text" id="old_password" name="old_password" size="45" type="password" /></td>
        <td class="input-err" width="149">&nbsp;</td>
      </tr>
      <tr>
        <td class="input-name">New Password</td>
        <td class="input"><input class="text" id="password" name="password" size="45" type="password" value="" /></td>
        <td class="input-err input-help">between 6 and 40 characters </td>
      </tr>
      <tr>
        <td class="input-name">Confirm new password</td>
        <td class="input"><input class="text" id="password_confirmation" name="password_confirmation" size="45" type="password" value="" /></td>
        <td class="input-err">&nbsp;</td>
      </tr>
      <tr>
        <td class="input-name">&nbsp;</td>
        <td class="input"><input name="commit" type="submit" value="Change password" /> 
	  <input class="formbutton" type="button" value="Cancel" onclick="MAU.goToArtist( 283);"/></td>
        <td class="input-err">&nbsp;</td>
      </tr>
    </table>
  </div>
</div>
</form>
<div class="open-close-div acct"><span id="deactivate_toggle" class="title">Deactivate Account</span><span class="edit"><a href="#deactivate" id="deactivate_toggle_lnk">change</a></span></div>
<div  class="edit-profile-sxn" id="deactivate" style="display:none;">
  <div class="inner-sxn">
    <table class="entry-table">
      <tr>
	<td align="center">
	  <div class="error-msg">
	    This action is permanent.  If you deactivate your account, all data associated with that user will no longer be available.</div>
	</td>
      </tr>
      <tr>
	<td class="td-center"><a onclick="return confirm('This action is permanent.\nAre you sure you want to deactivate your account?');" href="/users/deactivate/283"><button class="formbutton">Deactivate Me</button></a></td>
      </tr>
    </table>
  </div>
</div>

</div>
<div class='edit-buttons'>
<a href="/art_pieces/new">Upload some of your art to share with the world!</a>
</div>
</div>

</td>
</tr>
</table>

<!-- END Edit member info -->


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
