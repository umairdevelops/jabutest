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