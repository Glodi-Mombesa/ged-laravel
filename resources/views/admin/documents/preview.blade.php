<x-admin-layout>
    <x-slot name="title">Prévisualisation</x-slot>
    <x-slot name="subtitle">PDF seulement</x-slot>

    @php
        $mime = strtolower((string)($document->mime_type ?? ''));
        $isPdf = str_contains($mime, 'pdf');
        $fileUrl = Storage::disk('public')->url($document->file_path); // ✅ correction
    @endphp

    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                    <i class="fa-solid fa-eye text-indigo-600 mr-2"></i>
                    Prévisualisation
                </h1>
                <p class="text-slate-600 mt-1">
                    {{ $document->title }} — <span class="font-semibold">{{ $document->original_name }}</span>
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.documents.download', $document) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                    <i class="fa-solid fa-download"></i> Télécharger
                </a>
                <a href="{{ route('admin.documents.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold">
                    <i class="fa-solid fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 text-sm text-slate-600 flex items-center justify-between">
                <div>
                    Format : <span class="font-semibold text-slate-900">{{ $document->mime_type }}</span>
                </div>
                <div class="text-xs text-slate-500">
                    <i class="fa-solid fa-circle-info mr-1"></i> Preview = PDF uniquement
                </div>
            </div>

            @if($isPdf)
                <iframe src="{{ $fileUrl }}"
                        class="w-full"
                        style="height:80vh;"
                        title="Prévisualisation PDF"></iframe>
            @else
                <div class="p-8 text-slate-700">
                    <div class="font-extrabold text-slate-900 mb-1">Prévisualisation indisponible</div>
                    <div class="text-sm text-slate-600">
                        Seuls les fichiers <b>PDF</b> sont prévisualisables. Pour ce fichier, utilise le téléchargement.
                    </div>

                    <a href="{{ route('admin.documents.download', $document) }}"
                       class="inline-flex mt-4 items-center gap-2 px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                        <i class="fa-solid fa-download"></i> Télécharger
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>