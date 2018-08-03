<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['videos']))
    {
        global $wpdb;
        $table_videos = $wpdb->prefix . "video_rookie";
        $update_week = $wpdb->delete($table_videos,array('id'=>$_GET['videos']));
        $target_dir = $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/videos/";
        unlink($target_dir.$_GET['url']);
        wp_redirect('/admin-top');
    }
}
?>