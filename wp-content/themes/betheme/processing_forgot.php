<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
global $wpdb;
$table_team = $wpdb->prefix . "members";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['g-recaptcha-response']==''){
        $_SESSION['thongbaoloi'] ="3";
        $url = home_url('forgot-password');
        wp_redirect($url);
        exit;
    }

    if ($_POST['username']==null || $_POST['email']==null){
        $_SESSION['thongbaoloi'] ="Username và Email không thể rổng";
        $url = home_url('forgot-password');
        wp_redirect($url);
        exit;
    }
    else{
        $token = generateRandomString(32);
        $insert = $wpdb->update($table_team, array(
            'forgot_token'=>$token,
        ),array('member_username'=>$_POST['username'],'member_email'=>$_POST['email'])
        );
        if ($insert){
            require ("PHPMailer/src/mail_forgot.php");
            $url_token=home_url('input-new-password/?token='.$token);
            sendmail($_POST['email'],$url_token);
            $_SESSION['thongbaothanhcong'] =1;
            $url = home_url('forgot-password');
            wp_redirect($url);
            exit;
        }
        else{
            $_SESSION['thongbaoloi'] ="2";
            $url = home_url('forgot-password');
            wp_redirect($url);
            exit;
        }
    }

}
else {
    $_SESSION['thongbaoloi'] ="2";
    $url = home_url('forgot-password');
    wp_redirect($url);
    exit;
}
?>