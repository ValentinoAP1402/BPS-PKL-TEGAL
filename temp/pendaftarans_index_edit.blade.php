@if(session('success'))
    <div id="successAlert" class="alert alert-success">
        <div class="alert-icon">✓</div>
        <div class="alert-content">
            <div class="alert-title">Berhasil!</div>
            <div class="alert-message">{{ session('success') }}</div>
        </div>
    </div>
@endif

<script>
    // Auto hide alert after 5 seconds
    const alert = document.getElementById('successAlert');
    if (alert) {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(-100px)';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    }
</script>
