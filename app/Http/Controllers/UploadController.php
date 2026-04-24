<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload gambar produk (UMKM).
     * Mengembalikan URL yang bisa langsung disimpan ke kolom images (JSON).
     */
    public function uploadProductImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // max 5MB
        ]);

        $file     = $request->file('image');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('products', $filename, 'public');

        return response()->json([
            'message'  => 'Gambar berhasil diupload.',
            'url'      => Storage::url($path),
            'path'     => $path,
            'filename' => $filename,
        ], 201);
    }

    /**
     * Upload foto original untuk AI Product Studio.
     */
    public function uploadAiSource(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'], // max 10MB
        ]);

        $file     = $request->file('image');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('ai-source', $filename, 'public');

        return response()->json([
            'message'      => 'Foto berhasil diupload untuk AI Studio.',
            'url'          => Storage::url($path),
            'path'         => $path,
            'filename'     => $filename,
        ], 201);
    }

    /**
     * Upload avatar profil user.
     */
    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // max 2MB
        ]);

        $file     = $request->file('image');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('avatars', $filename, 'public');
        $url      = Storage::url($path);

        // Langsung update avatar_url di profil user
        $request->user()->profile?->update(['avatar_url' => $url]);

        return response()->json([
            'message'    => 'Avatar berhasil diupload.',
            'avatar_url' => $url,
            'path'       => $path,
        ], 201);
    }

    /**
     * Upload model AR (.glb/.gltf) untuk AR Try-On.
     */
    public function uploadArModel(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'file', 'mimes:glb,gltf', 'max:51200'], // max 50MB
        ]);

        $file     = $request->file('model');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('ar-models', $filename, 'public');

        return response()->json([
            'message'      => 'Model AR berhasil diupload.',
            'ar_model_url' => Storage::url($path),
            'path'         => $path,
        ], 201);
    }
}
