<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Service;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $serviceId = $request->integer('service_id');
        $folderId  = $request->integer('folder_id');

        $documents = Document::query()
            ->with(['service','folder'])
            ->where('status', 'validated')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('reference', 'like', "%{$q}%")
                        ->orWhere('original_name', 'like', "%{$q}%");
                });
            })
            ->when($serviceId, fn($query) => $query->where('service_id', $serviceId))
            ->when($folderId, fn($query) => $query->where('folder_id', $folderId))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $services = Service::query()->orderBy('name')->get();

        // Si tu n’as pas encore Folder, commente cette ligne
        $folders = Folder::query()->orderBy('name')->get();

        return view('user.documents.index', compact('documents','q','serviceId','folderId','services','folders'));
    }

    public function preview(Document $document)
    {
        // Sécurité: user ne voit que les documents validés
        abort_if($document->status !== 'validated', 403);

        $mime = strtolower((string) ($document->mime_type ?? ''));

        // Preview uniquement PDF
        if (!str_contains($mime, 'pdf')) {
            return redirect()
                ->route('user.documents.index')
                ->with('success', "Prévisualisation disponible uniquement pour les PDF.");
        }

        $disk = 'public';
        $path = $document->file_path;

        abort_unless(Storage::disk($disk)->exists($path), 404);

        // Inline preview (dans navigateur)
        return response()->file(
            Storage::disk($disk)->path($path),
            [
                'Content-Type' => $document->mime_type ?: 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$document->original_name.'"',
            ]
        );
    }

    public function download(Document $document)
    {
        abort_if($document->status !== 'validated', 403);

        $disk = 'public';
        $path = $document->file_path;

        abort_unless(Storage::disk($disk)->exists($path), 404);

        return Storage::disk($disk)->download($path, $document->original_name);
    }
}