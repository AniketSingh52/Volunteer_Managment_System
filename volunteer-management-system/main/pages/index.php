<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VolunteerHub - Empower Your Volunteer Community</title>
    <link type="image/png" sizes="16x16" rel="icon" href="../assets/Screenshot 2025-02-05 215045.svg">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        'primary-dark': '#2563EB',
                    }
                }
            }
        }
    </script>
    <style>
        .card svg {
            opacity: 0;
        }

        .card svg.fadeIn {
            animation: fadeIn 2s forwards;
        }

        .card svg.top-quote {
            animation: top-quote 2s forwards;
        }

        .card svg.bottom-quote {
            animation: bottom-quote 2s forwards;
        }

        .about {
            animation: fade-out linear;
            animation-timeline: view();
            animation-range: exit -200px;
        }

        @keyframes fade-out {
            to {
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes top-quote {
            0% {
                transform: translate(50px, 80px);
                opacity: 0;
            }

            50% {
                transform: translate(50px, 0px);
                opacity: 1;
            }

            100% {
                transform: translate(0px, 0px);
                opacity: 1;
            }
        }

        @keyframes bottom-quote {
            0% {
                transform: translate(-50px, -80px);
                opacity: 0;
            }

            50% {
                transform: translate(-50px, 0px);
                opacity: 1;
            }

            100% {
                transform: translate(0px, 0px);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="font-sans">
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto py-4 px-10">
            <div class="flex justify-between items-center">
                <a href="#" class="text-3xl font-bold text-blue-500">VolunteerHub</a>
                <div class="hidden md:flex space-x-6">
                    <!-- <a href="#features" class="text-gray-600 text-lg hover:text-primary">Features</a>
                    <a href="#about" class="text-gray-600 text-lg hover:text-primary">About</a>
                    <a href="#contact-us" class="text-gray-600 text-lg hover:text-primary">Contact</a> -->
                </div>
                <div class="hidden md:flex space-x-2">
                    <a href="login_in.php" class="px-4 py-2 border border-primary text-primary font-medium  hover:bg-primary hover:text-white transition duration-300 rounded-lg">Log in</a>
                    <a href="signup.php" class="px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark transition duration-300">Sign up</a>
                </div>
                <button id="menu-toggle" class="md:hidden text-gray-600 hover:text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
        <div id="mobile-menu" class="md:hidden hidden bg-white px-4 pt-2 pb-4 shadow-sm">
            <a href="#features" class="block py-2 text-gray-600 hover:text-primary">Features</a>
            <a href="#about" class="block py-2 text-gray-600 hover:text-primary">About</a>
            <a href="#contact" class="block py-2 text-gray-600 hover:text-primary">Contact</a>
            <div class="mt-4 space-y-2">
                <a href="login_in.php" class="block w-full px-4 py-2 text-center border border-primary text-primary rounded hover:bg-primary hover:text-white transition duration-300">Log in</a>
                <a href="signup.php" class="block w-full px-4 py-2 text-center bg-primary text-white rounded hover:bg-primary-dark transition duration-300">Sign up</a>
            </div>
        </div>
    </header>

    <main>

        <main class="mx-auto">
            <!-- Hero Section -->
            <section class="relative bg-gradient-to-br from-blue-900 to-indigo-800 h-[90vh] text-white overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="absolute inset-0 bg-cover bg-center bg-[url('https://insiderguides.com.au/wp-content/uploads/2016/05/volunteering-scaled.jpg')]   before:content-['']
            before:absolute
            before:inset-0
            before:block
            before:bg-gradient-to-t
            before:from-red-900
            before:to-blue-400
            before:opacity-5
            before:z-1" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>

                <div class=" container mx-auto px-4 py-24 md:py-32 relative z-10">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <!-- Left Side: Company Info -->
                        <div class="w-full md:w-1/2 mb-12 md:mb-0">
                            <h1 class="text-5xl md:text-6xl font-bold mb-6 ">
                                Empower Your Volunteer Community
                            </h1>
                            <p class="text-2xl mb-8 text-gray-200 font-normal"><span class=" text-3xl text-emerald-500 font-bold">Connect,</span><span class="  text-yellow-500 text-3xl font-bold"> Contribute,</span><span class=" text-rose-600 font-bold text-3xl">Create Change,</span> Join us to simplify volunteering and maximize your impact!</p>
                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                <a href="login_in.php" class="bg-white text-blue-900 font-semibold px-8 py-3 rounded-full hover:bg-indigo-600 hover:text-white transition duration-300 text-center">Get Started</a>
                                <!-- <a href="#" class="border-2 border-white text-white font-semibold px-8 py-3 rounded-full hover:bg-white hover:text-blue-900 transition duration-300 text-center">Learn More</a> -->
                            </div>
                        </div>

                        <!-- Right Side: Features -->
                        <div class="w-full md:w-1/2 md:pl-12">
                            <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-xl p-8 shadow-2xl">
                                <h2 class="text-2xl font-semibold mb-6">Why To Volunteer?</h2>
                                <ul class="space-y-4">
                                    <li class="flex items-center">
                                        <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span>Proper Time Usage</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        <span>Peace Of Mind</span>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                        </svg>
                                        <span>A Sense Of Belonging</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Element -->
                <!-- <div class="absolute bottom-0 left-0 right-0">
                    <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" />
                    </svg>
                </div> -->
            </section>

            <!-- ... (rest of your main content) ... -->
        </main>

        <!--Our Impacts-->
        <div class="text-gray-900 pt-5 pb-24 px-6 w-full mt-10 bg-gray-50">
            <div class="max-w-7xl mx-auto text-center">
                <h2 class="text-5xl font-bold mb-6 text-gray-800">Our Impact </h2>
                <p class="text-lg text-gray-600 mb-16">Join thousands who trust our platform </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- User Count -->
                    <div class="flex flex-col items-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl hover:scale-105 hover:shadow-purple-500 border-2 transition-all delay-200">
                        <div
                            class="mb-6 flex items-center justify-center w-28 h-28 rounded-full bg-gradient-to-r from-purple-500 to-pink-400 p-1">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-12 h-12 text-gray-900"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 5.5A3.5 3.5 0 0 1 15.5 9a3.5 3.5 0 0 1-3.5 3.5A3.5 3.5 0 0 1 8.5 9A3.5 3.5 0 0 1 12 5.5M5 8c.56 0 1.08.15 1.53.42c-.15 1.43.27 2.85 1.13 3.96C7.16 13.34 6.16 14 5 14a3 3 0 0 1-3-3a3 3 0 0 1 3-3m14 0a3 3 0 0 1 3 3a3 3 0 0 1-3 3c-1.16 0-2.16-.66-2.66-1.62a5.54 5.54 0 0 0 1.13-3.96c.45-.27.97-.42 1.53-.42M5.5 18.25c0-2.07 2.91-3.75 6.5-3.75s6.5 1.68 6.5 3.75V20h-13zM0 20v-1.5c0-1.39 1.89-2.56 4.45-2.9c-.59.68-.95 1.62-.95 2.65V20zm24 0h-3.5v-1.75c0-1.03-.36-1.97-.95-2.65c2.56.34 4.45 1.51 4.45 2.9z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-800">5+</div>
                        <div class="text-gray-500">Volunteers</div>
                    </div>
                    <!-- Documents Count -->
                    <div class="flex flex-col items-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl hover:scale-105 hover:shadow-purple-500 border-2 transition-all delay-200">
                        <div
                            class="mb-6 flex items-center justify-center w-28 h-28 rounded-full bg-gradient-to-r from-purple-500 to-pink-400 p-1">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-12 h-12 text-gray-900"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm0 2h7v5h5v11H6zm2 8v2h8v-2zm0 4v2h5v-2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-800">15+</div>
                        <div class="text-gray-500">Events and Camps</div>
                    </div>
                    <!-- Languages Supported -->
                    <!-- <div class="flex flex-col items-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div
                            class="mb-6 flex items-center justify-center w-28 h-28 rounded-full bg-gradient-to-r from-purple-500 to-pink-400 p-1">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-12 h-12 text-gray-900"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M17.9 17.39c-.26-.8-1.01-1.39-1.9-1.39h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1V7h2a2 2 0 0 0 2-2v-.41a7.984 7.984 0 0 1 2.9 12.8M11 19.93c-3.95-.49-7-3.85-7-7.93c0-.62.08-1.22.21-1.79L9 15v1a2 2 0 0 0 2 2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-800">100 +</div>
                        <div class="text-gray-500">Trusted organizations</div>
                    </div> -->
                    <div class="flex flex-col items-center p-8 bg-white rounded-lg shadow-lg hover:shadow-xl hover:scale-105 hover:shadow-purple-500 border-2 transition-all delay-200s">
                        <div
                            class="mb-6 flex items-center justify-center w-28 h-28 rounded-full bg-gradient-to-r from-purple-500 to-pink-400 p-1">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-12 h-12 text-gray-900"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M17.9 17.39c-.26-.8-1.01-1.39-1.9-1.39h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1V7h2a2 2 0 0 0 2-2v-.41a7.984 7.984 0 0 1 2.9 12.8M11 19.93c-3.95-.49-7-3.85-7-7.93c0-.62.08-1.22.21-1.79L9 15v1a2 2 0 0 0 2 2m1-16A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-800">6 +</div>
                        <div class="text-gray-500">Trusted organizations</div>
                    </div>
                </div>
            </div>
        </div>




        <!-- MOTTO SECTION -->
        <section class=" h-auto p-14 flex flex-col items-center justify-center mx-auto  rounded-3xl  my-5 overflow-hidden" data-aos="zoom-in">
            <div class="relative w-3/4 mx-auto group card">
                <!-- Quotes -->
                <svg class="absolute transform -left-12 -top-12" width="100" height="78" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M100 0H86.588L59.034 40.478v37.065h37.064V40.478H82.2L100 0zM40.966 0H27.554L0 40.478v37.065h37.064V40.478H23.165L40.965 0z" fill="#871EFF" />
                </svg>
                <svg class="absolute transform -right-12 -bottom-6 flip" width="101" height="78" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2916 77.9999H0.880127L18.6808 37.5217H4.78164V0.457275H41.846V37.5217L14.2916 77.9999Z" fill="#871EFF" />
                    <path d="M73.4115 78H60L77.8007 37.5218H63.9015V0.457397H100.966V37.5219L73.4115 78Z" fill="#871EFF" />
                </svg>
                <!-- Card -->
                <div class="flex flex-row relative bg-gray-900 shadow-xl rounded-2xl text-white">
                    <div class="relative px-4 py-6 p-10 md:p-14 w-3/2 flex flex-wrap content-center">
                        <div class="space-y-1">
                            <p class=" text-white text-4xl font-extrabold flex md:text-4xl ">
                                "No act of kindness, no matter how small, is ever wasted."
                            </p>
                            <footer class="mt-4">
                                <p class="italic text-end text-white text-2xl font-semibold"> - AESOP</p>

                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--Achievements-->
        <div class="bg-white py-10">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">

                    <p class="mt-2 text-pretty text-4xl font-extrabold text-gray-900 sm:text-5xl lg:text-balance">Objectives</p>
                    <p class="mt-6 text-lg/8 text-gray-600">We Target to Achieve the following for the betterment of the society.</p>
                </div>
                <div class="mx-auto mt-4 min-w-full">
                    <dl class="grid min-w-full grid-cols-1 lg:max-w-none lg:grid-cols-2 gap-3">
                        <div class="relative">
                            <div class=" mx-auto flex items-center justify-center">
                                <div class="relative overflow-hidden rounded-2xl">
                                    <!-- Background image with gradient overlay -->
                                    <div class="absolute inset-0">
                                        <img
                                            src="png-clipart-volunteering-community-symbol-sign-gospel-miscellaneous-text.png?height=600&width=1200"
                                            alt="Background"
                                            class="w-full h-full object-cover" />
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/90 to-purple-600/90"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="relative px-8 py-16 md:px-16 md:py-20">
                                        <!-- Logo -->
                                        <div class="flex items-center mb-8 ">
                                            <span class="text-white font-bold text-2xl">Facilitate Opportunity Discovery</span>
                                        </div>

                                        <!-- Quote -->
                                        <blockquote class="mt-6">
                                            <p class="text-xl font-medium text-white leading-relaxed md:leading-relaxed mb-8">
                                                "Allow volunteers to explore and apply for opportunities matching their interests and location."
                                            </p>
                                            <!-- <footer class="mt-4">
                            <p class="text-white text-lg font-semibold">Judith Black</p>
                            <p class="text-purple-200">CEO of Workcation</p>
                        </footer> -->
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative ">
                            <div class=" mx-auto flex items-center justify-center">
                                <div class="relative overflow-hidden rounded-2xl">
                                    <!-- Background image with gradient overlay -->
                                    <div class="absolute inset-0">
                                        <img
                                            src="png-clipart-volunteering-community-symbol-sign-gospel-miscellaneous-text.png?height=600&width=1200"
                                            alt="Background"
                                            class="w-full h-full object-cover" />
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/90 to-purple-600/90"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="relative px-8 py-16 md:px-16 md:py-20">
                                        <!-- Logo -->
                                        <div class="flex items-center mb-8 ">
                                            <span class="text-white font-bold text-2xl">Streamline Event Management</span>
                                        </div>

                                        <!-- Quote -->
                                        <blockquote class="mt-6">
                                            <p class="text-xl font-medium text-white leading-relaxed md:leading-relaxed mb-8">
                                                " Assist organizations in managing volunteer participation for events and <br> initiatives. "
                                            </p>
                                            <!-- <footer class="mt-4">
                            <p class="text-white text-lg font-semibold">Judith Black</p>
                            <p class="text-purple-200">CEO of Workcation</p>
                        </footer> -->
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class=" mx-auto flex items-center justify-center">
                                <div class="relative overflow-hidden rounded-2xl">
                                    <!-- Background image with gradient overlay -->
                                    <div class="absolute inset-0">
                                        <img
                                            src="png-clipart-volunteering-community-symbol-sign-gospel-miscellaneous-text.png?height=600&width=1200"
                                            alt="Background"
                                            class="w-full h-full object-cover" />
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/90 to-purple-600/90"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="relative px-8 py-16 md:px-16 md:py-20">
                                        <!-- Logo -->
                                        <div class="flex items-center mb-8 ">
                                            <span class="text-white font-bold text-2xl">Encourage Social Impact</span>
                                        </div>

                                        <!-- Quote -->
                                        <blockquote class="mt-6">
                                            <p class="text-xl font-medium text-white leading-relaxed md:leading-relaxed mb-8">
                                                " Promote engagement in community welfare programs through better visibility and accessibility. "
                                            </p>
                                            <!-- <footer class="mt-4">
                            <p class="text-white text-lg font-semibold">Judith Black</p>
                            <p class="text-purple-200">CEO of Workcation</p>
                        </footer> -->
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class=" mx-auto flex items-center justify-center ">
                                <div class="relative overflow-hidden rounded-2xl">
                                    <!-- Background image with gradient overlay -->
                                    <div class="absolute inset-0">
                                        <img
                                            src="png-clipart-volunteering-community-symbol-sign-gospel-miscellaneous-text.png?height=600&width=1200"
                                            alt="Background"
                                            class="w-full h-full object-cover" />
                                        <div class="absolute inset-0 bg-gradient-to-r from-purple-900/90 to-purple-600/90"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="relative px-8 py-16 md:px-16 md:py-20">
                                        <!-- Logo -->
                                        <div class="flex items-center mb-8 ">
                                            <span class="text-white font-bold text-2xl">Simplify Volunteer Participation</span>
                                        </div>

                                        <!-- Quote -->
                                        <blockquote class="mt-6">
                                            <p class="text-xl font-medium text-white leading-relaxed md:leading-relaxed mb-8">
                                                " Create an easy-to-use platform for volunteers to sign up and participate in social causes for which they care about. "
                                            </p>
                                            <!-- <footer class="mt-4">
                            <p class="text-white text-lg font-semibold">Judith Black</p>
                            <p class="text-purple-200">CEO of Workcation</p>
                        </footer> -->
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </dl>
                </div>
            </div>
        </div>




        <!--Works-->

        <section id="works" class="relative bg-gray-900 py-10 sm:py-16 lg:py-24">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-4xl text-white font-extrabold mx-auto md:text-6xl lg:text-5xl">How to get started?</h2>
                    <p class="max-w-2xl mx-auto mt-4 text-base text-gray-400 leading-relaxed md:text-2xl">
                        Following are the steps to get started with the platform
                    </p>
                </div>
                <div class="relative mt-12 lg:mt-20">
                    <div class="absolute inset-x-0 hidden xl:px-44 top-2 md:block md:px-20 lg:px-28"><img alt="" loading="lazy" width="1000" height="500" decoding="async" data-nimg="1" class="w-full" style="color:transparent" src="https://cdn.rareblocks.xyz/collection/celebration/images/steps/2/curved-dotted-line.svg">
                    </div>
                    <div class="relative grid grid-cols-1 text-center gap-y-12 md:grid-cols-3 gap-x-12">
                        <div>
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                                <span class="text-xl font-semibold text-gray-700">1</span>
                            </div>
                            <h3 class="mt-6 text-xl  text-white font-semibold leading-tight md:mt-10">Register Yourself</h3>
                            <p class="mt-4 text-base text-gray-400 md:text-lg">
                                Fill in all the Details.
                            </p>
                        </div>
                        <div>
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                                <span class="text-xl font-semibold text-gray-700">2</span>
                            </div>
                            <h3 class="mt-6 text-xl text-white font-semibold leading-tight md:mt-10">Explore the Catalog of Events</h3>
                            <p class="mt-4 text-base text-gray-400 md:text-lg">
                                search the events based on your preferences and interest.
                            </p>
                        </div>
                        <div>
                            <div
                                class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                                <span class="text-xl font-semibold text-gray-700">3</span>
                            </div>
                            <h3 class="mt-6 text-xl text-white font-semibold leading-tight md:mt-10">Apply for it</h3>
                            <p class="mt-4 text-base text-gray-400 md:text-lg">
                                After selecting the event apply to volunteer for that event.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 m-auto max-w-xs h-[357px] blur-[118px] sm:max-w-md md:max-w-lg"
                style="background:radial-gradient(1.89deg, rgba(34, 78, 95, 0.4) -1000%, rgba(191, 227, 205, 0.26) 1500.74%, rgba(34, 140, 165, 0.41) 56.49%, rgba(28, 47, 99, 0.11) 1150.91%)">
            </div>
        </section>

        <!--Contact Us-->

        <div id="contact-us" class="overflow-hidden bg-white py-16 px-4 dark:bg-slate-900 sm:px-6 lg:px-8 lg:py-24">
            <div class="relative mx-auto max-w-xl">
                <svg class="absolute left-full translate-x-1/2 transform" width="404" height="404" fill="none"
                    viewBox="0 0 404 404" aria-hidden="true">
                    <defs>
                        <pattern id="85737c0e-0916-41d7-917f-596dc7edfa27" x="0" y="0" width="20" height="20"
                            patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200 dark:text-slate-600"
                                fill="currentColor"></rect>
                        </pattern>
                    </defs>
                    <rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa27)"></rect>
                </svg>
                <svg class="absolute right-full bottom-0 -translate-x-1/2 transform" width="404" height="404" fill="none"
                    viewBox="0 0 404 404" aria-hidden="true">
                    <defs>
                        <pattern id="85737c0e-0916-41d7-917f-596dc7edfa27" x="0" y="0" width="20" height="20"
                            patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200 dark:text-slate-800"
                                fill="currentColor"></rect>
                        </pattern>
                    </defs>
                    <rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa27)"></rect>
                </svg>
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-slate-200 sm:text-4xl">Contact Us
                    </h2>
                    <p class="mt-4 text-base leading-6 text-gray-500 dark:text-slate-400">Feel free to reach out to us! Whether you have a question, feedback, or a collaboration proposal, we'd love to hear from you.
                        Thank you!
                    </p>
                </div>
                <div class="mt-12">
                    <form class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Name</label>
                            <div class="mt-1">
                                <input name="name" type="text" id="name" autocomplete="organization" required="" class="border border-gray-300 block w-full rounded-md py-3 px-4 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-white/5 dark:bg-slate-700/50 dark:text-white">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Email</label>
                            <div class="mt-1">
                                <input name="email" id="email" required="" type="email" autocomplete="email" class="border border-gray-300 block w-full rounded-md py-3 px-4 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-white/5 dark:bg-slate-700/50 dark:text-white">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Message</label>
                            <div class="mt-1">
                                <textarea required="" name="message" id="message" rows="4" class="border border-gray-300 block w-full rounded-md py-3 px-4 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-white/5 dark:bg-slate-700/50 dark:text-white"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end sm:col-span-2">
                            <button type="submit" class="inline-flex items-center rounded-md px-4 py-2 font-medium focus:outline-none focus-visible:ring focus-visible:ring-sky-500 shadow-sm sm:text-sm transition-colors duration-75 text-sky-500 border border-sky-500 hover:bg-sky-50 active:bg-sky-100 disabled:bg-sky-100 dark:hover:bg-gray-900 dark:active:bg-gray-800 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                <span>Send Message</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>



    <!-- <section class="body-font relative bg-gray-900 text-gray-400">

        <div class="container mx-auto px-5 py-24">

            <div class="mb-12 flex w-full flex-col text-center">
                <h1 class="title-font mb-4 text-2xl font-medium text-white sm:text-3xl">Contact Us</h1>
                <p class="mx-auto text-base leading-relaxed lg:w-2/3">Feel free to reach out to us! Whether you have a question,
                    feedback, or a collaboration proposal, we'd love to hear from you.
                </p>
            </div>

            <div class="mx-auto md:w-2/3 lg:w-1/2">
                <div class="-m-2 flex flex-wrap"> -->

    <!-- form -->
    <!-- <div class="w-1/2 p-2">
                        <div class="relative">
                            <input type="text" id="name" name="name" class="peer w-full rounded border border-gray-700 bg-gray-800 bg-opacity-40 py-1 px-3 text-base leading-8 text-gray-100 placeholder-transparent outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:bg-gray-900 focus:ring-2 focus:ring-indigo-900" placeholder="Name" />
                            <label for="name" class="absolute left-3 -top-6 bg-transparent text-sm leading-7 text-indigo-500 transition-all peer-placeholder-shown:left-3 peer-placeholder-shown:top-2 peer-placeholder-shown:bg-gray-900 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:left-3 peer-focus:-top-6 peer-focus:text-sm peer-focus:text-indigo-500">Name</label>
                        </div>
                    </div>
                    <div class="w-1/2 p-2">
                        <div class="relative">
                            <input type="email" id="email" name="email" class="peer w-full rounded border border-gray-700 bg-gray-800 bg-opacity-40 py-1 px-3 text-base leading-8 text-gray-100 placeholder-transparent outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:bg-gray-900 focus:ring-2 focus:ring-indigo-900" placeholder="Email" />
                            <label for="email" class="absolute left-3 -top-6 bg-transparent text-sm leading-7 text-indigo-500 transition-all peer-placeholder-shown:left-3 peer-placeholder-shown:top-2 peer-placeholder-shown:bg-gray-900 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:left-3 peer-focus:-top-6 peer-focus:text-sm peer-focus:text-indigo-500">Email</label>
                        </div>
                    </div>
                    <div class="mt-4 w-full p-2">
                        <div class="relative">
                            <textarea id="message" name="message" class="peer h-32 w-full resize-none rounded border border-gray-700 bg-gray-800 bg-opacity-40 py-1 px-3 text-base leading-6 text-gray-100 placeholder-transparent outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:bg-gray-900 focus:ring-2 focus:ring-indigo-900" placeholder="Message"></textarea>
                            <label for="message" class="absolute left-3 -top-6 bg-transparent text-sm leading-7 text-indigo-500 transition-all peer-placeholder-shown:left-3 peer-placeholder-shown:top-2 peer-placeholder-shown:bg-gray-900 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:left-3 peer-focus:-top-6 peer-focus:text-sm peer-focus:text-indigo-500">Message</label>
                        </div>
                    </div>
                    <div class="w-full p-2">
                        <button class="mx-auto flex rounded border-0 bg-indigo-500 py-2 px-8 text-lg text-white hover:bg-indigo-600 focus:outline-none">Button</button>
                    </div> -->


    <!-- footer -->
    <!-- <div class="mt-8 w-full border-t border-gray-800 p-2 pt-8 text-center">
                        <a class="text-indigo-400">example@email.com</a>
                        <p class="my-5 leading-normal">49 Smith St. <br />Saint Cloud, MN 56301</p>
                        <span class="inline-flex">
                            <a class="text-gray-500">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-5 w-5" viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                </svg>
                            </a>
                            <a class="ml-4 text-gray-500">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-5 w-5" viewBox="0 0 24 24">
                                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                                </svg>
                            </a>
                            <a class="ml-4 text-gray-500">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-5 w-5" viewBox="0 0 24 24">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                                </svg>
                            </a>
                            <a class="ml-4 text-gray-500">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="h-5 w-5" viewBox="0 0 24 24">
                                    <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                </svg>
                            </a>
                        </span>
                    </div>

                </div>
            </div>

        </div>

    </section> -->







    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h1 class=" text-3xl font-semibold">VolunteerHub</h1>
                    <p class="mt-2">Empowering volunteers, one click at a time.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-primary">Privacy Policy</a>
                    <a href="#" class="hover:text-primary">Terms of Service</a>
                    <a href="#" class="hover:text-primary">Contact</a>
                </div>
            </div>
            <div class="mt-8 text-center text-sm">
                © <span id="current-year"></span> VolunteerHub. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Set current year in footer
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>

</body>
<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const options = {
            root: null,
            rootMargin: "0px",
            threshold: 0.1,
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("fadeIn");
                    if (
                        entry.target.classList.contains("transform") &&
                        entry.target.classList.contains("-left-12")
                    ) {
                        entry.target.classList.add("top-quote");
                    } else if (
                        entry.target.classList.contains("transform") &&
                        entry.target.classList.contains("-right-12")
                    ) {
                        entry.target.classList.add("bottom-quote");
                    }
                    observer.unobserve(entry.target); // Stop observing once the animation is triggered
                }
            });
        }, options);

        const svgs = document.querySelectorAll(".card svg");
        svgs.forEach((svg) => {
            observer.observe(svg);
        });
    });
</script>

</html>

<!-- <div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base/7 font-semibold text-indigo-600">Deploy faster</h2>
            <p class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl lg:text-balance">Everything you need to deploy your app</p>
            <p class="mt-6 text-lg/8 text-gray-600">Quis tellus eget adipiscing convallis sit sit eget aliquet quis. Suspendisse eget egestas a elementum pulvinar et feugiat blandit at. In mi viverra elit nunc.</p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                <div class="relative pl-16">
                    <dt class="text-base/7 font-semibold text-gray-900">
                        <div class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                            </svg>
                        </div>
                        Push to deploy
                    </dt>
                    <dd class="mt-2 text-base/7 text-gray-600">Morbi viverra dui mi arcu sed. Tellus semper adipiscing suspendisse semper morbi. Odio urna massa nunc massa.</dd>
                </div>
                <div class="relative pl-16">
                    <dt class="text-base/7 font-semibold text-gray-900">
                        <div class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </div>
                        SSL certificates
                    </dt>
                    <dd class="mt-2 text-base/7 text-gray-600">Sit quis amet rutrum tellus ullamcorper ultricies libero dolor eget. Sem sodales gravida quam turpis enim lacus amet.</dd>
                </div>
                <div class="relative pl-16">
                    <dt class="text-base/7 font-semibold text-gray-900">
                        <div class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </div>
                        Simple queues
                    </dt>
                    <dd class="mt-2 text-base/7 text-gray-600">Quisque est vel vulputate cursus. Risus proin diam nunc commodo. Lobortis auctor congue commodo diam neque.</dd>
                </div>
                <div class="relative pl-16">
                    <dt class="text-base/7 font-semibold text-gray-900">
                        <div class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                            </svg>
                        </div>
                        Advanced security
                    </dt>
                    <dd class="mt-2 text-base/7 text-gray-600">Arcu egestas dolor vel iaculis in ipsum mauris. Tincidunt mattis aliquet hac quis. Id hac maecenas ac donec pharetra eget.</dd>
                </div>
            </dl>
        </div>
    </div>
</div> -->