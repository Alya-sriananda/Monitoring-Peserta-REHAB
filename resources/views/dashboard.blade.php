<x-app-layout>
    <x-slot name="header">
        Dashboard Monitoring REHAB
    </x-slot>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5 flex flex-col justify-between">
            <div class="text-textsecondary text-sm font-medium mb-1">Total Peserta Master</div>
            <div class="text-3xl font-bold text-textprimary">{{ number_format($totalPeserta, 0, ',', '.') }}</div>
            <div class="mt-4 flex items-center justify-between text-xs text-textsecondary">
                <a href="{{ route('peserta.index') }}" class="text-secondary hover:underline font-medium">Lihat Semua Data &rarr;</a>
            </div>
        </div>
        
        <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5 flex flex-col justify-between">
            <div class="text-textsecondary text-sm font-medium mb-1">Total Batch Import</div>
            <div class="text-3xl font-bold text-textprimary">{{ number_format($totalBatch, 0, ',', '.') }}</div>
            <div class="mt-4 flex items-center justify-between text-xs text-textsecondary">
                <a href="{{ route('batch.index') }}" class="text-secondary hover:underline font-medium">Kelola Batch &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Priority Outstanding Widget -->
    <div class="bg-surface rounded-lg shadow-sm border border-bordercolor overflow-hidden">
        <div class="p-5 border-b border-bordercolor bg-appbg flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-lg text-textprimary">Priority Outstanding</h3>
                <p class="text-xs text-textsecondary mt-0.5">Peserta Terdaftar REHAB dengan sisa tunggakan yang belum lunas</p>
            </div>
            <span class="bg-warning/20 text-warning px-2.5 py-1 rounded-full text-xs font-semibold border border-warning/30">
                {{ $priorityOutstanding->count() }} Data Tertinggi
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-appbg text-textsecondary font-medium border-b border-bordercolor">
                    <tr>
                        <th class="py-3 px-4">NOKA</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Terakhir Cek SIPP</th>
                        <th class="py-3 px-4 text-right">Sisa Tunggakan</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bordercolor text-textprimary">
                    @forelse($priorityOutstanding as $peserta)
                    @php
                        $verifikasi = $peserta->verifikasi_sipps->first();
                        $sisa = $verifikasi->tagihan_sebelum_bulan_berjalan + $verifikasi->tagihan_bulan_berjalan;
                    @endphp
                    <tr class="hover:bg-appbg/50 transition">
                        <td class="py-3 px-4 font-medium">{{ $peserta->noka }}</td>
                        <td class="py-3 px-4">{{ $peserta->nama }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($verifikasi->tanggal_cek)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-right font-medium text-warning">Rp {{ number_format($sisa, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('peserta.show', $peserta) }}" class="text-secondary hover:text-primary font-medium hover:underline text-xs bg-secondary/10 px-3 py-1.5 rounded-full">Proses Data</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-textsecondary">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-success mb-3 opacity-80"><path d="m9 12 2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>
                                <span class="text-base text-textprimary font-medium">Tidak ada priority outstanding saat ini.</span>
                                <span class="text-sm mt-1">Semua data peserta dalam pengawasan telah tertangani!</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
