const simplemde = new SimpleMDE({
        autofocus: true,
        element: document.getElementById("editor"),
        hideIcons: ["guide"],
        lineWrapping: false,
        placeholder: "Type here...",
        promptURLs: true,
        renderingConfig: {
                codeSyntaxHighlighting: true,
        },
        tabSize: 4,
});

async function deletePost() {
        const confirmation = confirm('Are you sure you want to delete this post? This action is permanent.');
        if (confirmation) {
                await processAction('delete');
        }
}

document.querySelector("#submit").addEventListener('click', event => {
        event.preventDefault();
        processAction(document.querySelector("#action").value)
})


async function processAction(action) {
        try {
                // Show loading message
                document.querySelector("#result").textContent = "Processing, please wait...";

                // Send request using fetch API
                const response = await fetch('./php/processPost.php', {
                        method: 'POST',
                        headers: {
                                'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                                id: document.querySelector('#id').value,
                                title: document.querySelector('#title').value,
                                date: document.querySelector('#date').value,
                                state: document.querySelector('#state').value,
                                content: encodeURIComponent(simplemde.value()),  // Correct encoding
                                action,
                        }),
                });

                // Handle the response
                const result = await response.json();
                if (response.ok) {
                        document.querySelector("#result").textContent = result.message || "Operation successful";
                } else {
                        console.error('Error in request:', result.error || 'Unknown error');
                        document.querySelector("#result").textContent = "An error occurred, please try again.";
                }
        } catch (error) {
                console.error('Error:', error);
                document.querySelector("#result").textContent = "An unexpected error occurred.";
        }
}