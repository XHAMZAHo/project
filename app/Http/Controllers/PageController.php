<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\BlogPost;
use App\Models\Service;

class PageController extends Controller
{
    public function home()
    {
        $featuredProjects = Project::with('technologies')
            ->featured()
            ->latest()
            ->take(6)
            ->get();

        $testimonials = Testimonial::active()
            ->latest()
            ->take(4)
            ->get();

        $featuredServices = Service::active()->featured()->ordered()->take(6)->get();

        return view('pages.home', compact('featuredProjects', 'testimonials', 'featuredServices'));
    }

    public function services()
    {
        $services = Service::active()->ordered()->get();
        return view('pages.services', compact('services'));
    }

    public function portfolio()
    {
        $projects = Project::with('technologies')
            ->where('status', '!=', 'archived')
            ->latest()
            ->paginate(9);

        return view('pages.portfolio', compact('projects'));
    }

    public function about()
    {
        $completedProjects = Project::completed()->count();
        $testimonials = Testimonial::active()->count();

        return view('pages.about', compact('completedProjects', 'testimonials'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function faq()
    {
        $faqs = Faq::active()->ordered()->get()->groupBy('category');
        return view('pages.faq', compact('faqs'));
    }

    public function blog()
    {
        $posts = BlogPost::where('status', 'published')
            ->latest('published_at')
            ->paginate(9);
        return view('pages.blog', compact('posts'));
    }

    public function blogPost(BlogPost $post)
    {
        abort_if($post->status !== 'published', 404);
        $related = BlogPost::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();
        return view('pages.blog-post', compact('post', 'related'));
    }

    public function serviceDetail(string $service)
    {
        // Try DB first
        $svc = Service::where('slug', $service)->active()->first();
        if ($svc) {
            return view('pages.service-detail', ['service' => $service, 'serviceModel' => $svc]);
        }
        $allowed = ['web-development', 'ui-ux-design', 'system-development'];
        if (!in_array($service, $allowed)) {
            abort(404);
        }
        return view('pages.service-detail', compact('service'));
    }
}
