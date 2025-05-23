<!DOCTYPE html>
<html lang="en">
<head>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <style>
        
        
        /* General Styles */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #F8F4E1;
        color: #4E1F00;
        margin: 0;
        padding: 0;
    }
    
    /* Star Rating Styles */
    #starRating .fa-star {
        color: #d1d5db; 
        transition: color 0.3s ease-in-out, transform 0.2s ease-in-out;
        cursor: pointer;
    }
    #starRating .fa-star:hover {
        transform: scale(1.2); 
    }
    
    #starRating .fa-star.selected {
        color: #fbbf24; 
    }
    
    /* Form Inputs */
    input, textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #f9fafb;
        color: #4E1F00;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    input:focus, textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
        outline: none;
    }
    
    /* Success Message */
    #successMessage {
        display: none;
        background-color: #d1fae5;
        color: #065f46;
        padding: 1rem;
        border-radius: 0.375rem;
        text-align: center;
        margin-top: 1rem;
    }
    .navbar {
        background-color: #FEBA17;
        padding: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        justify-content: space-between;
        
    }
    .btn-outline-success {
        background-color: #FEBA17;
        border-color: #4E1F00;
        color: #4E1F00;
        
    }
    .btn-outline-success:hover {
        background-color: #4E1F00;
        border-color: #4E1F00;
        color: #FEBA17;
    }
    
    .btn-primary{
        background-color: #4E1F00;
        border-color: #4E1F00;
        color: #FEBA17;
    }
    
    .btn-primary:hover {
        background-color: #FEBA17;
        border-color: #4E1F00;
        color: #4E1F00;
    }
    
    footer{
        background-color: #FEBA17;
        color: #4E1F00;
        padding: 1rem;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    .hidden {
        display: none !important;
    }

    </style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#starRating .fa-star');
    const ratingInput = document.getElementById('rating');
    
    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const value = this.getAttribute('data-value');
                highlightStars(value);
            });
            
            star.addEventListener('mouseout', function() {
                highlightStars(ratingInput.value); 
            });
            
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                highlightStars(value);
            });
        });

        function highlightStars(value) {
            stars.forEach(star => {
                if (star.getAttribute('data-value') <= value) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }
    });
    </script>


</head>
<body>

<nav class="navbar ">
    
    <div    >
        <h5>Feedback</h5>
        <i> provide us with your feedback</i>
        
    </div>
    <div>
        <h5>Response System</h5>
        
    </div>
    <div>
        <a href="{{ route('register') }}" class="btn btn-outline-success">Register</a>
        <a href="{{ route('login') }}" class="btn btn-outline-success">Log In</a>
    </div>
    
</nav>

<!-- Feedback Modal -->

<div class="mx-auto mt-2 p-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Give us your feedback</h3>
    <button id="feedbackButton" class="btn btn-primary" type="button">
        Feedback
    </button>
</div>

<div id="feedbackModal" class="container hidden">
    
    <form action="{{ route('feedback.submit') }}" method="POST" id="feedbackForm" >
        <div id="successMessage">
            Thank you for your feedback!
        </div>
        @csrf
        <div class="form-group">
            <label for="name" class="form-check-label">Name</label>
            <input type="text" id="name" name="name">
            
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
                </div>
             
                <div class="form-group">
                    <label class="form-check-label">Rating*</label>
                    <div id="starRating" class="flex items-center space-x-1 text-2xl text-gray-300">
                        <i class="fa fa-star cursor-pointer" data-value="1"></i>
                        <i class="fa fa-star cursor-pointer" data-value="2"></i>
                        <i class="fa fa-star cursor-pointer" data-value="3"></i>
                        <i class="fa fa-star cursor-pointer" data-value="4"></i>
                        <i class="fa fa-star cursor-pointer" data-value="5"></i>
                    </div>
                    
                    <input type="hidden" name="rating" id="rating" required>
                </div>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea id="comment" name="comment" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
             
            </form>
        </div>
    </div>
    <footer>
        <P>all rights recieved by @akashbhalnai21@gmail.com</P>
        </footer>

<script>
    
 
    document.addEventListener('DOMContentLoaded', function() {
        const feedbackButton = document.getElementById('feedbackButton');
        const feedbackModal = document.getElementById('feedbackModal');
        const cancelFeedback = document.getElementById('cancelFeedback');
        const feedbackForm = document.getElementById('feedbackForm');
        const successMessage = document.getElementById('successMessage');

        feedbackButton.addEventListener('click', function() {
            feedbackModal.classList.remove('hidden');
            feedbackModal.setAttribute('aria-hidden', 'false');
        });

        function closeFeedbackModal() {
            feedbackModal.classList.add('hidden');
            feedbackModal.setAttribute('aria-hidden', 'true');
        }

        cancelFeedback.addEventListener('click', closeFeedbackModal);

        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(feedbackForm);

            fetch('{{ route("feedback.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    feedbackForm.reset();
                    successMessage.classList.remove('hidden');
                    setTimeout(() => {
                        successMessage.classList.add('hidden');
                        closeFeedbackModal();
                    }, 3000);
                } else {
                    alert(data.message || 'Something went wrong. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });

</script>

</body>
</html>