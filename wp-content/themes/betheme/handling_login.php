<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    global $wpdb;
    $table_team = $wpdb->prefix."members";
    $data_prepare = $wpdb->prepare("SELECT * FROM $table_team WHERE member_username = %s AND member_password=%s",$_POST['username'],sha1($_POST['password']));
    $data_team = $wpdb->get_row($data_prepare);
    if ($data_team && $data_team->member_status==1)
    {
        if ($data_team->type==0) {
            $_SESSION['login'] = 1;
            $_SESSION['id'] = $data_team->id;
            $_SESSION['member_username'] = $data_team->member_username;

            if(!empty($_POST["auto_login"])) {
                $_SESSION['auto_login'] = $_POST["auto_login"];
            }
            $url = home_url('member-top');
            wp_redirect($url);
            exit();
        }
        elseif($data_team->type==1)
        {
            $_SESSION['login'] = 1;
            $_SESSION['id'] = $data_team->id;
            $_SESSION['member_username'] = $data_team->member_username;
            $_SESSION['admin_login']=1;
            $url = home_url('admin-top');
            if(!empty($_POST["auto_login"])) {
                $_SESSION['auto_login'] = $_POST["auto_login"];
            }
            wp_redirect($url);
            exit();
        }
    }
    if ($data_team==null){
        $_SESSION['login'] ='thatbai_1';
        $url = home_url();
        wp_redirect($url);
        exit;
    }
    if ($data_team && $data_team->member_status==0 || $data_team->member_status==3)
    {
        $_SESSION['login'] ='thatbai_1';
        $url = home_url();
        wp_redirect($url);
        exit;
    }
    else
    {
        $_SESSION['login'] ='thatbai';
        $url = home_url();
        wp_redirect($url);
        exit;
    }
}
?>