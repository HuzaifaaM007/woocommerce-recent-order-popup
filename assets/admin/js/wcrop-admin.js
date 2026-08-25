document.addEventListener('DOMContentLoaded', function () {

    const colorScheme = document.getElementById('wcrop_color_scheme');
    const bgColorInput = document.getElementById("wcrop_popup_bg_color");
    const textColorInput = document.getElementById("wcrop_popup_text_color");

    if (!colorScheme || !bgColorInput || !textColorInput) return;


    function toggleColorFields() {

        const isCustom = colorScheme.value === 'custom';
        bgColorInput.disabled = !isCustom;
        textColorInput.disabled = !isCustom;

        const bgRow = bgColorInput.closest('tr');
        const textRow = textColorInput.closest('tr');

        if (bgRow) bgRow.style.opacity = isCustom ? '1' : '0.5';
        if (textRow) textRow.style.opacity = isCustom ? '1' : '0.5';
    }

    toggleColorFields();

    colorScheme.addEventListener('change', toggleColorFields);
})