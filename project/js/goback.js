document.addEventListener("DOMContentLoaded", function() {
    // Restore scroll position if available
    if (sessionStorage.getItem("scrollPos")) {
        window.scrollTo(0, sessionStorage.getItem("scrollPos"));
        sessionStorage.removeItem("scrollPos"); // Clear after restoring
    }

    // Save scroll position when clicking the Comment button
    document.querySelectorAll(".comment-button").forEach(button => {
        button.addEventListener("click", function() {
            sessionStorage.setItem("scrollPos", window.scrollY);
        });
    });
});