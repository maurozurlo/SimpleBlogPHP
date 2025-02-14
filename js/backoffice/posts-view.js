function deletePost(id) {
    if (confirm('Are you sure you want to delete this post? This action is permanent.')) {
        processAction('delete', id);
    } else {
        return null;
    }
}

async function processAction(action, id) {
    const record = "#record" + id.toString();
    const recordEl = document.querySelector(record)
    const params = {
        id: id,
        action: action
    };

    try {
        recordEl.classList.add("updating");

        const response = await fetch('/php/processPost.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(params)
        });

        // Check if the response is okay
        if (response.ok) {
            const result = await response.json();  // Parse the JSON response

            if (result.status === 'success') {
                // Handle success
                recordEl.classList.add('d-none')
                alert(result.message);  // Display success message
            } else {
                // Handle error
                recordEl.classList.add("error");
                alert(result.message);  // Display error message
            }
        } else {
            recordEl.classList.add("error");
            console.error('Error in request:', response.statusText);
            alert('An unexpected error occurred.');
        }
    } catch (error) {
        // Handle network or other errors
        recordEl.classList.add("error");
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    }
}