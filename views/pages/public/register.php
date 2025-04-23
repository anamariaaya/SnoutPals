<section class="register mt-5">
    <div class="card-form">
        <h1 class="register__title">Create an Account</h1>

        <form id="register-form" class="form" method="POST">
            <div class="form__group">
                <label class="form__group__label" for="name">{%register.name_label%}</label>
                <input class="form__group__input" type="text" id="name" name="name" placeholder="{%register.name_placeholder%}" required />
            </div>

            <div class="form__group">
                <label class="form__group__label" for="lastname">{%register.lastname_label%}</label>
                <input class="form__group__input" type="text" id="lastname" name="lastname" placeholder="{%register.lastname_placeholder%}" required />
            </div>

            <div class="form__group">
                <label class="form__group__label" for="email">{%register.email_label%}</label>
                <input class="form__group__input" type="email" id="email" name="email" placeholder="{%register.email_placeholder%}" required />
            </div>

            <div class="form__group">
                <label class="form__group__label" for="password">{%register.password_label%}</label>
                <input class="form__group__input" type="password" id="password" name="password" required />
            </div>

            <div class="form__group">
                <label class="form__group__label" for="confirm-password">{%register.confirm_password_label%}</label>
                <input class="form__group__input" type="password" id="confirm-password" name="confirm-password" required />
            </div>

            <button type="submit" class="btn btn--primary">{%register.register_button%}</button>
        </form>
    </div>

    <p class="register__login">
        {%register.already_have_account%}
        <a class="register__login--link" href="/login">
            {%register.login_link%}
        </a>
    </p>
    <p class="register__login">
        <a class="register__login--link" href="/reset-password">
            {%register.forgot_password_link%}
        </a>
    </p>
</section>
