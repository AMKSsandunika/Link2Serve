document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const requestId = chatBox.dataset.requestId; // Get the request ID from a data attribute
    const userId = chatBox.dataset.userId; // Get the user ID from a data attribute

    function fetchMessages() {
        fetch(`get_messages.php?request_id=${requestId}`)
            .then(response => response.json())
            .then(messages => {
                chatBox.innerHTML = '';
                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('chat-message', message.sender == userId ? 'self' : 'other');
                    messageDiv.innerHTML = `<p>${message.message}</p><span class="timestamp">${message.timestamp}</span>`;
                    chatBox.appendChild(messageDiv);
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(error => console.error('Error:', error));
    }

    // Scroll chat box to bottom on page load
    chatBox.scrollTop = chatBox.scrollHeight;

    // Fetch messages every 5 seconds
    setInterval(fetchMessages, 5000);
    fetchMessages();
});
