<!-- NO RESULTS FOUND START -->
<div class="row mt-5 justify-content-center mb-5">
    <div class="col-12 col-md-9 text-center mt-5">
        <i class="fa-solid fa-magnifying-glass fs-1 mb-3"></i>
        <h5 class="fw-bold">No products found</h5>
        <p class="text-muted">We couldn't find any products matching your search.</p>
    </div>

    <div class="col-12 col-md-9 d-flex gap-2 w-50 mb-5">
        <input type="text" class="form-control rounded" placeholder="Search" aria-label="Search">
        <button class="btn green-btn fw-bold search-btn">Search</button>
    </div>
</div>

<script>
    $('.search-btn').on('click', function (e) {
        e.preventDefault();
        let search_value = $(this).siblings('input').val().trim();

        if (!search_value) {
            return;
        }

        window.location.href = '<?= base_url('/search') ?>' + '?query=' + encodeURIComponent(search_value);
    });
</script>

<!-- NO RESULTS FOUND END -->