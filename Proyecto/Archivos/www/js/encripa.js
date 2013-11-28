function encripta() {
	var ps = document.getElementById('contrasena');
	doc = sha1(ps.value);
}