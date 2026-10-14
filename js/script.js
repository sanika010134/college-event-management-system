document.addEventListener("DOMContentLoaded", function() {
    // Find any paragraph tags that have color styles applied (our success/error messages)
    const messages = document.querySelectorAll("p[style*='color:green'], p[style*='color:red']");
    
    messages.forEach(function(msg) {
        // Wait 3 seconds, then fade out
        setTimeout(function() {
            msg.style.transition = "opacity 0.5s ease";
            msg.style.opacity = "0";
            
            // Remove from DOM after fade completes
            setTimeout(function() {
                msg.style.display = "none";
            }, 500);
        }, 3000);
    });
});