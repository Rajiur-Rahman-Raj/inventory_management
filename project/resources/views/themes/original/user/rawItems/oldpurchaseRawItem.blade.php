<div class="procced-modal">
    <div class="modal fade show" id="proceedPurchaseModal" tabindex="-1" aria-labelledby="proccedOrderModal" aria-modal="true" role="dialog" style="display: block; padding-left: 0px;">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Make Payment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="total-amount d-flex align-items-center justify-content-between">
                        <h5>Total Order Amount</h5>
                        <h6 class="make-payment-total-amount">67.50 ৳</h6>
                    </div>
                    <div class="enter-amount d-flex justify-content-between align-items-center">
                        <h6>Customer Paid Amount</h6>
                        <input type="text" class="form-control customer-paid-amount" value="0" min="0" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" id="exampleFormControlInput1" name="customer_paid_amount">
                    </div>
                    <div class="change-amount d-flex align-items-center justify-content-between">
                        <h4 class="m-2 due-or-change-text">Due Amount</h4>  <span class="due-or-change-amount">67.50 ৳</span>
                        <input type="hidden" name="due_or_change_amount" class="due_or_change_amount_input" value="67.50">
                    </div>
                    <div class="total-amount d-flex align-items-center justify-content-between">
                        <h5>Total Payable Amount</h5>
                        <h6 class="total-payable-amount">67.50 ৳</h6>
                        <input type="hidden" name="total_payable_amount" class="total_payable_amount_input" value="67.50">
                    </div>
                    <div class="file">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Payment
                                Date</label>

                            <div class="flatpickr">
                                <div class="input-group">
                                    <input type="hidden" placeholder="Select Payment Date" class="form-control payment_date flatpickr-input" name="payment_date" value="" data-input=""><input class="form-control payment_date input" placeholder="Select Payment Date" tabindex="0" type="text" readonly="readonly">
                                    <div class="input-group-append" readonly="">
                                        <div class="form-control payment-date-times">
                                            <a class="input-button cursor-pointer" title="clear" data-clear="">
                                                <i class="fas fa-times" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="formFile" class="form-label">Payment Note                                                                            <span><sub>(optional)</sub></span></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Write payment note" rows="4" name="payment_note"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancel
                    </button>
                    <button type="submit" class="btn btn-primary">Confirm Order                                                                </button>
                </div>
            </div>
        </div>
    </div>
</div>
