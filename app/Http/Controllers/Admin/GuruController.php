<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GuruController extends Controller
{
    public function index(Request $request): View
    {
        $gurus = Guru::query()
            ->when($request->q, fn ($q, $search) => $q->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('mapel', 'like', "%{$search}%");
            }))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    public function create(): View
    {
        return view('admin.guru.form', ['guru' => new Guru]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateGuru($request);
        $data['foto'] = $this->storeFoto($request);
        $data['aktif'] = $request->boolean('aktif', true);

        $guru = Guru::create($data);
        $this->syncUserAccount($guru, $request);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru): View
    {
        $guru->load('user');

        return view('admin.guru.form', compact('guru'));
    }

    public function update(Request $request, Guru $guru): RedirectResponse
    {
        $data = $this->validateGuru($request, $guru->id);
        $data['aktif'] = $request->boolean('aktif', true);

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $this->storeFoto($request);
        }

        $guru->update($data);
        $this->syncUserAccount($guru, $request);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru): RedirectResponse
    {
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->user?->delete();
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    private function validateGuru(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:guru,nip,'.$ignoreId],
            'mapel' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:guru,email,'.$ignoreId],
            'kontak' => ['nullable', 'string', 'max:50'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'password' => [$ignoreId ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    private function storeFoto(Request $request): ?string
    {
        if (! $request->hasFile('foto')) {
            return null;
        }

        return $request->file('foto')->store('guru', 'public');
    }

    private function syncUserAccount(Guru $guru, Request $request): void
    {
        if (! $request->filled('password') && $guru->user) {
            return;
        }

        if (! $request->filled('password')) {
            return;
        }

        User::updateOrCreate(
            ['guru_id' => $guru->id],
            [
                'name' => $guru->nama,
                'email' => $guru->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
            ]
        );
    }
}
