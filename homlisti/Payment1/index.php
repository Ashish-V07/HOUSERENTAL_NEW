<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Payment Integration</title>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    </head>
    <body>


        <input type="hidden" id="amount" name="num" value="<?php echo $_GET['sd']; ?>">
 <input type="hidden" id="pid" name="pid" value="<?php echo $_GET['pid']; ?>">
  <input type="hidden" id="uid" name="uid" value="<?php echo $_GET['uid']; ?>">



        <script>
            function payNow() {
                var amount = document.getElementById('amount').value;
                var uid=document.getElementById('uid').value;
                var pid=document.getElementById('pid').value;
                
                if (!amount || amount <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }

                console.log("Amount to be sent: " + amount); // Debugging log

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'cheakout.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            alert('Error: ' + response.error);
                            return;
                        }

                        var options = {
                            "key": response.key,
                            "amount": response.amount,
                            "currency": "INR",
                            "name": response.name,
                            "description": "Test Transaction",
                            "order_id": response.order_id,
                            "handler": function (response) {
                                console.log(response);
                              
                                var paymentId = response.razorpay_payment_id;

        // Redirect to insertdata.php with payment ID
         window.location.href = `insertdata.php?method=${encodeURIComponent(paymentId)}&uid=${encodeURIComponent(uid)}&pid=${encodeURIComponent(pid)}&amount=${encodeURIComponent(amount)}`;
                            
                            },
                            "theme": {
                                "color": "#F37254"
                            }
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    } else {
                        alert('Something went wrong. Please try again. Status: ' + xhr.status);
                    }
                };
                xhr.send('num=' + encodeURIComponent(amount));
            }
            window.onload = payNow;
        </script>
    </body>
</html>
