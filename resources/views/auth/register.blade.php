<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <span id="name-error" class="text-red-500 hidden">El nombre debe tener al menos 5 caracteres.</span>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <span id="email-error" class="text-red-500 hidden">Ingresa un correo electrónico válido.</span>
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            <span id="phone-error" class="text-red-500 hidden">Ingresa un número de teléfono válido (10 dígitos numéricos).</span>
        </div>

        <!-- Date of Birth -->
        <div class="mt-4">
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-date-picker id="dob" class="block mt-1 w-full form-control" name="dob" :value="old('dob')" required max="{{ now()->format('Y-m-d') }}" />
            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
            <span id="dob-error" class="text-red-500 hidden">Selecciona una fecha de nacimiento válida (anterior al año actual).</span>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" oninput="validatePasswordStrength()" />
            <div class="password-strength mt-2">
                <span id="strength-message"></span>
                <div class="strength-bar mt-1 w-full">
                    <span id="strength-level" style="display: block; height: 5px; border-radius: 5px;"></span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" oninput="validatePasswordMatch()" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <span id="password-match" class="text-red-500 hidden">Las contraseñas no coinciden.</span>
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <input class="form-check-input" type="checkbox" id="terms" />
            <label class="form-check-label" for="terms">
                Acepto los términos y condiciones.<a href="javascript:void(0)" onclick="openTermsModal()" style="color: #00c0d7;">Leer</a>.
            </label>
            <span id="terms-error" class="text-red-500 hidden">Debes aceptar los términos y condiciones.</span>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4" id="register-btn" type="submit" disabled>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Terms Modal -->
    <div id="terms-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:#fff; padding:20px; border-radius:10px; width:80%; max-height:80%; overflow-y:auto;">
            <h2>Términos y Condiciones</h2>
            <p>Bienvenido/a a nuestra aplicación móvil dedicada al estudio y comprensión de la neurodivergencia. Antes de utilizar nuestra app, le solicitamos que lea detenidamente los siguientes términos y condiciones que rigen su acceso y participación en nuestra comunidad. Al hacer uso de nuestra aplicación, usted acepta expresamente los términos y condiciones que se detallan a continuación:</p>
            <p>1. Al descargar, instalar y utilizar nuestra aplicación, usted acepta cumplir con estos términos y condiciones.</p>
            <p>2. Nos comprometemos a respetar y proteger su privacidad de acuerdo con las leyes y regulaciones aplicables. Consulte nuestra Política de Privacidad para obtener más información detallada sobre cómo manejamos sus datos personales.</p>
            <p>3. Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Las modificaciones entrarán en vigencia tan pronto como se publiquen dentro de la aplicación. Se recomienda revisar periódicamente los términos para estar informado sobre posibles cambios.</p>
            <p>4. El usuario es responsable de la información que comparte y de su conducta en nuestra aplicación. Cualquier actividad que viole los términos y condiciones puede resultar en la terminación de su cuenta.</p>
            <p>5. El contenido proporcionado en nuestra aplicación está protegido por derechos de autor de acuerdo con la Ley 1915 de 2018 y otras disposiciones legales. Se prohíbe la reproducción no autorizada del contenido.</p>
            <p>6. Nos comprometemos a preservar la integridad y seguridad de la información que comparte en nuestra aplicación. Seguimos las disposiciones de la Ley 1273 de 2009 para proteger la información y los datos.</p>
            <div style="display: flex; justify-content: center; margin-top: 20px;">
                <button class="button" onclick="closeTermsModal()" style="background-color: #00c0d7; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">Aceptar</button>
            </div>
        </div>
    </div>

    <script>
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const dobInput = document.getElementById('dob');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const termsCheckbox = document.getElementById('terms');
        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const phoneError = document.getElementById('phone-error');
        const dobError = document.getElementById('dob-error');
        const termsError = document.getElementById('terms-error');
        const matchMessage = document.getElementById('password-match');
        const strengthLevel = document.getElementById('strength-level');
        const strengthMessage = document.getElementById('strength-message');
        const registerBtn = document.getElementById('register-btn');

        nameInput.addEventListener('input', validateName);
        emailInput.addEventListener('input', validateEmail);
        phoneInput.addEventListener('input', validatePhone);
        dobInput.addEventListener('input', validateDOB);
        passwordInput.addEventListener('input', validatePasswordStrength);
        confirmPasswordInput.addEventListener('input', validatePasswordMatch);
        termsCheckbox.addEventListener('change', checkFormValidity);

        function validateName() {
            if (nameInput.value.length < 5) {
                nameError.classList.remove('hidden');
                registerBtn.disabled = true;
            } else {
                nameError.classList.add('hidden');
                checkFormValidity();
            }
        }

        function validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                emailError.classList.remove('hidden');
                registerBtn.disabled = true;
            } else {
                emailError.classList.add('hidden');
                checkFormValidity();
            }
        }

        function validatePhone() {
            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phoneInput.value)) {
                phoneError.classList.remove('hidden');
                registerBtn.disabled = true;
            } else {
                phoneError.classList.add('hidden');
                checkFormValidity();
            }
        }

        function validateDOB() {
            const selectedDate = new Date(dobInput.value);
            const currentDate = new Date();
            if (selectedDate >= currentDate) {
                dobError.classList.remove('hidden');
                registerBtn.disabled = true;
            } else {
                dobError.classList.add('hidden');
                checkFormValidity();
            }
        }

        function validatePasswordStrength() {
            const password = passwordInput.value;
            let strength = 0;
            if (password.length >= 6) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            let strengthText = '';
            switch (strength) {
                case 0:
                case 1:
                    strengthLevel.style.width = "20%";
                    strengthLevel.style.backgroundColor = "red";
                    strengthText = 'Débil';
                    break;
                case 2:
                    strengthLevel.style.width = "40%";
                    strengthLevel.style.backgroundColor = "orange";
                    strengthText = 'Débil';
                    break;
                case 3:
                    strengthLevel.style.width = "60%";
                    strengthLevel.style.backgroundColor = "yellow";
                    strengthText = 'Media';
                    break;
                case 4:
                    strengthLevel.style.width = "80%";
                    strengthLevel.style.backgroundColor = "blue";
                    strengthText = 'Fuerte';
                    break;
                case 5:
                    strengthLevel.style.width = "100%";
                    strengthLevel.style.backgroundColor = "green";
                    strengthText = 'Muy Fuerte';
                    break;
            }
            strengthMessage.textContent = `Fortaleza de la contraseña: ${strengthText}`;
            if (strength <= 2) {
                strengthMessage.style.color = 'red';
            } else {
                strengthMessage.style.color = 'green';
            }
        }

        function validatePasswordMatch() {
            const match = confirmPasswordInput.value === passwordInput.value;
            if (!match) {
                matchMessage.classList.remove('hidden');
                registerBtn.disabled = true;
            } else {
                matchMessage.classList.add('hidden');
                checkFormValidity();
            }
        }

        function checkFormValidity() {
            if (!nameError.classList.contains('hidden') || !emailError.classList.contains('hidden') || !phoneError.classList.contains('hidden') || !dobError.classList.contains('hidden') || !matchMessage.classList.contains('hidden') || !termsCheckbox.checked) {
                registerBtn.disabled = true;
            } else {
                registerBtn.disabled = false;
            }
        }

        function openTermsModal() {
            document.getElementById('terms-modal').style.display = 'flex';
        }

        function closeTermsModal() {
            document.getElementById('terms-modal').style.display = 'none';
        }
    </script>
</x-guest-layout>
