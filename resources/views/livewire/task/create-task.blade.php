<div class=" flex items-center justify-center h-screen">
    <div class="w-4/5">
        <x-card title="Create Task">
            <x-errors class="mb-4" />
            <form wire:submit.prevent="create">
                <div class="grid grid-cols-12 gap-1">
                    <div class="col-span-6">
                        <x-input label="Title" wire:model="title" placeholder="Enter title of task" />
                    </div>
                    <div class="col-span-6">
                        <x-textarea wire:model="description" label="Description" placeholder="" class="h-10" />
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-1 mt-3">
                    <div class="col-span-6">
                        <x-select label="Task type" placeholder="Select task type" wire:model="taskType"
                            :options="$frequencies" option-label="text" option-value="id" />
                    </div>
                    <div class="col-span-6 {{ $taskType == 'weekly' ? 'block' : 'hidden' }}">
                        <x-select label="Days of week" placeholder="Select days of week" :options="$daysofweek"
                            wire:model='selectedDays' option-label="text" option-value="id" multiselect />
                    </div>
                    <div class="col-span-6 {{ $taskType == 'monthly' ? 'block' : 'hidden' }}">
                        <x-select label="Date of month" placeholder="Select date of month" :options="$daysofMonth"
                            wire:model='selectedDate' option-label="text" option-value="id" />
                    </div>
                    <div class="col-span-6 {{ $taskType == 'yearly' ? 'block' : 'hidden' }}">
                        <x-datetime-picker label="Date of year" parse-format="DD-MM-YYYY" without-tips=true
                            without-timezone=true without-time=true placeholder="Select date of year"
                            wire:model="selectedMonth" />

                    </div>
                </div>
                <div class="grid grid-cols-12 gap-1 mt-3">
                    <div class="col-span-12">
                        <label class="block text-gray-700 font-bold mb-2">
                            Iteration type
                        </label>
                        <x-radio id="right-label" md label="Date A to B" value="dateRange" wire:model="iterationType" />
                        <div class="h-2"></div>
                        <x-radio id="right-label" md label="Number of Iterations" value="numIterations"
                            wire:model="iterationType" />
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-1 mt-3">
                    <div class="col-span-6 {{ $iterationType == 'dateRange' ? 'block' : 'hidden' }}">
                        <div class="grid grid-cols-12 ">
                            <div class="col-span-6">
                                <x-datetime-picker label="Start Date" parse-format="DD-MM-YYYY" without-tips=true
                                    without-timezone=true without-time=true placeholder="Select start date"
                                    wire:model="startDate" class="w-full" />
                            </div>
                            <div class="col-span-6 ml-2">
                                <x-datetime-picker label="End Date" parse-format="DD-MM-YYYY" without-tips=true
                                    without-timezone=true without-time=true placeholder="Select end date"
                                    wire:model="endDate" class="w-full" />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6 {{ $iterationType == 'numIterations' ? 'block' : 'hidden' }}">
                        <x-inputs.number label="No of iterations" wire:model='noOfIterations' />
                    </div>
                    <div class="col-span-6">
                        <x-select label="Task Group" placeholder="Task group" wire:model="task_group_id"
                            :options="$task_groups" option-label="name" option-value="id" />
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