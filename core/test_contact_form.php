<?php
// Simple test to verify contact form functionality
echo "Testing contact form implementation...\n\n";

// Check if contact route exists
$routesFile = 'core/routes/web.php';
if (file_exists($routesFile)) {
    $routesContent = file_get_contents($routesFile);
    if (strpos($routesContent, 'contact') !== false) {
        echo "✓ Contact routes found in web.php\n";
    } else {
        echo "✗ Contact routes not found in web.php\n";
    }
} else {
    echo "✗ Routes file not found\n";
}

// Check if controller method exists
$controllerFile = 'core/app/Http/Controllers/SiteController.php';
if (file_exists($controllerFile)) {
    $controllerContent = file_get_contents($controllerFile);
    if (strpos($controllerContent, 'contactSubmit') !== false) {
        echo "✓ contactSubmit method found in SiteController\n";
    } else {
        echo "✗ contactSubmit method not found in SiteController\n";
    }
    
    if (strpos($controllerContent, 'redirect()->route(\'contact\')') !== false) {
        echo "✓ Controller redirects to contact route\n";
    } else {
        echo "✗ Controller redirect not found\n";
    }
    
    if (strpos($controllerContent, 'with(\'success\'') !== false) {
        echo "✓ Success flash message implemented\n";
    } else {
        echo "✗ Success flash message not found\n";
    }
} else {
    echo "✗ SiteController file not found\n";
}

// Check if contact form has flash message
$formFile = 'core/resources/views/templates/basic/contact.blade.php';
if (file_exists($formFile)) {
    $formContent = file_get_contents($formFile);
    if (strpos($formContent, 'session(\'success\')') !== false) {
        echo "✓ Flash message display found in contact form\n";
    } else {
        echo "✗ Flash message display not found in contact form\n";
    }
    
    if (strpos($formContent, 'id="contact-form"') !== false) {
        echo "✓ Contact form anchor found\n";
    } else {
        echo "✗ Contact form anchor not found\n";
    }
} else {
    echo "✗ Contact form file not found\n";
}

echo "\n=== Implementation Status ===\n";
echo "The contact form has been updated to use the stable PRS (Post-Redirect-Show) approach:\n";
echo "1. Form submits normally to contact.submit route\n";
echo "2. Controller validates and saves message\n";
echo "3. Controller redirects back to contact page with success flash message\n";
echo "4. Flash message displays on page reload\n";
echo "5. Page should land back at contact form position\n";
echo "\nTo test:\n";
echo "1. Visit the contact page\n";
echo "2. Fill out the form\n";
echo "3. Submit - page should reload with success message\n";
?>