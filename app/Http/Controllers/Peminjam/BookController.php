<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $books = Book::with('category')
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->input('category_id'));
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $keyword = $request->input('search');

                $query->where(function ($inner) use ($keyword) {
                    $inner->where('title', 'like', "%{$keyword}%")
                        ->orWhere('author', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('title')
            ->paginate(12);

        if ($request->ajax()) {
            return view('borrower.books.grid', compact('books'));
        }

        $categories = Category::orderBy('category_name')->get();

        return view('borrower.books.index', compact('books', 'categories'));
    }

    public function show(Book $book): View
    {
        $book->load('category');

        return view('borrower.books.show', compact('book'));
    }
}
