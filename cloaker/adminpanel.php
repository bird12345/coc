<?php

require_once('defines.php');
require_once('core.php');

function wpcloaker_processlist($thelist)
{
	$s = "";
	$items = explode("\n", $thelist);
	foreach ($items as $item) {
		if (trim($item) != "")
			$s .= trim($item) . "\n";
	}

	return trim($s);
}

function wpcloaker_processcheckbox($val)
{
//	return isset($val) ? "on" : "off";
	return ($val == '') ? "off" : "on";
}

function wpcloaker_upgrade()
{
	update_option('wpcloaker_version', WPCLOAKER_VERSION);

	delete_option('wpcloaker_ipupdate');
	delete_option('wpcloker_ipupdate');
	delete_option('wpcloker_ipversion');

	// delete IP lists previously stored in wordpress database
	$SElist = array('google', 'inktomi', 'lycos', 'msn', 'altavista', 'wisenut', 'askjeeves', 'misc', 'non_engines');
	foreach ($SElist as $option) {
		delete_option('wpcloaker_' . $option);
	}
}

function wpcloaker_options() {

	if(get_post_data('save')){
		update_option('wpcloaker_page', trim(get_post_data('landingpage')));
		update_option('wpcloaker_method', get_post_data('method'));
		update_option('wpcloaker_spiderid', get_post_data('spiderid'));
		update_option('wpcloaker_reversedns', wpcloaker_processcheckbox(get_post_data('reversedns')));
		update_option('wpcloaker_speedppcdki', wpcloaker_processlist(trim(get_post_data('speedppcdki'))));
		update_option('wpcloaker_ualist', wpcloaker_processlist(trim(get_post_data('ualist'))));
		update_option('wpcloaker_basehref', trim(get_post_data('basehref')));

		update_option('wpcloaker_customlandinglist', wpcloaker_processlist(trim(get_post_data('customlandinglist'))));
		update_option('wpcloaker_donotcloaklist', wpcloaker_processlist(trim(get_post_data('donotcloaklist'))));
		update_option('wpcloaker_referrerlist', wpcloaker_processlist(trim(get_post_data('referrerlist'))));
		update_option('wpcloaker_langlist', wpcloaker_processlist(trim(get_post_data('langlist'))));
		update_option('wpcloaker_geoipcountrylist', wpcloaker_processlist(trim(get_post_data('geoipcountrylist'))));
		update_option('wpcloaker_customlist', wpcloaker_processlist(trim(get_post_data('customlist'))));
		update_option('wpcloaker_excludelist', wpcloaker_processlist(trim(get_post_data('excludelist'))));
		update_option('wpcloaker_suckerlist', wpcloaker_processlist(trim(get_post_data('suckerlist'))));
		update_option('wpcloaker_suckerurl', trim(get_post_data('suckerurl')));

		update_option('wpcloaker_cookie', wpcloaker_processcheckbox(get_post_data('cookie')));
		update_option('wpcloaker_excludehome', wpcloaker_processcheckbox(get_post_data('excludehome')));
		update_option('wpcloaker_onlyhome', wpcloaker_processcheckbox(get_post_data('onlyhome')));
		update_option('wpcloaker_ieblankreferrer', wpcloaker_processcheckbox(get_post_data('ieblankreferrer')));

		update_option('wpcloaker_passthroughreferrerparams', trim(get_post_data('referrerparams')));
		
		update_option('wpcloaker_filterproxytraffic', wpcloaker_processcheckbox(get_post_data('filterproxytraffic')));
		update_option('wpcloaker_filterblankref', wpcloaker_processcheckbox(get_post_data('filterblankref')));
		update_option('wpcloaker_filterreferrerlist', wpcloaker_processlist(trim(get_post_data('filterreferrerlist'))));

		update_option('wpcloaker_onlycloakN', trim(get_post_data('onlycloakN')));

		if (wpcloaker_processcheckbox(get_post_data('resetcloak')) == 'on') {
			update_option('wpcloaker_N', '0');
		}

		echo '<div class="updated"><p>Landing Page saved successfully @ ' .date("Y-m-d H:i:s T") .'</p></div>';
	}

	// initiatize the plugin parameters
	if (get_option('wpcloaker_init') == 0) {
		update_option('wpcloaker_page', '');
		update_option('wpcloaker_method', WPCLOAKER_CLOAK);
		update_option('wpcloaker_spiderid', WPCLOAKER_IP);
		update_option('wpcloaker_reversedns', 'off');
		update_option('wpcloaker_speedppcdki', '');
		update_option('wpcloaker_ualist', "goog\nbot\nslurp\nyahoo\nbing\nmsn\nscooter\ncrawler\nmedia");
		update_option('wpcloaker_basehref', '');

		update_option('wpcloaker_customlandinglist', '');
		update_option('wpcloaker_donotcloaklist', '');
		update_option('wpcloaker_referrerlist', '');
		update_option('wpcloaker_langlist', '');
		update_option('wpcloaker_geoipcountrylist', '');
		update_option('wpcloaker_customlist', '');
		update_option('wpcloaker_excludelist', '');
		update_option('wpcloaker_suckerlist', '');
		update_option('wpcloaker_suckerurl', '');

		update_option('wpcloaker_cookie', 'on');
		update_option('wpcloaker_excludehome', 'off');
		update_option('wpcloaker_onlyhome', 'off');
		update_option('wpcloaker_ieblankreferrer', 'off');
		update_option('wpcloaker_init', 1);

		update_option('wpcloaker_passthroughreferrerparams', '');

		update_option('wpcloaker_filterproxytraffic', 'on');
		update_option('wpcloaker_filterblankref', 'off');
		update_option('wpcloaker_filterreferrerlist', '');

		update_option('wpcloaker_onlycloakN', '');
		update_option('wpcloaker_N', '0');
	}

	if (strcmp(WPCLOAKER_VERSION, get_option('wpcloaker_version')) != 0) {
		wpcloaker_upgrade();
	}

	$wpcloaker_method = get_option('wpcloaker_method');
	$wpcloaker_spiderid = get_option('wpcloaker_spiderid');
?>
<style type="text/css">
html {
	overflow-Y: scroll;
}

*, * focus {
	outline: none;
	margin: 0;
	padding: 0;
}

table {
	border-spacing: 0 20px;
}
th {
	text-align: right;
	padding-right: 20px;
}

fieldset.main-options {
	border: 1px solid black;
}
legend {
	margin-left: 10px;
	padding-left: 10px;
	padding-right: 10px;
}
.helptext {
	font-style: italic;
	font-weight: normal;
	font-size: small;
}

#matchdns_option {
	padding-left: 20px;
	display: none;
}


h1 {
	font: 4em normal Georgia, 'Times New Roman', Times, serif;
	text-align:center;
	padding: 20px 0;
	color: #aaa;
}
h1 span { color: #666; }
h1 small{
	font: 0.3em normal Verdana, Arial, Helvetica, sans-serif;
	text-transform:uppercase;
	letter-spacing: 1.5em;
	display: block;
	color: #666;
}
h2.trigger {
	padding: 0 0 0 50px;
	margin: 0 0 5px 0;
	background: url(h2_trigger_a.gif) no-repeat;
	height: 46px;
	line-height: 46px;
	width: 450px;
	font-size: 2em;
	font-weight: normal;
	float: left;
}
h2.trigger a {
	color: #fff;
	text-decoration: none;
	display: block;
}
h2.trigger a:hover {
	color: #ccc;
}
h2.active {background-position: left bottom;}
.toggle_container {
	margin: 0 0 5px;
	padding: 0;
	border-top: 1px solid #d6d6d6;
	background: #f0f0f0 url(toggle_block_stretch.gif) repeat-y left top;
	overflow: hidden;
	font-size: 1.2em;
	width: 500px;
	clear: both;
}
.toggle_container .block {
	padding: 10px;
	background: url(toggle_block_btm.gif) no-repeat left bottom;
}
.toggle_container .block p {
	padding: 5px 0;
	margin: 5px 0;
}
.toggle_container h3 {
	font: 2.5em normal Georgia, "Times New Roman", Times, serif;
	margin: 0 0 10px;
	padding: 0 0 5px 0;
	border-bottom: 1px dashed #ccc;
}
.toggle_container img {
	float: left;
	margin: 10px 15px 15px 0;
	padding: 5px;
	background: #ddd;
	border: 1px solid #ccc;
}

</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$(".toggle_container").hide();

	$("h2.trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("slow");
	});

});
</script>

	<?php echo '<div class="updated" style="display: none;"></div>'; ?>

	<div class="wrap">
	<form method="post" id="wpcloaker_options">
		<h2>WP Cloaker Options - version <?php echo WPCLOAKER_VERSION; ?></h2>
		<table width="100%" class="editform">
			<tr valign="top">
				<th width="25%" scope="row">Landing Page:<br />
				<span class="helptext">Default landing page for cloaking and redirecting.</span>
				</th>
				<td><input name="landingpage" type="text" id="wpcloaker_page" value="<?php echo stripslashes(get_option('wpcloaker_page')); ?>" size="100" /></td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Cloak Traffic<br />That Matches:<br />
				<span class="helptext">Chooses "when" to cloak.</span>
				</th>
				<td>
				<select name="spiderid">
					<option value="0" <?php if ($wpcloaker_spiderid == WPCLOAKER_IP) echo ' selected'; ?> >IP List</option>;
					<option value="1" <?php if ($wpcloaker_spiderid == WPCLOAKER_UA) echo ' selected'; ?> >User Agent</option>;
					<option value="3" <?php if ($wpcloaker_spiderid == WPCLOAKER_REFERRER) echo ' selected'; ?> >Referrer</option>;
					<option value="2" <?php if ($wpcloaker_spiderid == WPCLOAKER_IP_UA) echo ' selected'; ?> >IP + UA</option>;
					<option value="6" <?php if ($wpcloaker_spiderid == WPCLOAKER_IP_UA_REFERRER) echo ' selected'; ?> >IP + UA + Referrer</option>;
					<option value="4" <?php if ($wpcloaker_spiderid == WPCLOAKER_LANG) echo ' selected'; ?> >Language Code</option>;
					<option value="5" <?php if ($wpcloaker_spiderid == WPCLOAKER_GEOIP_COUNTRY) echo ' selected'; ?> >GeoIP Country</option>;
					<option value="8" <?php if ($wpcloaker_spiderid == WPCLOAKER_IP_GEOIP) echo ' selected'; ?> >IP + GeoIP</option>;
					<option value="7" <?php if ($wpcloaker_spiderid == WPCLOAKER_ALWAYS_CLOAK) echo ' selected'; ?> >Always Cloak</option>;
				</select>
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Action:<br />
				<span class="helptext">Chooses how the landing page is delivered</span>
				</th>
				<td>
				<select id="id_cloak_options" name="method">
					<option value="0" <?php if ($wpcloaker_method == WPCLOAKER_CLOAK) echo ' selected'; ?> >Cloak URL</option>;
					<option value="1" <?php if ($wpcloaker_method == WPCLOAKER_REDIRECT) echo ' selected'; ?> >Redirect to Landing Page</option>;
					<option value="3" <?php if ($wpcloaker_method == WPCLOAKER_FRAME) echo ' selected'; ?> >Frame Landing Page</option>;
					<option value="2" <?php if ($wpcloaker_method == WPCLOAKER_NONE) echo ' selected'; ?> >Do Not Cloak</option>;
				</select>
				<span id="matchdns_option">
					<label><strong>Drop Cookie: </strong></label>
					<input name="cookie" type="checkbox" id="wpcloaker_cookie" value="on" <?php if (get_option('wpcloaker_cookie') == 'on') echo " checked=\"on\""; ?> />					
					<span class="helptext">(Cookie stuff landing page URL)</span>
				</span>

				</td>
			</tr>
		
			<script type="text/javascript">
			$("#id_cloak_options").bind('change', function () {
				 if($(this).val() === '0') {
						$("#matchdns_option").show();
				 } else {
						$("#matchdns_option").hide();
				 }
			});
			</script>

			<tr valign="top">
				<th width="25%" scope="row">Match Reverse DNS:</th>
				<td>
				<input name="reversedns" type="checkbox" id="wpcloaker_reversedns" value="on" <?php if (get_option('wpcloaker_reversedns') == 'on') echo " checked=\"on\""; ?> />
				<br />Do a reverse DNS match to verify spider visit from Google, Yahoo, or MSN/Live. NOTE: Reverse DNS lookups can severely slow down the serving of the page.
				</td>
			</tr>
		</table>
		
		<h2>Filters</h2>
		<table width="100%" class="editform">
			<tr valign="top">
				<th width="25%" scope="row">Do Not Cloak Homepage:</th>
				<td>
				<input name="excludehome" type="checkbox" id="wpcloaker_excludehome" value="off" <?php if (get_option('wpcloaker_excludehome') == 'on') echo " checked=\"on\""; ?> />
				<br />When selected, the homepage of the blog will always be shown.
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">ONLY Cloak Homepage:</th>
				<td>
				<input name="onlyhome" type="checkbox" id="wpcloaker_onlyhome" value="off" <?php if (get_option('wpcloaker_onlyhome') == 'on') echo " checked=\"on\""; ?> />
				<br />When selected, ONLY the homepage of the blog will be cloaked. Everything else will be shown as-is.
				</td>
			</tr>

			<!--
			<tr valign="top">
				<th width="25%" scope="row">RESET cloak counter:</th>
				<td>
				<input name="resetcloak" type="checkbox" id="wpcloaker_resetcloak" value="off" <?php if (get_option('wpcloaker_resetcloak') == 'on') echo " checked=\"on\""; ?> />
				<br />When selected, Set the number of times cloaking has happened to 0. <em>(wpCloaker already cloaked <?php echo get_option('wpcloaker_N'); ?> times)</em>.
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">ONLY Cloak N Times:</th>
				<td>
				<input name="onlycloakN" type="text" id="wpcloaker_onlycloakN" value="<?php echo get_option('wpcloaker_onlycloakN'); ?>" />
				<br />When selected, Cloaking will happen only N times. After that the normal page will ALWAYS be shown. Leave this field blank to not worry about limiting the number of times to cloak.
				</td>
			</tr>
			-->
			
			<tr valign="top">
				<th width="25%" scope="row">Do Not Cloak Proxy Traffic:</th>
				<td>
				<input name="filterproxytraffic" type="checkbox" id="wpcloaker_filterproxytraffic" value="on" <?php if (get_option('wpcloaker_filterproxytraffic') == 'on') echo " checked=\"on\""; ?> />
				<br />When selected, traffic from proxies, load balancers, etc. is not cloaked.
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Do Not Cloak Traffic With Blank Referrer:</th>
				<td>
				<input name="filterblankref" type="checkbox" id="wpcloaker_filterblankref" value="off" <?php if (get_option('wpcloaker_filterblankref') == 'on') echo " checked=\"on\""; ?> />
				<br />When selected, traffic with a blank referrer is not cloaked.
				</td>
			</tr>
			
			<tr valign="top">
				<th width="25%" scope="row">Do Not Cloak Referrer List:</th>
				<td>
				<textarea name="filterreferrerlist" cols="80" rows="7"><?php echo get_option('wpcloaker_filterreferrerlist'); ?></textarea>
				<br />List of referrer patterns you DO NOT want to cloak. For example, if traffic comes in with a referrer that includes "partner.facebook.com" you may may choose to never cloak this traffic and pass it through to your normal page. The format for each line is a pattern to match against the referrer and need not contain the entire string of the referrer.</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Cloak all Internet Explorer<br />traffic with BLANK referrer</th>
				<td>
				<input name="ieblankreferrer" type="checkbox" id="wpcloaker_onlyhome" value="off" <?php if (get_option('wpcloaker_ieblankreferrer') == 'on') echo " checked=\"on\""; ?> />
				<br />When selected, traffic from Internet Explorer without a referrer will be shown the landing page. This is useful for referrer cloaking on sites like pinterest.com.
				</td>
			</tr>

		</table>

		<h2>Advanced Options</h2>		
		<table width="100%" class="editform">
			<tr valign="top">
				<th width="25%" scope="row">Passthrough Referrer Parameters:</th>
				<td><input name="referrerparams" type="text" id="wpcloaker_passthroughreferrerparams" value="<?php echo get_option('wpcloaker_passthroughreferrerparams'); ?>" size="40" />
				<br />This is a comma separated list of parameters expected in the HTTP REFERRER. The parameters and values will be passed through to the landing page. This is useful for example in passing the keyword from an organic search using Bing ('q') or Yahoo ('p'). NOTE: Google uses secure HTTP and *does not* pass the keyword searched for in the referrer. It is NOT possible any longer to detect the searched for keyword in Google.</td>
			</tr>
			

			<tr valign="top">
				<th width="25%" scope="row">SpeedPPC Dynamic Keyword Insertion (DKI):</th>
				<td>
				<textarea name="speedppcdki" cols="40" rows="7"><?php echo get_option('wpcloaker_speedppcdki'); ?></textarea>
				<br />If you are using a dynamic keyword insertion plugin like SpeedPPC's we will pass through the extra URL segments to your landing page. On each line include the *FINAL* URL segment of the normal page or post you would like us to parse and passthrough. For example, if your normal page is at /lander123 then you'd enter 'lander123' (no quotes) on a line above. When the user clicks on an ad and visits /lander123/Diet/Green/Smoothie we will pass the added segments (/Diet/Green/Smoothie) to the landing money page. If your normal page was at /dogs/dog-vitamins you would enter 'dog-vitamins'. NOTE: usage of this features REQUIRES you have DKI set up properly. We are only passing URL segments through. Nothing more.</td>
			</tr>
			
			<tr valign="top">
				<th width="25%" scope="row">User Agents:</th>
				<td>
				<textarea name="ualist" cols="40" rows="7"><?php echo get_option('wpcloaker_ualist'); ?></textarea>
				<br />Sets the list for UserAgent cloaking. This is a case insensitive match and need
				not contain the entire UserAgent string -- just an identifying pattern.</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Custom Landing Page List:</th>
				<td>
				<textarea name="customlandinglist" cols="80" rows="7"><?php echo get_option('wpcloaker_customlandinglist'); ?></textarea>
				<br />Sets the list for Custom Landing Pages. This is a case insensitive match and need
				not contain the entire page url string -- just an identifying pattern. The format for each line is pattern->url|basehref|titletag. The basehref and titletag is optional. So for example, if you wanted
				to cloak/redirect traffic to the page /insurance/10-ways-to-save-on-auto-insurance to http://www.geico.com you would make a line:<strong>
				auto-insurance->http://www.geico.com</strong>. If you wanted to include a basehref then it would be <strong>auto insurance->http://geico.com|http://geico.com</strong>. If you wanted to change the title tag of the page to 'Geico' you would use <strong>auto insurance->http://geico.com|http://geico.com|Geico</strong></td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Do Not Cloak URL List:</th>
				<td>
				<textarea name="donotcloaklist" cols="40" rows="7"><?php echo get_option('wpcloaker_donotcloaklist'); ?></textarea>
				<br />Sets the list for NOT cloaking. This is a case insensitive match and need
				not contain the entire page url string -- just an identifying pattern. The format for each line is pattern. So for example, if you wanted
				to not cloak/redirect traffic to the page /general/buy-garmin-c330-now-and-save-40-percent you could make a line:<strong>
				garmin-c330</strong></td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Referrer Cloaking List:</th>
				<td>
				<textarea name="referrerlist" cols="80" rows="7"><?php echo get_option('wpcloaker_referrerlist'); ?></textarea>
				<br />Sets the list for Referrer cloaking. This is a case insensitive match and need
				not contain the entire Referrer string -- just an identifying pattern. The format for each line is pattern->url|basehef|titletag. The base href and titletag is optional. So for example, if you wanted
				to cloak/redirect search engine traffic coming from a search for the word 'widget' to http://www.mywidgets.com you would make a line:<strong>
				widget->http://www.mywidgets.com</strong>. If you wanted to include a basehref then it would be <strong>widget->http://geico.com|http://geico.com</strong>, for example. If you wanted to change the title tag of the page to 'Geico' you would use <strong>auto insurance->http://geico.com|http://geico.com|Geico</strong>. 
				NOTE: If you just list the referrer pattern and do not include the URL we will use the landing page and custom landing page settings.</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">GeoIP Country List:</th>
				<td>
				<textarea name="geoipcountrylist" cols="80" rows="7"><?php echo get_option('wpcloaker_geoipcountrylist'); ?></textarea>
				<br />Sets the list for geoip cloaking by country. The format for each line is 'country code->url|basehref|titletag', where 'country code' is the two letter international country code (e.g. 'US'). The basehref and titletag is optional. So for example, if you wanted
				to cloak/redirect traffic coming from spain to http://es.mywidgets.com you would make a line:<strong>
				es->http://es.mywidgets.com</strong>. If you wanted to include a basehref then it would be <strong>es->http://geico.com|http://geico.com</strong> for example. If you wanted to change the title tag of the page to 'Geico' you would use <strong>auto insurance->http://geico.com|http://geico.com|Geico</strong>. Country code 'XX' is special and is the defaut country code. If there is no match to the other country codes then the destination URL for XX will be used (e.g. xx->http://bing.com). If there is NO MATCH for the geoip country then the page will NOT be cloaked unless you use the default country code. NOTE: if you just list the country code and no URL then we will use the landing page and the custom landing page settings.
				</td>
			</tr>


			<tr valign="top">
				<th width="25%" scope="row">Language List:</th>
				<td>
				<textarea name="langlist" cols="80" rows="7"><?php echo get_option('wpcloaker_langlist'); ?></textarea>
				<br />Sets the list for Language cloaking. The format for each line is 'language code->url|basehref|titletag'. The basehref and titletag is optional. So for example, if you wanted
				to cloak/redirect traffic coming from spain to http://es.mywidgets.com you would make a line:<strong>
				es->http://es.mywidgets.com</strong>. If you wanted to include a basehref then it would be <strong>es->http://geico.com|http://geico.com</strong> for example. If you wanted to change the title tag of the page to 'Geico' you would use <strong>auto insurance->http://geico.com|http://geico.com|Geico</strong>.
				You have to use the two character language code.</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Custom Spider List:</th>
				<td>
				<textarea name="customlist" cols="40" rows="7"><?php echo get_option('wpcloaker_customlist'); ?></textarea>
				<br />Sets the custom list of ip addresses you want to cloak/redirect. Among other things, this is useful for local testing. You can comment a line out by starting the line with a '#' character.
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Exclude List:</th>
				<td>
				<textarea name="excludelist" cols="40" rows="7"><?php echo get_option('wpcloaker_excludelist'); ?></textarea>
				<br />Sets the list of ip addresses you want to NEVER cloak/redirect. Traffic from these ip addresses will always be shown the normal page and never the landing page.
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Sucker List:</th>
				<td>
				<textarea name="suckerlist" cols="40" rows="7"><?php echo get_option('wpcloaker_suckerlist'); ?></textarea>
				<br />Sets the list of "sucker" ip addresses. Traffic from these ip addresses will always be redirected to the sucker url. If the sucker url is empty, traffic is directed as if the cloaking method is set to NONE.
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Sucker URL:</th>
				<td><input name="suckerurl" type="text" id="wpcloaker_basehref" value="<?php echo get_option('wpcloaker_suckerurl'); ?>" size="80" />
				<br />Sets the sucker url
				</td>
			</tr>

			<tr valign="top">
				<th width="25%" scope="row">Custom Base HREF tag:</th>
				<td><input name="basehref" type="text" id="wpcloaker_basehref" value="<?php echo get_option('wpcloaker_basehref'); ?>" size="80" />
				<br />Sets the custom BASEHREF tag (if needed)</td>
			</tr>

		</table>
		<p class="submit"><input type="submit" name="save" value="Save" /></p>
	</form>
	<p style="color: grey;">wpCloaker version <?php echo WPCLOAKER_VERSION; ?></p>
	</div>
<?php
}

function wpcloaker_adminmenu(){
	add_options_page('WPCloaker Options', 'WPCloaker', 2, 'wpcloaker.php', 'wpcloaker_options');
}

add_action('admin_menu','wpcloaker_adminmenu',1);
add_action('template_redirect', 'wpcloaker_process', 1); // explicitly set priority so other plugins like WPCustomCategoryPages don't get their template_redirect() called

?>