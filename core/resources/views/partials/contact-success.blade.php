<script>
    // Success message handling for iframe submission
    parent.document.getElementById('contactSuccess').style.display = 'block';
    parent.document.getElementById('contactSuccess').innerText = 'Thank you for your message! We will get back to you soon.';
    parent.document.getElementById('contactForm').reset();
    
    // Hide the success message after 5 seconds
    setTimeout(function() {
        parent.document.getElementById('contactSuccess').style.display = 'none';
    }, 5000);
</script>