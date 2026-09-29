@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-12">
                        <h2>Data <b>Peminjaman</b></h2>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ url('admin/borrowings') }}" class="row mb-3">
                <div class="col-md-4">
                    <span>Status:</span>
                    <select name="status" class="form-select" data-auto-submit>
                        <option value="">Semua</option>
                        <option value="borrowed" @selected(request('status') === 'borrowed')>Sedang dipinjam</option>
                        <option value="returned" @selected(request('status') === 'returned')>Sudah dikembalikan</option>
                    </select>
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($borrowings)
                        @forelse ($borrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowings->firstItem() + $loop->index }}</td>
                                <td>{{ $borrowing->user->name ?? '-' }}</td>
                                <td>{{ $borrowing->book->title ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d/m/Y') }}</td>
                                <td>{{ $borrowing->returned_at ? \Carbon\Carbon::parse($borrowing->returned_at)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if ($borrowing->returned_at)
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada transaksi peminjaman.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>

            @isset($borrowings)
                @include('partials.pagination', ['paginator' => $borrowings])
            @endisset
        </div>
    </div>
@endsection
