<?php
/**
 * Plugin Name: Members
 * Description: Quản Lý Công Ty
 * Version: 1.0
 * Author: Nhan
 */
define('TEAM_FILTER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TEAM_FILTER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TEAM_FILTER_INCLUDES_DIR', plugin_dir_path(__FILE__));

function cm_create_menu_member()
{
        global $wpdb;
        $table_products = $wpdb->prefix."members";
        $data = "SELECT * FROM $table_products WHERE type=0 ORDER BY id DESC";
        $product_list =$wpdb->get_results($data);
        ?>
    <style>
        .alert-danger, .alert-success {
            color: #ffffff;
            padding: 1%;
            border-radius: 10px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #d53239;
            margin-bottom: 3%;
        }

        .alert-success {
            background-color: #5cb85c;
            margin-bottom: 3%;
        }
        input[type=submit],input[type=reset],input[type=button]{
            background-color: #3d4247;
            border-radius: 10px!important;
            width: 20%;
        }
        .add-member:hover{
            text-decoration: none;
            color: #AF0000!important;
        }
    </style>
        <div class="content-wrapper" <?php if (isset($_GET['type'])) echo 'style="display: none"'?>>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #0A246A">Members</h3>
                    <p>
                        <?php
                        if (isset($_SESSION['thongbaoloi1']) && $_SESSION['thongbaoloi1']=='1'):
                        ?>
                    <div class="alert-danger">
                       Cập nhật không thành công. Vui lòng thử lại!.
                    </div>
                    <?php
                    $_SESSION['thongbaoloi1']='0';
                    endif;
                    ?>
                    <?php
                    if (isset($_SESSION['success1']) && $_SESSION['success1']=='1'):
                        ?>
                        <div class="alert-success">
                           Cập nhật dữ liệu thành công.
                        </div>
                        <?php
                        $_SESSION['success1']='0';
                    endif;
                    ?>
                    </p>
                    <!--            <br/>-->
                    <span class="box-title" style="float: right;background-color: #0A246A;margin-bottom: 1%;padding: 1.5%"><a style="color: #ffffff;font-weight: bold;font-size: 16px" class="add-member" href="/admin-members/?type=add">Add Members</a></span>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table style="overflow-x:auto;" id="member-table" class="table table-bordered table-striped members-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>User name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                            <th>Function</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        foreach ($product_list as $row)
                        {
                            ?>
                            <tr>
                                <td><?php echo $row->id?></td>
                                <td><?php echo $row->member_username?></td>
                                <td><?php echo $row->member_email?></td>
                                <td><?php echo $row->member_phone?></td>
                                <td><?php echo $row->member_date ?></td>
                                <td id="status<?php echo $row->id ?>"><?php echo $row->	member_status==1?'<span class="badge bg-green">Đang hoạt động</span>':'<span class="badge bg-red">Bị khóa</span>'?></td>
                                <td>
                                    <a style="color: #0A246A" class="btn btn-info" href="<?php echo home_url('admin-members/?type=update&email='.$row->member_email)?>">Edit</a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap.min.js"></script>
        <style>
            #member-table td
            {
                vertical-align:middle;
            }
            .bg-green{
                background-color: #5cb85c;
                border-radius: 10px;
                padding: 2%;
            }
            .bg-red{
                background-color: orangered;
                border-radius: 10px;
                padding: 2%;
            }
            .members-table, td, tr,th{
                border: 1px solid #1c2d3f!important;
            }
            select.input-sm {
                line-height: 15px;
            }
            .members-table td{
                color: #1c2d3f;
            }
        </style>
        <?php

        if (isset($_GET['type']) && $_GET['type']=='add')
        {
            ?>
            <style>
                input[type=text], input[type=email],input[type=password],input[type=number],select{
                    border: 1px solid #2d6987;
                    color: #1c2d3f;
                }
                span{
                    color: #1c2d3f;
                }
                td:nth-child(odd){
                    width: 100px;
                    border: none;
                }
                td, tr,th{
                    border: none!important;
                }
                .alert-danger,.alert-success{
                    color: #ffffff;
                    padding: 1%;
                    border-radius: 10px;
                    font-size: 14px;
                }
                .alert-danger{
                    background-color: #d53239;
                }
                .alert-success{
                    background-color: #5cb85c;
                }
            </style>
            <div class="content-wrapper">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="color: #0A246A">Add Members</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p>
                            <?php
                            if (isset($_SESSION['thongbaoloi']) && $_SESSION['thongbaoloi']=='1'):
                            ?>
                        <div class="alert-danger">
                            User name đã tồn tại.
                        </div>
                        <?php
                        $_SESSION['thongbaoloi']='0';
                        endif;
                        ?>
                        <?php
                        if (isset($_SESSION['thongbaoloi']) && $_SESSION['thongbaoloi']=='2'):
                            ?>
                            <div class="alert-danger">
                                Email đã tồn tại.
                            </div>
                            <?php
                            $_SESSION['thongbaoloi']='0';
                        endif;
                        if (isset($_SESSION['thongbaoloi']) && $_SESSION['thongbaoloi']=='3'):
                            ?>
                            <div class="alert-danger">
                                Thêm mới không thành công. Vui lòng thử lại.
                            </div>
                            <?php
                            $_SESSION['thongbaoloi']='0';
                        endif;
                        if (isset($_SESSION['thongbaoloi']) && $_SESSION['thongbaoloi']=='4'):
                            ?>
                            <div class="alert-danger">
                                Thêm mới không thành công. Vui lòng thử lại.
                            </div>
                            <?php
                            $_SESSION['thongbaoloi']='0';
                        endif;
                        if (isset($_SESSION['success']) && $_SESSION['success']=='1'):
                            ?>
                            <div class="alert-success">
                                Thêm thành viên mới thành công.
                            </div>
                            <?php
                            $_SESSION['success']='0';
                        endif;
                        ?>
                        </p>
                        <form action="<?php echo home_url('test')?>" method="post">
                            <table style="border: 1px solid;width: 50%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td><span>Username</span></td>
                                    <td><input type="text" name="username" required></td>
                                </tr>
                                <tr>
                                    <td><span>Password</span></td>
                                    <td><input type="password" name="password" minlength="6" required></td>
                                </tr>
                                <tr>
                                    <td><span>Email</span> </td>
                                    <td><input type="email" name="email" required></td>
                                </tr>
                                <tr>
                                    <td><span>Company/ School</span></td>
                                    <td><input type="text" name="company"></td>
                                </tr>
                                <tr>
                                    <td><span>Phone</span></td>
                                    <td><input type="number" name="phone" required></td>
                                </tr>
                                <tr>
                                    <td><span>Status</span></td>
                                    <td>
                                        <select name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <a href="/admin-members/"><input type="button" value="Quay lại"></a>
                            <input type="submit" value="Thêm" name="add">
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
    if (isset($_GET['type']) && $_GET['type']='update' && isset($_GET['email'])) {
        $data_prepare_name1 = $wpdb->prepare("SELECT * FROM $table_products WHERE member_email = %s", $_GET['email']);
        $data_team_name1 = $wpdb->get_row($data_prepare_name1);
        if ($data_team_name1) {
            ?>
            <style>
                input[type=text], input[type=email], input[type=password], input[type=number], select {
                    border: 1px solid #2d6987;
                    color: #1c2d3f;
                }

                span {
                    color: #1c2d3f;
                }

                td:nth-child(odd) {
                    width: 100px;
                    border: none;
                }

                td, tr, th {
                    border: none !important;
                }
            </style>
            <div class="content-wrapper">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="color: #0A246A">Add Members</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="<?php echo home_url('test') ?>" method="post">
                            <table style="border: 1px solid;width: 50%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td><span>Username</span></td>
                                    <td><input readonly type="text" name="username" required value="<?php echo $data_team_name1->member_username?>"></td>
                                </tr>
                                <tr>
                                    <td><span>Email</span></td>
                                    <td><input readonly type="email" name="email" value="<?php echo $data_team_name1->member_email?>" required></td>
                                </tr>
                                <tr>
                                    <td><span>Company/ School</span></td>
                                    <td><input type="text" name="company" value="<?php echo $data_team_name1->member_company?>" ></td>
                                </tr>
                                <tr>
                                    <td><span>Phone</span></td>
                                    <td><input type="number" name="phone" value="<?php echo $data_team_name1->member_phone?>" required></td>
                                </tr>
                                <tr>
                                    <td><span>Status</span></td>
                                    <td>
                                        <select name="status">
                                            <option value="1" <?php if ($data_team_name1->member_status==1) echo 'selected'?>>Active</option>
                                            <option value="0"<?php if ($data_team_name1->member_status==0) echo 'selected'?> >Inactive</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <a href="/admin-members/"><input type="button" value="Quay lại"></a>
                            <input type="submit" value="Update" name="update">
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        else
        {
            echo "Tài khoản thành viên không tồn tại.";
        }
    }
}
add_shortcode('admin_member', 'cm_create_menu_member');

?>
