<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
Stripe.setPublishableKey('pk_live_nFnXGK068qRRpxAnXCALoYOh');
function payAccount () {
	routing = document.getElementById('routing').value;

	validRouting = Stripe.bankAccount.validateRoutingNumber(routing, 'US');
	if (validRouting){
		name = document.getElementById('name').value;
		account = document.getElementById('account').value;
		
		token = Stripe.bankAccount.createToken({
			country: "US",
			routingNumber: routing,
			accountNumber: account
		}, stripeResponseHandler);
	}
}

function stripeResponseHandler(status, response) {
  
  if (response.error) {
    // Show the errors on the form
   	console.log(response.error.message);
    
  } else {
    // response contains id and card, which contains additional card details
    var token = response.id;
    var name = document.getElementById('name').value;
    var amount = document.getElementById('amount').value;
    // Insert the token into the form so it gets submitted to the server
    console.log({'token': token, 'name': name, 'amount': amount});
    $.ajax({
		url: 'http://localhost/awa/admin/makePayment/',
		type: "POST",
		data: {'token': token, 'name': name, 'amount': amount},
		success: function (data) {
			console.log(data);
		}
	});
    
  }
}

</script>

Amount: <input type="text" id="amount">
Name:<input type="text" id="name">
Account Number: <input type="text" id="account">
Routing Number: <input type="text" id="routing">

<button onclick="payAccount()">Pay</button>

