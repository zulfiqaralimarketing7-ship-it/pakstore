<?php
session_start();
include "auth.php";
$grandTotal = $_SESSION['grand_total'] ?? 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Secure Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>

    <h2>Pay Securely</h2>

    <form id="payment-form">
        <div id="card-element"></div>
        <br>
        <button id="payBtn">Pay Rs <?= $grandTotal ?></button>
    </form>

    <script>
        var stripe = Stripe("YOUR_PUBLISHABLE_KEY");

        var elements = stripe.elements();
        var card = elements.create("card");
        card.mount("#card-element");

        document.getElementById("payment-form").addEventListener("submit", async function(e) {
            e.preventDefault();

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: card
            });

            if (error) {
                alert(error.message);
            } else {
                fetch("process_payment.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            id: paymentMethod.id
                        })
                    }).then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location = "order_success.php";
                        } else {
                            alert("Payment Failed");
                        }
                    });
            }
        });
    </script>

</body>

</html>