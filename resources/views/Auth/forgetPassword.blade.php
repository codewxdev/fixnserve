@extends('layouts.auth')

@section('content')
    <div id="emailFormContainer"
        class="w-full max-w-md p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl"
        style="background-color: white;">
        <h1 class="text-3xl font-bold mb-4 text-center" style="color: #021056;">
            Forgot Password
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Enter your email address to receive a security code.
        </p>

        <div id="messageContainer" class="hidden px-4 py-3 rounded relative mb-6" role="alert">
            <p id="feedbackMessage" class="font-medium text-sm"></p>
        </div>

        <form id="forgotPasswordForm" onsubmit="event.preventDefault();" class="space-y-6">
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
                <a href="{{ route('login') }}" class="font-bold hover:underline" style="color: #1169FB;">Log
                    In</a>
            </p>
        </div>
    </div>

    <div id="otpModal" class="hidden fixed inset-0 flex items-center justify-center modal-overlay">
        <div class="bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl transform scale-100 transition-transform duration-300"
            style="color: #021056;">

            <h2 class="text-2xl font-bold mb-3 text-center">Verify Security Code</h2>
            <p class="text-center text-gray-500 mb-6 text-sm">
                A 6-digit code has been sent to the email provided.
            </p>

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
            z-index: 50;
        }

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
            container.classList.remove('hidden', 'bg-red-100', 'border-red-400', 'text-red-700', 'bg-green-100', 'border-green-400', 'text-green-700');
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
        }

        // 🔴 FIX: Robust Error Extractor
        async function handleApiResponse(res) {
            const data = await res.json();
            
            if (!res.ok || data.status === false) {
                let errorMsg = data.message || "An error occurred.";
                
                // Laravel Validation Errors Handling
                if (data.errors) {
                    const firstKey = Object.keys(data.errors)[0];
                    errorMsg = Array.isArray(data.errors[firstKey]) ? data.errors[firstKey][0] : data.errors[firstKey];
                } else if (data.error) {
                    errorMsg = data.error;
                }
                
                throw new Error(errorMsg);
            }
            return data;
        }

        // --- 1. Reusable OTP Verification Function ---
        function verifyOtp(otpValue) {
            clearMessage(modalMessageContainer);
            setLoadingState(otpSubmitButton, true, 'Verifying...');

            fetch("{{ url('/api/password/verify-code') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    email: document.getElementById("email").value,
                    code: otpValue
                })
            })
            .then(handleApiResponse)
            .then(data => {
                // OTP VERIFIED SUCCESSFULLY
                localStorage.setItem("reset_email", document.getElementById("email").value);
                localStorage.setItem("reset_code", otpValue);
                
                // Redirecting to reset password page
                window.location.href = "/auth/password/reset?email=" + encodeURIComponent(document.getElementById("email").value); 
            })
            .catch(err => {
                displayMessage(modalMessageContainer, err.message, true);
                setLoadingState(otpSubmitButton, false, 'Verify Code');
            });
        }

        // --- 2. Email Submission Logic (Send Code) ---
        forgotPasswordForm.addEventListener("submit", function(e) {
            e.preventDefault();

            const emailInput = document.getElementById("email").value;
            clearMessage(messageContainer);
            setLoadingState(submitButton, true, 'Sending...');

            fetch("{{ url('/api/password/forgot') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ email: emailInput })
            })
            .then(handleApiResponse)
            .then(data => {
                // SUCCESS
                displayMessage(messageContainer, data.message || "Success! A security code has been sent to your email.", false);

                // Open Modal
                otpModal.classList.remove('hidden');
                body.classList.add('modal-active');
                clearMessage(modalMessageContainer);
                otpInput.value = '';
                otpSubmitButton.disabled = true;
            })
            .catch(err => {
                displayMessage(messageContainer, err.message, true);
            })
            .finally(() => {
                setLoadingState(submitButton, false, 'Send Security Code');
            });
        });

        // --- 3. OTP Real-time Check and Auto-Submit ---
        otpInput.addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            const otpValue = this.value;

            if (otpValue.length === 6) {
                otpSubmitButton.disabled = false;
                verifyOtp(otpValue);
            } else {
                otpSubmitButton.disabled = true;
                clearMessage(modalMessageContainer);
                setLoadingState(otpSubmitButton, false, 'Verify Code');
            }
        });

        // --- 4. OTP Form Submission (Fallback for Enter Key) ---
        otpForm.addEventListener("submit", function(e) {
            e.preventDefault();
            verifyOtp(otpInput.value);
        });

        // --- 5. Resend Link Handler (REAL API) ---
        document.getElementById("resendLink").addEventListener("click", function(e) {
            e.preventDefault();
            const email = document.getElementById("email").value;
            
            clearMessage(modalMessageContainer);
            displayMessage(modalMessageContainer, "Sending new code...", false);

            fetch("{{ url('/api/password/forgot') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ email: email })
            })
            .then(handleApiResponse)
            .then(data => {
                displayMessage(modalMessageContainer, data.message || "A new security code has been sent to your email.", false);
                otpInput.value = "";
                otpSubmitButton.disabled = true;
                otpInput.classList.add("ring", "ring-green-400");
                setTimeout(() => otpInput.classList.remove("ring", "ring-green-400"), 500);
            })
            .catch(err => {
                displayMessage(modalMessageContainer, err.message, true);
            });
        });
    </script>
@endpush