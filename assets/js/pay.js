// $(document).ready(() => {

$('#pay').on('click', () => {
    validateInput('p2w');
    if (validateInput) {

        var Subscriber = {
            firstName: $('#firstname').val(),
            lastName: $('#lastname').val(),
            email: $('#email').val(),
            token: $('#token').val(),
            phone: $('#phone').val(),
            date: new Date(),
            price: parseInt($('#price').html()) * 100,
            valid: false,
            pay: () => {
                const paystack = new PaystackPop();
                paystack.newTransaction({
                    key: 'pk_test_a78dba4dcc45f5f94f55f86170449cece2bc0bd8',
                    email: Subscriber.email,
                    amount: Subscriber.price,
                    ref: 'BIVR' + Math.floor((Math.random() * 1000000000) + 1),
                    metadata: {
                        "custom_fields": [
                            {
                                "display_name": 'First Name',
                                "variable_name": "First Name",
                                "value": Subscriber.firstName
                            },
                            {
                                "display_name": 'Last Name',
                                "variable_name": "Last Name",
                                "value": Subscriber.lastName
                            },
                            {
                                "display_name": 'Phone Number',
                                "variable_name": "Phone Number",
                                "value": Subscriber.phone
                            },
                            {
                                "display_name": 'No. of Shells:',
                                "variable_name": "shells",
                                "value": Subscriber.token
                            }
                        ]
                    },

                    onSuccess: (tx) => {
                        $.ajax({
                            url: 'server/subscriber.php',
                            dataType: 'JSON',
                            type: 'POST',
                            data: {
                                // User Data
                                ref: tx.reference,
                                txStatus: tx.status,
                                txID: tx.transaction,
                                firstname: Subscriber.firstName,
                                lastname: Subscriber.lastName,
                                phone: Subscriber.phone,
                                shells: Subscriber.token,
                                email: Subscriber.email,
                                amount: Subscriber.price,
                                date: Subscriber.date.toString()
                            },
                            success: (res) => {
                                location.href = 'success.html'
                            }
                        })
                    },
                    onCancel: () => {
                        // user closed popup
                        location.href = 'failed.html'
                    }
                });
            }
        }
        Subscriber.pay()
    }
})

// Form Validator
validateInput = (inputArgs) => {
    let validInput = $('[' + inputArgs + ']');
    for (let formInput = 0; formInput < validInput.length; formInput++) {
        if (validInput.get(formInput).value == null || validInput.get(formInput).value == '') {
            validInput[formInput].placeholder = 'This field is required';
            return false;
        }
    }
    return true;
}