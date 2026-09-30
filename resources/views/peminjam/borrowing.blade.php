@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="card-panel">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
            <h4 class="panel-title mb-0">Riwayat Peminjaman</h4>
            <div class="chip-row ms-auto">
                <a href="{{ url('borrowings') }}" class="chip {{ request('status') ? '' : 'active' }}">Semua</a>
                <a href="{{ url('borrowings?status=borrowed') }}" class="chip {{ request('status') === 'borrowed' ? 'active' : '' }}">Sedang dipinjam</a>
                <a href="{{ url('borrowings?status=returned') }}" class="chip {{ request('status') === 'returned' ? 'active' : '' }}">Sudah dikembalikan</a>
            </div>
        </div>

        <div class="borrow-list">
            @isset($borrowings)
                @forelse ($borrowings as $borrowing)
                    <div class="borrow-card">
                        <div class="mini-cover tone-{{ ($borrowing->book->category_id ?? 0) % 6 }} {{ $borrowing->book?->image_url ? 'has-image' : '' }}" @if ($borrowing->book?->image_url) style="background-image: url('{{ $borrowing->book->image_url }}')" @endif>
                            <i class="ri-book-2-fill"></i>
                        </div>
                        <div class="borrow-info">
                            <h6 class="mb-0">{{ $borrowing->book->title ?? '-' }}</h6>
                            <small class="text-muted">{{ $borrowing->book->author ?? '-' }}</small>
                            <div class="borrow-dates">
                                <span><i class="ri-calendar-line"></i> Dipinjam {{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d/m/Y') }}</span>
                                <span><i class="ri-calendar-check-line"></i> {{ $borrowing->returned_at ? 'Dikembalikan ' . \Carbon\Carbon::parse($borrowing->returned_at)->format('d/m/Y') : 'Belum dikembalikan' }}</span>
                            </div>
                        </div>
                        <div class="borrow-actions">
                            @if ($borrowing->returned_at)
                                <span class="status-pill ok">Dikembalikan</span>
                            @else
                                <span class="status-pill warn">Dipinjam</span>
                                <form method="POST" action="{{ url('borrowings/' . $borrowing->id . '/return') }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-danger">Kembalikan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="ri-history-line"></i>
                        <p class="mb-0">Belum ada riwayat peminjaman.</p>
                    </div>
                @endforelse
            @endisset
        </div>

        @isset($borrowings)
            @include('partials.pagination', ['paginator' => $borrowings])
        @endisset
    </div>
@endsection
