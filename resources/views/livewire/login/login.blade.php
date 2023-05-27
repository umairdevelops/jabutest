<div class=" flex items-center justify-center h-screen">
    <div class="w-1/2">
        <x-card title="Enter your credentials below">
            <x-errors class="mb-4" />

            <div class="col-span-1 sm:col-span-2 gap-6">
                <x-input label="Email" wire:model.defer="email" />
            </div>

            <div class="col-span-1 sm:col-span-2 gap-6">
                <x-inputs.password label="Password" value="" wire:model.defer="password" />
            </div>

            <x-slot name="footer">
                <div class="flex items-center gap-x-3 justify-end">
                    <x-button wire:click="login" label="Sign in" spinner="Trying" primary />
                </div>
            </x-slot>
        </x-card>
    </div>
</div>
