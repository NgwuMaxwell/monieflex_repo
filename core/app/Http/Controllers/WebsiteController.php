<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    /**
     * Display the main website page with blog posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get blog posts (using Frontend model for blog content)
        $posts = Frontend::where('data_keys', 'blog.element')
            ->latest()
            ->take(5)
            ->get();

        // Ensure $posts is always a collection, even if empty
        if (!$posts || !is_a($posts, 'Illuminate\Support\Collection')) {
            $posts = collect();
        }

        // Generate slugs for posts that don't have them
        foreach ($posts as $post) {
            if (empty($post->slug)) {
                $title = $post->data_values->title ?? 'blog-post-' . $post->id;
                $post->slug = $this->generateSlug($title);
                $post->save();
            }
        }

        // Get recent posts for sidebar (excluding current ones)
        $recentPosts = Frontend::where('data_keys', 'blog.element')
            ->whereNotNull('slug')
            ->latest()
            ->take(3)
            ->get();

        // Ensure $recentPosts is always a collection, even if empty
        if (!$recentPosts || !is_a($recentPosts, 'Illuminate\Support\Collection')) {
            $recentPosts = collect();
        }

        return view('website.index', compact('posts', 'recentPosts'));
    }

    /**
     * Display a single blog post.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function newsDetail($slug)
    {
        // Find the blog post by slug
        $post = Frontend::where('data_keys', 'blog.element')
            ->where('slug', $slug)
            ->first();

        if (!$post) {
            abort(404, 'Blog post not found');
        }

        // Get recent posts for sidebar
        $recentPosts = Frontend::where('data_keys', 'blog.element')
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        // Get related posts (same category or similar tags)
        $relatedPosts = Frontend::where('data_keys', 'blog.element')
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(2)
            ->get();

        return view('website.news-detail', compact('post', 'recentPosts', 'relatedPosts'));
    }

    /**
     * Generate a URL-friendly slug from a title.
     *
     * @param  string  $title
     * @return string
     */
    private function generateSlug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        // Check if slug already exists and make it unique
        $originalSlug = $slug;
        $counter = 1;
        
        while (Frontend::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Handle contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactSubmit(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please fill in all required fields correctly.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the contact message
            $contactMessage = new \App\Models\ContactMessage();
            $contactMessage->first_name = $request->input('first_name');
            $contactMessage->last_name = $request->input('last_name');
            $contactMessage->email = $request->input('email');
            $contactMessage->message = $request->input('message');
            $contactMessage->status = 'unread';
            $contactMessage->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for your message! We will get back to you soon.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while sending your message. Please try again.'
            ], 500);
        }
    }
}