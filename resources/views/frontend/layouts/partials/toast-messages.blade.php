<div class="toast-container">
    @if(session()->has('error'))
        <div class="toast-message toast-error" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="toast-message toast-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
</div> 