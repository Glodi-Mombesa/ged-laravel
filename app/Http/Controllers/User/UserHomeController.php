<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Service;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index(Request $request)
    {
        // Stats (documents validés uniquement)
        $totalValidated = Document::query()->where('status', 'validated')->count();

        $latestDocuments = Document::query()
            ->with(['service', 'folder'])
            ->where('status', 'validated')
            ->latest()
            ->limit(6)
            ->get();

        $services = Service::query()
            ->orderBy('name')
            ->get();

        return view('user.home', compact('totalValidated', 'latestDocuments', 'services'));
    }
}