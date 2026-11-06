<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::withCount('assessments')->orderBy('category')->orderBy('name')->paginate(12);
        return view('skills.index', compact('skills'));
    }

    public function create() { return view('skills.form', ['skill' => new Skill]); }

    public function store(Request $request)
    {
        Skill::create($this->validated($request));
        return redirect()->route('skills.index')->with('success', 'Skill berhasil ditambahkan.');
    }

    public function edit(Skill $skill) { return view('skills.form', compact('skill')); }

    public function update(Request $request, Skill $skill)
    {
        $skill->update($this->validated($request));
        return redirect()->route('skills.index')->with('success', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'target_level' => ['required', 'integer', 'between:1,5'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
