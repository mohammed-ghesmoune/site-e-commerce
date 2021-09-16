(function ($) {
    $(document).ready(function () {

        var stripe = Stripe('pk_test_51HNwwMGJkqQ9hcwDPzZRWBNSwR45Wz6XIBsJc595hqYuTr45SyagFws92HYUnXs2g0ohyeedXtjJtFM5zMnyYT9G00HFta10qO');
        // collect card details 
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            },
        };

        var cardElement = elements.create("card", { style: style });
        cardElement.mount("#card-element");

        cardElement.on('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
                submitPayment();
            }
        });
        function submitPayment() {
            // submit payment to stripe 
            var cardholderName = document.getElementById('cardholder-name');
            var cardButton = document.getElementById('card-button');
            var clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', function (ev) {
                ev.preventDefault();
                this.textContent = 'paiement en cour ...';
                this.setAttribute("disabled", true);
                stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: cardElement,
                    },

                }).then(function (result) {
                    if (result.error) {
                        $("#setup-form").prepend($('<div id="payment-errors" class="alert alert-danger"></div>'));
                        var displayPaymentError = document.getElementById('payment-errors')
                        displayPaymentError.textContent = result.error.message;
                        cardButton.textContent = 'Payer';
                        $('#card-button').removeAttr("disabled");

                    } else {
                        if (result.paymentIntent.status === 'succeeded') {
                            $("#setup-form").prepend($('<div id="payment-success" class="alert alert-success"></div>'));
                            var displayPaymentError = document.getElementById('payment-success')
                            displayPaymentError.textContent = 'votre paiement a bien été effectué';
                            cardButton.textContent = 'Payer';
                            $('#card-button').removeAttr("disabled");
                        }
                    }
                });
            });
        }
    });
})(jQuery);