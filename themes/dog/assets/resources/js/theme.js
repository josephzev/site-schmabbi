// ---
require('./bootstrap'); 

/* YOUR CODE HERE */

/*scroll*/

var element = document.getElementById("navbar");

var path = window. location. pathname;
var page = path. split("/"). pop();

UIkit.util.on('#nav-scroll', 'inview', function () {

  
	element.classList.remove("scroll");

    if(page != 'portfolio' || page != 'gallery'){
	document.documentElement.style.setProperty("--line", "#fff");

	   }
});


UIkit.util.on('#nav-scroll', 'outview', function () {

  
	element.classList.add("scroll");

	document.documentElement.style.setProperty("--line", "#990033");
	    
});



/*scroll*/

UIkit.util.on('#lightbox', 'show' , function () {

 console.log('hello');
      
});



/*filter*/

(function($){
   $('#galleryFilter').on('change','input,select', function(){
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
  } else if (elem.webkitRequestFullscreen) { /* Safari */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE11 */
    elem.msRequestFullscreen();
  }
}

function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) { /* Safari */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE11 */
    document.msExitFullscreen();
  }
}

