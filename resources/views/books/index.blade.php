@extends('layouts.app')

@section('title', 'Buku')

@section('content')
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-6">
                        <h2>Data <b>Buku</b></h2>
                    </div>
                    <div class="col-6">
                        <a href="#addBookModal" class="btn btn-success" data-bs-toggle="modal">Tambah Buku</a>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ url('admin/books') }}" class="row mb-3">
                <div class="col-md-4">
                    <span>Kategori:</span>
                    <select name="category_id" class="form-select" data-auto-submit>
                        <option value="">Semua Kategori</option>
                        @isset($categories)
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->category_name }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <span>Cari:</span>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Judul atau penulis">
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($books)
                        @forelse ($books as $book)
                            <tr>
                                <td>{{ $books->firstItem() + $loop->index }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->category->category_name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">{{ $book->stock }}</span>
                                </td>
                                <td>
                                    <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editBookModal"
                                        data-action="{{ url('admin/books/' . $book->id) }}"
                                        data-title="{{ $book->title }}"
                                        data-author="{{ $book->author }}"
                                        data-category_id="{{ $book->category_id }}"
                                        data-stock="{{ $book->stock }}">
                                        <i class="ri-pencil-line" title="Edit"></i>
                                    </a>
                                    <a href="#" class="delete" data-bs-toggle="modal" data-bs-target="#deleteBookModal"
                                        data-action="{{ url('admin/books/' . $book->id) }}">
                                        <i class="ri-delete-bin-line" title="Hapus"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada buku.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>

            @isset($books)
                @include('partials.pagination', ['paginator' => $books])
            @endisset
        </div>
    </div>
@endsection

@section('modals')
    @include('books.modals')
    <x-partials.modal-delete id="deleteBookModal" title="Hapus Buku" message="Riwayat peminjaman buku ini juga akan terhapus. Lanjutkan?" />
@endsection
