<!-- Sidebar -->
<div id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900 text-white transform -translate-x-full lg:translate-x-0 transition-all duration-500 ease-in-out z-50 shadow-2xl">
    <!-- Sidebar Header -->
    <div class="sticky top-0 bg-blue-900 bg-opacity-95 backdrop-blur-sm border-b border-blue-700">
        <div class="p-6">
            <!-- Logo & Title -->
            <div class="flex items-center gap-3 mb-6">
                <div class="relative">
                    <i class="ph ph-stethoscope text-3xl text-blue-300 animate-pulse"></i>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full animate-ping"></div>
                </div>
                <div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">Bác sĩ Portal</h1>
                    <p class="text-blue-300 text-sm">Bệnh viện Heruko</p>
                </div>
            </div>

            <!-- Doctor Info -->
            <div class="bg-gradient-to-r from-blue-800 to-blue-700 rounded-xl p-4 border border-blue-600 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                            <i class="ph ph-user-circle text-2xl text-white"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-blue-800"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-white truncate">{{ Auth::guard('doctor')->user()->name ?? 'Bác sĩ' }}</h3>
                        <p class="text-blue-200 text-sm truncate">{{ Auth::guard('doctor')->user()->department->name ?? 'N/A' }}</p>
                        <p class="text-blue-300 text-xs">ID: {{ Auth::guard('doctor')->user()->id ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scrollable Navigation Menu -->
    <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-600 scrollbar-track-blue-800" style="max-height: calc(100vh - 200px);">
        <div class="p-6">
            <nav class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('doctors.dashboard') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('doctors.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'hover:bg-blue-800 hover:shadow-md' }} transition-all duration-300 transform hover:scale-105">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                        <i class="ph ph-house text-lg"></i>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    @if(request()->routeIs('doctors.dashboard'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Appointments -->
                <a href="{{ route('doctors.appointments') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('doctors.appointments') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'hover:bg-blue-800 hover:shadow-md' }} transition-all duration-300 transform hover:scale-105">
                    <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-colors">
                        <i class="ph ph-calendar-check text-lg"></i>
                    </div>
                    <span class="font-medium">Lịch khám</span>
                    @if(request()->routeIs('doctors.appointments'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Exam Create -->
                <a href="{{ route('doctors.exam.create') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('doctors.exam.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'hover:bg-blue-800 hover:shadow-md' }} transition-all duration-300 transform hover:scale-105">
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center group-hover:bg-purple-500 transition-colors">
                        <i class="ph ph-file-plus text-lg"></i>
                    </div>
                    <span class="font-medium">Khám bệnh</span>
                    @if(request()->routeIs('doctors.exam.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Prescription Create -->
                <a href="{{ route('doctors.prescription.create') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('doctors.prescription.create') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'hover:bg-blue-800 hover:shadow-md' }} transition-all duration-300 transform hover:scale-105">
                    <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center group-hover:bg-orange-500 transition-colors">
                        <i class="ph ph-pill text-lg"></i>
                    </div>
                    <span class="font-medium">Kê đơn thuốc</span>
                    @if(request()->routeIs('doctors.prescription.create'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Medical Records -->
                <a href="{{ route('doctors.medical-records') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('doctors.medical-records*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'hover:bg-blue-800 hover:shadow-md' }} transition-all duration-300 transform hover:scale-105">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center group-hover:bg-indigo-500 transition-colors">
                        <i class="ph ph-folder-open text-lg"></i>
                    </div>
                    <span class="font-medium">Hồ sơ bệnh nhân</span>
                    @if(request()->routeIs('doctors.medical-records*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Prescriptions -->
                <a href="{{ route('doctors.prescriptions') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('doctors.prescriptions*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'hover:bg-blue-800 hover:shadow-md' }} transition-all duration-300 transform hover:scale-105">
                    <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center group-hover:bg-teal-500 transition-colors">
                        <i class="ph ph-receipt text-lg"></i>
                    </div>
                    <span class="font-medium">Đơn thuốc của bệnh nhân</span>
                    @if(request()->routeIs('doctors.prescriptions*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>



                <!-- Statistics -->
                <a href="{{ route('doctors.statistics') }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('doctors.statistics') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'hover:bg-blue-800 hover:shadow-md' }} transition-all duration-300 transform hover:scale-105">
                    <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center group-hover:bg-yellow-500 transition-colors">
                        <i class="ph ph-chart-bar text-lg"></i>
                    </div>
                    <span class="font-medium">Thống kê</span>
                    @if(request()->routeIs('doctors.statistics'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

             
            </nav>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sticky bottom-0 bg-blue-900 bg-opacity-95 backdrop-blur-sm border-t border-blue-700">
        <div class="p-6">
            <div class="border-t border-blue-700 pt-4">
                <a href="#" onclick="confirmLogout()" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gradient-to-r hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center group-hover:bg-red-500 transition-colors">
                        <i class="ph ph-sign-out text-lg"></i>
                    </div>
                    <span class="font-medium">Đăng xuất</span>
                    <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="ph ph-arrow-right text-sm"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Custom Scrollbar Styles -->
<style>
    /* Webkit browsers (Chrome, Safari, Edge) */
    .scrollbar-thin::-webkit-scrollbar {
        width: 8px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #1e3a8a;
        border-radius: 4px;
        margin: 4px 0;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #2563eb);
        border-radius: 4px;
        border: 1px solid #1e40af;
        transition: all 0.3s ease;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #60a5fa, #3b82f6);
        transform: scaleX(1.2);
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb:active {
        background: linear-gradient(to bottom, #1d4ed8, #1e40af);
    }
    
    /* Firefox */
    .scrollbar-thin {
        scrollbar-width: thin;
        scrollbar-color: #2563eb #1e3a8a;
    }
    
    /* Always show scrollbar for testing */
    .scrollbar-thin {
        overflow-y: scroll !important;
    }
    
    /* Custom scrollbar for the sidebar */
    #sidebar .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }
    
    #sidebar .overflow-y-auto::-webkit-scrollbar-track {
        background: rgba(30, 58, 138, 0.3);
        border-radius: 4px;
        margin: 4px 0;
    }
    
    #sidebar .overflow-y-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #2563eb);
        border-radius: 4px;
        border: 1px solid #1e40af;
        box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.1);
    }
    
    #sidebar .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #60a5fa, #3b82f6);
        box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.2);
    }
</style>

<script>
    // Sidebar-specific functionality (only runs if not already initialized)
    if (!window.sidebarInitialized) {
        window.sidebarInitialized = true;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Force scrollbar to show for testing
            const sidebarContent = document.querySelector('#sidebar .overflow-y-auto');
            if (sidebarContent) {
                // Add some padding to ensure content overflows
                sidebarContent.style.paddingBottom = '100px';
                
                // Ensure scrollbar is visible
                sidebarContent.style.overflowY = 'scroll';
                
                // Add scroll event listener
                sidebarContent.addEventListener('scroll', function() {
                    console.log('Scrolling sidebar:', this.scrollTop);
                });
            }

            // Add a test button to show scrollbar functionality
            // const testButton = document.createElement('button');
            // testButton.innerHTML = '🔍 Test Scroll';
            // testButton.className = 'fixed top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded text-sm z-50';
            // testButton.onclick = function() {
            //     const sidebarContent = document.querySelector('#sidebar .overflow-y-auto');
            //     if (sidebarContent) {
            //         sidebarContent.scrollTo({
            //             top: sidebarContent.scrollHeight,
            //             behavior: 'smooth'
            //         });
            //     }
            // };
            // document.body.appendChild(testButton);
        });
    }
</script> 