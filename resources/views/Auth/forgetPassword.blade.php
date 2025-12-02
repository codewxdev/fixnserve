<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            Forgot Password
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Enter your email address to receive a password reset link.
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
                    Send Reset Link
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm">
            <p class="mt-4 text-gray-600">
                Remembered your password?
                <a href="login.html" class="font-bold hover:underline" style="color: #1169FB;">Log In</a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById("forgotPasswordForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const button = document.getElementById("submitButton");
            const messageContainer = document.getElementById("messageContainer");
            const feedbackMessage = document.getElementById("feedbackMessage");
            const emailInput = document.getElementById("email").value;

            // Start Loading State
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sending...
            `;
            messageContainer.classList.add('hidden');
            feedbackMessage.innerText = '';
            messageContainer.className = 'hidden px-4 py-3 rounded relative mb-6';

            // Mock API call to send reset link
            fetch("http://127.0.0.1:8000/password/forgot", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ email: emailInput })
                })
                .then(res => res.json())
                .then(data => {
                    // Mock success response
                    messageContainer.classList.remove('hidden');
                    
                    if (emailInput.includes("@")) { // Simple client-side success mock
                        messageContainer.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
                        feedbackMessage.innerText = "Success! If an account exists, a password reset link has been sent to your email.";
                    } else {
                        // Mock error response
                        messageContainer.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                        feedbackMessage.innerText = "Error: Please enter a valid email address.";
                    }
                })
                .catch(err => {
                    console.error(err);
                    messageContainer.classList.remove('hidden');
                    messageContainer.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                    feedbackMessage.innerText = "A network error occurred. Please try again later.";
                })
                .finally(() => {
                    // Reset Button State
                    button.disabled = false;
                    button.innerHTML = 'Send Reset Link';
                });
        });
    </script>
</body>
</html>