<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKucingRequest;
use App\Http\Requests\UpdateKucingRequest;
use App\Models\Kucing;
use Illuminate\Http\Request;
use App\Models\User;

class KucingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('sanctum')->user();
        $kucings = $user ? Kucing::where('id_user', null)->orWhere('id_user', $user->id_user)->get() : Kucing::where('id_user', null)->get();
        
        return response()->json([
            'success' => true,
            'message' => "Berhasil mengambil data kucing",
            'data' => $kucings->map(function ($kucing) use ($user) {
                return [
                    'id_kucing' => $kucing->id_kucing,
                    'name' => $kucing->name,
                    'warna' => $kucing->warna,
                    'rating' => $kucing->rating,
                    'mine' => $user && $kucing->id_user === $user->id_user ? "1" : "0"
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getImage($id_kucing) {
        $kucing = Kucing::find($id_kucing);

        if ($kucing) {
            $path = public_path($kucing->imageUrl);
            return response()->file($path);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKucingRequest $request)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "warna" => ["required", "string"],
            "rating" => ["required", "numeric"],
            "image" => ["required", "image"],
        ]);

        $image = $request->image;
        $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('gambar'), $filename);

        $kucing = Kucing::create([
            "id_user" => $request->user()->id_user,
            'name' => $request->name,
            'warna' => $request->warna,
            'rating' => $request->rating,
            'imageUrl' => "gambar/$filename"
        ]);

        return response()->json([
            'success' => true,
            'message' => "Berhasil menambahkan kucing"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kucing $kucing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kucing $kucing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKucingRequest $request, $id_kucing)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "warna" => ["required", "string"],
            "rating" => ["required", "numeric"],
            "image" => ["image"],
        ]);

        $kucing = Kucing::find($id_kucing);

        if(!$kucing) {
            return response()->json([
                'success' => false,
                'message' => "Kucing tidak ditemukan"
            ]);
        }

        if ($kucing->id_user != $request->user()->id_user) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda',
            ]);
        }

        $image = $request->image;
        if ($image) {
            $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gambar'), $filename);
            $kucing->imageUrl = "gambar/$filename";
        }

        $kucing->name = $request->name;
        $kucing->warna = $request->warna;
        $kucing->rating = $request->rating;
    
        $kucing->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id_kucing)
    {
        $kucing = Kucing::find($id_kucing);

        if (!$kucing) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        if ($kucing->id_user != $request->user()->id_user) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda',
            ]);
        }

        $kucing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}