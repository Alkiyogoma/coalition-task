<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create account - CompanySystem</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{  URL::asset('assets/css/tailwind.output.css') }}" />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="{{  URL::asset('assets/js/init-alpine.js') }}"></script>
</head>

<body>
  <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
      <div class=" overflow-y-auto md:flex-row">

        <div class=" items-center justify-center p-6">
          <div class="w-full">
            <form method="POST" action="{{ url('addCompany') }}">
              @csrf

              <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                Create Company Account
              </h1>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Your Fullname</span>
                <input class="form-control" placeholder="Jane Doe" name="name" required />
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Phone Number</span>
                <input type="text" class="form-control" placeholder="+2557xxxxxxxxx" name='phone' required minlength="10" />
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input type="email" class="form-control" placeholder="youremail@email.com" name="email" required />
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Your Company Name</span>
                <input type="text" class="form-control" placeholder="Company name" name='sname' required minlength="10" />
              </label>

             
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Your Address</span>
                <input type="text" class="form-control" placeholder="Enter address...." name='address' required minlength="10" />
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400"> Number of Users</span>
                <input type="number" class="form-control" placeholder="0" name='students' required min="50" />
              </label>
       
              <div class="flex mt-6 text-sm">
                <label class="flex items-center dark:text-gray-400">
                  <input type="checkbox" class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                  <span class="ml-2">
                    I agree to the
                    <span class="underline">privacy policy</span>
                  </span>
                </label>
              </div>
              <button type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                {{ __('Register') }}
              </button>

              <p class="mt-4">
                <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('login') }}">
                  Already have an account? Login
                </a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>