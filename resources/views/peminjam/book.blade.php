@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
    <div class="row g-4">
        <div class="col-xl-9">
            <div class="card-panel">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    <h4 class="panel-title mb-0">Katalog Buku</h4>
                    <form id="book-search-form" method="GET" action="{{ url('books') }}" class="search-box ms-auto">
                        <i class="ri-search-line"></i>
                        <input type="search" id="book-search" name="search" value="{{ request('search') }}" placeholder="Cari judul atau penulis" autocomplete="off">
                        <input type="hidden" id="book-category" name="category_id" value="{{ request('category_id') }}">
                    </form>
                </div>

                <div class="chip-row mb-4" id="category-chips">
                    <button type="button" class="chip {{ request('category_id') ? '' : 'active' }}" data-category="">Semua</button>
                    @isset($categories)
                        @foreach ($categories as $category)
                            <button type="button" class="chip {{ request('category_id') == $category->id ? 'active' : '' }}" data-category="{{ $category->id }}">{{ $category->category_name }}</button>
                        @endforeach
                    @endisset
                </div>

                <div id="book-grid" data-url="{{ url('books') }}">
                    @fragment('grid')
                        @isset($books)
                            <div class="book-grid">
                                @forelse ($books as $book)
                                    <article class="book-card" tabindex="0"
                                        data-title="{{ $book->title }}"
                                        data-author="{{ $book->author }}"
                                        data-category="{{ $book->category->category_name ?? '-' }}"
                                        data-stock="{{ $book->stock }}"
                                        data-tone="{{ $book->category_id % 6 }}"
                                        data-image="{{ $book->image_url }}"
                                        data-borrow-action="{{ url('books/' . $book->id . '/borrow') }}"
                                        data-show-url="{{ url('books/' . $book->id) }}">
                                        <div class="book-cover tone-{{ $book->category_id % 6 }} {{ $book->image_url ? 'has-image' : '' }}" @if ($book->image_url) style="background-image: url('{{ $book->image_url }}')" @endif>
                                            <span class="book-cover-category">{{ $book->category->category_name ?? '-' }}</span>
                                            <span class="book-cover-title">{{ $book->title }}</span>
                                            <span class="stock-tag {{ $book->stock > 0 ? 'in' : 'out' }}">{{ $book->stock > 0 ? 'Stok ' . $book->stock : 'Habis' }}</span>
                                        </div>
                                        <div class="book-meta">
                                            <small>{{ $book->author }}</small>
                                        </div>
                                    </article>
                                @empty
                                    <div class="empty-state">
                                        <i class="ri-book-2-line"></i>
                                        <p class="mb-0">Tidak ada buku yang cocok.</p>
                                    </div>
                                @endforelse
                            </div>

                            @if ($books->hasPages())
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $books->withQueryString()->links('pagination::bootstrap-4') }}
                                </div>
                            @endif
                        @endisset
                    @endfragment
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <aside class="detail-panel">
                <div id="panel-empty" class="text-center">
                    <i class="ri-book-read-line panel-empty-icon"></i>
                    <p class="mb-0">Pilih salah satu buku untuk melihat detailnya.</p>
                </div>

                <div id="panel-content" hidden>
                    <div id="panel-cover" class="panel-cover tone-0">
                        <span id="panel-cover-title"></span>
                    </div>
                    <h5 id="panel-title" class="text-center mt-4 mb-1"></h5>
                    <p id="panel-author" class="text-center panel-muted mb-3"></p>

                    <div class="panel-stats">
                        <div>
                            <strong id="panel-category">-</strong>
                            <small>Kategori</small>
                        </div>
                        <div>
                            <strong id="panel-stock">-</strong>
                            <small>Ketersediaan</small>
                        </div>
                    </div>

                    <form id="borrow-form" method="POST" action="">
                        @csrf
                        <button type="submit" id="borrow-btn" class="btn btn-light w-100 fw-bold">
                            <i class="ri-book-open-line me-1"></i> Pinjam Buku
                        </button>
                    </form>
                    <a id="panel-show-link" href="#" class="panel-link">Lihat detail lengkap</a>
                </div>
            </aside>
        </div>
    </div>
@endsection