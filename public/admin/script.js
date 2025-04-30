// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Search functionality
function searchTable(input, tableId) {
    let filter = input.value.toLowerCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let found = false;
        let td = tr[i].getElementsByTagName("td");
        for (let j = 0; j < td.length; j++) {
            let cell = td[j];
            if (cell) {
                let text = cell.textContent || cell.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        tr[i].style.display = found ? "" : "none";
    }
}

// Filter functionality
function filterTable(select, tableId) {
    let filter = select.value.toLowerCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td");
        let statusCell = td[3]; // Assuming status is in the 4th column
        if (statusCell) {
            let status = statusCell.textContent || statusCell.innerText;
            tr[i].style.display = filter === "" || status.toLowerCase().includes(filter) ? "" : "none";
        }
    }
}

// Add loading animation for buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function() {
        if (!this.classList.contains('btn-loading')) {
            this.classList.add('btn-loading');
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            
            // Simulate loading state
            setTimeout(() => {
                this.classList.remove('btn-loading');
                this.innerHTML = originalText;
            }, 1000);
        }
    });
});

// Handle form submissions with validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});

// Handle file uploads with preview
document.querySelectorAll('.custom-file-input').forEach(input => {
    input.addEventListener('change', function() {
        const fileName = this.files[0].name;
        const label = this.nextElementSibling;
        label.textContent = fileName;

        // If there's an image preview element
        const preview = document.querySelector('.image-preview');
        if (preview && this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});

// Add confirmation for delete actions
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(e) {
        if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            e.preventDefault();
        }
    });
});

// Add notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show notification`;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Initialize date display
document.addEventListener('DOMContentLoaded', function() {
    const dateElement = document.getElementById('currentDate');
    if (dateElement) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateElement.textContent = new Date().toLocaleDateString('id-ID', options);
    }
});
