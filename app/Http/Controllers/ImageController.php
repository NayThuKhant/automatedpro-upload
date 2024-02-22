<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ImageController extends Controller
{
    public function store(CreateImageRequest $request)
    {
        if ($request->ajax()) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            return Storage::disk('public')->url($filePath);
        }

        throw ValidationException::withMessages(["only ajax requests are allowed"]);
    }
}
