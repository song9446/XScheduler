function animate(elem,style,unit,from,to,time) {
	if( !elem) return;
		var start = new Date().getTime(),
		timer = setInterval(function() {
		var step = Math.min(1,(new Date().getTime()-start)/time);
		elem.style[style] = (from+step*(to-from))+unit;
		if( step == 1) clearInterval(timer);
	},25);
	elem.style[style] = from+unit;
}

function sidebar_toggle(button) {
	if (document.getElementById(button).value=="0"){
		animate(document.getElementById('sidebar'),"width","px",0,250,300);
		animate(document.getElementById('content'),"left","px",0,250,300);
		document.getElementById(button).value = "1";
	}

	else{
		animate(document.getElementById('sidebar'),"width","px",250,0,300);
	    animate(document.getElementById('content'),"left","px",250,0,300);
		document.getElementById(button).value = "0";
	}
}

function login_toggle(button, toggle_window) {
	if (document.getElementById(button).value=="0"){
		var x = document.getElementById(toggle_window).style.display="inline-block";
		document.getElementById(button).value = "1";
	}

	else{
		document.getElementById(toggle_window).style.display="none";
		document.getElementById(button).value = "0";
	}
}

