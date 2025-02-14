async function deleteUser() {
    const confirmation = confirm('Are you sure you want to delete this user? This action is permanent.');
    if (confirmation) {
        await processUserAction('delete');
    }
}

document.querySelector("#submit").addEventListener('click', event => {
    event.preventDefault();
    processUserAction(document.querySelector("#action").value);
});

async function processUserAction(action) {
    try {
        document.querySelector("#result").textContent = "Processing, please wait...";

        const payload = {
            id: document.querySelector('#id').value,
            username: document.querySelector('#username').value,
            action
        };

        // Include password only if it's provided
        const passwordField = document.querySelector('#password');
        if (passwordField.value.trim() !== "") {
            payload.password = passwordField.value;
        }

        const response = await fetch('/php/processUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
            credentials: 'same-origin',
        });

        const result = await response.json();

        if (response.ok) {
            document.querySelector("#result").textContent = result.message || "Operation successful";
            if (result.redirectUrl) {
                location.replace(result.redirectUrl);
            }
        } else {
            console.error('Error in request:', result.error || 'Unknown error');
            document.querySelector("#result").textContent = "An error occurred, please try again.";
        }
    } catch (error) {
        console.error('Error:', error);
        document.querySelector("#result").textContent = "An unexpected error occurred.";
    }
}
