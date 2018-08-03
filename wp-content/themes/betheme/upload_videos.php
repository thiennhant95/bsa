<?php
global $wpdb;
$table_videos = $wpdb->prefix . "video_rookie";
$table_week = $wpdb->prefix . "week";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name_videos']))
    {
        $name =$_POST['name_videos'];
    }
    else{
        $name= '';
    }
    $insert = $wpdb->update($table_videos, array(
        'video_name' => $name,
        'content' => $_POST['describe'],
        'video_type'=>$_POST['free']
    ), array('id' => $_GET['videos'])
    );
    if (isset($_POST['num_week']))
    {
        $update = $wpdb->update($table_week, array(
            'content_week' => $_POST['describe'],
        ), array('num_week' => $_POST['num_week'])
        );
    }
    $_SESSION['success_videos'] = 1;
    $url = home_url('admin-edit-video/?videos='.$_GET['videos']);
    wp_redirect($url);
    exit;
}
?>

