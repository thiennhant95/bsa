<?php
function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }
    return $str;
}

function CovertVn($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ặ|ẳ|ẵ|ắ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ặ|Ẳ|Ẵ|Ắ)/", 'a', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'e', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'o', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'u', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'y', $str);
    $str = preg_replace("/(Đ)/", 'd', $str);
    $str = strtolower($str);
    $str = preg_replace("/( )/", '-', $str);
    return $str;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    print_r($_FILES['videos']);
//    die();
    $table_week = $wpdb->prefix . "week";
    $table_videos = $wpdb->prefix . "video_rookie";
    if ($_POST['name_videos']==''){
        if($_POST['kind']!=1){
            $_SESSION['error_videos']=1;
            $url = home_url('admin-top');
            wp_redirect($url);
            exit;
        }
    }
//    if ($_POST['videos']==''){
//        $_SESSION['error_videos']=2;
//        $url = home_url('admin-top');
//        wp_redirect($url);
//        exit;
//    }
    if ($_POST['free']==''){
        $_POST['free']=1;
    }
    if ($_POST['kind']==1)
    {
        if ($_POST['name_week']==''){
            $_SESSION['error_videos']=3;
            $url = home_url('admin-top');
            wp_redirect($url);
            exit;
        }
        $data_prepare = $wpdb->prepare("SELECT * FROM $table_week WHERE num_week = %s",$_POST['id_week']);
        $data_week = $wpdb->get_row($data_prepare);
        if ($data_week)
        {
            $update_week = $wpdb->update($table_week, array(
                'name_week'=>$_POST['name_week'],
                'content_week'=>$_POST['describe'],
            ),array('num_week'=>$_POST['id_week']));

            $last_insert_id = $_POST['id_week'];
            $name = rand_string(5).CovertVn($_FILES['videos']['name']);
            $target_dir = WP_CONTENT_DIR . "/uploads/videos/";
            move_uploaded_file($_FILES['videos']['tmp_name'],$target_dir.$name);
            $url = $target_dir.$name;

            $insert_videos = $wpdb->insert($table_videos, array(
//                'video_name'=>$_POST['name_videos'],
                'category'=>1,
                'post'=>$_POST['post'],
                'video_url'=>$name,
                'video_type'=>$_POST['free'],
                'week'=>$_POST['id_week']
            ));
            $_SESSION['success_videos']=1;
            $url = home_url('admin-top');
            wp_redirect($url);
            exit;
        }
        else{
            $insert_week = $wpdb->insert($table_week, array(
                'num_week'=>$_POST['id_week'],
                'name_week'=>$_POST['name_week'],
                'content_week'=>$_POST['describe'],
            ));
            $last_insert_id = $wpdb->insert_id;
            $name = rand_string(5).CovertVn($_FILES['videos']['name']);
            $target_dir = WP_CONTENT_DIR . "/uploads/videos/";
            move_uploaded_file($_FILES['videos']['tmp_name'],$target_dir.$name);
            $url = $target_dir.$name;

            $insert_videos = $wpdb->insert($table_videos, array(
//                'video_name'=>$_POST['name_videos'],
                'category'=>1,
                'post'=>$_POST['post'],
                'video_url'=>$name,
                'video_type'=>$_POST['free'],
                'week'=>$_POST['id_week']
            ));
            $_SESSION['success_videos']=1;
            $url = home_url('admin-top');
            wp_redirect($url);
            exit;
        }
    }
    elseif($_POST['kind']==2){
        $name = rand_string(5).CovertVn($_FILES['videos']['name']);
        $target_dir = WP_CONTENT_DIR . "/uploads/videos/";
        move_uploaded_file($_FILES['videos']['tmp_name'],$target_dir.$name);
        $url_videos = $target_dir.$name;

        $insert_videos = $wpdb->insert($table_videos, array(
            'video_name'=>$_POST['name_videos'],
            'category'=>2,
            'video_url'=>$name,
            'video_type'=>$_POST['free'],
            'week'=>0,
            'content'=>$_POST['describe'],
        ));
        $_SESSION['success_videos']=1;
        $url = home_url('admin-top');
        wp_redirect($url);
        exit;
    }
    else{
        $name = rand_string(5).CovertVn($_FILES['videos']['name']);
        $target_dir = WP_CONTENT_DIR . "/uploads/videos/";
        move_uploaded_file($_FILES['videos']['tmp_name'],$target_dir.$name);
        $url_videos = $target_dir.$name;

//        $folder = WP_CONTENT_DIR . "/uploads/videos/";
//        $filename = $name;
//        $newFilename = pathinfo($filename, PATHINFO_FILENAME).'.mp4';
//        exec('/usr/bin/ffmpeg -y -i '.$folder.DIRECTORY_SEPARATOR.$filename.' -c:v libx264 -c:a aac -pix_fmt yuv420p -movflags faststart -hide_banner '.$folder.DIRECTORY_SEPARATOR.$newFilename.' 2>&1', $out, $res);
//        die();
        $insert_videos = $wpdb->insert($table_videos, array(
            'video_name'=>$_POST['name_videos'],
            'category'=>0,
            'video_url'=>$name,
            'video_type'=>0,
            'week'=>0,
            'content'=>$_POST['describe'],
        ));
        $_SESSION['success_videos']=1;
        $url = home_url('admin-top');
        wp_redirect($url);
        exit;
    }
}
?>