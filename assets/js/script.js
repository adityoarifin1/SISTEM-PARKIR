// =============================================
// MODERN PARKING SYSTEM - JAVASCRIPT
// =============================================

// Dashboard Statistics Update
function updateDashboard() {
    fetch('api_stats.php')
        .then(response => response.json())
        .then(data => {
            const sisaElement = document.getElementById('stat-sisa');
            const aktifElement = document.getElementById('stat-aktif');

            if(sisaElement && aktifElement) {
                sisaElement.innerText = data.sisa;
                aktifElement.innerText = data.aktif;
            }
        })
        .catch(error => {
            console.error('Error fetching stats:', error);
        });
}

// Confirm Delete
function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
    return confirm(message);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update dashboard stats
    updateDashboard();
    
    // Auto-refresh every 3 seconds
    setInterval(updateDashboard, 3000);
    
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required], select[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#dc2626';
                    isValid = false;
                } else {
                    input.style.borderColor = '#e2e8f0';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang diperlukan');
            }
        });
    });
});