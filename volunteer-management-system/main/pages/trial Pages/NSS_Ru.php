<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>V. G. VAZE</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,200,0,-25" />
    <!-- <link rel="stylesheet" href="../../js/showMoreItems-theme.min.css"> -->
    <link rel="stylesheet" href="demo.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/themes/prism.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/prism.min.js"></script>
    <script src="../../js/showMoreItems.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: rgb(37 99 235);
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #b30000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        .navbar {
            position: fixed;
            z-index: 2;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* padding: 2em 3em; */
            transition: all 0.3s;
        }

        .site-logo {
            color: #000;
        }

        .nav-container {
            transition: all 0.3s;
            visibility: hidden;
        }

        #menu-toggle-btn {
            transition: all 0.3s;
            z-index: 100000;
            cursor: pointer;
        }

        #menu-buttons {
            height: 2px;
            background: #000;
            width: 24px;
            display: inline-block;
            position: absolute;
            top: 50%;
            transition: all 0.3s;
        }

        #menu-buttons::before {
            content: " ";
            position: absolute;
            display: inline-block;
            height: 2px;
            background: #000;
            transform: translateY(-4px);
            width: 24px;
            transition: all 0.3s;
            top: -2px;
        }

        #menu-buttons::before {
            content: " ";
            position: absolute;
            display: inline-block;
            height: 2px;
            background: #000;
            transform: translateY(-4px);
            width: 24px;
            transition: all 0.3s;
            top: -2px;
        }

        .active #menu-buttons {
            transform: rotate(45deg);
            background: #fff;
        }

        .active #menu-buttons::before {
            top: unset;
            transform: rotate(-90deg);
            background: #fff;
        }

        .active:hover #menu-buttons::before {
            top: unset;
        }

        .nav-item-wrapper::after {
            content: "";
            position: absolute;
            top: 60px;
            left: 0;
            width: 500px;
            height: 60px;
            background: #000;
            margin: 0 auto;
            transition: 1s;
        }

        .nav-link {
            border: 0 solid transparent;
            /* Initial state with no visible border */
        }

        /* @media (max-width:900) {
    .nav {
        flex-direction: column-reverse;
    }
    .nav-logo {
        display: none;
    }
    .nav-socials {
        flex-direction: row;
        margin-top: 4em;

    }
    .nav-socials a {
        padding: 0 0 0.4em;
    }
    .nav-footer{
        display: none;
    }
} */





        .hide-scroll-bar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .hide-scroll-bar::-webkit-scrollbar {
            display: none;
        }

        .head2 {
            background: linear-gradient(to right,
                    rgb(0, 35, 177),
                    rgb(214, 95, 69));
            /* -webkit-background-clip: text; */
            -webkit-text-fill-color: transparent;
        }

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

<body class="bg-gray-100 overflow-x-hidden mx-auto dark:bg-black" style="transition: all 2s ease">
    <div class="w-full bg-gray-100 overflow-hidden" id="main">
        <!-- logo & Humburger  -->
        <div class="navbar p-5 pr-20  z-50 " id="header">
            <div class="site-logo  flex flex-row">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqmQgjQk1D7mvZUTC1ge9JFD8AFuM7ydyV_Ne0J3jsOQ&s" class="h-14 mr-3 sm:h-20" alt="Landwind Logo">
                <span class="sm:text-lg  self-center text-xs font-semibold whitespace-nowrap dark:text-white">
                    THE KELKAR EDUCATION TRUST'S <br />
                    VINAYAK GANESH VAZE COLLEGE OF ARTS, <br />
                    SCIENCE AND COMMERCE (AUTONOMOUS)
                </span>

            </div>
            <div class="menu-toggle">
                <div id="menu-toggle-btn">
                    <span id="menu-buttons"></span>
                </div>
            </div>
        </div>

        <!-- Header  -->
        <!-- <div
            class="absolute w-full top-2/4 left-2/4 translate-x-[-50%] translate-y-[-50%] text-8xl uppercase font-normal text-center "
          >
            We Transform <br />
            Ideas into Digital<br />
            Outcomes.
            
          </div> -->
        <div>
            <div>
                <div class="relative isolate flex flex-col justify-end overflow-hidden py-2 md:h-[30rem] h-[25rem] mx-auto w-full items-center justify-center">
                    <img src="../../assests/nss.jpg" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover" />
                    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-800 via-gray-900/10"></div>
                    <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-white/10"></div>
                    <div class="text-center z-1" data-aos="fade-up">
                        <h1 class="md:text-7xl text-5xl font-bold tracking-tight text-white sm:text-6xl text-center px-[20px]">
                            NSS
                        </h1>
                    </div>
                    <div class="text-center z-1" data-aos="fade-up">
                        <p class="mt-6 text-3xl leading-8 text-white">
                            National Service Scheme.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Component: Flat breadcrumb with text & leading icon -->
            <nav aria-label="Breadcrumb" class="pl-16 mt-10" id="Breadcrumb">
                <ol class="flex items-stretch gap-2 list-none">
                    <li class="flex items-center gap-2">
                        <a href="#" class="flex max-w-[20ch] items-center gap-1 truncate whitespace-nowrap text-slate-700 transition-colors hover:text-emerald-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true" aria-labelledby="title-01 description-01" role="link">
                                <title id="title-01">Home</title>
                                <desc id="description-01">
                                    Home button indicating the homepage of the website.
                                </desc>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="hidden md:block">Home</span>
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-none w-4 h-4 transition-transform stroke-slate-700 md:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true" aria-labelledby="title-02 description-02" role="graphics-symbol">
                            <title id="title-02">Arrow</title>
                            <desc id="description-02">
                                Arrow icon that points to the next page in big screen resolution sizes
                                and previous page in small screen resolution sizes.
                            </desc>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </li>
                    <li class="flex items-center flex-1 gap-2">
                        <a href="#" aria-current="page" class="pointer-events-none max-w-[20ch] truncate whitespace-nowrap text-slate-400">NSS</a>
                    </li>
                </ol>
            </nav>
            <!-- End Flat breadcrumb with text & leading icon -->
            <!--ABOUT SECTION-->
            <section class="py-12">
                <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                    <div class="mb-12 space-y-2 text-center">
                        <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                            About NSS
                        </h2>
                        <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                            Empowering Youth for Social Change and Community Development
                        </p>

                    </div>
                    <div class=" grid grid-cols-1 items-center justify-center mx-auto md:grid-cols-3 gap-2 md:mx-10 overflow-hidden about">
                        <div class="order-last md:order-1 md:text-left lg:text-left text-center mx-auto p-10 col-span-2" data-aos="fade-right">
                            <p class="text-justify">
                                In India, the idea of involving students in the task of national
                                service dates back to the times of Mahatma Gandhi, the father of the
                                nation. The central theme which he tried to impress upon his student
                                audience time and again, was that they should always keep before them,
                                their social responsibility. <br />The University Grants Commission
                                headed by
                                <span class="bg-yellow-200">Dr. Radhakrishnan</span> recommended
                                introduction of national service in the academic institutions on a
                                voluntary basis with a view to developing healthy contacts between the
                                students and teachers on the one hand and establishing a constructive
                                linkage between the campus and the community on the other hand.
                            </p>
                        </div>
                        <div class="md:order-2 mx-auto" data-aos="fade-left">
                            <image alt="NextUI hero Image with delay" class="rounded md:max-h-[200px] lg:max-h-[300px] max-h-60" src="https://www.pngkey.com/png/full/247-2479287_nss-logo-national-service-scheme-logo-png.png" />
                        </div>
                    </div>
                </div>
            </section>
            <!-- MOTTO SECTION -->
            <section class="h-[350px] max-h-[400px] bg-gray-100 flex flex-col items-center justify-center mx-auto  rounded-3xl  my-5" data-aos="zoom-in">
                <div class="relative max-w-xl mx-auto group card">
                    <!-- Quotes -->
                    <svg class="absolute transform -left-12 -top-12" width="100" height="78" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M100 0H86.588L59.034 40.478v37.065h37.064V40.478H82.2L100 0zM40.966 0H27.554L0 40.478v37.065h37.064V40.478H23.165L40.965 0z" fill="#871EFF" />
                    </svg>
                    <svg class="absolute transform -right-12 -bottom-6 flip" width="101" height="78" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.2916 77.9999H0.880127L18.6808 37.5217H4.78164V0.457275H41.846V37.5217L14.2916 77.9999Z" fill="#871EFF" />
                        <path d="M73.4115 78H60L77.8007 37.5218H63.9015V0.457397H100.966V37.5219L73.4115 78Z" fill="#871EFF" />
                    </svg>
                    <!-- Card -->
                    <div class="flex flex-row relative bg-white shadow-xl rounded-2xl">
                        <div class="relative px-4 py-6 p-10 md:p-14 w-3/2 flex flex-wrap content-center">
                            <div class="space-y-1">
                                <p class="italic text-gray-800 text-4xl font-extrabold leading-none md:text-4xl lg:text-5xl">
                                    Not Me But You.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--OBJECTIVES SECTION-->
            <section class="py-12">
                <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                    <div class="mb-12 space-y-2 text-center">
                        <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                            Objectives
                        </h2>
                        <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                            Working Towards a Better Society Through
                        </p>
                    </div>
                    <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-16">
                        <div class=" dark:lg:bg-darker  rounded-[4rem] space-y-6 md:flex flex-row-reverse md:gap-6 justify-center md:space-y-0 lg:items-center">
                            <div class="md:5/12 lg:w-1/2">
                                <img src="../../assests/Capa 1.png" alt="image" loading="lazy" class="" />
                            </div>
                            <div class="md:7/12 lg:w-1/2">
                                <div class="divide-y space-y-8 divide-gray-300 dark:divide-gray-800">
                                    <div class="mt-8 flex gap-4 md:items-center">
                                        <div class="w-12 h-12 flex gap-4 rounded-full bg-indigo-100 dark:bg-indigo-900/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-indigo-500 dark:text-indigo-400">
                                                <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 01-3.476.383.39.39 0 00-.297.17l-2.755 4.133a.75.75 0 01-1.248 0l-2.755-4.133a.39.39 0 00-.297-.17 48.9 48.9 0 01-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97zM6.75 8.25a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H7.5z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-5/6">
                                            <h4 class="font-semibold text-lg text-gray-700 dark:text-indigo-300">Instill
                                                Solidarity</h3>
                                                <p class="text-gray-500 dark:text-gray-400">As the motto of NSS goes,
                                                    "Not me
                                                    but you," the primary objective of the NSS Unit of Vaze College is
                                                    to foster
                                                    a spirit of solidarity among volunteers.</p>
                                        </div>
                                    </div>
                                    <div class="pt-4 flex gap-4 md:items-center">
                                        <div class="w-12 h-12 flex gap-4 rounded-full bg-teal-100 dark:bg-teal-900/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-teal-600 dark:text-teal-400">
                                                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-5/6">
                                            <h4 class="font-semibold text-lg text-gray-700 dark:text-teal-300">
                                                Understand
                                                Transformations</h3>
                                                <p class="text-gray-500 dark:text-gray-400">As societal processes
                                                    undergo
                                                    significant transformation, NSS offers a platform to comprehend
                                                    these
                                                    changes and how volunteers, as responsible citizens, can adapt and
                                                    help
                                                    marginalized sections integrate into the development process.</p>
                                        </div>
                                    </div>
                                    <div class="pt-4 flex gap-4 md:items-center">
                                        <div class="w-12 h-12 flex gap-4 rounded-full bg-teal-100 dark:bg-teal-900/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-teal-600 dark:text-teal-400">
                                                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-5/6">
                                            <h4 class="font-semibold text-lg text-gray-700 dark:text-teal-300">Promote
                                                Discipline and Time Management</h3>
                                                <p class="text-gray-500 dark:text-gray-400">The spirit of solidarity
                                                    must be
                                                    supported by a strong sense of discipline and time management, which
                                                    NSS
                                                    aims to cultivate.</p>
                                        </div>
                                    </div>
                                    <div class="pt-4 flex gap-4 md:items-center">
                                        <div class="w-12 h-12 flex gap-4 rounded-full bg-teal-100 dark:bg-teal-900/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-teal-600 dark:text-teal-400">
                                                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-5/6">
                                            <h4 class="font-semibold text-lg text-gray-700 dark:text-teal-300">Expose to
                                                Rural
                                                Life</h3>
                                                <p class="text-gray-500 dark:text-gray-400">NSS seeks to familiarize
                                                    city-raised
                                                    students with elements of rural life, broadening their perspectives
                                                    and
                                                    understanding.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!--Year Dropdown-->
            <!-- <div
      class="mx-auto rounded-2xl py-10 text-center px-2 bg-gray-200"
      data-aos="zoom-in"
    >
      <div class="mx-auto flex w-full">
        <div
          class="basis-[75%] md:text-3xl font-bold text-left md:px-[100px] text-[25px] inline px-3"
        >
          Yearly Activities
        </div>
        <select
          id="year"
          class="md:max-w-2xl text-center basis-[25%] text-sm font-medium inline px-3 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500 rounded-md shadow-sm focus:outline-none focus:ring-2 border border-gray-300"
        >
          <option disabled>Select a Year</option>
          <option value="2023">2023-2024</option>
          <option value="2022">2022-2023</option>
          <option value="2021">2021-2022</option>
          <option value="2020">2020-2021</option>
          <option value="2019" selected>2019-2020</option>
        </select>
      </div>
    </div> -->
            <div class="py-12">
                <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                    <div class="mb-12 space-y-2 text-center">
                        <h2 class="text-5xl font-bold text-gray-800 md:text-6xl dark:text-white">
                            Yearly Activities
                        </h2>
                        <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                            Browse our past events and select the year range you're interested in.
                        </p>
                    </div>
                    <div class="flex hide-scroll-bar lg:justify-center items-center gap-6 flex-nowrap overflow-x-auto mx-auto">
                        <button class="bg-blue-500 text-nowrap px-5 py-3 text-sm shadow-sm font-bold tracking-wider  text-blue-100 rounded-full hover:shadow-2xl hover:bg-blue-600">2023-2024</button>
                        <button class="bg-gray-50 text-nowrap px-5 py-3 text-sm shadow-sm font-medium tracking-wider  text-gray-600 rounded-full hover:shadow-2xl hover:bg-gray-100">2022-2023</button>
                        <button class="bg-gray-50 text-nowrap px-5 py-3 text-sm shadow-sm font-medium tracking-wider  text-gray-600 rounded-full hover:shadow-2xl hover:bg-gray-100">2021-2022</button>
                        <button class="bg-gray-50 text-nowrap px-5 py-3 text-sm shadow-sm font-medium tracking-wider  text-gray-600 rounded-full hover:shadow-2xl hover:bg-gray-100">2020-2021</button>
                        <button class="bg-gray-50 text-nowrap px-5 py-3 text-sm shadow-sm font-medium tracking-wider  text-gray-600 rounded-full hover:shadow-2xl hover:bg-gray-100">2019-2020</button>
                        <button class="bg-gray-50 text-nowrap px-5 py-3 text-sm shadow-sm font-medium tracking-wider  text-gray-600 rounded-full hover:shadow-2xl hover:bg-gray-100">2018-2019</button>
                        <button class="bg-gray-50 text-nowrap px-5 py-3 text-sm shadow-sm font-medium tracking-wider  text-gray-600 rounded-full hover:shadow-2xl hover:bg-gray-100">2017-2018</button>
                    </div>

                </div>
            </div>
            <!--yearly activities-->
            <div id="2019_2020" class="max-w-[95dvw] rounded-2xl mb-12 bg-white mx-auto" style="transition: all 2s ease">
                <!--Achivements-->
                <section class="py-12 border-b">
                    <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                        <div class="mb-12 space-y-2 text-center">
                            <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                                Achievements and Participation at <br /> State and University Levels
                            </h2>
                            <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                                Celebrating the outstanding accomplishments of our talented students.
                            </p>
                        </div>


                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Degree Unit</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Junior Unit</button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-styled-tab-content">
                            <div class="hidden p-4 overflow-hidden rounded-lg  dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                <script>
                                    $(document).ready(function() {

                                        $('.list1').showMoreItems({
                                            startNum: 6,
                                            afterNum: 3,
                                            moreText: 'View All',
                                            original: true,
                                        });
                                    })
                                </script>
                                <div class=" grid gap-8 sm:grid-cols-2 md:-mx-8 lg:grid-cols-3 md:px-10 list1">
                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 2nd Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Street Play Competition organised by B.N. Bandodkar College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Won 2nd Prize in Street Play Competition organised by B.N. Bandodkar
                                                    College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">2nd
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">B.N. Bandodkar
                                                        College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 1st Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Best Out of Waste in DVITI Fest at SIES College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Esha Mungalekar and Ms. Pooja Mestry won 1st Prize in Best Out
                                                    of Waste
                                                    in DVITI Fest at SIES College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">1st
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">SIES College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 1st Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Treasure Hunt in AAROHAN Fest at VPM College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Mr. Lokesh Pujari, Mr. Apurvesh Sawant, Mr. Apurva Bomble & Ms.
                                                    Radhika
                                                    Shine won 1st Prize in Treasure Hunt in AAROHAN Fest at VPM College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">1st
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">VPM College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 1st Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Krida in DVITI Fest at SIES College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Esha Mungalekar and Ms. Pooja Mestry won 1st Prize in Krida in
                                                    DVITI
                                                    Fest at SIES College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">1st
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">SIES College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 2nd Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        PPT in LAKSHYA Fest at SIES College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Vedashree Wadshingkar and Ms. Radhika Shinde won 2nd Prize in
                                                    PPT in
                                                    LAKSHYA Fest at SIES College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">2nd
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">SIES College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Participated
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        University Level Leadership Training Programme
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Jagruti Janjirkar participated in the University Level
                                                    Leadership
                                                    Training Programme.
                                                </p>
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Rupal Pawar participated in the University Level Leadership
                                                    Training
                                                    Programme.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        star
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">Participated</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">University
                                                        Level</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Selected
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Pre-State Republic Day Camp
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Gauri Sonawane selected for Pre-State Republic Day Camp.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        event
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">Selected</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">Pre-State Republic Day
                                                        Camp</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Participated
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Swachh Bharat Special Camp & Yoga Camp
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Mr. Apurvesh Sawant participated in Swachh Bharat Special Camp &
                                                    Yoga Camp
                                                    conducted by University of Mumbai.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        star
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">Participated</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">University of
                                                        Mumbai</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 1st Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Essay Writing at Srujan Fest organised by Bandodkar College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Radhika Shinde won 1st Prize in Essay Writing at Srujan Fest
                                                    organised
                                                    by Bandodkar College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">1st
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">Bandodkar
                                                        College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 1st Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Open-Mic & 3rd Prize in Suspense Story Writing at Olakh Fest
                                                        organised
                                                        by Ruia College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Pooja Chavan won 1st Prize in Open-Mic & 3rd Prize in Suspense
                                                    Story
                                                    Writing at Olakh Fest organised by Ruia College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">1st
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">3rd
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">Ruia College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Selected
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Utkarsha Camp at University Level
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Divya Ballewar selected for Utkarsha Camp at University Level.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        event
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">Selected</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">University
                                                        Level</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 2nd Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Mono Acting in ANUBHUTI Fest at Ruia College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Mr. Darshan Thoke won 2nd Prize & 3rd Prize in Mono Acting in
                                                    ANUBHUTI Fest
                                                    at Ruia College and LAKSHYA Fest at SIES College respectively.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">2nd
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">3rd
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">Ruia College</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">SIES College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-10">
                                            <div class="flex items-center space-x-4">
                                                <div aria-hidden="true" class="flex size-16 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                    <span class="font-bold text-4xl text-pink-600 dark:text-pink-300 material-symbols-outlined">emoji_events</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                        Won 1st Prize
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                                        Photography in DVITI Fest at SIES College
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Ms. Mansi Warghanti won 1st Prize in Photography in DVITI Fest at
                                                    SIES
                                                    College.
                                                </p>
                                            </div>
                                            <div class="flex flex-col gap-6 mt-10">
                                                <div class="flex gap-2 items-center text-yellow-500">
                                                    <span class="material-symbols-outlined font-medium text-2xl">
                                                        military_tech
                                                    </span>
                                                    <span class="w-max block font-normal text-gray-700 sm:mt-0">1st
                                                        Prize</span>
                                                </div>
                                                <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                    <span class="material-symbols-outlined">
                                                        school
                                                    </span>
                                                    <span class="line-clamp-1 hover:line-clamp-4">SIES College</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="hidden p-4 rounded-lg  dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class=" grid gap-8 sm:grid-cols-2 md:-mx-8 lg:grid-cols-3">
                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-16">
                                            <div aria-hidden="true" class="flex h-10 w-10 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                <span class="font-bold text-pink-600 dark:text-pink-300">1</span>
                                            </div>
                                            <div class="space-y-4">
                                                <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                    First feature
                                                </h3>
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Quae accusantium, laudantium recusandae tenetur fugiat non cum
                                                    doloribus
                                                    aperiam
                                                    voluptates nostrum.
                                                </p>
                                            </div>
                                            <img src="https://cdn-icons-png.flaticon.com/512/7983/7983132.png" class="w-16" width="512" height="512" alt="burger illustration" />
                                        </div>
                                    </div>
                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-16">
                                            <div aria-hidden="true" class="flex h-10 w-10 items-center justify-center rounded-full bg-pink-50 dark:bg-gray-700">
                                                <span class="font-bold text-pink-600 dark:text-pink-300">2</span>
                                            </div>
                                            <div class="space-y-4">
                                                <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                    Second feature
                                                </h3>
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Quae accusantium, laudantium recusandae tenetur fugiat non cum
                                                    doloribus
                                                    aperiam
                                                    voluptates nostrum.
                                                </p>
                                            </div>
                                            <img src="https://cdn-icons-png.flaticon.com/512/7983/7983306.png" class="w-16" width="512" height="512" alt="burger illustration" />
                                        </div>
                                    </div>
                                    <div class="p-8 py-12 sm:p-12 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                        <div class="space-y-16">
                                            <div aria-hidden="true" class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-50 dark:bg-gray-700">
                                                <span class="font-bold text-purple-600 dark:text-purple-300">3</span>
                                            </div>
                                            <div class="space-y-4">
                                                <h3 class="text-2xl font-semibold text-gray-800 transition dark:text-white">
                                                    Third feature
                                                </h3>
                                                <p class="text-gray-600 dark:text-gray-300">
                                                    Quae accusantium, laudantium recusandae tenetur fugiat non cum
                                                    doloribus
                                                    aperiam
                                                    voluptates nostrum.
                                                </p>
                                            </div>
                                            <img src="https://cdn-icons-png.flaticon.com/512/7983/7983333.png" class="w-16" width="512" height="512" alt="burger illustration" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                <!--Activities Conducted-->
                <section class="py-12 border-b">
                    <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                        <div class="mb-12 space-y-2 text-center">
                            <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                                Activities Conducted
                            </h2>
                            <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                                We engage in a variety of activities to promote community well-being and development
                            </p>
                        </div>

                        <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                            <div class="grid gap-12 md:gap-6 md:grid-cols-2 lg:gap-12">
                                <div class="group space-y-6">
                                    <img src="../../assests/nss_yogaday.jpg" alt="art cover" loading="lazy" width="1000" height="667" class="h-96 w-full rounded-3xl object-cover object-top transition-all duration-500 group-hover:rounded-xl" />
                                    <h3 class="text-3xl font-semibold text-gray-800 dark:text-white">
                                        Yoga Day
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Celebration of International Yoga Day on 21st June 2019 with an initiative to
                                        spread
                                        awareness about Yoga through beautiful posters in college campus and a practice
                                        session
                                        of Yoga. </p>
                                    <div class="flex gap-6 items-center">
                                        <div class="flex gap-2 items-center text-gray-500">
                                            <span class="material-symbols-outlined">
                                                calendar_month
                                            </span>
                                            <span class="w-max block font-light text-gray-500 sm:mt-0">Jun 21
                                                2019</span>
                                        </div>
                                        <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                            <span class="material-symbols-outlined">
                                                location_on
                                            </span>
                                            <span class="line-clamp-1 hover:line-clamp-4">V.G. Vaze College of Arts,
                                                Science and
                                                Commerce (Autonomous)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="group space-y-6">
                                    <img src="../../assests/no_to_tabaco.jpg" alt="art cover" loading="lazy" width="1000" height="667" class="h-96 w-full rounded-3xl object-cover object-top transition-all duration-500 group-hover:rounded-xl" />
                                    <h3 class="text-3xl font-semibold text-gray-800 dark:text-white">
                                        No To Tobacco
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        NSS Degree Volunteers gave a pledge to around 750 students of the college on 8th
                                        July
                                        2019 to abstain from the use of tobacco.
                                    </p>
                                    <div class="flex gap-6 items-center">
                                        <div class="flex gap-2 items-center text-gray-500">
                                            <span class="material-symbols-outlined">
                                                calendar_month
                                            </span>
                                            <span class="w-max block font-light text-gray-500 sm:mt-0">Jun 21
                                                2019</span>
                                        </div>
                                        <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                            <span class="material-symbols-outlined">
                                                location_on
                                            </span>
                                            <span class="line-clamp-1 hover:line-clamp-4">V.G. Vaze College of Arts,
                                                Science and
                                                Commerce (Autonomous)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="group space-y-6">
                                    <img src="../../assests/swatch_bharat.jpg" alt="art cover" loading="lazy" width="1000" height="667" class="h-96 w-full rounded-3xl object-cover object-top transition-all duration-500 group-hover:rounded-xl" />
                                    <h3 class="text-3xl font-semibold text-gray-800 dark:text-white">
                                        Swachh Bharat Abhiyan
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Volunteers took up a Swachh Bharat Summer Internship Programme at our adopted
                                        village
                                        Bendshil- Chiknichi Wadi, Badlapur which included a number of activities such as
                                        survey
                                        about cleanliness, awareness campaign regarding solid waste management & on
                                        dry/wet
                                        waste management, construction of compost pits.
                                    </p>
                                    <div class="flex gap-6 items-center">
                                        <div class="flex gap-2 items-center text-gray-500">
                                            <span class="material-symbols-outlined">
                                                calendar_month
                                            </span>
                                            <span class="w-max block font-light text-gray-500 sm:mt-0">Jun 21
                                                2019</span>
                                        </div>
                                        <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                            <span class="material-symbols-outlined">
                                                location_on
                                            </span>
                                            <span class="line-clamp-1 hover:line-clamp-4">Bendshil- Chiknichi Wadi,
                                                Badlapur</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="group space-y-6">
                                    <img src="https://borgenproject.org/wp-content/uploads/Online-Education-in-India-1030x687.jpg" alt="art cover" loading="lazy" width="1000" height="667" class="h-96 w-full rounded-3xl object-cover object-top transition-all duration-500 group-hover:rounded-xl" />
                                    <h3 class="text-3xl font-semibold text-gray-800 dark:text-white">
                                        Encourage Education
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Set up a Library in Bendshil Village – Chiknichi Wadi, Badlapur East to ensure
                                        that the
                                        children have daily access to 202 books which take care of requirements other
                                        than their
                                        academics with books emphasizing on moral lessons. and also donated 150
                                        notebooks & 50
                                        pens to Immanuel Mercy Home – Special Child Care Centre..
                                    </p>
                                    <div class="flex gap-6 items-center">
                                        <div class="flex gap-2 items-center text-gray-500">
                                            <span class="material-symbols-outlined">
                                                calendar_month
                                            </span>
                                            <span class="w-max block font-light text-gray-500 sm:mt-0">Jun 21
                                                2019</span>
                                        </div>
                                        <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                            <span class="material-symbols-outlined">
                                                location_on
                                            </span>
                                            <span class="line-clamp-1 hover:line-clamp-4">Bendshil- Chiknichi Wadi,
                                                Badlapur</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="group space-y-6">
                                    <img src="https://c.ndtvimg.com/eq99n43_kerala-floods-afp-650_625x300_24_August_18.jpg" alt="art cover" loading="lazy" width="1000" height="667" class="h-96 w-full rounded-3xl object-cover object-top transition-all duration-500 group-hover:rounded-xl" />
                                    <h3 class="text-3xl font-semibold text-gray-800 dark:text-white">
                                        Flood Relief
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Over 2 lakh people in the floods hit districts of Kolhapur and Sangli were
                                        completely
                                        were struggling without access to daily necessities. We took an initiative by
                                        organizing
                                        a Flood Relief Drive at our campus to collect groceries, clothes, medicines,
                                        food items.
                                        Many students and teachers of our college extended a helping hand by donating
                                        the
                                        above-mentioned items for the flood relief.
                                    </p>
                                    <div class="flex gap-6 items-center">
                                        <div class="flex gap-2 items-center text-gray-500">
                                            <span class="material-symbols-outlined">
                                                calendar_month
                                            </span>
                                            <span class="w-max block font-light text-gray-500 sm:mt-0">Jun 21
                                                2019</span>
                                        </div>
                                        <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                            <span class="material-symbols-outlined">
                                                location_on
                                            </span>
                                            <span class="line-clamp-1 hover:line-clamp-4">Kolhapur and Sangli</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--Events Conducted and Participated -->
                <section class="py-12 border-b">
                    <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                        <div class="mb-12 space-y-2 text-center">
                            <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                                Events Conducted And Participated
                            </h2>
                            <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                                The NSS Degree Unit of our college also conducted and participated
                                in number of events throughout the year
                            </p>
                        </div>
                        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <div class="group p-6 sm:p-8 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="../../assests/nss.jpg" alt="art cover" loading="lazy" width="1000" height="667" class="h-64 w-full object-cover object-top transition duration-500 group-hover:scale-105" />
                                </div>
                                <div class="mt-6 relative">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">
                                        Yog Sadhbhavna Programme
                                    </h3>
                                    <p class="mt-6 mb-8 text-gray-600 dark:text-gray-300">
                                        Voluptates harum aliquam totam, doloribus eum impedit atque!
                                        Temporibus...
                                    </p>
                                </div>
                            </div>
                            <div class="group p-6 sm:p-8 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://images.unsplash.com/photo-1491895200222-0fc4a4c35e18?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1674&q=80" alt="art cover" loading="lazy" width="1000" height="667" class="h-64 w-full object-cover object-top transition duration-500 group-hover:scale-105" />
                                </div>
                                <div class="mt-6 relative">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">
                                        Anti-Plastic Campaign
                                    </h3>
                                    <p class="mt-6 mb-8 text-gray-600 dark:text-gray-300">
                                        cloth bag collection and donation – to more than 150 vegetable
                                        vendors
                                    </p>
                                </div>
                            </div>
                            <div class="group p-6 sm:p-8 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://images.unsplash.com/photo-1620121692029-d088224ddc74?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2832&q=80" alt="art cover" loading="lazy" width="1000" height="667" class="h-64 w-full object-cover object-top transition duration-500 group-hover:scale-105" />
                                </div>
                                <div class="mt-6 relative">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">
                                        De fuga fugiat lorem ispum laboriosam expedita.
                                    </h3>
                                    <p class="mt-6 mb-8 text-gray-600 dark:text-gray-300">
                                        Voluptates harum aliquam totam, doloribus eum impedit atque!
                                        Temporibus...
                                    </p>
                                </div>
                            </div>
                            <div class="group p-6 sm:p-8 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://images.unsplash.com/photo-1620121692029-d088224ddc74?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2832&q=80" alt="art cover" loading="lazy" width="1000" height="667" class="h-64 w-full object-cover object-top transition duration-500 group-hover:scale-105" />
                                </div>
                                <div class="mt-6 relative">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">
                                        De fuga fugiat lorem ispum laboriosam expedita.
                                    </h3>
                                    <p class="mt-6 mb-8 text-gray-600 dark:text-gray-300">
                                        Voluptates harum aliquam totam, doloribus eum impedit atque!
                                        Temporibus...
                                    </p>
                                </div>
                            </div>
                            <div class="group p-6 sm:p-8 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://images.unsplash.com/photo-1620121692029-d088224ddc74?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2832&q=80" alt="art cover" loading="lazy" width="1000" height="667" class="h-64 w-full object-cover object-top transition duration-500 group-hover:scale-105" />
                                </div>
                                <div class="mt-6 relative">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">
                                        De fuga fugiat lorem ispum laboriosam expedita.
                                    </h3>
                                    <p class="mt-6 mb-8 text-gray-600 dark:text-gray-300">
                                        Voluptates harum aliquam totam, doloribus eum impedit atque!
                                        Temporibus...
                                    </p>
                                </div>
                            </div>
                            <div class="group p-6 sm:p-8 rounded-3xl bg-white border border-gray-100 dark:shadow-none dark:border-gray-700 dark:bg-gray-800 bg-opacity-50 shadow-2xl shadow-gray-600/10">
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://images.unsplash.com/photo-1620121692029-d088224ddc74?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2832&q=80" alt="art cover" loading="lazy" width="1000" height="667" class="h-64 w-full object-cover object-top transition duration-500 group-hover:scale-105" />
                                </div>
                                <div class="mt-6 relative">
                                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">
                                        De fuga fugiat lorem ispum laboriosam expedita.
                                    </h3>
                                    <p class="mt-6 mb-8 text-gray-600 dark:text-gray-300">
                                        Voluptates harum aliquam totam, doloribus eum impedit atque!
                                        Temporibus...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--Special Camp SECTION-->
                <section class="py-12 border-b">
                    <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                        <div class="mb-12 space-y-2 text-center">
                            <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                                NSS Special Camp
                            </h2>
                            <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                                Empowering communities and promoting social awareness through a residential camp
                                experience.
                            </p>
                        </div>

                        <div class="space-y-10">
                            <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-16">
                                <div class="lg:bg-gray-50 dark:lg:bg-darker lg:p-16 rounded-[4rem] space-y-6 md:flex flex-row-reverse md:gap-6 justify-center md:space-y-0 lg:items-center">
                                    <div class="md:5/12 lg:w-1/2">
                                        <img src="../../assests/nssspecial_camp.jpg" alt="image" loading="lazy" class="rounded-2xl h-96 w-full object-cover	" />
                                    </div>
                                    <div class="md:7/12 lg:w-1/2">
                                        <h2 class="text-2xl font-bold text-gray-900 md:text-3xl dark:text-white">
                                            The NSS 7 Day Residential Special Camp
                                        </h2>
                                        <div class="divide-y space-y-4 divide-gray-200 dark:divide-gray-800">
                                            <div class="mt-8 flex gap-4 md:items-center">
                                                <div class="w-12 h-12 flex gap-4 rounded-full bg-indigo-100 dark:bg-indigo-900/20">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-indigo-500 dark:text-indigo-400">
                                                        <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 01-3.476.383.39.39 0 00-.297.17l-2.755 4.133a.75.75 0 01-1.248 0l-2.755-4.133a.39.39 0 00-.297-.17 48.9 48.9 0 01-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97zM6.75 8.25a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H7.5z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="w-5/6">
                                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-indigo-300">
                                                        Construction of 2 Solid Vanrai Bandhara.</h3>
                                                </div>
                                            </div>
                                            <div class="pt-4 flex gap-4 md:items-center">
                                                <div class="w-12 h-12 flex gap-4 rounded-full bg-teal-100 dark:bg-teal-900/20">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-teal-600 dark:text-teal-400">
                                                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="w-5/6">
                                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-teal-300">
                                                        Cleanliness campaign</h3>
                                                </div>
                                            </div>
                                            <div class="pt-4 flex gap-4 md:items-center">
                                                <div class="w-12 h-12 flex gap-4 rounded-full bg-teal-100 dark:bg-teal-900/20">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-teal-600 dark:text-teal-400">
                                                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="w-5/6">
                                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-teal-300">
                                                        Organised
                                                        various sessions on Unity, Menstrual Awareness, Eradication of
                                                        Superstition and Bharud on Social Issues.</h3>
                                                </div>
                                            </div>
                                            <div class="pt-4 flex gap-4 md:items-center">
                                                <div class="w-12 h-12 flex gap-4 rounded-full bg-teal-100 dark:bg-teal-900/20">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 m-auto text-teal-600 dark:text-teal-400">
                                                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="w-5/6">
                                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-teal-300">
                                                        In 7
                                                        days, our volunteers performed 7 street plays on Cleanliness,
                                                        Gender
                                                        Equality, Unity in Diversity, Superstition, Menstrual Hygiene,
                                                        Anti-Corruption and Women Empowerment.
                                                        </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-6 mt-10">
                                            <div class="flex gap-2 items-center text-gray-500">
                                                <span class="material-symbols-outlined">
                                                    calendar_month
                                                </span>
                                                <span class="w-max block font-light text-gray-500 sm:mt-0">24 December
                                                    2019 – 30
                                                    December 2019</span>
                                            </div>
                                            <div class="flex gap-2 items-center text-gray-500 line-clamp-3">
                                                <span class="material-symbols-outlined">
                                                    location_on
                                                </span>
                                                <span class="line-clamp-1 hover:line-clamp-4">Village Bendshil –
                                                    Chiknichi Wadi,
                                                    Badlapur East</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </section>
                <!-- program officier -->
                <section class="py-12 border-b">
                    <div class="xl:container mb-28 m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                        <div class="mb-12 space-y-2 text-center">
                            <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                                Programme Officers
                            </h2>
                            <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                                Our programme officers oversee and manage various initiatives and activities within NSS,
                                ensuring effective implementation and impact.
                            </p>
                        </div>
                    </div>
                    <div class="grid gap-10 md:grid-cols-2  mx-auto">
                        <div class="group space-y-4 text-center">
                            <div class="mx-auto h-56 w-56 rotate-45 overflow-hidden rounded-[4rem] md:h-40 md:w-40 lg:h-56 lg:w-56">
                                <img class="mx-auto h-full w-full -rotate-45 scale-125 object-cover transition duration-300 group-hover:scale-[1.4]" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YXZhdGFyfGVufDB8fDB8fHww" alt="woman" loading="lazy" width="640" height="805" />
                            </div>
                            <div class="pt-4">
                                <h4 class="text-2xl text-gray-700 dark:text-white">Mr. Nikesh Kumar</h4>
                                <span class="block text-sm text-gray-500">Head Officer</span>
                            </div>
                        </div>
                        <div class="group space-y-4 text-center">
                            <div class="mx-auto h-56 w-56 rotate-45 overflow-hidden rounded-[4rem] md:h-40 md:w-40 lg:h-56 lg:w-56">
                                <img class="mx-auto h-full w-full -rotate-45 scale-125 object-cover transition duration-300 group-hover:scale-[1.4]" src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8YXZhdGFyfGVufDB8fDB8fHww" alt="man" loading="lazy" width="1000" height="667" />
                            </div>
                            <div class="pt-4">
                                <h4 class="text-2xl text-gray-700 dark:text-white">Mr. Naresh Mehta</h4>
                                <span class="block text-sm text-gray-500">Assistant Officer</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!--Image Slider-->
                <section class="py-12 min-w-full">
                    <div class="xl:container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                        <div class="mb-12 space-y-2 text-center">
                            <h2 class="text-4xl font-bold text-gray-800 md:text-5xl dark:text-white">
                                Photo Gallery
                            </h2>
                            <p class="lg:mx-auto lg:w-6/12 text-gray-600 dark:text-gray-300">
                                Explore moments from our NSS activities and special events through these snapshots.
                            </p>

                        </div>
                        <div id="default-carousel" class="relative rounded-lg overflow-hidden shadow-lg w-full" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative h-80 md:h-[40rem]" data-carousel-inner>
                                <!-- Item 1 -->
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="../../assests/nss.jpg" class="object-cover w-full h-full" alt="Slide 1" />
                                    <span class="absolute top-[80%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl font-semibold opacity-[70%] text-gray-50 md:text-3xl">Group
                                        Photo</span>
                                </div>
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="https://assets.thehansindia.com/h-upload/2021/07/25/1091268-nss-volunteers.webp" class="object-cover w-full h-full" alt="Slide 1" />
                                    <span class="absolute top-[80%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl font-semibold opacity-[70%] text-gray-50 md:text-3xl">Group
                                        Photo</span>
                                </div>
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/The_National_Service_Scheme_%28NSS%29_Marching_Contingent_passes_through_the_Rajpath%2C_on_the_occasion_of_the_68th_Republic_Day_Parade_2017%2C_in_New_Delhi_on_January_26%2C_2017.jpg" class="object-cover w-full h-full" alt="Slide 1" />
                                    <span class="absolute top-[80%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl font-semibold opacity-[70%] text-gray-50 md:text-3xl">Group
                                        Photo</span>
                                </div>
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="https://ramanujancollege.ac.in/media/images/NSS-1.original.jpg" class="object-cover w-full h-full" alt="Slide 1" />
                                    <span class="absolute top-[80%] left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl font-semibold opacity-[70%] text-gray-50 md:text-3xl">Group
                                        Photo</span>
                                </div>
                            </div>
                            <!-- Slider indicators -->
                            <div class="flex absolute bottom-5 left-1/2 z-30 -translate-x-1/2 space-x-2" data-carousel-indicators>
                                <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition"></button>
                                <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition"></button>
                                <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition"></button>
                                <button type="button" class="w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 focus:outline-none focus:bg-gray-400 transition"></button>
                            </div>
                            <!-- Slider controls -->
                            <button type="button" class="flex absolute top-1/2 left-3 z-40 items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition" data-carousel-prev>
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                    </path>
                                </svg>
                            </button>
                            <button type="button" class="flex absolute top-1/2 right-3 z-40 items-center justify-center w-10 h-10 bg-gray-200/50 rounded-full hover:bg-gray-300 focus:outline-none transition" data-carousel-next>
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </div>

                    </div>
                </section>

            </div>

            <footer class="">
                <div class="mx-auto max-w-screen-xl space-y-8 px-4 py-10 sm:px-6 lg:space-y-16 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                        <div>
                            <img class="h-16 w-auto" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOAAAADgCAMAAAAt85rTAAAAgVBMVEX///8WFhYAAAAMDAxISEg8PDwXFxcTExP8/Pzd3d3o6OgICAiGhoZMTEzU1NTy8vKnp6c2NjbOzs4rKytubm7u7u7ExMS5ubkbGxvj4+MxMTF8fHyQkJCampqwsLBdXV0iIiK/v79VVVVnZ2d/f39AQECcnJyRkZF0dHRiYmJZWVnPUtf3AAAOy0lEQVR4nO1di3aiMBCFwSZBUFRU0PrAqtX2/z9wk4BWK48kTHz07N2zu3VbMXfvZCaPycRxbsEY/z1bHcadOCXUfXKkcWd8SHxWQqQS0WacAQcVeDSBevD2URrwtsbjjSrHWehxbi5xuXqUPJpBAyjhvwRJChDsZg3UhG36X4LdS4Jz/PJzFlUEnWj3svRcbnOc4i6qYzilcGmVlHovgB83ITwipNNK+ZwQvPOPUuFk5vvOk6PX2c9lU39UgZA5pRqyHvz8EGRhMou0fO+jwKJZEmZnjoRCr9RIJ3Pg3ySSnrvw797OlvAXbkGRuDCf/P42cybZ6fuQDV5Cud9gg5RLJA0wyCa/rZTNC36eMOEXhGg0jwEelVYaxL+6F+9/ufeEuO+Ud9Fnh/Qs/Uz6EerCx+W3mLMDkpvnd/SwFqIg+oBUWiK8/8RD5mxy46VwfFH5TuAyjnMNKWx+GEYn+xzXjQJeAYy3XzIUgfynG76DHAXA92vLV4CthT0SYaQF/FxUL4teXD8JxqLYyw2yX/zTd+AWr/8GQaefh7zgW74uBHQhfHTT8BAWlHwZPN5zC83+gnwFWEpPoUK6UPli8Cc8jARzBpCHCuFIkyJu/Bl6AkwsJnFHmvCvv2TYgMWj24QIrtVCDl2CL/4io3IM83LzoxqIpSXZ8bhjOX9l+KCLF8/lpDJa+NEVmMYIyWcyXY4763DQf7ZBeiiFg5UwVvFFYvIQ/9AR68Ni3RXSbfJUCkrfSblr2QaSadOS6W/wALri7LzTKoFcxllGtauSd8VMCudtnb1YdaPBzSJGHcTexYCe2F2sZ8FnxYLW/TERJkrp3omlj4k1m9UfQsmuBY+s85Gd9mojEsQIjR05//WG6u8U/xXL8wLqFYhY0tlZa7MW2JtULnXkxMJ7U38jJ7iFMnoF4K37FCHjTWhAXUfO5TUIOoJf9Z4T4f2ZPoWZ5gSp42oTfK/hJygSyqPP4/GW9yLH1TJRbnmrOvvMQeHz8eFib0SQu99AZVMUlg9naKrgsVlAGS+WMlpaarxKtDVS8Ly+oaDhoCWJJkSj+sGJoYkqCShFhI3FReT+sndsmOCZmWikvMHNrbRvhSDzB2uA78b5q5mCSX2IuIJHui253MIffIkEl71CpDVTcKxqoQLBHlVBf7AVm9UeZInKpMXMycQ6iUEUxkjdkBXkKH8m+VR7j5GCXc0cEz6kaU9wthrPizQDAhCqLh0YKbjRsVCRhdR2LWu2OrrCLGXOFv/qqN6tjQgOdLOEvKF5uO+uZMYcJYVf82DtazzMyERDLQVdYVM7zTFb/sPd5Di8yn5JPd25tJGCtRPBcsBUV8Fu8i4cSnCVcwXxStMUDBRkzkegq6DrxYpeIV+FTN5z5a7DLdBPbTvXVVBM0le/l5mUJDwqUePKbXZvcJsLSFzpOrUJ6irIB/DvRomIFKqy4y7Q3YSx8JbkZi7GrXU8MVk311JQPL271++A+cPjiv+xAtFmtwe4WYSUeWXEg49+6dvRCU5Bt/+dUbZzVdCbTMN9HudKkPLIMJyahhlNE120yJOtCPeT6WIovWXV+D13nabQUjBan82TuO5tR2mAzKu63oqahr1ihJI/8wpEJowDLOV7DMcJygry54+yEz9KqcebpaumnPye3MRktBBmGdQ/xMx1XkBDwcFPH+ENe9tlut6GenGxihJNl/sf5apA3ADG3ZYzEfU+OBaJXoS3krfsazXjrQzlCPEiGudfEPFDpQ0ncOAPGi2+y7zlNTXxhwc94TrbTURUFZzFINO8ADrheTA4WdDriCx2crjPg/lHeftpeug1m6X4QSIW/xUiZyMUFUy4OXlie3Ml1rCK/1Pem6Jk7cqzMUW75OGT3eiUZHTbcNWeSyFdoezBNSsoPiQUm7fDQ5+diF0gGn3Kmag8BPQRrvJYUEFQyfOSs+u8B0HOZvIG2Thp2BuNJpPL5nTKg7YSOL13tL3+RhNlzmi/6CtGop+f0J4y/sCDre5Oeg2aFORhayb/0jSXgQlBYcDcdY4wt/jNlg2bMTJSkLQZdZbDdHepCcqbF5eg4KKf1bBFcKZPkIfZAysOnqK1w5qJdpuD+Q2s7AjbUnCivaxBKYHhAD0VzJaC+gTFQJcPlo6GM/cqWFPQwEQlAHoJQ4wTthQ0cDKFjny6Ei/xLPWpwkRBkWBaqi0F++ZDNQk+LVuhDLdtKZi0JOjy2TxZIOwN2yJ4aE1QHpD+ap0OZstEldMw6gGwbzl4s6XgsMV88AJErBGEbWZPlhRkOALKJGluqWvz1RlLCrZ1or8A8DYwTAS3pKDRfLcachAXGm30W1LwK1Bb1ieVOxJXoHnuwYeBpdogyByWqfkYmlI4IyjG5zSVjMgt9QCGn5H9LWwF9EFNGeL1In80TQaL9/FXb5gFF2y9sjJE+oM4OwouQbUIFFw0l7Eo6vY53c/w+N2ZZ6l3o66bTzc0GmNDQaYRBWFd7Ruj7szvb1afi93x4y2FC6RL5e1sK05GZ64E6haXW/NyN1735t54pNYVrfRBnSAB26qnFItP7Pzq6puTrhpBKwr2NMZpts9k2lCwqxXlqyVEgQ0Fl3rDGMDPCL4AOkHu2t70ZhJwtHkWz4KJ9kEz/cKqhBZMVHuua/UoHr6CTDtXiNqUEF9BhVNb95QQn6D+5jWhYO90OrqJGs3lIbTmSNEVNFpOuyy8hAxsBSPdGFFIeEDgUgpcBZnzabYYQylOL7y1A1wFmWNYDJiA4kmdxgb8BnIf1DsTcwnwEVDSkZH7oPaBgzMotEdaQhBXQfNdQQyUVqrAJYi05YJJENVEJ95DC47bVxB5wV4X9hXM9PPUrRPEVHCquJ59V4KYCq6NYwQObCtomhqDBqsE8yp0j4VVE2UOe/ilDZZNtH1mTFtYVnCtuKlrD3b74OThAloOE4YzXUzY7YN7nMyfAl7z3KgEQcmWKJaCuBMlGk+6JrA4o2+ffHdFkBo3xBZBxQIsRJwubPa2FNAIopioLGKlGCQoVbmnCo8gkoKKe54iD8bLTxnW+yR4rrNLzOl5JYlJvyCyBgd9eUqvOxJFZX+XqrgkqFXotA4oCrJIpQ4gXVy12n+vOcerXaq2Ejhhonk5lMIxz92RmSF5hojfqXwbXuoFTh/cNRGU9eOuIVhWDn8ArXQnDsGmPUHP9csztqqmICqlS9SAYqKTBrcvq+OVEWRVDG8FNwWKgv2GQnl19Y7Kh0DKBb8bwwmKgqtaglTculLdkNJROt5RQhQF61dj5N5fNcHSPW/Y9RXR1DYUBb9qCTZt/ZW8mxDlKVJT21AUnHt1Jto0Kpm2mIg0j8pRCJaVSz8jWNe+lzvXVlWGmtqGYqK1LRSlmuvfPtaoVqpNEEPB+nqxfFDSQLDFZPk+Ck7qCTYOK5NaE29JEEPB+gxfKFspucLUvBPeS8EGgg2YmiUPqRHEULA+gbLZRFc2FUQKE3UEGwpvsjbV6O4UJr7rdj6b09DWYLzzfScFP+sk8HoNTkY/RViHIIqC9Tmi9esrckr47H2QxXUz+qbbqnTOyegTxFl0qs1wovUSmufvKRHEWZMRjawMZRQqh9vsdKvc7ZuKP05Xd8s1/9Nn5Ivj4o72+0yXmPAT1aMtSipvbeRTidKrcWTpuJptMjfL4vlw3+n1PkqfewGk7bP3+jl91SIZq1oMILBcrZIk2Wym0+mo3/f9WXcyidgZyi3DcTL1x3koLVkWzbGAiiV/tKVtrA3QfW2JI87wcH1FS15mdFt51hdtaRtrfzCpjdZcXthfrQ8JgpuseqaLRhAtjWReG82IKDu6vVyPZ0kHapZynk5BIWFaR9GVhXPfB/1utzsbfW4bdgifT0Gno1D39cL5N0wBn05BeU1qE0Pi/uSzNUxxn46gI7axEXO5ns5EBb4RU0meUUE+qcDKaeajOzOCVs8uMTaZo1U6MiNoOSldljtGYmh4rNfu4SwxBH4/hbeWthocQ23sylRHP+K6mee3arc9QGGSbViWuYB/SJkNMpVi7xZQShBdQWGnfXmLRGO+1l0I2qqMF/mb1WDQpl46EkFblfHyv7Su8bND0JaCOcsnIGirOmWOJyBoU8H/BO9B8L+JvjrB/wq+OsH/Cv4n+OQE/5toK2wVZqmWCdpVcDNoxGfZyVhCvUAf91dQZZuytAgUTXsG2PetlzwyYFh6Koia7sRaL3mkj9JkU2+I9ny7CirANsE/r+CfJ/jfRG3jfgTp3yQoTZRygiLc/lWC/BOclOI+Vxl3IUhTJxYK0thepdYqWCYYxXKvK3b28u8A7XS3egvsEsxv0aN7Zys3vPBOdyvDMkFZSYsEW5H252qcLMWDZYL5GWFYFIczmtKrLcAywVAIR2FV1IOhGdaDlWGZYJ4wDb4Tnb+yWFi/DHYJ+rLn0SwSNyUVxnpnhnYJ5hnT8OUUvZFQgndJsxqsEiyK2UnfWXxQZYK8LVgkyIqCp7LSPCsS52lZIWCbsKmgdCyEyhs72Kmu1r0jhU2C8s54evacH3IwkxfWQHm+EmwRZPKsg5Tsu/gnP3/t8RH3nyAYxXnS+0/iouyFlMLHPbuhNYLOd34oQ5QKOX1WkF+KB2PnftHQCkHRx2T5AXJ5WQc7H2iHo87poHawRbDY2CKwOWvFRKgQVktcWN9t5muHYPQN+Xk82F25TNbjHyfKnUHcP9+uZhf4BIX/FIeGxC/o/WIQzYtMTw92KFdRN8KCglGY53ESAr/XYJgzyeQHCleTtbzDWLE12ATZIJVmKHxJXFJmQmTOU1lBkgI92L06TwCZoL8gxZkvUs6Pf+LHeceOAmRhMrN2o478OCyCLJolYQznx1HR/8pKnTE+hDt/pjxORef7jj3QsmNaaaen+Zj9XDb1/AQqnEiVMlMXZMSnJ5aeRZQdQCCu/nPyEF5YJwW3prYeE37o8UWXzcG13NUNqMUwxh9DWed4BXB6X77CJbazHT2dCyBuTa3TJ0E+BBPsgt3MUczw2IwzeVjzoTe5KIHKs+wc8XijPMqUZU5nyWHcidOHXnWiAOKmcWd8SPKrpUrU+wdPrvFW9N+WjgAAAABJRU5ErkJggg==" alt="">

                            <!-- <div class="text-teal-600">
                <svg
                  class="h-8"
                  viewBox="0 0 118 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M37.83 19.2047C37.2352 19.237 36.6469 19.0679 36.16 18.7247C35.9566 18.5739 35.7929 18.3758 35.6831 18.1476C35.5733 17.9193 35.5208 17.6678 35.53 17.4147V8.1447C35.5252 8.1055 35.5293 8.0656 35.5422 8.0282C35.555 7.9908 35.5762 7.9569 35.6042 7.9289C35.6322 7.9009 35.6661 7.8797 35.7035 7.8669C35.7409 7.854 35.7808 7.8499 35.82 7.8547H37.5C37.69 7.8547 37.78 7.9547 37.78 8.1447V16.6947C37.78 17.0747 37.95 17.2647 38.3 17.2647C38.4484 17.2708 38.5968 17.254 38.74 17.2147C38.94 17.2147 39.05 17.2747 39.06 17.4547L39.21 18.7047C39.2172 18.7412 39.2165 18.7787 39.208 18.8149C39.1995 18.851 39.1833 18.885 39.1605 18.9143C39.1378 18.9437 39.109 18.9679 39.0762 18.9852C39.0433 19.0025 39.0071 19.0126 38.97 19.0147C38.602 19.1363 38.2175 19.2004 37.83 19.2047Z"
                    fill="currentColor"
                  />
                  <path
                    d="M47.28 18.1347C46.4359 18.8322 45.375 19.2137 44.28 19.2137C43.185 19.2137 42.1242 18.8322 41.28 18.1347C40.5381 17.3857 40.1218 16.374 40.1218 15.3197C40.1218 14.2654 40.5381 13.2537 41.28 12.5047C42.1258 11.8108 43.186 11.4316 44.28 11.4316C45.374 11.4316 46.4342 11.8108 47.28 12.5047C48.0049 13.2606 48.4096 14.2674 48.4096 15.3147C48.4096 16.362 48.0049 17.3688 47.28 18.1247V18.1347ZM42.86 16.8147C43.2518 17.1696 43.7614 17.3661 44.29 17.3661C44.8186 17.3661 45.3283 17.1696 45.72 16.8147C46.0746 16.4071 46.2698 15.885 46.2698 15.3447C46.2698 14.8045 46.0746 14.2824 45.72 13.8747C45.3283 13.5199 44.8186 13.3233 44.29 13.3233C43.7614 13.3233 43.2518 13.5199 42.86 13.8747C42.5055 14.2824 42.3102 14.8045 42.3102 15.3447C42.3102 15.885 42.5055 16.4071 42.86 16.8147Z"
                    fill="currentColor"
                  />
                  <path
                    d="M57.66 11.6847C57.85 11.6847 57.94 11.7847 57.94 11.9747V19.1447C57.9575 19.6287 57.8669 20.1104 57.6749 20.5549C57.4829 20.9995 57.1943 21.3957 56.83 21.7147C56.0214 22.4042 54.9816 22.7615 53.92 22.7147C52.9612 22.7484 52.0151 22.4866 51.21 21.9647C50.8662 21.739 50.5725 21.4449 50.3472 21.1009C50.1218 20.7568 49.9696 20.3701 49.9 19.9647C49.9 19.7647 49.9 19.6747 50.17 19.6747H51.85C51.9213 19.6771 51.9905 19.7002 52.049 19.741C52.1076 19.7818 52.1531 19.8386 52.18 19.9047C52.289 20.2084 52.5062 20.4613 52.79 20.6147C53.1359 20.7932 53.5209 20.8826 53.91 20.8747C54.1448 20.8876 54.3798 20.8535 54.6013 20.7745C54.8228 20.6956 55.0263 20.5732 55.2 20.4147C55.3587 20.2489 55.4821 20.0526 55.5629 19.8378C55.6437 19.623 55.6801 19.394 55.67 19.1647V18.5347C55.0685 18.9771 54.3364 19.2059 53.59 19.1847C53.0676 19.2037 52.5468 19.117 52.0587 18.9297C51.5707 18.7423 51.1256 18.4584 50.75 18.0947C50.0291 17.3489 49.6261 16.3521 49.6261 15.3147C49.6261 14.2774 50.0291 13.2806 50.75 12.5347C51.1274 12.1743 51.5731 11.8931 52.0608 11.7076C52.5486 11.5221 53.0685 11.4361 53.59 11.4547C54.358 11.4344 55.1098 11.678 55.72 12.1447V11.9847C55.7154 11.9464 55.7194 11.9075 55.7317 11.8709C55.744 11.8344 55.7643 11.801 55.7911 11.7732C55.8179 11.7454 55.8506 11.724 55.8867 11.7104C55.9229 11.6968 55.9616 11.6915 56 11.6947L57.66 11.6847ZM53.78 17.4047C54.0376 17.4127 54.2939 17.364 54.5306 17.262C54.7673 17.1601 54.9788 17.0074 55.15 16.8147C55.4825 16.3854 55.6629 15.8577 55.6629 15.3147C55.6629 14.7717 55.4825 14.2441 55.15 13.8147C54.9794 13.6247 54.7692 13.4742 54.5343 13.374C54.2993 13.2738 54.0453 13.2263 53.79 13.2347C53.5294 13.2265 53.2702 13.275 53.0302 13.3769C52.7902 13.4788 52.5752 13.6316 52.4 13.8247C52.0317 14.2354 51.838 14.7735 51.86 15.3247C51.842 15.8705 52.0314 16.4029 52.39 16.8147C52.5656 17.0073 52.7807 17.1598 53.0206 17.2616C53.2605 17.3634 53.5195 17.4122 53.78 17.4047Z"
                    fill="currentColor"
                  />
                  <path
                    d="M66.57 18.1347C65.7242 18.8286 64.664 19.2078 63.57 19.2078C62.476 19.2078 61.4158 18.8286 60.57 18.1347C59.8445 17.3771 59.4395 16.3687 59.4395 15.3197C59.4395 14.2708 59.8445 13.2623 60.57 12.5047C61.4166 11.8126 62.4765 11.4345 63.57 11.4345C64.6635 11.4345 65.7234 11.8126 66.57 12.5047C67.2949 13.2606 67.6996 14.2674 67.6996 15.3147C67.6996 16.362 67.2949 17.3688 66.57 18.1247V18.1347ZM62.14 16.8147C62.3317 16.9971 62.5577 17.1396 62.8049 17.234C63.0521 17.3284 63.3155 17.3729 63.58 17.3647C63.8428 17.3715 64.1044 17.3265 64.3498 17.2321C64.5952 17.1377 64.8195 16.9959 65.01 16.8147C65.3588 16.4043 65.5503 15.8833 65.5503 15.3447C65.5503 14.8061 65.3588 14.2851 65.01 13.8747C64.8195 13.6936 64.5952 13.5517 64.3498 13.4574C64.1044 13.363 63.8428 13.3179 63.58 13.3247C63.3155 13.3166 63.0521 13.361 62.8049 13.4554C62.5577 13.5498 62.3317 13.6924 62.14 13.8747C61.7913 14.2851 61.5998 14.8061 61.5998 15.3447C61.5998 15.8833 61.7913 16.4043 62.14 16.8147Z"
                    fill="currentColor"
                  />
                  <path
                    d="M71.31 9.9847C71.0457 10.2161 70.7063 10.3436 70.355 10.3436C70.0037 10.3436 69.6644 10.2161 69.4 9.9847C69.2802 9.8716 69.1847 9.7352 69.1194 9.5839C69.0542 9.4326 69.0205 9.2695 69.0205 9.1047C69.0205 8.9399 69.0542 8.7769 69.1194 8.6255C69.1847 8.4742 69.2802 8.3378 69.4 8.2247C69.6671 7.9991 70.0054 7.8754 70.355 7.8754C70.7046 7.8754 71.0429 7.9991 71.31 8.2247C71.4299 8.3378 71.5254 8.4742 71.5906 8.6255C71.6559 8.7769 71.6895 8.9399 71.6895 9.1047C71.6895 9.2695 71.6559 9.4326 71.5906 9.5839C71.5254 9.7352 71.4299 9.8716 71.31 9.9847ZM71.52 19.2047C70.9256 19.2339 70.3383 19.0651 69.85 18.7247C69.6497 18.5717 69.4888 18.3729 69.381 18.145C69.2731 17.9171 69.2213 17.6667 69.23 17.4147V11.9747C69.2252 11.9355 69.2293 11.8956 69.2422 11.8582C69.255 11.8208 69.2762 11.7869 69.3042 11.7589C69.3322 11.7309 69.3661 11.7097 69.4035 11.6969C69.4409 11.684 69.4808 11.6799 69.52 11.6847H71.2C71.39 11.6847 71.48 11.7847 71.48 11.9747V16.6947C71.48 17.0747 71.65 17.2647 71.99 17.2647C72.1417 17.2702 72.2933 17.2533 72.44 17.2147C72.64 17.2147 72.75 17.2747 72.76 17.4547L72.91 18.7047C72.9172 18.7412 72.9165 18.7787 72.908 18.8149C72.8995 18.851 72.8833 18.885 72.8605 18.9143C72.8378 18.9437 72.809 18.9679 72.7762 18.9852C72.7433 19.0025 72.7071 19.0126 72.67 19.0147C72.2988 19.137 71.9109 19.2011 71.52 19.2047Z"
                    fill="currentColor"
                  />
                  <path
                    d="M79.09 11.4447C79.6148 11.424 80.1383 11.5089 80.6296 11.6944C81.1209 11.88 81.57 12.1623 81.95 12.5247C82.6572 13.2837 83.0504 14.2824 83.0504 15.3197C83.0504 16.357 82.6572 17.3558 81.95 18.1147C81.5718 18.4804 81.1233 18.7655 80.6317 18.9528C80.1401 19.1402 79.6157 19.2259 79.09 19.2047C78.3412 19.2214 77.6073 18.9932 77 18.5547V22.1647C77 22.3547 76.9 22.4447 76.71 22.4447H75.03C74.9917 22.4519 74.9522 22.4496 74.9149 22.4381C74.8777 22.4265 74.8438 22.4061 74.8162 22.3785C74.7887 22.3509 74.7682 22.3171 74.7567 22.2798C74.7451 22.2426 74.7429 22.2031 74.75 22.1647V13.9647C74.7618 13.8845 74.7546 13.8027 74.7292 13.7257C74.7037 13.6488 74.6605 13.5788 74.6032 13.5215C74.5459 13.4642 74.476 13.4211 74.399 13.3956C74.3221 13.3701 74.2402 13.363 74.16 13.3747H73.83C73.61 13.3747 73.5 13.2947 73.5 13.1347V11.9547C73.4948 11.8817 73.5148 11.8091 73.5567 11.7491C73.5985 11.689 73.6597 11.6451 73.73 11.6247C74.0759 11.499 74.442 11.438 74.81 11.4447C75.177 11.4122 75.5453 11.4901 75.8678 11.6682C76.1902 11.8464 76.4522 12.1168 76.62 12.4447C76.9421 12.1189 77.3273 11.8622 77.752 11.6902C78.1767 11.5183 78.632 11.4347 79.09 11.4447ZM77.53 16.8147C77.7083 17.0011 77.9225 17.1494 78.1597 17.2507C78.3969 17.352 78.6521 17.4042 78.91 17.4042C79.1679 17.4042 79.4232 17.352 79.6603 17.2507C79.8975 17.1494 80.1117 17.0011 80.29 16.8147C80.6656 16.3958 80.8629 15.8469 80.84 15.2847C80.8662 14.7221 80.6684 14.1719 80.29 13.7547C80.1117 13.5684 79.8975 13.4201 79.6603 13.3188C79.4232 13.2174 79.1679 13.1652 78.91 13.1652C78.6521 13.1652 78.3969 13.2174 78.1597 13.3188C77.9225 13.4201 77.7083 13.5684 77.53 13.7547C77.1662 14.1793 76.9768 14.726 77 15.2847C76.9797 15.843 77.1688 16.3887 77.53 16.8147Z"
                    fill="currentColor"
                  />
                  <path
                    d="M87.77 19.2047C86.8723 19.2416 85.9822 19.0269 85.2 18.5847C84.8862 18.3957 84.619 18.1384 84.4181 17.832C84.2173 17.5256 84.0881 17.1779 84.04 16.8147C84.04 16.6147 84.11 16.5147 84.33 16.5147H85.8C85.8699 16.5175 85.9378 16.5394 85.996 16.5783C86.0542 16.6171 86.1006 16.6712 86.13 16.7347C86.34 17.2747 86.89 17.5447 87.77 17.5447C88.077 17.5588 88.3826 17.4969 88.66 17.3647C88.7558 17.3215 88.8379 17.2531 88.8978 17.1668C88.9577 17.0805 88.993 16.9795 89 16.8747C89 16.6147 88.84 16.4347 88.52 16.3147C88.1405 16.1884 87.7481 16.1045 87.35 16.0647C86.8785 16.0113 86.4109 15.9278 85.95 15.8147C85.5018 15.7133 85.0943 15.4799 84.78 15.1447C84.5949 14.9169 84.4587 14.6534 84.3797 14.3707C84.3008 14.088 84.2809 13.792 84.3212 13.5013C84.3616 13.2105 84.4613 12.9311 84.6142 12.6806C84.7671 12.43 84.9699 12.2136 85.21 12.0447C85.9308 11.5856 86.7765 11.3619 87.63 11.4047C88.4564 11.3768 89.274 11.5812 89.99 11.9947C90.2786 12.1582 90.527 12.3839 90.7173 12.6555C90.9076 12.9271 91.0349 13.2377 91.09 13.5647C91.09 13.7647 91 13.8647 90.82 13.8647H89.34C89.2777 13.8684 89.2157 13.8532 89.1622 13.8211C89.1087 13.789 89.0661 13.7414 89.04 13.6847C88.9411 13.4479 88.7549 13.2581 88.52 13.1547C88.255 13.0161 87.959 12.9472 87.66 12.9547C87.3669 12.9388 87.0745 12.9973 86.81 13.1247C86.7168 13.1607 86.6366 13.2237 86.5795 13.3057C86.5225 13.3877 86.4913 13.4849 86.49 13.5847C86.4964 13.7215 86.5465 13.8526 86.6329 13.9588C86.7193 14.065 86.8374 14.1406 86.97 14.1747C87.354 14.3195 87.7533 14.4201 88.16 14.4747C88.6277 14.5363 89.0917 14.6231 89.55 14.7347C89.9982 14.8362 90.4057 15.0695 90.72 15.4047C90.8882 15.5894 91.018 15.8055 91.1021 16.0407C91.1862 16.2758 91.2229 16.5253 91.21 16.7747C91.2186 17.1204 91.1375 17.4624 90.9745 17.7674C90.8115 18.0723 90.5722 18.3298 90.28 18.5147C89.5329 18.9944 88.6574 19.235 87.77 19.2047Z"
                    fill="currentColor"
                  />
                  <path
                    d="M101.78 18.7047C101.786 18.7402 101.784 18.7765 101.776 18.8114C101.767 18.8464 101.752 18.8792 101.73 18.9081C101.709 18.937 101.682 18.9613 101.651 18.9796C101.62 18.9979 101.586 19.0098 101.55 19.0147C101.185 19.1339 100.804 19.198 100.42 19.2047C100.04 19.2441 99.656 19.1847 99.306 19.0323C98.955 18.8799 98.65 18.6396 98.42 18.3347C97.714 18.942 96.8 19.2536 95.87 19.2047C95.438 19.2246 95.007 19.1539 94.604 18.9972C94.201 18.8405 93.835 18.6012 93.53 18.2947C93.227 17.9736 92.9922 17.5946 92.8392 17.1805C92.6863 16.7664 92.6186 16.3257 92.64 15.8847V11.9747C92.64 11.7847 92.73 11.6847 92.92 11.6847H94.6C94.79 11.6847 94.88 11.7847 94.88 11.9747V15.5847C94.862 16.0345 95.015 16.4743 95.31 16.8147C95.457 16.9707 95.636 17.0933 95.834 17.1744C96.032 17.2555 96.246 17.2931 96.46 17.2847C96.679 17.2943 96.898 17.2604 97.104 17.1848C97.31 17.1093 97.499 16.9937 97.66 16.8447C97.812 16.6877 97.931 16.5011 98.008 16.2964C98.086 16.0917 98.12 15.8733 98.11 15.6547V11.9747C98.11 11.7847 98.2 11.6847 98.39 11.6847H100.09C100.28 11.6847 100.37 11.7847 100.37 11.9747V16.6847C100.37 17.0747 100.54 17.2647 100.87 17.2647C101.025 17.2707 101.18 17.2539 101.33 17.2147C101.368 17.2041 101.408 17.2022 101.446 17.2092C101.485 17.2161 101.521 17.2317 101.553 17.2548C101.585 17.2779 101.611 17.3079 101.63 17.3425C101.648 17.3771 101.658 17.4155 101.66 17.4547L101.78 18.7047Z"
                    fill="currentColor"
                  />
                  <path
                    d="M117.67 18.7047C117.679 18.7405 117.68 18.7779 117.673 18.8141C117.665 18.8502 117.65 18.8844 117.628 18.914C117.606 18.9436 117.578 18.968 117.545 18.9854C117.513 19.0029 117.477 19.0129 117.44 19.0147C117.068 19.1356 116.681 19.1997 116.29 19.2047C115.695 19.2354 115.108 19.0665 114.62 18.7247C114.409 18.5783 114.238 18.3822 114.121 18.1537C114.004 17.9252 113.945 17.6713 113.95 17.4147V15.0647C113.971 14.6163 113.821 14.1766 113.53 13.8347C113.39 13.6784 113.216 13.5552 113.023 13.4739C112.829 13.3927 112.62 13.3554 112.41 13.3647C112.221 13.3576 112.033 13.3935 111.859 13.4697C111.686 13.5459 111.533 13.6605 111.41 13.8047C111.146 14.1398 111.011 14.5586 111.03 14.9847V18.6747C111.03 18.8647 110.94 18.9647 110.75 18.9647H109.06C109.021 18.9696 108.981 18.9654 108.944 18.9526C108.906 18.9397 108.872 18.9185 108.844 18.8905C108.816 18.8626 108.795 18.8286 108.782 18.7912C108.769 18.7538 108.765 18.714 108.77 18.6747V15.0647C108.792 14.6212 108.653 14.1846 108.38 13.8347C108.258 13.6877 108.105 13.5694 107.932 13.4882C107.76 13.407 107.571 13.3648 107.38 13.3647C107.176 13.3565 106.973 13.3914 106.783 13.4673C106.593 13.5431 106.422 13.6581 106.28 13.8047C105.994 14.1291 105.847 14.5529 105.87 14.9847V18.6747C105.875 18.714 105.871 18.7538 105.858 18.7912C105.845 18.8286 105.824 18.8626 105.796 18.8905C105.768 18.9185 105.734 18.9397 105.697 18.9526C105.659 18.9654 105.619 18.9696 105.58 18.9647H103.95C103.76 18.9647 103.67 18.8647 103.67 18.6747V13.9647C103.682 13.8845 103.675 13.8027 103.649 13.7257C103.624 13.6488 103.581 13.5788 103.523 13.5215C103.466 13.4642 103.396 13.4211 103.319 13.3956C103.242 13.3701 103.16 13.363 103.08 13.3747H102.75C102.53 13.3747 102.42 13.2947 102.42 13.1347V11.9547C102.415 11.8817 102.435 11.8091 102.477 11.7491C102.519 11.689 102.58 11.6451 102.65 11.6247C102.996 11.499 103.362 11.438 103.73 11.4447C104.083 11.4146 104.438 11.485 104.753 11.6478C105.068 11.8106 105.33 12.0591 105.51 12.3647C105.847 12.045 106.247 11.7982 106.684 11.6399C107.121 11.4816 107.586 11.4152 108.05 11.4447C108.501 11.4227 108.95 11.5072 109.362 11.6914C109.774 11.8756 110.136 12.1542 110.42 12.5047C110.751 12.145 111.158 11.8634 111.611 11.68C112.064 11.4967 112.552 11.4164 113.04 11.4447C113.476 11.4243 113.912 11.4946 114.32 11.6513C114.728 11.8079 115.099 12.0474 115.41 12.3547C115.714 12.6752 115.949 13.0541 116.102 13.4684C116.255 13.8826 116.323 14.3237 116.3 14.7647V16.6947C116.3 17.0747 116.47 17.2647 116.79 17.2647C116.945 17.2719 117.1 17.2551 117.25 17.2147C117.457 17.2147 117.567 17.2947 117.58 17.4547L117.67 18.7047Z"
                    fill="currentColor"
                  />
                  <path
                    d="M0.41 10.3847C1.14777 7.4194 2.85643 4.7861 5.2639 2.90424C7.6714 1.02234 10.6393 0 13.695 0C16.7507 0 19.7186 1.02234 22.1261 2.90424C24.5336 4.7861 26.2422 7.4194 26.98 10.3847H25.78C23.7557 10.3549 21.7729 10.9599 20.11 12.1147C20.014 12.1842 19.9138 12.2477 19.81 12.3047H19.67C19.5662 12.2477 19.466 12.1842 19.37 12.1147C17.6924 10.9866 15.7166 10.3841 13.695 10.3841C11.6734 10.3841 9.6976 10.9866 8.02 12.1147C7.924 12.1842 7.8238 12.2477 7.72 12.3047H7.58C7.4762 12.2477 7.376 12.1842 7.28 12.1147C5.6171 10.9599 3.6343 10.3549 1.61 10.3847H0.41ZM23.62 16.6547C24.236 16.175 24.9995 15.924 25.78 15.9447H27.39V12.7347H25.78C24.4052 12.7181 23.0619 13.146 21.95 13.9547C21.3243 14.416 20.5674 14.6649 19.79 14.6649C19.0126 14.6649 18.2557 14.416 17.63 13.9547C16.4899 13.1611 15.1341 12.7356 13.745 12.7356C12.3559 12.7356 11.0001 13.1611 9.86 13.9547C9.2343 14.416 8.4774 14.6649 7.7 14.6649C6.9226 14.6649 6.1657 14.416 5.54 13.9547C4.4144 13.1356 3.0518 12.7072 1.66 12.7347H0V15.9447H1.61C2.39051 15.924 3.154 16.175 3.77 16.6547C4.908 17.4489 6.2623 17.8747 7.65 17.8747C9.0377 17.8747 10.392 17.4489 11.53 16.6547C12.1468 16.1765 12.9097 15.9257 13.69 15.9447C14.4708 15.9223 15.2348 16.1735 15.85 16.6547C16.9901 17.4484 18.3459 17.8738 19.735 17.8738C21.1241 17.8738 22.4799 17.4484 23.62 16.6547ZM23.62 22.3947C24.236 21.915 24.9995 21.664 25.78 21.6847H27.39V18.4747H25.78C24.4052 18.4581 23.0619 18.886 21.95 19.6947C21.3243 20.156 20.5674 20.4049 19.79 20.4049C19.0126 20.4049 18.2557 20.156 17.63 19.6947C16.4899 18.9011 15.1341 18.4757 13.745 18.4757C12.3559 18.4757 11.0001 18.9011 9.86 19.6947C9.2343 20.156 8.4774 20.4049 7.7 20.4049C6.9226 20.4049 6.1657 20.156 5.54 19.6947C4.4144 18.8757 3.0518 18.4472 1.66 18.4747H0V21.6847H1.61C2.39051 21.664 3.154 21.915 3.77 22.3947C4.908 23.1889 6.2623 23.6147 7.65 23.6147C9.0377 23.6147 10.392 23.1889 11.53 22.3947C12.1468 21.9165 12.9097 21.6657 13.69 21.6847C14.4708 21.6623 15.2348 21.9135 15.85 22.3947C16.9901 23.1884 18.3459 23.6138 19.735 23.6138C21.1241 23.6138 22.4799 23.1884 23.62 22.3947Z"
                    fill="currentColor"
                  />
                </svg>
              </div> -->

                            <p class="mt-4 max-w-xs text-gray-500">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Esse non
                                cupiditate quae nam molestias.
                            </p>

                            <ul class="mt-8 flex gap-6">
                                <li>
                                    <a href="https://www.facebook.com/profile.php?id=100064226286644&ti=as" rel="noreferrer" target="_blank" class="text-gray-700 transition hover:opacity-75">
                                        <span class="sr-only">Facebook</span>

                                        <svg class="h-8 w-8" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
                                            <path fill="#1877F2" d="M15 8a7 7 0 00-7-7 7 7 0 00-1.094 13.915v-4.892H5.13V8h1.777V6.458c0-1.754 1.045-2.724 2.644-2.724.766 0 1.567.137 1.567.137v1.723h-.883c-.87 0-1.14.54-1.14 1.093V8h1.941l-.31 2.023H9.094v4.892A7.001 7.001 0 0015 8z" />
                                            <path fill="#ffffff" d="M10.725 10.023L11.035 8H9.094V6.687c0-.553.27-1.093 1.14-1.093h.883V3.87s-.801-.137-1.567-.137c-1.6 0-2.644.97-2.644 2.724V8H5.13v2.023h1.777v4.892a7.037 7.037 0 002.188 0v-4.892h1.63z" />
                                        </svg>

                                    </a>
                                </li>

                                <li>
                                    <a href="https://www.instagram.com/" rel="noreferrer" target="_blank" class="text-gray-700 transition hover:opacity-75">
                                        <span class="sr-only">Instagram</span>

                                        <svg class="h-8 w-8" viewBox="0 0 3364.7 3364.7" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <radialGradient id="0" cx="217.76" cy="3290.99" r="4271.92" gradientUnits="userSpaceOnUse">
                                                    <stop offset=".09" stop-color="#fa8f21" />
                                                    <stop offset=".78" stop-color="#d82d7e" />
                                                </radialGradient>
                                                <radialGradient id="1" cx="2330.61" cy="3182.95" r="3759.33" gradientUnits="userSpaceOnUse">
                                                    <stop offset=".64" stop-color="#8c3aaa" stop-opacity="0" />
                                                    <stop offset="1" stop-color="#8c3aaa" />
                                                </radialGradient>
                                            </defs>
                                            <path d="M853.2,3352.8c-200.1-9.1-308.8-42.4-381.1-70.6-95.8-37.3-164.1-81.7-236-153.5S119.7,2988.6,82.6,2892.8c-28.2-72.3-61.5-181-70.6-381.1C2,2295.4,0,2230.5,0,1682.5s2.2-612.8,11.9-829.3C21,653.1,54.5,544.6,82.5,472.1,119.8,376.3,164.3,308,236,236c71.8-71.8,140.1-116.4,236-153.5C544.3,54.3,653,21,853.1,11.9,1069.5,2,1134.5,0,1682.3,0c548,0,612.8,2.2,829.3,11.9,200.1,9.1,308.6,42.6,381.1,70.6,95.8,37.1,164.1,81.7,236,153.5s116.2,140.2,153.5,236c28.2,72.3,61.5,181,70.6,381.1,9.9,216.5,11.9,281.3,11.9,829.3,0,547.8-2,612.8-11.9,829.3-9.1,200.1-42.6,308.8-70.6,381.1-37.3,95.8-81.7,164.1-153.5,235.9s-140.2,116.2-236,153.5c-72.3,28.2-181,61.5-381.1,70.6-216.3,9.9-281.3,11.9-829.3,11.9-547.8,0-612.8-1.9-829.1-11.9" fill="url(#0)" />
                                            <path d="M853.2,3352.8c-200.1-9.1-308.8-42.4-381.1-70.6-95.8-37.3-164.1-81.7-236-153.5S119.7,2988.6,82.6,2892.8c-28.2-72.3-61.5-181-70.6-381.1C2,2295.4,0,2230.5,0,1682.5s2.2-612.8,11.9-829.3C21,653.1,54.5,544.6,82.5,472.1,119.8,376.3,164.3,308,236,236c71.8-71.8,140.1-116.4,236-153.5C544.3,54.3,653,21,853.1,11.9,1069.5,2,1134.5,0,1682.3,0c548,0,612.8,2.2,829.3,11.9,200.1,9.1,308.6,42.6,381.1,70.6,95.8,37.1,164.1,81.7,236,153.5s116.2,140.2,153.5,236c28.2,72.3,61.5,181,70.6,381.1,9.9,216.5,11.9,281.3,11.9,829.3,0,547.8-2,612.8-11.9,829.3-9.1,200.1-42.6,308.8-70.6,381.1-37.3,95.8-81.7,164.1-153.5,235.9s-140.2,116.2-236,153.5c-72.3,28.2-181,61.5-381.1,70.6-216.3,9.9-281.3,11.9-829.3,11.9-547.8,0-612.8-1.9-829.1-11.9" fill="url(#1)" />
                                            <path d="M1269.25,1689.52c0-230.11,186.49-416.7,416.6-416.7s416.7,186.59,416.7,416.7-186.59,416.7-416.7,416.7-416.6-186.59-416.6-416.7m-225.26,0c0,354.5,287.36,641.86,641.86,641.86s641.86-287.36,641.86-641.86-287.36-641.86-641.86-641.86S1044,1335,1044,1689.52m1159.13-667.31a150,150,0,1,0,150.06-149.94h-0.06a150.07,150.07,0,0,0-150,149.94M1180.85,2707c-121.87-5.55-188.11-25.85-232.13-43-58.36-22.72-100-49.78-143.78-93.5s-70.88-85.32-93.5-143.68c-17.16-44-37.46-110.26-43-232.13-6.06-131.76-7.27-171.34-7.27-505.15s1.31-373.28,7.27-505.15c5.55-121.87,26-188,43-232.13,22.72-58.36,49.78-100,93.5-143.78s85.32-70.88,143.78-93.5c44-17.16,110.26-37.46,232.13-43,131.76-6.06,171.34-7.27,505-7.27S2059.13,666,2191,672c121.87,5.55,188,26,232.13,43,58.36,22.62,100,49.78,143.78,93.5s70.78,85.42,93.5,143.78c17.16,44,37.46,110.26,43,232.13,6.06,131.87,7.27,171.34,7.27,505.15s-1.21,373.28-7.27,505.15c-5.55,121.87-25.95,188.11-43,232.13-22.72,58.36-49.78,100-93.5,143.68s-85.42,70.78-143.78,93.5c-44,17.16-110.26,37.46-232.13,43-131.76,6.06-171.34,7.27-505.15,7.27s-373.28-1.21-505-7.27M1170.5,447.09c-133.07,6.06-224,27.16-303.41,58.06-82.19,31.91-151.86,74.72-221.43,144.18S533.39,788.47,501.48,870.76c-30.9,79.46-52,170.34-58.06,303.41-6.16,133.28-7.57,175.89-7.57,515.35s1.41,382.07,7.57,515.35c6.06,133.08,27.16,223.95,58.06,303.41,31.91,82.19,74.62,152,144.18,221.43s139.14,112.18,221.43,144.18c79.56,30.9,170.34,52,303.41,58.06,133.35,6.06,175.89,7.57,515.35,7.57s382.07-1.41,515.35-7.57c133.08-6.06,223.95-27.16,303.41-58.06,82.19-32,151.86-74.72,221.43-144.18s112.18-139.24,144.18-221.43c30.9-79.46,52.1-170.34,58.06-303.41,6.06-133.38,7.47-175.89,7.47-515.35s-1.41-382.07-7.47-515.35c-6.06-133.08-27.16-224-58.06-303.41-32-82.19-74.72-151.86-144.18-221.43S2586.8,537.06,2504.71,505.15c-79.56-30.9-170.44-52.1-303.41-58.06C2068,441,2025.41,439.52,1686,439.52s-382.1,1.41-515.45,7.57" fill="#ffffff" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a href="https://www.linkedin.com/school/vazecollegeautonomous/" rel="noreferrer" target="_blank" class="text-gray-700 transition hover:opacity-75">
                                        <span class="sr-only">Linkedin</span>

                                        <svg class="h-8 w-8" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
                                            <path fill="#0A66C2" d="M12.225 12.225h-1.778V9.44c0-.664-.012-1.519-.925-1.519-.926 0-1.068.724-1.068 1.47v2.834H6.676V6.498h1.707v.783h.024c.348-.594.996-.95 1.684-.925 1.802 0 2.135 1.185 2.135 2.728l-.001 3.14zM4.67 5.715a1.037 1.037 0 01-1.032-1.031c0-.566.466-1.032 1.032-1.032.566 0 1.031.466 1.032 1.032 0 .566-.466 1.032-1.032 1.032zm.889 6.51h-1.78V6.498h1.78v5.727zM13.11 2H2.885A.88.88 0 002 2.866v10.268a.88.88 0 00.885.866h10.226a.882.882 0 00.889-.866V2.865a.88.88 0 00-.889-.864z" />
                                        </svg>
                                    </a>
                                </li>

                                <li>
                                    <a href="https://www.youtube.com/channel/UC8lT0q9Defrg5pKA2-BhVPQ" rel="noreferrer" target="_blank" class="text-gray-700 transition hover:opacity-75">
                                        <span class="sr-only">Youtube</span>

                                        <svg class="h-8 w-8" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
                                            <path fill="red" d="M14.712 4.633a1.754 1.754 0 00-1.234-1.234C12.382 3.11 8 3.11 8 3.11s-4.382 0-5.478.289c-.6.161-1.072.634-1.234 1.234C1 5.728 1 8 1 8s0 2.283.288 3.367c.162.6.635 1.073 1.234 1.234C3.618 12.89 8 12.89 8 12.89s4.382 0 5.478-.289a1.754 1.754 0 001.234-1.234C15 10.272 15 8 15 8s0-2.272-.288-3.367z" />
                                            <path fill="#ffffff" d="M6.593 10.11l3.644-2.098-3.644-2.11v4.208z" />
                                        </svg>
                                    </a>
                                </li>


                            </ul>
                        </div>

                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:col-span-2 lg:grid-cols-4">
                            <div>
                                <p class="font-medium text-gray-900">Services</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            1on1 Coaching
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Company Review
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Accounts Review
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            HR Consulting
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            SEO Optimisation
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <p class="font-medium text-gray-900">Company</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            About
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Meet the Team
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Accounts Review
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <p class="font-medium text-gray-900">Helpful Links</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Contact
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            FAQs
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Live Chat
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <p class="font-medium text-gray-900">Legal</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Accessibility
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Returns Policy
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Refund Policy
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-gray-700 transition hover:opacity-75">
                                            Hiring Statistics
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-center text-gray-500">
                        &copy; 2015. V.G. Vaze College. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>

        <div class="nav-container fixed top-0 w-full min-h-full bg-black text-white flex flex-col justify-center items-center">
            <div class="justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

            </div>
            <!-- w-2/3 -->
            <div class="d-flex  flex w-3/4 justify-between">
                <!-- <div class="flex flex-col justify-between items-start">
                <div class="font-light mt-[-0.2em] uppercase text-xl">
                  KETS <br />
                  VAZE
                </div>
                <div class="flex flex-col">
                  <a class="font-normal text-xs" href="">Behance</a>
                  <a class="font-normal text-xs" href="">Facebook</a>
                  <a class="font-normal text-xs" href="">Instagram</a>
                  <a class="font-normal text-xs" href="">Github</a>
                  <a class="font-normal text-xs" href="">Youtube</a>
                </div>
              </div> -->
                <div>
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:md:text-3xl text-xl text-xl font-light hover:text-slate-400" href="">Home</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:md:text-3xl text-xl text-xl font-light hover:text-slate-400" href="">Contact Us</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center justify-between">
                                About us
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>

                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                Academics
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                Student Corner
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                Our campus
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Admissions</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Research</a>
                        <div class="nav-item-wrapper"></div>
                    </div>
                </div>
                <div class="hidden">
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:md:text-3xl text-xl text-xl font-light hover:text-slate-400" href="">Home</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:md:text-3xl text-xl text-xl font-light hover:text-slate-400" href="">Contact Us</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center justify-between">
                                About us
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>

                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                Academics
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                Student Corner
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                Our campus
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Admissions</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Research</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                More
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>
                </div>
                <div>
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Alumni</a>
                        <!-- <button id="animateButton" class="mb-4 px-4 py-2 bg-blue-500 text-white rounded z-10 hover:bg-blue-600">
                    Click Me
                </button> -->
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Faculty</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Committees</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">Procedures</a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                NAAC
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>
                    <div class="nav-link py-2 relative">
                        <a class="relative top-[60px] md:text-3xl text-xl font-light hover:text-slate-400" href="">
                            <div class="flex flex-row items-center gap-4 justify-between">
                                More
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </a>
                        <div class="nav-item-wrapper"></div>
                    </div>

                </div>
            </div>

            <!-- Nav Footer  -->
            <div class="nav-footer absolute w-full bottom-0 py-[2em] px-[1em] flex justify-between">
                <div>
                    <a class="py-0 px-[1em]" href="#">Privacy Policy</a>
                    <a class="py-0 px-[1em]" href="#">Terms & Conditions</a>
                </div>
            </div>
        </div>

        <script>
            var lastScrollTop; // This Varibale will store the top position
            navbar = document.getElementById('header'); // Get The NavBar
            console.log(navbar);
            window.addEventListener('scroll', function() {
                //on every scroll this funtion will be called

                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                console.log(scrollTop);
                //This line will get the location on scroll
                if (scrollTop < 10) { // If scrollTop is 0, make navbar transparent
                    navbar.classList.add('bg-transparent');
                    navbar.classList.remove('bg-white backdrop-blur-lg bg-opacity-50');
                } else if (scrollTop > lastScrollTop) { // If scrolling down
                    navbar.style.top = '-150px';
                    navbar.classList.remove('bg-transparent');
                    navbar.classList.add('bg-white');
                } else { // If scrolling up
                    navbar.style.top = '0';
                    navbar.classList.remove('bg-transparent');
                    navbar.classList.add('bg-white');
                }

                lastScrollTop = scrollTop; //New Position Stored
            });

            const t1 = gsap.timeline({
                paused: true
            });

            const animateOpenNav = () => {
                t1.to(".nav-container", 0.2, {
                        autoAlpha: 1,
                        delay: 0.1,
                    })
                    .to(
                        ".navbar",
                        0.2, {
                            backgroundColor: "#000",
                            autoAlpha: 1,
                        },
                        "-=0.2"
                    )
                    .to(".site-logo", 0.2, {
                        color: "#fff"
                    }, "-=0.2");
            };

            const openNav = () => {
                animateOpenNav();
                const navBtn = document.getElementById("menu-toggle-btn");
                navBtn.onclick = function(e) {
                    navBtn.classList.toggle("active");
                    t1.reversed(!t1.reversed());
                };
            };

            openNav();

            t1.from(".d-flex > div", 0.4, {
                    opacity: 0,
                    y: 10,
                    stagger: {
                        amount: 0.04,
                    },
                })
                .to(
                    ".nav-link > a",
                    0.8, {
                        top: 0,
                        ease: "power2.inOut",
                        stagger: {
                            amount: 0.1
                        },
                    },
                    "-=0.4"
                )
                .to(
                    ".nav-link",
                    0.8, {
                        top: 0,
                        ease: "power2.inOut",
                        stagger: {
                            amount: 0.1
                        },
                        borderBottom: "0.1px solid #fff",
                    },
                    "-=0.4"
                )
                .from(".nav-footer", 0.3, {
                    opacity: 0
                }, "-=0.5")
                .reverse();
            document.getElementById('animateButton').addEventListener('click', function() {
                console.log("hello");
                // Select the next div that is currently hidden
                let nextDiv = document.querySelector('.box.hidden');

                // If there is a next div to show
                if (nextDiv) {
                    t1.to(".nav-link", 0.8, {
                            top: 10, // Move them out of view
                            ease: "power2.inOut",
                            stagger: {
                                amount: 0.1
                            },
                            borderBottom: "0.1px solid transparent",
                        })
                        .to(".nav-link > a", 0.8, {
                            top: 10, // Move them out of view
                            ease: "power2.inOut",
                            stagger: {
                                amount: 0.1
                            },
                        }, "-=0.8") // Overlap with the previous animation

                        // Then animate the .d-flex > div elements to disappear
                        .to(".d-flex > div", 0.4, {
                            opacity: 0,
                            y: 10,
                            stagger: {
                                amount: 0.04
                            },
                        }, "-=0.8"); // Overlap with the previous animation
                    // .reverse();
                    // Remove the hidden class to make it visible
                    nextDiv.classList.remove('hidden');

                    // Use GSAP to animate the appearance of the div
                    gsap.from(nextDiv, {
                        duration: 1,
                        opacity: 0,
                        y: -50
                    });
                }
            });
        </script>
    </div>
    <!--Image section NSS-->
    <!-- <div class="relative isolate">
    <img id="fallbackImage" src="../../assests/nss.jpg" alt="Fallback Image" class=" mx-auto top-0 left-0  w-[100vw] h-[60vh] max-h-[300px] object-cover">
    <div class="absolute inset-0 -z-10 bg-gradient-to-t   from-gray-800 via-gray-900/10"></div>

    <div class="text-center z-1" style="margin-top:-120px; display:flex;justify-content:center;-webkit-text-fill-color:transparent;-webkit-text-stroke:4px white" data-aos="fade-up">
        <h1 class=" md:text-7xl text-5xl font-bold tracking-tight text-white sm:text-6xl text-center px-[20px]">NSS</h1>
    </div>
    <div class="text-center z-1" style="margin-top:-20px; display:flex;justify-content:center" data-aos="fade-up">
        <p class="mt-6  text-3xl leading-8 text-white "> National Service Scheme. </p>
    </div>
</div> -->

</body>

</html>
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