<x-app-layout>
<div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-900 min-h-screen">

    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">Classroom Equipment Fault System</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mt-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Report Fault Form --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Report a Fault</h2>
        <form action="{{ route('report_fault.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Classroom --}}
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300">Classroom</label>
                <select id="classroom" name="classroom_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm">
                    <option value="">Select classroom</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">
                            {{ $classroom->building }} - Room {{ $classroom->roomNumber }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Equipment --}}
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300">Equipment</label>
                <select id="equipment" name="equipment_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm">
                    <option value="">Select equipment</option>
                    {{-- Options filled dynamically via JS --}}
                </select>
            </div>

            {{-- Description --}}
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" placeholder="Describe the issue..." required
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm"></textarea>
            </div>

            {{-- Evidence --}}
            <div>
                <label class="block font-medium text-gray-700 dark:text-gray-300">Upload Evidence</label>
                <input type="file" name="evidence[]" multiple
                       class="mt-1 block w-full text-gray-700 dark:text-gray-300">
            </div>

            {{-- Buttons --}}
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white font-semibold hover:bg-indigo-700">Submit Fault</button>
                <button type="reset" class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">Clear</button>
            </div>
        </form>
    </div>

    {{-- My Reported Faults --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">My Reported Faults</h2>

        @if($faults->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">You have not reported any faults yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr class="text-left text-gray-600 dark:text-gray-300">
                            <th class="px-4 py-2">Classroom</th>
                            <th class="px-4 py-2">Equipment</th>
                            <th class="px-4 py-2">Priority</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Reported At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($faults as $fault)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-2">{{ $fault->classroom->building }} - Room {{ $fault->classroom->roomNumber }}</td>
                                <td class="px-4 py-2">{{ $fault->equipment->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($fault->priority ?? 'N/A') }}</td>
                                <td class="px-4 py-2">{{ $fault->description }}</td>
                                <td class="px-4 py-2">
                                    <span class="font-semibold" style="color: 
                                        {{ $fault->status === 'resolved' ? 'green' : ($fault->status === 'in_progress' ? 'orange' : 'red') }}">
                                        {{ ucfirst($fault->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $fault->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $faults->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Dynamic equipment filtering --}}
<script>
    const allEquipments = @json($equipments);

    document.getElementById('classroom').addEventListener('change', function() {
        const classroomId = parseInt(this.value);
        const equipmentSelect = document.getElementById('equipment');

        equipmentSelect.innerHTML = '<option value="">Select equipment</option>';

        allEquipments
            .filter(eq => eq.classroom_id === classroomId)
            .forEach(eq => {
                const option = document.createElement('option');
                option.value = eq.id;
                option.text = eq.name + ' (SN: ' + eq.serialNumber + ')';
                equipmentSelect.add(option);
            });
    });
</script>

</x-app-layout>
