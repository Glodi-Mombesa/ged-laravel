<x-admin-layout>
    <x-slot name="title">Modifier document</x-slot>
    <x-slot name="subtitle">Mise à jour + remplacement de fichier</x-slot>

    @php
        $mime = strtolower((string)($document->mime_type ?? ''));
        $isPdf = str_contains($mime, 'pdf');
        $ext = strtoupper(pathinfo((string)$document->original_name, PATHINFO_EXTENSION));
    @endphp

    <div class="max-w-4xl mx-auto">

        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                    <i class="fa-solid fa-pen-to-square text-indigo-600 mr-2"></i>
                    Modifier le document
                </h1>
                <p class="text-slate-600 mt-1">
                    Fichier actuel : <span class="font-semibold text-slate-900">{{ $document->original_name }}</span>
                    <span class="text-slate-500">({{ $ext }})</span>
                </p>
            </div>

            <div class="flex gap-2">
                @if($isPdf)
                    <a target="_blank" href="{{ route('admin.documents.preview', $document) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold text-sm">
                        <i class="fa-solid fa-eye"></i> Preview
                    </a>
                @endif

                <a href="{{ route('admin.documents.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.documents.update', $document) }}" enctype="multipart/form-data"
              class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="text-sm font-semibold text-slate-700">Titre</label>
                <input name="title" value="{{ old('title', $document->title) }}" required
                       class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                @error('title') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Référence</label>
                    <input name="reference" value="{{ old('reference', $document->reference) }}"
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Service</label>
                    <select name="service_id"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">— Aucun —</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" @selected(old('service_id', $document->service_id)==$s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Dossier (optionnel)</label>
                    <select name="folder_id"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">— Aucun —</option>
                        @foreach($folders as $f)
                            <option value="{{ $f->id }}" @selected(old('folder_id', $document->folder_id)==$f->id)>{{ $f->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Statut</label>
                    <select name="status" required
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="draft" @selected(old('status',$document->status)==='draft')>Brouillon</option>
                        <option value="validated" @selected(old('status',$document->status)==='validated')>Validé</option>
                        <option value="archived" @selected(old('status',$document->status)==='archived')>Archivé</option>
                    </select>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="text-sm font-semibold text-slate-900">Fichier actuel</div>
                        <div class="text-sm text-slate-700">{{ $document->original_name }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ $document->mime_type }} • {{ number_format(($document->file_size ?? 0)/1024, 1) }} KB</div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.documents.download', $document) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition text-sm">
                            <i class="fa-solid fa-download"></i> Télécharger
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Remplacer le fichier (optionnel)</label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                       class="mt-1 block w-full text-sm text-slate-700
                              file:mr-3 file:py-2.5 file:px-4
                              file:rounded-2xl file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-600 file:text-white
                              hover:file:bg-indigo-700">
                <div class="text-xs text-slate-500 mt-2">
                    <i class="fa-solid fa-circle-info mr-1"></i> Preview = PDF uniquement.
                </div>
                @error('file') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Description</label>
                <textarea name="description" rows="4"
                          class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $document->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <a href="{{ route('admin.documents.index') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                    Annuler
                </a>
                <button class="px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-rotate mr-2"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>