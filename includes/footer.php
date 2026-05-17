</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert:not(.perm)');

    alerts.forEach(alert => {
        alert.style.transition = "0.5s";
        alert.style.opacity = "0";

        setTimeout(() => {
            alert.remove();
        }, 500);
    });
}, 3000);
</script>

<script src="/zegowska-szama/assets/js/cart.js"></script>
<div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
    <div id="liveToast" class="toast bg-white opacity-100" role="alert">
        <div class="toast-header">
            <strong class="me-auto">Zegowska Szama</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toast-message">
            Powiadomienie
        </div>
    </div>
</div>
</body>
</html>