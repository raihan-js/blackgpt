<x-app-layout>
    <div class="p-6" x-data="chatApp()">
        <!-- Content -->
        <div class="relative">
            <div class="py-10 lg:py-14">
                
                <!-- Title -->
                <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto text-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />

                    <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
                        Welcome to BlackGPT
                    </h1>
                    <p class="mt-3 text-gray-600 dark:text-gray-400">
                        Your AI-powered copilot for the web
                    </p>
                </div>
                <!-- End Title -->

                {{-- Chats like this --}}
                <ul class="mt-16 space-y-5 chat-messages">
                    <!-- Chat bubbles will be appended here -->
                </ul>
                
                {{-- This suggestions will disappear when prompted --}}
                <div id="suggestions" class="flex justify-center mt-8 relative">      
                    <div class="h-48 w-full max-w-xs relative">
                        <!-- Scrolling Area -->
                        <div class="overflow-y-auto h-full scrollbar-hide">
                            <div class="py-2 flex flex-col items-center space-y-4">
                            <!-- Button 1 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                Summary of the Civil Rights Act of 1964
                            </button>
                            <!-- Button 2 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                Best HBCUs for STEM
                            </button>
                            <!-- Button 3 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                How to Trace African American Genealogy
                            </button>
                            <!-- Button 4 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                Latest Trends in African American Literature
                            </button>
                            <!-- Button 5 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                Impact of Hip Hop on Global Culture
                            </button>
                            <!-- Button 6 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                African American Scientists and Inventors List
                            </button>
                            <!-- Button 7 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                Guide to African American Hair Care
                            </button>
                            <!-- Button 8 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                African American Contributions to Jazz Music
                            </button>
                            <!-- Button 9 -->
                            <button class="button-with-arrow px-4 py-2 w-full bg-gray-200 text-gray-800 rounded-lg text-sm text-center dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                Strategies for Addressing Health Disparities in African American Communities
                            </button>
                            </div>
                        </div>
                        <!-- Gradient Overlays for Fading Effect -->
                        <div class="absolute top-0 left-0 right-0 h-10 bg-gradient-to-b from-gray-100 to-transparent dark:from-gray-900 dark:to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-gray-100 to-transparent dark:from-gray-900 dark:to-transparent"></div>
                    </div>
                </div>

            </div>


            <footer class="sticky bottom-0 z-10 border-t border-gray-200 pt-2 pb-0 sm:pt-4 sm:pb-0  dark:border-gray-700 bg-gray-100 dark:bg-gray-900">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center mb-3">
                        <x-new-chat />
                        <x-conversations />
                    </div>
                    <x-chat-input />
                </div>
            </footer>


        </div>
    </div>

    <script>
        function chatApp() {
            return {
                init() {
                    this.listenForSessionLoad();
                },
                listenForSessionLoad() {
                    window.addEventListener('load-session', (event) => {
                        const sessionId = event.detail.sessionId;
                        this.loadSessionConversations(sessionId);
                    });
                },
                loadSessionConversations(sessionId) {
                    fetch(`/chat/session/${sessionId}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.displayConversations(data);
                        // Hide suggestions
                        document.getElementById('suggestions').style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error loading session conversations:', error);
                        // Display an error message to the user, or log it
                    });
                },
                displayConversations(conversations) {
                    const chatMessagesUl = document.querySelector('.chat-messages');
                    chatMessagesUl.innerHTML = ''; // Clear current messages

                    conversations.forEach(conversation => {
                        // User Message
                        const userLi = document.createElement('li');
                        userLi.className = 'py-2 sm:py-4'; // Add your classes here
                        userLi.innerHTML = `
                        <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto">
                        <div class="max-w-2xl flex gap-x-2 sm:gap-x-4">
                            <span class="flex-shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-gray-600">
                                <span class="text-sm font-medium text-white leading-none">AZ</span>
                            </span>
                            <div class="grow mt-2 space-y-3">
                                <p class="text-gray-800 dark:text-gray-200">${conversation.prompt}</p>
                            </div>
                        </div>
                    </div>`;
                        chatMessagesUl.appendChild(userLi);

                        // AI Response
                        const aiLi = document.createElement('li');
                        aiLi.className = 'py-2 sm:py-4'; // Add your classes here
                        aiLi.innerHTML = `
                        <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto">
                        <div class="max-w-2xl flex gap-x-2 sm:gap-x-4">
                            <span class="flex-shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-blue-600">
                                <span class="text-sm font-medium text-white leading-none">BG</span>
                            </span>
                            <div class="grow mt-2 space-y-3">
                                <p class="text-gray-800 dark:text-gray-200">${conversation.response}</p>
                                <div>
                                    <div class="sm:flex sm:justify-between">
                                    <div>
                                        <div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-gray-700">
                                            <button type="button" class="inline-flex flex-shrink-0 justify-center items-center size-6 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-900 dark:hover:text-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-gray-700">
                                            <button type="button" class="inline-flex flex-shrink-0 justify-center items-center size-6 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-900 dark:hover:text-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-gray-700">
                                            <button type="button" class="inline-flex flex-shrink-0 justify-center items-center size-6 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-900 dark:hover:text-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                        chatMessagesUl.appendChild(aiLi);
                    });

                    // Optionally hide suggestions after displaying conversations
                    document.getElementById('suggestions').style.display = 'none';
                }

            }
        }
        </script>
        
</x-app-layout>




{{-- -------------------- --}}


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#sendButton').click(function() {
        var messageContent = $('#chatInput').val();
        if(messageContent.trim() === '') return; // Prevent sending empty messages

        $('#suggestions').hide(); // Hide suggestions immediately upon click

        appendChatBubble('user', messageContent); // Append the user's message
        $('#chatInput').val('');
        $('#chatSpinner').removeClass('hidden');
        $('#sendButton').addClass('hidden');
        // Start AJAX call
        $.ajax({
            url: "{{ route('chat.completion') }}", // Ensure this route is correctly defined and accessible
            type: "POST",
            data: {message: messageContent, _token: "{{ csrf_token() }}"},
            success: function(response) {
                // Directly display the HTML response after a brief "typing" effect
                if(response.chatResponse) {
                    createAITypingBubble(response.chatResponse);
                } else {
                    console.error("No 'chatResponse' in response");
                }
                $('#chatSpinner').addClass('hidden');
                $('#sendButton').removeClass('hidden');

            },
            error: function(xhr, status, error) {
                console.error("Error in AJAX call:", status, error);
                alert("An error occurred. Please try again.");
            }
        });
    });

    // Function to append a chat bubble for user messages
    function appendChatBubble(type, message) {
        if (type === 'user') {
            const userBubbleHtml = `
            <li class="py-2 sm:py-4">
                    <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto">
                        <div class="max-w-2xl flex gap-x-2 sm:gap-x-4">
                            <span class="flex-shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-gray-600">
                                <span class="text-sm font-medium text-white leading-none">AZ</span>
                            </span>
                            <div class="grow mt-2 space-y-3">
                                <p class="text-gray-800 dark:text-gray-200">${message}</p>
                            </div>
                        </div>
                    </div>
                </li>`;
            $('.chat-messages').append(userBubbleHtml);
        }
    }

    // Function to create a bubble for AI response and apply typing effect
    function createAITypingBubble(message) {
        const responseBubbleHtml = `<li class="py-2 sm:py-4">
                    <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto">
                        <div class="max-w-2xl flex gap-x-2 sm:gap-x-4">
                            <span class="flex-shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-blue-600">
                                <span class="text-sm font-medium text-white leading-none">BG</span>
                            </span>
                            <div class="grow mt-2 space-y-3">
                                <p class="text-gray-800 dark:text-gray-200 typing"></p>
                                <div>
                                    <div class="sm:flex sm:justify-between">
                                    <div>
                                        <div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-gray-700">
                                            <button type="button" class="inline-flex flex-shrink-0 justify-center items-center size-6 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-900 dark:hover:text-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-gray-700">
                                            <button type="button" class="inline-flex flex-shrink-0 justify-center items-center size-6 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-900 dark:hover:text-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-gray-700">
                                            <button type="button" class="inline-flex flex-shrink-0 justify-center items-center size-6 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-900 dark:hover:text-blue-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>`;
        $('.chat-messages').append(responseBubbleHtml);
        simulateTypingEffect($('.typing:last'), message, 0); // Apply typing effect to the latest '.typing' element
    }

    // Typing effect simulation function
    function simulateTypingEffect(element, message, index) {
        if (index < message.length) {
            element.text(element.text() + message.charAt(index));
            setTimeout(function() {
                simulateTypingEffect(element, message, index + 1);
            }, 15); // Adjust typing speed as needed
        }
    }
    $('#suggestions').on('click', 'button', function() {
        // Fetch the text from the clicked button and trim it
        var buttonText = $(this).text().trim();
        
        // Set the chat input to the trimmed button's text
        $('#chatInput').val(buttonText);
        
        // Hide the suggestions container
        $('#suggestions').hide();

        // Programmatically click the send button to submit the chat
        $('#sendButton').click();
    });

});
</script>