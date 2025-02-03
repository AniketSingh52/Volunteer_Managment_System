<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="multiselect-dropdown.js"></script>
</head>

<body>
    <div class="max-w-4xl mx-auto font-[sans-serif] p-6">
        <div class="text-center mb-16">

            <h4 class="text-gray-800 text-base font-semibold mt-6">Register</h4>
        </div>

        <form method="post" id="yourFormID2">

            <div class="grid gap-6 mb-6">
                <div>
                    <label for="skill" class="text-gray-700 text-sm mb-2 block font-semibold ">Your Skills</label>
                    <!-- <input name="skill" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" /> -->
                    <select name="skill2" multiple id="skill2" class="w-full">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div>
                    <label for="causes" class="text-gray-700 text-sm mb-2 block font-semibold ">Cause for Which You want To Volunteer</label>
                    <!-- <input name="skill" id="name" type="text" class="bg-gray-100 w-full text-gray-800 text-sm px-4 py-3.5 rounded-md focus:bg-white outline-blue-500 transition-all" placeholder="Enter name" /> -->
                    <select name="skill" multiple
                        multiselect-search="true"
                        multiselect-select-all="true"
                        multiselect-max-items="3"
                        multiselect-hide-x="false" id="skill" class="w-full">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>
            <input value="save" type="submit" onclick="c1()" />

        </form>
    </div>
    <script>
        function c1() {


            // Check if the listener has already been added to prevent duplication
            const form = document.getElementById("yourFormID2");

            if (!form.hasListener) {
                form.addEventListener("submit", function(event) {

                    event.preventDefault(); // Prevent the default form submission

                    let formData = new FormData(form);
                    // Log form data to console
                    console.log("Form data:");
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }

                    
                });

                // Mark the form as having a listener to avoid adding multiple times
                form.hasListener = true;
            }

         
        }
    </script>
</body>

</html>