<div class="flex items-center justify-center h-screen">
    <div class="w-4/5">
        <x-card title="Tasks List">
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
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-300">{{$task['id']}}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{$task['group']['name']}}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{$task['title']}}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{$task['description']}}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            @if($task['completed'])
                            <x-button icon="check" primary label="Mark Incomplete" wire:click="markIncomplete({{$task['id']}})" />
                            @else
                            <x-button icon="check" secondary label="Mark Completed" wire:click="markComplete({{$task['id']}})" />
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>
    </div>
</div>
