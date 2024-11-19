<template>
     <footer class="bg-black text-white py-10">
    <!-- Footer Container -->
    <!-- <div class="container mx-auto px-6">
      
      Footer Top Section (Company Information)
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8"> -->
        <!-- Column 1: Company Information -->
        <!-- <div>
          <h2 class="text-lg font-semibold mb-4 text-gray-400">MAY WE HELP YOU?</h2>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="underline-link">Contact Us</a></li>
            <li><a href="#" class="underline-link">FAQs</a></li>
            <li><a href="#" class="underline-link">Email Unsubscribe</a></li>
          </ul>
        </div> -->
        
        <!-- Column 2: The Company -->
        <!-- <div>
          <h2 class="text-lg font-semibold mb-4 text-gray-400">THE COMPANY</h2>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="underline-link">About SupplyEase</a></li>
            <li><a href="#" class="underline-link">Privacy & Cookie Policy</a></li>
            <li><a href="#" class="underline-link">Corporate Information</a></li>
          </ul>
        </div> -->

        <!-- Column 3: Subscribe & Store Locator -->
        <!-- <div>
          <h2 class="text-lg font-semibold mb-4 text-gray-400">SIGN UP FOR SUPPLYEASE UPDATES</h2>
          <p class="text-xs mb-4">Join us for updates on the latest collections, events, and news related to SupplyEase. By entering your email, you consent to receiving our newsletter as per our 
            Privacy Policy.</p>
          <div class="flex">
            <input type="email" placeholder="Enter your email" class="px-4 py-2 rounded-l-full w-3/4 text-black" />
            <button class="bg-primary-600 text-white px-6 py-2 rounded-r-full hover:bg-primary-700 transition-all duration-300">Subscribe</button>
          </div>
          
          <div class="mt-8">
            <h2 class="text-lg font-semibold mb-4 text-gray-400">STORE LOCATOR</h2>
            <p class="text-xs">Davao City, Philippines</p>
          </div>
        </div>
      </div> -->

      <!-- <div class="flex justify-between items-center mt-8">
        <p class="text-gray-500 dark:text-gray-400 text-sm">
          SE Copyright © {{ new Date().getFullYear() }}. All rights reserved.
        </p>
      </div> -->
      <!-- </div>
    </div> -->
    </footer>
  </template>
  
  <script>

  
  </script>
  <style scoped>
  /* General Styles for the Footer */
  footer {
    background-color: #000;
    color: white;
  }

  /* Underline link styling */
  .underline-link {
    position: relative;
    color: white;
    text-decoration: none;
    font-size: 0.875rem; /* Smaller font size for links */
  }

  .underline-link::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -2px;
    width: 0;
    height: 2px;
    background-color: #4D9BFF;
    transition: width 0.3s ease;
  }

  .underline-link:hover::after {
    width: 100%;
  }

  /* Input field and button */
  input[type="email"] {
    border: none;
    outline: none;
    background-color: #fff;
    color: #333;
  }

  /* Container */
  .container {
    max-width: 1200px;
    margin: 0 auto;
  }

  /* Button hover */
  button:hover {
    background-color: #fff; /* Your primary hover color */
  }

  /* SUPPLYEASE Text Styling */
  .supplyease-text {
    font-size: 7rem;           /* Prominent font size */
    font-weight: bold;
    letter-spacing: 0.5em;     /* Wide letter spacing */
    color: #fff;
    margin-top: 1rem;          /* Extra margin above */
    line-height: 2.1;          /* Adjusted line height */
  }
</style>