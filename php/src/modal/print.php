<div class="modal fade" id="printModal<?php echo $info['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Print Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="receipt">
                    <div class="header">
                        <h2>ใบเสร็จ</h2>
                    </div>
                    <div class="info">
                        <p><strong>ชื่อลูกค้า:</strong> <?php echo $info['username']; ?></p>
                        <p><strong>วันที่:</strong> <?php echo $info['create_date']; ?></p>
                    </div>

                    <table class="items">
                        <thead>
                            <tr>
                                <th>น้ำหนักน้ำยางสด</th>
                                <th>เปอร์เซ็นต์ที่ได้</th>
                                <th>จำนวนเงินที่ได้รับ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $info['weighed']; ?></td>
                                <td><?php echo $info['percentage']; ?></td>
                                <td><?php echo $info['price_total']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="total">
                        <p><strong>ยอดรวม:</strong> <?php echo $info['price_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- เพิ่มปุ่ม "Print" หรือปุ่มอื่น ๆ ตามต้องการ -->
                <button type="button" class="btn btn-primary">Print</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>