// ---
require('./bootstrap');

/* YOUR CODE HERE */

/*scroll*/

var element = document.getElementById("navbar");

var path = window. location. pathname;
var page = path. split("/"). pop();

UIkit.util.on('#nav-scroll', 'inview', function () {

  
	element.classList.remove("scroll");

    if(page != 'portfolio'){
	document.documentElement.style.setProperty("--line", "#fff");

	   }
});


UIkit.util.on('#nav-scroll', 'outview', function () {

  
	element.classList.add("scroll");

	document.documentElement.style.setProperty("--line", "#990033");
	    
});
