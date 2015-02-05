(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-59389995-1', 'auto');
ga('send', 'pageview');

var body = document.querySelector('body')
  , drop = document.querySelector('.drop');

body.onmousemove = function() {

	drop.style.left = (window.event.clientX - 43) + 'px';
};

var update_current_status = function() {

	var xhr = new XMLHttpRequest();
	xhr.open("GET", base_url + '/api/watershed');

	xhr.onload = function(e) {

		drop.innerHTML = JSON.parse(xhr.responseText).data.percentage + "%";
	};

	xhr.send();
};

update_current_status();
