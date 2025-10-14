<x-layouts.guest>
    <x-slot:title>
      Login
    </x-slot:title>

        <div class="hero min-h-screen">
          <div class="hero-content flex-col lg:flex-row-reverse">

            <div class="text-center lg:text-left">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.webp"
                    class="max-w-sm rounded-lg shadow-2xl"
                />
            </div>

            <div class="flex flex-col">

              <h1 class="text-5xl font-bold">Welcome back to AsensoStock!</h1>
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
              <div class="card-body">
                <fieldset class="fieldset">
                  <label class="label">Email</label>
                  <input type="email" class="input" placeholder="Email" />
                  <label class="label">Password</label>
                  <input type="password" class="input" placeholder="Password" />
                  <div><a class="link link-hover">Forgot password?</a></div>
                  <button class="btn btn-primary mt-4">Login</button>
                </fieldset>
              </div>
            </div>

            </div>

          </div>
        </div>

</x-layouts.guest>
