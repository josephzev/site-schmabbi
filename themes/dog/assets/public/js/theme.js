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

  if (page != 'portfolio' || page != 'gallery') {
    document.documentElement.style.setProperty("--line", "#fff");
  }
});
UIkit.util.on('#nav-scroll', 'outview', function () {
  element.classList.add("scroll");
  document.documentElement.style.setProperty("--line", "#990033");
});
/*scroll*/

UIkit.util.on('#lightbox', 'show', function () {
  console.log('hello');
});
/*filter*/

(function ($) {
  $('#galleryFilter').on('change', 'input,select', function () {
    var $form = $(this).closest('form');
    console.log($form);
    $form.request();
  });
})(jQuery);
/*fullscreen*/

/* Get the documentElement (<html>) to display the page in fullscreen */


var elem = document.documentElement;
/* View in fullscreen */

document.getElementById('btnfull').onclick = function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.webkitRequestFullscreen) {
    /* Safari */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) {
    /* IE11 */
    elem.msRequestFullscreen();
  }
};
/* Close fullscreen */


function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) {
    /* Safari */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) {
    /* IE11 */
    document.msExitFullscreen();
  }
}

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

__webpack_require__(/*! /srv/october-projects/schmabbi-new/themes/dog/assets/resources/js/theme.js */"./assets/resources/js/theme.js");
module.exports = __webpack_require__(/*! /srv/october-projects/schmabbi-new/themes/dog/assets/resources/scss/theme.scss */"./assets/resources/scss/theme.scss");


/***/ })

},[[0,"/public/js/manifest","/public/js/vendor"]]]);