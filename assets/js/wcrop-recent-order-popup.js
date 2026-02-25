document.addEventListener("DOMContentLoaded", function () {

    let lastOrderId = 0;

    function fetchRecentOrders() {

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

                if (!data.success) return;

                const orders = data.data.new_orders;

                if (orders.length === 0) return;

                lastOrderId = data.data.last_order_id;

                orders.forEach((order, index) => {
                    setTimeout(() => {
                        showPopup(order);
                    }, index * 6000);
                });

                setTimeout(() => {
                    lastOrderId = 0;
                }, orders.length * 6000);

            })
            .catch(error => console.error("AJAX Error:", error));
    }

    function showPopup(order) {

        const popup = document.createElement("div");
        popup.className = "wcrop-popup";

        let itemsHtml = "";
        order.order_items.forEach(item => {
            itemsHtml += `<li>${item.quantity} × ${item.name}</li>`;
        });

        popup.innerHTML = `
            <strong>${order.customer}</strong> just placed an order!
            <ul>${itemsHtml}</ul>
            <small>${order.order_date}</small>
        `;

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