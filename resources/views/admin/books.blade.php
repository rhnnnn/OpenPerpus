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
    <x-partials.modal-add id="addBookModal" title="Tambah Buku" :action="url('admin/books')">
        <div class="mb-3">
            <label for="add-title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="add-title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="add-author" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="add-author" name="author" value="{{ old('author') }}" required>
        </div>
        <div class="mb-3">
            <label for="add-category_id" class="form-label select-label">Kategori</label>
            <select name="category_id" id="add-category_id" class="form-select" required>
                @isset($categories)
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->category_name }}</option>
                    @endforeach
                @endisset
            </select>
        </div>
        <div class="mb-3">
            <label for="add-stock" class="form-label">Stok</label>
            <input type="number" min="0" class="form-control" id="add-stock" name="stock" value="{{ old('stock', 0) }}" required>
        </div>
    </x-partials.modal-add>

    <x-partials.modal-edit id="editBookModal" title="Edit Buku">
        <div class="mb-3">
            <label for="edit-title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="edit-title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="edit-author" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="edit-author" name="author" value="{{ old('author') }}" required>
        </div>
        <div class="mb-3">
            <label for="edit-category_id" class="form-label select-label">Kategori</label>
            <select name="category_id" id="edit-category_id" class="form-select" required>
                @isset($categories)
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->category_name }}</option>
                    @endforeach
                @endisset
            </select>
        </div>
        <div class="mb-3">
            <label for="edit-stock" class="form-label">Stok</label>
            <input type="number" min="0" class="form-control" id="edit-stock" name="stock" value="{{ old('stock', 0) }}" required>
        </div>
    </x-partials.modal-edit>

    <x-partials.modal-delete id="deleteBookModal" title="Hapus Buku" message="Riwayat peminjaman buku ini juga akan terhapus. Lanjutkan?" />
@endsection
