@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-6">
                        <h2>Data <b>Kategori</b></h2>
                    </div>
                    <div class="col-6">
                        <a href="#addCategoryModal" class="btn btn-success" data-bs-toggle="modal">Tambah Kategori</a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($categories)
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $loop->index }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ $category->books_count ?? 0 }}</td>
                                <td>
                                    <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                        data-action="{{ url('admin/categories/' . $category->id) }}"
                                        data-category_name="{{ $category->category_name }}">
                                        <i class="ri-pencil-line" title="Edit"></i>
                                    </a>
                                    <a href="#" class="delete" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal"
                                        data-action="{{ url('admin/categories/' . $category->id) }}">
                                        <i class="ri-delete-bin-line" title="Hapus"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>

            @isset($categories)
                @include('partials.pagination', ['paginator' => $categories])
            @endisset
        </div>
    </div>
@endsection

@section('modals')
    @include('categories.modals')
    <x-partials.modal-delete id="deleteCategoryModal" title="Hapus Kategori" message="Menghapus kategori juga akan menghapus semua buku di dalamnya. Lanjutkan?" />
@endsection
