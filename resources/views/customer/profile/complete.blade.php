@extends('layouts.app')

@section('title', 'Lengkapi Profil - SkyLine Airways')

@section('content')
<div class="bg-slate-50 min-h-screen py-12 flex items-center justify-center">
    <div class="max-w-3xl w-full px-4">
        
        <!-- Welcome Card -->
        <div class="bg-brand-900 text-white rounded-3xl shadow-xl p-8 mb-6 relative overflow-hidden border border-slate-700">
            <div class="absolute right-0 top-0 opacity-10 translate-x-12 -translate-y-12">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L14 19v-5.5L21 16z"/></svg>
            </div>
            <div class="relative z-10">
                <span class="bg-brand-accent text-brand-900 font-extrabold text-xs uppercase tracking-widest px-3 py-1.5 rounded-full">
                    Satu Langkah Lagi
                </span>
                <h1 class="text-3xl font-extrabold mt-4">Lengkapi Profil Anda</h1>
                <p class="text-slate-300 mt-2 leading-relaxed">
                    Sebelum Anda dapat memesan tiket dan merencanakan perjalanan bersama kami, mohon luangkan waktu sejenak untuk melengkapi data profil resmi Anda di bawah ini.
                </p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-8">
            <form action="{{ route('customer.profile.complete.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Full Name -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap (Sesuai KTP/Paspor)</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('name') border-red-500 @enderror"
                            placeholder="Nama Lengkap Anda">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIK (16 Digit KTP)</label>
                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" required maxlength="16" minlength="16"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('nik') border-red-500 @enderror"
                            placeholder="Contoh: 3201234567890123" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('nik')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Passport Number -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Paspor (Opsional)</label>
                        <input type="text" name="passport_number" value="{{ old('passport_number', $user->identity_type === 'passport' ? $user->identity_number : '') }}"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('passport_number') border-red-500 @enderror"
                            placeholder="Contoh: B1234567">
                        @error('passport_number')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" required
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('birth_date') border-red-500 @enderror">
                        @error('birth_date')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                        <select name="gender" required
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('gender') border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Handphone (WhatsApp)</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('phone') border-red-500 @enderror"
                            placeholder="Contoh: 081234567890" oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nationality -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kewarganegaraan</label>
                        <input type="text" name="nationality" value="{{ old('nationality', $user->nationality ?? 'Indonesia') }}" required
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('nationality') border-red-500 @enderror"
                            placeholder="Contoh: Indonesia, Malaysia">
                        @error('nationality')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                        <textarea name="address" required rows="3"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition @error('address') border-red-500 @enderror"
                            placeholder="Tuliskan alamat lengkap tempat tinggal Anda...">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City, Province, Postal Code -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kota/Kabupaten</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}"
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition"
                            placeholder="Contoh: Depok, Bogor">
                    </div>
                    <div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Provinsi</label>
                                <input type="text" name="province" value="{{ old('province', $user->province) }}"
                                    class="w-full border-2 border-slate-200 rounded-xl px-3 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition"
                                    placeholder="Jawa Barat">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" maxlength="5"
                                    class="w-full border-2 border-slate-200 rounded-xl px-3 py-3 focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition"
                                    placeholder="16412" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Profil</label>
                        <div class="flex items-center gap-6 p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl">
                            <div class="w-16 h-16 rounded-full bg-slate-200 flex-shrink-0 flex items-center justify-center overflow-hidden border border-slate-300">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                @endif
                            </div>
                            <div>
                                <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg" class="text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-900 file:text-white hover:file:bg-brand-800 transition">
                                <p class="text-xs text-slate-400 mt-2">Mendukung format JPG, JPEG, PNG. Maksimal ukuran 2MB.</p>
                            </div>
                        </div>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-brand-accent hover:bg-amber-500 text-brand-900 font-extrabold py-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                        Simpan dan Lanjutkan
                    </button>
                </div>

            </form>
        </div>
        
        <!-- Simple Logout Link -->
        <div class="text-center mt-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-red-600 transition">
                    Keluar / Logout
                </button>
            </form>
        </div>
        
    </div>
</div>
@endsection
