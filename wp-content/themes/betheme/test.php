<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/**
 * Template Name: test
 *
 * @package Betheme
 * @author Muffin Group
 */
?>
<?php
    global $wpdb;
    $table_products = $wpdb->prefix."members";
    $data = "SELECT * FROM $table_products WHERE type=0";
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add']))
    {
        $data_prepare_name = $wpdb->prepare("SELECT * FROM $table_products WHERE member_username = %s",$_POST['username']);
        $data_team_name = $wpdb->get_row($data_prepare_name);
        if ($data_team_name){
            $_SESSION['thongbaoloi'] =1;
            $url = home_url('admin-members/?type=add');
            wp_redirect($url);
            exit;
        }
        $data_prepare_name1 = $wpdb->prepare("SELECT * FROM $table_products WHERE member_email = %s",$_POST['email']);
        $data_team_name1 = $wpdb->get_row($data_prepare_name1);
        if ($data_team_name1){
            $_SESSION['thongbaoloi'] =2;
            $url = home_url('/admin-members/?type=add');
            wp_redirect($url);
            exit;
        }
        $insert = $wpdb->insert($table_products, array(
                "member_username"=>htmlspecialchars($_POST['username']),
                "member_password"=>htmlspecialchars($_POST['password']),
                "member_email"=>htmlspecialchars($_POST['email']),
                "member_company"=>htmlspecialchars($_POST['company']),
                "member_phone"=>$_POST['phone'],
                "member_status"=>$_POST['status'],
                "member_date"=>date('Y-m-d H:i:s'),
                "week"=>'["1"]',
                "type"=>0
            )
        );
        if ($insert){
            $_SESSION['success'] =1;
            $url = home_url('/admin-members/?type=add');
            wp_redirect($url);
            exit;
        }
        else{
            $_SESSION['thongbaoloi'] =3;
            $url = home_url('/admin-members/?type=add');
            wp_redirect($url);
            exit;
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){

        $insert = $wpdb->update($table_products, array(
                "member_company"=>htmlspecialchars($_POST['company']),
                "member_phone"=>$_POST['phone'],
                "member_status"=>$_POST['status'],
            ),array('member_email'=>$_POST['email'])
        );
        if ($insert){
            $_SESSION['success1'] =1;
            $url = home_url('/admin-members/');
            wp_redirect($url);
            exit;
        }
        else{
            $_SESSION['thongbaoloi1'] =1;
            $url = home_url('/admin-members/');
            wp_redirect($url);
            exit;
        }
    }
//    else{
//        $_SESSION['thongbaoloi'] =4;
//        $url = home_url('/admin-members/?type=add');
//        wp_redirect($url);
//        exit;
//    }

