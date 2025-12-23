<!DOCTYPE html>
<html lang="en">

{{-- <head>
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
</head> --}}
<x-partials.head />

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    @yield('content')

    

  @stack('scripts')
</body>

</html>
