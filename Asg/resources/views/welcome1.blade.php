<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Equipment Fault Reporting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-indigo-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <a href="{{ route('welcome1') }}" class="flex items-center">
                    <i class="fas fa-tools text-2xl mr-2"></i>
                    <span class="font-bold text-xl">EduFix</span>
                </a>
                <div class="flex items-center space-x-4">
                    {{-- <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded">Home</a>
                    <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded">Report Fault</a>
                    <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded">Status</a> --}}
                    <a href="{{ route('login') }}" class="bg-indigo-800 px-4 py-2 rounded hover:bg-indigo-900">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Classroom Equipment Fault Reporting System</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Quickly report equipment issues in your classroom and track repair status in real-time.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('dashboard') }}">
                    <button class="bg-white text-indigo-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Report a Fault <i class="ml-2 fas fa-arrow-right"></i>
                    </button>
                </a>

                <button class="bg-transparent border-2 border-white px-6 py-3 rounded-lg font-semibold hover:bg-white/10 transition duration-300">
                    Check Status <i class="ml-2 fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-lg bg-gray-50 hover:shadow-md transition duration-300">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-edit text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">1. Report Issue</h3>
                    <p class="text-gray-600">Fill out a simple form to report equipment faults with details and photos.</p>
                </div>
                <div class="text-center p-6 rounded-lg bg-gray-50 hover:shadow-md transition duration-300">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tasks text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">2. Track Status</h3>
                    <p class="text-gray-600">Monitor the repair progress with real-time status updates.</p>
                </div>
                <div class="text-center p-6 rounded-lg bg-gray-50 hover:shadow-md transition duration-300">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">3. Issue Resolved</h3>
                    <p class="text-gray-600">Get notified when the equipment is fixed and ready for use.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">EduFix</h3>
                    <p class="text-gray-400">Streamlining classroom equipment maintenance for better learning experiences.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Home</a></li>
                        <li><a href="#" class="hover:text-white">Report Fault</a></li>
                        <li><a href="#" class="hover:text-white">Check Status</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i> support@edufix.edu</li>
                        <li><i class="fas fa-phone mr-2"></i> (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Education Building, Room 101</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Subscribe</h4>
                    <p class="text-gray-400 mb-2">Get updates on system maintenance</p>
                    <div class="flex">
                        <input type="email" placeholder="Your email" class="flex-grow p-2 rounded-l text-gray-800">
                        <button class="bg-indigo-600 px-4 rounded-r hover:bg-indigo-700">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 EduFix Classroom Equipment Fault System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function faultReport() {
            return {
                step: 1,
                equipmentList: [
                    { id: 1, name: 'Projector', icon: 'fas fa-video' },
                    { id: 2, name: 'Computer', icon: 'fas fa-desktop' },
                    { id: 3, name: 'Printer', icon: 'fas fa-print' },
                    { id: 4, name: 'Smart Board', icon: 'fas fa-chalkboard' },
                    { id: 5, name: 'Sound System', icon: 'fas fa-volume-up' },
                    { id: 6, name: 'Other', icon: 'fas fa-cogs' }
                ],
                selectedEquipment: null,
                problemType: '',
                description: '',
                location: '',
                urgency: 'medium',
                referenceId: '',
                
                selectEquipment(equipment) {
                    this.selectedEquipment = equipment;
                },
                
                submitReport() {
                    // In a real app, this would send data to the server
                    // For demo, we'll just generate a reference ID and show success
                    this.referenceId = 'EDUF-' + new Date().getFullYear() + '-' + 
                        Math.floor(1000 + Math.random() * 9000);
                    this.step = 4;
                },
                
                resetForm() {
                    this.step = 1;
                    this.selectedEquipment = null;
                    this.problemType = '';
                    this.description = '';
                    this.location = '';
                    this.urgency = 'medium';
                    this.referenceId = '';
                }
            }
        }
    </script>
</body>
</html>