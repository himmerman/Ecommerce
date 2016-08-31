<?php
require_once('lib/Stripe.php');

$stripe = array(
  "secret_key"      => "sk_live_xWXnKF20CO65PDXWf3QU3qnS",
  "publishable_key" => "pk_live_nFnXGK068qRRpxAnXCALoYOh"
);

Stripe::setApiKey($stripe['secret_key']);
?>