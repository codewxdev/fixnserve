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
                <zabel for="email" class="block text-sm font-medium mb-2" style="color: #021056;">Email
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
        const fpPromise = import('https://openfpcdn.io/fingerprintjs/v4').then(FingerprintJS => FingerprintJS.load());
    </script>

    <script>
        // 1. Global Variables
        let currentAuthEmail = '';
        let tempAccessToken = '';
        let currentVisitorId = '';
        let currentDeviceInfo = null;

        // 2. Helper Functions
        function setButtonLoading(button, isLoading, originalText = 'Log In') {
            if (!button) return;
            button.disabled = isLoading;
            button.innerHTML = isLoading ?
                `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg> Processing...` : originalText;
        }

        function showTwoFAModal(title, email, isSetupMode = false, qrCodeUrl = null, secret = null) {
            document.getElementById("twoFactorModal").style.display = 'flex';
            document.getElementById("twoFactorTitle").innerText = title;
            document.getElementById("twoFactorEmail").value = email;

            if (isSetupMode) {
                document.getElementById("qrcode").innerHTML = "";
                new QRCode(document.getElementById("qrcode"), {
                    text: qrCodeUrl,
                    width: 200,
                    height: 200,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
                document.getElementById("qrCodeSection").classList.remove('hidden');
                document.getElementById("twoFactorSecret").innerText = secret;
            } else {
                document.getElementById("qrCodeSection").classList.add('hidden');
            }
        }

        function hideTwoFAModal() {
            document.getElementById("twoFactorModal").style.display = 'none';
            document.getElementById("twoFactorErrorMessageContainer").classList.add('hidden');
            document.getElementById("twoFactorErrorMessage").innerText = '';
            document.getElementById("otpCode").value = '';
        }

        function getDeviceInfo() {
            const ua = navigator.userAgent;
            let browserName = "Unknown Browser";
            let osName = "Unknown OS";

            if (ua.indexOf("Win") !== -1) osName = "Windows";
            if (ua.indexOf("Mac") !== -1) osName = "MacOS";
            if (ua.indexOf("Linux") !== -1) osName = "Linux";
            if (ua.indexOf("Android") !== -1) osName = "Android";
            if (ua.indexOf("like Mac") !== -1) osName = "iOS";

            if (ua.indexOf("Firefox") > -1) browserName = "Firefox";
            else if (ua.indexOf("SamsungBrowser") > -1) browserName = "Samsung Internet";
            else if (ua.indexOf("Opera") > -1 || ua.indexOf("OPR") > -1) browserName = "Opera";
            else if (ua.indexOf("Trident") > -1) browserName = "Internet Explorer";
            else if (ua.indexOf("Edge") > -1) browserName = "Edge";
            else if (ua.indexOf("Chrome") > -1) browserName = "Chrome";
            else if (ua.indexOf("Safari") > -1) browserName = "Safari";

            return {
                os_version: osName,
                device_name: browserName + " on " + osName,
                app_version: navigator.appVersion,
                is_rooted: false
            };
        }

        // 3. Login Form Submission
        document.getElementById("loginForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const loginButton = document.getElementById("loginButton");
            const errorMessageContainer = document.getElementById("errorMessageContainer");
            const errorMessage = document.getElementById("errorMessage");
            currentAuthEmail = document.getElementById("email").value;

            setButtonLoading(loginButton, true, 'Log In');
            errorMessageContainer.classList.add('hidden');
            errorMessage.innerText = '';

            try {
                // Get Fingerprint
                let visitorId = "unknown-device-" + Math.random().toString(36).substring(2, 10);
                try {
                    const fp = await fpPromise;
                    const result = await fp.get();
                    visitorId = result.visitorId;
                } catch (fpError) {
                    console.warn("FingerprintJS fallback used.");
                }

                const deviceInfo = getDeviceInfo();
                currentVisitorId = visitorId;
                currentDeviceInfo = deviceInfo;

                const payload = {
                    login: currentAuthEmail,
                    password: document.getElementById("password").value,
                    fingerprint: visitorId,
                    device_name: deviceInfo.device_name,
                    os_version: deviceInfo.os_version,
                    app_version: deviceInfo.app_version,
                    is_rooted: deviceInfo.is_rooted
                };

                const res = await fetch("http://localhost:8000/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || ''
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (!res.ok) {
                    throw new Error(data.error || data.message || "Invalid credentials.");
                }

                if (data.status === '2fa_required') {
                    tempAccessToken = data.access_token; // Matches your login controller
                    // Fingerprint ko store karein taake 2FA modal ya baad mein use ho sakay
                    localStorage.setItem('device_fingerprint', currentVisitorId);
                    showTwoFAModal('2FA Verification Required', currentAuthEmail, false);
                } else if (data.status === 'enable_2fa') {
                    tempAccessToken = data.access_token; // Matches your login controller
                    enable2FA(data.access_token);
                    localStorage.setItem('device_fingerprint', currentVisitorId);
                } else if (data.access_token) {
                    localStorage.setItem('token', data.access_token);
                    document.cookie = `token=${data.access_token}; path=/; SameSite=Lax`;
                    window.location.href = "{{ route('platform_overview.index') }}";
                    localStorage.setItem('device_fingerprint', currentVisitorId);
                }
            } catch (err) {
                errorMessage.innerText = err.message;
                errorMessageContainer.classList.remove('hidden');
            } finally {
                setButtonLoading(loginButton, false, 'Log In');
            }
        });

        // 4. Enable 2FA Setup
        function enable2FA(tempToken) {
            fetch("http://localhost:8000/api/2fa/enable", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": `Bearer ${tempToken}`
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'setup_initiated' && data.qrcode_url) {
                        showTwoFAModal('Setup Two-Factor Authentication', currentAuthEmail, true, data.qrcode_url, data
                            .secret);
                    } else {
                        alert(data.error || "Failed to initiate 2FA setup.");
                    }
                })
                .catch(err => console.error("2FA Enable Error:", err));
        }

        // 5. Verify 2FA Form Submission (CRITICAL FIXES HERE)
        document.getElementById("twoFactorForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const verifyButton = document.getElementById("verify2FAButton");
            const errorMessageContainer = document.getElementById("twoFactorErrorMessageContainer");
            const errorMessage = document.getElementById("twoFactorErrorMessage");
            const otpCode = document.getElementById("otpCode").value;

            setButtonLoading(verifyButton, true, 'Verify & Log In');
            errorMessageContainer.classList.add('hidden');

            try {
                // Ensure device info is still available
                if (!currentVisitorId) {
                    const fp = await fpPromise;
                    const result = await fp.get();
                    currentVisitorId = result.visitorId;
                    currentDeviceInfo = getDeviceInfo();
                }

                const res = await fetch("http://localhost:8000/api/2fa/verify", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    },
                    body: JSON.stringify({
                        email: document.getElementById("twoFactorEmail").value,
                        otp: otpCode,
                        fingerprint: currentVisitorId,
                        device_name: currentDeviceInfo.device_name,
                        os_version: currentDeviceInfo.os_version,
                        app_version: currentDeviceInfo.app_version,
                        is_rooted: currentDeviceInfo.is_rooted
                    })
                });

                const data = await res.json();

                // Check for 'success' status and 'access_token' (matching your verify2FA controller)
                if (data.status === 'success' && data.access_token) {
                    localStorage.setItem('token', data.access_token);
                    document.cookie = `token=${data.access_token}; path=/; max-age=86400; SameSite=Lax`;

                    if (data.user) {
                        localStorage.setItem("user", JSON.stringify(data.user));
                    }

                    window.location.href = "{{ route('platform_overview.index') }}";
                } else {
                    errorMessage.innerText = data.error || "Verification failed. Check your code.";
                    errorMessageContainer.classList.remove('hidden');
                }
            } catch (err) {
                errorMessage.innerText = "Connection error. Please try again.";
                errorMessageContainer.classList.remove('hidden');
            } finally {
                setButtonLoading(verifyButton, false, 'Verify & Log In');
            }
        });

        document.getElementById("twoFAModalBack").addEventListener("click", hideTwoFAModal);
    </script>
@endpush

@push('styles')
    <style>
        body {
            font-family: 'Poppins';
        }
    </style>
@endpush
