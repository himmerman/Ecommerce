// change urls for production

function confirmDelete (action, id) {
	var response = confirm("Do you wish to delete this? This cannot be reversed.");
	if (response) {
		$.ajax({
			url: 'http://localhost/techpro/admin/delete' + action + '/' + id,
			success: function (data) {
				location.reload();
			},
			error: function(data) {
				console.log(data);
				alert('This cannot be deleted because it is in use.');
			}
		});
	}
}

function saveCategories (product_id) {
	var categories = document.getElementsByClassName('cat-check');
	var post = new Array();
	for (var i = 0; i < categories.length; i++) {
		post[i] = [categories[i].value, categories[i].checked];
	};
	var jsonPost = JSON.stringify(post);

	$.ajax({
		url: '/admin/saveProdCategories/' + product_id,
		type: "POST",
		data: {data: jsonPost},
		success: function (data) {
			location.reload();
		}
	});
	return false;	
}

function checkNewProductFields(){

	var reqFields = new Array(
			document.getElementById('photo').value,
			document.getElementById('pName').value,
			document.getElementById('pCode').value,
			document.getElementById('pPrice').value,
			document.getElementById('pQuantity').value,
			document.getElementById('pWood').value
		);


	var valid = true;

	for (var i = 0; i < reqFields.length; i++) {
		if(!reqFields[i])
			valid=false;

	};

	if (!valid) {
		alert('Please fill in the required fields that are marked by the red *. Thank you.');
	};

	if (valid) {

		$.ajax({
			url: '/admin/checkProductCode/' + reqFields[2],
			async: false,
			success: function (data) {
				if (data != 'true') {
					valid = false;
					alert(data);
				} else {
					valid = true;
				}
			}
		});

	}

	return valid;
}
