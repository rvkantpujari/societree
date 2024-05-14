<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Personal Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Information such as name, email address etc.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form wire:submit.prevent="save" class="mt-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-2 space-y-4 md:space-y-0 md:space-x-10">
            <div class="col-span-4 space-y-4">
                <div class="grid grid-cols-6 space-y-4 md:space-y-0 md:space-x-3">
                    <div class="col-span-full md:col-span-2">
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input 
                            type="text" 
                            id="first_name" 
                            name="first_name" 
                            class="mt-1 block w-full" 
                            autocomplete="given-name" 
                            autofocus 
                            wire:model="form.first_name" 
                            wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.first_name')" />
                    </div>
        
                    <div class="col-span-full md:col-span-2">
                        <x-input-label for="middle_name" :value="__('Middle Name')" />
                        <x-text-input 
                            type="text" 
                            id="middle_name" 
                            name="middle_name" 
                            class="mt-1 block w-full" 
                            autocomplete="additional-name" 
                            wire:model="form.middle_name" 
                            wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.middle_name')" />
                    </div>
        
                    <div class="col-span-full md:col-span-2">
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input 
                            type="text" 
                            id="last_name" 
                            name="last_name" 
                            class="mt-1 block w-full" 
                            autocomplete="family-name" 
                            wire:model="form.last_name" 
                            wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.last_name')" />
                    </div>
                </div>

                <div class="grid grid-cols-6 space-y-4 md:space-y-0 md:space-x-3">
                    <div class="col-span-full md:col-span-3">
                        <x-input-label for="dob" :value="__('Date of Birth')" />
                        <x-text-input 
                            type="date" 
                            id="dob" 
                            name="dob" 
                            class="mt-1 block w-full" 
                            autocomplete="dob" 
                            wire:model="form.dob" 
                            wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('form.dob')" />
                    </div>

                    <div class="col-span-full md:col-span-3">
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input 
                            id="phone" 
                            name="phone" 
                            class="mt-1 block w-full"
                            wire:model="form.phone" />
                        <x-input-error class="mt-2" :messages="$errors->get('form.phone')" />
                    </div>
                </div>
            </div>

            <div class="col-span-2">
                <x-input-label for="profile_image" :value="__('Profile Image')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button wire:click.prevent="save">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
