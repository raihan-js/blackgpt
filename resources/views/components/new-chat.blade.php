                    <!-- Adjust your button's x-data block -->
                    <div x-data="{
                        startNewSession() {
                            fetch('{{ route('chat.startNewSession') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if(data.success) {
                                    // Clear chat messages and show suggestions
                                    this.clearChats();
                                    this.showSuggestions();

                                    // Dispatch the toast event with message
                                    window.dispatchEvent(new CustomEvent('toast', {
                                        detail: { type: 'success', message: data.message }
                                    }));
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Dispatch the toast event for error
                                window.dispatchEvent(new CustomEvent('toast', {
                                    detail: { type: 'danger', message: 'An error occurred. Please try again.' }
                                }));
                            });
                        },
                        clearChats() {
                            document.querySelector('.chat-messages').innerHTML = '';
                        },
                        showSuggestions() {
                            const suggestions = document.getElementById('suggestions');
                            suggestions.style.display = 'flex'; // Reveal suggestions
                            suggestions.classList.add('justify-center');
                        }
                    }">
                    <button @click="startNewSession()" class="inline-flex justify-center items-center gap-x-2 rounded-lg font-medium text-gray-800 hover:text-blue-600 text-xs sm:text-sm dark:text-gray-200 dark:hover:text-blue-500">
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        New chat
                        </button>
                    </div>