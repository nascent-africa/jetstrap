<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="col">
                {{ $logo ?? '' }}
            </div>

            <div class="card mx-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
