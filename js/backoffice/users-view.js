function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user? This action is permanent.')) {
        processUserAction('delete', id);
    }
}

async function processUserAction(action, id) {
    const record = "#record" + id.toString();
    const recordEl = document.querySelector(record);
    const params = {
        id: id,
        action: action
    };

    try {
        recordEl.classList.add("updating");

        const response = await fetch('/php/processUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(params)
        });

        if (response.ok) {
            const result = await response.json();

            if (result.status === 'success') {
                recordEl.classList.add('d-none');
                alert(result.message);
            } else {
                recordEl.classList.add("error");
                alert(result.message);
            }
        } else {
            recordEl.classList.add("error");
            console.error('Error in request:', response.statusText);
            alert('An unexpected error occurred.');
        }
    } catch (error) {
        recordEl.classList.add("error");
        console.error('Error:', error);
        alert('An unexpected error occurred.');
    }
}
