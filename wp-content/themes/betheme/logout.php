<?php
session_unset("login");
session_unset("member_username");
$url = home_url();
wp_redirect($url);
?>