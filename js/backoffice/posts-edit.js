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

document.querySelector('#title').addEventListener('input', (e) => {
        function slugify(str) {
                return String(str)
                        .toLowerCase()
                        .normalize('NFKD')
                        .replace(/[\u0300-\u036f]/g, '')
                        .trim()
                        .replace(/[^a-z0-9 -]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
        }

        document.querySelector("#slug").value = slugify(e.target.value);
})



async function processAction(action) {
        try {
                document.querySelector("#result").textContent = "Processing, please wait...";
                const response = await fetch('/php/processPost.php', {
                        method: 'POST',
                        headers: {
                                'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                                id: document.querySelector('#id').value,
                                title: document.querySelector('#title').value,
                                date: document.querySelector('#date').value,
                                state: document.querySelector('#state').value,
                                slug: document.querySelector("#slug").value,
                                content: encodeURIComponent(simplemde.value()),
                                action,
                        }),
                        credentials: 'same-origin',
                });
                const result = await response.json();
                if (response.ok) {
                        document.querySelector("#result").textContent = result.message || "Operation successful";
                        if (result.redirectUrl) {
                                location.replace(result.redirectUrl)
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