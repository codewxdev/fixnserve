{{-- <!DOCTYPE html>
<html lang="en">

<x-partials.head />

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="login-card-shadow w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-4xl font-bold mb-10 text-center" style="color: #021056;">
            Sign In
        </h1>

        <div id="errorMessageContainer" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <p id="errorMessage" class="font-medium text-sm"></p>
        </div>

        <form action="" method="POST" id="loginForm" class="space-y-6">

            <div>
                <label for="email" class="block text-sm font-medium mb-2" style="color: #021056;">Email
                    Address</label>
                <input type="email" name="email" id="email" placeholder="you@example.com" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-2" style="color: #021056;">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div class="pt-4">
                <button type="submit" id="loginButton"
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-lg font-semibold text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out"
                    style="background-color: #1169FB;">
                    Log In
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm">
            <a href="{{ route('forget.password') }}" class="font-medium hover:underline" style="color: #1169FB;">
                Forgot your password?
            </a>
            
        </div>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const button = document.getElementById("loginButton");
            const errorMessageContainer = document.getElementById("errorMessageContainer");
            const errorMessage = document.getElementById("errorMessage");

            // --- 1. START: Set Button to Loading State (Loader/Disable) ---
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
            // Clear previous errors
            errorMessageContainer.classList.add('hidden');
            errorMessage.innerText = '';
            // -----------------------------------------------------------------


            fetch("http://localhost:8000/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: document.getElementById("email").value,
                        password: document.getElementById("password").value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        // Successful login
                        localStorage.setItem('token', data.token);
                        window.location.href = "/";
                    } else {
                        // Failed login/Error
                        errorMessage.innerText = data.error || "An unknown error occurred. Please try again.";
                        errorMessageContainer.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    // Network or unhandled error
                    console.error(err);
                    errorMessage.innerText = "Could not connect to the server. Check your network or try again later.";
                    errorMessageContainer.classList.remove('hidden');
                })
                .finally(() => {
                    // --- 2. END: Reset Button State ---
                    button.disabled = false;
                    button.innerHTML = 'Log In';
                    // ------------------------------------
                });
        });
    </script>


</body>

</html> --}}

@extends('layouts.auth')

@section('content')
    
    <div class="login-card-shadow w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-4xl font-bold mb-10 text-center" style="color: #021056;">
            Sign In
        </h1>

        <div id="errorMessageContainer" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <p id="errorMessage" class="font-medium text-sm"></p>
        </div>

        <form action="" method="POST" id="loginForm" class="space-y-6">

            <div>
                <label for="email" class="block text-sm font-medium mb-2" style="color: #021056;">Email
                    Address</label>
                <input type="email" name="email" id="email" placeholder="you@example.com" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-2" style="color: #021056;">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150"
                    style="color: #021056; background-color: white;">
            </div>

            <div class="pt-4">
                <button type="submit" id="loginButton"
                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-lg font-semibold text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out"
                    style="background-color: #1169FB;">
                    Log In
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm">
            <a href="{{ route('forget.password') }}" class="font-medium hover:underline" style="color: #1169FB;">
                Forgot your password?
            </a>
            
        </div>
    </div>
@endsection
 
@push('scripts')
      <script>
        document.getElementById("loginForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const button = document.getElementById("loginButton");
            const errorMessageContainer = document.getElementById("errorMessageContainer");
            const errorMessage = document.getElementById("errorMessage");

            // --- 1. START: Set Button to Loading State (Loader/Disable) ---
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
            // Clear previous errors
            errorMessageContainer.classList.add('hidden');
            errorMessage.innerText = '';
            // -----------------------------------------------------------------


            fetch("http://localhost:8000/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: document.getElementById("email").value,
                        password: document.getElementById("password").value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        // Successful login
                        localStorage.setItem('token', data.token);
                        localStorage.setItem("user", JSON.stringify(data.user));
                        window.location.href = "/";
                    } else {
                        // Failed login/Error
                        errorMessage.innerText = data.error || "An unknown error occurred. Please try again.";
                        errorMessageContainer.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    // Network or unhandled error
                    console.error(err);
                    errorMessage.innerText = "Could not connect to the server. Check your network or try again later.";
                    errorMessageContainer.classList.remove('hidden');
                })
                .finally(() => {
                    // --- 2. END: Reset Button State ---
                    button.disabled = false;
                    button.innerHTML = 'Log In';
                    // ------------------------------------
                });
        });
    </script>
@endpush

@push('styles')
    <style>
        body{
            font-family: 'Poppins';
        }
    </style>
@endpush