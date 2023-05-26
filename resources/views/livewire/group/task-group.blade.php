<div class=" flex items-center justify-center h-screen">
    <div class="w-1/2">
        <x-card title="Create Task Group" >
            <x-errors class="mb-4" />
            <div class="col-span-1 sm:col-span-2 gap-6">
                <x-input label="Group Name" placeholder="Group Name" wire:model.defer="group.name" />
            </div>
            <div class="col-span-1 sm:col-span-2 gap-6 mt-3">
                <x-textarea label="Description" placeholder="Enter Description" wire:model.defer="group.description" />
            </div>
        
            <x-slot name="footer">
                <div class="flex items-center gap-x-3 justify-end">
                    <x-button wire:click="cancel" label="Cancel" flat />
                    <x-button wire:click="save" label="Save" spinner="save" primary />
                </div>
            </x-slot>
        </x-card>
    </div>
</div>
