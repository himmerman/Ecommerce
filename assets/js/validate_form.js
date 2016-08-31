function validateCheckOutForm () {
	var input_fields = document.getElementsByClassName('required');
	var messages = document.getElementsByClassName('message');
	if (messages.length > 0) {
		for (var i = messages.length - 1; i >= 0; i--) {
			messages[i].parentElement.removeChild(messages[i]);
		};
	};
	// alert('here');
	var form_is_valid = true;
	for (var i = input_fields.length - 1; i >= 0; i--) {
		if(input_fields[i].value == "" || input_fields[i].value == null) {
			var span = document.createElement('span');
			span.className = "red message";
			span.appendChild(document.createTextNode('This Field is required'));
			input_fields[i].parentElement.appendChild(span);
			form_is_valid = false;
		}
	};
	var button = document.getElementById('customButton');

	return form_is_valid;
}