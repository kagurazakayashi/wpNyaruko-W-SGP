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

          <?php $category = get_the_category(); //反馈回W
          $category = end($category); 
          $cid = $category->term_id;
          echo $cid;
          ?>
          <div class="topline"><?php the_time('Y-m-d') ?>&nbsp;</div>
          <div class="toptags"><?php echo '<a href="'.get_category_link($cid).'">'.$category->cat_name.'</a>'; ?></div>
      </div>
      <div class="blockbottomdiv">
        <?php 
        $nya_wsgp_freeshipping = get_post_meta($cid, '_nya_wsgp_freeshipping_value', true); //包邮
        $nya_wsgp_price = round(floatval(get_post_meta($cid, '_nya_wsgp_price_value', true)),2); //原价
        $nya_wsgp_pre = round(floatval(get_post_meta($cid, '_nya_wsgp_pre_value', true)),2); //优惠力度
        $nya_wsgp_concessionary = round(($nya_wsgp_price - $nya_wsgp_pre),2); //round(floatval(get_post_meta($cid, '_nya_wsgp_concessionary_value', true)),2); //优惠后价
        $nya_wsgp_cnum = intval(get_post_meta($cid, '_nya_wsgp_cnum_value', true)); //优惠券数量
        $nya_wsgp_salesvol = intval(get_post_meta($cid, '_nya_wsgp_salesvol_value', true)); //销量
        $nya_wsgp_url = get_post_meta($cid, '_nya_wsgp_url_value', true); //地址
        $isconcessionary = false;
        if ($nya_wsgp_price > $nya_wsgp_concessionary) {
            $isconcessionary = true;
        }
        ?>
        <p><span class="nya_wsgp_qrbox">
            <span class="nya_wsgp_qr">二维码预留<br/>二维码预留<br/>二维码预留<br/>二维码预留</span>
            <span class="nya_wsgp_qrboxinfo">手机扫码或保<br/>存到相册识别</span>
        </span></p>
        <div class="nya_wsgp_title"><p><?php the_title(); ?></p></div>
        <!-- <div class="bottomcontent"><?php the_excerpt(); ?></div> -->
        <?php
        if ($nya_wsgp_freeshipping != "") {
            echo '<div class="nya_wsgp_freeshipping"><span>'.$nya_wsgp_freeshipping.'</span></div>';
        }
        ?>
        <br/><span class="nya_wsgp_freeshipping_s">￥</span><span class="nya_wsgp_freeshipping_l"><?php
        echo sprintf("%.2f",$nya_wsgp_concessionary);
        ?></span><?php
        if ($isconcessionary) echo '<span class="nya_wsgp_freeshipping_s">券后价&emsp;</span><span class="nya_wsgp_freeshipping_oldp">￥'.sprintf("%.2f",$nya_wsgp_price).'</span>';
        ?><br/><?php
        if ($isconcessionary) echo '<span class="nya_wsgp_cnum nya_wsgp_cnuma">&nbsp;券&nbsp;</span><span class="nya_wsgp_cnum nya_wsgp_cnumb">&nbsp;￥'.sprintf("%.2f",$nya_wsgp_pre).'&nbsp;</span>&emsp;';
        ?><span class="nya_wsgp_salesvol">销量:<?php echo $nya_wsgp_salesvol; ?></span>
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