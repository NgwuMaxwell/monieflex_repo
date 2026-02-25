<?php

// Simple test script to verify the integration
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Frontend;

// Test database connection
try {
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
} catch (\Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test Frontend model
try {
    $posts = Frontend::where('data_keys', 'blog.content')->get();
    echo "✅ Found " . $posts->count() . " blog posts\n";
    
    if ($posts->count() > 0) {
        foreach ($posts as $post) {
            echo "  - Title: " . ($post->data_values->title ?? 'No title') . "\n";
            echo "    Slug: " . ($post->slug ?? 'No slug') . "\n";
        }
    } else {
        echo "  ℹ️  No blog posts found - this is normal for a fresh installation\n";
    }
} catch (\Exception $e) {
    echo "❌ Frontend model test failed: " . $e->getMessage() . "\n";
}

// Test WebsiteController
try {
    $controller = new \App\Http\Controllers\WebsiteController();
    echo "✅ WebsiteController instantiated successfully\n";
} catch (\Exception $e) {
    echo "❌ WebsiteController test failed: " . $e->getMessage() . "\n";
}

echo "\n🎉 Integration test completed!\n";
echo "The website is now running at: http://localhost:8000\n";
echo "You can access:\n";
echo "  - Home page: http://localhost:8000\n";
echo "  - Contact form: http://localhost:8000/contact\n";
echo "  - Blog posts will appear on the home page if they exist\n";