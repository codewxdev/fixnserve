{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom modal overlay for non-dismissible background */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.75);
            /* Darker backdrop */
            z-index: 50;
            /* Ensure it's above everything else */
        }

        /* Hiding scrollbar for better focus when modal is open */
        .modal-active {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <!-- Primary Dark Blue: #021056 | Accent Blue: #1169FB -->

    <!-- Main Content Card (Email Form) -->
    <div id="emailFormContainer"
        class="w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-3xl font-bold mb-4 text-center" style="color: #021056;">
            Forgot Password
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Enter your email address to receive a security code.
        </p>

        <!-- Success/Error Message Container -->
        <div id="messageContainer" class="hidden px-4 py-3 rounded relative mb-6" role="alert">
            <p id="feedbackMessage" class="font-medium text-sm"></p>
        </div>

        <form action="" method="POST" id="forgotPasswordForm" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium mb-2" style="color: #021056;">Email
                    Address</label>
                <input type="email" name="email" id="email" placeholder="you@example.com" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div class="pt-4">
                <button type="submit" id="submitButton"
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-lg font-semibold text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out"
                    style="background-color: #1169FB;">
                    Send Security Code
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm">
            <p class="mt-4 text-gray-600">
                Remembered your password?
                <a href="{{ route('login.index') }}" class="font-bold hover:underline" style="color: #1169FB;">Log
                    In</a>
            </p>
        </div>
    </div>

    <!-- OTP Input Modal (Non-Dismissible, Pro, Modern) -->
    <div id="otpModal" class="hidden fixed inset-0 flex items-center justify-center modal-overlay">
        <div class="bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl transform scale-100 transition-transform duration-300"
            style="color: #021056;">

            <h2 class="text-2xl font-bold mb-3 text-center">Verify Security Code</h2>
            <p class="text-center text-gray-500 mb-6 text-sm">
                A 6-digit code has been sent to the email provided.
            </p>

            <!-- Modal Error/Success Message -->
            <div id="modalMessageContainer" class="hidden px-3 py-2 rounded relative mb-4" role="alert">
                <p id="modalFeedbackMessage" class="font-medium text-xs"></p>
            </div>

            <form id="otpForm" class="space-y-4">
                <div>
                    <label for="otp" class="block text-sm font-medium mb-2">Security Code</label>
                    <input type="text" id="otp" placeholder="e.g., 123456" required maxlength="6"
                        pattern="[0-9]{6}" title="Six digit code"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center tracking-widest text-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#021056] transition duration-150">
                </div>

                <button type="submit" id="otpSubmitButton" disabled
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg font-semibold text-white shadow-md transition duration-300 ease-in-out disabled:opacity-50"
                    style="background-color: #021056;">
                    Verify Code
                </button>
            </form>

            <div class="mt-4 text-center text-xs text-gray-500">
                <a href="#" class="hover:underline" id="resendLink">Resend Code</a>
            </div>
        </div>
    </div>


    <script>
        // DOM Elements
        const forgotPasswordForm = document.getElementById("forgotPasswordForm");
        const submitButton = document.getElementById("submitButton");
        const messageContainer = document.getElementById("messageContainer");
        const otpModal = document.getElementById("otpModal");
        const otpForm = document.getElementById("otpForm");
        const otpSubmitButton = document.getElementById("otpSubmitButton");
        const modalMessageContainer = document.getElementById("modalMessageContainer");
        const body = document.body;
        const otpInput = document.getElementById("otp");

        // --- Utility Functions ---

        function setLoadingState(button, isLoading, text) {
            button.disabled = isLoading;
            if (isLoading) {
                button.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${text}
                `;
            } else {
                button.innerHTML = text;
            }
        }

        function displayMessage(container, message, isError) {
            container.classList.remove('hidden', 'bg-red-100', 'border-red-400', 'text-red-700', 'bg-green-100',
                'border-green-400', 'text-green-700');

            if (isError) {
                container.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
            } else {
                container.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
            }
            container.querySelector('p').innerText = message;
        }

        function clearMessage(container) {
            container.classList.add('hidden');
            container.querySelector('p').innerText = '';
            container.className = 'hidden px-4 py-3 rounded relative mb-6'; // Reset classes
        }

        // --- 1. Reusable OTP Verification Function ---
        function verifyOtp(otpValue, isAuto) {

            clearMessage(modalMessageContainer);
            setLoadingState(otpSubmitButton, true, 'Verifying...');

            fetch("http://127.0.0.1:8000/api/password/verify-code", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: document.getElementById("email").value,
                        code: otpValue
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === true) {
                        // OTP VERIFIED
                        localStorage.setItem("reset_email", document.getElementById("email").value);
                        localStorage.setItem("reset_code", otpValue);

                        window.location.href = "/auth/password/reset?email=" + document.getElementById("email").value;
                    } else {
                        // OTP WRONG
                        displayMessage(modalMessageContainer, data.message, true);
                        setLoadingState(otpSubmitButton, false, 'Verify Code');
                    }
                })
                .catch(err => {

                    displayMessage(modalMessageContainer, "Server error occurred.", true);
                    setLoadingState(otpSubmitButton, false, 'Verify Code');
                });
        }



        // --- 2. Email Submission Logic (Send Code) ---

        forgotPasswordForm.addEventListener("submit", function(e) {
            e.preventDefault();

            const emailInput = document.getElementById("email").value;
            clearMessage(messageContainer);
            setLoadingState(submitButton, true, 'Sending...');

            // Mock API call to send OTP
            fetch("http://127.0.0.1:8000/api/password/forgot", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: emailInput
                    })
                })
                .then(res => {
                    // Check for server errors (4xx, 5xx)
                    if (!res.ok) {
                        return res.text().then(() => {
                            throw new Error(`Server responded with status ${res.status}.`);
                        });
                    }
                    // Skip parsing response as JSON in this mock environment
                    return Promise.resolve();
                })
                .then(() => {
                    const emailInput = document.getElementById("email").value;
                    // MOCK SUCCESS LOGIC: We assume success if the email looks valid
                    if (emailInput.includes("@") && emailInput.length > 5) {

                        // Show success on the main form
                        displayMessage(messageContainer,
                            "Success! A security code has been sent to your email.", false);

                        // Open the Modal (Non-Dismissible)
                        otpModal.classList.remove('hidden');
                        body.classList.add('modal-active'); // Locks the background scroll

                        // Prepare the modal form
                        clearMessage(modalMessageContainer);
                        otpInput.value = ''; // Clear OTP input
                        otpSubmitButton.disabled = true; // Ensure button is disabled

                    } else {
                        // MOCK ERROR LOGIC: If email is invalid client-side, show error
                        displayMessage(messageContainer, "Error: Please enter a valid email address.", true);
                    }
                })
                .catch(err => {
                    console.error("Fetch Error:", err);
                    // Handle network/server errors
                    displayMessage(messageContainer, "Error: Could not connect to the authentication server.",
                        true);
                })
                .finally(() => {
                    setLoadingState(submitButton, false, 'Send Security Code');
                });
        });


        // --- 3. OTP Real-time Check and Auto-Submit ---

        otpInput.addEventListener("input", function() {
            // Clean input: only allow digits
            this.value = this.value.replace(/[^0-9]/g, '');
            const otpValue = this.value;

            // Enable/Disable the button based on length
            if (otpValue.length === 6) {
                otpSubmitButton.disabled = false;
                // Auto-submit for real-time verification
                verifyOtp(otpValue, true);
            } else {
                otpSubmitButton.disabled = true;
                // Clear any previous error/loading state if user starts typing again
                clearMessage(modalMessageContainer);
                setLoadingState(otpSubmitButton, false, 'Verify Code');
            }
        });


        // --- 4. OTP Form Submission (Fallback for Enter Key) ---

        otpForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const otpValue = otpInput.value;
            verifyOtp(otpValue, false);
        });


        // --- 5. Resend Link Handler ---

        // --- 5. Resend Link Handler (REAL API) ---
        document.getElementById("resendLink").addEventListener("click", function(e) {
            e.preventDefault();

            const email = document.getElementById("email").value;

            clearMessage(modalMessageContainer);

            // Show loading
            displayMessage(modalMessageContainer, "Sending new code...", false);

            fetch("http://127.0.0.1:8000/api/password/forgot", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === true) {
                        displayMessage(
                            modalMessageContainer,
                            "A new security code has been sent to your email.",
                            false
                        );

                        // Reset OTP field and disable submit button
                        otpInput.value = "";
                        otpSubmitButton.disabled = true;

                        // Optional: small highlight animation
                        otpInput.classList.add("ring", "ring-green-400");
                        setTimeout(() => otpInput.classList.remove("ring", "ring-green-400"), 500);
                    } else {
                        displayMessage(modalMessageContainer, data.message, true);
                    }
                })
                .catch(() => {
                    displayMessage(modalMessageContainer, "Unable to resend code. Try again.", true);
                });
        });
    </script>
</body>

</html> --}}


@extends('layouts.auth')

@section('content')
    <!-- Main Content Card (Email Form) -->
    <div id="emailFormContainer"
        class="w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-3xl font-bold mb-4 text-center" style="color: #021056;">
            Forgot Password
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Enter your email address to receive a security code.
        </p>

        <!-- Success/Error Message Container -->
        <div id="messageContainer" class="hidden px-4 py-3 rounded relative mb-6" role="alert">
            <p id="feedbackMessage" class="font-medium text-sm"></p>
        </div>

        <form action="" method="POST" id="forgotPasswordForm" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium mb-2" style="color: #021056;">Email
                    Address</label>
                <input type="email" name="email" id="email" placeholder="you@example.com" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div class="pt-4">
                <button type="submit" id="submitButton"
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-lg font-semibold text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out"
                    style="background-color: #1169FB;">
                    Send Security Code
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm">
            <p class="mt-4 text-gray-600">
                Remembered your password?
                <a href="{{ route('login.index') }}" class="font-bold hover:underline" style="color: #1169FB;">Log
                    In</a>
            </p>
        </div>
    </div>

    <!-- OTP Input Modal (Non-Dismissible, Pro, Modern) -->
    <div id="otpModal" class="hidden fixed inset-0 flex items-center justify-center modal-overlay">
        <div class="bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl transform scale-100 transition-transform duration-300"
            style="color: #021056;">

            <h2 class="text-2xl font-bold mb-3 text-center">Verify Security Code</h2>
            <p class="text-center text-gray-500 mb-6 text-sm">
                A 6-digit code has been sent to the email provided.
            </p>

            <!-- Modal Error/Success Message -->
            <div id="modalMessageContainer" class="hidden px-3 py-2 rounded relative mb-4" role="alert">
                <p id="modalFeedbackMessage" class="font-medium text-xs"></p>
            </div>

            <form id="otpForm" class="space-y-4">
                <div>
                    <label for="otp" class="block text-sm font-medium mb-2">Security Code</label>
                    <input type="text" id="otp" placeholder="e.g., 123456" required maxlength="6"
                        pattern="[0-9]{6}" title="Six digit code"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center tracking-widest text-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#021056] transition duration-150">
                </div>

                <button type="submit" id="otpSubmitButton" disabled
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg font-semibold text-white shadow-md transition duration-300 ease-in-out disabled:opacity-50"
                    style="background-color: #021056;">
                    Verify Code
                </button>
            </form>

            <div class="mt-4 text-center text-xs text-gray-500">
                <a href="#" class="hover:underline" id="resendLink">Resend Code</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom modal overlay for non-dismissible background */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.75);
            /* Darker backdrop */
            z-index: 50;
            /* Ensure it's above everything else */
        }

        /* Hiding scrollbar for better focus when modal is open */
        .modal-active {
            overflow: hidden;
        }
    </style>
@endpush


@push('scripts')
    <script>
        // DOM Elements
        const forgotPasswordForm = document.getElementById("forgotPasswordForm");
        const submitButton = document.getElementById("submitButton");
        const messageContainer = document.getElementById("messageContainer");
        const otpModal = document.getElementById("otpModal");
        const otpForm = document.getElementById("otpForm");
        const otpSubmitButton = document.getElementById("otpSubmitButton");
        const modalMessageContainer = document.getElementById("modalMessageContainer");
        const body = document.body;
        const otpInput = document.getElementById("otp");

        // --- Utility Functions ---

        function setLoadingState(button, isLoading, text) {
            button.disabled = isLoading;
            if (isLoading) {
                button.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${text}
                `;
            } else {
                button.innerHTML = text;
            }
        }

        function displayMessage(container, message, isError) {
            container.classList.remove('hidden', 'bg-red-100', 'border-red-400', 'text-red-700', 'bg-green-100',
                'border-green-400', 'text-green-700');

            if (isError) {
                container.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
            } else {
                container.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
            }
            container.querySelector('p').innerText = message;
        }

        function clearMessage(container) {
            container.classList.add('hidden');
            container.querySelector('p').innerText = '';
            container.className = 'hidden px-4 py-3 rounded relative mb-6'; // Reset classes
        }

        // --- 1. Reusable OTP Verification Function ---
        function verifyOtp(otpValue, isAuto) {

            clearMessage(modalMessageContainer);
            setLoadingState(otpSubmitButton, true, 'Verifying...');

            fetch("http://127.0.0.1:8000/api/password/verify-code", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: document.getElementById("email").value,
                        code: otpValue
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === true) {
                        // OTP VERIFIED
                        localStorage.setItem("reset_email", document.getElementById("email").value);
                        localStorage.setItem("reset_code", otpValue);

                        window.location.href = "/auth/password/reset?email=" + document.getElementById("email").value;
                    } else {
                        // OTP WRONG
                        displayMessage(modalMessageContainer, data.message, true);
                        setLoadingState(otpSubmitButton, false, 'Verify Code');
                    }
                })
                .catch(err => {

                    displayMessage(modalMessageContainer, "Server error occurred.", true);
                    setLoadingState(otpSubmitButton, false, 'Verify Code');
                });
        }



        // --- 2. Email Submission Logic (Send Code) ---

        forgotPasswordForm.addEventListener("submit", function(e) {
            e.preventDefault();

            const emailInput = document.getElementById("email").value;
            clearMessage(messageContainer);
            setLoadingState(submitButton, true, 'Sending...');

            // Mock API call to send OTP
            fetch("http://127.0.0.1:8000/api/password/forgot", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: emailInput
                    })
                })
                .then(res => {
                    // Check for server errors (4xx, 5xx)
                    if (!res.ok) {
                        return res.text().then(() => {
                            throw new Error(`Server responded with status ${res.status}.`);
                        });
                    }
                    // Skip parsing response as JSON in this mock environment
                    return Promise.resolve();
                })
                .then(() => {
                    const emailInput = document.getElementById("email").value;
                    // MOCK SUCCESS LOGIC: We assume success if the email looks valid
                    if (emailInput.includes("@") && emailInput.length > 5) {

                        // Show success on the main form
                        displayMessage(messageContainer,
                            "Success! A security code has been sent to your email.", false);

                        // Open the Modal (Non-Dismissible)
                        otpModal.classList.remove('hidden');
                        body.classList.add('modal-active'); // Locks the background scroll

                        // Prepare the modal form
                        clearMessage(modalMessageContainer);
                        otpInput.value = ''; // Clear OTP input
                        otpSubmitButton.disabled = true; // Ensure button is disabled

                    } else {
                        // MOCK ERROR LOGIC: If email is invalid client-side, show error
                        displayMessage(messageContainer, "Error: Please enter a valid email address.", true);
                    }
                })
                .catch(err => {
                    console.error("Fetch Error:", err);
                    // Handle network/server errors
                    displayMessage(messageContainer, "Error: Could not connect to the authentication server.",
                        true);
                })
                .finally(() => {
                    setLoadingState(submitButton, false, 'Send Security Code');
                });
        });


        // --- 3. OTP Real-time Check and Auto-Submit ---

        otpInput.addEventListener("input", function() {
            // Clean input: only allow digits
            this.value = this.value.replace(/[^0-9]/g, '');
            const otpValue = this.value;

            // Enable/Disable the button based on length
            if (otpValue.length === 6) {
                otpSubmitButton.disabled = false;
                // Auto-submit for real-time verification
                verifyOtp(otpValue, true);
            } else {
                otpSubmitButton.disabled = true;
                // Clear any previous error/loading state if user starts typing again
                clearMessage(modalMessageContainer);
                setLoadingState(otpSubmitButton, false, 'Verify Code');
            }
        });


        // --- 4. OTP Form Submission (Fallback for Enter Key) ---

        otpForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const otpValue = otpInput.value;
            verifyOtp(otpValue, false);
        });


        // --- 5. Resend Link Handler ---

        // --- 5. Resend Link Handler (REAL API) ---
        document.getElementById("resendLink").addEventListener("click", function(e) {
            e.preventDefault();

            const email = document.getElementById("email").value;

            clearMessage(modalMessageContainer);

            // Show loading
            displayMessage(modalMessageContainer, "Sending new code...", false);

            fetch("http://127.0.0.1:8000/api/password/forgot", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === true) {
                        displayMessage(
                            modalMessageContainer,
                            "A new security code has been sent to your email.",
                            false
                        );

                        // Reset OTP field and disable submit button
                        otpInput.value = "";
                        otpSubmitButton.disabled = true;

                        // Optional: small highlight animation
                        otpInput.classList.add("ring", "ring-green-400");
                        setTimeout(() => otpInput.classList.remove("ring", "ring-green-400"), 500);
                    } else {
                        displayMessage(modalMessageContainer, data.message, true);
                    }
                })
                .catch(() => {
                    displayMessage(modalMessageContainer, "Unable to resend code. Try again.", true);
                });
        });
    </script>
@endpush
