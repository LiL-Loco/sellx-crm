<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="generateTokenForm">
  <button type="submit">Token generieren</button>
</form>
<div id="tokenDisplay"></div>

<script>
  document.getElementById('generateTokenForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const response = await fetch('/generate-token/', {
      method: 'POST',
      headers: {
        'Authorization': 'Token YOUR_AUTH_TOKEN_HERE',  // Ersetzen Sie mit dem Auth-Token des Benutzers
        'Content-Type': 'application/json',
      },
    });

    if (response.ok) {
      const data = await response.json();
      document.getElementById('tokenDisplay').innerText = `Ihr Token: ${data.token}`;
    } else {
      document.getElementById('tokenDisplay').innerText = 'Fehler beim Generieren des Tokens.';
    }
  });
</script>
