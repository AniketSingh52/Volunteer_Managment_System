// Sample events data
// const events = [
//   {
//     id: 1,
//     title: "Community Garden Clean-up",
//     image:
//       "https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800",
//     description:
//       "Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds.",
//     fromDate: "2024-03-20",
//     toDate: "2024-03-20",
//     fromTime: "09:00",
//     toTime: "14:00",
//     location: "Central Community Garden",
//     organizer: "Green Earth Initiative",
//   },
//   {
//     id: 2,
//     title: "Youth Mentorship Program",
//     image:
//       "https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&q=80&w=800",
//     description:
//       "Make a difference in a young person's life through our mentorship program.",
//     fromDate: "2024-03-25",
//     toDate: "2024-06-25",
//     fromTime: "16:00",
//     toTime: "18:00",
//     location: "City Youth Center",
//     organizer: "Youth Forward",
//   },
//   {
//     id: 3,
//     title: "Food Bank Distribution",
//     image:
//       "https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&q=80&w=800",
//     description:
//       "Help sort and distribute food to families in need at our local food bank.",
//     fromDate: "2024-03-22",
//     toDate: "2024-03-22",
//     fromTime: "08:00",
//     toTime: "12:00",
//     location: "Community Food Bank",
//     organizer: "Food for All",
//   },
// ];

$(document).ready(function () {
  let currentSlide = 0;
  const totalSlides = $(".carousel-item").length;

  // Show first slide initially
  $(".carousel-item").eq(0).removeClass("hidden");

  // Initialize carousel controls
  function showSlide(index) {
    $(".carousel-item").addClass("hidden");
    $(".carousel-item").eq(index).removeClass("hidden");
  }

  $("#prevSlide").click(function () {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
  });

  $("#nextSlide").click(function () {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
  });

  // Auto-advance carousel
  setInterval(function () {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
  }, 5000);

  // Initialize events list
  // function renderEvents() {
  //   const eventsList = events
  //     .map(
  //       (event) => `
  //     <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
  //       <div class="md:flex">
  //         <div class="md:w-1/3">
  //           <img class="h-48 w-full object-cover md:h-full" src="${event.image}" alt="${event.title}">
  //         </div>
  //         <div class="p-8 md:w-2/3">
  //           <div class="uppercase tracking-wide text-sm text-blue-600 font-semibold">${event.organizer}</div>
  //           <h3 class="mt-1 text-2xl font-semibold text-gray-900">${event.title}</h3>
            
  //           <div class="mt-4 flex items-center text-gray-600">
  //             <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  //               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
  //                     d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
  //             </svg>
  //             ${event.fromDate} - ${event.toDate}
  //           </div>
            
  //           <div class="mt-2 flex items-center text-gray-600">
  //             <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  //               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
  //                     d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
  //             </svg>
  //             ${event.fromTime} - ${event.toTime}
  //           </div>
            
  //           <div class="mt-2 flex items-center text-gray-600">
  //             <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  //               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
  //                     d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
  //               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
  //                     d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
  //             </svg>
  //             ${event.location}
  //           </div>
            
  //           <p class="mt-4 text-gray-600">${event.description}</p>
            
  //           <div class="mt-6 flex space-x-4">
  //             <button onclick="window.location.href='/events/${event.id}'" 
  //                     class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 
  //                            transition-colors duration-200">
  //               View More
  //             </button>
  //             <button onclick="window.location.href='/events/${event.id}/apply'" 
  //                     class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 
  //                            transition-colors duration-200">
  //               Apply
  //             </button>
  //           </div>
  //         </div>
  //       </div>
  //     </div>
  //   `
  //     )
  //     .join("");

  //   $("#events-list").html(eventsList);
  // }

  // Initial render of events list
  // renderEvents();
});

//  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
//                 <!-- Carousel Section -->
//                 <div
//                   class="relative h-[500px] overflow-hidden rounded-xl mb-16 group"
//                 >
//                   <div id="carousel" class="h-full">
//                     <div class="relative h-full">
//                       <img
//                         src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
//                         alt="Food Bank Distribution"
//                         class="w-full h-full object-cover"
//                       />
//                       <div
//                         class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8"
//                       >
//                         <h2 class="text-4xl font-bold text-white mb-4">
//                           Food Bank Distribution
//                         </h2>
//                         <button
//                           onclick="window.location.href='/events/3'"
//                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200"
//                         >
//                           View Details
//                         </button>
//                       </div>
//                     </div>
//                   </div>

//                   <!-- Carousel Controls -->
//                   <button
//                     id="prevSlide"
//                     class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity"
//                   >
//                     <svg
//                       xmlns="http://www.w3.org/2000/svg"
//                       class="h-6 w-6"
//                       fill="none"
//                       viewBox="0 0 24 24"
//                       stroke="currentColor"
//                     >
//                       <path
//                         stroke-linecap="round"
//                         stroke-linejoin="round"
//                         stroke-width="2"
//                         d="M15 19l-7-7 7-7"
//                       ></path>
//                     </svg>
//                   </button>
//                   <button
//                     id="nextSlide"
//                     class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity"
//                   >
//                     <svg
//                       xmlns="http://www.w3.org/2000/svg"
//                       class="h-6 w-6"
//                       fill="none"
//                       viewBox="0 0 24 24"
//                       stroke="currentColor"
//                     >
//                       <path
//                         stroke-linecap="round"
//                         stroke-linejoin="round"
//                         stroke-width="2"
//                         d="M9 5l7 7-7 7"
//                       ></path>
//                     </svg>
//                   </button>
//                 </div>

//                 <!-- Events Section -->
//                 <h2 class="text-3xl font-bold text-gray-900 mb-8">
//                   Available Opportunities
//                 </h2>
//                 <div id="events-list" class="space-y-6">
//                   <div
//                     class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow"
//                   >
//                     <div class="md:flex">
//                       <div class="md:w-1/3">
//                         <img
//                           class="h-48 w-full object-cover md:h-full"
//                           src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
//                           alt="Community Garden Clean-up"
//                         />
//                       </div>
//                       <div class="p-8 md:w-2/3">
//                         <div
//                           class="uppercase tracking-wide text-sm text-blue-600 font-semibold"
//                         >
//                           Green Earth Initiative
//                         </div>
//                         <h3 class="mt-1 text-2xl font-semibold text-gray-900">
//                           Community Garden Clean-up
//                         </h3>

//                         <div class="mt-4 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
//                             ></path>
//                           </svg>
//                           2024-03-20 - 2024-03-20
//                         </div>

//                         <div class="mt-2 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
//                             ></path>
//                           </svg>
//                           09:00 - 14:00
//                         </div>

//                         <div class="mt-2 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
//                             ></path>
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
//                             ></path>
//                           </svg>
//                           Central Community Garden
//                         </div>

//                         <p class="mt-4 text-gray-600">
//                           Join us in maintaining our community garden. Help
//                           plant new vegetables and maintain existing beds.
//                         </p>

//                         <div class="mt-6 flex space-x-4">
//                           <button
//                             onclick="window.location.href='/events/1'"
//                             class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200"
//                           >
//                             View More
//                           </button>
//                           <button
//                             onclick="window.location.href='/events/1/apply'"
//                             class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200"
//                           >
//                             Apply
//                           </button>
//                         </div>
//                       </div>
//                     </div>
//                   </div>

//                   <div
//                     class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow"
//                   >
//                     <div class="md:flex">
//                       <div class="md:w-1/3">
//                         <img
//                           class="h-48 w-full object-cover md:h-full"
//                           src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
//                           alt="Youth Mentorship Program"
//                         />
//                       </div>
//                       <div class="p-8 md:w-2/3">
//                         <div
//                           class="uppercase tracking-wide text-sm text-blue-600 font-semibold"
//                         >
//                           Youth Forward
//                         </div>
//                         <h3 class="mt-1 text-2xl font-semibold text-gray-900">
//                           Youth Mentorship Program
//                         </h3>

//                         <div class="mt-4 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
//                             ></path>
//                           </svg>
//                           2024-03-25 - 2024-06-25
//                         </div>

//                         <div class="mt-2 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
//                             ></path>
//                           </svg>
//                           16:00 - 18:00
//                         </div>

//                         <div class="mt-2 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
//                             ></path>
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
//                             ></path>
//                           </svg>
//                           City Youth Center
//                         </div>

//                         <p class="mt-4 text-gray-600">
//                           Make a difference in a young person's life through our
//                           mentorship program.
//                         </p>

//                         <div class="mt-6 flex space-x-4">
//                           <button
//                             onclick="window.location.href='/events/2'"
//                             class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200"
//                           >
//                             View More
//                           </button>
//                           <button
//                             onclick="window.location.href='/events/2/apply'"
//                             class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200"
//                           >
//                             Apply
//                           </button>
//                         </div>
//                       </div>
//                     </div>
//                   </div>

//                   <div
//                     class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow"
//                   >
//                     <div class="md:flex">
//                       <div class="md:w-1/3">
//                         <img
//                           class="h-48 w-full object-cover md:h-full"
//                           src="https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&amp;fit=crop&amp;q=80&amp;w=800"
//                           alt="Food Bank Distribution"
//                         />
//                       </div>
//                       <div class="p-8 md:w-2/3">
//                         <div
//                           class="uppercase tracking-wide text-sm text-blue-600 font-semibold"
//                         >
//                           Food for All
//                         </div>
//                         <h3 class="mt-1 text-2xl font-semibold text-gray-900">
//                           Food Bank Distribution
//                         </h3>

//                         <div class="mt-4 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
//                             ></path>
//                           </svg>
//                           2024-03-22 - 2024-03-22
//                         </div>

//                         <div class="mt-2 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
//                             ></path>
//                           </svg>
//                           08:00 - 12:00
//                         </div>

//                         <div class="mt-2 flex items-center text-gray-600">
//                           <svg
//                             class="h-5 w-5 mr-2"
//                             fill="none"
//                             stroke="currentColor"
//                             viewBox="0 0 24 24"
//                           >
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
//                             ></path>
//                             <path
//                               stroke-linecap="round"
//                               stroke-linejoin="round"
//                               stroke-width="2"
//                               d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
//                             ></path>
//                           </svg>
//                           Community Food Bank
//                         </div>

//                         <p class="mt-4 text-gray-600">
//                           Help sort and distribute food to families in need at
//                           our local food bank.
//                         </p>

//                         <div class="mt-6 flex space-x-4">
//                           <button
//                             onclick="window.location.href='/events/3'"
//                             class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200"
//                           >
//                             View More
//                           </button>
//                           <button
//                             onclick="window.location.href='/events/3/apply'"
//                             class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200"
//                           >
//                             Apply
//                           </button>
//                         </div>
//                       </div>
//                     </div>
//                   </div>
//                 </div>
//               </div>



//Pure Vanilla Js
// document.addEventListener("DOMContentLoaded", function () {
  

//   function initializeCarousel() {
//     let currentSlide = 0;
//     let totalSlides = 0;
//     let carouselItems = [];
//     let autoAdvanceInterval = null;
//     // Get fresh references to elements
//     carouselItems = Array.from(document.querySelectorAll(".carousel-item"));
//     totalSlides = carouselItems.length;

//     // Clear existing interval
//     if (autoAdvanceInterval) clearInterval(autoAdvanceInterval);

//     // Reset if no slides found
//     if (totalSlides === 0) return;

//     // Show first slide
//     showSlide(currentSlide);

//     // Setup event listeners
//     document
//       .getElementById("prevSlide")
//       ?.addEventListener("click", showPrevSlide);
//     document
//       .getElementById("nextSlide")
//       ?.addEventListener("click", showNextSlide);

//     // Start auto-advance
//     autoAdvanceInterval = setInterval(showNextSlide, 5000);
//   }

//   function showSlide(index) {
//     // Handle out-of-bound indices
//     if (index < 0 || index >= totalSlides) return;

//     currentSlide = index;
//     carouselItems.forEach((item, i) => {
//       item.classList.toggle("hidden", i !== currentSlide);
//     });
//   }

//   function showPrevSlide() {
//     currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
//     showSlide(currentSlide);
//   }

//   function showNextSlide() {
//     currentSlide = (currentSlide + 1) % totalSlides;
//     showSlide(currentSlide);
//   }

//   // Initial initialization
//   initializeCarousel();

//   // If you're using AJAX to load content, call initializeCarousel()
//   // again after the content has been inserted into the DOM
// });
