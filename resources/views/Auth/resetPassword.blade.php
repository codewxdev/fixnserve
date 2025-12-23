{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <!-- Primary Dark Blue: #021056 | Accent Blue: #1169FB -->
    <div class="w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-3xl font-bold mb-4 text-center" style="color: #021056;">
            Set New Password
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Choose a strong, new password for your account.
        </p>

        <!-- Success/Error Message Container -->
        <div id="messageContainer" class="hidden px-4 py-3 rounded relative mb-6" role="alert">
            <p id="feedbackMessage" class="font-medium text-sm"></p>
        </div>

        <form action="" method="POST" id="resetPasswordForm" class="space-y-6">

            <div>
                <label for="password" class="block text-sm font-medium mb-2" style="color: #021056;">New
                    Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required minlength="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium mb-2" style="color: #021056;">Confirm
                    Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required
                    minlength="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div class="pt-4">
                <button type="submit" id="submitButton"
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-lg font-semibold text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out"
                    style="background-color: #021056;">
                    Reset Password
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm">
            <p class="mt-4 text-gray-600">
                <a href="login.html" class="font-bold hover:underline" style="color: #1169FB;">Back to Login</a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById("resetPasswordForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const button = document.getElementById("submitButton");
            const messageContainer = document.getElementById("messageContainer");
            const feedbackMessage = document.getElementById("feedbackMessage");

            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            const email = localStorage.getItem("reset_email");
            const code = localStorage.getItem("reset_code");

            if (!email || !code) {
                messageContainer.classList.remove("hidden");
                messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                feedbackMessage.innerText = "Missing email or verification code. Please verify OTP again.";
                return;
            }

            // Client-side validation
            if (password !== confirmPassword) {
                messageContainer.classList.remove("hidden");
                messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                feedbackMessage.innerText = "Error: The passwords do not match.";
                return;
            }

            // Start loading
            button.disabled = true;
            button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Updating...
        `;

            fetch("http://127.0.0.1:8000/api/password/reset", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: email,
                        code: code,
                        password: password,
                        password_confirmation: confirmPassword
                    })
                })
                .then(res => res.json())
                .then(data => {
                    messageContainer.classList.remove("hidden");

                    if (data.status === true) {
                        messageContainer.classList.add("bg-green-100", "border-green-400", "text-green-700");
                        feedbackMessage.innerText = "Success! Your password has been updated.";

                        // Clear OTP storage
                        localStorage.removeItem("reset_email");
                        localStorage.removeItem("reset_code");

                        setTimeout(() => {
                            window.location.href = "{{ route('login.index') }}";
                        }, 1500);

                    } else {
                        messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                        feedbackMessage.innerText = data.message || "An error occurred.";
                    }
                })
                .catch(err => {
                    messageContainer.classList.remove("hidden");
                    messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                    feedbackMessage.innerText = "Network error occurred.";
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerHTML = "Reset Password";
                });
        });
    </script>

</body>

</html> --}}


@extends('layouts.auth')

@section('content')
    <!-- Primary Dark Blue: #021056 | Accent Blue: #1169FB -->
    <div class="w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-3xl font-bold mb-4 text-center" style="color: #021056;">
            Set New Password
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Choose a strong, new password for your account.
        </p>

        <!-- Success/Error Message Container -->
        <div id="messageContainer" class="hidden px-4 py-3 rounded relative mb-6" role="alert">
            <p id="feedbackMessage" class="font-medium text-sm"></p>
        </div>

        <form action="" method="POST" id="resetPasswordForm" class="space-y-6">

            <div>
                <label for="password" class="block text-sm font-medium mb-2" style="color: #021056;">New
                    Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required minlength="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium mb-2" style="color: #021056;">Confirm
                    Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required
                    minlength="8"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div class="pt-4">
                <button type="submit" id="submitButton"
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-lg font-semibold text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out"
                    style="background-color: #021056;">
                    Reset Password
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm">
            <p class="mt-4 text-gray-600">
                <a href="login.html" class="font-bold hover:underline" style="color: #1169FB;">Back to Login</a>
            </p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById("resetPasswordForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const button = document.getElementById("submitButton");
            const messageContainer = document.getElementById("messageContainer");
            const feedbackMessage = document.getElementById("feedbackMessage");

            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            const email = localStorage.getItem("reset_email");
            const code = localStorage.getItem("reset_code");

            if (!email || !code) {
                messageContainer.classList.remove("hidden");
                messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                feedbackMessage.innerText = "Missing email or verification code. Please verify OTP again.";
                return;
            }

            // Client-side validation
            if (password !== confirmPassword) {
                messageContainer.classList.remove("hidden");
                messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                feedbackMessage.innerText = "Error: The passwords do not match.";
                return;
            }

            // Start loading
            button.disabled = true;
            button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Updating...
        `;

            fetch("http://127.0.0.1:8000/api/password/reset", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: email,
                        code: code,
                        password: password,
                        password_confirmation: confirmPassword
                    })
                })
                .then(res => res.json())
                .then(data => {
                    messageContainer.classList.remove("hidden");

                    if (data.status === true) {
                        messageContainer.classList.add("bg-green-100", "border-green-400", "text-green-700");
                        feedbackMessage.innerText = "Success! Your password has been updated.";

                        // Clear OTP storage
                        localStorage.removeItem("reset_email");
                        localStorage.removeItem("reset_code");

                        setTimeout(() => {
                            window.location.href = "{{ route('login.index') }}";
                        }, 1500);

                    } else {
                        messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                        feedbackMessage.innerText = data.message || "An error occurred.";
                    }
                })
                .catch(err => {
                    messageContainer.classList.remove("hidden");
                    messageContainer.classList.add("bg-red-100", "border-red-400", "text-red-700");
                    feedbackMessage.innerText = "Network error occurred.";
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerHTML = "Reset Password";
                });
        });
    </script>
@endpush
