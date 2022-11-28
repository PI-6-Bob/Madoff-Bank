let pos = { set: false, lat: 0, alt: 0};
// navigator.geolocation.getCurrentPosition(function (geo) { });
document.getElementById('transaction').addEventListener('submit', addgeo);

function addgeo(e) {
	const latitude = document.createElement('input');
	const altitude = document.createElement('input');
	altitude.type = 'hidden';
	latitude.type = 'hidden';
	altitude.name = '_altitude';
	latitude.name = '_latitude';
	altitude.value = pos.alt;
	latitude.value = pos.lat;
	e.target.appendChild(altitude);
	e.target.appendChild(latitude);
}
