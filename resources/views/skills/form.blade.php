
@extends('layouts.app')

@section('title', $skill->exists ? 'Edit Skill' : 'Tambah Skill')

@section('content')

<div class="page-head">
    <div>
        <div class="eyebrow">Master Data / Skill</div>
        <h1>{{ $skill->exists ? 'Edit Skill' : 'Tambah Skill' }}</h1>
    </div>

    <a class="btn light" href="{{ route('skills.index') }}">
        ← Kembali
    </a>
</div>

<div class="card">
    <form method="POST"
        action="{{ $skill->exists ? route('skills.update', $skill) : route('skills.store') }}">

        @csrf

        @if($skill->exists)
            @method('PUT')
        @endif

        <div class="form-grid">

            {{-- Nama Skill --}}
            <div class="form-group">
                <label>Nama Skill *</label>
                <input
                    type="text"
                    class="field"
                    name="name"
                    value="{{ old('name', $skill->name) }}"
                    placeholder="Contoh: Sewing Operation"
                    required
                >
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Jenis Skill --}}
            <div class="form-group">
                <label>Jenis Skill *</label>
                <select name="skill_type" id="skill_type" class="field" required>
                    <option value="">-- Pilih Jenis Skill --</option>

                    @foreach([
                        'Sewing',
                        'Assembling',
                        'Stockfit',
                        'Hotpress',
                        'Cutting',
                        'Painting',
                        'Injection Phylon'
                    ] as $type)

                        <option value="{{ $type }}"
                            @selected(old('skill_type', $skill->skill_type ?? '') == $type)>
                            {{ $type }}
                        </option>

                    @endforeach
                </select>
                @error('skill_type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Kategori Otomatis --}}
            <div class="form-group">
                <label>Kategori *</label>
                <select name="category" id="category" class="field" required>
                    <option value="">-- Kategori Otomatis --</option>
                    <option value="Production"
                        @selected(old('category', $skill->category ?? '') == 'Production')>
                        Production
                    </option>
                    <option value="Technical"
                        @selected(old('category', $skill->category ?? '') == 'Technical')>
                        Technical
                    </option>
                    <option value="Quality"
                        @selected(old('category', $skill->category ?? '') == 'Quality')>
                        Quality
                    </option>
                    <option value="Safety"
                        @selected(old('category', $skill->category ?? '') == 'Safety')>
                        Safety
                    </option>
                    <option value="Soft Skill"
                        @selected(old('category', $skill->category ?? '') == 'Soft Skill')>
                        Soft Skill
                    </option>
                    <option value="Leadership"
                        @selected(old('category', $skill->category ?? '') == 'Leadership')>
                        Leadership
                    </option>
                </select>
                @error('category')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Target Level --}}
            <div class="form-group">
                <label>Target Level *</label>
                <select name="target_level" class="field" required>
                    @php
                        $levels = [
                            0 => 'Pemula',
                            25 => 'Dasar',
                            50 => 'Menengah',
                            75 => 'Mahir',
                            100 => 'Ahli'
                        ];
                    @endphp

                    @foreach($levels as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('target_level', $skill->target_level ?? 3) == $value)>
                            {{ $value }} — {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('target_level')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

           

            {{-- Deskripsi --}}
            <div class="form-group full">
                <label>Deskripsi</label>
                <textarea
                    name="description"
                    class="field"
                    rows="4"
                    placeholder="Masukkan deskripsi skill..."
                >{{ old('description', $skill->description) }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                Simpan Skill
            </button>

            <a class="btn light" href="{{ route('skills.index') }}">
                Batal
            </a>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const skillType = document.getElementById('skill_type');
    const category = document.getElementById('category');

    const categoryMapping = {
        'Sewing': 'Production',
        'Assembling': 'Production',
        'Stockfit': 'Production',
        'Hotpress': 'Production',
        'Cutting': 'Production',
        'Painting': 'Production',
        'Injection Phylon': 'Production'
    };

    skillType.addEventListener('change', function () {
        const selectedType = this.value;

        if (categoryMapping[selectedType]) {
            category.value = categoryMapping[selectedType];
        }
    });

    // Isi kategori otomatis saat halaman edit dibuka
    if (skillType.value && categoryMapping[skillType.value]) {
        category.value = categoryMapping[skillType.value];
    }
});
</script>

@endsection
