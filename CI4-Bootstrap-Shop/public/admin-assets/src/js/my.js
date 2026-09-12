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
    checkForEmptyVariations();
});

$(document).on('click', '.add-comb-value', function () {
    $(this).siblings('.comb-values').append($('#combValueTemplate .combValueContainer').clone(true));
    calculateCombinations();
})

$(document).on('click', '.removeCombValue', function () {
    const combCard = $(this).closest('.comb-card');
    const combValue = $(this).closest('.combValueContainer');
    const combValues = combCard.find('.combValueContainer');

    if (combValues.length === 1) {
        combCard.remove();
    } else {
        combValue.remove();
    }

    checkForEmptyVariations();
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
    checkForEmptyVariations();
    calculateCombinations();
});

$('.add-attribute').on('click', function () {
    $('.attributeContainer').append(
        $('#attributeTemplate .attr-row').clone(true)
    );
});

function calculateCombinations() {
    $('.combNameContainer .comb-card').each(function (combNameIndex) {
        $(this).find('.comb-name').text(`Comb Name ${combNameIndex + 1}`);

        $(this).find('.comb-title-value').attr('name', `combinations[${combNameIndex}][title]`);

        $(this).find('.combValueContainer').each(function (combValueIndex) {
            $(this).find('.comb-value').text(`Comb Value ${combValueIndex + 1}`);

            $(this).find('.comb-image')
                .attr('name', `combinations[${combNameIndex}][values][${combValueIndex}][comb-image]`);
            $(this).find('.comb-value-title')
                .attr('name', `combinations[${combNameIndex}][values][${combValueIndex}][title]`);

            $(this).find('.sku').attr('name', `combinations[${combNameIndex}][values][${combValueIndex}][sku]`);

            $(this).find('.price').attr('name', `combinations[${combNameIndex}][values][${combValueIndex}][price]`);

            $(this).find('.promo').attr('name', `combinations[${combNameIndex}][values][${combValueIndex}][promo]`);

            $(this).find('.qty').attr('name', `combinations[${combNameIndex}][values][${combValueIndex}][qty]`);
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


