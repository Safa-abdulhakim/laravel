<?php

namespace App\Http\Controllers;

use App\Models\CareerPath;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class CareerPathController extends Controller
{
    public function __construct(private ProgressService $progressService) {}

    public function index(Request $request)
    {
        $query = CareerPath::where('status', 'active')->withCount(['stages', 'skills']);

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($level = $request->get('level')) {
            $query->where('difficulty_level', $level);
        }

        $careerPaths = $query->orderByDesc('enrolled_count')->paginate(9)->withQueryString();

        return view('career-paths.index', compact('careerPaths'));
    }

    public function show(CareerPath $careerPath)
    {
        $careerPath->load(['stages.skills.learningResources']);

        $progress = null;
        $stagesProgress = [];
        $skillStatuses = [];

        if (auth()->check()) {
            $user = auth()->user();
            $progress = $this->progressService->getCareerPathProgress($user, $careerPath);

            foreach ($careerPath->stages as $stage) {
                $stagesProgress[$stage->id] = $this->progressService->getStageProgress($user, $stage, $careerPath);
                foreach ($stage->skills as $skill) {
                    $skillStatuses[$skill->id] = $this->progressService->getSkillStatus($user, $skill, $careerPath);
                }
            }
        }

        return view('career-paths.show', compact('careerPath', 'progress', 'stagesProgress', 'skillStatuses'));
    }
}
