// Listen for login button click event
document.getElementById('loginBtn').addEventListener('click', login);

async function login() {
        const user = document.getElementById('user').value;
        const pass = document.getElementById('pass').value;
        const resultEl = document.getElementById('result')

        const payload = { user, pass };

        try {
                // Show loading message
                resultEl.textContent = "Please wait...";

                // Send the login request
                const response = await fetch('./php/_login.php', {
                        method: 'POST',
                        headers: {
                                'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(payload),
                });

                // Handle the response
                const result = await response.json();

                if (response.ok && result.redirectUrl) {
                        resultEl.textContent = "";
                        location.href = result.redirectUrl;
                } else {
                        resultEl.innerHTML = result.message;
                        resultEl.style.color = 'red';
                }
        } catch (err) {
                resultEl.innerHTML = "There was an issue with your request.";
                resultEl.style.color = 'red';
                console.error('Error:', err);
        }
}