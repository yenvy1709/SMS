<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Danh sách đơn đặt hàng</h3>
        <div class="card-tools">
            <a href="<?php echo base_url ?>admin/?page=purchase_order/manage_po" class="btn btn-flat btn-primary"><span
                    class="fas fa-plus"></span> Tạo mới</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="20%">
                        <col width="20%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th> STT </th>
                            <th> Ngày tạo</th>
                            <th>Mã gửi hàng</th>
                            <th>Nhà cung cấp</th>
                            <th>Mặt hàng</th>
                            <th>Trạng thái</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT p.*, s.name as supplier FROM `purchase_order_list` p inner join supplier_list s on p.supplier_id = s.id order by p.`date_created` desc");
                        while($row = $qry->fetch_assoc()):
                            $row['items'] = $conn->query("SELECT count(item_id) as `items` FROM `po_items` where po_id = '{$row['id']}' ")->fetch_assoc()['items'];
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                            <td><?php echo $row['po_code'] ?></td>
                            <td><?php echo $row['supplier'] ?></td>
                            <td class="text-right"><?php echo number_format($row['items']) ?></td>
                            <td class="text-center">
                                <?php if($row['status'] == 0): ?>
                                <span class="badge badge-primary rounded-pill">Chưa giải quyết</span>
                                <?php elseif($row['status'] == 1): ?>
                                <span class="badge badge-warning rounded-pill">Đang xử lý</span>
                                <?php elseif($row['status'] == 2): ?>
                                <span class="badge badge-success rounded-pill">Đã nhận</span>
                                <?php else: ?>
                                <span class="badge badge-danger rounded-pill">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button"
                                    class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                    data-toggle="dropdown">
                                    Chi tiết
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <?php if($row['status'] == 0): ?>

                                    <a class="dropdown-item"
                                        href="<?php echo base_url.'admin?page=receiving/manage_receiving&po_id='.$row['id'] ?>"
                                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-boxes text-dark"></span>
                                        Đã nhận</a>
                                    <div class="dropdown-divider"></div>
                                    <?php endif; ?>
                                    <a class="dropdown-item"
                                        href="<?php echo base_url.'admin?page=purchase_order/view_po&id='.$row['id'] ?>"
                                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span>
                                        Xem</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="<?php echo base_url.'admin?page=purchase_order/manage_po&id='.$row['id'] ?>"
                                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span>
                                        Sửa</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)"
                                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span>
                                        Xoá</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.delete_data').click(function() {
        _conf("Bạn có chắc chắn xóa đơn đặt hàng này vĩnh viễn?", "delete_po", [$(this).attr(
            'data-id')])
    })
    $('.view_details').click(function() {
        uni_modal("Chi tiết thanh toán", "transaction/view_payment.php?id=" + $(this).attr('data-id'),
            'mid-large')
    })
    $('.table td,.table th').addClass('py-1 px-2 align-middle')
    $('.table').dataTable();
})

function delete_po($id) {
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=delete_po",
        method: "POST",
        data: {
            id: $id
        },
        dataType: "json",
        error: err => {
            console.log(err)
            alert_toast("Đã xảy ra lỗi.", 'error');
            end_loader();
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("Đã xảy ra lỗi.", 'error');
                end_loader();
            }
        }
    })
}
</script>