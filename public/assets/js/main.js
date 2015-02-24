(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-59389995-1', 'auto');
ga('send', 'pageview');

var body 		= document.querySelector('html')
  , drop 		= document.querySelector('.drop')
  , water 		= document.querySelector('.water')
  , max_water	= parseInt(window.getComputedStyle(water).getPropertyValue('height'));

body.onmousemove = function(e) {

	var e = e || window.event;
	var o = e.srcElement || e.target;

	drop.style.left = (e.clientX - 43) + 'px';
};

var update_current_status = function() {

	var xhr = new XMLHttpRequest();
	xhr.open("GET", base_url + '/api/watershed');

	xhr.onload = function(e) {

		var data = JSON.parse(xhr.responseText).data;

		drop.innerHTML = parseFloat(Math.round(data.percentage * 100) / 100).toFixed(1) + "%";
		water.style.height = ((max_water * data.percentage) / 100) - 11 + "px";
	};

	xhr.send();
};

function drawChart() {

	var options = {
		  hartArea: { left: 0, top: 0, width: "100%", height: "100%" }
		, curveType: 'function'
		, legend: { position: 'bottom' }
		, pointSize: 5
		, vAxis: {
			  minValue: 0
			, maxValue: 100
		}
		, hAxis: {
			  format: "d/m"
			, showTextEvery: 4
		}
	};

	var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
	var xhr = new XMLHttpRequest();

	xhr.open("GET", base_url + '/api/reservoirs/google-chart');

	xhr.onload = function(e) {

		var data = JSON.parse(xhr.responseText);

		chart.draw(google.visualization.arrayToDataTable(data), options);
	};

	xhr.send();
}

update_current_status();
google.setOnLoadCallback(drawChart);


$(document).ready(function() {

	$(".input-form").intlTelInput({
		defaultCountry: "auto",
		utilsScript: "assets/js/utils.js"
	});
});


var singup = function(number) {

	var xhr = new XMLHttpRequest();
	xhr.open("POST", base_url + '/reports/signup');
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send('number=' + number);
};

var btSingup = document.getElementById('btSingup');

btSingup.onclick = function() {

	var inputNumber = $(".input-form").intlTelInput("getNumber");
	
	inputNumber = inputNumber.slice(3, inputNumber.length);
	singup(inputNumber);
};
