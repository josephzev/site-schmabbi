(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/public/js/theme"],{

/***/ "./assets/resources/js/bootstrap.js":
/*!******************************************!*\
  !*** ./assets/resources/js/bootstrap.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// ---
// Initialize jQuery globally
window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"); // Required for OctoberCMS AJAX framework
// Initialize UIkit globally

window.UIkit = __webpack_require__(/*! uikit */ "./node_modules/uikit/dist/js/uikit.js");
window.UIkit.use(__webpack_require__(/*! uikit/dist/js/uikit-icons */ "./node_modules/uikit/dist/js/uikit-icons.js")); // Adds support for UIkit iconography

/***/ }),

/***/ "./assets/resources/js/theme.js":
/*!**************************************!*\
  !*** ./assets/resources/js/theme.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// ---
__webpack_require__(/*! ./bootstrap */ "./assets/resources/js/bootstrap.js");
/* YOUR CODE HERE */

/*scroll*/


var element = document.getElementById("navbar");
var path = window.location.pathname;
var page = path.split("/").pop();
UIkit.util.on('#nav-scroll', 'inview', function () {
  element.classList.remove("scroll");

  if (page != 'portfolio') {
    document.documentElement.style.setProperty("--line", "#fff");
  }
});
UIkit.util.on('#nav-scroll', 'outview', function () {
  element.classList.add("scroll");
  document.documentElement.style.setProperty("--line", "#990033");
});

/***/ }),

/***/ "./assets/resources/scss/theme.scss":
/*!******************************************!*\
  !*** ./assets/resources/scss/theme.scss ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*******************************************************************************!*\
  !*** multi ./assets/resources/js/theme.js ./assets/resources/scss/theme.scss ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /srv/october-projects/shmaby-site/themes/schmabbi/assets/resources/js/theme.js */"./assets/resources/js/theme.js");
module.exports = __webpack_require__(/*! /srv/october-projects/shmaby-site/themes/schmabbi/assets/resources/scss/theme.scss */"./assets/resources/scss/theme.scss");


/***/ })

},[[0,"/public/js/manifest","/public/js/vendor"]]]);