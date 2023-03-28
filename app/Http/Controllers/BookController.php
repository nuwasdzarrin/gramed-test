<?php

namespace App\Http\Controllers;

use App\Http\Resources\GeneralResponseCollection;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public static function rules(Request $request = null)
    {
        return [
            'store' => [
                'judul' => 'required|string|max:255',
                'stok' => 'required|numeric',
                'gambar' => 'mimes:jpeg,jpg,png|max:2000|nullable',
            ],
            'update' => [
                'judul' => 'string|max:255',
                'stok' => 'numeric',
                'gambar' => 'mimes:jpeg,jpg,png|max:2000|nullable',
            ]
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::query()->get();
        return response()->view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate(self::rules($request)['store']);
        $book = new Book;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $book->{$key} = $request->file($key)->store('books', 'public');
                } elseif ($request->exists($key)) {
                    $book->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $book->{$key} = $request->{$key};
            }
        }
        $book->save();
        return (new GeneralResponseCollection($book, ['Success create book'], true))
            ->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate(self::rules($request)['update']);
        $book = Book::query()->findOrFail($id);
        foreach (self::rules($request)['update'] as $key => $value) {
            if (Str::contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $book->{$key} = $request->file($key)->store('books', 'public');
                } elseif ($request->exists($key)) {
                    $book->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $book->{$key} = $request->{$key};
            }
        }
        $book->save();
        return (new GeneralResponseCollection($book, ['Success create book'], true))
            ->response()->setStatusCode(200);
    }

    public function destroy($id)
    {
        $book = Book::query()->findOrFail($id);
        $book->delete();
        return response()->redirectToRoute('buku.index');
    }
}
