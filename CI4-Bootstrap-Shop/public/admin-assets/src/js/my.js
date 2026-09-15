$("#statusSwitch").on("change", function () {
    const status_label = $('.status-label');
    this.checked
        ? status_label.text("Available")
        : status_label.text("Not Available");
});

$("#add-product-form input#product_name").on("input", function () {
    let name_value = this.value
        .replaceAll(" ", "-")
        .replaceAll("'", "-")
        .replaceAll("`", "-")
        .replaceAll(";", "-")
        .replaceAll("+", "-plus")
        .toLowerCase();

    $("#add-product-form input#slug").val(name_value);
});

$("button#addFeature").on("click", function () {
    $("#featureContainer").append($('#featuresTemplate .feature-row').clone(true));
});

$(document).on("click", ".remove-feature", function () {
    if ($(".feature-row").length > 1) {
        $(this).closest(".feature-row").remove();
    }
});

$(document).on('click', '.remove-comb-name', function () {
    $(this).closest('.card').remove();
    calculateCombinations();
});

$(document).on('click', '.add-comb-value', function () {
    $(this).siblings('.comb-values').append($('#combValueTemplate .combValueContainer').clone(true));
    calculateCombinations();
});

$(document).on('click', '.removeCombValue', function () {
    const combCard = $(this).closest('.comb-card');
    const combValue = $(this).closest('.combValueContainer');
    const combValues = combCard.find('.combValueContainer');

    if (combValues.length === 1) {
        combCard.remove();
    } else {
        combValue.remove();
    }

    calculateCombinations();
});

$('#addCombination').on('click', function () {
    let comb_name_container = $('.combNameContainer');
    if (comb_name_container.find('.comb-card').length === 0) {
        comb_name_container.empty();
    }
    comb_name_container.append($('#combinationTemplate .comb-card').clone(true));
    calculateCombinations();
});

$('#removeCombinations').on('click', function () {
    $('.combNameContainer .comb-card').remove();
    calculateCombinations();
});

$('.add-attribute').on('click', function () {
    $('.attributeContainer').append(
        $('#attributeTemplate .attr-row').clone(true)
    );
});
function calculateCombinations() {
    $('.combNameContainer .comb-card').each(function (combNameIndex) {
        const comb_name_id = $(this).data('combn-id');

        let comb_name_key = combNameIndex;
        if (comb_name_id !== undefined && comb_name_id !== '') {
            comb_name_key = comb_name_id;
        }

        $(this).find('.comb-name').text(`Comb Name ${combNameIndex + 1}`);

        $(this).find('.comb-title-value').attr('name', `combinations[${comb_name_key}][title]`);

        $(this).find('.combValueContainer').each(function (combValueIndex) {
            const comb_value_id = $(this).data('combv-id');

            let comb_value_key = combValueIndex;
            if (comb_value_id !== undefined && comb_value_id !== '') {
                comb_value_key = comb_value_id;
            }

            $(this).find('.comb-value').text(`Comb Value ${combValueIndex + 1}`);

            $(this).find('.comb-image').attr('name', `combinations[${comb_name_key}][values][${comb_value_key}][comb-image]`);
            $(this).find('.comb-value-title').attr('name', `combinations[${comb_name_key}][values][${comb_value_key}][title]`);
            $(this).find('.sku').attr('name', `combinations[${comb_name_key}][values][${comb_value_key}][sku]`);
            $(this).find('.price').attr('name', `combinations[${comb_name_key}][values][${comb_value_key}][price]`);
            $(this).find('.promo').attr('name', `combinations[${comb_name_key}][values][${comb_value_key}][promo]`);
            $(this).find('.qty').attr('name', `combinations[${comb_name_key}][values][${comb_value_key}][qty]`);
        });
    });
}

$(document).on('click', '.remove-attribute', function () {
    $(this).closest('.attr-row').remove();
});

$('#products-selector').select2({
    placeholder: 'Choose a product',
    allowClear: false,
    minimumResultsForSearch: 0,
    theme: 'bootstrap-5',
    width: '100%'
}).on('select2:open', function() {
    $('.select2-search__field').css({
        'outline': 'none',
        'box-shadow': 'none',
        'border-color': '#ced4da'
    });
});

$(document).ready(function () {
    $('#productsTable').DataTable({
        responsive: true,
        pageLength: 15,
        lengthMenu: [
            [15, 25, 50, 100, -1],
            [15, 25, 50, 100, "All"]
        ],
        order: [
            [
                0,
                'asc'
            ]
        ],
        columnDefs: [
            {
                orderable: false,
                targets: [8]
            }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search products...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ products",
            infoEmpty: "No products found",
            infoFiltered: "(filtered from _MAX_ total)",
            zeroRecords: "No matching products found",
            paginate: {
                first: "«",
                last: "»",
                next: "›",
                previous: "‹"
            }
        }
    });
});

$(document).ready(function () {
    $('#categoriesTable').DataTable({
        responsive: true,
        pageLength: 15,
        lengthMenu: [
            [15, 25, 50, 100, -1],
            [15, 25, 50, 100, "All"]
        ],
        order: [
            [0, 'asc']
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search categories...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ categories",
            infoEmpty: "No categories found",
            infoFiltered: "(filtered from _MAX_ total)",
            zeroRecords: "No matching categories found",
            paginate: {
                first: "«",
                last: "»",
                next: "›",
                previous: "‹"
            }
        }
    });
});