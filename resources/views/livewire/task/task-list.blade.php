<div class="flex items-center justify-center h-screen">
    <div class="w-4/5">
        <x-card title="Tasks List">
            <ul class="flex mb-4">
                <li class="mr-1">
                    <button class="px-4 py-2 bg-gray-300 rounded-t-lg {{ $activeTab === 'today' ? 'bg-gray-400' : '' }}" wire:click="$set('activeTab', 'today')">Today</button>
                </li>
                <li class="mr-1">
                    <button class="px-4 py-2 bg-gray-300 rounded-t-lg {{ $activeTab === 'tomorrow' ? 'bg-gray-400' : '' }}" wire:click="$set('activeTab', 'tomorrow')">Tomorrow</button>
                </li>
                <li class="mr-1">
                    <button class="px-4 py-2 bg-gray-300 rounded-t-lg {{ $activeTab === 'nextWeek' ? 'bg-gray-400' : '' }}" wire:click="$set('activeTab', 'nextWeek')">Next Week</button>
                </li>
                <li class="mr-1">
                    <button class="px-4 py-2 bg-gray-300 rounded-t-lg {{ $activeTab === 'nearFuture' ? 'bg-gray-400' : '' }}" wire:click="$set('activeTab', 'nearFuture')">Near Future</button>
                </li>
                <li>
                    <button class="px-4 py-2 bg-gray-300 rounded-t-lg {{ $activeTab === 'future' ? 'bg-gray-400' : '' }}" wire:click="$set('activeTab', 'future')">Future</button>
                </li>
            </ul>

            <table class="w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">ID
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Group
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Title
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Description
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Actions</th>
                        <!-- Added Actions column -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    @include('livewire.task.taskRow',['task'=>$task])
                    @endforeach
                </tbody>
            </table>
        </x-card>
    </div>
</div>