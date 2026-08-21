document.addEventListener("DOMContentLoaded", function () {

    let lastOrderId = 0;
    let popupsDisabled = false;

    function fetchRecentOrders() {
        if (popupsDisabled) return;

        fetch(wcrop_recent_orders.ajax_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({
                action: "wcrop_check_new_orders",
                nonce: wcrop_recent_orders.nonce,
                last_order_id: lastOrderId
            })
        })
            .then(response => response.json())
            .then(data => {


                console.log(data);

                if (!data.success) return;

                const orders = data.data.new_orders;

                if (orders.length === 0) return;

                lastOrderId = data.data.last_order_id;

                orders.forEach((order, index) => {
                    setTimeout(() => {
                        if (!popupsDisabled) showPopup(order);
                    }, index * 6000);
                });

                setTimeout(() => {
                    lastOrderId = 0;
                }, orders.length * 6000);

            })
            .catch(error =>
                console.error("AJAX Error:", error));
    }

    function disableAllPopups() {
        popupsDisabled = true;
        document.querySelectorAll(".wcrop-popup").forEach(p => p.remove());
    }

    function showPopup(order) {

        const popup = document.createElement("div");
        popup.className = "wcrop-popup";

        let itemsHtml = "";
        order.order_items.forEach(item => {
            itemsHtml += `<li class="wcrop-item">
            <img src="${item.image_url}" alt="${item.name}" class="wcrop-product-img" />
            <span class="wcrop-item-text">${item.quantity} × ${item.name}</span>
            <li>`;
        });

        popup.innerHTML = `
            <button class="wcrop-popup-close" aria-label="Dismiss and disable alerts">&times;</button>
            <div class="wcrop-popup-header"><strong>${order.customer}</strong> just placed an order!</div>

            <ul class="wcrop-popup-items">${itemsHtml}</ul>
            <small>${order.order_date}</small>
        `;

        popup.querySelector(".wcrop-popup-close").addEventListener("click", () => {
            disableAllPopups();
        });

        document.body.appendChild(popup);

        setTimeout(() => {
            popup.classList.add("show");
        }, 100);

        setTimeout(() => {
            popup.classList.remove("show");
            setTimeout(() => popup.remove(), 500);
        }, 5000);
    }

    setInterval(fetchRecentOrders, wcrop_recent_orders.interval);
});