/**
 * Navigation Highlight Script
 * Automatically adds 'active' class to navigation items based on current URL
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get current URL path
    const currentPath = window.location.pathname;
    
    // Get all nav links
    const navLinks = document.querySelectorAll('.navbar-menu .nav-link');
    
    // Loop through each nav link
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        // Skip links without href or with # href
        if (!href || href === '#') return;
        
        // Check if the current path matches the link's href
        if (currentPath === href || currentPath.startsWith(href) && href !== '/') {
            // Add active class to the link's parent (nav-item)
            const parentItem = link.closest('.nav-item');
            if (parentItem) {
                parentItem.classList.add('active');
            }
            
            // If this is a submenu item, expand the parent menu
            const parentDropdown = link.closest('.menu-dropdown');
            if (parentDropdown) {
                const parentToggle = document.querySelector(`[data-bs-toggle="collapse"][href="#${parentDropdown.id}"]`);
                if (parentToggle) {
                    parentToggle.setAttribute('aria-expanded', 'true');
                    parentDropdown.classList.add('show');
                    
                    // Add active class to the parent menu item as well
                    const grandParentItem = parentToggle.closest('.nav-item');
                    if (grandParentItem) {
                        grandParentItem.classList.add('active');
                    }
                }
            }
        }
    });
});
