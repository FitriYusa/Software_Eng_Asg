<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Equipment Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #f8fafc;
        }
        .equipment-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .equipment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-left-color: #4f46e5;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
        }
        .status-operational {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-faulty {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-maintenance {
            background-color: #fef3c7;
            color: #92400e;
        }
        .modal {
            transition: opacity 0.3s ease;
        }
        .modal-content {
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        .modal-open .modal-content {
            transform: scale(1);
        }
    </style>
</head>
<body class="bg-white text-black">
    <div x-data="dashboard()" class="min-h-screen">
        <!-- Header -->
    <header class="bg-gray-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-black">Registered Classroom Equipment</h1>
                    <p class="text-gray-600">Equipment management dashboard</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button @click="showNotificationPanel = !showNotificationPanel" class="relative p-2 text-gray-600 hover:text-indigo-600">
                        <i class="fas fa-bell text-xl"></i>
                        <span x-show="unreadNotifications > 0" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center" x-text="unreadNotifications"></span>
                    </button>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Sarah Johnson</p>
                            <p class="text-sm text-gray-500">sarah.johnson@complac.equ</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <!-- User Info Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-col md:flex-row md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Sarah Johnson</h2>
                        <p class="text-gray-600">sarah.johnson@complac.equ</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <h3 class="text-lg font-semibold text-gray-900">Location</h3>
                        <p class="text-gray-600">Department: FCI</p>
                        <p class="text-gray-600">Accepted Classroom</p>
                        <p class="text-gray-600">COUNTRY, COUNTRY, COUNTRY03</p>
                    </div>
                </div>
            </div>

            <!-- Report & Plan Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Report & Plan</h2>
                <hr class="mb-6">
                
                <!-- Equipment Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Equipment Card 1 -->
                    <div class="equipment-card bg-white border border-gray-200 rounded-lg p-4 cursor-pointer" 
                         @click="openReportModal('Projector 1')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900">Projector 1</h3>
                            <span class="status-badge status-operational">Operational</span>
                        </div>
                        <p class="text-gray-600 text-sm">Digital Projector</p>
                        <p class="text-gray-500 text-xs mt-1">Sportfleet</p>
                        <div class="mt-3 flex justify-between text-xs text-gray-500">
                            <span>Last maintenance: 15 Sep 2023</span>
                            <button class="text-indigo-600 hover:text-indigo-800">Report Issue</button>
                        </div>
                    </div>

                    <!-- Equipment Card 2 -->
                    <div class="equipment-card bg-white border border-gray-200 rounded-lg p-4 cursor-pointer" 
                         @click="openReportModal('AC Unit B102')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900">AC Unit B102</h3>
                            <span class="status-badge status-faulty">Faulty</span>
                        </div>
                        <p class="text-gray-600 text-sm">Air Conditioner</p>
                        <p class="text-gray-500 text-xs mt-1">Faulty</p>
                        <div class="mt-3 flex justify-between text-xs text-gray-500">
                            <span>Reported: 10 Oct 2023</span>
                            <button class="text-indigo-600 hover:text-indigo-800">View Status</button>
                        </div>
                    </div>

                    <!-- Equipment Card 3 -->
                    <div class="equipment-card bg-white border border-gray-200 rounded-lg p-4 cursor-pointer" 
                         @click="openReportModal('Speaker System C205')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900">Speaker System C205</h3>
                            <span class="status-badge status-operational">Operational</span>
                        </div>
                        <p class="text-gray-600 text-sm">Audit System</p>
                        <p class="text-gray-500 text-xs mt-1">Sportfleet</p>
                        <div class="mt-3 flex justify-between text-xs text-gray-500">
                            <span>Last maintenance: 20 Aug 2023</span>
                            <button class="text-indigo-600 hover:text-indigo-800">Report Issue</button>
                        </div>
                    </div>

                    <!-- Horizontal Separator -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 my-4">
                        <hr>
                    </div>

                    <!-- Equipment Card 4 -->
                    <div class="equipment-card bg-white border border-gray-200 rounded-lg p-4 cursor-pointer" 
                         @click="openReportModal('Interactive Whiteboard')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900">Interactive Whiteboard</h3>
                            <span class="status-badge status-maintenance">Maintenance</span>
                        </div>
                        <p class="text-gray-600 text-sm">Smart Board</p>
                        <p class="text-gray-500 text-xs mt-1">Meterwear</p>
                        <div class="mt-3 flex justify-between text-xs text-gray-500">
                            <span>Scheduled: 25 Oct 2023</span>
                            <button class="text-indigo-600 hover:text-indigo-800">View Details</button>
                        </div>
                    </div>

                    <!-- Equipment Card 5 -->
                    <div class="equipment-card bg-white border border-gray-200 rounded-lg p-4 cursor-pointer" 
                         @click="openReportModal('Computer Lab PC-05')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900">Computer Lab PC-05</h3>
                            <span class="status-badge status-operational">Operational</span>
                        </div>
                        <p class="text-gray-600 text-sm">Desktop Computer</p>
                        <p class="text-gray-500 text-xs mt-1">Sportfleet</p>
                        <div class="mt-3 flex justify-between text-xs text-gray-500">
                            <span>Last maintenance: 05 Oct 2023</span>
                            <button class="text-indigo-600 hover:text-indigo-800">Report Issue</button>
                        </div>
                    </div>

                    <!-- Equipment Card 6 -->
                    <div class="equipment-card bg-white border border-gray-200 rounded-lg p-4 cursor-pointer" 
                         @click="openReportModal('Monitor BI01-A')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900">Monitor BI01-A</h3>
                            <span class="status-badge status-operational">Operational</span>
                        </div>
                        <p class="text-gray-600 text-sm">Dialogy Monitor</p>
                        <p class="text-gray-500 text-xs mt-1">Sportfleet</p>
                        <div class="mt-3 flex justify-between text-xs text-gray-500">
                            <span>Last maintenance: 12 Sep 2023</span>
                            <button class="text-indigo-600 hover:text-indigo-800">Report Issue</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Report Issue Modal -->
        <div x-show="showReportModal" class="fixed inset-0 z-50 overflow-y-auto modal" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showReportModal = false"></div>
                
                <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl modal-content">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Report Equipment Issue</h3>
                        <button @click="showReportModal = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="mt-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Equipment</label>
                            <p class="mt-1 text-gray-900" x-text="selectedEquipment"></p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="issueType" class="block text-sm font-medium text-gray-700">Issue Type</label>
                            <select id="issueType" x-model="issueType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select issue type</option>
                                <option value="not_working">Not Working</option>
                                <option value="partially_working">Partially Working</option>
                                <option value="physical_damage">Physical Damage</option>
                                <option value="performance_issue">Performance Issue</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="issueDescription" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="issueDescription" x-model="issueDescription" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Please describe the issue in detail..."></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Urgency</label>
                            <div class="mt-2 flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="low" x-model="urgency" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2">Low</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="medium" x-model="urgency" class="text-indigo-600 focus:ring-indigo-500" checked>
                                    <span class="ml-2">Medium</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="urgency" value="high" x-model="urgency" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2">High</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <button @click="showReportModal = false" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button @click="submitReport()" type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Panel -->
        <div x-show="showNotificationPanel" x-transition class="fixed right-0 top-0 h-full w-80 bg-white shadow-lg z-40">
            <div class="p-4 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Notifications</h3>
                    <button @click="showNotificationPanel = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    <template x-for="notification in notifications" :key="notification.id">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between">
                                <span class="font-medium" x-text="notification.title"></span>
                                <span class="text-xs text-gray-500" x-text="notification.time"></span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Success Toast -->
        <div x-show="showSuccessToast" x-transition class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span x-text="successMessage"></span>
            </div>
        </div>
    </div>

    <script>
        function dashboard() {
            return {
                showReportModal: false,
                showNotificationPanel: false,
                showSuccessToast: false,
                selectedEquipment: '',
                issueType: '',
                issueDescription: '',
                urgency: 'medium',
                unreadNotifications: 2,
                successMessage: '',
                notifications: [
                    {
                        id: 1,
                        title: 'Maintenance Scheduled',
                        message: 'Interactive Whiteboard maintenance scheduled for Oct 25',
                        time: '2 hours ago',
                        read: false
                    },
                    {
                        id: 2,
                        title: 'Issue Reported',
                        message: 'Your report for AC Unit B102 has been received',
                        time: '1 day ago',
                        read: false
                    },
                    {
                        id: 3,
                        title: 'Issue Resolved',
                        message: 'Projector 2 has been repaired and is operational',
                        time: '3 days ago',
                        read: true
                    }
                ],
                openReportModal(equipment) {
                    this.selectedEquipment = equipment;
                    this.showReportModal = true;
                },
                submitReport() {
                    // In a real application, this would send data to the server
                    console.log('Submitting report:', {
                        equipment: this.selectedEquipment,
                        issueType: this.issueType,
                        description: this.issueDescription,
                        urgency: this.urgency
                    });
                    
                    this.showReportModal = false;
                    this.successMessage = `Issue reported for ${this.selectedEquipment}`;
                    this.showSuccessToast = true;
                    
                    // Reset form
                    this.issueType = '';
                    this.issueDescription = '';
                    this.urgency = 'medium';
                    
                    // Hide toast after 3 seconds
                    setTimeout(() => {
                        this.showSuccessToast = false;
                    }, 3000);
                }
            }
        }
    </script>
</body>
</html>