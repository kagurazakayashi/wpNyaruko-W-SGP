<?php
/**
 * @package wpNyaruko-W-SGP
 * @version 0.1
 */
/*
Plugin Name: wpNyaruko-W-SGP
Plugin URI: https://github.com/kagurazakayashi/wpNyaruko-W-SGP
Description: 用于 wpNyaruko-W 主题的扩展包，让网站变成导购商城。
Version: 0.1
Author: 神楽坂雅詩
Author URI: https://github.com/kagurazakayashi
Text Domain: wpNyaruko-W-SGP
*/
define("NYARUKOWSGP_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("NYARUKOWSGP_FULL_DIR", plugin_dir_path( __FILE__ ));
define("NYARUKOWSGP_TEXT_DOMAIN", "nyarukowsgp");
define("NYARUKOWSGP_RANDOM_CHAR", "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
function nyarukoWSGPHead() {
    $plugindir = plugins_url('',__FILE__);
    echo '<link href="'.NYARUKOWSGP_PLUGIN_URL.'/nyarukowsgp.css" rel="stylesheet">';
    echo '<script type="text/javascript" src="'.NYARUKOWSGP_PLUGIN_URL.'/nyarukowsgp.js"></script>';
}
add_action("admin_head","nyarukoWSGPHead");
function nyarukoWSGPpostlistblock($indexint) {
    echo "plug_wsgp_installed".$indexint;
}
?>