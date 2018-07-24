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
nyarukoWSGPHead();
// add_action("admin_head","nyarukoWSGPHead");
function nyarukoWSGPpostlistblock($indexint) {
    ?>
    <div id="blockbdiv<?php echo $indexint ?>" class="blockbdiv" onclick="blockbdivclick(<?php echo "'".$indexint."','"; the_permalink(); echo "'"; ?>)" onmouseover="blockbdivblur(<?php echo $indexint ?>)" onmouseout="blockbdivfocus(<?php echo $indexint ?>)">
      <div name="blocktopdiv" id="blocktopdiv<?php echo $indexint ?>" class="blocktopdiv">
        <img name="blocktopimg" id="blocktopimg<?php echo $indexint ?>" src="<?php 
          $itemimage = catch_that_image();
          if ($itemimage == "") {
            bloginfo("template_url");
            echo "/images/default.jpg";
          } else {
            echo $itemimage;
          }
          ?>" alt="<?php the_title(); ?>" />
          <?php $category = end(get_the_category()); 
          $cid = $category->term_id;
          echo $cid;
          ?>
          <div class="topline"><?php the_time('Y-m-d') ?>&nbsp;</div>
          <div class="toptags"><?php echo '<a href="'.get_category_link($cid).'">'.$category->cat_name.'</a>'; ?></div>
      </div>
      <div class="blockbottomdiv">
        <div class="bottomtitle"><?php the_title(); ?></div>
        <div class="bottomcontent"><?php the_excerpt(); ?></div>
      </div>
    </div>
    <?php
}
function nyarukoWSGPmetabox() {
    return array(
        "nya_wsgp_freeshipping" => array(
          "name" => "_nya_wsgp_freeshipping",
          "std" => "包邮",
          "title" => "包邮：（不填字隐藏）"),
        "nya_wsgp_price" => array(
          "name" => "_nya_wsgp_price",
          "std" => "0.00",
          "title" => "原价："),
        "nya_wsgp_concessionary" => array(
          "name" => "_nya_wsgp_concessionary",
          "std" => "0.00",
          "title" => "优惠后价："),
        "nya_wsgp_pre" => array(
          "name" => "_nya_wsgp_pre",
          "std" => "0.00",
          "title" => "优惠力度："),
        "nya_wsgp_cnum" => array(
          "name" => "_nya_wsgp_cnum",
          "std" => "0",
          "title" => "优惠券数量："),
        "nya_wsgp_salesvol" => array(
          "name" => "_nya_wsgp_salesvol",
          "std" => "0",
          "title" => "销量："),
        "nya_wsgp_url" => array(
          "name" => "_nya_wsgp_url",
          "std" => "http://",
          "title" => "购买/领劵地址：")
    );
}
?>