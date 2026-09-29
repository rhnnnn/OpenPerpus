@props(['id', 'title', 'action'])

<x-partials.modal :id="$id" :title="$title" :action="$action">
    {{ $slot }}
</x-partials.modal>
