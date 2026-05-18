<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return response()->json(News::with('user')->latest()->get());
    }

    public function show(string $id)
    {
        $news = News::find($id);
        if (!$news) return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        
        return response()->json($news);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $news = $request->user()->news()->create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json(['message' => 'Berita berhasil dibuat!', 'data' => $news], 201);
    }

    public function update(Request $request, string $id)
    {
        $news = News::find($id);
        if (!$news) return response()->json(['message' => 'Berita tidak ditemukan'], 404);

        if ($news->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk mengubah berita ini.'], 403);
        }

        $news->update($request->all());
        return response()->json(['message' => 'Berita berhasil diupdate!', 'data' => $news]);
    }

    public function destroy(Request $request, string $id)
    {
        $news = News::find($id);
        if (!$news) return response()->json(['message' => 'Berita tidak ditemukan'], 404);

        if ($news->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk menghapus artikel ini.'], 403);
        }

        $news->delete();
        return response()->json(['message' => 'Berita berhasil dihapus!']);
    }
}
