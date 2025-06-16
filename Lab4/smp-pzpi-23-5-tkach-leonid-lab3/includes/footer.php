</div>
    </main>
    <footer class="site-footer">
        <div class="container footer-content">
            <a href="/aboutus.php"><?= t('about_us_link') ?></a>
            <span style="margin: 0 10px;">|</span>
            <span>&copy; <?php echo date('Y'); ?> <?= t('footer_copyright') ?></span>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const langBtn = document.getElementById('langBtn');
        const langDropdown = document.getElementById('langDropdownContent');

        if (langBtn) {
            langBtn.addEventListener('click', function(event) {
                event.stopPropagation(); 
                langDropdown.classList.toggle('show');
            });
        }

        window.addEventListener('click', function(event) {
            if (langDropdown && langDropdown.classList.contains('show')) {
                if (!langBtn.contains(event.target)) {
                    langDropdown.classList.remove('show');
                }
            }
        });
    });
    </script>
</body>
</html>