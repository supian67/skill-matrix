@extends('layouts.app')

@section('title', $assessment->exists ? 'Edit Assessment' : 'Tambah Assessment')

@section('content')

<style>
    .assessment-page {
        max-width: 1100px;
        margin: 0 auto;
        color: #243247;
    }

    .assessment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .assessment-header h1 {
        margin: 0;
        font-size: 25px;
        font-weight: 700;
        color: #123e68;
    }

    .assessment-header p {
        margin: 6px 0 0;
        color: #718096;
        font-size: 14px;
    }

    .assessment-card {
        background: #fff;
        border: 1px solid #e5eaf0;
        border-radius: 14px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(18, 62, 104, .05);
    }

    .assessment-card-header {
        padding: 17px 22px;
        background: #f7faff;
        border-bottom: 1px solid #e8eef5;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .assessment-card-header h2 {
        margin: 0;
        color: #123e68;
        font-size: 16px;
        font-weight: 700;
    }

    .assessment-card-body {
        padding: 24px;
    }

    .assessment-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .assessment-field {
        min-width: 0;
    }

    .assessment-field.full {
        grid-column: 1 / -1;
    }

    .assessment-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #43546a;
        margin-bottom: 7px;
    }

    .required-mark {
        color: #dc3545;
    }

    .assessment-control {
        width: 100%;
        min-height: 43px;
        padding: 10px 12px;
        border: 1px solid #d7e0ea;
        border-radius: 8px;
        background: #fff;
        color: #243247;
        font-size: 14px;
        box-sizing: border-box;
    }

    .assessment-control:focus {
        outline: none;
        border-color: #1769aa;
        box-shadow: 0 0 0 3px rgba(23, 105, 170, .10);
    }

    .assessment-control[readonly] {
        background: #f5f8fb;
    }

    .assessment-search {
        display: flex;
        gap: 9px;
    }

    .assessment-search input {
        flex: 1;
        min-width: 0;
    }

    .btn-assessment {
        border: 0;
        border-radius: 8px;
        padding: 10px 17px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: .2s;
    }

    .btn-search {
        background: #1769aa;
        color: #fff;
        white-space: nowrap;
    }

    .btn-search:hover {
        background: #12558b;
        color: #fff;
    }

    .btn-search:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .btn-save {
        background: #123e68;
        color: #fff;
    }

    .btn-save:hover {
        background: #0d3154;
        color: #fff;
    }

    .btn-cancel {
        background: #edf1f5;
        color: #43546a;
    }

    .btn-cancel:hover {
        background: #dfe6ed;
        color: #243247;
    }

    .employee-result {
        display: none;
        margin-top: 20px;
        padding: 18px;
        background: #f2f8ff;
        border: 1px solid #d5e8fb;
        border-radius: 10px;
    }

    .employee-result-title {
        color: #123e68;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .employee-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .employee-info-label {
        display: block;
        color: #718096;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .employee-info-value {
        color: #243247;
        font-size: 14px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .assessment-message {
        display: none;
        margin-top: 12px;
        padding: 11px 13px;
        border-radius: 8px;
        font-size: 13px;
    }

    .assessment-message.error {
        display: block;
        background: #fff1f0;
        color: #b42318;
        border: 1px solid #ffd5d2;
    }

    .assessment-message.success {
        display: block;
        background: #effaf3;
        color: #187443;
        border: 1px solid #ccebd7;
    }

    .assessment-hint {
        color: #8492a6;
        font-size: 12px;
        margin-top: 6px;
    }

    .assessment-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 8px;
        margin-bottom: 25px;
    }

    .field-error {
        display: block;
        margin-top: 5px;
        color: #dc3545;
        font-size: 12px;
    }

    @media (max-width: 650px) {
        .assessment-grid,
        .employee-info-grid {
            grid-template-columns: 1fr;
        }

        .assessment-card-body {
            padding: 17px;
        }

        .assessment-search {
            flex-direction: column;
        }

        .assessment-search .btn-search {
            width: 100%;
        }

        .assessment-header h1 {
            font-size: 21px;
        }
    }
</style>

<div class="assessment-page">

    {{-- HEADER --}}
    <div class="assessment-header">
        <div>
            <h1>
                {{ $assessment->exists ? 'Edit Assessment' : 'Tambah Assessment' }}
            </h1>
            <p>
                Input dan kelola hasil penilaian kompetensi karyawan.
            </p>
        </div>

        <a href="{{ route('assessments.index') }}"
           class="btn-assessment btn-cancel">
            ← Kembali
        </a>
    </div>

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        id="assessmentForm"
        action="{{ $assessment->exists
            ? route('assessments.update', $assessment->id)
            : route('assessments.store') }}"
        method="POST"
    >

        @csrf

        @if ($assessment->exists)
            @method('PUT')
        @endif

        {{-- BAGIAN 1: DATA KARYAWAN --}}
        <div class="assessment-card">

            <div class="assessment-card-header">
                <span>👤</span>
                <h2>Data Karyawan dari HRIS</h2>
            </div>

            <div class="assessment-card-body">

                <div class="assessment-field">

                    <label for="employee_search" class="assessment-label">
                        NIK Karyawan <span class="required-mark">*</span>
                    </label>

                    <div class="assessment-search">

                        <input
                            type="text"
                            name="employee_no"
                            id="employee_search"
                            class="assessment-control"
                            placeholder="Masukkan NIK karyawan"
                            autocomplete="off"
                            value="{{ old('employee_no', $assessment->employee->employee_no ?? '') }}"
                        >

                        <button
                            type="button"
                            id="btnSearchEmployee"
                            class="btn-assessment btn-search"
                        >
                            🔍 Cari NIK
                        </button>

                    </div>

                    <div class="assessment-hint">
                        Masukkan NIK sesuai database HRIS, kemudian klik Cari NIK.
                    </div>

                    {{-- ID KARYAWAN LOKAL UNTUK RELASI ASSESSMENT --}}
                    <input
                        type="hidden"
                        name="employee_id"
                        id="employee_id"
                        value="{{ old('employee_id', $assessment->employee_id) }}"
                    >

                    <div id="employeeMessage" class="assessment-message"></div>

                </div>

                {{-- INFORMASI KARYAWAN --}}
                <div
                    id="employeeResult"
                    class="employee-result"
                    style="{{ $assessment->employee ? 'display:block' : 'display:none' }}"
                >

                    <div class="employee-result-title">
                        ✓ Informasi Karyawan
                    </div>

                    <div class="employee-info-grid">

                        <div>
                            <span class="employee-info-label">NIK</span>
                            <span class="employee-info-value" id="infoEmployeeNo">
                                {{ $assessment->employee->employee_no ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <span class="employee-info-label">Nama Lengkap</span>
                            <span class="employee-info-value" id="infoName">
                                {{ $assessment->employee->name ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <span class="employee-info-label">Jenis Kelamin</span>
                            <span class="employee-info-value" id="infoGender">
                                {{ $assessment->employee->gender ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <span class="employee-info-label">Departemen</span>
                            <span class="employee-info-value" id="infoDepartment">
                                {{ $assessment->employee->department ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <span class="employee-info-label">Posisi / Jabatan</span>
                            <span class="employee-info-value" id="infoPosition">
                                {{ $assessment->employee->position ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <span class="employee-info-label">Organisasi</span>
                            <span class="employee-info-value" id="infoOrganization">
                                {{ $assessment->employee->organization ?? '-' }}
                            </span>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- BAGIAN 2: PENILAIAN KOMPETENSI --}}
        <div class="assessment-card">

            <div class="assessment-card-header">
                <span>📊</span>
                <h2>Penilaian Kompetensi</h2>
            </div>

            <div class="assessment-card-body">

                <div class="assessment-grid">

                    {{-- PILIH SKILL --}}
                    <div class="assessment-field full">

                        <label for="skill_id" class="assessment-label">
                            Kompetensi / Skill <span class="required-mark">*</span>
                        </label>

                        <select
                            name="skill_id"
                            id="skill_id"
                            class="assessment-control"
                            required
                        >
                            <option value="">-- Pilih Kompetensi --</option>

                            @foreach ($skills as $skill)
                                <option
                                    value="{{ $skill->id }}"
                                    {{ (string) old('skill_id', $assessment->skill_id) === (string) $skill->id ? 'selected' : '' }}
                                >
                                    {{ $skill->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('skill_id')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- LEVEL SAAT INI --}}
                    <div class="assessment-field">

                        <label for="assessed_level" class="assessment-label">
                            Level Saat Ini <span class="required-mark">*</span>
                        </label>

                        <select
                            name="assessed_level"
                            id="assessed_level"
                            class="assessment-control"
                            required
                        >
                            <option value="">-- Pilih Level --</option>

                            @for ($level = 1; $level <= 5; $level++)
                                <option
                                    value="{{ $level }}"
                                    {{ (string) old('assessed_level', $assessment->assessed_level) === (string) $level ? 'selected' : '' }}
                                >
                                    Level {{ $level }}
                                </option>
                            @endfor

                        </select>

                        <div class="assessment-hint">
                            Pilih tingkat kompetensi karyawan saat ini.
                        </div>

                        @error('assessed_level')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- TARGET LEVEL --}}
                    <div class="assessment-field">

                        <label for="target_level" class="assessment-label">
                            Target Level <span class="required-mark">*</span>
                        </label>

                        <select
                            name="target_level"
                            id="target_level"
                            class="assessment-control"
                            required
                        >
                            <option value="">-- Pilih Target --</option>

                            @for ($level = 1; $level <= 5; $level++)
                                <option
                                    value="{{ $level }}"
                                    {{ (string) old('target_level', $assessment->target_level) === (string) $level ? 'selected' : '' }}
                                >
                                    Level {{ $level }}
                                </option>
                            @endfor

                        </select>

                        <div class="assessment-hint">
                            Pilih tingkat kompetensi yang diharapkan.
                        </div>

                        @error('target_level')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                    </div>

                    
                    {{-- TANGGAL ASSESSMENT --}}
                    <div class="assessment-field">

                        <label for="assessed_at" class="assessment-label">
                            Tanggal Assessment <span class="required-mark">*</span>
                        </label>

                        <input
                            type="date"
                            name="assessed_at"
                            id="assessed_at"
                            class="assessment-control"
                            value="{{ old('assessed_at', $assessment->assessed_at ? \Illuminate\Support\Carbon::parse($assessment->assessed_at)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                            required
                        >

                        @error('assessed_at')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- PERIODE ASSESSMENT --}}
                    <div class="assessment-field">

                        <label class="assessment-label">
                            Periode Assessment
                        </label>

                        <input
                            type="text"
                            id="assessment_period"
                            class="assessment-control"
                            value=""
                            readonly
                        >

                        <div class="assessment-hint">
                            Periode ditentukan otomatis berdasarkan tanggal assessment.
                        </div>

                    </div>


                    {{-- PENILAI --}}
                    <div class="assessment-field">

                        <label for="assessor" class="assessment-label">
                            Nama Penilai
                        </label>

                        <input
                            type="text"
                            name="assessor"
                            id="assessor"
                            class="assessment-control"
                            maxlength="150"
                            placeholder="Masukkan nama penilai"
                            value="{{ old('assessor', $assessment->assessor) }}"
                        >

                        @error('assessor')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                    </div>

                    {{-- CATATAN --}}
                    <div class="assessment-field full">

                        <label for="notes" class="assessment-label">
                            Catatan / Keterangan
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            class="assessment-control"
                            rows="4"
                            maxlength="1000"
                            placeholder="Masukkan catatan hasil penilaian, jika ada..."
                        >{{ old('notes', $assessment->notes) }}</textarea>

                        @error('notes')
                            <small class="field-error">{{ $message }}</small>
                        @enderror

                    </div>

                </div>

            </div>
        </div>

        {{-- TOMBOL SIMPAN --}}
        <div class="assessment-footer">

            <a
                href="{{ route('assessments.index') }}"
                class="btn-assessment btn-cancel"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn-assessment btn-save"
                id="btnSave"
            >
                💾 {{ $assessment->exists ? 'Update Assessment' : 'Simpan Assessment' }}
            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('employee_search');
    const searchButton = document.getElementById('btnSearchEmployee');
    const employeeIdInput = document.getElementById('employee_id');
    const employeeResult = document.getElementById('employeeResult');
    const employeeMessage = document.getElementById('employeeMessage');
    const assessmentForm = document.getElementById('assessmentForm');
    const saveButton = document.getElementById('btnSave');


    const assessmentDate = document.getElementById('assessed_at');
const assessmentPeriod = document.getElementById('assessment_period');

function updateAssessmentPeriod() {

    if (!assessmentDate.value) {
        assessmentPeriod.value = '';
        return;
    }

    const date = new Date(assessmentDate.value + 'T12:00:00');

    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const quarter = Math.ceil(month / 3);

    const quarterNames = {
        1: 'Januari - Maret',
        2: 'April - Juni',
        3: 'Juli - September',
        4: 'Oktober - Desember'
    };

    assessmentPeriod.value =
        'Q' + quarter + ' - ' + year +
        ' (' + quarterNames[quarter] + ')';
}

assessmentDate.addEventListener('change', updateAssessmentPeriod);

updateAssessmentPeriod();

    const lookupUrl = @json(route('employees.lookup', ['nik' => '__NIK__']));

    function showMessage(message, type) {
        employeeMessage.textContent = message;
        employeeMessage.className = 'assessment-message ' + type;
    }

    function clearEmployee() {

        employeeIdInput.value = '';

        employeeResult.style.display = 'none';

        document.getElementById('infoEmployeeNo').textContent = '-';
        document.getElementById('infoName').textContent = '-';
        document.getElementById('infoGender').textContent = '-';
        document.getElementById('infoDepartment').textContent = '-';
        document.getElementById('infoPosition').textContent = '-';
        document.getElementById('infoOrganization').textContent = '-';
    }

    function fillEmployee(data) {

        employeeIdInput.value = data.employee_id;

        document.getElementById('infoEmployeeNo').textContent = data.employee_no || '-';
        document.getElementById('infoName').textContent = data.name || '-';
        document.getElementById('infoGender').textContent = data.gender || '-';
        document.getElementById('infoDepartment').textContent = data.department || '-';
        document.getElementById('infoPosition').textContent = data.position || '-';
        document.getElementById('infoOrganization').textContent = data.organization || '-';

        employeeResult.style.display = 'block';

        showMessage('Data karyawan berhasil ditemukan.', 'success');
    }

    async function searchEmployee() {

        const nik = searchInput.value.trim();

        if (!nik) {
            clearEmployee();
            showMessage('Silakan masukkan NIK karyawan terlebih dahulu.', 'error');
            searchInput.focus();
            return;
        }

        searchButton.disabled = true;
        searchButton.textContent = 'Mencari...';

        clearEmployee();

        showMessage('Sedang mencari data karyawan...', 'success');

        try {

            const url = lookupUrl.replace(
                '__NIK__',
                encodeURIComponent(nik)
            );

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(
                    result.message || 'Data karyawan tidak ditemukan.'
                );
            }

            if (!result.data || !result.data.employee_id) {
                throw new Error(
                    'Data ditemukan, tetapi ID karyawan lokal belum tersedia.'
                );
            }

            fillEmployee(result.data);

        } catch (error) {

            clearEmployee();

            showMessage(
                error.message || 'Terjadi kesalahan saat mencari data.',
                'error'
            );

        } finally {

            searchButton.disabled = false;
            searchButton.textContent = '🔍 Cari NIK';

        }
    }

    // TOMBOL CARI NIK
    searchButton.addEventListener('click', searchEmployee);

    // ENTER UNTUK MENCARI
    searchInput.addEventListener('keydown', function (event) {

        if (event.key === 'Enter') {
            event.preventDefault();
            searchEmployee();
        }

    });

    // KETIKA NIK DIUBAH, ID LAMA HARUS DIHAPUS
    searchInput.addEventListener('input', function () {

        clearEmployee();

        employeeMessage.className = 'assessment-message';
        employeeMessage.textContent = '';

    });

    // VALIDASI SEBELUM MENYIMPAN
    assessmentForm.addEventListener('submit', function (event) {

        if (!employeeIdInput.value) {

            event.preventDefault();

            showMessage(
                'Cari dan pilih data karyawan berdasarkan NIK sebelum menyimpan Assessment.',
                'error'
            );

            searchInput.focus();

            return;
        }

        const currentLevel = parseInt(
            document.getElementById('assessed_level').value,
            10
        );

        const targetLevel = parseInt(
            document.getElementById('target_level').value,
            10
        );

        if (
            currentLevel &&
            targetLevel &&
            targetLevel < currentLevel
        ) {

            const confirmSave = confirm(
                'Target level lebih rendah daripada level saat ini. Apakah Anda yakin ingin menyimpan?'
            );

            if (!confirmSave) {
                event.preventDefault();
            }

        }

        if (event.defaultPrevented) {
            return;
        }

        saveButton.disabled = true;
        saveButton.textContent = 'Menyimpan...';

    });

});
</script>

@endpush