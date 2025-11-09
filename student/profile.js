 
    function loadPage(page) {
      fetch(page)
        .then(response => {
          if (!response.ok) throw new Error("Page not found");
          return response.text();
        })
        .then(data => {
          document.getElementById("content-area").innerHTML = data;
        })
        .catch(error => {
          document.getElementById("content-area").innerHTML =
            "<p style='color:red;'>Error: Page not found.</p>";
          console.error(error);
        });
    }

    function logout() {
      alert("You have been logged out!");
      window.location.href = "home.html"; // change to your login page
    }
  