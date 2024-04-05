            <!-- History Button -->
            <div x-data="{ open: false }">
                <!-- Trigger Button -->
                <button @click="open = true" class="inline-flex items-center gap-x-2 py-1.5 px-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800">
                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                    History
                </button>
            
                <!-- Modal -->
                <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-10" @click="open = false"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <div class="flex items-center justify-center min-h-screen" @click.stop>
                        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg p-4"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <h2 class="text-lg font-medium dark:text-white text-gray-800">Chat History</h2>
                            
                            <!-- Scrollable List Container -->
                            <div class="mt-4 max-h-60 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg scrollbar-hide">
                                <!-- List of Items -->
                                <ul>
                                    <li @click="/* your click action here */" class="flex justify-between items-center dark:text-white text-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <span>Impact of jazz from the Black community.</span>
                                        <span class="text-sm text-gray-500">2 minutes ago</span>
                                    </li>
                                    <li @click="/* your click action here */" class="flex justify-between items-center dark:text-white text-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <span>Harlem Renaissance's cultural influence.</span>
                                        <span class="text-sm text-gray-500">5 minutes ago</span>
                                    </li>
                                    <li @click="/* your click action here */" class="flex justify-between items-center dark:text-white text-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <span>Role of HBCUs in education.</span>
                                        <span class="text-sm text-gray-500">10 minutes ago</span>
                                    </li>
                                    <li @click="/* your click action here */" class="flex justify-between items-center dark:text-white text-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <span>Innovations by African American inventors.</span>
                                        <span class="text-sm text-gray-500">10 minutes ago</span>
                                    </li>
                                    <li @click="/* your click action here */" class="flex justify-between items-center dark:text-white text-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <span>Evolution of African American literature.</span>
                                        <span class="text-sm text-gray-500">10 minutes ago</span>
                                    </li>
                                    <li @click="/* your click action here */" class="flex justify-between items-center dark:text-white text-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <span>Civil rights movement's legacy.</span>
                                        <span class="text-sm text-gray-500">10 minutes ago</span>
                                    </li>
                                    <li @click="/* your click action here */" class="flex justify-between items-center dark:text-white text-gray-800 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <span>African American art and expression.</span>
                                        <span class="text-sm text-gray-500">10 minutes ago</span>
                                    </li>
                                    <!-- Add more list items here -->
                                </ul>
                            </div>
                            
                            <!-- Close Button -->
                            <button @click="open = false" class="mt-4 px-4 py-2 inline-flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">Close</button>
                        </div>
                    </div>
                </div>

            </div>