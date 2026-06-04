<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::orderByDesc('issue_date')->paginate(15);
        return view('dashboard.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('dashboard.certificates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'issuer' => 'required|string|max:255',
            'issuer_ar' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'integer',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }
        Certificate::create($data);
        return redirect()->route('admin.certificates.index')->with('success', __('messages.created_success'));
    }

    public function edit(Certificate $certificate)
    {
        return view('dashboard.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'issuer' => 'required|string|max:255',
            'issuer_ar' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'integer',
        ]);
        if ($request->hasFile('image')) {
            if ($certificate->image) Storage::disk('public')->delete($certificate->image);
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }
        $certificate->update($data);
        return redirect()->route('admin.certificates.index')->with('success', __('messages.updated_success'));
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image) Storage::disk('public')->delete($certificate->image);
        $certificate->delete();
        return redirect()->route('admin.certificates.index')->with('success', __('messages.deleted_success'));
    }
}
