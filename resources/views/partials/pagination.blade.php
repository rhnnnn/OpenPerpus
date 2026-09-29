<div class="clearfix">
    <div class="hint-text">
        Menampilkan <b>{{ $paginator->firstItem() ?? 0 }}</b> sampai <b>{{ $paginator->lastItem() ?? 0 }}</b> dari <b>{{ $paginator->total() }}</b> data
    </div>
    <div class="float-end">
        {{ $paginator->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
