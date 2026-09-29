<x-partials.modal-add id="addBookModal" title="Tambah Buku" :action="url('admin/books')">
    @include('books.fields', ['prefix' => 'add'])
</x-partials.modal-add>

<x-partials.modal-edit id="editBookModal" title="Edit Buku">
    @include('books.fields', ['prefix' => 'edit'])
</x-partials.modal-edit>
