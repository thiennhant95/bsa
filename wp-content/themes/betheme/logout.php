<?php
session_unset("login");
session_unset("member_username");
unset( $_COOKIE['username'] );
setcookie( 'username', '', time() - ( 15 * 60 ) );
unset( $_COOKIE['username'] );
setcookie( 'username', '', time() - ( 15 * 60 ) );
$url = home_url();
wp_redirect($url);
?>