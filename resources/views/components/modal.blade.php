@props(['id', 'maxWidth', 'modal' => false])

@php
$id = $id ?? md5($attributes->wire('model'));

switch ($maxWidth ?? '') {
    case 'sm':
        $maxWidth = ' modal-sm';
        break;
    case 'md':
        $maxWidth = '';
        break;
    case 'lg':
        $maxWidth = ' modal-lg';
        break;
    case 'xl':
        $maxWidth = ' modal-xl';
        break;
    case '2xl':
    default:
        $maxWidth = '';
        break;
}
@endphp

<!-- Modal -->
<div 
    x-data="{
        show: @entangle($attributes->wire('model')).defer,
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="() => {
        let modal = $('#{{ $id }}');
        $watch('show', value => {
            if (value) {
                modal.modal('show')
                setTimeout(() => (focusables()[0]).focus(), 250);
            } else {
                modal.modal('hide')
            }
        });

        modal.on('hide.bs.modal', function () {
            show = false
        })
        
        modal.click(function(e) {
            if (e.target == this) {
                show = false;
            }
        });
    }"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    wire:ignore.self 
    class="modal fade" 
    id="{{ $id }}" 
    aria-labelledby="{{ $id }}" 
    aria-hidden="true"
    x-ref="{{ $id }}"
>
    <div class="modal-dialog{{ $maxWidth }}">
        {{ $slot }}
    </div>
</div>
