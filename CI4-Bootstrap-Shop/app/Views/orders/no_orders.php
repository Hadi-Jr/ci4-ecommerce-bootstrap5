<div class="text-center py-5 mt-5 no-orders">
    <i class="fa-solid fa-box text-secondary" style="font-size: 5rem;"></i>
    <h3 class="mt-3 mb-1">No orders yet</h3>
    <p class="text-muted small mb-0">Items you order will show up here</p>

    <div class="row justify-content-center mt-4">
        <div class="col-md-6 col-lg-5">
            <div class="text-center">
                <div>
                    <a href="<?= base_url('/') ?>" class="btn fw-bold green-btn">Explore our products</a>
                    <p class="mt-2 fw-bold">OR</p>
                    <input type="text" class="form-control" placeholder="Enter your tracking number here" id="track">
                    <p class="text-danger error-message mt-3"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-none text-center mt-3 mt-lg-5 orders-page"></div>

<script>
    $('#track').on('input', function () {
        let input_val = $(this).val();

        if (input_val.length === 21) {
            $.ajax({
                url: '<?= base_url('/order/track/') ?>' + input_val,
                method: 'GET',
                dataType: 'json'
            }).done(function (response) {
                if (response.status === 'error') {
                    $('.error-message').html(response.message);
                } else {
                    const order_page = $('.orders-page');
                    order_page.removeClass('d-none');
                    order_page.html(response.html);
                    $('.no-orders').remove();
                }
            });
        }
    });
</script>