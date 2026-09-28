@if (session('success'))
    <div class="alert alert-success" style="margin-bottom:1.5rem">
        <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" style="margin-bottom:1.5rem">
        <i class="ri-error-warning-line"></i> {{ session('error') }}
    </div>
@endif

@if ($errors->any() && !session('success'))
    <div class="alert alert-danger" style="margin-bottom:1.5rem">
        <i class="ri-error-warning-line"></i> {{ $errors->first() }}
    </div>
@endif
