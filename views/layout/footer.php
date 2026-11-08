    </main>
</div>
<script>
    // Konfirmasi sebelum menghapus: form dengan atribut data-konfirmasi
    document.querySelectorAll('form[data-konfirmasi]').forEach(function (form) {
        form.addEventListener('submit', function (ev) {
            if (!confirm(form.getAttribute('data-konfirmasi'))) {
                ev.preventDefault();
            }
        });
    });
</script>
</body>
</html>
