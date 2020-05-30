<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
    <title>Calculator</title>
</head>

<body>

    <div class="card">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="col col-sm-10 col-md-8 col-lg-6">
                        <h2>Calculator</h2>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-sm-center">
                    <div class="col col-sm-10 col-md-8 col-lg-6">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <input type="number" name="firstOperand" class="form-control" id="firstOperand" placeholder="1" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="operator" name="operator" required>
                                        <option value="+">+</option>
                                        <option value="-">-</option>
                                        <option value="*">*</option>
                                        <option value="/">/</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="number" name="secondOperand" class="form-control" id="secondOperand" placeholder="2" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="button" class="btn btn-primary btn-sm form-control" id="equals">=</button>
                                </div>
                                <div class="form-group col-md-2" id="result">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>
                <div class="row justify-content-sm-center">
                    <div class="col-md-6">
                        <div class="card border-dark mb-3">
                            <div class="card-header"><strong>Recent Calculations From Users</strong></div>
                            <div class="card-body" align="center" id="recent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery CDN links for Bootstrap -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

    <script>
        $(document).ready(function() {

            // Retreive recent calculations upon page loading
            getCalculations();

            // Update the screen with recent calculations
            setInterval(function() {
                getCalculations()
            }, 2000);


            $(document).on('click', '#equals', function() {
                var firstOperand = Number($('#firstOperand').val());
                var secondOperand = Number($('#secondOperand').val());
                var operator = $('#operator').val();
                var result = 0;

                // Check for which operation to perform
                switch (operator) {
                    case '+':
                        result = firstOperand + secondOperand;
                        break;

                    case '-':
                        result = firstOperand - secondOperand;
                        break;

                    case '*':
                        result = firstOperand * secondOperand;
                        break;

                    case '/':
                        // Check for second number to be 0, if so, exit
                        if (secondOperand === 0) {
                            alert("You can't divide by zero");
                            return;
                        }
                        result = firstOperand / secondOperand;
                        break;

                    default:
                        break;
                }


                var expression = `${firstOperand} ${operator} ${secondOperand} = ${result}`;
                $.ajax({
                    url: "calculator.php",
                    method: "POST",
                    data: {
                        createCalculation: 'createCalculation',
                        expression: expression
                    },
                    success: function(data) {
                        getCalculations();
                        $('#result').html(`<p>${result}</p>`);

                    }

                });
            })

            // Gets calculation from the backend
            function getCalculations() {
                $.ajax({
                    url: "calculator.php",
                    method: "POST",
                    data: {
                        getCalculations: 'getCalculations'
                    },
                    success: function(data) {
                        $('#recent').html(data);
                    }
                });
            }
        })
    </script>
</body>

</html>