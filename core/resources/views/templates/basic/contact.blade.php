@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$infos = getContent('contact.element');
$contact = getContent('contact.content',true);
@endphp
<section class="pt-150 pb-150">
    <div class="container">
      <div class="row mb-none-40">
        @foreach($infos as $info)
        <div class="col-lg-4 col-md-6 mb-40">
          <div class="contact-item">
            <div class="icon">
              @php echo $info->data_values->icon @endphp
            </div>
            <div class="content">
              <h3 class="title">{{ __($info->data_values->title) }}</h3>
              <p>{{ __($info->data_values->content) }}</p>
            </div>
          </div><!-- contact-item end -->
        </div>
        @endforeach
      </div>
      <div class="row justify-content-center mt-100">
        <div class="col-lg-12">
          <div class="contact-form-wrapper pl-5">
            <h3 class="title">{{ __($contact->data_values->heading) }}</h3>
            <p>{{ __($contact->data_values->subheading) }}</p>
            
            <!-- Flash message for success -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Anchor for scroll position preservation -->
            <a id="contact-form"></a>
            
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <form action="{{ route('contact.submit') }}" class="contact-form verify-gcaptcha mt-50" id="contactForm" method="post">
              @csrf
              <div class="row">
                <div class="form-group col-lg-6">
                  <input type="text" name="first_name" class="form-control" id="contact-first-name" placeholder="@lang('First Name')">
                </div>
                <div class="form-group col-lg-6">
                  <input type="text" name="last_name" class="form-control" id="contact-last-name" placeholder="@lang('Last Name')">
                </div>
                <div class="form-group col-lg-12">
                  <input type="email" name="email" class="form-control" id="contact-email" placeholder="@lang('Email')">
                </div>
                <div class="form-group col-lg-12">
                  <input type="text" name="subject" class="form-control" id="contact-subject" placeholder="@lang('Subject')">
                </div>
                <div class="form-group col-lg-12">
                  <textarea name="message" id="contact-message" class="form-control" placeholder="@lang('Write message')"></textarea>
                </div>
                <x-captcha></x-captcha>
                <div class="col-lg-12">
                  <button type="submit" class="btn btn--base w-100" id="contact-submit-btn">@lang('send message')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('contact-submit-btn');
    
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
                    // Success - show success message and reset form
                    form.reset();
                    // Reset captcha
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.reset();
                    }
                    
                    // Show success message
                    const successMsg = document.createElement('div');
                    successMsg.className = 'alert alert-success mt-3';
                    successMsg.textContent = data.message;
                    form.parentNode.insertBefore(successMsg, form.nextSibling);
                    
                    // Scroll to top of form to show success message
                    form.scrollIntoView({ behavior: 'smooth' });
                    
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.textContent = '@lang("send message")';
                    
                    // Remove success message after 5 seconds
                    setTimeout(() => {
                        successMsg.remove();
                    }, 5000);
                    
                } else {
                    // Error - show error message
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'alert alert-danger mt-3';
                    errorMsg.textContent = data.message || 'Something went wrong. Please try again.';
                    form.parentNode.insertBefore(errorMsg, form.nextSibling);
                    
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.textContent = '@lang("send message")';
                    
                    // Remove error message after 5 seconds
                    setTimeout(() => {
                        errorMsg.remove();
                    }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Network error message
                const errorMsg = document.createElement('div');
                errorMsg.className = 'alert alert-danger mt-3';
                errorMsg.textContent = 'Network error. Please check your connection and try again.';
                form.parentNode.insertBefore(errorMsg, form.nextSibling);
                
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = '@lang("send message")';
                
                // Remove error message after 5 seconds
                setTimeout(() => {
                    errorMsg.remove();
                }, 5000);
            });
        });
    }
});
</script>
@endpush

@endsection
