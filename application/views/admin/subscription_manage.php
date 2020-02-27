<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <button data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/subscription_add/' . $user_data->user_id; ?>" id="menu" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Subscription</button>
            <br>
            <br>
            <table class="table table-bordered">
                <thead>
                    <th><?php echo trans('subscriber_name'); ?></th>
                    <th><?php echo trans('email'); ?></th>
                    <th><?php echo trans('gender'); ?></th>
                    <th><?php echo trans('joining_date'); ?></th>
                    <th><?php echo trans('last_login'); ?></th>
                </thead>
                <tr>
                    <td><?php echo $user_data->name; ?></td>
                    <td><?php echo $user_data->email; ?></td>
                    <td><?php if ($user_data->gender == '1') {
                            echo "Male";
                        } else {
                            echo "Female";
                        } ?></td>
                    <td><?php echo date('d-m-Y', strtotime($user_data->join_date)); ?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($user_data->last_login)); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-12">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo trans('subscription_plan)'); ?></th>
                        <th><?php echo trans('from)'); ?></th>
                        <th><?php echo trans('to)'); ?></th>
                        <th><?php echo trans('payment_method)'); ?></th>
                        <th><?php echo trans('transaction_id)'); ?></th>
                        <th><?php echo trans('paid_amount)'); ?></th>
                        <th><?php echo trans('status)'); ?></th>
                        <th><?php echo trans('option)'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl = 1;
                    foreach ($subscriptions as $subscription) :
                        ?>
                        <tr id='row_<?php echo $subscription['subscription_id']; ?>'>
                            <td><?php echo $sl++; ?></td>
                            <td><strong><?php echo $this->subscription_model->get_plan_name_by_id($subscription['plan_id']); ?><?php if (time() > $subscription['timestamp_to']) {
                                                                                                                                        echo '(expired)';
                                                                                                                                    } ?></strong></td>
                            <td><?php echo date('d-m-Y', $subscription['timestamp_from']); ?></td>
                            <td><?php echo date('d-m-Y', $subscription['timestamp_to']); ?></td>
                            <td><?php echo $subscription['payment_method']; ?></td>
                            <td><?php echo $subscription['payment_info']; ?></td>
                            <td><?php echo $subscription['paid_amount']; ?></td>
                            <td><?php if ($subscription['status'] == '1') {
                                        echo 'ACTIVE';
                                    } else {
                                        echo "INACTIVE";
                                    } ?></td>
                            <td>
                                <div class="btn-group m-b-20">
                                    <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/subscription_edit/' . $subscription['subscription_id']; ?>" id="menu" title="<?php echo trans('edit'); ?>" class="btn btn-icon"><i class="fa fa-pencil"></i></a>
                                    <a title="<?php echo trans('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo " 'subscription' " . ',' . $subscription['subscription_id']; ?>)" class="delete"><i class="fa fa-remove"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
    });
</script>

<!-- select2-->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- select2-->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>