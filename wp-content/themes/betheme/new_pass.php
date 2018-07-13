<?php
if (isset($_POST['email_forgot']) && isset($_POST['password_new']) && isset($_POST['password_confirm']))
{
    if ($_POST['password_new']!=$_POST['password_confirm'])
    {
       $_SESSION['loi_forgot']=1;
        wp_redirect(base64_decode($_POST['return_url']));
        exit;
    }
    if (strlen($_POST['password_new'])<6)
    {
        $_SESSION['loi_forgot']=2;
        wp_redirect(base64_decode($_POST['return_url']));
        exit;
    }
    else
    {
        $table_team = $wpdb->prefix."members";
        $data_prepare = $wpdb->prepare("SELECT * FROM $table_team WHERE member_email = %s",$_POST['email_forgot']);
        $data_team = $wpdb->get_row($data_prepare);
        if ($data_team){
            $insert = $wpdb->update($table_team, array(
                'member_password'=>sha1(htmlspecialchars($_POST['password_new'])),
                'forgot_token'=>rand(1111,9999),
            ),array('member_email'=>$_POST['email_forgot'])
            );
            if ($insert)
            {
                wp_redirect(home_url('password-success'));
                exit;
            }
            else
            {
                $_SESSION['loi_forgot']=3;
                wp_redirect(base64_decode($_POST['return_url']));
                exit;
            }
        }
    }
}
else{
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    get_template_part( 404 );
    die();
}
?>