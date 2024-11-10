</div> 

<footer class="text-center">
    <div class="container">
        <div class="social-icons mb-3">
            <a href="#"><img src="images/facebook-icon.png" alt="Facebook"></a>
            <a href="#"><img src="images/x-icon.png" alt="Twitter"></a>
            <a href="#"><img src="images/linkedin-icon.png" alt="LinkedIn"></a>
            <a href="#"><img src="images/instagram-icon.png" alt="Instagram"></a>
        </div>
        <nav>
            <a href="index.php" class="me-3 text-decoration-none">Home</a>
            <a href="aboutUs.php" class="me-3 text-decoration-none">About Us</a>
            <a href="product.php" class="me-3 text-decoration-none">Product</a>
            <a href="profil.php" class="text-decoration-none">Login</a>
        </nav>
        <p class="mt-3">&copy; <?php echo date("Y"); ?> AIFYCODE Learning | All Rights Reserved. Made With Love</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const navbar = document.querySelector(".navbar");
    window.addEventListener("scroll", () => {
        const scrollPos = window.scrollY;
        if (scrollPos > 50) {
            navbar.classList.add("zoom-out");
            navbar.classList.remove("zoom-in");
        } else {
            navbar.classList.add("zoom-in");
            navbar.classList.remove("zoom-out");
        }
    });
</script>
</body>
</html>
