<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
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
                        <p><strong>เลขที่ใบเสร็จ:</strong> <?php echo htmlspecialchars($info['id']); ?></p>
                        <p><strong>ชื่อลูกค้า:</strong> <?php echo htmlspecialchars($info['username']); ?></p>
                        <p><strong>วันที่:</strong> <?php echo htmlspecialchars($info['create_date']); ?></p>
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
                                <td><?php echo htmlspecialchars(number_format($info['weighed'], 2)); ?></td>
                                <td><?php echo htmlspecialchars(number_format($info['percentage'], 2)); ?></td>
                                <td><?php echo htmlspecialchars(number_format($info['price_total'], 2)); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="total">
                        <p><strong>ยอดรวม:</strong> <?php echo htmlspecialchars(number_format($info['price_total'], 2)); ?></p>
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