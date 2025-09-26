<x-app-layout>
<div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-900 min-h-screen">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">Technician Dashboard</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Overview of repair tasks and progress.</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border-l-4 border-indigo-500 flex items-center space-x-4">
            <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">Total</div>
            <div>
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Total Tasks</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $summary['total'] }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border-l-4 border-yellow-500 flex items-center space-x-4">
            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">In Progress</div>
            <div>
                <h2 class="text-sm text-gray-500 dark:text-gray-400">In Progress</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $summary['in_progress'] }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 border-l-4 border-gray-500 flex items-center space-x-4">
            <div class="p-3 bg-gray-200 dark:bg-gray-700 rounded-lg">Pending</div>
            <div>
                <h2 class="text-sm text-gray-500 dark:text-gray-400">Pending</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $summary['pending'] }}</p>
            </div>
        </div>
    </div>

    {{-- Assigned Repair Tasks --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Assigned Repair Tasks</h2>

        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr class="text-left text-gray-600 dark:text-gray-300">
                        <th class="px-4 py-3">Report ID</th>
                        <th class="px-4 py-3">Equipment</th>
                        <th class="px-4 py-3">Classroom</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Reported By</th>
                        <th class="px-4 py-3">Evidence</th>
                        <th class="px-4 py-3">Last Updated</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($tasks as $task)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-3">{{ $task->id }}</td>
                            <td class="px-4 py-3">{{ $task->equipment->name }}</td>
                            <td class="px-4 py-3">{{ $task->equipment->classroom->name }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('technician.updateStatus', $task->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()"
                                            class="px-2 py-1 rounded text-white text-sm
                                            {{ $task->status == 'pending' ? 'bg-gray-500' : ($task->status == 'in_progress' ? 'bg-yellow-500' : 'bg-green-500') }}">
                                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3">{{ $task->reporter->name }}</td>
                            <td class="px-4 py-3">
                                @if($task->evidence)
                                    <button onclick="openModal({{ $task->id }})"
                                            class="px-2 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                        View
                                    </button>
                                @else
                                    <span class="text-gray-400 text-sm">No evidence</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $task->updated_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Evidence Modal --}}
<div id="evidence-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg max-w-lg w-full p-6 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Evidence</h2>
        <div id="evidence-content" class="flex justify-center">
            <!-- Image or file will load here -->
        </div>
    </div>
</div>

<script>
    function openModal(taskId) {
        const modal = document.getElementById('evidence-modal');
        const content = document.getElementById('evidence-content');

        const evidenceData = @json($tasks->keyBy('id')->map(fn($t) => $t->evidence));

        if(evidenceData[taskId]) {
            const ext = evidenceData[taskId].split('.').pop().toLowerCase();
            if(['jpg','jpeg','png','gif','webp'].includes(ext)) {
                content.innerHTML = `<img src="/storage/${evidenceData[taskId]}" class="max-h-96 object-contain" alt="Evidence">`;
            } else {
                content.innerHTML = `<a href="/storage/${evidenceData[taskId]}" target="_blank" class="text-blue-500 underline">Download Evidence</a>`;
            }
        } else {
            content.innerHTML = '<span class="text-gray-500">No evidence available</span>';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('evidence-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

</x-app-layout>
