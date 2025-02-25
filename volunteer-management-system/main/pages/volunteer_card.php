<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/lucide-icons@0.294.0/dist/umd/lucide.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex space-x-6">
                <img
                    src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=150"
                    alt="John Doe"
                    class="h-24 w-24 rounded-lg object-cover border-2 border-gray-200">
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">John Doe</h3>
                            <p class="text-sm text-gray-500 mt-1">Volunteer ID: VOL-2024-0123</p>
                        </div>
                        <div class="flex items-center bg-green-50 px-3 py-1 rounded-full">
                            <i data-lucide="award" class="h-4 w-4 text-green-600 mr-1"></i>
                            <span class="text-sm font-medium text-green-600">Active Volunteer</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center space-x-4">
                        <div class="flex items-center">
                            <i data-lucide="star" class="h-5 w-5 text-yellow-400"></i>
                            <p class="ml-1.5 text-sm font-medium text-gray-600">Volunteer Score: 4.8</p>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="clock" class="h-5 w-5 text-blue-500"></i>
                            <p class="ml-1.5 text-sm font-medium text-gray-600">Joined: March 15, 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Personal Information</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="h-4 w-4 text-gray-400 mr-2"></i>
                            <span class="text-sm text-gray-600">DOB: January 15, 1990</span>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="user" class="h-4 w-4 text-gray-400 mr-2"></i>
                            <span class="text-sm text-gray-600">Gender: Male</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Contact Information</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i data-lucide="mail" class="h-4 w-4 text-gray-400 mr-2"></i>
                            <span class="text-sm text-gray-600">john.doe@example.com</span>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="phone" class="h-4 w-4 text-gray-400 mr-2"></i>
                            <span class="text-sm text-gray-600">+1 (555) 123-4567</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Location</h4>
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <i data-lucide="map-pin" class="h-4 w-4 text-gray-400 mr-2 mt-0.5"></i>
                            <span class="text-sm text-gray-600">123 Volunteer Street<br>
                                San Francisco, CA 94105<br>
                                United States</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Volunteer Statistics</h4>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-sm text-gray-500">Hours Completed</div>
                            <div class="text-lg font-semibold text-gray-900">156</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-sm text-gray-500">Events Attended</div>
                            <div class="text-lg font-semibold text-gray-900">23</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i data-lucide="edit" class="h-4 w-4 mr-2"></i>
                        Edit Profile
                    </button>
                    <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i data-lucide="message-square" class="h-4 w-4 mr-2"></i>
                        Message
                    </button>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-500">Last updated: 2 days ago</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>

</html>