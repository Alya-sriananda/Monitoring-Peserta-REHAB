<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('peserta.index') }}" class="text-textsecondary hover:text-textprimary transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            </a>
            <span>Detail Peserta</span>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-success/20 text-success border border-success/30 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Info Peserta -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                <h3 class="font-semibold text-lg mb-4">Informasi Dasar</h3>
                
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="block text-textsecondary mb-1">Nama Lengkap</span>
                        <span class="font-medium text-textprimary text-base">{{ $peserta->nama }}</span>
                    </div>
                    <div>
                        <span class="block text-textsecondary mb-1">NOKA</span>
                        <span class="font-medium text-textprimary">{{ $peserta->noka }}</span>
                    </div>
                    <div>
                        <span class="block text-textsecondary mb-1">No HP / WhatsApp</span>
                        <span class="font-medium text-textprimary">{{ $peserta->no_hp ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-textsecondary mb-1">Alamat</span>
                        <span class="font-medium text-textprimary">{{ $peserta->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                <h3 class="font-semibold text-lg mb-4">Histori Batch</h3>
                <div class="space-y-3">
                    @forelse($peserta->batches as $batch)
                        <div class="flex items-center justify-between text-sm py-2 border-b border-bordercolor last:border-0">
                            <span class="text-textsecondary">{{ \Carbon\Carbon::parse($batch->tanggal_data)->format('d M Y') }}</span>
                            <span class="text-textprimary font-medium">{{ $batch->nama_file }}</span>
                        </div>
                    @empty
                        <span class="text-sm text-textsecondary">Tidak ada histori batch</span>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Verifikasi & Komunikasi -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Form Verifikasi SIPP -->
            <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    Verifikasi SIPP
                </h3>
                
                <form action="{{ route('verifikasi.store', $peserta) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-textsecondary mb-1">Terdaftar REHAB?</label>
                            <select name="terdaftar_rehab" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-textsecondary mb-1">Tanggal Daftar REHAB</label>
                            <input type="date" name="tanggal_daftar_rehab" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-textsecondary mb-1">Tagihan Sebelumnya (Rp)</label>
                            <input type="number" name="tagihan_sebelum_bulan_berjalan" required min="0" value="0" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-textsecondary mb-1">Tagihan Berjalan (Rp)</label>
                            <input type="number" name="tagihan_bulan_berjalan" required min="0" value="0" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-textsecondary mb-1">Jumlah Anggota Keluarga SIPP</label>
                            <input type="number" name="jumlah_peserta_sipp" required min="1" value="1" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-textsecondary mb-1">Status Pembayaran</label>
                            <input type="text" name="status_pembayaran_bulan_berjalan" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-textsecondary mb-1">Catatan</label>
                        <textarea name="catatan" rows="2" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-primary text-white px-5 py-2 rounded-md text-sm font-medium hover:bg-primary/90 transition shadow-sm">Simpan Verifikasi</button>
                    </div>
                </form>
            </div>
            
            <!-- Riwayat Verifikasi -->
            @if($peserta->verifikasi_sipps->isNotEmpty())
            <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                <h3 class="font-semibold text-lg mb-4">Riwayat Verifikasi SIPP</h3>
                <div class="space-y-4">
                    @foreach($peserta->verifikasi_sipps->sortByDesc('created_at') as $verifikasi)
                        <div class="border border-bordercolor rounded p-3 text-sm">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium text-textprimary">{{ \Carbon\Carbon::parse($verifikasi->tanggal_cek)->format('d M Y H:i') }} oleh {{ $verifikasi->user->name }}</span>
                                <span class="bg-{{ $verifikasi->terdaftar_rehab ? 'success' : 'gray-100' }} text-{{ $verifikasi->terdaftar_rehab ? 'white' : 'gray-700' }} px-2 py-0.5 rounded text-xs font-medium">
                                    {{ $verifikasi->terdaftar_rehab ? 'REHAB' : 'Bukan REHAB' }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <div><span class="text-textsecondary">Tagihan Sebelum:</span> Rp {{ number_format($verifikasi->tagihan_sebelum_bulan_berjalan, 0, ',', '.') }}</div>
                                <div><span class="text-textsecondary">Tagihan Berjalan:</span> Rp {{ number_format($verifikasi->tagihan_bulan_berjalan, 0, ',', '.') }}</div>
                                @if($verifikasi->catatan)
                                    <div class="col-span-2 mt-1"><span class="text-textsecondary">Catatan:</span> {{ $verifikasi->catatan }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- WhatsApp & Komunikasi -->
            <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#25D366]"><path d="M3 21l1.65-3.8a9 9 0 1 1 3.4 2.9L3 21"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0v1a5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></svg>
                    WhatsApp & Komunikasi
                </h3>
                
                <div class="space-y-4" x-data="waGenerator()">
                    <div>
                        <label class="block text-sm font-medium text-textsecondary mb-1">Pilih Template Pesan</label>
                        <select x-model="templateId" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                            <option value="">-- Pilih Template --</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->nama_template }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div x-show="templateId" style="display: none;">
                        <label class="block text-sm font-medium text-textsecondary mb-1">Preview Pesan</label>
                        <textarea x-model="message" rows="5" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary bg-gray-50" readonly></textarea>
                    </div>

                    <div class="flex gap-2" x-show="message" style="display: none;">
                        <button @click="copyToClipboard" class="flex-1 bg-white border border-bordercolor text-textprimary py-2 rounded-md text-sm font-medium hover:bg-gray-50 transition" x-text="copyText"></button>
                        <a :href="whatsappUrl" target="_blank" class="flex-1 bg-[#25D366] text-white py-2 rounded-md text-sm font-medium hover:bg-[#20b858] transition text-center flex items-center justify-center gap-2">
                            Buka WhatsApp Web
                        </a>
                    </div>
                    
                    <!-- Form Catat Hasil -->
                    <div class="border-t border-bordercolor pt-4 mt-4">
                        <h4 class="font-medium text-sm mb-3 text-textprimary">Catat Hasil Komunikasi</h4>
                        <form action="{{ route('komunikasi.store', $peserta) }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="template_id" :value="templateId">
                            <input type="hidden" name="pesan" :value="message">
                            
                            <div>
                                <label class="block text-xs font-medium text-textsecondary mb-1">Status Komunikasi</label>
                                <select name="status" required class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                                    <option value="sudah_dihubungi">Sudah Dihubungi</option>
                                    <option value="tidak_terdaftar_wa">Nomor Tidak Terdaftar WA</option>
                                    <option value="salah_sambung">Salah Sambung</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-textsecondary mb-1">Catatan/Respon Peserta</label>
                                <textarea name="catatan" rows="2" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary"></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-primary text-white py-2 rounded-md text-sm font-medium hover:bg-primary/90 transition shadow-sm">Simpan Catatan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Riwayat Komunikasi -->
            @if($peserta->komunikasis->isNotEmpty())
            <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                <h3 class="font-semibold text-lg mb-4">Riwayat Komunikasi</h3>
                <div class="space-y-4">
                    @foreach($peserta->komunikasis->sortByDesc('created_at') as $komunikasi)
                        <div class="border border-bordercolor rounded p-3 text-sm">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium text-textprimary">{{ \Carbon\Carbon::parse($komunikasi->tanggal_dihubungi)->format('d M Y H:i') }} oleh {{ $komunikasi->user->name }}</span>
                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs font-medium">
                                    {{ str_replace('_', ' ', \Illuminate\Support\Str::title($komunikasi->status)) }}
                                </span>
                            </div>
                            @if($komunikasi->pesan)
                                <div class="mt-2 text-textsecondary text-xs p-2 bg-gray-50 rounded border border-gray-100 italic">
                                    {{ \Illuminate\Support\Str::limit($komunikasi->pesan, 100) }}
                                </div>
                            @endif
                            @if($komunikasi->catatan)
                                <div class="mt-2"><span class="text-textsecondary">Respon/Catatan:</span> {{ $komunikasi->catatan }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('waGenerator', () => ({
                templateId: '',
                message: '',
                copyText: 'Salin Pesan',
                pesertaUrl: '{{ route("komunikasi.generate", $peserta) }}',
                noHp: '{{ preg_replace("/[^0-9]/", "", $peserta->no_hp) }}',
                
                init() {
                    this.$watch('templateId', async (value) => {
                        if (!value) {
                            this.message = '';
                            return;
                        }
                        
                        try {
                            const response = await fetch(this.pesertaUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ template_id: value })
                            });
                            const data = await response.json();
                            this.message = data.message;
                        } catch (e) {
                            console.error('Error generating message', e);
                            alert('Gagal generate pesan.');
                        }
                    });
                },
                
                get whatsappUrl() {
                    let formattedHp = this.noHp;
                    if (formattedHp.startsWith('0')) {
                        formattedHp = '62' + formattedHp.substring(1);
                    }
                    const encodedMessage = encodeURIComponent(this.message);
                    return `https://wa.me/${formattedHp}?text=${encodedMessage}`;
                },
                
                async copyToClipboard() {
                    try {
                        await navigator.clipboard.writeText(this.message);
                        this.copyText = 'Tersalin!';
                        setTimeout(() => { this.copyText = 'Salin Pesan'; }, 2000);
                    } catch (err) {
                        alert('Gagal menyalin text');
                    }
                }
            }))
        })
    </script>
</x-app-layout>
