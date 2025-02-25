let selectedUserId = null;
let lastMessageTime = null;
let messageCheckInterval = null;

$(document).ready(function() {
    // Search functionality
    $('#userSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.user-chat').each(function() {
            const userName = $(this).data('user-name').toLowerCase();
            $(this).toggle(userName.includes(searchTerm));
        });
    });

    // User selection
    $(document).on('click', '.user-chat', function() {
        selectedUserId = $(this).data('user-id');
        const userName = $(this).data('user-name');
        const profilePic = $(this).data('profile-pic');
        
        // Update chat header
        $('.chat-header-name').text(userName);
        $('.chat-header-img').attr('src', profilePic);
        
        // Update active state
        $('.user-chat').removeClass('border-l-4 border-blue-500 bg-blue-50');
        $(this).addClass('border-l-4 border-blue-500 bg-blue-50');
        
        // Load messages
        loadMessages();
        
        // Reset and start interval
        if (messageCheckInterval) {
            clearInterval(messageCheckInterval);
        }
        messageCheckInterval = setInterval(loadMessages, 2000);
    });

    // Send message
    $('#messageForm').submit(function(e) {
        e.preventDefault();
        if (!selectedUserId) return;

        const messageInput = $('#messageInput');
        const message = messageInput.val().trim();
        
        if (message) {
            $.post('send_message.php', {
                to_id: selectedUserId,
                message: message
            }, function(response) {
                if (response.success) {
                    messageInput.val('');
                    loadMessages();
                }
            }, 'json');
        }
    });
});

function loadMessages() {
    if (!selectedUserId) return;
    
    $.get('get_messages.php', { user_id: selectedUserId }, function(messages) {
        const messagesContainer = $('.messages-container');
        let html = '';
        
        messages.forEach(message => {
            const isSent = message.from_id == <?php echo $user_id; ?>;
            const time = new Date(message.date_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            html += `
                <div class="flex items-end ${isSent ? 'justify-end' : 'space-x-2'} mb-4">
                    ${!isSent ? `<img src="${message.profile_picture}" alt="${message.name}" 
                               class="w-8 h-8 rounded-full object-cover">` : ''}
                    <div class="max-w-md">
                        <div class="${isSent ? 'bg-blue-100' : 'bg-white'} rounded-lg p-4 shadow-sm">
                            <p class="text-gray-800">${escapeHtml(message.text)}</p>
                        </div>
                        <div class="flex items-center ${isSent ? 'justify-end' : ''} space-x-1">
                            <span class="text-xs text-gray-500">${time}</span>
                            ${isSent ? `<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M5 13l4 4L19 7" />
                            </svg>` : ''}
                        </div>
                    </div>
                </div>`;
        });
        
        messagesContainer.html(html);
        messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
    });
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
} 