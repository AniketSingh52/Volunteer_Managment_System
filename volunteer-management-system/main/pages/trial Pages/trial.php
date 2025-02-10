<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-teal-300 to-gray-300 min-h-screen flex justify-center items-center">
    <form class="bg-gradient-to-br from-blue-200 to-purple-200 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-8">SignUp Form</h1>
        <div class="relative flex justify-between items-center mb-8 ">
            <div class="absolute bottom-6 transform w-full h-1 bg-gray-300 transition-all duration-500 " id="progress-line"></div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center progress-step" data-title="Name">1</div>
                <span class="text-sm mt-2">Name</span>
            </div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step" data-title="Contact">2</div>
                <span class="text-sm mt-2">Contact</span>
            </div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step" data-title="ID">3</div>
                <span class="text-sm mt-2">ID</span>
            </div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center progress-step" data-title="Password">4</div>
                <span class="text-sm mt-2">Password</span>
            </div>
        </div>
        <div class="form-step active">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">First Name</label>
                <input type="text" id="username" name="username" placeholder="First Name" class="w-full border border-gray-400 rounded p-2">
            </div>
            <div class="mb-4">
                <label for="lname" class="block text-gray-700">Last Name</label>
                <input type="text" id="lname" name="lname" placeholder="Last Name" class="w-full border border-gray-400 rounded p-2">
            </div>
            <button type="button" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded">Next</button>
        </div>

        <div class="form-step hidden">
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone</label>
                <input type="tel" id="phone" name="phone" placeholder="Phone" class="w-full border border-gray-400 rounded p-2">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" class="w-full border border-gray-400 rounded p-2">
            </div>
            <div class="flex justify-between">
                <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded">Prev</button>
                <button type="button" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded">Next</button>
            </div>
        </div>

        <div class="form-step hidden">
            <div class="mb-4">
                <label for="dob" class="block text-gray-700">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="w-full border border-gray-400 rounded p-2">
            </div>
            <div class="mb-4">
                <label for="id" class="block text-gray-700">National ID</label>
                <input type="text" id="id" name="id" placeholder="National ID" class="w-full border border-gray-400 rounded p-2">
            </div>
            <div class="flex justify-between">
                <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded">Prev</button>
                <button type="button" class="btn btn-next bg-blue-500 text-white px-4 py-2 rounded">Next</button>
            </div>
        </div>

        <div class="form-step hidden">
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="w-full border border-gray-400 rounded p-2">
            </div>
            <div class="mb-4">
                <label for="ConfirmPassword" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password" class="w-full border border-gray-400 rounded p-2">
            </div>
            <div class="flex justify-between">
                <button type="button" class="btn btn-prev bg-gray-500 text-white px-4 py-2 rounded">Prev</button>
                <input type="submit" value="Submit" class="bg-green-500 text-white px-4 py-2 rounded cursor-pointer">
            </div>
        </div>
    </form>

    <script>
        const prevBtns = document.querySelectorAll(".btn-prev");
        const nextBtns = document.querySelectorAll(".btn-next");
        const progressSteps = document.querySelectorAll(".progress-step");
        const formSteps = document.querySelectorAll(".form-step");
        const progressLine = document.getElementById("progress-line");

        let formStepsNum = 0;

        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum++;
                updateFormSteps();
                updateProgressBar();
            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum--;
                updateFormSteps();
                updateProgressBar();
            });
        });

        function updateFormSteps() {
            formSteps.forEach((formStep, index) => {
                formStep.classList.toggle("hidden", index !== formStepsNum);
                formStep.classList.toggle("active", index === formStepsNum);
            });
        }

        function updateProgressBar() {
            progressSteps.forEach((step, index) => {
                if (index <= formStepsNum) {
                    step.classList.add("bg-blue-500", "text-white");
                    step.classList.remove("bg-gray-300", "text-gray-500");
                } else {
                    step.classList.add("bg-gray-300", "text-gray-500");
                    step.classList.remove("bg-blue-500", "text-white");
                }
            });

            const activeSteps = Array.from(progressSteps).slice(0, formStepsNum + 1);
            const percentage = ((activeSteps.length - 1) / (progressSteps.length - 1)) * 100;
            progressLine.style.background = `linear-gradient(to right, #3b82f6 ${percentage}%, #d1d5db ${percentage}%)`;
        }

        updateProgressBar();
    </script>
</body>

</html>