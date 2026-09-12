var basicRating;
document.querySelector("#fast-product-rater") &&
(basicRating = raterJs({
  starSize: 22,
  rating: Number(document.querySelector("#fast-product-rating").dataset.rating),
  element: document.querySelector("#fast-product-rater"),
  rateCallback: function (e, t) {
    this.setRating(e);
    document.querySelector("#fast-product-rating").value = e;
    t();
  },
}));

document.querySelector("#main-product-rater") &&
  (basicRating = raterJs({
    starSize: 15,
    rating: 0,
    element: document.querySelector("#main-product-rater"),
    rateCallback: function (e, t) {
      this.setRating(e);
      document.querySelector("#main-product-rating").value = e;
      t();
    },
  }));

document.querySelector("#basic-rater5") &&
  (basicRating = raterJs({
    starSize: 22,
    rating: 1,
    element: document.querySelector("#basic-rater5"),
    rateCallback: function (e, t) {
      (this.setRating(e), t());
    },
  }));

document.querySelectorAll(".review-rater").forEach(function (element) {
  raterJs({
    starSize: 22,
    rating: Number(element.dataset.rating),
    readOnly: true,
    element: element,
  });
});
