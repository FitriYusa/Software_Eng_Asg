
    <!-- Interactive Demo Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Try It Now</h2>
            
            <div x-data="faultReport()" class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Report Equipment Fault</h3>
                    
                    <!-- Step 1: Equipment Selection -->
                    <div x-show="step === 1">
                        <p class="text-gray-600 mb-6">Select the equipment that needs repair:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <template x-for="equipment in equipmentList">
                                <button 
                                    @click="selectEquipment(equipment)"
                                    class="p-4 border rounded-lg text-left hover:bg-indigo-50 transition duration-200"
                                    :class="selectedEquipment === equipment ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200'">
                                    <i :class="equipment.icon" class="text-2xl mb-2 text-indigo-600"></i>
                                    <h4 class="font-medium" x-text="equipment.name"></h4>
                                </button>
                            </template>
                        </div>
                        
                        <div class="flex justify-between">
                            <div></div>
                            <button 
                                @click="step = 2" 
                                :disabled="!selectedEquipment"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg disabled:bg-gray-300 disabled:cursor-not-allowed">
                                Next <i class="ml-2 fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Problem Description -->
                    <div x-show="step === 2">
                        <p class="text-gray-600 mb-6">Describe the problem with <span x-text="selectedEquipment.name" class="font-medium"></span>:</p>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2">Problem Type</label>
                            <select x-model="problemType" class="w-full p-3 border border-gray-300 rounded-lg">
                                <option value="">Select problem type</option>
                                <option value="not_working">Not working at all</option>
                                <option value="partially_working">Partially working</option>
                                <option value="physical_damage">Physical damage</option>
                                <option value="software_issue">Software issue</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2">Description</label>
                            <textarea 
                                x-model="description" 
                                class="w-full p-3 border border-gray-300 rounded-lg" 
                                rows="4" 
                                placeholder="Please provide details about the issue..."></textarea>
                        </div>
                        
                        <div class="flex justify-between">
                            <button @click="step = 1" class="px-6 py-2 border border-gray-300 rounded-lg">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
                            <button 
                                @click="step = 3" 
                                :disabled="!problemType || !description"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg disabled:bg-gray-300 disabled:cursor-not-allowed">
                                Next <i class="ml-2 fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Location & Submit -->
                    <div x-show="step === 3">
                        <p class="text-gray-600 mb-6">Almost done! Just need a few more details:</p>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2">Location</label>
                            <select x-model="location" class="w-full p-3 border border-gray-300 rounded-lg">
                                <option value="">Select location</option>
                                <option value="room_101">Room 101 - Science Lab</option>
                                <option value="room_202">Room 202 - Computer Lab</option>
                                <option value="room_305">Room 305 - Art Studio</option>
                                <option value="auditorium">Auditorium</option>
                                <option value="library">Library</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2">Urgency</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="urgency" value="low" x-model="urgency" class="mr-2">
                                    <span>Low</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="urgency" value="medium" x-model="urgency" class="mr-2" checked>
                                    <span>Medium</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="urgency" value="high" x-model="urgency" class="mr-2">
                                    <span>High</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <button @click="step = 2" class="px-6 py-2 border border-gray-300 rounded-lg">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
                            <button 
                                @click="submitReport()" 
                                :disabled="!location"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg disabled:bg-gray-300 disabled:cursor-not-allowed">
                                Submit Report <i class="ml-2 fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Success Message -->
                    <div x-show="step === 4" class="text-center py-8">
                        <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-2">Report Submitted Successfully!</h3>
                        <p class="text-gray-600 mb-6">Your fault report has been logged. Reference ID: <span x-text="referenceId" class="font-mono font-bold"></span></p>
                        <button @click="resetForm()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">
                            Submit Another Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Tracking Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Track Repair Status</h2>
            
            <div class="max-w-2xl mx-auto bg-gray-50 rounded-lg p-6">
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Enter Reference ID</label>
                    <div class="flex">
                        <input type="text" placeholder="e.g. EDUF-2023-001" class="flex-grow p-3 border border-gray-300 rounded-l-lg">
                        <button class="bg-indigo-600 text-white px-6 rounded-r-lg hover:bg-indigo-700 transition duration-300">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Sample Status Display -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold">Projector - Room 202</h3>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">In Progress</span>
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-gray-600 mb-2">Issue: Display flickering and intermittent shutdown</p>
                        <p class="text-gray-600">Reported: 2 days ago</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mr-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="font-medium">Report Received</p>
                                <p class="text-sm text-gray-500">Oct 10, 2023</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white mr-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="font-medium">Technician Assigned</p>
                                <p class="text-sm text-gray-500">Oct 11, 2023</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center text-white mr-3">
                                <i class="fas fa-cog fa-spin"></i>
                            </div>
                            <div>
                                <p class="font-medium">Repair In Progress</p>
                                <p class="text-sm text-gray-500">Expected completion: Oct 13, 2023</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center opacity-50">
                            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-white mr-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="font-medium">Issue Resolved</p>
                                <p class="text-sm text-gray-500">--</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>