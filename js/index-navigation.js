function openNav() {
    // Check the window width and adjust the margin and panel width accordingly.
    if (window.innerWidth < 820) {
        if (window.innerWidth < 480) {
            // Adjust the margin for smaller screens.
            document.getElementById("main").style.marginLeft = "20px";
        } else {
            // Adjust the margin for medium-sized screens.
            document.getElementById("main").style.marginLeft = "100px";
        }
        // Adjust the panel width for all smaller screens.
        document.getElementById("side-panel").style.width = "180px";
    } else {
        // Adjust the panel width for larger screens.
        document.getElementById("side-panel").style.width = "270px";
        // Adjust the margin for larger screens.
        document.getElementById("main").style.marginLeft = "250px";
    }
}

function closeNav() {
    // Reset the panel and margin width to zero.
    document.getElementById("side-panel").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}
