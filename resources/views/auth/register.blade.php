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
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <span id="password-strength"></span>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <span id="password-match" class="text-red-500 hidden">Las contraseñas no coinciden.</span>
        </div>

        <!-- Check  -->
        <div class="mt-4">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
                Acepto los términos y condiciones.
            </label>
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

    <script>
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const dobInput = document.getElementById('dob');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const phoneError = document.getElementById('phone-error');
        const dobError = document.getElementById('dob-error');
        const matchMessage = document.getElementById('password-match');
        const registerBtn = document.getElementById('register-btn');

        nameInput.addEventListener('input', validateName);
        emailInput.addEventListener('input', validateEmail);
        phoneInput.addEventListener('input', validatePhone);
        dobInput.addEventListener('input', validateDOB);
        passwordInput.addEventListener('input', validatePasswordStrength);
        confirmPasswordInput.addEventListener('input', validatePasswordMatch);

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
            const strength = calculatePasswordStrength(password);
            updateStrengthIndicator(strength);
        }

        function calculatePasswordStrength(password) {
            if (/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[A-Z]).{8,}$/.test(password)) {
                return 'Muy Fuerte';
            } else if (password.length < 8) {
                return 'Débil';
            } else {
                return 'Fuerte';
            }
        }

        function updateStrengthIndicator(strength) {
            const strengthIndicator = document.getElementById('password-strength');
            if (strength === 'Débil') {
                strengthIndicator.style.color = 'red';
            } else if (strength === 'Fuerte') {
                strengthIndicator.style.color = 'orange';
            } else {
                strengthIndicator.style.color = 'green';
            }
            strengthIndicator.textContent = `Fortaleza de la contraseña: ${strength}`;
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
            if (!nameError.classList.contains('hidden') || !emailError.classList.contains('hidden') || !phoneError.classList.contains('hidden') || !dobError.classList.contains('hidden') || !matchMessage.classList.contains('hidden')) {
                registerBtn.disabled = true;
            } else {
                registerBtn.disabled = false;
            }
        }
    </script>
</x-guest-layout>
