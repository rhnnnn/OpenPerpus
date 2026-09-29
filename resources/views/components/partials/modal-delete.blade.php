@props(['id', 'title', 'message' => 'Yakin ingin menghapus data ini?'])

<x-partials.modal
    :id="$id"
    :title="$title"
    method="DELETE"
    :fill="true"
    submit-label="Hapus"
    submit-class="btn-danger">
    <p>{{ $message }}</p>
    <p class="text-warning"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
</x-partials.modal>
