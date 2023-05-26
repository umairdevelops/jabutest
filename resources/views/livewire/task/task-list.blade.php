<div class="flex items-center justify-center h-screen">
    <div class="w-4/5">
        <x-card title="Tasks List">
            <table class="w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Group Name
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Description
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Description
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Description
                        </th>
                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-left rounded-t-lg">Actions</th>
                        <!-- Added Actions column -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-300">John Doe</td>
                        <td class="py-2 px-4 border-b border-gray-300">25</td>
                        <td class="py-2 px-4 border-b border-gray-300">25</td>
                        <td class="py-2 px-4 border-b border-gray-300">25</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <x-button icon="pencil" primary label="Primary" />
                            <x-button icon="clipboard-list" secondary label="Secondary" />
                        </td> <!-- Added Edit and Delete buttons with color classes -->
                    </tr>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-300">Jane Smith</td>
                        <td class="py-2 px-4 border-b border-gray-300">30</td>
                        <td class="py-2 px-4 border-b border-gray-300">30</td>
                        <td class="py-2 px-4 border-b border-gray-300">30</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <x-button icon="pencil" primary label="Primary" />
                            <x-button icon="clipboard-list" secondary label="Secondary" />
                        </td> <!-- Added Edit and Delete buttons with color classes -->
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </x-card>
    </div>
</div>