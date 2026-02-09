<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>MonieFlex Website - Contact</title>

        <!-- CSS FILES -->        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link href="css/templatemo-kind-heart-charity.css" rel="stylesheet">
    </head>
    
    <body id="section_5">
        <main>
            <section class="contact-section section-padding" id="section_5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-12 ms-auto mb-5 mb-lg-0">
                            <div class="contact-info-wrap">
                                <h2>Get in touch</h2>

                                <div class="contact-image-wrap d-flex flex-wrap">
                                    <img src="images/avatar/pretty-blonde-woman-wearing-white-t-shirt.jpg" class="img-fluid avatar-image" alt="">
                                    <div class="d-flex flex-column justify-content-center ms-3">
                                        <p class="mb-0">Clara Barton</p>
                                        <p class="mb-0"><strong>HR & Office Manager</strong></p>
                                    </div>
                                </div>

                                <div class="contact-info">
                                    <h5 class="mb-3">Contact Infomation</h5>
                                    <p class="d-flex mb-2">
                                        <i class="bi-geo-alt me-2"></i>
                                        Akershusstranda 20, 0150 Oslo, Norway
                                    </p>
                                    <p class="d-flex mb-2">
                                        <i class="bi-telephone me-2"></i>
                                        <a href="tel: 120-240-9600">120-240-9600</a>
                                    </p>
                                    <p class="d-flex">
                                        <i class="bi-envelope me-2"></i>
                                        <a href="mailto:info@yourgmail.com">donate@charity.org</a>
                                    </p>
                                    <a href="#" class="custom-btn btn mt-3">Get Direction</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12 mx-auto">
                            <form class="custom-form contact-form" id="contactForm" method="post" action="{{ route('contact.submit') }}">
                                @csrf
                                <h2>Contact form</h2>

                                <p class="mb-4">Or, you can just send an email:
                                    <a href="mailto:info@monieflex.site">info@monieflex.site</a>
                                </p>
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="first_name" id="first-name" class="form-control" placeholder="First Name" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="last_name" id="last-name" class="form-control" placeholder="Last Name" required>
                                    </div>
                                </div>

                                <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email Address" required>
                                <textarea name="message" rows="5" class="form-control" id="message" placeholder="Your message" required></textarea>

                                <button type="submit" class="form-control" id="submitBtn">Send Message</button>
                                
                                <!-- Success/Error Messages -->
                                <div id="formMessage" class="mt-3" style="display: none;"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/counter.js"></script>
        <script src="js/custom.js"></script>
        
        <!-- AJAX Contact Form Handler -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('formMessage');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form data
                    const formData = new FormData(form);
                    
                    // Get CSRF token from meta tag
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    // Disable submit button to prevent double submission
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Sending...';
                    
                    // Show loading message
                    formMessage.style.display = 'block';
                    formMessage.className = 'alert alert-info';
                    formMessage.textContent = 'Sending your message...';
                    
                    fetch(form.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Success message
                            formMessage.className = 'alert alert-success';
                            formMessage.textContent = data.message;
                            
                            // Reset form
                            form.reset();
                            
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Send Message';
                            
                            // Scroll to top of form to show success message
                            form.scrollIntoView({ behavior: 'smooth' });
                            
                        } else {
                            // Error message
                            formMessage.className = 'alert alert-danger';
                            formMessage.textContent = data.message || 'Something went wrong. Please try again.';
                            
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Send Message';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Network error message
                        formMessage.className = 'alert alert-danger';
                        formMessage.textContent = 'Network error. Please check your connection and try again.';
                        
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Send Message';
                    });
                });
            }
        });
        </script>
    </body>
</html>