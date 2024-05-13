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
        <div class="grid grid-cols-4 space-y-4 md:space-y-0 md:space-x-3">
            <div class="col-span-full md:col-span-1">
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

            <div class="col-span-full md:col-span-1">
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

            <div class="col-span-full md:col-span-1">
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

        <div>
            <div class="flex items-center gap-1">
                <x-input-label for="email" :value="__('Email')" />
                @if ($user->hasVerifiedEmail())
                    <span class="text-green-700" title="Email Verified">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.49991 0.877045C3.84222 0.877045 0.877075 3.84219 0.877075 7.49988C0.877075 11.1575 3.84222 14.1227 7.49991 14.1227C11.1576 14.1227 14.1227 11.1575 14.1227 7.49988C14.1227 3.84219 11.1576 0.877045 7.49991 0.877045ZM1.82708 7.49988C1.82708 4.36686 4.36689 1.82704 7.49991 1.82704C10.6329 1.82704 13.1727 4.36686 13.1727 7.49988C13.1727 10.6329 10.6329 13.1727 7.49991 13.1727C4.36689 13.1727 1.82708 10.6329 1.82708 7.49988ZM10.1589 5.53774C10.3178 5.31191 10.2636 5.00001 10.0378 4.84109C9.81194 4.68217 9.50004 4.73642 9.34112 4.96225L6.51977 8.97154L5.35681 7.78706C5.16334 7.59002 4.84677 7.58711 4.64973 7.78058C4.45268 7.97404 4.44978 8.29061 4.64325 8.48765L6.22658 10.1003C6.33054 10.2062 6.47617 10.2604 6.62407 10.2483C6.77197 10.2363 6.90686 10.1591 6.99226 10.0377L10.1589 5.53774Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </span>
                @else
                    <span class="text-red-700" title="Email Unverified">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.4449 0.608765C8.0183 -0.107015 6.9817 -0.107015 6.55509 0.608766L0.161178 11.3368C-0.275824 12.07 0.252503 13 1.10608 13H13.8939C14.7475 13 15.2758 12.07 14.8388 11.3368L8.4449 0.608765ZM7.4141 1.12073C7.45288 1.05566 7.54712 1.05566 7.5859 1.12073L13.9798 11.8488C14.0196 11.9154 13.9715 12 13.8939 12H1.10608C1.02849 12 0.980454 11.9154 1.02018 11.8488L7.4141 1.12073ZM6.8269 4.48611C6.81221 4.10423 7.11783 3.78663 7.5 3.78663C7.88217 3.78663 8.18778 4.10423 8.1731 4.48612L8.01921 8.48701C8.00848 8.766 7.7792 8.98664 7.5 8.98664C7.2208 8.98664 6.99151 8.766 6.98078 8.48701L6.8269 4.48611ZM8.24989 10.476C8.24989 10.8902 7.9141 11.226 7.49989 11.226C7.08567 11.226 6.74989 10.8902 6.74989 10.476C6.74989 10.0618 7.08567 9.72599 7.49989 9.72599C7.9141 9.72599 8.24989 10.0618 8.24989 10.476Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    </span>
                @endif
            </div>
            <x-text-input 
                type="text" 
                id="email" 
                name="email" 
                class="mt-1 block w-full" 
                autocomplete="email" 
                wire:model="form.email" 
                wire:dirty.class="border-red-500 focus:border-red-500 focus:ring-red-500"
            />
            <x-input-error class="mt-2" :messages="$errors->get('form.email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
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
