<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-step Form with Blade</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<style>
    .step {
        display: none
    }
    .step.active {
        display: block
    }
    hr {
        color: red;
    }
    .rv-dish {
        display: inline;
    }
</style>

<div class="container">
    <form method="POST" action="/form-submit">
        @csrf
        <div step="1" id="step1" class="step active">
            <h1>Step1</h1>
            <div class="form-group">
                <h2 for="step1_select">Please select a meal</h2>
                <select id="meal" name="meal" class="form-control" required>
                    <option value="breakfast">breakfast </option>
                    <option value="lunch">lunch </option>
                    <option value="dinner">dinner </option>
                </select>
            </div>
            <div class="form-group">
                <h2 for="step1_input">Please enter number of people:</h2>
                <input type="number" id="number_people" name="number_people" min="1" max="10" class="form-control" placeholder="Enter a number" required>
            </div>
        </div>
       
        <div class="step" id="step2" step="2">
        
            <h1>Step2</h1>
            <div class="form-group">
                <h2 for="step2_select">Please select a Restaurant</h2>
                <select id="restaurant" name="restaurant" class="form-control" required>
                    <option value="">Please select a Restaurant </option>
                </select>
            </div>
        </div>

        <div class="step" id="step3" step="3">
            <h1>Step3</h1>
            <div class="form-group">
                <h2 for="step3_select">Please select a dish</h2>
                <select id="dish" name="dish" class="form-control" required>
                    <option value="">Please select a Dish </option>
                </select>
            </div>
            <div class="form-group">
                <h2 for="step3_input">Please enter number of serving</h2>
                <input type="number" id="number_dish" name="number_dish" min="1" max="10" class="form-control" placeholder="Enter a number" required>
            </div>
            <hr>
           <div>
            <button type="button" id="plus" class="btn btn-secondary" >plus</button> 
           </div>
        </div>

        <div class="step" id="step4" step="4">
            <h1>Step4</h1>
            <div class="form-group">
                <h2 for="step4">Review</h2>
               <h3 id="rv-Meal">Meal:</h3>
               <h3 id="rv-People">People:</h3>
               <h3 id="rv-Restaurant">Restaurant:</h3>
               <div class="rv-dish"><h3 >Dishes: <h3 id="rv-Dishes"></h3> - <h3 id="rv-Dishes-number"></h3></h3>
                </div>
            </div>
        </div>

        <button type="button" id="prev" class="btn btn-secondary" style="display: none;">Previous</button>
        <button type="button" id="next" class="btn btn-primary">Next</button>
        <button type="submit" id="submit" class="btn btn-success" style="display: none;">Submit</button>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
{{-- <script>
    // JavaScript để điều khiển hiển thị các bước của form
    document.addEventListener('DOMContentLoaded', function () {
        var currentStep = 1;
        var steps = document.querySelectorAll('form > div');
        var prevButton = document.getElementById('prev');
        var nextButton = document.getElementById('next');
        var submitButton = document.getElementById('submit');

        function updateButtonStatus() {
            if (currentStep === 1) {
                prevButton.disabled = true;
            } else {
                prevButton.disabled = false;
            }

            if (currentStep === steps.length) {
                nextButton.style.display = 'none';
                submitButton.style.display = 'inline-block';
            } else {
                nextButton.style.display = 'inline-block';
                submitButton.style.display = 'none';
            }
        }

        updateButtonStatus();

        document.getElementById('next').addEventListener('click', function () {
            if (currentStep < steps.length) {
                steps[currentStep - 1].style.display = 'none';
                currentStep++;
                steps[currentStep - 1].style.display = 'block';
                updateButtonStatus();
            }
        });

        document.getElementById('prev').addEventListener('click', function () {
            if (currentStep > 1) {
                steps[currentStep - 1].style.display = 'none';
                currentStep--;
                steps[currentStep - 1].style.display = 'block';
                updateButtonStatus();
            }
        });
    });
</script> --}}
<script>
       $(document).ready(function() {
        $('#next').click(function(){
            var step = 1;
            $( ".step" ).each(function( index ) {
                if($(this).hasClass('active')) {
                    step = $(this).attr('step')
                    return;
                }
            });
            switch(parseInt(step)) {
                case 1:
                    getMeal();
                    break;
                case 2:
                    // code block
                    getDish();
                    break;
                case 3:
                   review()
                    $('#submit').show();
                    break;
                default:
                    // code block
            }
            $("#step"+(parseInt(step))).removeClass('active')
            $("#step"+(parseInt(step)+1)).addClass('active')
            if(parseInt(step) == 3) {
                $(this).hide();
            }
            $('#prev').show();
        });
        $('#prev').click(function(){
            var step = 1;
            $( ".step" ).each(function( index ) {
                if($(this).hasClass('active')) {
                    step = $(this).attr('step')
                    return;
                }
            });
            switch(parseInt(step)) {
                case 1:
                    
                    break;
                case 2:
                    break;
                case 3:
                    break;
                default:
                    // code block
            }
            $("#step"+(parseInt(step))).removeClass('active')
            $("#step"+(parseInt(step)-1)).addClass('active')
            if(parseInt(step) <= 2) {
                $(this).hide();
            }
            $('#next').show();
            $('#submit').hide();
        });
        $('#plus').click(function(){
            var selectHtml = $('#dish').prop('outerHTML');
            var inputHtml = $('#number_dish').prop('outerHTML');
            var newRowHtml = '<div class="form-group">' +
                                '<h2 for="step3_select">Please select a dish</h2>' +
                                selectHtml +
                            '</div>' +
                            '<div class="form-group">' +
                                '<h2 for="step3_input">Please enter number of serving</h2>' +
                                inputHtml +
                                '</div>' +
                            '<hr>';
             $('#step3').append(newRowHtml);
             $('#step3').append($('#plus'));
        }
        )
            
        });
        function getMeal() {
          
            var mealData = $('#meal').val();
            // if(mealData != '') {
            //     alert('You need choose Meal');
            // }
            // if(parseInt($('#number_people').val()) < 0 && parseInt($('#number_people').val()) > 10) {
            //     alert('Number of people must be between 10 and 1');
            // }
            $.ajax({
                url: "http://127.0.0.1:8000/api/get/data",
                type: "get", //send it through get method
                data: { 
                    meal: mealData, 
                },
                success: function(response) {
                    console.log('response',response);
                    $('#restaurant').empty().append('<option selected="selected" value="">Please select a Restaurant</option>')
                    $.each( response, function( key, value ) {
                        $('#restaurant').append('<option value="'+value+'">'+value+'</option>');
                    });
                },
                error: function(xhr) {
                    console.log('Error');
                }
            });
        }
        function getDish() {
            var restaurantData = $('#restaurant').val();
            $.ajax({
                url: "http://127.0.0.1:8000/api/get/data/dish",
                type: "get", 
                data: { 
                    restaurant: restaurantData, 
                },
                success: function(response) {
                    console.log('response',response);
                    $('#dish').empty().append('<option selected="selected" value="">Please select a Dish</option>')
                    $.each( response, function( key, value ) {
                        $('#dish').append('<option value="'+value+'">'+value+'</option>');
                    });
                },
                error: function(xhr) {
                    console.log('Error');
                }
            })
        }
        function review() {
            var restaurantData = $('#restaurant').val();
            var mealData = $('#meal').val();
            var dishData = $('#dish').val();
            var numberPeopleData = $('#number_people').val();
            var numberDishData = $('#number_dish').val();
            $('#rv-Meal').append(mealData);
            $('#rv-People').append(numberPeopleData);
            $('#rv-Restaurant').append(restaurantData);
            $('#rv-Dishes').append(dishData);
            $('#rv-Dishes-number').append(numberDishData);
        }
        
</script>
</body>
</html>
