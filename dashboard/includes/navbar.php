<style>

.topbar{
    background:white;
    border-radius:15px;
    padding:15px 20px;
    margin-bottom:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);

    width:100%;
    margin-left:0;
}

/* Search */

.search-box{
    width:50%;
}

/* Dark Mode */

.dark-mode{
    background:#121212;
    color:white;
}

.dark-mode .topbar{
    background:#1f1f1f;
    color:white;
}

.dark-mode .card{
    background:#1f1f1f;
    color:white;
}

.dark-mode table{
    color:white;
}

</style>

<!-- Topbar -->

<div class="topbar">

    <!-- Page Title -->

    <h4 class="fw-bold mb-0">
        LMS
    </h4>

    <!-- Search -->

    <input type="text"
           id="search"
           class="form-control search-box"
           placeholder="Search..."
           onkeyup="searchTable()">

    <!-- Dark Mode -->

    <button class="btn btn-dark rounded-3"
            onclick="toggleDarkMode()">

        <i class="bi bi-moon"></i>

    </button>

</div>

<script>

function toggleDarkMode(){

    document.body.classList.toggle("dark-mode");

    // Save mode

    if(document.body.classList.contains("dark-mode")){

        localStorage.setItem("darkMode", "enabled");

    } else {

        localStorage.setItem("darkMode", "disabled");

    }

}

// Load mode automatically

window.onload = function(){

    if(localStorage.getItem("darkMode") === "enabled"){

        document.body.classList.add("dark-mode");

    }

}


function searchTable(){

    let input =
        document.getElementById("search");

    let filter =
        input.value.toLowerCase();

    let rows =
        document.querySelectorAll("table tbody tr");

    rows.forEach(row => {

        row.style.display =
            row.innerText
                .toLowerCase()
                .includes(filter)
            ? ""
            : "none";

    });

}

</script>