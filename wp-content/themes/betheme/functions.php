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
    <script src='https://www.google.com/recaptcha/api.js?hl=vn'></script>
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

            if (isset($_SESSION['thongbaoloi']) && $_SESSION['thongbaoloi']==2)
            {
                ?>
                <div style="width: 100%;color: #AF0000;font-size: 15px">
                    Bạn nhập sai tài khoản hoặc email. Vui lòng thử lại.
                </div>
                <?php
                $_SESSION['thongbaoloi']=0;
            }
            if (isset($_SESSION['thongbaoloi']) && $_SESSION['thongbaoloi']==3)
            {
                ?>
                <div style="width: 100%;color: #AF0000;font-size: 15px">
                    Bạn chưa chọn hoặc chọn sai hình Captcha. Vui lòng thử lại.
                </div>
                <?php
                $_SESSION['thongbaoloi']=0;
            }
            ?>
            <div class="div-forgot">
                <form action="<?php echo home_url('processing-forgot')?>" method="post">
                    <label>Tên: <input style="border-radius: 10px" type="text" name="username" required></label>
                    <label>Email: <input style="border-radius: 10px" type="email" name="email" required></label>
                    <label> <div class="g-recaptcha" data-sitekey="6LcZPWYUAAAAAEHsR1tAzeCa2gjG7ilucBhPuJ6O"></div></label>
                    <input type="submit" onclick="checkcaptcha()" value="GỬI ĐI">
                </form>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            function checkcaptcha() {
                this.submit();
            }
        });
    </script>
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
    $target_dir = home_url()."/wp-content/uploads/videos/";
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
                        <h4 style="color:#0a0a0a "><?php echo '■ '.$video->video_name.' '.$video->post?></h4>
                        <div class="wpb_wrapper">
                            <p>
                                <video width="550" height="400" controls controlsList="nodownload">
                                    <source src="<?php echo $target_dir.$video->video_url ?>" type="video/mp4">
                                </video>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    $list_videos = "SELECT * FROM $table_video WHERE video_type = 0 ORDER BY id ASC";
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
   <p><a class="list-videos" style="color: #1c2d3f;font-size: 18px;font-weight: 500" href='<?php echo home_url('free-contents-list?videos='.$row->id)?>'><?php echo $row->video_name.' '.$row->post ?></a></p>
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
add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'test';
    if($path[0] == $templatename){
        $load = locate_template('test.php', true);
        if ($load) {
            exit();
        }
    }
});


function sidebar_member(){
    ob_start();
    ?>
    <style>
        .tag-a-sidebar:hover{
            text-decoration: none;
        }
        .tag-a-sidebar{
            font-size: 14px;
            color: #0A246A;
            font-weight: 500;
        }
    </style>
    <div class="sidebar sidebar-1 four columns1">
        <div class="widget-area clearfix ">
            <aside id="custom_html-2" class="widget_text widget widget_custom_html">
                <div class="textwidget custom-html-widget" style="color: #0a0a0a!important;">
                    <?php
                    global $wpdb;
                    $table_video = $wpdb->prefix."video_rookie";
                    $query_video_a = "SELECT * FROM $table_video WHERE status = 1 ORDER BY id ASC ";
                    $data_video_a =$wpdb->get_results($query_video_a);

                    $table_members = $wpdb->prefix."members";
                    $data_prepare = $wpdb->prepare("SELECT * FROM $table_members WHERE member_username = %s",$_SESSION['member_username']);
                    $data_members = $wpdb->get_row($data_prepare);
//                    $week = json_decode($data_members->week);
//                    $current_week =end($week);
                   $current_week =diff_in_weeks_and_days(date('Y-m-d',strtotime($data_members->member_date)),date('Y-m-d'));
//                   print_r($current_week);
                   $table_week = $wpdb->prefix."week";
                    $data_prepare1 = $wpdb->prepare("SELECT * FROM $table_week WHERE num_week = %d",$current_week[0]);
                    $data_week = $wpdb->get_row($data_prepare1);

                    $query_week_a = "SELECT * FROM $table_week";
                    $data_list_week =$wpdb->get_results($query_week_a);


                    ?>
                    <h6><?php echo "Tuần ".$data_week->num_week." ". $data_week->name_week ?><hr></h6>
                    <?php
                    foreach ($data_video_a as $row)
                    {
                        if ($row->week==$current_week[0] && $row->category==1) {
                            if ($current_week[1] >= $row->post) {
                                ?>
                                <a class="tag-a-sidebar"
                                   href="<?php echo home_url('videos-detail/?videos=' . $row->id) ?>"><?php echo $row->video_name . 'Bài ' . $row->post ?></a>
                                <br/>
                                <?php
                            }
                        }
                    }
                    ?>
                    <br/>
                    <h6>Xem lại bài trước<hr></h6>
                    <?php
                    foreach ($data_list_week as $row)
                    {
                        if ($row->num_week < $current_week[0])
                        {
                            ?>
                            <a class="tag-a-sidebar" href="<?php echo home_url('back-number-list/?week='.$row->num_week)?>"><?php echo "Tuần ".$row->num_week." ". $row->name_week ?></a>
                            <br/>
                            <?php
                        }
                    }
                    ?>
                    <br/>
                    <h6>Getting Started<hr></h6>
                    <?php
                    foreach ($data_video_a as $row)
                    {
                        if ($row->category==0)
                        {
                            ?>
                            <a class="tag-a-sidebar" href="<?php echo home_url('videos-detail/?videos='.$row->id)?>"><?php echo $row->video_name.' '.$row->post ?></a>
                            <br/>
                            <?php
                        }
                    }
                    ?>
                    <br/>
                    <h6>Xem lại và các nội dung đặc biệt<hr></h6>
                    <?php
                    foreach ($data_video_a as $row)
                    {
                        if ($row->category==2)
                        {
                            ?>
                            <a class="tag-a-sidebar" href="<?php echo home_url('videos-detail/?videos='.$row->id)?>"><?php echo $row->video_name.' '.$row->post ?></a>
                            <br/>
                            <?php
                        }
                    }
                    ?>
                    <br/>
                    <a href="/contact/"><button id="contact-button" style="font-size: 12px">Liên hệ với chúng tôi</button>
                    </a>
                    <br/>
                    <br/>
                    <div class="phone-class">
                        <p></p>
                        <p>
                            <span>Liên hệ qua điện thoại</span>
                            <span><a href="tel:0898897896">0898 897 896</a></span>
                        </p>
                        <p></p>
                    </div>
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

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'te';
    if($path[0] == $templatename){
        $load = locate_template('new_pass.php', true);
        if ($load) {
            exit();
        }
    }
});


function check_login(){
    ob_start();
    global $wpdb;
    if (!isset($_SESSION['login']) && !isset($_SESSION['member_username']))
    {
        ?>
        <script>window.location='<?php echo home_url()?>'</script>
    <?php
    }
    else
    {
        $table_team = $wpdb->prefix."members";
        $data_prepare = $wpdb->prepare("SELECT * FROM $table_team WHERE member_username = %s AND type=%d",$_SESSION['member_username'],0);
        $data_team = $wpdb->get_row($data_prepare);
        $data_prepare1 = $wpdb->prepare("SELECT * FROM $table_team WHERE member_username = %s AND type=%d",$_SESSION['member_username'],1);
        $data_team1 = $wpdb->get_row($data_prepare1);
        if (!$data_team){
            if ($data_team1)
            {
                $_SESSION['admin_login']=1;
            }
            else {
                ?>
                <script>window.location = '<?php echo home_url()?>'</script>
                <?php
                exit;
            }
        }

    }
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('check_login', 'check_login');

function free_list()
{
    ob_start();
    global $wpdb;
    $table_video = $wpdb->prefix."video_rookie";
    $query_video_a = "SELECT * FROM $table_video WHERE video_type=0 ORDER BY id ASC";
    $data_video =$wpdb->get_results($query_video_a);
    ?>
    <style>.free-list{
            color: #0A246A;
            font-size: 14px;
        }</style>
    <table class="table-widgets">
        <?php
        foreach ($data_video as $row){
            ?>
            <tr>
                <td><a class="free-list" href="/free-contents-list/?videos=<?php echo $row->id ?>"><?php echo $row->video_name.' '.$row->post ?></a></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('free_list','free_list');

function message_login(){
    ob_start();
    if (isset($_SESSION['login']) && $_SESSION['login']=='thatbai_1')
    {
        ?>
        <span style="color: #AF0000">Tài khoản hoặc mật khẩu không đúng.</span>
        <?php
        unset($_SESSION['login']);
    }
    if (isset($_SESSION['login']) && $_SESSION['login']=='thatbai')
    {
        ?>
        <span style="color: #AF0000">Đã xãy ra lỗi trong quá trình đăng nhập. Vui lòng thử lại.</span>
        <?php
        unset($_SESSION['login']);
    }
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('message_login', 'message_login');

function diff_in_weeks_and_days($from, $to) {
    $day   = 24 * 3600;
    $from  = strtotime($from);
    $to    = strtotime($to) + $day;
    $diff  = abs($to - $from);
    $weeks = floor($diff / $day / 7);
    $days  = $diff / $day - $weeks * 7;
    if (date('Y-m-d')<date('Y-m-d',strtotime('2018-08-08')))
    {
    return [-($weeks+1),$days];
    }
    else{
        return [$weeks+1,$days];
    }
}

function plugin_shortcode_video_detail(){
    global $wpdb;
    $table_members = $wpdb->prefix."members";
    $data_prepare = $wpdb->prepare("SELECT * FROM $table_members WHERE member_username = %s",$_SESSION['member_username']);
    $data_members = $wpdb->get_row($data_prepare);
//    $week = json_decode($data_members->week);
//    $current_week =end($week);
    $current_week =diff_in_weeks_and_days(date('Y-m-d',strtotime($data_members->member_date)),date('Y-m-d'));

    $table_week = $wpdb->prefix."week";
    $data_prepare1 = $wpdb->prepare("SELECT * FROM $table_week WHERE num_week = %d",$current_week[0]);
    $data_week = $wpdb->get_row($data_prepare1);



    if (isset($_GET['videos']))
    {
        $id=$_GET['videos'];
    }
    else{
        $id=-1;
    }

    $table_video = $wpdb->prefix."video_rookie";
    $query_video = $wpdb->prepare("SELECT * FROM $table_video WHERE id = %d",$id);
    $data_video = $wpdb->get_row($query_video);
    $search = array('\r\n','&lt;br&gt;','\&quot;','\&amp;','\&#039;','\"','&lt;','&gt;');
    $replace = array('<br>','<br>','"','&amp;','&#039','"','<','>');

    $data_prepare2 = $wpdb->prepare("SELECT * FROM $table_week WHERE num_week = %d",$data_video->week);
    $data_week2 = $wpdb->get_row($data_prepare2);

    ob_start();
    if ($data_week2!=null)
    {
        ?>
        <h3 style="color: #0A246A"><?php echo "Tuần ".$data_week2->num_week." ". $data_week2->name_week ?><hr></h3>
        <br>
        <p style="color: #1c2d3f">
            <?php
            echo $data_week2->content_week;
            ?>
        </p>
        <br>
        <br>
        <?php
    }
    $target_dir = home_url()."/wp-content/uploads/videos/";
    ?>
    <style>
        .load_video iframe{ width: 100%;}
    </style>
        <div class="wpb_column vc_column_container load_video">
            <div class="vc_column-inner ">
                <div class="wpb_wrapper">
                    <div class="wpb_text_column wpb_content_element ">
                        <?php
                        if ($data_members->type==1){
                            $lession = $data_video->category==1?'Bài ': '';
                            ?>
                            <h4 style="color:#0a0a0a "><?php echo '■ '.$data_video->video_name.$lession.$data_video->post?></h4>
                            <p style="color:#0a0a0a "><?php echo $data_video->content ?></p>
                            <div class="wpb_wrapper">
                                <p>
                                    <video width="550" height="400" controls controlsList="nodownload">
                                        <source src="<?php echo $target_dir.$data_video->video_url ?>" type="video/mp4">
                                    </video>
                                </p>
                            </div>
                        <?php
                        }
                        else{
                        if ($data_video==null):
                        {
                            ?>
                            <h5>Videos Không tồn tại.</h5>
                            <?php

                        }
                        elseif ($data_video!=null && $data_video->category==1):
                        if ($data_video->week<=$current_week[0]):
                        ?>
                        <h4 style="color:#0a0a0a "><?php echo '■ '.$data_video->video_name.' Bài '.$data_video->post?></h4>
                        <p style="color:#0a0a0a "><?php echo $data_video->content ?></p>
                        <div class="wpb_wrapper">
                            <p>
                                <video width="550" height="400" controls controlsList="nodownload">
                                    <source src="<?php echo $target_dir.$data_video->video_url ?>" type="video/mp4">
                                </video>
                            </p>
                        </div>
                        <?php
                        elseif($data_video->week > $current_week[0]):
                            if (isset($_SESSION['admin_login']))
                            {
                                ?>
                                <video width="550" height="400" controls controlsList="nodownload">
                                    <source src="<?php echo $target_dir.$data_video->video_url ?>" type="video/mp4">
                                </video>
                                <?php
                            }
                            else{
                            ?>
                                <h5>Bạn chưa được phép xem Videos này.</h5>
                                <?php
                            }
                            ?>

                        <?php
                            else:
                                ?>
                                <h5>Videos Không tồn tại.</h5>
                            <?php
                        endif;
                        else:
                            ?>
                            <h4 style="color:#0a0a0a "><?php echo '■ '.$data_video->video_name.' '.$data_video->post?></h4>
                            <p style="color:#0a0a0a "><?php echo $data_video->content ?></p>
                            <div class="wpb_wrapper">
                                <p>
                                    <video width="550" height="400" controls controlsList="nodownload">
                                        <source src="<?php echo $target_dir.$data_video->video_url ?>" type="video/mp4">
                                    </video>
                                </p>
                            </div>
                        <?php
                            endif;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    $list_post = ob_get_contents();
    ob_end_clean();
    return $list_post;
}
add_shortcode('shortcode_video_detail', 'plugin_shortcode_video_detail');


function plugin_shortcode_video_week(){
    global $wpdb;
    if (isset($_GET['week']))
    {
        $id=$_GET['week'];
    }
    else{
        $id=-1;
    }
    $table_week = $wpdb->prefix."week";
    $data_prepare1 = $wpdb->prepare("SELECT * FROM $table_week WHERE num_week = %d",$id);
    $data_week = $wpdb->get_row($data_prepare1);

    $table_video = $wpdb->prefix."video_rookie";
    $query_video_a = "SELECT * FROM $table_video WHERE status = 1 ORDER BY id ASC";
    $data_video =$wpdb->get_results($query_video_a);
    ob_start();
    ?>
    <style>
        .list-videos:hover{
            color: #AF0000!important;
        }
    </style>
    <?php
    if ($data_week!=null)
    {
        ?>
        <h3 style="color: #0A246A"><?php echo "Tuần ".$data_week->num_week." ". $data_week->name_week ?><hr></h3>
        <br>
        <p style="color: #1c2d3f">
            <?php
            echo $data_week->content_week;
            ?>
        </p>
        <br>
        <br>
        <?php
    }
    foreach ($data_video as $row):
        if ($data_week==null):
            ?>
        <h5>Không có Videos phù hợp.</h5>
        <?php
        break;
            elseif ($data_week->num_week ==$row->week):
        ?>
        <p><a class="list-videos" style="color: #1c2d3f;font-size: 18px;font-weight: 500" href='<?php echo home_url('videos-detail/?videos='.$row->id)?>'><?php echo $row->video_name.'Bài '.$row->post ?></a>

            <?php
            if (isset($_SESSION['admin_login'])):
            ?>
                <a href="<?php echo home_url('admin-edit-video/?videos='.$row->id)?>">
                    <i style="font-size: 20px" class="fa fa-edit"></i>
                </a>
            <a href="<?php echo home_url('delete-video/?videos='.$row->id.'&url='.$row->video_url)?>" onclick="return confirm('Are you sure you want to delete this item?');">
                <i style="font-size: 20px" class="fa fa-remove"></i>
            </a>
            <?php
            endif;
            ?>
        </p>
        <?php
        endif;
        ?>
    <?php
    endforeach;
    $list_post = ob_get_contents();
    ob_end_clean();
    return $list_post;
}
add_shortcode('shortcode_video_week', 'plugin_shortcode_video_week');

function edit_video()
{
    global $wpdb;
    $table_week = $wpdb->prefix."video_rookie";
    $data_prepare1 = $wpdb->prepare("SELECT * FROM $table_week WHERE id = %d",$_GET['videos']);
    $data_videos = $wpdb->get_row($data_prepare1);

    $table_week1 = $wpdb->prefix."week";
    $data_prepare2 = $wpdb->prepare("SELECT * FROM $table_week1 WHERE num_week = %d",$data_videos->week);
    $data_week = $wpdb->get_row($data_prepare2);

    ob_start();
    if($data_videos) {
        ?>
        <style>
            .load_video iframe {
                width: 100%;
            }

            select, input[type=text], textarea {
                display: inline;
                padding-left: 10px;
            }

            select {
                width: 30%;
            }

            input[type=text] {
                width: 60%;
            }

            label {
                color: #0a0a0a;
            }

            textarea {
                vertical-align: top;
                width: 60%;
            }

            .upload_video_upload, .button-upload {
                background-color: darkgray !important;
                border-radius: 10px !important;
                width: 20% !important;
            }
        </style>
        <p style="color: #252525;font-weight: bold;font-size: 15px"> ■ Edit video</p>
        <div class="wpb_column vc_column_container load_video">
            <div class="vc_column-inner ">
                <div class="wpb_wrapper">
                    <div class="wpb_text_column wpb_content_element">
                        <?php
                        if (isset($_SESSION['success_videos']) && $_SESSION['success_videos'] == 1) {
                            ?>
                            <div style="color: #1e83c9;font-size: 15px;font-weight: bold">Update successful!</div>
                            <?php
                            $_SESSION['success_videos'] = 0;
                        }
                        if (isset($_SESSION['error_videos']) && $_SESSION['error_videos'] == 1) {
                            ?>
                            <div style="color: #AF0000;font-size: 15px;font-weight: bold">Tên Videos không được để
                                trống.
                            </div>
                            <?php
                            $_SESSION['error_videos'] = 0;
                        }
                        if (isset($_SESSION['error_videos']) && $_SESSION['error_videos'] == 2) {
                            ?>
                            <div style="color: #AF0000;font-size: 15px;font-weight: bold">Bạn chưa có video tải lên. Vui
                                lòng thử lại.
                            </div>
                            <?php
                            $_SESSION['error_videos'] = 0;
                        }
                        if (isset($_SESSION['error_videos']) && $_SESSION['error_videos'] == 3) {
                            ?>
                            <div style="color: #AF0000;font-size: 15px;font-weight: bold">Tuần không được để rổng.</div>
                            <?php
                            $_SESSION['error_videos'] = 0;
                        }

                        ?>
                        <form action="<?php echo home_url('update-videos?videos='.$data_videos->id) ?>" method="post" enctype="multipart/form-data">
                            <label>
                                <?php
                                if ($data_videos->category==1){
                                    ?>
                                    Week : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data_videos->week ?>
                                    <br/>
                                    <?php
                                }
                                ?>
                            </label>
                            <?php
                            if ($data_videos->category!=1) {
                                ?>
                                <label>Tên &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" value="<?php echo $data_videos->video_name ?>" name="name_videos"
                                           required>
                                </label>
                                <?php
                            }
                            ?>
                            <label><span style="color: white">fdfdffdđddddddđ</span>
                                <?php
                                if ($data_videos->category==1){
                                    ?>
                                    <span id="no-free"><input id="radio-nofree" type="radio" name="free" value="1" checked>No Free</span>
                                    <?php
                                }
                                elseif($data_videos->category==2){
                                    ?>
                                    <span id="no-free"><input id="radio-nofree" type="radio" name="free" value="1" <?php if ($data_videos->video_type==1) echo "checked"?>>No Free</span>
                                    <span id="free"><input id="radio-free" type="radio" name="free" value="0" <?php if ($data_videos->video_type==0) echo "checked"?> >Free</span>
                                    <?php
                                }
                                else{
                                    ?>
                                    <span id="free"><input id="radio-free" type="radio" name="free" value="0" checked>Free</span>
                                    <?php
                                }
                                ?>

                                &nbsp;</label>
                            <?php
                             if ($data_videos->category!=1) {
                                 ?>
                                 <label> Videos content &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <textarea name="describe" rows="6"><?php echo $data_videos->content ?></textarea>
                                     <label>
                                         <input class="button-upload" type="reset">
                                         <input class="button-upload" type="submit" value="Cập nhật">
                                     </label>
                                 </label>
                                 <?php
                             }
                             else{
                                 ?>
                                 <input type="hidden" name="num_week" value="<?php echo $data_videos->week?>">
                                 <label> Week content&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <textarea name="describe" rows="6"><?php echo $data_week->content_week ?></textarea>
                                     <label>
                                         <input class="button-upload" type="reset">
                                         <input class="button-upload" type="submit" value="Cập nhật">
                                     </label>
                                 </label>
                                 <?php
                             }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    $list_post = ob_get_contents();
    ob_end_clean();
    return $list_post;
}
add_shortcode('edit_video', 'edit_video');

function upload_video()
{
    ob_start();
    ?>
    <style>
        .load_video iframe{ width: 100%;}
        select,input[type=text],textarea{
           display: inline;
            padding-left: 10px;
        }
        select{
            width: 30%;
        }
        input[type=text]{
            width: 60%;
        }
        label{
            color: #0a0a0a;
        }
        textarea{
            vertical-align: top;
            width: 60%;
        }
        .upload_video_upload,.button-upload{
            background-color: darkgray!important;
            border-radius: 10px!important;
            width: 20%!important;
        }
    </style>
    <p style="color: #252525;font-weight: bold;font-size: 15px"> ■ Upload video</p>
    <div class="wpb_column vc_column_container load_video">
        <div class="vc_column-inner ">
            <div class="wpb_wrapper">
                <div class="wpb_text_column wpb_content_element">
                    <?php
                    if (isset($_SESSION['success_videos']) && $_SESSION['success_videos']==1)
                    {
                        ?>
                        <div style="color: #1e83c9;font-size: 15px;font-weight: bold">Inserted!</div>
                    <?php
                        $_SESSION['success_videos']=0;
                    }
                    if (isset($_SESSION['error_videos']) && $_SESSION['error_videos']==1)
                    {
                        ?>
                        <div style="color: #AF0000;font-size: 15px;font-weight: bold">Tên Videos không được để trống.</div>
                        <?php
                        $_SESSION['error_videos']=0;
                    }
                    if (isset($_SESSION['error_videos']) && $_SESSION['error_videos']==2)
                    {
                        ?>
                        <div style="color: #AF0000;font-size: 15px;font-weight: bold">Bạn chưa có video tải lên. Vui lòng thử lại.</div>
                        <?php
                        $_SESSION['error_videos']=0;
                    }
                    if (isset($_SESSION['error_videos']) && $_SESSION['error_videos']==3)
                    {
                        ?>
                        <div style="color: #AF0000;font-size: 15px;font-weight: bold">Tuần không được để rổng.</div>
                        <?php
                        $_SESSION['error_videos']=0;
                    }

                    ?>
                    <form action="<?php echo home_url('videos') ?>" method="post" enctype="multipart/form-data">
                        <label>Thể loại <input onclick="check_kind_display()" type="radio" name="kind" value="1" checked />Weekly Lesson &nbsp;&nbsp;<input id="check-kind-special" onclick="check_kind1()" type="radio" name="kind" value="2"/>Special Content &nbsp;&nbsp;<input id="check-kind-start" onclick="check_kind()" type="radio" name="kind" value="0"/>Getting Started</label>
                        <label id="week-label">Tuần &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="id_week">
                                <?php
                                for($i=1;$i<=20;$i++) {
                                    ?>
                                    <option><?php echo $i;?></option>
                                    <?php
                                }
                                    ?>
                            </select>
                            <input style="width: 30%!important;" type="text" name="name_week" placeholder="Tên Tuần"></label>
                        </label>
                        <label id="video-name">Tên &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" name="name_videos"></label>
                        <label id="lesson-label">Bài  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="post">
                                <?php
                                for($i=1;$i<=20;$i++) {
                                    ?>
                                    <option><?php echo $i;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                        <label>Tập tin &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="file" name="videos" accept="video/*;capture=camcorder" required>
<!--                            <iframe src="--><?php //echo get_option('upload_video'); ?><!--" name="upload_video" width="300px" height="250px" class="upload_video" id="display_iframe" style="display:none"></iframe>-->
<!--                            <button class="upload_video_upload button button-primary margin-top20">Upload</button>-->
<!--                            <input type="hidden" name="upload_video" class="upload_video_upload" hidden="hidden" value="--><?php //echo get_option('upload_video'); ?><!--">-->
                        </label>
                        <label><span style="color: white">fdfdffdđ</span><span id="no-free"><input id="radio-nofree" type="radio" name="free" value="1">No Free</span> <span id="free"><input id="radio-free" type="radio" name="free" value="0">Free</span> &nbsp;</label>
                        <label> Mô tả &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <textarea name="describe" rows="6"></textarea>
                            <label>
                            <input class="button-upload" type="reset">
                            <input class="button-upload" type="submit" value="Tải lên">
                            </label>
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function check_kind() {
            document.getElementById("lesson-label").style.display = "none";
            document.getElementById("week-label").style.display = "none";
            document.getElementById("no-free").style.display = "none";
            document.getElementById("free").style.display = "block";
            document.getElementById("radio-free").checked = true;
            document.getElementById("video-name").style.display = "block";
        }

        function check_kind1() {
            document.getElementById("lesson-label").style.display = "none";
            document.getElementById("week-label").style.display = "none";
            document.getElementById("free").style.display = "block";
            document.getElementById("no-free").style.display = "block";
            document.getElementById("radio-free").checked = true;
            document.getElementById("video-name").style.display = "block";
        }

        function check_kind_display() {
            document.getElementById("lesson-label").style.display = "block";
            document.getElementById("week-label").style.display = "block";
            document.getElementById("no-free").style.display = "block";
            document.getElementById("radio-nofree").checked = true;
            document.getElementById("free").style.display = "none";
            document.getElementById("video-name").style.display = "none";
        }

        document.getElementById("free").style.display = "none";
        document.getElementById("radio-nofree").checked = true;
        document.getElementById("video-name").style.display = "none";
    </script>
    <?php
    $list_post = ob_get_contents();
    ob_end_clean();
    return $list_post;
}
add_shortcode('upload_video', 'upload_video');

add_action( 'wp_enqueue_scripts', 'the_dramatist_enqueue_scripts' );

 #Call wp_enqueue_media() to load up all the scripts we need for media uploader

function the_dramatist_enqueue_scripts() {
    wp_enqueue_media();
    wp_enqueue_script(
        'some-script',
        get_template_directory_uri() . '/js/media-uploader.js',
        array( 'jquery' ),
        null
    );
}

function sidebar_admin(){
    ob_start();
    ?>
    <style>
        .tag-a-sidebar:hover{
            text-decoration: none;
        }
        .tag-a-sidebar{
            font-size: 14px;
            color: #0A246A;
            font-weight: 500;
        }
    </style>
    <div class="sidebar sidebar-1 four columns1">
        <div class="widget-area clearfix ">
            <aside id="custom_html-2" class="widget_text widget widget_custom_html">
                <div class="textwidget custom-html-widget" style="color: #0a0a0a!important;">
                    <?php
                    global $wpdb;
                    $table_video = $wpdb->prefix."video_rookie";
                    $query_video_a = "SELECT * FROM $table_video WHERE status = 1 ORDER BY id ASC";
                    $data_video_a =$wpdb->get_results($query_video_a);

                    $table_members = $wpdb->prefix."members";
                    $data_prepare = $wpdb->prepare("SELECT * FROM $table_members WHERE member_username = %s",$_SESSION['member_username']);
                    $data_members = $wpdb->get_row($data_prepare);
                    $week = json_decode($data_members->week);
                    $current_week =end($week);

                    $table_week = $wpdb->prefix."week";
                    $data_prepare1 = $wpdb->prepare("SELECT * FROM $table_week WHERE num_week = %d",$current_week);
                    $data_week = $wpdb->get_row($data_prepare1);

                    $query_week_a = "SELECT * FROM $table_week";
                    $data_list_week =$wpdb->get_results($query_week_a);


                    ?>
                    <h6>Weekly Lesson <hr></h6>

                    <?php
                    foreach ($data_list_week as $row)
                    {
                            ?>
                            <a class="tag-a-sidebar" href="<?php echo home_url('back-number-list/?week='.$row->num_week)?>"><?php  echo "Tuần ".$row->num_week." ". $row->name_week ?></a>
                        <a href="<?php echo home_url('delete-week/?week='.$row->num_week)?>" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i style="font-size: 20px" class="fa fa-remove"></i>
                        </a>
                        <br/>
                            <?php
                    }
                    ?>
                    <br/>
                    <br/>
                    <h6>Special Content<hr></h6>
                    <?php
                    foreach ($data_video_a as $row)
                    {
                        if ($row->category==2)
                        {
                            ?>
                            <a class="tag-a-sidebar" href="<?php echo home_url('videos-detail/?videos='.$row->id)?>"><?php echo $row->video_name.' '.$row->post?></a>
                            <a href="<?php echo home_url('admin-edit-video/?videos='.$row->id)?>">
                                <i style="font-size: 20px" class="fa fa-edit"></i>
                            </a>
                            <a href="<?php echo home_url('delete-video/?videos='.$row->id.'&url='.$row->video_url)?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                <i style="font-size: 20px" class="fa fa-remove"></i>
                            </a>
                            <br/>
                            <?php
                        }
                    }
                    ?>
                    <br/>
                    <br/>
                    <h6>Getting Started<hr></h6>
                    <?php
                    foreach ($data_video_a as $row)
                    {
                        if ($row->category==0)
                        {
                            ?>
                            <a class="tag-a-sidebar" href="<?php echo home_url('videos-detail/?videos='.$row->id)?>"><?php echo $row->video_name.' '.$row->post ?></a>
                            <a href="<?php echo home_url('admin-edit-video/?videos='.$row->id)?>">
                                <i style="font-size: 20px" class="fa fa-edit"></i>
                            </a>
                            <a href="<?php echo home_url('delete-video/?videos='.$row->id.'&url='.$row->video_url)?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                <i style="font-size: 20px" class="fa fa-remove"></i>
                            </a>
                            <br/>
                            <?php
                        }
                    }
                    ?>
                    <br/>
                </div>
            </aside>
        </div>
    </div>
    <?php
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('sidebar_admin_right', 'sidebar_admin');

function getting_started_right()
{
    ob_start();
    global $wpdb;
    $search = array('\r\n','&lt;br&gt;','\&quot;','\&amp;','\&#039;','\"','&lt;','&gt;');
    $replace = array('<br>','<br>','"','&amp;','&#039','"','<','>');
    $table_video = $wpdb->prefix."video_rookie";
    $query_video_a = "SELECT * FROM $table_video WHERE category=0 AND video_type =0 ORDER  BY id";
//    $text= array(
//            1=>'Nhận thức và tư duy là gì ?',
//            2=>'Ý thức và Tư duy',
//            3=>'Training menu'
//    );
    $i=1;
    $target_dir = home_url()."/wp-content/uploads/videos/";
    $data_video =$wpdb->get_results($query_video_a);
    foreach ($data_video as $row) {
        ?>
        <div class="vc_col-sm-5 text-home">
            <p><?php echo $row->video_name.' '.$row->post ?></p>
            <p><?php echo $row->content ?></p>
        </div>
        <div class="vc_col-sm-7">
            <video width="350" height="200" controls controlsList="nodownload">
                <source src="<?php echo $target_dir.$row->video_url ?>" type="video/mp4">
            </video>
        </div>
        <?php
        $i++;
    }
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}
add_shortcode('getting_started_right','getting_started_right');

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'log-out';
    if($path[0] == $templatename){
        $load = locate_template('logout.php', true);
        if ($load) {
            exit();
        }
    }
});

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'videos';
    if($path[0] == $templatename){
        $load = locate_template('videos.php', true);
        if ($load) {
            exit();
        }
    }
});

add_action( 'init', 'setting_my_first_cookie' );

function setting_my_first_cookie() {
    if (isset($_SESSION['member_username']) && isset($_SESSION['auto_login']) && $_SESSION['auto_login']!=null && !isset($_COOKIE['username'])) {
        setcookie('username', $_SESSION['member_username'], time()+60*60*24*365);
    }
}

add_action('init', function() {
    // yes, this is a PHP 5.3 closure, deal with it
    if (isset($_COOKIE['username'])=='') {
        setcookie('username', '', time() - ( 15 * 60 ));
    }
});


add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'delete-video';
    if($path[0] == $templatename){
        $load = locate_template('delete_video.php', true);
        if ($load) {
            exit();
        }
    }
});
add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'delete-week';
    if($path[0] == $templatename){
        $load = locate_template('delete_week.php', true);
        if ($load) {
            exit();
        }
    }
});

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    $path = explode("/",$url_path);
    $templatename = 'update-videos';
    if($path[0] == $templatename){
        $load = locate_template('upload_videos.php', true);
        if ($load) {
            exit();
        }
    }
});
?>