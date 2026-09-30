<?php

namespace App\Http\Controllers\Borrower;

use App\Exceptions\BorrowingException;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(Request $request): View
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', $request->user()->id)
            ->when($request->input('status') === 'borrowed', fn ($query) => $query->whereNull('returned_at'))
            ->when($request->input('status') === 'returned', fn ($query) => $query->whereNotNull('returned_at'))
            ->latest('borrowed_at')
            ->latest('id')
            ->paginate(10);

        return view('borrower.borrowings.index', compact('borrowings'));
    }

    public function store(Request $request, Book $book): RedirectResponse
    {
        $userId = $request->user()->id;

        try {
            DB::transaction(function () use ($userId, $book) {
                $locked = Book::whereKey($book->id)->lockForUpdate()->firstOrFail();

                if ($locked->stock < 1) {
                    throw new BorrowingException('Stok buku ini sedang habis.');
                }

                $alreadyBorrowed = Borrowing::where('user_id', $userId)
                    ->where('book_id', $locked->id)
                    ->whereNull('returned_at')
                    ->exists();

                if ($alreadyBorrowed) {
                    throw new BorrowingException('Kamu masih meminjam buku ini.');
                }

                $locked->decrement('stock');

                Borrowing::create([
                    'user_id' => $userId,
                    'book_id' => $locked->id,
                    'borrowed_at' => now()->toDateString(),
                ]);
            });
        } catch (BorrowingException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Buku berhasil dipinjam.');
    }

    public function returnBook(Request $request, Borrowing $borrowing): RedirectResponse
    {
        abort_unless((int) $borrowing->user_id === (int) $request->user()->id, 403);

        try {
            DB::transaction(function () use ($borrowing) {
                $locked = Borrowing::whereKey($borrowing->id)->lockForUpdate()->firstOrFail();

                if ($locked->returned_at !== null) {
                    throw new BorrowingException('Buku ini sudah dikembalikan.');
                }

                Book::whereKey($locked->book_id)->lockForUpdate()->firstOrFail()->increment('stock');

                $locked->update(['returned_at' => now()->toDateString()]);
            });
        } catch (BorrowingException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
