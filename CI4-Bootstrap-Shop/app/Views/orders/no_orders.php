<div class="orders-page mt-5">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 mb-5">
                <div class="text-center">
                    <div>
                        <i class="bi bi-box-seam" style="font-size: 15rem; color: #dee2e6;"></i>
                    </div>

                    <h4>No Orders Yet</h4>

                    <p class="text-muted mb-4">
                        You haven't placed any orders yet.
                        <br>Start shopping to see your orders here!
                    </p>

                    <div>
                        <a href="<?= base_url('/') ?>" class="btn fw-bold green-btn">Explore our products</a>
                        <p class="mt-2 fw-bold">OR</p>
                        <input type="text" class="form-control" placeholder="Enter your tracking number here" id="track">
                        <p class="error-message mt-3"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    $('.orders-page').html(response.html);
                }
            });
        }
    });
</script>