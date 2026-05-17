<?php
require 'includes/auth.php';
require 'includes/header.php';
?>

<h1 class="mb-4">
    🛒 Koszyk
</h1>

<div id="cart-container"></div>

<button 
    class="btn btn-success mt-3"
    id="checkout-btn"
>
    Złóż zamówienie
</button>

<script>

function renderCart(){

    const container = document.getElementById('cart-container');

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if(cart.length === 0){

        container.innerHTML = `
            <div class="alert alert-info perm">
                Koszyk jest pusty.
            </div>
        `;

        return;
    }

    let html = `
        <table class="table table-bordered bg-white">

            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Cena</th>
                    <th>Ilosc</th>
                    <th>Usun</th>
                </tr>
            </thead>

            <tbody>
    `;

    cart.forEach((item, index) => {

        html += `
            <tr>

                <td>${item.name}</td>

                <td>${item.price} zl</td>

                <td>${item.quantity}</td>

                <td>
                    <button 
                        class="btn btn-danger btn-sm"
                        onclick="removeItem(${index})"
                    >
                        X
                    </button>
                </td>

            </tr>
        `;

    });

    html += `
            </tbody>
        </table>
    `;

    container.innerHTML = html;
}

function removeItem(index){

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    cart.splice(index, 1);

    localStorage.setItem('cart', JSON.stringify(cart));

    renderCart();
}

renderCart();

document.getElementById('checkout-btn')
.addEventListener('click', () => {

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if(cart.length === 0){
        showToast("Koszyk jest pusty!");
        return;
    }

    fetch('order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cart)
    })
    .then(res => res.text())
    .then(data => {

        localStorage.removeItem('cart');

        const container = document.getElementById('cart-container');
        container.innerHTML = `
            <div class="alert alert-success perm">
                Zamówienie złożone pomyślnie!
            </div>
        `;

    })
    .catch(err => {
        console.error(err);
        showToast("Wystąpił błąd przy składaniu zamówienia.");
    });

});

</script>

<?php
require 'includes/footer.php';
?>