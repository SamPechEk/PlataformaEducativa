// modo oscuro
const boton = document.querySelector('#interruptor')
boton.addEventListener('click',function(e){
	document.body.classList.toggle('dark');
	boton.classList.toggle('active')
	// particulas
	const da = document.getElementById('body')
	var bandera = 0;
	for (let i = 0; i <= da.classList.length; i++) {
		
		if (da.classList[i]=='dark'){
			// localStorage
			bandera =1;
			// localStorage
		}
	}
	if (bandera==1) {
		
		localStorage.setItem('modo','true');
	} else {
		
		localStorage.setItem('modo','false');
	}
	
	e.preventDefault();
})
// modo oscuro

// particulas
if (localStorage.getItem('modo')==='true') {
	document.body.classList.toggle('dark');
	boton.classList.toggle('active')
	
}
