
<?php

//error_reporting(0);
//include("../../config/connect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_FILES['file'])) {
            // File information
            print_r($_FILES['file']);
            $file_tmp_path = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $file_error = $_FILES['file']['error'];

            // Validate file
           // $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 10 * 1024 * 1024; // 10MB

            $fileExt = explode('.', $file_name);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg', 'jpeg', 'png');

            if (in_array($fileActualExt, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= $max_size) {
                        $file_name_new = uniqid('', true) . "." . $fileActualExt;
                        $file_destination = 'uploads/' . $file_name_new;
                        if (move_uploaded_file($file_tmp_path, $file_destination)) {
                            echo "file uploaded successfully";
                        }
                        else{
                            echo "file not uploaded";
                        }
                    }else{
                    echo "File size too large (max 10MB)";
                    }
                } else {
                    echo "there was an error uploading your image";
                }
            } else {
                die("Invalid file type");
            }

        }
    }



?>

  <!-- Js for Next and Previous Button -->
    <script>
        const prevBtns1 = document.querySelectorAll(".btn-prev1");
        const nextBtns1 = document.querySelectorAll(".btn-next1");
        const progressSteps1 = document.querySelectorAll(".progress-step1");
        const formSteps1 = document.querySelectorAll(".form-step1");
        const progressLine1 = document.getElementById("progress-line1");
        let formStepsNum1 = 0;

        // New validation functions
        function validateCurrentStep2() {
            const currentStep = formSteps1[formStepsNum1];
            const inputs = currentStep.querySelectorAll('input, select, textarea');
            let allValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required')) {
                    if (input.type === 'file') {
                        if (!input.files.length) allValid = false;
                    } else if (!input.checkValidity()) {
                        allValid = false;
                    }
                }
            });

            return allValid;
        }

        function updateNextButtonState2() {
            const currentStep = formSteps1[formStepsNum1];
            const nextBtn = currentStep.querySelector('.btn-next');
            if (nextBtn) {
                const isValid = validateCurrentStep2();
                nextBtn.disabled = !isValid;

                // Add opacity styling
                if (isValid) {
                    nextBtn.classList.remove('opacity-50', 'bg-cyan-800');
                    nextBtn.classList.add('bg-blue-500');
                } else {
                    nextBtn.classList.add('opacity-50', 'bg-cyan-800');
                    nextBtn.classList.remove('bg-blue-500');
                }
            }
        }

        // Modified form step update function
        function updateFormSteps2() {
            formSteps1.forEach((formStep, index) => {
                const isActive = index === formStepsNum1;
                formStep.classList.toggle("hidden", !isActive);
                formStep.classList.toggle("active", isActive);

                if (isActive) {
                    // Add event listeners to all inputs in active step
                    const inputs = formStep.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('input', updateNextButtonState);
                        input.addEventListener('change', updateNextButtonState);
                    });
                }
            });
            updateNextButtonState2();
        }

        // Modified next button handler
        nextBtns1.forEach((btn) => {
            btn.addEventListener("click", () => {
                if (validateCurrentStep2()) {
                    formStepsNum1++;
                    updateFormSteps2();
                    updateProgressBar2();
                }
            });
        });

        prevBtns1.forEach((btn) => {
            btn.addEventListener("click", () => {
                formStepsNum1--;
                updateFormSteps2();
                updateProgressBar2();
            });
        });

        // Rest of your existing progress bar code...
        function updateProgressBar2() {
            progressSteps1.forEach((step, index) => {
                if (index <= formStepsNum1) {
                    step.classList.add("bg-blue-500", "text-white");
                    step.classList.remove("bg-gray-300", "text-gray-500");
                } else {
                    step.classList.add("bg-gray-300", "text-gray-500");
                    step.classList.remove("bg-blue-500", "text-white");
                }
            });

            const activeSteps2 = Array.from(progressSteps1).slice(0, formStepsNum1 + 1);
            const percentage2 = ((activeSteps2.length - 1) / (progressSteps1.length - 1)) * 100;
            progressLine1.style.background = `linear-gradient(to right, #3b82f6 ${percentage2}%, #d1d5db ${percentage2}%)`;
        }

        // Initialize
        updateProgressBar2();
        updateFormSteps2();
    </script>