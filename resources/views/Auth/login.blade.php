@extends('layouts.auth')

@section('content')
    <div class="login-card-shadow w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-4xl font-bold mb-10 text-center" style="color: #021056;">
            Sign In
        </h1>

        <div id="errorMessageContainer"
            class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
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

    {{-- Two-Factor Authentication Modal/Form (Hidden by default) --}}
    <div id="twoFactorModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-50">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-sm">
            <h2 id="twoFactorTitle" class="text-2xl font-bold mb-6 text-center" style="color: #021056;">
                2FA Verification
            </h2>

            <div id="twoFactorErrorMessageContainer"
                class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <p id="twoFactorErrorMessage" class="font-medium text-sm"></p>
            </div>

            <div id="qrCodeSection" class="hidden text-center mb-6">
                <p class="text-sm mb-4">Scan the QR code with your authenticator app (e.g., Google Authenticator, Authy) to
                    set up Two-Factor Authentication.</p>
                <div id="qrcode" class="mx-auto border p-2 rounded-lg mb-4">
                </div>
                <p class="text-xs font-mono break-all p-2 bg-gray-100 rounded">Secret: <span id="twoFactorSecret"></span>
                </p>
            </div>

            <form id="twoFactorForm" class="space-y-6">
                <input type="hidden" id="twoFactorEmail">

                <div>
                    <label for="otpCode" class="block text-sm font-medium mb-2" style="color: #021056;">
                        Authentication Code
                    </label>
                    <input type="text" name="otpCode" id="otpCode" placeholder="Enter 6-digit code" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#1169FB] focus:border-transparent transition duration-150 text-center tracking-widest"
                        maxlength="6" pattern="\d{6}" style="color: #021056; background-color: white;">
                </div>

                <div class="pt-4">
                    <button type="submit" id="verify2FAButton"
                        class="w-full flex items-center justify-center py-3 px-4 rounded-lg text-lg font-semibold text-white shadow-md hover:shadow-lg transition duration-300 ease-in-out"
                        style="background-color: #1169FB;">
                        Verify & Log In
                    </button>
                </div>
            </form>
            <p id="twoFAModalBack" class="mt-4 text-center text-sm font-medium hover:underline cursor-pointer"
                style="color: #1169FB;">
                &larr; Back to Login
            </p>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Store the user's email temporarily for 2FA verification
        let currentAuthEmail = '';
        // Store the temporary access token for 2FA setup (enable_2fa status)
        let tempAccessToken = '';

        // Helper function to set button state
        function setButtonLoading(button, isLoading, originalText = 'Log In') {
            button.disabled = isLoading;
            button.innerHTML = isLoading ?
                `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...` : originalText;
        }

        // Helper function to show 2FA modal
        function showTwoFAModal(title, email, isSetupMode = false, qrCodeUrl = null, secret = null) {


            document.getElementById("twoFactorModal").style.display = 'flex';
            document.getElementById("twoFactorTitle").innerText = title;
            document.getElementById("twoFactorEmail").value = email;

            // Setup mode: show QR code
            if (isSetupMode) {
                // const qrCodeKeyUri = qrCodeUrl; // This is your otpauth://... string

                // The library renders the QR code inside the <div> with id="qrcode"
                const qr = new QRCode(document.getElementById("qrcode"), {
                    text: qrCodeUrl, // <-- The essential part: pass the URI string here
                    width: 200, // Optional: Set the size
                    height: 200, // Optional: Set the size
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H // High error correction level
                });

                //

                // Construct the Google Charts API URL
                // const googleChartApiUrl = `https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=${encodeURIComponent(qrCodeKeyUri)}`;
                document.getElementById("qrCodeSection").classList.remove('hidden');
                // document.getElementById("qrcode").src = qrCodeUrl;
                document.getElementById("twoFactorSecret").innerText = secret;
            } else {
                // Verification mode: hide QR code
                document.getElementById("qrCodeSection").classList.add('hidden');
            }
        }

        // Helper function to hide 2FA modal
        function hideTwoFAModal() {
            document.getElementById("twoFactorModal").style.display = 'none';
            document.getElementById("twoFactorErrorMessageContainer").classList.add('hidden');
            document.getElementById("twoFactorErrorMessage").innerText = '';
            document.getElementById("otpCode").value = ''; // Clear OTP field
        }


        // --- LOGIN FORM SUBMISSION HANDLER ---
        document.getElementById("loginForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const loginButton = document.getElementById("loginButton");
            const errorMessageContainer = document.getElementById("errorMessageContainer");
            const errorMessage = document.getElementById("errorMessage");
            currentAuthEmail = document.getElementById("email").value;

            setButtonLoading(loginButton, true, 'Log In');
            errorMessageContainer.classList.add('hidden');
            errorMessage.innerText = '';

            fetch("http://localhost:8000/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        // NOTE: X-CSRF-TOKEN is typically not needed for a stateless API login with JWT.
                        // Keeping it here for Laravel Blade context, but good to know for API development.
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]') ? document
                            .querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                    },
                    body: JSON.stringify({
                        login: currentAuthEmail,
                        password: document.getElementById("password").value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    localStorage.setItem('api_token', data
                        .access_token);

                    // Assuming 'response.token' holds the value
                    if (data.status === '2fa_required') {

                        // Admin/Super Admin needs to verify 2FA before login
                        tempAccessToken = data
                            .access_token; // Keep token for potential future use or re-login flow
                        showTwoFAModal('2FA Verification Required', currentAuthEmail, false);
                        document.getElementById('twoFactorForm').setAttribute('data-mode', 'verify');

                    } else if (data.status === 'enable_2fa') {
                        // Admin/Super Admin needs to SET UP 2FA
                        tempAccessToken = data
                            .access_token; // Use this token to authenticate the enable2FA API call
                        return enable2FA(data.access_token);

                    } else if (data.access_token && data.token_type === 'bearer') {
                        // Successful login for non-admin user or admin after a flow change
                        localStorage.setItem('token', data.access_token);
                        // The backend should return user data here if needed, but the current respondWithToken does not.
                        // Let's assume you'll update the backend response for non-2fa users to be consistent or
                        // rely on a separate API call post-login. For now, redirect.
                        document.cookie = `token=${data.token}; path=/; SameSite=Lax`;
                        window.location.href = "/platform-overview";

                    } else if (data.error) {
                        // Failed login (e.g., Invalid credentials - 401 response from backend)
                        errorMessage.innerText = data.error;
                        errorMessageContainer.classList.remove('hidden');

                    } else {
                        // Fallback error
                        errorMessage.innerText = "An unknown error occurred. Please try again.";
                        errorMessageContainer.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    // Network or unhandled error
                    console.error(err);
                    errorMessage.innerText =
                        "Could not connect to the server. Check your network or try again later.";
                    errorMessageContainer.classList.remove('hidden');
                })
                .finally(() => {
                    setButtonLoading(loginButton, false, 'Log In');
                });
        });

        // --- 2FA ENABLE/SETUP FLOW ---
        function enable2FA(tempToken) {
            const loginButton = document.getElementById("loginButton");

            fetch("http://localhost:8000/api/2fa/enable", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        // The key change: use the temporary token for API call
                        "Authorization": `Bearer ${tempToken}`
                    },
                })
                .then(res => res.json())
                .then(data => {


                    if (data.status === 'setup_initiated' && data.qrcode_url) {
                        showTwoFAModal(
                            'Setup Two-Factor Authentication',
                            currentAuthEmail,
                            true,
                            data.qrcode_url,
                            data.secret
                        );
                        document
                            .getElementById('twoFactorForm')
                            .setAttribute('data-mode', 'setup-verify');
                    } else {
                        console.error(data);
                        alert(data.error || "Failed to initiate 2FA setup.");
                    }
                })

                .catch(err => {
                    console.error("2FA Enable Error:", err);
                    alert("An error occurred during 2FA setup initiation.");
                })
                .finally(() => {
                    setButtonLoading(loginButton, false, 'Log In');
                });
        }

        // --- 2FA FORM SUBMISSION HANDLER (Verification) ---
        document.getElementById("twoFactorForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const verifyButton = document.getElementById("verify2FAButton");
            const errorMessageContainer = document.getElementById("twoFactorErrorMessageContainer");
            const errorMessage = document.getElementById("twoFactorErrorMessage");
            const otpCode = document.getElementById("otpCode").value;
            const mode = e.currentTarget.getAttribute('data-mode');

            setButtonLoading(verifyButton, true, 'Verify & Log In');
            errorMessageContainer.classList.add('hidden');
            errorMessage.innerText = '';

            // Verification API call
            fetch("http://localhost:8000/api/2fa/verify", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    },
                    body: JSON.stringify({
                        email: document.getElementById("twoFactorEmail").value,
                        otp: otpCode
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === 'success' && data.token) {
                        localStorage.setItem('token', data.token);

                        // --- ADD THIS BLOCK ---
                        // Set a cookie so the browser sends the token on reload/redirect
                        document.cookie = `token=${data.token}; path=/; max-age=86400; SameSite=Lax`;
                        // ----------------------

                        if (data.user) {
                            localStorage.setItem("user", JSON.stringify(data.user));
                        }

                        window.location.href = "{{ route('platform_overview.index') }}";
                    } else if (data.error) {
                        // Failed verification (e.g., Invalid OTP)
                        errorMessage.innerText = data.error;
                        errorMessageContainer.classList.remove('hidden');
                    } else {
                        errorMessage.innerText = "Verification failed. Please check your code and try again.";
                        errorMessageContainer.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    console.error("2FA Verification Error:", err);
                    errorMessage.innerText = "Could not connect to the verification server. Try again.";
                    errorMessageContainer.classList.remove('hidden');
                })
                .finally(() => {
                    // Adjust button text based on the mode
                    setButtonLoading(verifyButton, false, 'Verify & Log In');
                });
        });

        // --- BACK BUTTON HANDLER ---
        document.getElementById("twoFAModalBack").addEventListener("click", function() {
            hideTwoFAModal();
            // Clear temporary data on back
            tempAccessToken = '';
            currentAuthEmail = '';
        });
    </script>
@endpush

@push('styles')
    <style>
        body {
            font-family: 'Poppins';
        }
    </style>
@endpush
