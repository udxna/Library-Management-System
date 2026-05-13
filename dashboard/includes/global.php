<style>

/* Global Dark Mode */

.dark-mode{
    background:#121212 !important;
    color:white !important;
}

.dark-mode .card{
    background:#1f1f1f !important;
    color:white !important;
}

.dark-mode .table{
    color:white !important;
}

.dark-mode .table-dark{
    background:#000 !important;
}

.dark-mode .form-control{
    background:#2a2a2a !important;
    color:white !important;
    border:none !important;
}

.dark-mode .form-control::placeholder{
    color:#ccc !important;
}

.dark-mode .topbar{
    background:#1f1f1f !important;
    color:white !important;
}

.dark-mode .sidebar{
    background:#111827 !important;
}

.dark-mode .btn{
    border:none;
}

</style>

<script>

function toggleDarkMode(){

    document.body.classList.toggle("dark-mode");

    if(document.body.classList.contains("dark-mode")){

        localStorage.setItem("darkMode", "enabled");

    } else {

        localStorage.setItem("darkMode", "disabled");

    }

}

// Load dark mode on every page

window.onload = function(){

    if(localStorage.getItem("darkMode") === "enabled"){

        document.body.classList.add("dark-mode");

    }

}

</script>
<?php

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: ../auth/login.php");
    exit();

}
?>