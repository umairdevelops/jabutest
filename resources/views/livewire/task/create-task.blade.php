<div class=" flex items-center justify-center h-screen">
    <div class="w-4/5">
        <x-card title="Create Task">
            <x-errors class="mb-4" />
            <form wire:submit.prevent="create">
                <div class="grid grid-cols-12 gap-1">
                    <div class="col-span-6">
                        <x-input label="Title" wire:model.defer="title" placeholder="Enter title of task" />
                    </div>
                    <div class="col-span-6">
                        <x-textarea wire:model.defer="description" label="Description" placeholder="" class="h-10" />
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-1 mt-3">
                    <div class="col-span-6">
                        <x-select label="Repetetion type" placeholder="Select Repetetion Type" wire:model="repetetionType" :options="$repetetionTypeList" option-label="text" option-value="id" />
                    </div>

                    <div class="col-span-6 {{ $repetetionType == App\Enums\RepetetionTypeEnum::weekly->value ? 'block' : 'hidden' }}">
                        <x-select label="Days of week" placeholder="Select days of week" :options="$weekDaysList" wire:model='selectedDays' option-label="text" option-value="id" multiselect />
                    </div>

                    <div class="col-span-6 {{ $repetetionType == App\Enums\RepetetionTypeEnum::monthly->value ? 'block' : 'hidden' }}">
                        <x-select label="Date of month" placeholder="Select date of month" :options="$monthDaysList" wire:model='selectedDate' option-label="text" option-value="id" />
                    </div>

                    <div class="col-span-6 {{ $repetetionType == App\Enums\RepetetionTypeEnum::yearly->value ? 'block' : 'hidden' }}">
                        <x-select label="Month" placeholder="Select month" :options="$monthsList" wire:model='selectedMonth' option-label="text" option-value="id" />
                        <x-select label="Date" placeholder="Select date" :options="$monthDaysList" wire:model='selectedDate' option-label="text" option-value="id" />
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-1 mt-3">
                    <div class="col-span-12">
                        <label class="block text-gray-700 font-bold mb-2">
                            Task Type
                        </label>
                        <x-radio id="right-label" md label="Date A to B" value="{{App\Enums\TaskTypeEnum::dates->value}}" wire:model="taskType" />
                        <div class="h-2"></div>
                        <x-radio id="right-label" md label="Number of Iterations" value="{{App\Enums\TaskTypeEnum::repetetions->value}}" wire:model="taskType" />
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-1 mt-3">
                    <div class="col-span-6 {{ $taskType == App\Enums\TaskTypeEnum::dates->value ? 'block' : 'hidden' }}">
                        <div class="grid grid-cols-12 ">
                            <div class="col-span-6">
                                <x-datetime-picker label="Start Date" parse-format="DD-MM-YYYY" without-tips=true without-timezone=true without-time=true placeholder="Select start date" wire:model="startDate" class="w-full" />
                            </div>
                            <div class="col-span-6 ml-2">
                                <x-datetime-picker label="End Date" parse-format="DD-MM-YYYY" without-tips=true without-timezone=true without-time=true placeholder="Select end date" wire:model="endDate" class="w-full" />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6 {{ $taskType == App\Enums\TaskTypeEnum::repetetions->value ? 'block' : 'hidden' }}">
                        <x-inputs.number label="No of iterations" wire:model='noOfIterations' />
                    </div>
                    <div class="col-span-6">
                        <x-select label="Task Group" placeholder="Task group" wire:model="group" :options="$groupsList" option-label="name" option-value="id" />
                    </div>
                </div>
                <x-slot name="footer">
                    <div class="flex items-center gap-x-3 justify-end">
                        <x-button wire:click="cancel" label="Cancel" flat />
                        <x-button wire:click="save" label="Save" spinner="save" primary />
                    </div>
                </x-slot>
            </form>
        </x-card>
    </div>
</div>
