// print page
function tisk () {
  window.print();
} 

// stripe tables
window.onload = init;

function init() {
	stripeTableById('list');
}

function stripeTable(t) {
	var i, odd = true;
	for (i=0; i<t.rows.length; i++) {
		t.rows[i].className += odd ? ' odd' : ' even';
	 odd = !odd;
  }
}
	
function stripeTableById(id) {
	var t = document.getElementById(id);
	if (t) stripeTable(t);
}
