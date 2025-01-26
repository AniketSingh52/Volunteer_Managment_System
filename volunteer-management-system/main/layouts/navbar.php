

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp-like Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="flex h-screen bg-gray-100">
    <div class="flex w-full">
        <!-- Sidebar -->
        <div class="w-1/4 bg-base-200 border-r border-gray-300">
            <!-- Header -->
            <div class="p-4 bg-base-300 flex justify-between items-center">
                <img src="https://api.dicebear.com/6.x/initials/svg?seed=JD" alt="Profile" class="w-10 h-10 rounded-full">
                <div class="flex space-x-4">
                    <i class="fas fa-circle-notch text-gray-600"></i>
                    <i class="fas fa-comment-alt text-gray-600"></i>
                    <i class="fas fa-ellipsis-v text-gray-600"></i>
                </div>
            </div>
            <!-- Search -->
            <div class="p-4">
                <div class="relative">
                    <input type="text" placeholder="Search or start new chat" class="input input-bordered w-full pr-10">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <!-- Chats -->
            <div class="overflow-y-auto h-[calc(100vh-132px)]">
                <div class="chat-item p-4 hover:bg-base-300 cursor-pointer">
                    <div class="flex items-center">
                        <img src="https://api.dicebear.com/6.x/initials/svg?seed=AS" alt="Alice Smith" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h3 class="font-semibold">Alice Smith</h3>
                            <p class="text-sm text-gray-600">Hey, how are you?</p>
                        </div>
                    </div>
                </div>
                <!-- More chat items... -->
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="w-3/4 flex flex-col">
            <!-- Chat Header -->
            <div class="bg-base-300 p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="https://api.dicebear.com/6.x/initials/svg?seed=AS" alt="Alice Smith" class="w-10 h-10 rounded-full mr-4">
                    <h2 class="font-semibold">Alice Smith</h2>
                </div>
                <div class="flex space-x-4">
                    <i class="fas fa-search text-gray-600"></i>
                    <i class="fas fa-paperclip text-gray-600"></i>
                    <i class="fas fa-ellipsis-v text-gray-600"></i>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-4 bg-base-200" id="chat-messages">
                <div class="chat chat-start">
                    <div class="chat-bubble">Hey, how are you?</div>
                </div>
                <div class="chat chat-end">
                    <div class="chat-bubble">I'm good, thanks! How about you?</div>
                </div>
                <!-- More messages... -->
            </div>

            <!-- Input Area -->
            <div class="bg-base-300 p-4 flex items-center">
                <i class="fas fa-smile text-gray-600 mr-4"></i>
                <input type="text" placeholder="Type a message" class="input input-bordered flex-1 mr-4" id="message-input">
                <button class="btn btn-circle btn-primary" id="send-button">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('send-button').addEventListener('click', sendMessage);
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        function sendMessage() {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            if (message) {
                const chatMessages = document.getElementById('chat-messages');
                const newMessage = document.createElement('div');
                newMessage.className = 'chat chat-end';
                newMessage.innerHTML = `<div class="chat-bubble">${message}</div>`;
                chatMessages.appendChild(newMessage);
                input.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
    </script>
</body>

</html>