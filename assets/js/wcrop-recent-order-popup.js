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
                console.log(wcrop_recent_orders.wcrop_popup_display_time);
                console.log(wcrop_recent_orders.wcrop_popup_time_to_show);



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

        const scheme = wcrop_recent_orders.wcrop_color_scheme || 'light';
        const popup = document.createElement("div");
        const border = wcrop_recent_orders.wcrop_image_border || 'rounded';
        popup.className = `wcrop-popup wcrop-theme-${scheme} wcrop-border-${border}`;

        if (scheme === 'custom') {
            const bgColor = wcrop_recent_orders.wcrop_popup_bg_color || '#ffffff';
            const textColor = wcrop_recent_orders.wcrop_popup_text_color || '#222222';

            popup.style.setProperty('--wcrop-bg', bgColor);
            popup.style.setProperty('--wcrop-text', textColor);
            popup.style.setProperty('--wcrop-sub-text', textColor);
            popup.style.setProperty('--wcrop-hover-bg', `color-mix(in srgb, ${textColor} 8%, transparent)`);
            popup.style.setProperty('--wcrop-border', `color-mix(in srgb, ${textColor} 15%, transparent)`);
            popup.style.setProperty('--wcrop-text-muted', `color-mix(in srgb, ${textColor} 60%, transparent)`);
            popup.style.setProperty('--wcrop-close-color', `color-mix(in srgb, ${textColor} 50%, transparent)`);
        }

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

        const timeToShow = parseInt(wcrop_recent_orders.wcrop_popup_time_to_show, 10) || 500;
        const displayTime = parseInt(wcrop_recent_orders.wcrop_popup_display_time, 10) || 100;

        setTimeout(() => {
            popup.classList.add("show");


            setTimeout(() => {
                popup.classList.remove("show");
                setTimeout(() => popup.remove(), 300);
            }, displayTime);
        }, timeToShow);


    }
    const fetchInterval = parseInt(wcrop_recent_orders.interval, 10) || 10000;
    setInterval(fetchRecentOrders, fetchInterval);

});