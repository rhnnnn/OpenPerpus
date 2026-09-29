<div class="mb-3">
    <label for="{{ $prefix }}-title" class="form-label">Judul</label>
    <input type="text" class="form-control" id="{{ $prefix }}-title" name="title" value="{{ old('title') }}" required>
</div>
<div class="mb-3">
    <label for="{{ $prefix }}-author" class="form-label">Penulis</label>
    <input type="text" class="form-control" id="{{ $prefix }}-author" name="author" value="{{ old('author') }}" required>
</div>
<div class="mb-3">
    <label for="{{ $prefix }}-category_id" class="form-label select-label">Kategori</label>
    <select name="category_id" id="{{ $prefix }}-category_id" class="form-select" required>
        @isset($categories)
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->category_name }}</option>
            @endforeach
        @endisset
    </select>
</div>
<div class="mb-3">
    <label for="{{ $prefix }}-stock" class="form-label">Stok</label>
    <input type="number" min="0" class="form-control" id="{{ $prefix }}-stock" name="stock" value="{{ old('stock', 0) }}" required>
</div>
