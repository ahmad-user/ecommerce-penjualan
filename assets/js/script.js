console.log("ecommerce running");

// script.js

// contoh alert fade out
window.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000); // hilang setelah 3 detik
    });
});


document.addEventListener("DOMContentLoaded", function() {
    const qtyInputs = document.querySelectorAll("input[name^='qty']");

    qtyInputs.forEach(input => {
        input.addEventListener("input", function() {
            const id = this.name.match(/\d+/)[0];
            const price = parseInt(this.dataset.price);
            const subtotalCell = document.querySelector(`#subtotal-${id}`);
            const totalCell = document.querySelector("#total-order");

            const qty = parseInt(this.value) || 0;
            const subtotal = price * qty;
            subtotalCell.innerText = "Rp " + subtotal.toLocaleString('id-ID');

            let total = 0;
            qtyInputs.forEach(q => {
                const p = parseInt(q.dataset.price);
                const qVal = parseInt(q.value) || 0;
                total += p * qVal;
            });
            totalCell.innerText = "Rp " + total.toLocaleString('id-ID');
        });
    });
});

