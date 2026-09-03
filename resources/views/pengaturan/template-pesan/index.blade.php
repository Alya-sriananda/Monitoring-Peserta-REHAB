<x-app-layout>
    <x-slot name="header">
        Pengaturan Template WhatsApp
    </x-slot>

    @if(session('success'))
        <div class="bg-success/20 text-success border border-success/30 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                <h3 class="font-semibold text-lg mb-4">Tambah Template Baru</h3>
                <form action="{{ route('template-pesan.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-textsecondary mb-1">Nama Template</label>
                        <input type="text" name="nama_template" required class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary" placeholder="Cth: Tagihan REHAB">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-textsecondary mb-1">Isi Pesan</label>
                        <textarea name="isi_template" required rows="6" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary"></textarea>
                        <p class="text-xs text-textsecondary mt-2">Gunakan variabel berikut:<br> {name}, {noka}, {no_hp}, {tagihan_sebelumnya}, {tagihan_berjalan}, {sisa_tunggakan}</p>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white py-2 rounded-md font-medium hover:bg-primary/90 transition shadow-sm">Simpan Template</button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            @foreach($templates as $template)
                <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-5">
                    <form action="{{ route('template-pesan.update', $template) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex justify-between items-start mb-4">
                            <input type="text" name="nama_template" value="{{ $template->nama_template }}" class="border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary w-1/2 font-semibold">
                            
                            <div class="flex gap-2 items-center">
                                <label class="flex items-center gap-2 mr-2 cursor-pointer">
                                    <input type="checkbox" name="aktif" value="1" {{ $template->aktif ? 'checked' : '' }} class="rounded text-primary focus:ring-primary border-bordercolor">
                                    <span class="text-sm font-medium text-textsecondary">Aktif</span>
                                </label>
                                <button type="submit" class="bg-secondary text-white px-3 py-1.5 rounded text-sm font-medium hover:bg-secondary/90 transition">Update</button>
                                <button type="button" onclick="if(confirm('Hapus template ini?')) document.getElementById('delete-{{$template->id}}').submit()" class="bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 px-3 py-1.5 rounded text-sm font-medium transition">Hapus</button>
                            </div>
                        </div>
                        <textarea name="isi_template" rows="4" class="w-full border-bordercolor rounded-md text-sm focus:ring-primary focus:border-primary">{{ $template->isi_template }}</textarea>
                    </form>
                    <form id="delete-{{$template->id}}" action="{{ route('template-pesan.destroy', $template) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
            
            @if($templates->isEmpty())
                <div class="bg-surface rounded-lg shadow-sm border border-bordercolor p-8 text-center text-textsecondary">
                    Belum ada template pesan yang dibuat.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
