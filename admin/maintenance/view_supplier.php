<?php require_once('./../../config.php') ?>
<?php 
 $qry = $conn->query("SELECT * FROM `supplier_list` where  id = '{$_GET['id']}' ");
 if($qry->num_rows > 0){
     foreach($qry->fetch_assoc() as $k => $v){
         $$k=$v;
     }
 }
?>
<style>
#uni_modal .modal-footer {
    display: none;
}
</style>
<div class="container-fluid" id="print_out">
    <div id='transaction-printable-details' class='position-relative'>
        <div class="row">
            <fieldset class="w-100">
                <div class="col-12">

                    <dl>
                        <dt class="text-info">Tên:</dt>
                        <dd class="pl-3"><?php echo $name ?></dd>
                        <dt class="text-info">Địa chỉ:</dt>
                        <dd class="pl-3"><?php echo isset($address) ? $address : '' ?></dd>
                        <dt class="text-info">Người liên hệ:</dt>
                        <dd class="pl-3"><?php echo isset($cperson) ? $cperson : '' ?></dd>
                        <dt class="text-info">Liên hệ khác #:</dt>
                        <dd class="pl-3"><?php echo isset($contact) ? $contact : '' ?></dd>
                        <dt class="text-info">Trạng thái:</dt>
                        <dd class="pl-3">
                            <?php if($status == 1): ?>
                            <span class="badge badge-success rounded-pill">Đang hoạt động</span>
                            <?php else: ?>
                            <span class="badge badge-danger rounded-pill">Không hoạt động</span>
                            <?php endif; ?>
                        </dd>
                    </dl>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-12">
        <div class="d-flex justify-content-end align-items-center">
            <button class="btn btn-dark btn-flat" type="button" id="cancel" data-dismiss="modal">Đóng</button>
        </div>
    </div>
</div>


<script>
$(function() {
    $('.table td,.table th').addClass('py-1 px-2 align-middle')
})
</script>