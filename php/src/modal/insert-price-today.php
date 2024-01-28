<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insert Purchase Today</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display additional purchase details here -->
                <p>Purchase price of fresh latex as of <?php echo htmlspecialchars(date('Y-m-d')); ?></p>
                <!-- Form -->
                <div class="pt-2">
                    <form class="user" method="post" action="">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="price" placeholder="ราคาน้ำยางวันนี้" pattern="\d+" title="Please enter only numeric values">
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">Save</button>
                    </form>
                </div>
                <!-- end form -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>