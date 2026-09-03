<x-app-layout>
    <x-slot name="header">
        Batch & Import Data
    </x-slot>

    <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4 text-textprimary">Import Batch Excel</h2>
        
        @if(session('success'))
            <div class="bg-success/20 text-success border border-success/30 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 border border-red-300 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-700 border border-red-300 p-4 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('batch.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-4 items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-medium text-textsecondary mb-1">Pilih File Excel (SIPP)</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" class="block w-full text-sm text-textsecondary
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-medium
                    file:bg-primary/10 file:text-primary
                    hover:file:bg-primary/20 cursor-pointer
                "/>
            </div>
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-md font-medium hover:bg-primary/90 transition shadow-sm">
                Upload & Proses
            </button>
        </form>
    </div>

    <div class="bg-surface rounded-lg shadow-sm border border-bordercolor overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-appbg text-textsecondary font-medium border-b border-bordercolor">
                    <tr>
                        <th class="py-3 px-4">Tanggal Data</th>
                        <th class="py-3 px-4">Nama File</th>
                        <th class="py-3 px-4 text-right">Total Data</th>
                        <th class="py-3 px-4 text-right">Valid</th>
                        <th class="py-3 px-4 text-right">Baru</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bordercolor text-textprimary">
                    @forelse($batches as $batch)
                    <tr class="hover:bg-appbg/50 transition">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($batch->tanggal_data)->format('d M Y') }}</td>
                        <td class="py-3 px-4">{{ $batch->nama_file }}</td>
                        <td class="py-3 px-4 text-right">{{ number_format($batch->jumlah_data, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right">{{ number_format($batch->total_valid, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right">{{ number_format($batch->total_peserta_baru, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $batch->status_import === 'success' ? 'bg-success/20 text-success' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($batch->status_import) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('batch.show', $batch) }}" class="text-secondary hover:text-primary hover:underline font-medium">Lihat Peserta</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-textsecondary">Belum ada data batch. Mulai import file Excel pertama Anda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($batches->hasPages())
        <div class="p-4 border-t border-bordercolor">
            {{ $batches->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
