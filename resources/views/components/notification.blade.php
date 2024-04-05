

<!-- notification.blade.php -->
<div x-data="{ show: false, message: '', type: '' }"
     @toast.window="type = $event.detail.type; message = $event.detail.message; show = true; setTimeout(() => show = false, 5000);"
     x-show="show"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="ease-in duration-300"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90"
     class="fixed bottom-5 right-5 z-50 flex p-4 max-w-xs text-sm rounded-lg shadow-lg"
     :class="{
         'bg-gray-100 text-gray-800 border border-gray-200 dark:bg-white/10 dark:border-white/20 dark:text-white': type === 'info',
         'bg-green-100 text-green-800 border border-green-200 dark:bg-green-800/10 dark:border-green-900 dark:text-green-500': type === 'success',
         'bg-yellow-100 text-yellow-800 border border-yellow-200 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500': type === 'warning',
         'bg-red-100 text-red-800 border border-red-200 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500': type === 'danger',
         'bg-blue-100 text-blue-800 border border-blue-200 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500': type === 'alert'
     }" 
     role="alert"
     style="display: none;">

    <div class="flex-grow">
        <p x-text="message" class="flex-grow text-gray-900 dark:text-white"></p>
    </div>
    <div class="ml-auto">
        <button @click="show = false" type="button" class="inline-flex justify-center items-center rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white">
            <span class="sr-only">Close</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
