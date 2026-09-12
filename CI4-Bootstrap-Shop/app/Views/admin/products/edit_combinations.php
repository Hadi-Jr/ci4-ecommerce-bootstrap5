<div class="row justify-content-center mt-5 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card p-4 shadow border-0">
            <form id="add-product-form">

                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h3 class="fw-bold">
                            Edit Combinations
                        </h3>
                    </div>
                </div>

                <div class="mb-4">
                    <select id="products-selector" name="product_id">
                        <option value="">Select an option</option>
                        <?php
                        foreach ($products ?? [] as $product) {
                            ?>
                            <option value="<?= $product->id ?>"><?= $product->name . ' - SKU: ' . $product->sku ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-4 variants">
                    <fieldset class="border rounded-3 p-3">
                        <legend class="float-none w-auto px-2 fs-6 fw-bold">
                            Product Variants
                        </legend>

                        <div class="combNameContainer mb-3">
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
                        </div>

                        <div>
                            <button type="button" class="btn btn-success btn-sm mt-2 fw-bold" id="addCombination">
                                Add Combination
                            </button>
                            <button type="button" class="btn btn-danger btn-sm mt-2 fw-bold ms-2" id="removeCombinations">
                                Remove All Combinations
                            </button>
                        </div>
                    </fieldset>

                    <div class="invalid-feedback"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn w-100 fw-bold btn-secondary" id="add-product-btn">
                            Edit Combinations
                        </button>
                    </div>
                </div>
            </form>
            <div class="mt-4" id="general-error"></div>
        </div>
    </div>
</div>

<div id="combinationTemplate" class="d-none">
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

                            <input type="file" class="form-control mb-2 comb-image"
                                   accept="image/*">

                            <input type="text" class="form-control mb-2 comb-value-title" placeholder="Title"
                                   required>

                            <input type="text" class="form-control mb-2 sku" placeholder="Sku"
                                   required>

                            <input type="number" class="form-control mb-2 price" placeholder="Price"
                                   required>

                            <input type="text" class="form-control mb-2" placeholder="Promo"
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
</div>

<div id="combValueTemplate" class="d-none">
    <div class="col-12 col-md-6 combValueContainer mb-2">
        <div class="card">
            <div class="card-body">
                <p class="card-title fw-semibold mb-3 text-center comb-value"></p>

                <input type="file" class="form-control mb-2 comb-image"
                       accept="image/*">

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