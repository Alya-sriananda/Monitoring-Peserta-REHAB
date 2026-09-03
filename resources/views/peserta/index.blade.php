<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span>Data Peserta</span>
            @if($batchAktif)
                <span class="bg-primary/10 text-primary text-xs px-2.5 py-1 rounded-full font-medium border border-primary/20">Batch: {{ $batchAktif->nama_file }}</span>
            @endif
        </div>
    </x-slot>

    <div class="bg-surface rounded-lg shadow-sm border border-bordercolor overflow-hidden">
        <div class="p-4 border-b border-bordercolor flex gap-4 items-center justify-between">
            <form action="{{ route('peserta.index') }}" method="GET" class="flex gap-2">
                @if(request('batch'))
                    <input type="hidden" name="batch" value="{{ request('batch') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NOKA atau Nama..." class="border-bordercolor rounded-md text-sm w-64 focus:ring-primary focus:border-primary">
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/90 transition">Cari</button>
                @if(request('search'))
                    <a href="{{ route('peserta.index', request()->except('search')) }}" class="px-4 py-2 text-sm text-textsecondary hover:text-textprimary transition">Clear</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-appbg text-textsecondary font-medium border-b border-bordercolor">
                    <tr>
                        <th class="py-3 px-4">NOKA</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">No HP</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bordercolor text-textprimary">
                    @forelse($pesertas as $peserta)
                    <tr class="hover:bg-appbg/50 transition cursor-pointer" onclick="window.location='{{ route('peserta.show', $peserta) }}'">
                        <td class="py-3 px-4 font-medium">{{ $peserta->noka }}</td>
                        <td class="py-3 px-4">{{ $peserta->nama }}</td>
                        <td class="py-3 px-4">{{ $peserta->no_hp ?? '-' }}</td>
                        <td class="py-3 px-4 truncate max-w-[200px]">{{ $peserta->alamat ?? '-' }}</td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('peserta.show', $peserta) }}" class="text-secondary hover:text-primary font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-textsecondary">Data peserta tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pesertas->hasPages())
        <div class="p-4 border-t border-bordercolor">
            {{ $pesertas->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
