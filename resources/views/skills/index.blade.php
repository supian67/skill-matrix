@extends('layouts.app')

@section('title', 'Master Skill')

@section('content')

<div class="page-head">
    <div>
        <div class="eyebrow">Master Data / Kompetensi</div>
        <h1>Master Skill</h1>
        <div class="muted">
            Daftar kompetensi, jenis skill, kategori, dan target level.
        </div>
    </div>

    <a class="btn" href="{{ route('skills.create') }}">
        ＋ Tambah Skill
    </a>
</div>


{{-- Tabel Master Skill --}}
<div class="card">

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Skill</th>
                    <th>Jenis Skill</th>
                    <th>Kategori</th>
                    <th>Target Level</th>
                    <th>Jumlah Assessment</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($skills as $skill)
                    <tr>
                        <td>
                            {{ $skills->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <b>{{ $skill->name }}</b>
                            @if($skill->description)
                                <div class="muted">
                                    {{ $skill->description }}
                                </div>
                            @endif
                        </td>

                        <td>
                            <span class="badge neutral">
                                {{ $skill->skill_type ?? '-' }}
                            </span>
                        </td>

                        <td>
                            {{ $skill->category }}
                        </td>

                        <td>
                            <b>{{ $skill->target_level }}/5</b>
                        </td>

                        <td>
                            {{ $skill->assessments_count }}
                        </td>

                        <td>
                            @if($skill->is_active)
                                <span class="badge">Aktif</span>
                            @else
                                <span class="badge neutral">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a class="btn light"
                                   href="{{ route('skills.edit', $skill) }}">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('skills.destroy', $skill) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus skill ini?')"
                                    style="display:inline"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">
                            Belum ada data skill.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $skills->links() }}
    </div>

</div>

@endsection