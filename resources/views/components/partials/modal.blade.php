@props([
    'id',
    'title',
    'action' => '',
    'method' => 'POST',
    'fill' => false,
    'submitLabel' => 'Simpan',
    'submitClass' => 'btn-success',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true" @if ($fill) data-fill-form @endif>
    <div class="modal-dialog">
        <div class="modal-content text-white">
            <form method="POST" action="{{ $action }}">
                @csrf
                @if (! in_array(strtoupper($method), ['GET', 'POST']))
                    @method($method)
                @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn {{ $submitClass }}">{{ $submitLabel }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
