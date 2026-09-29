<x-partials.modal-add id="addCategoryModal" title="Tambah Kategori" :action="url('admin/categories')">
    @include('categories.fields', ['prefix' => 'add'])
</x-partials.modal-add>

<x-partials.modal-edit id="editCategoryModal" title="Edit Kategori">
    @include('categories.fields', ['prefix' => 'edit'])
</x-partials.modal-edit>
