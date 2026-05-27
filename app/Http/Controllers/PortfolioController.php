<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Certificate;
use App\Models\Cv;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::active()->orderBy('sort_order')->take(6)->get();
        $skills = Skill::orderBy('category')->orderBy('sort_order')->get();
        $experiences = Experience::orderBy('start_date', 'desc')->get();
        $certificates = Certificate::orderBy('issue_date', 'desc')->take(6)->get();
        $activeCv = Cv::where('is_active', true)->latest()->first();

        $skillsByCategory = $skills->groupBy('category');

        return view('portfolio.index', compact(
            'featuredProjects', 'skills', 'skillsByCategory',
            'experiences', 'certificates', 'activeCv'
        ));
    }

    public function projects()
    {
        $projects = Project::active()->orderBy('sort_order')->paginate(9);
        return view('portfolio.projects', compact('projects'));
    }

    public function project(Project $project)
    {
        return view('portfolio.project', compact('project'));
    }

    public function contact()
    {
        return view('portfolio.contact');
    }

    public function sendMessage(ContactRequest $request)
    {
        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Your message has been sent successfully! I will get back to you soon.');
    }

    public function downloadCv()
    {
        $cv = Cv::where('is_active', true)->latest()->first();

        if (!$cv || !Storage::disk('public')->exists($cv->file_path)) {
            return back()->with('error', 'CV is not available for download at the moment.');
        }

        $cv->incrementDownload();

        return Storage::disk('public')->download($cv->file_path, $cv->original_name);
    }
}
