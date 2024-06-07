<!-- <header class="bg-[#4983C7]">
    <div class="container max-w-7xl m-auto py-6 px-4">
        <h1 class="pb-10 text-[#EAD7BB] font-semibold text-3xl">SiAngkot</h1>
        <div class="flex justify-between">
            <h3 class="text-[#EAD7BB;] text-2xl font-semibold">Informasi Rute <br> Angkutan Kota Bogor</h3>
            <img src="assets/logo_kotabogor.png" alt="logo_kotabogor">
        </div>
    </div>
</header> -->
<!-- <nav class="border-gray-200 bg-[#4983C7]">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <div class="">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="/assets/logo_singkot.png" class="h-8" alt="Flowbite Logo" />
            </a>
            <div class="">
                <h1 class="text-[#EAD7BB] text-lg">
                    Informasi Rute Angkutan Kota Bogor
                </h1>
            </div>
        </div>
        <button data-collapse-toggle="navbar-solid-bg" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-solid-bg" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
            <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent ">
                <li>
                <a href="/" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white" aria-current="page">Home</a>
                </li>
                <li>
                <a href="/rute" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white">Rute</a>
                </li>
                <li>
                <a href="#" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white">Tentang</a>
                </li>
            </ul>
        </div>
    </div>
</nav> -->


<nav class="border-gray-200 bg-[#4983C7] fixed top-0 left-0 w-full z-50">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <div class="w-2/3 md:w-auto">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="/assets/logo_singkot.png" class="h-8" alt="Flowbite Logo" />
        </a>
        <div class="">
            <h1 class="text-[#EAD7BB] text-sm md:text-lg text-wrap">
                Informasi Rute Angkutan Kota Bogor
            </h1>
        </div>
    </div>
  <div class="flex md:order-2">
    <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="md:hidden text-white dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
      </svg>
      <span class="sr-only">Search</span>
    </button>
    <form class="relative hidden md:block" method="get" action="/rute">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
        <span class="sr-only">Search icon</span>
      </div>
      <input type="text" id="search-navbar" name="wilayah" class="block outline-none w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari jalan/wilayah yang dituju..." value="<?= $_GET['wilayah'] ?? '' ?>">
    </form>
    <button data-collapse-toggle="navbar-search" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-search" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
      <form class="relative mt-3 md:hidden" method="get" action="/rute">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
        </div>
        <input type="text" id="search-navbar" name="wilayah" class="block outline-none w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari jalan/wilayah yang dituju..." value="<?= $_GET['wilayah'] ?? '' ?>">
      </form>
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 bg-white lg:bg-[#4983C7] dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="/" class="block py-2 px-3 text-[#4983C7] lg:text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:font-bold md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Beranda</a>
        </li>
        <li>
          <a href="/rute" class="block py-2 px-3 text-[#4983C7] lg:text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:font-bold md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Rute</a>
        </li>
        <li>
          <a href="/navigasi" class="block py-2 px-3 text-[#4983C7] lg:text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:font-bold md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Navigasi</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
