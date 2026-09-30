<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(Request $request): View
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->when($request->input('status') === 'borrowed', fn ($query) => $query->whereNull('returned_at'))
            ->when($request->input('status') === 'returned', fn ($query) => $query->whereNotNull('returned_at'))
            ->latest('borrowed_at')
            ->latest('id')
            ->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }
}
