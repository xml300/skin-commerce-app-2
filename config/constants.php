<?php

return [
  'pay_secret_key' => env("PAYSTACK_SECRET_KEY", ""),
  'pay_callback_url' => env("PAYSTACK_CALLBACK_URL", "http://localhost:8080/callback"),
  'pay_init_url' => env("PAYSTACK_INIT_URL", "http://localhost:8080/"),
  'pay_verify_url' => env("PAYSTACK_VERIFY_URL", "http://localhost:8080/") 
];