<x-app-layout>
    <x-slot name="header">
        Laporan & Export Data
    </x-slot>

    <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-6 max-w-2xl">
        <h3 class="font-semibold text-lg mb-4">Export Data Peserta</h3>
        <p class="text-textsecondary text-sm mb-6">Unduh data peserta beserta hasil verifikasi SIPP dan riwayat komunikasi terakhir dalam format Excel (.xlsx).</p>

        <form action="{{ route('laporan.export') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-textsecondary mb-1">Filter Batch (Opsional)</label>
                <select name="batch_id" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">
                    <option value="">-- Semua Batch --</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}">{{ $batch->nama_file }} ({{ \Carbon\Carbon::parse($batch->tanggal_data)->format('d M Y') }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-textsecondary mt-1">Biarkan kosong untuk mengunduh seluruh data peserta.</p>
            </div>
            
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md font-medium hover:bg-primary/90 transition shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Export ke Excel
            </button>
        </form>
    </div>
</x-app-layout>
