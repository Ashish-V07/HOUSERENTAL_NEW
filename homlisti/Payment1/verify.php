<?php
session_start();
require 'config.php';
require 'vendor/autoload.php';

use Razorpay\Api\Api;

// Initialize the Razorpay API with your API keys
$api = new Api(API_KEY, API_SECRET);

// Capture the response from Razorpay after payment
if (isset($_POST['razorpay_payment_id']) && isset($_POST['razorpay_order_id'])) {
    
    // Store the payment details
    $razorpay_payment_id = $_POST['razorpay_payment_id'];
    $razorpay_order_id = $_POST['razorpay_order_id'];
    $razorpay_signature = $_POST['razorpay_signature'];
    
    // Verify payment signature to ensure it's genuine
    try {
        $attributes = [
            'razorpay_order_id' => $razorpay_order_id,
            'razorpay_payment_id' => $razorpay_payment_id,
            'razorpay_signature' => $razorpay_signature
        ];
        
        $api->utility->verifyPaymentSignature($attributes);

        // Payment was successful
        echo "<h3>Payment Successful!</h3>";
        echo "<p>Payment ID: " . $razorpay_payment_id . "</p>";
        echo "<p>Order ID: " . $razorpay_order_id . "</p>";

        // Get more details about the transaction (optional)
        $payment = $api->payment->fetch($razorpay_payment_id);
        echo "<p>Amount: " . ($payment->amount / 100) . " INR</p>"; // Amount is in paise
        echo "<p>Status: " . $payment->status . "</p>";

        // You can also save these details to your database if needed

    } catch (\Exception $e) {
        // Payment failed verification
        echo "<h3>Payment Verification Failed</h3>";
        echo "Error: " . $e->getMessage();
    }
}
?>
