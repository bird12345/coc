<?php

// replacements for Wordpress functions
require_once('settings.php');
//require_once('flintstone.class.php');

require('vendor/autoload.php');
use Flintstone\Flintstone;

function update_option($key, $value = '')
{
	Flintstone::load('settings', array('dir' => PLUGIN_DIR . "/db/"))->set($key, $value);
}

function delete_option($key)
{
	Flintstone::load('settings', array('dir' => PLUGIN_DIR . "/db/"))->delete($key);
}

function get_option($key)
{
	$value = Flintstone::load('settings', array('dir' => PLUGIN_DIR . "/db/"))->get($key);
	return $value;
}

function add_action($tag, $func, $priority=0)
{
}

function add_options_page($page_title, $menu_title, $capability, $menu_slug, $callback = '')
{
}

function get_post_data($key)
{
	return isset($_POST[$key]) ? $_POST[$key] : '';
}

function is_admin()
{
	return false;
}

function is_home()
{	
	$uri = $_SERVER['SCRIPT_NAME'];
	
	if ((strpos($uri, "index") !== false) || (substr($uri, -1) == '/')) return true; else return false;
}

function is_front_page()
{
	return is_home();
}

function echo_db()
{
	$db = new Flintstone(array('dir' => PLUGIN_DIR . "/db/"));
	$keys = $db->load('settings')->getKeys();
	print_r($keys);
	die("done");
}
?>