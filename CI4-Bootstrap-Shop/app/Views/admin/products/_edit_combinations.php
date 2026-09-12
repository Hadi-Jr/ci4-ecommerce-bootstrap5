<?php
foreach ($combinations as $combination) {
    ?>
    <div class="card mb-3 comb-card">
        <div class="card-body">
            <p class="card-title fw-semibold mb-2 text-center comb-name"></p>
            <div class="d-flex gap-2 mb-3">
                <input type="text" class="form-control comb-title-value" placeholder="Title (e.g., Color)"
                       required>
                <button type="button" class="btn btn-danger remove-comb-name">×</button>
            </div>

            <div class="row comb-values">
                <div class="col-12 col-md-6 combValueContainer mb-2">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title fw-semibold mb-3 text-center comb-value"></p>

                            <input type="text" class="form-control mb-2 comb-value-title" placeholder="Title"
                                   required>

                            <input type="text" class="form-control mb-2 sku" placeholder="Sku"
                                   required>

                            <input type="number" class="form-control mb-2 price" placeholder="Price"
                                   required>

                            <input type="text" class="form-control mb-2 promo" placeholder="Promo"
                                   value="0.0">

                            <input type="number" class="form-control mb-2 qty" placeholder="Quantity"
                                   required>

                            <button type="button" class="btn btn-danger btn-sm mt-2 fw-bold
                                                            removeCombValue">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-success btn-sm mt-2 fw-bold mt-2 add-comb-value">
                Add Comb Value
            </button>
        </div>
    </div>
<?php
}
