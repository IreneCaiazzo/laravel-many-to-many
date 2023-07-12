<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="current_password" class="form-label" value="Current Password">Current password</label>
        <input type="password" class="form-control" id="current_password" name="current_password">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label" value="New Password">New password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label" value="Confirm Password">Password Confirmation</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >Saved</p>
        @endif
    </div>
      


</form>