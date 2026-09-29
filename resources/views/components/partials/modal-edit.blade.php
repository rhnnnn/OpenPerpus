@props(['id', 'title'])

<x-partials.modal
    :id="$id"
    :title="$title"
    method="PUT"
    :fill="true"
    submit-label="Simpan Perubahan"
    submit-class="btn-primary">
    {{ $slot }}
</x-partials.modal>
