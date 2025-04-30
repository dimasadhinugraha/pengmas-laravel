// Sidebar Toggle
const toggler = document.querySelector(".toggle-btn");
const sidebar = document.getElementById("sidebar");
let isSidebarExpanded = false;

toggler.addEventListener("click", function () {
    isSidebarExpanded = !isSidebarExpanded;
    sidebar.classList.toggle("expand");
    
    // Animate toggle button
    toggler.style.transform = isSidebarExpanded ? "rotate(180deg)" : "rotate(0deg)";
});

// Close sidebar when clicking outside on mobile
document.addEventListener("click", function (e) {
    if (window.innerWidth <= 768) {
        if (!sidebar.contains(e.target) && !toggler.contains(e.target)) {
            sidebar.classList.remove("expand");
            isSidebarExpanded = false;
            toggler.style.transform = "rotate(0deg)";
        }
    }
});

// Add active class to current page link
const currentPage = window.location.pathname.split("/").pop();
const sidebarLinks = document.querySelectorAll(".sidebar-link");

sidebarLinks.forEach(link => {
    if (link.getAttribute("href") === currentPage) {
        link.classList.add("active");
        link.style.backgroundColor = "rgba(255, 255, 255, 0.1)";
        link.style.borderLeft = "3px solid #3b7ddd";
    }
});

// Form validation with custom styling
const forms = document.querySelectorAll('.needs-validation');
forms.forEach(form => {
    form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Add shake animation to invalid fields
            const invalidFields = form.querySelectorAll(':invalid');
            invalidFields.forEach(field => {
                field.classList.add('shake');
                setTimeout(() => field.classList.remove('shake'), 600);
            });
        }
        form.classList.add('was-validated');
    }, false);
});

// Add loading spinner
function showLoading(buttonElement) {
    const originalText = buttonElement.innerHTML;
    buttonElement.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>Loading...';
    buttonElement.disabled = true;
    return originalText;
}

function hideLoading(buttonElement, originalText) {
    buttonElement.innerHTML = originalText;
    buttonElement.disabled = false;
}

// Add smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Add confirmation dialog
function confirmAction(message, callback) {
    const confirmed = window.confirm(message);
    if (confirmed && typeof callback === 'function') {
        callback();
    }
    return confirmed;
}

// Table sorting
function sortTable(table, column) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const isNumeric = rows.every(row => !isNaN(row.children[column].textContent.trim()));
    
    rows.sort((a, b) => {
        const aValue = a.children[column].textContent.trim();
        const bValue = b.children[column].textContent.trim();
        
        if (isNumeric) {
            return parseFloat(aValue) - parseFloat(bValue);
        }
        return aValue.localeCompare(bValue);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// Table search
function searchTable(input, tableId) {
    const table = document.getElementById(tableId);
    const rows = table.getElementsByTagName('tr');
    const filter = input.value.toLowerCase();

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < cells.length; j++) {
            const cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        rows[i].style.display = found ? '' : 'none';
    }
}

// File upload preview
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
    notification.style.zIndex = '9999';
    notification.style.maxWidth = '300px';
    notification.style.opacity = '0';
    notification.style.transform = 'translateY(-20px)';
    notification.style.transition = 'all 0.3s ease-in-out';
    
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 100);
    
    // Auto dismiss
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Initialize all interactive elements
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Add smooth scroll behavior to all internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
