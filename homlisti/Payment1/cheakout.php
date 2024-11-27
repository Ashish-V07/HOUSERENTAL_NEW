<?php
session_start();
require 'config.php';  // Ensure this is the correct path to your config file
require 'vendor/autoload.php';

use Razorpay\Api\Api;

if (isset($_POST['num'])) {
    $amount = $_POST['num'] * 100; // Convert to paise

    $api = new Api(API_KEY, API_SECRET);
    $orderData = [
        'receipt'         => '123',
        'amount'          => $amount,
        'currency'        => 'INR',
        'payment_capture' => 1, // Auto capture
        'notes'           => [
            'key1' => 'val3',
            'key2' => 'val4'
        ]
    ];

    try {
        $order = $api->order->create($orderData);
        $orderId = $order['id'];

        $response = [
            'key' => API_KEY,
            'amount' => $amount,
            'order_id' => $orderId,
            'name' => COMPANY_NAME
        ];

        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Something went wrong: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>
