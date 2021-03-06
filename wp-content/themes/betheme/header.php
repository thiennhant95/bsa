<?php
//print_r($_SESSION);
//print_r($_COOKIE);
if (isset($_COOKIE['username'])){
    $_SESSION['login'] = 1;
    $_SESSION['member_username'] = $_COOKIE['username'];
}
if (strpos($_SERVER['REQUEST_URI'],'admin-top') || strpos($_SERVER['REQUEST_URI'],'admin-members') || strpos($_SERVER['REQUEST_URI'],'training-fee-admin') || strpos($_SERVER['REQUEST_URI'],'member-admin'))
{
    if (!isset($_SESSION['login']) && !isset($_SESSION['member_username']))
{
        if (isset($_COOKIE['username'])) {
            $_SESSION['login'] = 1;
            $_SESSION['member_username'] = $_COOKIE['username'];
        }
        if (!isset($_COOKIE['username'])) {
            $url = home_url('/');
            wp_redirect($url);
            exit;
        }
}
else{
    $table_team = $wpdb->prefix."members";
    $data_prepare = $wpdb->prepare("SELECT * FROM $table_team WHERE member_username = %s AND type=%d",$_SESSION['member_username'],1);
    $data_team = $wpdb->get_row($data_prepare);
    if (!$data_team){
        $url = home_url('/');
        wp_redirect($url);
        exit;
    }
}
}
if (strpos($_SERVER['REQUEST_URI'],'input-new-password'))
{
    if (!isset($_GET['token'])){
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 );
        die();
    }
    else
    {
        $table_team = $wpdb->prefix."members";
        $data_prepare = $wpdb->prepare("SELECT * FROM $table_team WHERE forgot_token = %s",$_GET['token']);
        $data_team = $wpdb->get_row($data_prepare);
        if ($data_team)
        {
          $_POST['email_forgot']=$data_team->member_email;
          $_POST['user_forgot']=$data_team->member_username;
        }
        else
        {
            global $wp_query;
            $wp_query->set_404();
            status_header( 404 );
            get_template_part( 404 );
            die();
        }
    }
}
?>
<?php
/**
 * The Header for our theme.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */
?>
<!DOCTYPE html>
<?php 
	if( $_GET && key_exists('mfn-rtl', $_GET) ):
		echo '<html class="no-js" lang="ar" dir="rtl">';
	else:
?>
<html class="no-js<?php echo mfn_user_os(); ?>" <?php language_attributes(); ?><?php mfn_tag_schema(); ?>>
<?php endif; ?>

<!-- head -->
<head>

<!-- meta -->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php 
	if( mfn_opts_get('responsive') ){
		if( mfn_opts_get('responsive-zoom') ){
			echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
		} else {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
		}
		 
	}
?>

<?php do_action('wp_seo'); ?>

<link rel="shortcut icon" href="<?php mfn_opts_show( 'favicon-img', THEME_URI .'/images/favicon.ico' ); ?>" />	
<?php if( mfn_opts_get('apple-touch-icon') ): ?>
<link rel="apple-touch-icon" href="<?php mfn_opts_show( 'apple-touch-icon' ); ?>" />
<?php endif; ?>	

<!-- wp_head() -->
<?php wp_head(); ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<!-- body -->
<body <?php body_class(); ?>>
	
	<?php do_action( 'mfn_hook_top' ); ?>

	<?php get_template_part( 'includes/header', 'sliding-area' ); ?>
	
	<?php if( mfn_header_style( true ) == 'header-creative' ) get_template_part( 'includes/header', 'creative' ); ?>
	
	<!-- #Wrapper -->
	<div id="Wrapper">
	
		<?php 
			// Featured Image | Parallax ----------
			$header_style = '';
				
			if( mfn_opts_get( 'img-subheader-attachment' ) == 'parallax' ){
				
				if( mfn_opts_get( 'parallax' ) == 'stellar' ){
					$header_style = ' class="bg-parallax" data-stellar-background-ratio="0.5"';
				} else {
					$header_style = ' class="bg-parallax" data-enllax-ratio="0.3"';
				}
				
			}
		?>
		
		<?php if( mfn_header_style( true ) == 'header-below' ) echo mfn_slider(); ?>

		<!-- #Header_bg -->
		<div id="Header_wrapper" <?php echo $header_style; ?>>
			<!-- #Header -->
			<header id="Header">
				<?php if( mfn_header_style( true ) != 'header-creative' ) get_template_part( 'includes/header', 'top-area' ); ?>	
				<?php if( mfn_header_style( true ) != 'header-below' ) echo mfn_slider(); ?>
			</header>
			<?php 
				if( ( mfn_opts_get('subheader') != 'all' ) && 
					( ! get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ) &&
					( get_post_meta( mfn_ID(), 'mfn-post-template', true ) != 'intro' )	){

					
					$subheader_advanced = mfn_opts_get( 'subheader-advanced' );
					
					$subheader_style = '';
					
					if( mfn_opts_get( 'subheader-padding' ) ){
						$subheader_style .= 'padding:'. mfn_opts_get( 'subheader-padding' ) .';';
					}				
					
					
					if( is_search() ){
						// Page title -------------------------
						
						echo '<div id="Subheader" style="'. $subheader_style .'">';
							echo '<div class="container">';
								echo '<div class="column one">';

									if( trim( $_GET['s'] ) ){
										global $wp_query;
										$total_results = $wp_query->found_posts;
									} else {
										$total_results = 0;
									}

									$translate['search-results'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-results','results found for:') : __('results found for:','betheme');								
									echo '<h1 class="title">'. $total_results .' '. $translate['search-results'] .' '. esc_html( $_GET['s'] ) .'</h1>';
									
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
						
					} elseif( ! mfn_slider_isset() || ( is_array( $subheader_advanced ) && isset( $subheader_advanced['slider-show'] ) ) ){
						// Page title -------------------------
						
						
						// Subheader | Options
						$subheader_options = mfn_opts_get( 'subheader' );


						if( is_home() && ! get_option( 'page_for_posts' ) && ! mfn_opts_get( 'blog-page' ) ){
							$subheader_show = false;
						} elseif( is_array( $subheader_options ) && isset( $subheader_options[ 'hide-subheader' ] ) ){
							$subheader_show = false;
						} elseif( get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ){
							$subheader_show = false;
						} else {
							$subheader_show = true;
						}
						
						
						// title
						if( is_array( $subheader_options ) && isset( $subheader_options[ 'hide-title' ] ) ){
							$title_show = false;
						} else {
							$title_show = true;
						}
						
						
						// breadcrumbs
						if( is_array( $subheader_options ) && isset( $subheader_options[ 'hide-breadcrumbs' ] ) ){
							$breadcrumbs_show = false;
						} else {
							$breadcrumbs_show = true;
						}
						
						if( is_array( $subheader_advanced ) && isset( $subheader_advanced[ 'breadcrumbs-link' ] ) ){
							$breadcrumbs_link = 'has-link';
						} else {
							$breadcrumbs_link = 'no-link';
						}
						
						
						// Subheader | Print
						if( $subheader_show ){
							echo '<div id="Subheader" style="'. $subheader_style .'">';
								echo '<div class="container">';
									echo '<div class="column one">';
										
										// Title
										if( $title_show ){
											$title_tag = mfn_opts_get( 'subheader-title-tag', 'h1' );
											echo '<'. $title_tag .' class="title">'. mfn_page_title() .'</'. $title_tag .'>';
										}
										
										// Breadcrumbs
										if( $breadcrumbs_show ){
											mfn_breadcrumbs( $breadcrumbs_link );
										}
										
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
					}
				}
			?>
            <?php
            if (is_front_page()):
            ?>
            <div class="sections_group slogan">
                <div class="entry-content" itemprop="mainContentOfPage">
                    <div class="section the_content has_content">
                        <div class="the_content_wrapper">
                            <div class="vc_row wpb_row vc_row-fluid slogan-name">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="vc_column-inner ">
                                        <div class="wpb_wrapper">
                                            <div class="wpb_text_column wpb_content_element  slogan-text">
                                                <div class="wpb_wrapper">
                                                    <p>[Perception and Thinking] là công cụ tốt nhất giúp đánh thức các khả năng của bạn trong môi trường kinh doanh!</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            endif;
            ?>
		</div>
		
		<?php
			// Single Post | Template: Intro
			if( get_post_meta( mfn_ID(), 'mfn-post-template', true ) == 'intro' ){
				get_template_part( 'includes/header', 'single-intro' );
			}
		?>
		
		<?php do_action( 'mfn_hook_content_before' );
		
// Omit Closing PHP Tags
?>
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login']==1 && !isset($_SESSION['admin_login']))
        {
            ?>
            <script>
                jQuery(function($) {
                    $("#form-login").css({"display": "none"});
                    $("#forgot-password").css({"display": "none"});
                    $(".member-login").append('<li><a href="/member-top/">Members Page</a></li>');
                    $(".member-login").append('<li><a href="/log-out/">Logout</a></li>');
                });
            </script>
            <?php
        }
        elseif (isset($_SESSION['login']) && $_SESSION['login']==1 && isset($_SESSION['admin_login']))
        {
            ?>
            <script>
                jQuery(function($) {
                    $("#form-login").css({"display": "none"});
                    $("#forgot-password").css({"display": "none"});
                    $(".member-login").append('<li><a href="/admin-top/">Admin Page</a></li>');
                    $(".member-login").append('<li><a href="/log-out/">Logout</a></li>');
                });
            </script>
            <?php
        }
?>
