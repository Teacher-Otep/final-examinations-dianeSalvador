// Function to show selected section (Task 4)
function showSection(sectionID) {
    // Select both .content and .homecontent sections
    const sections = document.querySelectorAll('.content, .homecontent');

    // Hide all of them
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Display the clicked section
    const activeSection = document.getElementById(sectionID);
    if (activeSection) {
        activeSection.style.display = 'block';
    }
}

// Task 5: Clear Fields Function
document.addEventListener('DOMContentLoaded', () => {
    const clrBtn = document.getElementById('clrbtn');
    if (clrBtn) {
        clrBtn.addEventListener('click', function() {
            const inputs = document.querySelectorAll('.field');
            inputs.forEach(input => input.value = '');
        });
    }

    // Task 2a: Logo Click Event (Hide .content sections)
    const logo = document.getElementById('logo');
    if (logo) {
        logo.addEventListener('click', function() {
            const contents = document.querySelectorAll('.content');
            contents.forEach(sec => sec.style.display = 'none');
            // Show home section
            showSection('home');
        });
    }
});

// Insertion success toast logic
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
        const toast = document.getElementById('success-toast');
        if (toast) {
            toast.classList.remove('toast-hidden');
            
            // Hide it automatically after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    toast.classList.add('toast-hidden');
                }, 500);
            }, 3000);
        }
        // Clean the URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

