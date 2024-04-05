<!-- Input -->
<div class="relative">
    <textarea id="chatInput" class="scrollbar-hide p-4 pb-12 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Ask me anything..."></textarea>

    <!-- Toolbar -->
    <div class="absolute bottom-px inset-x-px p-2 rounded-b-md bg-white dark:bg-gray-900">
    <div class="flex justify-between items-center">
        <!-- Button Group -->
        <div class="flex items-center">

        </div>
        <!-- End Button Group -->

        <!-- Button Group -->
        <div class="flex items-center gap-x-1">

        <!-- Send Button -->
        <button id="sendButton" type="button" class="inline-flex flex-shrink-0 justify-center items-center size-8 rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
            </svg>
        </button>
        <div id="chatSpinner" class="hidden animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500" role="status">
            <span class="sr-only">Loading...</span>
        </div>                
        <!-- End Send Button -->
        </div>
        <!-- End Button Group -->
    </div>
    </div>
    <!-- End Toolbar -->
</div>
<!-- End Input -->