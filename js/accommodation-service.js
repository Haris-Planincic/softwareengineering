document.addEventListener("DOMContentLoaded", function () {
  loadAccommodations();
});

function loadAccommodations() {
  fetch("http://localhost/seproject/backend/accommodations")
    .then(response => response.json())
    .then(data => {
      const cardContainer = document.querySelector(".col-lg-9 .row");
      cardContainer.innerHTML = "";

      data.forEach(acc => {
        const card = document.createElement("div");
        card.classList.add("col-md-12");

        card.innerHTML = `
          <div class="card mb-4">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="${acc.imageUrls || 'images/default.jpg'}" class="img-fluid rounded-start" alt="${acc.name}">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">${acc.name}</h5>
                  <p class="card-text">${acc.description || "No description available."}</p>
                  <p class="card-text"><strong>Location:</strong> ${acc.location}</p>
                  <p class="card-text"><strong>Price per night:</strong> €${acc.pricePerNight}</p>
                  <p class="card-text"><strong>Category:</strong> ${acc.category}</p>
                  <a href="#" class="btn btn-primary">Details</a>
                  <a href="#" class="btn btn-primary">Book Now</a>
                </div>
              </div>
            </div>
          </div>
        `;

        cardContainer.appendChild(card);
      });
    })
    .catch(error => {
      console.error("Error loading accommodations:", error);
    });
}