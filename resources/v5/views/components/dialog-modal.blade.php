@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ $title }}</h5>
            <!-- Modal close button is different in bootstrap 5 -->
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{ $content }}
        </div>
        <div class="modal-footer bg-light">
            {{ $footer }}
        </div>
    </div>
</x-jet-modal>
