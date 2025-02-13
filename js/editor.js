const simplemde = new SimpleMDE({
        autofocus: true,
        autosave: {
                enabled: true,
                uniqueId: "editor",
                delay: 1000,
        },
        element: document.getElementById("editor"),
        forceSync: true,
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
                                content: encodeURI(simplemde.value()),
                                action,
                        }),
                });

                // Handle the response
                if (response.ok) {
                        const result = await response.text();
                        document.querySelector("#result").textContent = "Post updated";
                } else {
                        console.error('Error in request:', response.statusText);
                        document.querySelector("#result").textContent = "An error occurred, please try again.";
                }
        } catch (error) {
                console.error('Error:', error);
                document.querySelector("#result").textContent = "An unexpected error occurred.";
        }
}
