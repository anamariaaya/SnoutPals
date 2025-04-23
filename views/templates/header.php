<header class="header">
    <div class="header__container container">
        <img class="header__logo" src="/build/img/logo.png" alt="Logo" />
        <nav class="header__nav">
            <ul class="header__nav--list">
                <?php if(!isset($init)):?>
                    <li class="header__nav--link"><a href="/"><?php echo tt('home.home_link');?></a></li>
                <?php endif; ?>
                <li class="header__nav--link"><a href="/about"><?php echo tt('home.about_link');?></a></li>
                <li class="header__nav--link"><a href="/contact"><?php echo tt('home.contact_link');?></a></li>
                <?php if(!isset($init)):?>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="header__nav--link"><a href="/logout"><?php echo tt('home.logout_link');?></a></li>
                    <?php else: ?>
                        <li class="header__nav--link"><a href="/login"><?php echo tt('home.login_link');?></a></li>
                        <li class="header__nav--link"><a href="/register"><?php echo tt('home.register_link');?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <div class="header__nav--extra">
                <div class="header__lang">
                    <div class="header__select no-display" id="language">
                        <button class="header__lang--btn btn-lang" value="en">English</button>
                        <button class="header__lang--btn btn-lang" value="es">Español</button>
                    </div>
                </div>

                <div class="header__theme" id="theme-toggle">
                </div>
                
                <div class="header__nav--mobile only--tablet only--mobile">
                    <i class="fa-solid fa-bars" id="btnMenu"></i>
                </div>
            </div>
        </nav>
    </div>
</header>