@extends('layouts.app')

@section('content')

    <script>
        window.profileSettings = function() {
            return {
                activeTab: 'general',
                isLoading: false,
                isPasswordLoading: false,
                message: {
                    text: '',
                    type: ''
                },
                user: {
                    id: '',
                    name: '',
                    email: '',
                    phone: ''
                },
                userRole: 'Admin',
                profileImagePreview: 'https://placehold.co/256x256/3b82f6/ffffff?text=Admin',
                passwords: {
                    current: '',
                    new: '',
                    confirm: ''
                },

                init() {
                     const storedUser = JSON.parse(localStorage.getItem('user') || '{}');
                    if (storedUser.id) {
                        this.user.id = storedUser.id;
                        this.user.name = storedUser.name || '';
                        this.user.email = storedUser.email || '';
                        this.user.phone = storedUser.phone || '';

                        if (storedUser.roles && storedUser.roles.length > 0) {
                            this.userRole = storedUser.roles[0].name;
                        }

                         const initials = this.user.name ? this.user.name.substring(0, 2).toUpperCase() : 'AD';
                        this.profileImagePreview = storedUser.image || storedUser.avatar ||
                            `https://placehold.co/256x256/1169FB/ffffff?text=${initials}`;
                    }
                },

                handleImageUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.profileImagePreview = URL.createObjectURL(file);
                    }
                },

                async updateProfile() {
                    this.isLoading = true;
                    this.message.text = '';
                    const token = localStorage.getItem('token');

                    try {
                        let formData = new FormData();
                        formData.append('name', this.user.name);
                        formData.append('phone', this.user.phone);

                        const fileInput = document.getElementById('avatar_upload');
                        if (fileInput.files.length > 0) {
                            formData.append('image', fileInput.files[0]);
                        }

                        const res = await fetch(`{{ url('/api/update/profile') }}`, {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: formData
                        });

                        const data = await res.json();

                        if (!res.ok || data.status === false) throw new Error(data.message || 'Failed to update profile');

                        const storedUser = JSON.parse(localStorage.getItem('user') || '{}');
                        storedUser.name = this.user.name;
                        storedUser.phone = this.user.phone;

                        if (data.data && data.data.profile_image_url) {
                            storedUser.image = data.data.profile_image_url;
                            this.profileImagePreview = data.data.profile_image_url;
                        }

                        localStorage.setItem('user', JSON.stringify(storedUser));

                        this.showMessage('Profile updated successfully!', 'success');
                    } catch (error) {
                        this.showMessage(error.message, 'error');
                    } finally {
                        this.isLoading = false;
                    }
                },

                async updatePassword() {
                    if (this.passwords.new !== this.passwords.confirm) {
                        this.showMessage('New passwords do not match!', 'error');
                        return;
                    }

                    this.isPasswordLoading = true;
                    this.message.text = '';
                    const token = localStorage.getItem('token');

                    try {
                        const res = await fetch(`{{ url('/api/password/update') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${token}`,
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: JSON.stringify({
                                current_password: this.passwords.current,
                                password: this.passwords.new,
                                password_confirmation: this.passwords.confirm
                            })
                        });

                        const data = await res.json();
                        if (!res.ok) throw new Error(data.message || 'Failed to update password');

                        this.showMessage('Password updated successfully!', 'success');

                        this.passwords = { current: '', new: '', confirm: '' };
                    } catch (error) {
                        this.showMessage(error.message, 'error');
                    } finally {
                        this.isPasswordLoading = false;
                    }
                },

                showMessage(text, type) {
                    this.message = { text, type };
                    setTimeout(() => {
                        if (this.message.text === text) {
                            this.message.text = '';
                        }
                    }, 5000);
                }
            };
        };
    </script>


    <div class="max-w-5xl mx-auto" x-data="window.profileSettings()">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#021056]">Profile Settings</h1>
            <p class="text-gray-500 mt-1">Manage account details, security, and preferences.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <div class="w-full md:w-64 bg-gray-50 border-b md:border-b-0 md:border-r border-gray-100 p-4">
                    <nav class="flex md:flex-col space-x-2 md:space-x-0 md:space-y-2 overflow-x-auto">
                        <button @click="activeTab = 'general'"
                            :class="activeTab === 'general' ? 'bg-blue-50 text-[#1169FB] font-semibold' : 'text-gray-600 hover:bg-gray-100'"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors whitespace-nowrap w-full text-left">
                            <i class="fa-regular fa-user w-5 mr-2"></i> General Info
                        </button>
                        <button @click="activeTab = 'security'"
                            :class="activeTab === 'security' ? 'bg-blue-50 text-[#1169FB] font-semibold' : 'text-gray-600 hover:bg-gray-100'"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors whitespace-nowrap w-full text-left">
                            <i class="fa-solid fa-shield-halved w-5 mr-2"></i> Security
                        </button>
                        <button @click="activeTab = 'preferences'"
                            :class="activeTab === 'preferences' ? 'bg-blue-50 text-[#1169FB] font-semibold' : 'text-gray-600 hover:bg-gray-100'"
                            class="flex items-center px-4 py-3 rounded-lg transition-colors whitespace-nowrap w-full text-left">
                            <i class="fa-solid fa-sliders w-5 mr-2"></i> Preferences
                        </button>
                    </nav>
                </div>

                <div class="flex-1 p-6 md:p-8">

                    <div x-show="message.text" x-transition
                        :class="message.type === 'success' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200'"
                        class="mb-6 p-4 rounded-lg border flex items-start" style="display: none;">
                        <i :class="message.type === 'success' ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-exclamation'"
                            class="mt-0.5 mr-3"></i>
                        <span x-text="message.text" class="text-sm font-medium"></span>
                        <button @click="message.text = ''" class="ml-auto text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        <h2 class="text-xl font-bold text-[#021056] mb-6">General Information</h2>

                        <form @submit.prevent="updateProfile" class="space-y-6">
                            <div class="flex items-center space-x-6">
                                <div class="relative">
                                    <img :src="profileImagePreview"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-gray-50 shadow-sm"
                                        alt="Profile">
                                    <label for="avatar_upload"
                                        class="absolute bottom-0 right-0 bg-[#1169FB] text-white p-2 rounded-full cursor-pointer shadow-md hover:bg-blue-700 transition">
                                        <i class="fa-solid fa-camera text-sm"></i>
                                        <input type="file" id="avatar_upload" class="hidden" accept="image/*"
                                            @change="handleImageUpload">
                                    </label>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800">Profile Photo</h3>
                                    <p class="text-xs text-gray-500 mt-1">Recommended size: 256x256px. Max: 2MB.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" x-model="user.name"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1169FB] focus:border-[#1169FB] outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" x-model="user.email" disabled
                                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 rounded-lg text-gray-500 cursor-not-allowed">
                                    <p class="text-xs text-gray-400 mt-1">Contact super-admin to change email.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="text" x-model="user.phone" placeholder="+1 234 567 8900"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1169FB] focus:border-[#1169FB] outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <input type="text" x-model="userRole" disabled
                                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 rounded-lg text-gray-500 cursor-not-allowed capitalize">
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex justify-end">
                                <button type="submit" :disabled="isLoading"
                                    class="bg-[#021056] text-white px-6 py-2.5 rounded-lg font-medium hover:bg-[#0a1b6b] transition disabled:opacity-70 flex items-center">
                                    <span x-show="!isLoading">Save Changes</span>
                                    <span x-show="isLoading"><i class="fa-solid fa-spinner fa-spin mr-2"></i>
                                        Saving...</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div x-show="activeTab === 'security'" style="display: none;"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        <h2 class="text-xl font-bold text-[#021056] mb-6">Security Settings</h2>

                        <form @submit.prevent="updatePassword" class="space-y-6 max-w-md">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" x-model="passwords.current" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1169FB] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" x-model="passwords.new" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1169FB] outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" x-model="passwords.confirm" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1169FB] outline-none">
                            </div>

                            <div class="pt-2">
                                <button type="submit" :disabled="isPasswordLoading"
                                    class="bg-[#1169FB] text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition disabled:opacity-70 flex items-center">
                                    <span x-show="!isPasswordLoading">Update Password</span>
                                    <span x-show="isPasswordLoading"><i class="fa-solid fa-spinner fa-spin mr-2"></i>
                                        Updating...</span>
                                </button>
                            </div>
                        </form>

                        <hr class="my-8 border-gray-100">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Two-Factor Authentication (2FA)</h3>
                            <p class="text-sm text-gray-500 mb-4">Add an extra layer of security to your account by
                                requiring a code from an authenticator app.</p>

                            <div
                                class="flex items-center justify-between p-4 border border-gray-200 rounded-xl bg-gray-50">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-4">
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Authenticator App</p>
                                        <p class="text-xs text-gray-500">Google Authenticator, Authy, etc.</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked disabled>
                                    <div
                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1169FB]">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'preferences'" style="display: none;"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        <h2 class="text-xl font-bold text-[#021056] mb-6">System Preferences</h2>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-md font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">Email
                                    Notifications</h3>

                                <div class="space-y-4">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox"
                                            class="form-checkbox h-5 w-5 text-[#1169FB] rounded border-gray-300 focus:ring-[#1169FB]"
                                            checked>
                                        <span class="ml-3 text-sm text-gray-700">Security Alerts (Logins from new
                                            devices)</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox"
                                            class="form-checkbox h-5 w-5 text-[#1169FB] rounded border-gray-300 focus:ring-[#1169FB]"
                                            checked>
                                        <span class="ml-3 text-sm text-gray-700">Daily System Health Reports</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox"
                                            class="form-checkbox h-5 w-5 text-[#1169FB] rounded border-gray-300 focus:ring-[#1169FB]">
                                        <span class="ml-3 text-sm text-gray-700">Marketing & Promotional updates</span>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-4">
                                <h3 class="text-md font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">
                                    Dashboard Display</h3>

                                <div class="flex items-center justify-between max-w-sm">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Compact Sidebar</p>
                                        <p class="text-xs text-gray-500">Minimize the sidebar by default</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#021056]">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-checkbox {
            appearance: none;
            background-color: #fff;
            margin: 0;
            font: inherit;
            color: currentColor;
            width: 1.25em;
            height: 1.25em;
            border: 2px solid #e5e7eb;
            border-radius: 0.25em;
            display: grid;
            place-content: center;
            transition: 0.2s all ease-in-out;
        }

        .form-checkbox::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em white;
            background-color: white;
            transform-origin: bottom left;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }

        .form-checkbox:checked {
            background-color: #1169FB;
            border-color: #1169FB;
        }

        .form-checkbox:checked::before {
            transform: scale(1);
        }
    </style>
@endpush