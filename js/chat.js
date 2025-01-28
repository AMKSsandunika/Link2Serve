document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.getElementById('chat-form');
    const chatBox = document.getElementById('chat-box');
    const messageInput = document.getElementById('message');
    const fileInput = document.getElementById('file');
    const fileNameDisplay = document.getElementById('file-name');
    const requestId = chatForm.querySelector('input[name="request_id"]').value;
    const userId = chatForm.querySelector('input[name="sender"]').value;

    fileInput.addEventListener('change', () => {
        fileNameDisplay.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : '';
    });

    chatForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(chatForm);

        fetch('../components/send_message.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const message = formData.get('message');
                const timestamp = new Date().toISOString().slice(0, 19).replace('T', ' ');
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('chat-message', 'self');
                messageDiv.innerHTML = `<p>${message}</p><span class="timestamp">${timestamp}</span>`;
                
                if (fileInput.files.length > 0) {
                    const fileName = fileInput.files[0].name;
                    const filePath = 'uploads/' + fileName;
                    messageDiv.innerHTML += `<p>File: <a href="${filePath}" download>${fileName}</a></p>`;
                }

                chatBox.appendChild(messageDiv);
                messageInput.value = '';
                fileInput.value = '';
                fileNameDisplay.textContent = '';
                chatBox.scrollTop = chatBox.scrollHeight;
            } else {
                console.error('Error sending message:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function fetchMessages() {
        fetch(`../components/get_messages.php?request_id=${requestId}`)
            .then(response => response.json())
            .then(messages => {
                chatBox.innerHTML = '';
                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.classList.add('chat-message', message.sender == userId ? 'self' : 'other');
                    messageDiv.innerHTML = `<p>${message.message}</p><span class="timestamp">${message.timestamp}</span>`;
                    if (message.file_path) {
                        messageDiv.innerHTML += `<p>File: <a href="../${message.file_path}" download>${message.file_name}</a></p>`;
                    }
                    chatBox.appendChild(messageDiv);
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(error => console.error('Error:', error));
    }

    chatBox.scrollTop = chatBox.scrollHeight;

    setInterval(fetchMessages, 5000);
    fetchMessages();
});
