<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Account Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Information such as your email and password.') }}
        </p>
    </header>

    <form wire:submit.prevent="save" class="mt-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-2 space-y-4 md:space-y-0 md:space-x-10">
            <div class="col-span-4 space-y-4">
                <div class="grid grid-cols-6 space-y-4 md:space-y-0 md:space-x-3">
                    <div class="col-span-full">
                        <div class="flex">
                            <x-input-label for="email" :value="__('Email')" />
                        </div>
                        <x-text-input 
                            type="text" 
                            id="email" 
                            name="email" 
                            class="mt-1 block w-full" 
                            autocomplete="email" 
                            autofocus 
                            wire:model="form.email" 
                            wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.email')" />
                    </div>
                </div>

                <div class="grid grid-cols-6 space-y-4 md:space-y-0 md:space-x-3">
                    <div class="col-span-full md:col-span-3">
                        <x-input-label for="password" :value="__('New Password')" />
                        <x-text-input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="mt-1 block w-full" 
                            autocomplete="new-password" 
                            wire:model="form.password" 
                            wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.password')" />
                    </div>

                    <div class="col-span-full md:col-span-3">
                        <x-input-label for="confirm_password" :value="__('Confirm Password')" />
                        <x-text-input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="mt-1 block w-full" 
                            autocomplete="new-password" 
                            wire:model="form.confirm_password" 
                            wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.confirm_password')" />
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <x-input-label for="photo_id_card" :value="__('Photo ID Card')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button wire:click.prevent="save">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'account-info-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif

            <div wire:dirty class="text-sm text-gray-600">Unsaved changes.</div> 
        </div>
    </form>
</section>
