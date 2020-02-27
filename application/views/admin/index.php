<?php
    $system_name              =   $this->db->get_where('config', array('title' => 'system_name'))->row()->value;
    $system_short_name        =   $this->db->get_where('config', array('title' => 'system_short_name'))->row()->value;
    $site_name                =   $this->db->get_where('config', array('title' => 'site_name'))->row()->value;
    $business_address         =   $this->db->get_where('config', array('title' => 'business_address'))->row()->value;
    $system_email             =   $this->db->get_where('config', array('title' => 'system_email'))->row()->value;
    $business_phone           =   $this->db->get_where('config', array('title' => 'business_phone'))->row()->value;
    $color                    =   $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->theme_color;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Abdul Mannan">
    <meta name="copyright" content="Copyright (c) 2014 - 2018 SpaGreen">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <!-- CSS-->

    <!-- select2 CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.css" rel="stylesheet" />

    <!-- main CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <!-- icon CSS -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--summernote CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/summernote/dist/summernote.css" rel="stylesheet" />


    <!--Jquery JS -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
    <title><?php echo $page_title . '-' . $system_short_name; ?></title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
</head>

<body class="app sidebar-mini rtl <?php //if(isset($page_name) && ($page_name=='videos_add' || $page_name=='videos_edit'|| $page_name=='videos_manage')){ echo 'sidebar-collapse';}  
                                    ?>">
    <!-- Navbar-->
    <header class="app-header hidden-print"><a class="app-header__logo" href="<?php echo base_url(); ?>">
            <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="Ovoo" height="30" style="margin-top:-15px;"></a>
        <!-- Sidebar toggle button-->
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!-- visit website -->
            <li><a class="app-nav__item" href="<?php echo base_url(); ?>" target="_blank"><?php echo trans('visit_website'); ?></a></li>
            <!-- language switch -->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" style="text-transform: capitalize;"><?php echo $this->language_model->language_by_id($this->session->userdata('active_language_id')); ?></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <?php
                        $languages = $this->language_model->get_languages();
                        foreach ($languages as $language) : ?>
                        <li><a class="dropdown-item" href="<?php echo base_url('language/switch/').$language->short_form; ?>"><?php echo $language->name; ?></a></li>
                    <?php endforeach; ?>                    
                </ul>
            </li>
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><img src="<?php echo $this->common_model->get_img('user', $this->session->userdata('user_id')) . '?' . time(); ?>" class="img-circle" alt="photo" height="20"></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/manage_profile"><i class="fa fa-user fa-lg"></i> <?php echo trans('profile'); ?></a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>admin/manage_profile"><i class="fa fa-lock fa-lg" aria-hidden="true"></i><?php echo trans('change_password'); ?> </a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out fa-lg"></i> <?php echo trans('logout'); ?></a></li>
                </ul>
            </li>
        </ul>
    </header>
    <?php include 'navigation.php'; ?>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><?php echo $page_title; ?></h1>
            </div>
        </div>
        <?php include $page_name . '.php'; ?>
    </main>
    <footer class="footer text-right"> <?php echo date("Y"); ?> &copy; <a href="https://codecanyon.net/item/ovoomovie-video-steaming-cms/20180569">OVOO - <?php echo ovoo_config('version'); ?></a> |
        <?php echo trans('developed_by'); ?>: <a href="http://www.spagreen.net">SpaGreen Creative</a></footer>
    <!-- ajax modal  -->

    <div id="mymodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title text-light"><?php echo $page_title; ?></h3>
                    </div>
                    <div class="modal-body">
                        <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url(); ?>assets/images/preloader.gif" /> </div>

                        <!-- content will be load here -->
                        <div id="dynamic-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '#menu', function(e) {
                e.preventDefault();
                var url = $(this).data('id'); // it will get action url
                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show(); // load ajax loader
                $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'html'
                    })
                    .done(function(data) {
                        console.log(data);
                        $('#dynamic-content').html('');
                        $('#dynamic-content').html(data); // load response 
                        $('#modal-loader').hide(); // hide ajax loader 
                    })
                    .fail(function() {
                        $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                        $('#modal-loader').hide();
                    });
            });
        });
    </script>
    <!-- END Ajax modal  -->

    <!-- Ajax Delete -->
    <script type="text/javascript">
        function delete_row2(table_name, row_id) {
            var table_row = '#row_' + row_id
            var base_url = '<?php echo base_url(); ?>'
            url = base_url + 'admin/delete_record/'
            swal({
                title: "Are you Sure??",
                text: "it will be delete permanently",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3CB371',
                cancelButtonText: "Cancel",
                confirmButtonText: "yes! Delete it.",
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                            url: url,
                            type: 'POST',
                            data: 'row_id=' + row_id + '&table_name=' + table_name,
                            dataType: 'json'
                        })
                        .done(function(response) {
                            //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            swal("Deleted", response.message, response.status);
                            $(table_row).fadeOut(2000);
                        })
                        .fail(function() {
                            swal('Oops...', response.message, response.status);
                        });
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        }
    </script>
    <script type="text/javascript">
        function delete_row(table_name, row_id) {
            var table_row = '#row_' + row_id
            var base_url = '<?php echo base_url(); ?>'
            url = base_url + 'admin/delete_record/'
            swal({
                    title: 'Are you sure?',
                    text: "It will be deleted permanently!",
                    icon: "warning",
                    buttons: true,
                    buttons: ["Cancel", "Delete"],
                    dangerMode: true,
                    closeOnClickOutside: false
                })
                .then(function(confirmed) {
                    if (confirmed) {
                        $.ajax({
                                url: url,
                                type: 'POST',
                                data: 'row_id=' + row_id + '&table_name=' + table_name,
                                dataType: 'json'
                            })
                            .done(function(response) {
                                swal.stopLoading();
                                swal("Deleted!", response.message, response.status);
                                $(table_row).fadeOut(2000);
                            })
                            .fail(function() {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                            })
                    }
                })
        }
    </script>
    <!-- END Ajax Delete -->

    <!-- Essential javascripts for application to work-->
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url(); ?>assets/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!--sweet alert2 JS -->
    <script src="<?php echo base_url(); ?>assets/js/plugins/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            var success_message = '<?php echo $this->session->flashdata('success'); ?>';
            var error_message = '<?php echo $this->session->flashdata('error'); ?>';
            if (success_message != '') {
                swal('Success!', success_message, 'success');
            }
            if (error_message != '') {
                swal('Error!', error_message, 'error');
            }
        });
    </script>
    <!--END sweet alert2 JS -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $('#datatable').DataTable();
    </script>
</body>

</html>