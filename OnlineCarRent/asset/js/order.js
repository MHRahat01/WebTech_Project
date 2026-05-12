// asset/js/order.js
// Handles AJAX total calculation and order placement

(function () {
    function qs(sel) { return document.querySelector(sel); }
    function qsa(sel) { return document.querySelectorAll(sel); }

    const form = qs('#order-form');
    if (!form) return;

    const carIdEl = qs('#car_id');
    const startEl = qs('#start_date');
    const endEl = qs('#end_date');
    const totalSpan = qs('#total_cost');
    const errorsDiv = qs('#order_errors');

    function setError(msg) {
        errorsDiv.textContent = msg || '';
    }

    function validateClient(start, end) {
        if (!start || !end) return 'Start date and end date are required.';
        const s = new Date(start);
        const e = new Date(end);
        const today = new Date();
        today.setHours(0,0,0,0);
        if (isNaN(s.getTime()) || isNaN(e.getTime())) return 'Invalid date format.';
        if (s < today) return 'Start date cannot be in the past.';
        if (e <= s) return 'End date must be after start date.';
        return '';
    }

    async function calculateTotal() {
        setError('');
        const car_id = parseInt(carIdEl.value, 10);
        const start_date = startEl.value;
        const end_date = endEl.value;

        const clientErr = validateClient(start_date, end_date);
        if (clientErr) {
            totalSpan.textContent = '0.00';
            setError(clientErr);
            return;
        }

        try {
            const res = await fetch('?action=calculate_total', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ car_id, start_date, end_date })
            });
            const data = await res.json();
            if (data.success) {
                totalSpan.textContent = parseFloat(data.total).toFixed(2);
            } else {
                totalSpan.textContent = '0.00';
                setError(data.error || 'Failed to calculate total.');
            }
        } catch (err) {
            totalSpan.textContent = '0.00';
            setError('Network error calculating total.');
        }
    }

    startEl.addEventListener('change', calculateTotal);
    endEl.addEventListener('change', calculateTotal);

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        setError('');

        const car_id = parseInt(carIdEl.value, 10);
        const start_date = startEl.value;
        const end_date = endEl.value;

        const clientErr = validateClient(start_date, end_date);
        if (clientErr) {
            setError(clientErr);
            return;
        }

        try {
            const res = await fetch('?action=place_order', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ car_id, start_date, end_date })
            });
            const data = await res.json();
            if (data.success) {
                // Redirect to invoice page with order id
                window.location.href = '?action=invoice&order_id=' + encodeURIComponent(data.order_id);
            } else {
                setError(data.error || 'Failed to place order.');
            }
        } catch (err) {
            setError('Network error placing order.');
        }
    });
})();
