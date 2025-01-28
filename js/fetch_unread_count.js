document.addEventListener('DOMContentLoaded', function() {
    function fetchUnreadCount() {
        fetch('components/get_unread_messages.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const unreadCountElement = document.getElementById('unread-count');
                    if (data.unread_count > 0) {
                        unreadCountElement.textContent = data.unread_count;
                        unreadCountElement.style.display = 'inline-block';
                    } else {
                        unreadCountElement.style.display = 'none';
                    }
                } else {
                    console.error('Error fetching unread messages:', data.message);
                }
            })
            .catch(error => console.error('Error fetching unread messages:', error));
    }

    // Fetch unread message count when the page loads
    fetchUnreadCount();

    // Optionally, you can set an interval to periodically check for new unread messages
    setInterval(fetchUnreadCount, 60000); // Fetch every 60 seconds
});
