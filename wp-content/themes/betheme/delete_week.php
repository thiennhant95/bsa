<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['week']))
    {
        global $wpdb;
        $table_videos = $wpdb->prefix . "video_rookie";

        $query_video_a = "SELECT * FROM $table_videos WHERE week =". $_GET['week'];
        $data_video_a =$wpdb->get_results($query_video_a);
        $target_dir = $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/videos/";
        foreach ($data_video_a as $row)
        {
            echo $row->video_url;
            unlink($target_dir.$row->video_url);
        }

        $update_videos = $wpdb->delete($table_videos,array('week'=>$_GET['week']));
        $table_week = $wpdb->prefix . "week";
        $update_week = $wpdb->delete($table_week,array('num_week'=>$_GET['week']));

        wp_redirect('/admin-top');


    }
}
?>