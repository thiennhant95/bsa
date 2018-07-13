<?php
/**
 * Theme Functions
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */


define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'betheme' );
define( 'THEME_VERSION', '17.6' );

define( 'LIBS_DIR', THEME_DIR. '/functions' );
define( 'LIBS_URI', THEME_URI. '/functions' );
define( 'LANG_DIR', THEME_DIR. '/languages' );

add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );


/* ---------------------------------------------------------------------------
 * White Label
 * IMPORTANT: We recommend the use of Child Theme to change this
 * --------------------------------------------------------------------------- */
defined( 'WHITE_LABEL' ) or define( 'WHITE_LABEL', false );


/* ---------------------------------------------------------------------------
 * Loads Theme Textdomain
 * --------------------------------------------------------------------------- */
load_theme_textdomain( 'betheme',  LANG_DIR );
load_theme_textdomain( 'mfn-opts', LANG_DIR );


/* ---------------------------------------------------------------------------
 * Loads the Options Panel
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_admin_scripts' ) )
{
	function mfn_admin_scripts() {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
}   
add_action( 'wp_enqueue_scripts', 'mfn_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'mfn_admin_scripts' );
	
require( THEME_DIR .'/muffin-options/theme-options.php' );

$theme_disable = mfn_opts_get( 'theme-disable' );


/* ---------------------------------------------------------------------------
 * Loads Theme Functions
 * --------------------------------------------------------------------------- */

// Functions ------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-functions.php' );

// Header ---------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-head.php' );

// Menu -----------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-menu.php' );
if( ! isset( $theme_disable['mega-menu'] ) ){
	require_once( LIBS_DIR .'/theme-mega-menu.php' );
}

// Muffin Builder -------------------------------------------------------------
require_once( LIBS_DIR .'/builder/fields.php' );
require_once( LIBS_DIR .'/builder/back.php' );
require_once( LIBS_DIR .'/builder/front.php' );

// Custom post types ----------------------------------------------------------
$post_types_disable = mfn_opts_get( 'post-type-disable' );

if( ! isset( $post_types_disable['client'] ) ){
	require_once( LIBS_DIR .'/meta-client.php' );
}
if( ! isset( $post_types_disable['offer'] ) ){
	require_once( LIBS_DIR .'/meta-offer.php' );
}
if( ! isset( $post_types_disable['portfolio'] ) ){
	require_once( LIBS_DIR .'/meta-portfolio.php' );
}
if( ! isset( $post_types_disable['slide'] ) ){
	require_once( LIBS_DIR .'/meta-slide.php' );
}
if( ! isset( $post_types_disable['testimonial'] ) ){
	require_once( LIBS_DIR .'/meta-testimonial.php' );
}

if( ! isset( $post_types_disable['layout'] ) ){
	require_once( LIBS_DIR .'/meta-layout.php' );
}
if( ! isset( $post_types_disable['template'] ) ){
	require_once( LIBS_DIR .'/meta-template.php' );
}

require_once( LIBS_DIR .'/meta-page.php' );
require_once( LIBS_DIR .'/meta-post.php' );

// Content ----------------------------------------------------------------------
require_once( THEME_DIR .'/includes/content-post.php' );
require_once( THEME_DIR .'/includes/content-portfolio.php' );

// Shortcodes -------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-shortcodes.php' );

// Hooks ------------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-hooks.php' );

// Widgets ----------------------------------------------------------------------
require_once( LIBS_DIR .'/widget-functions.php' );

require_once( LIBS_DIR .'/widget-flickr.php' );
require_once( LIBS_DIR .'/widget-login.php' );
require_once( LIBS_DIR .'/widget-menu.php' );
require_once( LIBS_DIR .'/widget-recent-comments.php' );
require_once( LIBS_DIR .'/widget-recent-posts.php' );
require_once( LIBS_DIR .'/widget-tag-cloud.php' );

// TinyMCE ----------------------------------------------------------------------
require_once( LIBS_DIR .'/tinymce/tinymce.php' );

// Plugins ---------------------------------------------------------------------- 
if( ! isset( $theme_disable['demo-data'] ) ){
	require_once( LIBS_DIR .'/importer/import.php' );
}

require_once( LIBS_DIR .'/system-status.php' );

require_once( LIBS_DIR .'/class-love.php' );
require_once( LIBS_DIR .'/class-tgm-plugin-activation.php' );

require_once( LIBS_DIR .'/plugins/visual-composer.php' );

// WooCommerce specified functions
if( function_exists( 'is_woocommerce' ) ){
	require_once( LIBS_DIR .'/theme-woocommerce.php' );
}

// Disable responsive images in WP 4.4+ if Retina.js enabled
if( mfn_opts_get( 'retina-js' ) ){
	add_filter( 'wp_calculate_image_srcset', '__return_false' );
}

// Hide activation and update specific parts ------------------------------------

/* Khởi tạo session */
function myStartSession() {
    session_start();
}
add_action('init', 'myStartSession');

#---------------------------------
// Slider Revolution
if( ! mfn_opts_get( 'plugin-rev' ) ){
	if( function_exists( 'set_revslider_as_theme' ) ){
		set_revslider_as_theme();
	}
}

// LayerSlider
if( ! mfn_opts_get( 'plugin-layer' ) ){
	add_action('layerslider_ready', 'mfn_layerslider_overrides');
	function mfn_layerslider_overrides() {
		// Disable auto-updates
		$GLOBALS['lsAutoUpdateBox'] = false;
	}
}

// Visual Composer 
if( ! mfn_opts_get( 'plugin-visual' ) ){
	add_action( 'vc_before_init', 'mfn_vcSetAsTheme' );
	function mfn_vcSetAsTheme() {
		vc_set_as_theme();
	}
}

function forgot(){
    ob_start();
    ?>
    <div class="container">
        <div class="row">
            <?php
            if (isset($_SESSION['thongbaothanhcong']) && $_SESSION['thongbaothanhcong']==1)
            {
                ?>
                <div style="width: 100%;color: #AF0000;font-size: 15px">
                Chúng tôi đã gửi cho bạn link tạo tài khoản mới. Vui lòng kiểm tra email của bạn.
                </div>
                <?php
                $_SESSION['thongbaothanhcong']=0;
            }
            ?>
            <div class="div-forgot">
                <form action="<?php echo home_url('processing-forgot')?>" method="post">
                    <label>Tên: <input style="border-radius: 10px" type="text" name="username" required></label>
                    <label>Email: <input style="border-radius: 10px" type="email" name="email" required></label>
                    <?php
                    echo do_shortcode('[bws_google_captcha]');
                    ?>
                    <input type="submit" value="GỬI ĐI">
                </form>
            </div>
        </div>
    </div>
    <?php
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('forgot_password', 'forgot');

function set_password(){
    ob_start();
    ?>
    <?php
    if (isset($_SESSION['loi_forgot']) && $_SESSION['loi_forgot']==1)
    {
        ?>
        <div style="color: #AF0000;font-size: 15px;font-weight: 400">
        Mật khẩu nhập lại không giống.
        </div>
        <?php
        $_SESSION['loi_forgot']=0;
    }
    if (isset($_SESSION['loi_forgot']) && $_SESSION['loi_forgot']==2)
    {
        ?>
        <div style="color: #AF0000;font-size: 15px;font-weight: 400">
        Mật khẩu phải lớn hơn 6 kí tự.
        </div>
        <?php
        $_SESSION['loi_forgot']=0;
    }
    if (isset($_SESSION['loi_forgot']) && $_SESSION['loi_forgot']==3)
    {
        ?>
        <div style="color: #AF0000;font-size: 15px;font-weight: 400">
        Đổi mật khẩu không thành công.<br/>Vui lòng thử lại.
        </div>
        <?php
        $_SESSION['loi_forgot']=0;
    }

    ?>
    <div class="container">
        <div class="row">
            <div class="div-forgot">
                <form action="<?php echo home_url('new-pass-word')?>" method="post">
                    <input type="hidden" value="<?php echo $_POST['email_forgot']?>" name="email_forgot">
                    <?php
                    $current_url = base64_encode($_SERVER['REQUEST_URI']);
                    ?>
                    <input type="hidden" name="return_url" value="<?php echo $current_url ?>" />
                    <label>Tên: <?php echo $_POST['user_forgot'];?></label>
                    <label>Mật khẩu mới: <input style="border-radius: 10px" type="password" minlength="6" name="password_new" required></label>
                    <label>Xác nhận lại: <input style="border-radius: 10px" type="password" minlength="6"  name="password_confirm" required></label>
                    <input type="submit" value="CHẤP NHẬN">
                </form>
            </div>
        </div>
    </div>
    <?php
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('set_forgot_password', 'set_password');

function plugin_shortcode_video(){
    global $wpdb;
    $table_video = $wpdb->prefix."video_rookie";
    $query_video_a = "SELECT * FROM $table_video WHERE status = 1";
    $data_video_a =$wpdb->get_results($query_video_a);
    if (isset($_GET['videos']))
    {
        $id=$_GET['videos'];
    }
    else{
        $id=$data_video_a[0]->id;
    }

    $query_video = "SELECT * FROM $table_video WHERE status = 1 AND id=$id order by id DESC LIMIT 1";
    $data_video =$wpdb->get_results($query_video);
    $search = array('\r\n','&lt;br&gt;','\&quot;','\&amp;','\&#039;','\"','&lt;','&gt;');
    $replace = array('<br>','<br>','"','&amp;','&#039','"','<','>');
    ob_start();
    ?>
    <style>
        .load_video iframe{ width: 100%;}
    </style>
    <?php
    foreach($data_video as $video){
        ?>
        <div class="wpb_column vc_column_container load_video">
            <div class="vc_column-inner ">
                <div class="wpb_wrapper">
                    <div class="wpb_text_column wpb_content_element ">
                        <h4 style="color:#0a0a0a "><?php echo '■ '.$video->video_name?></h4>
                        <div class="wpb_wrapper">
                            <p>
                                <?php
                                if($video->video_type == 0){
                                    echo str_replace($search, $replace,$video->video_url);
                                }
                                if($video->video_type == 1){
                                    ?>
                                    <iframe src="<?php echo $video->video_url ?>"></iframe>
                                    <?php
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    $list_videos = "SELECT * FROM $table_video WHERE status = 1";
    $data_video1 =$wpdb->get_results($list_videos);
    ?>
    <style>
        .list-videos:hover{
            color: #AF0000!important;
        }
    </style>
    <?php
    foreach ($data_video1 as $row):
        ?>
   <p><a class="list-videos" style="color: #1c2d3f;font-size: 18px;font-weight: 500" href='<?php echo home_url('free-contents-list?videos='.$row->id)?>'><?php echo $row->video_name ?></a></p>
        <?php
        ?>
    <?php
    endforeach;
    $list_post = ob_get_contents();
    ob_end_clean();
    return $list_post;
}
add_shortcode('shortcode_video', 'plugin_shortcode_video');

add_filter('wp_mail_smtp_custom_options', function( $phpmailer ) {
    return $phpmailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
});

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'handing-login';
    if($path[0] == $templatename){
        $load = locate_template('handling_login.php', true);
        if ($load) {
            exit();
        }
    }
});


function sidebar_member(){
    ob_start();
    ?>
    <div class="sidebar sidebar-1 four columns1">
        <div class="widget-area clearfix " style="min-height: 1032px;">
            <aside id="custom_html-2" class="widget_text widget widget_custom_html">
                <div class="textwidget custom-html-widget">

                </div>
            </aside>
        </div>
    </div>
    <?php
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('sidebar_member_right', 'sidebar_member');

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'processing-forgot';
    if($path[0] == $templatename){
        $load = locate_template('processing_forgot.php', true);
        if ($load) {
            exit();
        }
    }
});

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'new-pass-word';
    if($path[0] == $templatename){
        $load = locate_template('new_pass.php', true);
        if ($load) {
            exit();
        }
    }
});

