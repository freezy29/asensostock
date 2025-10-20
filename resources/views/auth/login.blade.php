<x-layouts.guest>
    <x-slot:title>
      Login
    </x-slot:title>

        <div class="hero">
          <div class="hero-content flex-col lg:flex-row-reverse">
            <div class="text-center lg:text-left">
              <h1 class="text-5xl font-bold">Welcome back to <span class="text-primary">AsensoStock!</span></h1>
                <p class="py-6">
                    manage your inventaory kineme

                  </p>
            </div>
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
              <div class="card-body">

                <form method="POST" action="/login">
                @csrf

                <fieldset class="fieldset">
                <legend class="fieldset-legend">Login</legend>

                <!-- email -->
                <label class="input validator floating-label mb-2 @error('email') input-error @enderror">
                    <span>Email</span>
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g
                            stroke-linejoin="round"
                            stroke-linecap="round"
                            stroke-width="2.5"
                            fill="none"
                            stroke="currentColor"
                        >
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </g>
                    </svg>
                    <input type="email"
                           name="email"
                           placeholder="mail@example.com"
                           value="{{ old('email') }}"
                           required
                           autofocus/>
                </label>
                <div class="validator-hint hidden -mt-2">Enter valid email address</div>

                @error('email')
                   <div class="label mb-2 -mt-2">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                   </div>
                @enderror

                <!-- password -->
                <label class="input floating-label mb-2 @error('password') input-error @enderror">
                <span>Password</span>
                  <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g
                      stroke-linejoin="round"
                      stroke-linecap="round"
                      stroke-width="2.5"
                      fill="none"
                      stroke="currentColor"
                    >
                      <path
                        d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"
                      ></path>
                      <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                    </g>
                  </svg>
                  <input
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                  />
                </label>

                @error('password')
                   <div class="label mb-2">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                   </div>
                @enderror

                    <!-- remember me -->
                  <label class="label">
                    <input type="checkbox" name="remember" class="checkbox" />
                    Remember me
                  </label>
                  <button type="submit" class="btn btn-primary mt-4">Login</button>
                </fieldset>
                </form>

              </div>
            </div>
          </div>
        </div>



</x-layouts.guest>
