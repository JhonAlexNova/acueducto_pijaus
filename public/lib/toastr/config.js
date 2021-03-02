function toastr_success(mensaje){
	//alert('akjsdhk');
	toastr.success(mensaje,'Mensaje!!!',{
		"progressBar": true,
		  "positionClass": "toast-bottom-right",
		  "preventDuplicates": false,
		  "timeOut": "6000"
	});
}