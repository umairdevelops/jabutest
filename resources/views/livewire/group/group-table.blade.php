<div class=" flex items-center justify-center h-screen">
    <div class="w-1/2">
        <x-card title="Task Groups" >
            <table class="w-full bg-white">
                <thead>
                  <tr>
                    <th class="py-3 px-4  border-b border-gray-300 font-semibold text-left rounded-t-lg">Group Name</th>
                    <th class="py-3 px-4  border-b border-gray-300 font-semibold text-left rounded-t-lg">Description</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($taskGroups as $taskGroup)
                    <tr>
                        <td>{{ $taskGroup->name }}</td>
                        <td>{{ $taskGroup->description }}</td>
                    <hr>
                @endforeach
                </tbody>
              </table>
        </x-card>
    </div>
</div>

  