<x-app-layout>
    <div class="p-6 space-y-8 bg-white min-h-screen text-black">
        <!-- Page Title -->
    <h2 class="text-2xl font-bold text-black">Admin Dashboard</h2>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-100 shadow rounded-lg p-6">
                <p class="text-sm text-gray-600">Total Faults</p>
                <h3 class="text-3xl font-bold text-indigo-600">
                    {{ $summary['total'] ?? 0 }}
                </h3>
                <p class="text-xs text-gray-400">Currently under your responsibility</p>
            </div>

            <div class="bg-gray-100 shadow rounded-lg p-6">
                <p class="text-sm text-gray-600">Average Completion Time</p>
                <h3 class="text-3xl font-bold text-green-600">
                    {{ $averageCompletionDays }} Days
                </h3>
                <p class="text-xs text-gray-400">Based on last 30 days</p>
            </div>

            <div class="bg-gray-100 shadow rounded-lg p-6">
                <p class="text-sm text-gray-600">Completed Repairs</p>
                <h3 class="text-3xl font-bold text-red-600">
                    {{ $summary['completed'] ?? 0 }}
                </h3>
                <p class="text-xs text-gray-400">Successfully resolved</p>
            </div>
        </div>

        <!-- Fault Trends -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-100 shadow rounded-lg p-6">
                <h4 class="text-lg font-semibold text-black mb-4">Monthly Faults</h4>
                <canvas id="monthlyFaults"></canvas>
            </div>
            <div class="bg-gray-100 shadow rounded-lg p-6">
                <h4 class="text-lg font-semibold text-black mb-4">Weekly Workload</h4>
                <canvas id="weeklyFaults"></canvas>
            </div>
        </div>

        <!-- Detailed Analysis -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-100 shadow rounded-lg p-6">
                <h4 class="text-lg font-semibold text-black mb-4">Repair Time Distribution</h4>
                <canvas id="repairTime"></canvas>
            </div>
            <div class="bg-gray-100 shadow rounded-lg p-6">
                <h4 class="text-lg font-semibold text-black mb-4">Faults by Equipment</h4>
                <canvas id="faultsByType"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Faults Line Chart
        new Chart(document.getElementById('monthlyFaults'), {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'Faults',
                    data: @json($monthlyCounts),
                    borderColor: '#4f46e5',
                    fill: false,
                    tension: 0.3
                }]
            }
        });


        // Weekly Workload Bar Chart
        fetch('/api/weekly-faults')
            .then(response => response.json())
            .then(data => {
                const days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                const faults = new Array(7).fill(0);

                data.forEach(d => {
                    // Map MySQL DAYOFWEEK (1=Sun, 2=Mon, ...) to Monday-first index
                    const chartIndex = (d.day + 5) % 7;
                    faults[chartIndex] = d.total;
                });

                new Chart(document.getElementById('weeklyFaults'), {
                    type: 'bar',
                    data: {
                        labels: days,
                        datasets: [{
                            label: 'Faults',
                            data: faults,
                            backgroundColor: '#f59e0b'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false }, tooltip: { enabled: true } },
                        scales: {
                            y: { beginAtZero: true, title: { display: true, text: 'Number of Faults' } },
                            x: { title: { display: true, text: 'Day of Week' } }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching weekly faults:', error));


        // Repair Time Distribution
        new Chart(document.getElementById('repairTime'), {
            type: 'bar',
            data: {
                labels: ['<1 Day', '1-3 Days', '3-7 Days', '>7 Days'],
                datasets: [{
                    label: 'Cases',
                    data: [
                        {{ $repairTimeDistribution[0] }},
                        {{ $repairTimeDistribution[1] }},
                        {{ $repairTimeDistribution[2] }},
                        {{ $repairTimeDistribution[3] }}
                    ],
                    backgroundColor: '#10b981'
                }]
            }
        });


        // Faults by Equipment Pie Chart
        const equipmentTypes = @json($equipmentTypes);
        const faultCounts = @json($faultCounts);

        new Chart(document.getElementById('faultsByType'), {
            type: 'doughnut',
            data: {
                labels: equipmentTypes,
                datasets: [{
                    data: faultCounts,
                    backgroundColor: ['#ffffffff', '#f59e0b', '#ef4444', '#10b981'] // add more colors if needed
                }]
            }
        });
    </script>
</x-app-layout>

    <body class="bg-white">
