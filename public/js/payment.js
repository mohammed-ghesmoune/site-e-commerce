/**
*Order forms
*/
const loader = document.querySelector('.loader')

function paymentStep() {
    $("#form_choose_address, #form_new_address").submit(function (event) {

        event.preventDefault();
        const url = this.getAttribute('action')
        const formData = new FormData(this)
        loader.classList.remove('d-none')

        fetch(url,{
            method:'post',
            body: formData,
             headers:{
                "X-Requested-With": "XMLHttpRequest"

             }
        }).then(response => response.json())
        .then(data=>{
            $('#paymentStep').html(data.content);
           paymentStep();
            checkout();
            loader.classList.add('d-none')

        })
    
     });
}
paymentStep();

/**
* checkout
*/
function checkout() {
    //stripe public key
    var stripe = Stripe('pk_test_51JaKWTAux3gYDg7UUzfTDtJYWkuwgbaWvtOoy88ghPt3z37v8cv4juhFS0rTDNTRevJtRVFaDnHwa6l0MQB6XOBT00bhBQYrQr');
    
    // create card elements 
    var elements = stripe.elements();    
    var cardElement = elements.create("card");
    cardElement.mount("#card-element");

    cardElement.on('change', function (event) {
        var displayError = $('#card-errors');
        if (event.error) {
            displayError.html(event.error.message);
        } else {
            displayError.html('');
        }
    });
    // submit payment to stripe

        $('#card-button').click(function (event) {
            event.preventDefault();
            $(this).html('paiement en cour ...');
            $(this).attr("disabled", true);
            loader.classList.remove('d-none')

            stripe.confirmCardPayment(
                $('#card-button').data('secret'), 
                {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: $('#cardholder-name').val(),
                      },
                },
                setup_future_usage : 'off_session',

            }).then(function (result) {
                if (result.error) {
                    var message ="";
                    if(result.error.code == "parameter_invalid_empty"){
                        message = "Veuillez saisir le nom du titulaire de la carte"
                    }else{
                    message = result.error.message;
                    }
                    $("#payment-errors").removeClass('d-none').html(message);
                    $('#card-button').html('Payer');
                    $('#card-button').removeAttr("disabled");
                    loader.classList.add('d-none')


                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        document.location.href =  $('#card-button').data('redirect');
                    }
                }
            });
        });
    
}
checkout();