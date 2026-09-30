@extends('layouts.app')

@section('title', $book->title ?? 'Detail Buku')

@section('content')
    @isset($book)
        <div class="card-panel p-0 overflow-hidden">
            <div class="detail-banner"></div>
            <div class="row g-4 detail-body">
                <div class="col-md-4">
                    <div class="detail-cover-wrap">
                        <div class="book-cover detail-cover tone-{{ $book->category_id % 6 }} {{ $book->image_url ? 'has-image' : '' }}" @if ($book->image_url) style="background-image: url('{{ $book->image_url }}')" @endif>
                            <span class="book-cover-category">{{ $book->category->category_name ?? '-' }}</span>
                            <span class="book-cover-title">{{ $book->title }}</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ url('books/' . $book->id . '/borrow') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 fw-bold" @disabled($book->stock < 1)>
                            <i class="ri-book-open-line me-1"></i> {{ $book->stock < 1 ? 'Stok Habis' : 'Pinjam Buku' }}
                        </button>
                    </form>
                    <a href="{{ url('books') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="ri-arrow-left-line me-1"></i> Kembali ke Katalog
                    </a>
                </div>

                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small">
                            <li class="breadcrumb-item"><a href="{{ url('books') }}">Katalog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Buku</li>
                        </ol>
                    </nav>

                    <div class="mb-3">
                        <span class="status-pill {{ $book->stock > 0 ? 'ok' : 'off' }}">{{ $book->stock > 0 ? 'Tersedia' : 'Sedang habis' }}</span>
                        <span class="status-pill neutral">{{ $book->category->category_name ?? '-' }}</span>
                    </div>

                    <h2 class="detail-title">{{ $book->title }}</h2>
                    <p class="detail-author">oleh {{ $book->author }}</p>

                    <h6 class="mt-4 mb-3 panel-title">Informasi</h6>
                    <dl class="info-list">
                        <dt>Penulis</dt>
                        <dd>{{ $book->author }}</dd>
                        <dt>Kategori</dt>
                        <dd>{{ $book->category->category_name ?? '-' }}</dd>
                        <dt>Stok</dt>
                        <dd>{{ $book->stock }} eksemplar</dd>
                        <dt>Ditambahkan</dt>
                        <dd>{{ \Carbon\Carbon::parse($book->created_at)->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    @endisset
@endsection
