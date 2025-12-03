<h1>Hello world</h1>

<button id="logoutBtn"
    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition rounded-lg">
   Logout
</button>

<script>
document.getElementById("logoutBtn").addEventListener("click", function () {
    
    let token = localStorage.getItem("token");

    if (!token) {
        alert("Token not found. Please login first.");
        window.location.href = "/auth/login";
        return;
    }

    fetch("http://localhost:8000/api/auth/logout", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Bearer " + token
        }
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);

        // remove token from browser
        localStorage.removeItem("token");

        // redirect to login
        window.location.href = "/auth/login";
    })
    .catch(err => console.error("Logout error:", err));
});
</script>
