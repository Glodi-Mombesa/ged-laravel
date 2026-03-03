<x-admin-layout>
    <x-slot name="title">Nouveau document</x-slot>
    <x-slot name="subtitle">Upload multi-format + classement optionnel</x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="mb-6 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                    <i class="fa-solid fa-upload text-indigo-600 mr-2"></i>
                    Ajouter un document
                </h1>
                <p class="text-slate-600 mt-1">
                    Formats : PDF, Word, Excel, PowerPoint (max 20MB).
                    <span class="text-slate-500">Prévisualisation : PDF uniquement.</span>
                </p>
            </div>

            <a href="{{ route('admin.documents.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold text-sm">
                <i class="fa-solid fa-arrow-left"></i>
                Retour
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 px-4 py-3 rounded-2xl border border-rose-200 bg-rose-50 text-rose-800">
                <div class="font-semibold mb-1"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Veuillez corriger :</div>
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data"
              class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            @csrf

            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    <span class="font-semibold text-slate-900">Nouvel upload</span>
                    <span class="hidden sm:inline">• GED Administration</span>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-xl border border-indigo-200 bg-indigo-50 text-indigo-700 font-semibold">
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Upload
                </span>
            </div>

            <div class="p-6 space-y-6">

                {{-- Infos --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 font-extrabold">1</span>
                        <h2 class="text-base font-semibold text-slate-900">Informations</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">Titre <span class="text-rose-600">*</span></label>
                            <input name="title" value="{{ old('title') }}" required
                                   class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Ex: Procédure de validation des courriers">
                            @error('title') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Référence (optionnel)</label>
                            <input name="reference" value="{{ old('reference') }}"
                                   class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Ex: SEC-2026-013">
                            @error('reference') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Statut <span class="text-rose-600">*</span></label>
                            <select name="status" required
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="draft" @selected(old('status','draft')==='draft')>Brouillon</option>
                                <option value="validated" @selected(old('status')==='validated')>Validé</option>
                                <option value="archived" @selected(old('status')==='archived')>Archivé</option>
                            </select>
                            @error('status') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Classement --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 font-extrabold">2</span>
                        <h2 class="text-base font-semibold text-slate-900">Classement</h2>
                        <span class="text-xs text-slate-500">Optionnel</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Service</label>
                            <select name="service_id"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">— Aucun —</option>
                                @foreach($services as $s)
                                    <option value="{{ $s->id }}" @selected(old('service_id')==$s->id)>{{ $s->name }}</option>
                                @endforeach
                            </select>
                            @error('service_id') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Dossier</label>
                            <select name="folder_id"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">— Aucun —</option>
                                @foreach($folders as $f)
                                    <option value="{{ $f->id }}" @selected(old('folder_id')==$f->id)>{{ $f->name }}</option>
                                @endforeach
                            </select>
                            @error('folder_id') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-3 text-xs text-slate-500">
                        <i class="fa-solid fa-lightbulb mr-1"></i>
                        Astuce : choisis un <b>Service</b> et un <b>Dossier</b> pour mieux organiser.
                    </div>
                </div>

                {{-- Fichier --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 font-extrabold">3</span>
                        <h2 class="text-base font-semibold text-slate-900">Fichier</h2>
                        <span class="text-xs text-slate-500">Obligatoire</span>
                    </div>

                    <div class="rounded-3xl border border-slate-200 p-5 bg-slate-50">
                        <label class="text-sm font-semibold text-slate-700">Sélectionner un fichier</label>

                        <input type="file" name="file"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                               required
                               class="mt-2 block w-full text-sm text-slate-700
                                      file:mr-3 file:py-2.5 file:px-4
                                      file:rounded-2xl file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-600 file:text-white
                                      hover:file:bg-indigo-700">

                        <div class="mt-2 text-xs text-slate-500">
                            <b>PDF</b> (prévisualisable), DOC/DOCX, XLS/XLSX, PPT/PPTX.
                        </div>

                        @error('file') <div class="text-sm text-rose-700 mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 font-extrabold">4</span>
                        <h2 class="text-base font-semibold text-slate-900">Description</h2>
                        <span class="text-xs text-slate-500">Optionnel</span>
                    </div>

                    <textarea name="description" rows="4"
                              class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Décris brièvement le contenu / objectif du document...">{{ old('description') }}</textarea>
                    @error('description') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-200 bg-white flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Le document sera enregistré et traçable.
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.documents.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                        Annuler
                    </a>
                    <button class="px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Uploader
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>